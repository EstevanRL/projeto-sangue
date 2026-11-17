<section class="card">
    <h1>Explorar combinações</h1>
    <p class="muted">Aqui você pode escolher livremente dois tipos sanguíneos, mesmo que nenhum deles seja o seu tipo cadastrado.</p>
    <form data-ajax-form data-api="/compatibilidade-sanguinea/api/consultations/explore.php" data-form-kind="result" data-result-target="#exploreResult">
        <div class="grid">
            <div><label for="tipo1">Primeiro tipo sanguíneo</label><select id="tipo1" name="tipo1" required><option value="">Selecione</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select></div>
            <div><label for="tipo2">Segundo tipo sanguíneo</label><select id="tipo2" name="tipo2" required><option value="">Selecione</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select></div>
        </div>
        <div><label for="gestante">Quem está gestante?</label><select id="gestante" name="gestante" required><option value="tipo1">Primeiro tipo</option><option value="tipo2">Segundo tipo</option></select></div>
        <div class="form-message" data-form-message role="status" aria-live="polite"></div>
        <div class="form-actions"><button type="submit">Explorar combinação</button><a class="button secondary" href="/compatibilidade-sanguinea/consulta.php">Voltar para minha consulta</a></div>
    </form>
</section>
<section id="exploreResult" aria-live="polite"></section>
