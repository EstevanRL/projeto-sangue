<section class="quiz-hero">
    <div class="quiz-hero-copy">
        <p class="quiz-eyebrow">MISSÃO EDUCATIVA</p>
        <h1>Desafio da herança sanguínea</h1>
        <p>Aprenda genética usando os tipos sanguíneos como exemplo. Responda, receba explicações e acumule pontos enquanto avança pelos níveis.</p>
        <div class="quiz-hero-tags">
            <span>24 perguntas</span>
            <span>4 níveis</span>
            <span>Sem cronômetro</span>
            <span>Sem cadastro</span>
        </div>
    </div>
    <div class="quiz-hero-symbol" aria-hidden="true">🧬</div>
</section>

<section class="card quiz-intro" id="quizIntro">
    <h2>Como funciona?</h2>
    <div class="quiz-rules-grid">
        <div class="quiz-rule"><span class="quiz-rule-icon" aria-hidden="true">🎯</span><div><strong>Escolha uma resposta</strong><p>São quatro alternativas por pergunta. Pense com calma antes de confirmar.</p></div></div>
        <div class="quiz-rule"><span class="quiz-rule-icon" aria-hidden="true">💡</span><div><strong>Aprenda com o feedback</strong><p>Depois de responder, você verá a explicação científica e poderá conferir uma dica.</p></div></div>
        <div class="quiz-rule"><span class="quiz-rule-icon" aria-hidden="true">⭐</span><div><strong>Ganhe XP e conquistas</strong><p>As perguntas vão ficando mais difíceis. Sequências de acertos rendem pontos extras.</p></div></div>
    </div>
    <div class="quiz-mission-note"><strong>Objetivo da missão:</strong> entender alelos, genótipos, fenótipos, dominância, codominância e cruzamentos genéticos usando o sistema ABO e uma versão simplificada do RhD. O modelo é educativo e não deve ser usado para decisões médicas.</div>
    <button type="button" class="button quiz-start-button" id="startQuiz">Começar a missão <span aria-hidden="true">→</span></button>
</section>

<section class="card quiz-game" id="quizGame" hidden aria-live="polite">
    <div class="quiz-game-top">
        <div>
            <span class="quiz-level-label" id="levelLabel">NÍVEL 1</span>
            <h2 id="levelTitle">Fundamentos da genética</h2>
        </div>
        <div class="quiz-stats" aria-label="Pontuação atual">
            <div class="quiz-stat"><span>XP</span><strong id="xpValue">0</strong></div>
            <div class="quiz-stat"><span>Sequência</span><strong id="streakValue">0 🔥</strong></div>
        </div>
    </div>

    <div class="quiz-progress-meta"><span id="questionCounter">Pergunta 1 de 24</span><span id="progressPercent">8%</span></div>
    <div class="quiz-progress-track" role="progressbar" aria-label="Progresso do quiz" aria-valuemin="0" aria-valuemax="24" aria-valuenow="1" id="progressTrack"><span id="progressBar"></span></div>

    <div class="quiz-question-area">
        <p class="quiz-topic" id="topicLabel">CONCEITOS BÁSICOS</p>
        <h3 id="questionText" tabindex="-1">Pergunta</h3>
        <div class="quiz-options" id="answerOptions" role="group" aria-label="Alternativas de resposta"></div>
        <details class="quiz-hint" id="hintDetails">
            <summary>Precisa de uma dica?</summary>
            <p id="hintText"></p>
        </details>
        <div class="quiz-feedback" id="quizFeedback" hidden role="status" aria-live="polite">
            <h4 id="feedbackTitle"></h4>
            <p id="feedbackText"></p>
            <span class="quiz-xp-earned" id="xpEarned"></span>
        </div>
        <div class="quiz-actions">
            <button type="button" class="button" id="checkAnswer" disabled>Confirmar resposta</button>
            <button type="button" class="button" id="nextQuestion" hidden>Próxima pergunta →</button>
        </div>
    </div>
</section>

<section class="card quiz-results" id="quizResults" hidden aria-live="polite">
    <div class="quiz-finish-icon" id="finishIcon" aria-hidden="true">🏆</div>
    <p class="quiz-eyebrow">MISSÃO CONCLUÍDA</p>
    <h2 id="resultTitle">Você concluiu o desafio!</h2>
    <p class="muted" id="resultMessage"></p>
    <div class="quiz-result-stats">
        <div><span>Acertos</span><strong id="finalCorrect">0/12</strong></div>
        <div><span>Desempenho</span><strong id="finalPercent">0%</strong></div>
        <div><span>XP conquistado</span><strong id="finalXp">0</strong></div>
    </div>
    <div class="quiz-badge" id="finalBadge"><span aria-hidden="true">🧬</span><div><strong>Aprendiz da Herança</strong><p>Sua próxima conquista começa com a curiosidade.</p></div></div>
    <h3 class="quiz-review-heading">Revisão das respostas</h3>
    <p class="muted">Confira o que acertou e reveja as explicações das perguntas que precisam de mais atenção.</p>
    <div class="quiz-review-list" id="reviewList"></div>
    <div class="quiz-actions quiz-result-actions">
        <button type="button" class="button" id="restartQuiz">Jogar novamente ↻</button>
    </div>
</section>


<script src="/compatibilidade-sanguinea/assets/js/quiz.js" defer></script>
