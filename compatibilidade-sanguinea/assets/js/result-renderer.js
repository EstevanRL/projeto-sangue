class ResultRenderer {
    static escape(value) {
        return String(value ?? '').replace(/[&<>"']/g, (character) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        })[character]);
    }

    static percent(value) {
        const number = Number(value);
        if (Number.isInteger(number)) return `${number}%`;
        return `${number.toFixed(2).replace('.', ',').replace(/0+$/, '').replace(/,$/, '')}%`;
    }

    static tags(items) {
        if (!Array.isArray(items) || items.length === 0) return '<span class="muted">Nenhum tipo listado.</span>';
        return `<div class="tags">${items.map((item) => `<span class="tag">${this.escape(item)}</span>`).join('')}</div>`;
    }

    static render(target, result) {
        if (!target || !result) return;
        const e = (value) => this.escape(value);
        const donationClass1 = result.doa1 ? 'good' : 'bad';
        const donationClass2 = result.doa2 ? 'good' : 'bad';
        const donationText1 = result.doa1 ? 'Pode doar hemácias para o outro tipo.' : 'Não pode doar hemácias para o outro tipo.';
        const donationText2 = result.doa2 ? 'Pode doar hemácias para o primeiro tipo.' : 'Não pode doar hemácias para o primeiro tipo.';
        const childRows = Object.entries(result.filhos || {}).map(([type, probability]) => `<tr><td><strong>${e(type)}</strong></td><td>${this.percent(probability)}</td></tr>`).join('');
        const scenarios = (result.genetica?.detalhes || []).map((detail, index) => `
            <div class="calculation-step">
                <h4>Cenário ${index + 1} — peso ${this.percent(detail.peso)}</h4>
                <p>ABO: <strong>${e(detail.genotipo1.abo)} × ${e(detail.genotipo2.abo)}</strong> | RhD: <strong>${e(detail.genotipo1.rh)} × ${e(detail.genotipo2.rh)}</strong></p>
                <p>ABO: ${e(this.distribution(detail.abo))}</p>
                <p>RhD: ${e(this.distribution(detail.rh))}</p>
                <p><strong>Resultado combinado:</strong> ${e(this.distribution(detail.filhos))}</p>
            </div>`).join('');
        const pregnancy = result.gravidez || {};
        const html = `
        <section class="card result-section">
            <h2>1. Compatibilidade entre os dois tipos</h2>
            <p class="muted">Esta parte considera <strong>transfusão de hemácias</strong> e mostra as duas direções possíveis.</p>
            <div class="result-grid">
                <div class="result-box ${donationClass1}"><h3>${e(result.tipo1)} → ${e(result.tipo2)}</h3><p>${donationText1}</p></div>
                <div class="result-box ${donationClass2}"><h3>${e(result.tipo2)} → ${e(result.tipo1)}</h3><p>${donationText2}</p></div>
            </div>
            <details class="explanation"><summary>Como funciona a compatibilidade?</summary><div class="explanation-body">
                <p>A compatibilidade de hemácias depende principalmente dos antígenos presentes nas hemácias do doador e dos anticorpos do receptor. O sistema compara os sistemas ABO e RhD para determinar se as hemácias de um tipo são compatíveis com o outro.</p>
                <p><strong>Exemplo:</strong> o tipo O+ pode doar hemácias para A+, B+ e AB+, mas não para os mesmos tipos negativos, porque as hemácias O+ possuem o antígeno RhD.</p>
                <p>Esta tabela é específica para <strong>hemácias</strong>. A compatibilidade de plasma segue regras diferentes.</p>
            </div></details>
        </section>
        <section class="card result-section">
            <h2>2. Doação e recebimento</h2>
            <div class="grid">
                <div class="result-box"><h3>${e(result.tipo1)}</h3><p><strong>Pode doar para:</strong></p>${this.tags(result.doaLista1)}<p class="mt-14"><strong>Pode receber de:</strong></p>${this.tags(result.recebeLista1)}</div>
                <div class="result-box"><h3>${e(result.tipo2)}</h3><p><strong>Pode doar para:</strong></p>${this.tags(result.doaLista2)}<p class="mt-14"><strong>Pode receber de:</strong></p>${this.tags(result.recebeLista2)}</div>
            </div>
            <details class="explanation"><summary>Por que as regras de doação são assim?</summary><div class="explanation-body">
                <p>No sistema ABO, as hemácias podem apresentar antígeno A, B, os dois ou nenhum. O receptor não deve receber hemácias que carreguem um antígeno contra o qual seus anticorpos possam reagir.</p>
                <p>No sistema RhD, o fator positivo indica presença do antígeno D. Por isso, para transfusão de hemácias, as combinações positivas e negativas também precisam ser consideradas.</p>
                <p>Na prática transfusional, a equipe de saúde ainda realiza a tipagem e os testes necessários antes da transfusão.</p>
            </div></details>
        </section>
        <section class="card result-section">
            <h2>3. Possíveis tipos sanguíneos do bebê</h2>
            <p>Considerando <strong>${e(result.tipo1)}</strong> × <strong>${e(result.tipo2)}</strong>, o sistema consolida todos os genótipos compatíveis com os fenótipos informados e apresenta uma única distribuição final.</p>
            <div class="alert info-note"><strong>Como a incerteza genética é tratada:</strong> quando o tipo visível permite mais de um genótipo, cada genótipo compatível é considerado com o mesmo peso dentro do cálculo do projeto. Assim, as possibilidades são combinadas em um único resultado que totaliza 100%.</div>
            <div class="table-wrap"><table><thead><tr><th>Tipo sanguíneo do bebê</th><th>Probabilidade consolidada</th></tr></thead><tbody>${childRows}</tbody></table></div>
            <details class="explanation"><summary>Como o cálculo dos filhos foi feito?</summary><div class="explanation-body">
                <p><strong>1. Genótipos possíveis dos pais</strong></p>
                <p><strong>ABO:</strong> cada pessoa recebe um alelo de cada pai. A e B são codominantes entre si e o O é recessivo em relação a ambos: A = AA ou AO; B = BB ou BO; AB = AB; O = OO.</p>
                <p><strong>O que isso significa:</strong> em AO, o alelo A aparece no fenótipo e o O fica “escondido”. Em AB, A e B aparecem juntos. Em OO, não existe A nem B para produzir esses antígenos.</p>
                <p><strong>RhD:</strong> neste modelo simplificado, D é dominante e d é recessivo. Por isso, DD e Dd são positivos e dd é negativo.</p>
                <p><strong>2. Todos os cruzamentos possíveis são considerados</strong></p>
                <p>O sistema combina os genótipos possíveis do primeiro tipo com os genótipos possíveis do segundo tipo. Cada combinação completa de genótipos recebe o mesmo peso no cálculo consolidado.</p>
                <div class="scenario-summary"><p><strong>${e(result.genetica.totalCenarios)}</strong> combinação(ões) de genótipos foram consideradas.</p><p class="small-note">${e(result.genetica.modelo)}</p></div>
                <p>O resultado final é uma estimativa do modelo do projeto: como o exame do tipo sanguíneo não mostra sempre o genótipo exato, o sistema considera todas as combinações compatíveis com o mesmo peso. Isso facilita a visualização, mas não representa uma frequência genética universal da população.</p>
                ${scenarios}
            </div></details>
        </section>
        <section class="card result-section">
            <h2>4. Gestação e incompatibilidade sanguínea</h2>
            <p class="muted">Gestante: <strong>${e(pregnancy.gestante)}</strong> | Outro progenitor: <strong>${e(pregnancy.outro)}</strong></p>
            <div class="result-box ${e(pregnancy.classe)}"><h3>${e(pregnancy.titulo)}</h3><p class="preline">${e(pregnancy.texto)}</p></div>
            <details class="explanation"><summary>Por que uma gestação pode ter incompatibilidade sanguínea?</summary><div class="explanation-body">
                <p><strong>RhD:</strong> uma situação clássica ocorre quando a gestante é Rh-negativa e existe possibilidade de um feto Rh-positivo. A relevância clínica depende da presença de anticorpos maternos e do histórico de sensibilização, por isso o tipo sanguíneo sozinho não diagnostica a doença.</p>
                <p><strong>ABO:</strong> diferenças entre os grupos também podem ter importância, especialmente quando a gestante é do grupo O e o bebê é A ou B. Esse mecanismo é diferente da incompatibilidade RhD.</p>
                <p><strong>Outros anticorpos:</strong> a gestação não é avaliada somente pelos sistemas ABO e RhD. Anticorpos contra outros antígenos das hemácias também podem ser relevantes. O site não consegue identificar esses anticorpos, porque utiliza apenas os oito tipos sanguíneos principais.</p>
                <p><strong>Por isso:</strong> situações reais de gestação precisam de triagem de anticorpos e acompanhamento no pré-natal.</p>
            </div></details>
            <p class="small-note mt-15">Esta seção é educativa e não substitui avaliação médica, tipagem laboratorial ou acompanhamento pré-natal.</p>
        </section>`;
        target.innerHTML = html;
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    static distribution(values) {
        return Object.entries(values || {}).filter(([, value]) => Number(value) > 0).map(([type, value]) => `${type} ${this.percent(value)}`).join(' | ');
    }
}

window.ResultRenderer = ResultRenderer;
