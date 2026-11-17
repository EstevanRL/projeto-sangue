<section class="card center-card">
    <h1>Entrar</h1>
    <p class="muted">Acesse sua conta para consultar combinações e acompanhar seu histórico.</p>
    <form data-ajax-form data-api="/compatibilidade-sanguinea/api/auth/login.php" data-form-kind="redirect" autocomplete="on">
        <div><label for="email">E-mail</label><input id="email" name="email" type="email" maxlength="150" autocomplete="username" required></div>
        <div><label for="senha">Senha</label><input id="senha" name="senha" type="password" maxlength="256" autocomplete="current-password" required></div>
        <div class="form-message" data-form-message role="status" aria-live="polite"></div>
        <button type="submit">Entrar</button>
    </form>
    <p class="muted">Ainda não tem cadastro? <a href="/compatibilidade-sanguinea/auth/cadastro.php">Criar cadastro</a></p>
</section>
