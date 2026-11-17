<section class="card center-card">
    <h1>Criar cadastro</h1>
    <p class="muted">O tipo sanguíneo informado será usado como o seu tipo nas consultas.</p>
    <form data-ajax-form data-api="/compatibilidade-sanguinea/api/auth/register.php" data-form-kind="redirect" autocomplete="on">
        <div><label for="nome">Nome</label><input id="nome" name="nome" type="text" maxlength="100" autocomplete="name" required></div>
        <div><label for="email">E-mail</label><input id="email" name="email" type="email" maxlength="150" autocomplete="email" required></div>
        <div><label for="senha">Senha</label><input id="senha" name="senha" type="password" minlength="8" maxlength="256" autocomplete="new-password" required></div>
        <div><label for="tipo_sanguineo">Seu tipo sanguíneo</label><select id="tipo_sanguineo" name="tipo_sanguineo" required>
            <option value="">Selecione</option>
            <option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
        </select></div>
        <div class="form-message" data-form-message role="status" aria-live="polite"></div>
        <button type="submit">Cadastrar</button>
    </form>
</section>
