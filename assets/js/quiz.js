class GeneticsQuizController {
    constructor() {


        this.questions = [

        {
            level: 1, topic: 'ALELOS',
            question: 'O que é um alelo?',
            options: ['Uma versão de um gene.', 'Uma célula do sangue.', 'Uma característica que sempre aparece.', 'Um tipo de anticorpo.'], answer: 0,
            hint: 'Pense em versões diferentes de uma mesma informação genética.',
            explanation: 'Alelo é uma das versões possíveis de um gene. No modelo ABO, A, B e O são os alelos considerados.'
        },
        {
            level: 1, topic: 'GENÓTIPO',
            question: 'O que significa genótipo?',
            options: ['A característica observável.', 'A combinação de alelos que uma pessoa possui para uma característica.', 'O nome de um tipo sanguíneo.', 'A quantidade de hemácias.'], answer: 1,
            hint: 'É a combinação genética, não o resultado observado diretamente.',
            explanation: 'Genótipo é a combinação de alelos. Por exemplo, AA e AO são genótipos diferentes que, no modelo ABO, produzem o mesmo fenótipo A.'
        },
        {
            level: 1, topic: 'FENÓTIPO',
            question: 'No estudo dos tipos sanguíneos, qual alternativa é um exemplo de fenótipo?',
            options: ['AO.', 'Uma cópia herdada do gene.', 'Tipo sanguíneo A observado em um exame.', 'A probabilidade de 25%.'], answer: 2,
            hint: 'Fenótipo é a característica que se manifesta e pode ser observada ou identificada.',
            explanation: 'Tipo sanguíneo A é um fenótipo. O genótipo que está por trás dele pode ser AA ou AO no modelo ABO simplificado.'
        },
        {
            level: 1, topic: 'HERANÇA',
            question: 'No modelo usado neste quiz, de onde vêm os dois alelos de uma pessoa para o gene ABO?',
            options: ['Os dois vêm da mãe.', 'Os dois vêm do pai.', 'Um é herdado de cada genitor biológico.', 'Eles são definidos pela alimentação.'], answer: 2,
            hint: 'Cada genitor transmite uma cópia do gene.',
            explanation: 'A pessoa recebe um alelo de cada genitor biológico. A combinação dos alelos contribui para determinar o fenótipo ABO.'
        },
        {
            level: 1, topic: 'FENÓTIPO A',
            question: 'Quais genótipos podem produzir o tipo sanguíneo A no modelo ABO?',
            options: ['AA ou AO.', 'BB ou BO.', 'AB ou OO.', 'Somente AB.'], answer: 0,
            hint: 'O alelo A se manifesta mesmo quando está junto do alelo O.',
            explanation: 'AA e AO produzem o fenótipo A. Nesse modelo, A é dominante em relação a O.'
        },
        {
            level: 1, topic: 'FENÓTIPO O',
            question: 'Qual genótipo corresponde ao tipo sanguíneo O no modelo ABO simplificado?',
            options: ['AB.', 'AO.', 'BO.', 'OO.'], answer: 3,
            hint: 'O alelo O precisa ser herdado dos dois genitores.',
            explanation: 'O fenótipo O corresponde ao genótipo OO nesse modelo, pois o alelo O é recessivo em relação a A e B.'
        },


        {
            level: 2, topic: 'DOMINÂNCIA',
            question: 'Uma pessoa tem genótipo AO. Por que o tipo sanguíneo observado é A, e não O?',
            options: ['Porque A é dominante em relação a O no modelo ABO.', 'Porque O desaparece do DNA.', 'Porque a pessoa não herdou O.', 'Porque todos os genótipos são dominantes.'], answer: 0,
            hint: 'Um alelo pode determinar o fenótipo mesmo quando está acompanhado de outro alelo.',
            explanation: 'O alelo A se manifesta no fenótipo quando está junto do alelo O. O alelo O continua presente no genótipo e pode ser transmitido aos filhos.'
        },
        {
            level: 2, topic: 'CODOMINÂNCIA',
            question: 'Por que uma pessoa com genótipo AB apresenta o fenótipo AB?',
            options: ['A elimina B.', 'O domina os dois.', 'A e B são codominantes e ambos se manifestam.', 'O tipo AB aparece somente por mutação.'], answer: 2,
            hint: 'Nesse caso, nenhum dos dois alelos esconde o outro.',
            explanation: 'A e B são codominantes entre si: os dois se manifestam, resultando no fenótipo AB.'
        },
        {
            level: 2, topic: 'INTERPRETAÇÃO DO GENÓTIPO',
            question: 'Qual é o fenótipo ABO de uma pessoa com genótipo BO?',
            options: ['A.', 'B.', 'AB.', 'O.'], answer: 1,
            hint: 'Compare a dominância de B com a de O.',
            explanation: 'O alelo B é dominante em relação a O no modelo ABO. Assim, BO produz o fenótipo B.'
        },
        {
            level: 2, topic: 'GENÓTIPO AB',
            question: 'Qual combinação de alelos uma pessoa com fenótipo AB transmite em um único óvulo ou espermatozoide, considerando o gene ABO?',
            options: ['Sempre A e B juntos.', 'Somente O.', 'Pode transmitir A ou B.', 'Pode transmitir O mesmo tendo genótipo AB.'], answer: 2,
            hint: 'Cada gameta recebe apenas um dos dois alelos desse gene.',
            explanation: 'Uma pessoa AB pode transmitir o alelo A ou o alelo B. No modelo ABO padrão apresentado aqui, ela não possui alelo O para transmitir.'
        },
        {
            level: 2, topic: 'TRANSMISSÃO DOS ALELOS',
            question: 'Em um modelo simples, qual alelo uma pessoa com genótipo OO pode transmitir para um filho?',
            options: ['Sempre A.', 'Sempre B.', 'A ou B.', 'Sempre O.'], answer: 3,
            hint: 'Os dois alelos dessa pessoa são iguais.',
            explanation: 'Como o genótipo é OO, a pessoa só pode transmitir O para esse gene ABO.'
        },
        {
            level: 2, topic: 'PROBABILIDADE DE TRANSMISSÃO',
            question: 'Se uma pessoa AO transmitir um de seus alelos ao acaso, qual é a probabilidade de transmitir O?',
            options: ['0%.', '25%.', '50%.', '100%.'], answer: 2,
            hint: 'Há dois alelos possíveis e, neste modelo, cada um tem a mesma chance de ser transmitido.',
            explanation: 'A pessoa AO pode transmitir A ou O. Considerando chances iguais, a probabilidade de transmitir O é 1/2, ou 50%.'
        },


        {
            level: 3, topic: 'CRUZAMENTO AO × OO',
            question: 'Uma pessoa AO tem filhos com uma pessoa OO. Quais fenótipos ABO são esperados e em quais proporções?',
            options: ['100% A.', '50% A e 50% O.', '50% AB e 50% O.', '25% A, 25% B, 25% AB e 25% O.'], answer: 1,
            hint: 'A primeira pessoa pode transmitir A ou O; a segunda só transmite O.',
            explanation: 'As combinações possíveis são AO e OO, com 50% para cada uma. Os fenótipos esperados são 50% A e 50% O.'
        },
        {
            level: 3, topic: 'CRUZAMENTO AB × OO',
            question: 'Uma pessoa AB tem filhos com uma pessoa OO. Quais fenótipos ABO podem aparecer?',
            options: ['50% A e 50% B.', '100% AB.', '50% AB e 50% O.', '100% O.'], answer: 0,
            hint: 'A pessoa AB pode transmitir A ou B; a pessoa OO só transmite O.',
            explanation: 'As combinações são AO e BO. Por isso, os fenótipos esperados são A e B, cada um com 50% neste cruzamento.'
        },
        {
            level: 3, topic: 'CRUZAMENTO AO × BO',
            question: 'Uma pessoa AO tem filhos com uma pessoa BO. Considerando transmissão equiprovável dos alelos, qual distribuição ABO é esperada?',
            options: ['50% A e 50% B.', '100% AB.', '25% A, 25% B, 25% AB e 25% O.', '75% A e 25% O.'], answer: 2,
            hint: 'Combine A ou O do primeiro genitor com B ou O do segundo: há quatro combinações equiprováveis.',
            explanation: 'As combinações são AB, AO, BO e OO. Cada uma corresponde a um fenótipo diferente e tem 25% neste cruzamento específico.'
        },
        {
            level: 3, topic: 'CRUZAMENTO AO × AO',
            question: 'Duas pessoas AO têm um filho. Qual distribuição de fenótipos ABO é esperada?',
            options: ['50% A e 50% O.', '75% A e 25% O.', '25% A, 25% B, 25% AB e 25% O.', '100% A.'], answer: 1,
            hint: 'As quatro combinações são AA, AO, AO e OO. Agrupe as que têm o mesmo fenótipo.',
            explanation: 'AA representa 25%, AO representa 50% e OO representa 25%. Como AA e AO são fenótipos A, o total esperado é 75% A e 25% O.'
        },
        {
            level: 3, topic: 'CRUZAMENTO BO × BO',
            question: 'Duas pessoas BO têm um filho. Qual distribuição de fenótipos ABO é esperada?',
            options: ['75% B e 25% O.', '75% O e 25% B.', '50% A e 50% B.', '100% AB.'], answer: 0,
            hint: 'O cruzamento BO × BO é análogo a AO × AO, mas com o alelo B.',
            explanation: 'As combinações esperadas são BB, BO, BO e OO. BB e BO resultam no fenótipo B, totalizando 75%; OO resulta em O, com 25%.'
        },
        {
            level: 3, topic: 'PROBABILIDADE DE UM GENÓTIPO',
            question: 'Se ambos os genitores são AO, qual é a probabilidade de um filho ter genótipo OO em uma gestação?',
            options: ['0%.', '25%.', '50%.', '75%.'], answer: 1,
            hint: 'O filho precisa receber O de ambos. Cada genitor AO transmite O com chance de 50%.',
            explanation: 'A chance é 1/2 × 1/2 = 1/4, ou 25%. Cada gestação é um evento independente; o resultado de uma não determina o da seguinte.'
        },


        {
            level: 4, topic: 'CRUZAMENTO AB × AB',
            question: 'Duas pessoas AB têm filhos. Qual distribuição de fenótipos ABO é esperada no modelo padrão?',
            options: ['25% A, 50% AB e 25% B; não se espera O.', '25% A, 25% B, 25% AB e 25% O.', '50% A e 50% O.', '100% AB.'], answer: 0,
            hint: 'Cada genitor transmite A ou B. Monte as combinações AA, AB, AB e BB.',
            explanation: 'As combinações são AA (25%), AB (50%) e BB (25%). Portanto, os fenótipos esperados são A (25%), AB (50%) e B (25%); não há combinação OO nesse cruzamento.'
        },
        {
            level: 4, topic: 'INFERÊNCIA A PARTIR DE UM FILHO',
            question: 'Um casal tem fenótipos A e B e teve um filho O. O que isso indica no modelo ABO padrão?',
            options: ['Os genitores precisam ser AA e BB.', 'O filho O não pode ser biologicamente filho desse casal.', 'É possível se os genótipos dos genitores forem AO e BO.', 'Um dos genitores precisa ser AB.'], answer: 2,
            hint: 'Para ter genótipo OO, o filho precisa receber um O de cada genitor.',
            explanation: 'A pessoa de fenótipo A pode ser AO e a de fenótipo B pode ser BO. Se ambos transmitirem O, o filho terá OO. Os fenótipos, sozinhos, não revelam com certeza os genótipos parentais.'
        },
        {
            level: 4, topic: 'LIMITES DO FENÓTIPO',
            question: 'Uma pessoa tem tipo sanguíneo A. O que podemos concluir apenas com esse fenótipo, no modelo ABO?',
            options: ['O genótipo é obrigatoriamente AA.', 'O genótipo é obrigatoriamente AO.', 'O genótipo pode ser AA ou AO; o fenótipo sozinho não distingue os dois.', 'A pessoa transmite sempre A e nunca O.'], answer: 2,
            hint: 'Lembre que dois genótipos diferentes podem produzir o mesmo fenótipo.',
            explanation: 'O fenótipo A pode corresponder a AA ou AO. Sem informação genética adicional, não é possível distinguir esses genótipos apenas pelo tipo sanguíneo observado.'
        },
        {
            level: 4, topic: 'MODELO SIMPLIFICADO DO RhD',
            question: 'Neste modelo didático, D é dominante sobre d, DD e Dd são RhD positivos e dd é negativo. Em Dd × Dd, qual proporção é esperada?',
            options: ['50% positivos e 50% negativos.', '75% positivos e 25% negativos.', '25% positivos e 75% negativos.', '100% negativos.'], answer: 1,
            hint: 'Os genótipos esperados são DD, Dd, Dd e dd.',
            explanation: 'Três das quatro combinações têm pelo menos um D (DD ou Dd), resultando em 75% RhD positivos; uma é dd, resultando em 25% negativos. É uma simplificação educativa do sistema RhD real.'
        },
        {
            level: 4, topic: 'CRUZAMENTO RhD: Dd × dd',
            question: 'No modelo simplificado do RhD, uma pessoa Dd tem filhos com uma pessoa dd. Qual proporção é esperada?',
            options: ['100% positivos.', '100% negativos.', '50% positivos (Dd) e 50% negativos (dd).', '75% positivos e 25% negativos.'], answer: 2,
            hint: 'A pessoa Dd transmite D ou d; a pessoa dd sempre transmite d.',
            explanation: 'As combinações esperadas são Dd e dd em proporções iguais, portanto 50% positivos e 50% negativos nesse modelo didático.'
        },
        {
            level: 4, topic: 'PROBABILIDADES COMBINADAS',
            question: 'No modelo didático, os genitores têm genótipos ABO AO e BO, e genótipos RhD Dd e dd. Supondo segregação independente entre os dois sistemas, qual é a probabilidade de um filho O+?',
            options: ['12,5%.', '25%.', '37,5%.', '50%.'], answer: 0,
            hint: 'Primeiro calcule a chance de O no cruzamento AO × BO. Depois, a chance de RhD positivo em Dd × dd. Multiplique as probabilidades.',
            explanation: 'No cruzamento AO × BO, a chance de fenótipo O é 25%. No cruzamento Dd × dd, a chance de RhD positivo é 50%. No modelo simplificado com segregação independente, 25% × 50% = 12,5% para O+.'
        }
    ];

        this.levels = {
        1: 'Primeiros passos',
        2: 'Como os alelos se expressam',
        3: 'Cruzamentos e probabilidades',
        4: 'Desafio avançado'
    };

        this.intro = this.el('quizIntro');
        this.game = this.el('quizGame');
        this.results = this.el('quizResults');
        if (!this.intro || !this.game || !this.results) return;

        this.current = 0;
        this.xp = 0;
        this.streak = 0;
        this.correctCount = 0;
        this.answerHistory = [];
        this.selectedAnswer = null;
        this.answered = false;
        this.bindEvents();
    }

    el(id) {
        return document.getElementById(id);
    }

    setHidden(element, hidden) {
        element.hidden = hidden;
    }

    setText(id, value) {
        const target = this.el(id);
        if (target) target.textContent = value;
    }

    renderQuestion() {
        const item = this.questions[this.current];
        this.selectedAnswer = null;
        this.answered = false;

        this.setText('levelLabel', `NÍVEL ${item.level} DE 4`);
        this.setText('levelTitle', this.levels[item.level]);
        this.setText('topicLabel', item.topic);
        this.setText('questionText', item.question);
        this.setText('questionCounter', `Pergunta ${this.current + 1} de ${this.questions.length}`);
        this.setText('progressPercent', `${Math.round(((this.current + 1) / this.questions.length) * 100)}%`);
        this.setText('xpValue', String(this.xp));
        this.setText('streakValue', `${this.streak} 🔥`);
        this.setText('hintText', item.hint);
        this.el('progressBar').style.width = `${((this.current + 1) / this.questions.length) * 100}%`;
        this.el('progressTrack').setAttribute('aria-valuenow', String(this.current + 1));
        this.el('hintDetails').open = false;
        this.setHidden(this.el('quizFeedback'), true);
        this.setHidden(this.el('nextQuestion'), true);
        this.el('checkAnswer').disabled = true;
        this.el('checkAnswer').textContent = 'Confirmar resposta';

        const options = this.el('answerOptions');
        options.replaceChildren();
        item.options.forEach((option, index) => {
            const label = document.createElement('label');
            label.className = 'quiz-option';
            const radio = document.createElement('input');
            radio.type = 'radio';
            radio.name = 'quiz-answer';
            radio.value = String(index);
            radio.autocomplete = 'off';
            const letter = document.createElement('span');
            letter.className = 'quiz-option-letter';
            letter.textContent = String.fromCharCode(65 + index);
            const text = document.createElement('span');
            text.className = 'quiz-option-text';
            text.textContent = option;
            label.append(radio, letter, text);
            radio.addEventListener('change', () => {
                if (this.answered) return;
                this.selectedAnswer = index;
                this.el('checkAnswer').disabled = false;
                options.querySelectorAll('.quiz-option').forEach((node) => node.classList.remove('selected'));
                label.classList.add('selected');
            });
            options.appendChild(label);
        });
    }

    submitAnswer() {
        if (this.answered || this.selectedAnswer === null) return;
        this.answered = true;
        const item = this.questions[this.current];
        const isCorrect = this.selectedAnswer === item.answer;
        let earned = 0;

        if (isCorrect) {
            this.streak += 1;
            this.correctCount += 1;
            earned = 50 + item.level * 50 + (this.streak >= 3 ? 25 : 0);
            this.xp += earned;
        } else {
            this.streak = 0;
        }

        this.answerHistory.push({ selected: this.selectedAnswer, correct: isCorrect, earned });
        this.setText('xpValue', String(this.xp));
        this.setText('streakValue', `${this.streak} 🔥`);

        const optionNodes = this.el('answerOptions').querySelectorAll('.quiz-option');
        optionNodes.forEach((label, index) => {
            const radio = label.querySelector('input');
            radio.disabled = true;
            if (index === item.answer) label.classList.add('correct');
            if (index === this.selectedAnswer && !isCorrect) label.classList.add('incorrect');
        });

        const feedback = this.el('quizFeedback');
        feedback.classList.toggle('is-correct', isCorrect);
        feedback.classList.toggle('is-incorrect', !isCorrect);
        this.setText('feedbackTitle', isCorrect ? 'Resposta certa! ✨' : 'Vamos aprender com essa resposta.');
        this.setText('feedbackText', item.explanation);
        this.setText('xpEarned', isCorrect ? `+${earned} XP ${this.streak >= 3 ? '(inclui bônus de sequência!)' : ''}` : '0 XP desta vez — siga em frente!');
        this.setHidden(feedback, false);
        this.setHidden(this.el('nextQuestion'), false);
        this.el('checkAnswer').disabled = true;
        this.el('checkAnswer').textContent = 'Resposta confirmada';
        this.el('nextQuestion').textContent = this.current === this.questions.length - 1 ? 'Ver resultado final →' : 'Próxima pergunta →';
        this.el('nextQuestion').focus();
    }

    nextQuestion() {
        if (!this.answered) return;
        if (this.current < this.questions.length - 1) {
            this.current += 1;
            this.renderQuestion();
            this.el('questionText').focus?.();
        } else {
            this.showResults();
        }
    }

    badgeFor(score) {
        if (score === this.questions.length) return { icon: '🏆', title: 'Mestre da Herança', desc: 'Você acertou todas! Mostrou domínio dos conceitos trabalhados.' };
        if (score >= Math.ceil(this.questions.length * 0.8)) return { icon: '🧬', title: 'Analista de Genótipos', desc: 'Você já relaciona bem genótipos, fenótipos e cruzamentos.' };
        if (score >= Math.ceil(this.questions.length * 0.6)) return { icon: '🔎', title: 'Explorador Genético', desc: 'Você construiu uma boa base. Revise as explicações para avançar ainda mais.' };
        return { icon: '🌱', title: 'Aprendiz da Herança', desc: 'Todo aprendizado começa com perguntas. Revise os conceitos e tente novamente.' };
    }

    showResults() {
        this.setHidden(this.game, true);
        this.setHidden(this.results, false);
        const percent = Math.round((this.correctCount / this.questions.length) * 100);
        const badge = this.badgeFor(this.correctCount);
        this.setText('finishIcon', badge.icon);
        this.setText('resultTitle', this.correctCount === this.questions.length ? 'Perfeito! Missão completa!' : 'Missão concluída!');
        this.setText('resultMessage', percent >= 75
            ? 'Ótimo trabalho! Você está conseguindo relacionar as informações genéticas aos tipos sanguíneos.'
            : 'Você concluiu a atividade. Leia a revisão abaixo e use os erros como pistas do que vale estudar de novo.');
        this.setText('finalCorrect', `${this.correctCount}/${this.questions.length}`);
        this.setText('finalPercent', `${percent}%`);
        this.setText('finalXp', String(this.xp));
        this.el('finalBadge').replaceChildren();
        const icon = document.createElement('span');
        icon.setAttribute('aria-hidden', 'true');
        icon.textContent = badge.icon;
        const badgeText = document.createElement('div');
        const title = document.createElement('strong');
        title.textContent = badge.title;
        const desc = document.createElement('p');
        desc.textContent = badge.desc;
        badgeText.append(title, desc);
        this.el('finalBadge').append(icon, badgeText);

        const review = this.el('reviewList');
        review.replaceChildren();
        this.questions.forEach((item, index) => {
            const record = this.answerHistory[index];
            const article = document.createElement('article');
            article.className = `quiz-review-item ${record.correct ? 'review-correct' : 'review-incorrect'}`;
            const heading = document.createElement('h4');
            heading.textContent = `${record.correct ? '✓' : '↻'} Pergunta ${index + 1}: ${item.question}`;
            const chosen = document.createElement('p');
            chosen.className = 'quiz-review-answer';
            chosen.textContent = `Sua resposta: ${item.options[record.selected]}`;
            const right = document.createElement('p');
            right.className = 'quiz-review-answer';
            right.textContent = `Resposta correta: ${item.options[item.answer]}`;
            const explanation = document.createElement('p');
            explanation.className = 'quiz-review-explanation';
            explanation.textContent = item.explanation;
            article.append(heading, chosen, right, explanation);
            review.appendChild(article);
        });
        this.results.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    startQuiz() {
        this.current = 0;
        this.xp = 0;
        this.streak = 0;
        this.correctCount = 0;
        this.answerHistory = [];
        this.setHidden(this.intro, true);
        this.setHidden(this.results, true);
        this.setHidden(this.game, false);
        this.renderQuestion();
        this.el('questionText').focus?.();
        this.game.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    bindEvents() {
        this.el('startQuiz').addEventListener('click', () => this.startQuiz());
        this.el('checkAnswer').addEventListener('click', () => this.submitAnswer());
        this.el('nextQuestion').addEventListener('click', () => this.nextQuestion());
        this.el('restartQuiz').addEventListener('click', () => this.startQuiz());
    }
}

document.addEventListener('DOMContentLoaded', () => new GeneticsQuizController());
