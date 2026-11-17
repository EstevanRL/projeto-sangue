<?php
declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;

final class BloodCompatibilityService
{

    public function tiposSanguineos(): array
    {
        return ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
    }

    public function partesTipo(string $tipo): array
    {
        if (!preg_match('/^(AB|A|B|O)([+-])$/', $tipo, $matches)) {
            throw new InvalidArgumentException('Tipo sanguíneo inválido.');
        }

        return [$matches[1], $matches[2]];
    }

    public function podeDoar(string $origem, string $destino): bool
    {
        $doa = [
            'O-'  => ['O-','O+','A-','A+','B-','B+','AB-','AB+'],
            'O+'  => ['O+','A+','B+','AB+'],
            'A-'  => ['A-','A+','AB-','AB+'],
            'A+'  => ['A+','AB+'],
            'B-'  => ['B-','B+','AB-','AB+'],
            'B+'  => ['B+','AB+'],
            'AB-' => ['AB-','AB+'],
            'AB+' => ['AB+']
        ];

        return isset($doa[$origem]) && in_array($destino, $doa[$origem], true);
    }

    public function listaDoacao(string $tipo): array
    {
        $resultado = [];

        foreach ($this->tiposSanguineos() as $destino) {
            if ($this->podeDoar($tipo, $destino)) {
                $resultado[] = $destino;
            }
        }

        return $resultado;
    }

    public function listaRecebimento(string $tipo): array
    {
        $resultado = [];

        foreach ($this->tiposSanguineos() as $origem) {
            if ($this->podeDoar($origem, $tipo)) {
                $resultado[] = $origem;
            }
        }

        return $resultado;
    }

    public function genotiposAbo(string $tipo): array
    {
        [$abo] = $this->partesTipo($tipo);

        return match ($abo) {
            'A'  => ['AA', 'AO'],
            'B'  => ['BB', 'BO'],
            'AB' => ['AB'],
            'O'  => ['OO'],
        };
    }

    public function genotiposRh(string $rh): array
    {
        return match ($rh) {
            '+' => ['DD', 'Dd'],
            '-' => ['dd'],
            default => throw new InvalidArgumentException('Fator Rh inválido.')
        };
    }

    public function genotiposCompletos(string $tipo): array
    {
        [, $rh] = $this->partesTipo($tipo);
        $resultado = [];

        foreach ($this->genotiposAbo($tipo) as $abo) {
            foreach ($this->genotiposRh($rh) as $rhGenotipo) {
                $resultado[] = [
                    'abo' => $abo,
                    'rh' => $rhGenotipo,
                ];
            }
        }

        return $resultado;
    }

    public function fenotipoAbo(string $a, string $b): string
    {
        $alelos = [$a, $b];
        sort($alelos);

        if ($alelos === ['A', 'B']) {
            return 'AB';
        }

        if (in_array('A', $alelos, true) && !in_array('B', $alelos, true)) {
            return 'A';
        }

        if (in_array('B', $alelos, true) && !in_array('A', $alelos, true)) {
            return 'B';
        }

        return 'O';
    }

    public function distribuicaoAboPorGenotipos(string $genotipo1, string $genotipo2): array
    {
        $contagem = ['A' => 0, 'B' => 0, 'AB' => 0, 'O' => 0];

        foreach (str_split($genotipo1) as $a1) {
            foreach (str_split($genotipo2) as $a2) {
                $contagem[$this->fenotipoAbo($a1, $a2)]++;
            }
        }

        return $contagem;
    }

    public function distribuicaoRhPorGenotipos(string $genotipo1, string $genotipo2): array
    {
        $contagem = ['+' => 0, '-' => 0];

        foreach (str_split($genotipo1) as $a1) {
            foreach (str_split($genotipo2) as $a2) {
                $contagem[in_array('D', [$a1, $a2], true) ? '+' : '-']++;
            }
        }

        return $contagem;
    }

    public function percentuaisAbo(string $genotipo1, string $genotipo2): array
    {
        $dist = $this->distribuicaoAboPorGenotipos($genotipo1, $genotipo2);

        return [
            'A' => ($dist['A'] / 4) * 100,
            'B' => ($dist['B'] / 4) * 100,
            'AB' => ($dist['AB'] / 4) * 100,
            'O' => ($dist['O'] / 4) * 100,
        ];
    }

    public function percentuaisRh(string $genotipo1, string $genotipo2): array
    {
        $dist = $this->distribuicaoRhPorGenotipos($genotipo1, $genotipo2);

        return [
            '+' => ($dist['+'] / 4) * 100,
            '-' => ($dist['-'] / 4) * 100,
        ];
    }

    public function combinarDistribuicoes(array $abo, array $rh): array
    {
        $filhos = [];

        foreach ($abo as $tipoAbo => $probAbo) {
            if ($probAbo <= 0) {
                continue;
            }

            foreach ($rh as $fatorRh => $probRh) {
                if ($probRh <= 0) {
                    continue;
                }

                $filhos[$tipoAbo . $fatorRh] = ($probAbo * $probRh) / 100;
            }
        }

        return $filhos;
    }

    public function ordenarTipos(array $tipos): array
    {
        $ordem = ['O-','O+','A-','A+','B-','B+','AB-','AB+'];
        $resultado = [];

        foreach ($ordem as $tipo) {
            if (isset($tipos[$tipo])) {
                $resultado[$tipo] = $tipos[$tipo];
            }
        }

        return $resultado;
    }

    public function calcularFilhos(string $p1, string $p2): array
    {
        $genotipos1 = $this->genotiposCompletos($p1);
        $genotipos2 = $this->genotiposCompletos($p2);
        $totalCenarios = count($genotipos1) * count($genotipos2);

        $consolidado = [];
        $detalhes = [];

        foreach ($genotipos1 as $g1) {
            foreach ($genotipos2 as $g2) {
                $distAbo = $this->percentuaisAbo($g1['abo'], $g2['abo']);
                $distRh = $this->percentuaisRh($g1['rh'], $g2['rh']);
                $filhos = $this->ordenarTipos($this->combinarDistribuicoes($distAbo, $distRh));

                foreach ($filhos as $tipo => $prob) {
                    $consolidado[$tipo] = ($consolidado[$tipo] ?? 0.0) + ($prob / $totalCenarios);
                }

                $detalhes[] = [
                    'genotipo1' => $g1,
                    'genotipo2' => $g2,
                    'abo' => $distAbo,
                    'rh' => $distRh,
                    'filhos' => $filhos,
                    'peso' => 100 / $totalCenarios,
                ];
            }
        }

        arsort($consolidado, SORT_NUMERIC);

        $soma = array_sum($consolidado);
        $diferenca = 100.0 - $soma;
        if ($consolidado && abs($diferenca) > 0.0000001) {
            $ultimoTipo = array_key_last($consolidado);
            $consolidado[$ultimoTipo] += $diferenca;
        }

        return [
            'filhos' => $consolidado,
            'detalhes' => $detalhes,
            'totalCenarios' => $totalCenarios,
            'modelo' => 'Cada combinação de genótipos compatível com os fenótipos informados recebe o mesmo peso no cálculo consolidado.'
        ];
    }

    public function percentual(float $valor): string
    {
        if (abs($valor - round($valor)) < 0.00001) {
            return (int) round($valor) . '%';
        }

        return rtrim(rtrim(number_format($valor, 2, ',', '.'), '0'), ',') . '%';
    }

    public function filhosPossiveis(array $filhos): array
    {
        return array_keys($filhos);
    }

    public function textoDistribuicao(array $dist): string
    {
        $partes = [];

        foreach ($dist as $tipo => $prob) {
            if ($prob > 0) {
                $partes[] = $tipo . ' ' . $this->percentual((float) $prob);
            }
        }

        return implode(' | ', $partes);
    }

    public function textoGravidez(string $gestante, string $outro, array $filhos): array
    {
        [, $rhGestante] = $this->partesTipo($gestante);
        [, $rhOutro] = $this->partesTipo($outro);
        [, $aboGestante] = $this->partesTipo($gestante);

        $possivelRhPositivo = false;
        $possivelRhNegativo = false;
        $possiveisAboDoBebe = [];

        foreach ($filhos as $tipo => $prob) {
            if ($prob <= 0) {
                continue;
            }

            if (str_ends_with($tipo, '+')) {
                $possivelRhPositivo = true;
            } else {
                $possivelRhNegativo = true;
            }

            $aboBebe = rtrim($tipo, '+-');
            $possiveisAboDoBebe[$aboBebe] = true;
        }

        $classe = 'pregnancy-info';
        $titulo = 'Gestação e compatibilidade sanguínea';
        $mensagens = [];

        if ($rhGestante === '-' && $possivelRhPositivo) {
            $classe = 'pregnancy-warning';
            $mensagens[] = 'RhD: a gestante é Rh-negativa e existe possibilidade de um bebê Rh-positivo com os tipos informados. Isso não significa que exista doença. O risco real depende, entre outros fatores, de a gestante ter ou não desenvolvido anticorpos anti-D e do acompanhamento feito no pré-natal.';
        } elseif ($rhGestante === '-' && !$possivelRhPositivo) {
            $mensagens[] = 'RhD: neste cruzamento, não existe possibilidade de um bebê Rh-positivo. Portanto, com base apenas no sistema RhD e nos tipos informados, não há incompatibilidade RhD prevista.';
        } else {
            $mensagens[] = 'RhD: como a gestante é Rh-positiva, a incompatibilidade RhD clássica causada por uma gestante Rh-negativa não se aplica a esta combinação.';
        }

        if ($rhGestante === '-' && $rhOutro === '-' && $possivelRhNegativo) {
            $mensagens[] = 'Como os dois tipos informados são Rh-negativos, o bebê será Rh-negativo nesse sistema.';
        }

        $possivelAbo = false;
        if ($aboGestante === 'O') {
            foreach (['A', 'B', 'AB'] as $abo) {
                if (isset($possiveisAboDoBebe[$abo])) {
                    $possivelAbo = true;
                    break;
                }
            }
        }

        if ($possivelAbo) {
            if ($classe !== 'pregnancy-warning') {
                $classe = 'pregnancy-info';
            }
            $mensagens[] = 'ABO: também pode existir incompatibilidade ABO quando a gestante é do grupo O e o bebê é A, B ou AB. Esse mecanismo é diferente do RhD e, em muitos casos, é menos grave, mas pode contribuir para doença hemolítica do feto ou do recém-nascido.';
        } else {
            $mensagens[] = 'ABO: diferenças entre os grupos também podem ser relevantes na gestação, mas o tipo sanguíneo dos pais não permite prever sozinho se haverá problema. O risco depende da combinação de antígenos, anticorpos e do quadro clínico.';
        }

        $mensagens[] = 'Outros anticorpos: a avaliação da gestação não se limita aos sistemas ABO e RhD. Anticorpos contra outros antígenos das hemácias também podem causar incompatibilidade. Eles podem surgir, por exemplo, após transfusões ou gestações anteriores e são investigados por exames específicos.';
        $mensagens[] = 'Na prática, o pré-natal utiliza a tipagem sanguínea e a pesquisa de anticorpos. O site mostra apenas uma estimativa educativa baseada nos oito tipos ABO/RhD e não consegue diagnosticar incompatibilidade ou doença.';

        return [
            'classe' => $classe,
            'titulo' => $titulo,
            'texto' => implode("\n\n", $mensagens),
            'gestante' => $gestante,
            'outro' => $outro,
        ];
    }

    public function montarResultado(string $tipo1, string $tipo2, string $gestanteTipo): array
    {
        $genetica = $this->calcularFilhos($tipo1, $tipo2);
        $filhos = $genetica['filhos'];

        $outro = $gestanteTipo === $tipo1 ? $tipo2 : $tipo1;

        return [
            'tipo1' => $tipo1,
            'tipo2' => $tipo2,
            'doa1' => $this->podeDoar($tipo1, $tipo2),
            'doa2' => $this->podeDoar($tipo2, $tipo1),
            'doaLista1' => $this->listaDoacao($tipo1),
            'recebeLista1' => $this->listaRecebimento($tipo1),
            'doaLista2' => $this->listaDoacao($tipo2),
            'recebeLista2' => $this->listaRecebimento($tipo2),
            'filhos' => $filhos,
            'genetica' => $genetica,
            'gravidez' => $this->textoGravidez($gestanteTipo, $outro, $filhos),
        ];
    }
}
