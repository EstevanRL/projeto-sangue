<?php
declare(strict_types=1);

namespace App\Services;

use InvalidArgumentException;

final class ConsultationService
{
    private const BLOOD_TYPES = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

    public function __construct(
        private HistoryService $history,
        private BloodCompatibilityService $blood
    ) {
    }

    public function compare(array $user, array $input): array
    {
        $otherType = (string) ($input['tipo_outra'] ?? '');
        $pregnantOption = (string) ($input['gestante'] ?? 'usuario');
        $userType = (string) ($user['tipo_sanguineo'] ?? '');

        if (!in_array($userType, self::BLOOD_TYPES, true)
            || !in_array($otherType, self::BLOOD_TYPES, true)
            || !in_array($pregnantOption, ['usuario', 'outra'], true)) {
            throw new InvalidArgumentException('Confira os tipos sanguíneos e a opção de gestação.');
        }

        $pregnantType = $pregnantOption === 'usuario' ? $userType : $otherType;
        $result = $this->blood->montarResultado($userType, $otherType, $pregnantType);
        $this->history->add((int) $user['id'], $userType, $otherType, $pregnantOption, 'consulta');

        return $result;
    }

    public function explore(array $user, array $input): array
    {
        $type1 = (string) ($input['tipo1'] ?? '');
        $type2 = (string) ($input['tipo2'] ?? '');
        $pregnantOption = (string) ($input['gestante'] ?? 'tipo1');

        if (!in_array($type1, self::BLOOD_TYPES, true)
            || !in_array($type2, self::BLOOD_TYPES, true)
            || !in_array($pregnantOption, ['tipo1', 'tipo2'], true)) {
            throw new InvalidArgumentException('Selecione dois tipos sanguíneos válidos e indique quem está gestante.');
        }

        $pregnantType = $pregnantOption === 'tipo1' ? $type1 : $type2;
        $result = $this->blood->montarResultado($type1, $type2, $pregnantType);
        $this->history->add((int) $user['id'], $type1, $type2, $pregnantOption, 'explorar');

        return $result;
    }
}
