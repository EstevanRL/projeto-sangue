<section class="card">
    <h1>Consulta com seu tipo</h1>
    <p class="muted">Seu tipo sanguíneo cadastrado: <strong id="userBloodType">Carregando...</strong></p>
    <form data-ajax-form data-api="/compatibilidade-sanguinea/api/consultations/compare.php" data-form-kind="result" data-result-target="#consultationResult">
        <div><label for="tipo_outra">Tipo sanguíneo da outra pessoa</label><select id="tipo_outra" name="tipo_outra" required>
            <option value="">Selecione</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
        </select></div>
        <div><label for="gestante">Quem está gestante?</label><select id="gestante" name="gestante" required><option value="usuario">Eu (tipo cadastrado)</option><option value="outra">A outra pessoa</option></select></div>
        <div class="form-message" data-form-message role="status" aria-live="polite"></div>
        <div class="form-actions"><button type="submit">Consultar</button><a class="button secondary" href="/compatibilidade-sanguinea/explorar.php">Explorar outras combinações</a></div>
    </form>
</section>
<section id="consultationResult" aria-live="polite"></section>
