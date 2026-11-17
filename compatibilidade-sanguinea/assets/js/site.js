class AjaxFormController {
    constructor() {
        document.querySelectorAll('form[data-ajax-form]').forEach((form) => {
            form.addEventListener('submit', (event) => this.submit(event, form));
        });

        document.querySelectorAll('form[data-ajax-logout]').forEach((form) => {
            form.addEventListener('submit', (event) => this.logout(event));
        });
    }

    async submit(event, form) {
        event.preventDefault();
        if (!form.reportValidity()) return;

        const button = form.querySelector('[type="submit"]');
        const message = form.querySelector('[data-form-message]');
        const originalLabel = button?.textContent || '';
        if (button) {
            button.disabled = true;
            button.textContent = 'Enviando...';
        }
        this.showMessage(message, '', '');

        const payload = Object.fromEntries(new FormData(form).entries());
        try {
            const response = await ApiClient.post(form.dataset.api, payload);
            if (form.dataset.formKind === 'redirect') {
                window.location.href = response.data.redirect;
                return;
            }
            if (form.dataset.formKind === 'result') {
                const target = document.querySelector(form.dataset.resultTarget);
                ResultRenderer.render(target, response.data.result);
                this.showMessage(message, response.message, 'success');
            }
        } catch (error) {
            this.showMessage(message, error.message, 'error');
        } finally {
            if (button) {
                button.disabled = false;
                button.textContent = originalLabel;
            }
        }
    }

    async logout(event) {
        event.preventDefault();
        try {
            const response = await ApiClient.post('/compatibilidade-sanguinea/api/auth/logout.php');
            window.location.href = response.data.redirect;
        } catch (error) {
            window.alert(error.message);
        }
    }

    showMessage(element, text, kind) {
        if (!element) return;
        element.textContent = text;
        element.className = kind ? `form-message alert ${kind}` : 'form-message';
    }
}

class DashboardController {
    async init() {
        const root = document.getElementById('dashboardProfile');
        if (!root) return;

        try {
            const response = await ApiClient.get('/compatibilidade-sanguinea/api/dashboard/summary.php');
            const user = response.data.user;
            document.getElementById('dashboardBloodType').textContent = user.tipo_sanguineo;
            document.getElementById('dashboardGreeting').textContent = `Olá, ${user.nome}!`;
            document.getElementById('dashboardDescription').innerHTML = `Seu tipo sanguíneo cadastrado é <strong>${this.escape(user.tipo_sanguineo)}</strong>.`;
            this.renderHistory(response.data.history || []);
        } catch (error) {
            root.innerHTML = `<div class="alert error">${this.escape(error.message)}</div>`;
        }
    }

    renderHistory(items) {
        const target = document.getElementById('dashboardHistory');
        if (!target) return;
        if (!items.length) {
            target.innerHTML = '<p class="muted">Ainda não há consultas registradas. Quando você fizer uma consulta, ela aparecerá aqui.</p>';
            return;
        }
        const rows = items.map((item) => `<tr><td>${this.date(item.criado_em)}</td><td><strong>${this.escape(item.tipo1)} × ${this.escape(item.tipo2)}</strong></td><td>${this.escape(this.pregnantLabel(item.gestante))}</td></tr>`).join('');
        target.innerHTML = `<div class="table-wrap"><table><thead><tr><th>Data</th><th>Combinação</th><th>Gestante</th></tr></thead><tbody>${rows}</tbody></table></div><a class="button secondary mt-14" href="/compatibilidade-sanguinea/historico.php">Ver histórico completo</a>`;
    }

    pregnantLabel(value) {
        return ({ usuario: 'Eu', outra: 'A outra pessoa', tipo1: 'Primeiro tipo', tipo2: 'Segundo tipo' })[value] || value;
    }

    date(value) {
        const date = new Date(String(value).replace(' ', 'T'));
        return Number.isNaN(date.getTime()) ? this.escape(value) : new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short', timeStyle: 'short' }).format(date);
    }

    escape(value) {
        return ResultRenderer.escape(value);
    }
}

class HistoryController {
    constructor() {
        this.target = document.getElementById('historyContent');
        this.message = document.getElementById('historyMessage');
        this.deleteButton = document.getElementById('deleteHistoryButton');
        this.deleteButton?.addEventListener('click', () => this.deleteAll());
    }

    async init() {
        if (!this.target) return;
        await this.load();
    }

    async load() {
        try {
            const response = await ApiClient.get('/compatibilidade-sanguinea/api/history/list.php');
            this.render(response.data.items || []);
        } catch (error) {
            this.target.innerHTML = `<div class="alert error">${ResultRenderer.escape(error.message)}</div>`;
        }
    }

    render(items) {
        if (!items.length) {
            this.target.innerHTML = '<p class="muted">Você ainda não fez nenhuma consulta.</p><a class="button" href="/compatibilidade-sanguinea/consulta.php">Fazer uma consulta</a>';
            return;
        }
        const rows = items.map((item) => `<tr><td>${this.date(item.criado_em)}</td><td><strong>${ResultRenderer.escape(item.tipo1)} × ${ResultRenderer.escape(item.tipo2)}</strong></td><td>${ResultRenderer.escape(this.pregnantLabel(item.gestante))}</td><td>${item.origem === 'explorar' ? 'Explorar combinações' : 'Consulta'}</td></tr>`).join('');
        this.target.innerHTML = `<div class="table-wrap"><table><thead><tr><th>Data e hora</th><th>Combinação</th><th>Quem está gestante</th><th>Origem</th></tr></thead><tbody>${rows}</tbody></table></div>`;
    }

    async deleteAll() {
        if (!window.confirm('Tem certeza que deseja apagar todo o seu histórico? Essa ação não pode ser desfeita.')) return;
        this.deleteButton.disabled = true;
        try {
            const response = await ApiClient.post('/compatibilidade-sanguinea/api/history/delete.php');
            this.showMessage(response.message, 'success');
            await this.load();
        } catch (error) {
            this.showMessage(error.message, 'error');
        } finally {
            this.deleteButton.disabled = false;
        }
    }

    showMessage(text, kind) {
        if (!this.message) return;
        this.message.textContent = text;
        this.message.className = `form-message alert ${kind}`;
    }

    pregnantLabel(value) {
        return ({ usuario: 'Eu (tipo cadastrado)', outra: 'A outra pessoa', tipo1: 'Primeiro tipo', tipo2: 'Segundo tipo' })[value] || value;
    }

    date(value) {
        const date = new Date(String(value).replace(' ', 'T'));
        return Number.isNaN(date.getTime()) ? ResultRenderer.escape(value) : new Intl.DateTimeFormat('pt-BR', { dateStyle: 'short', timeStyle: 'short' }).format(date);
    }
}

class ConsultationProfileController {
    async init() {
        const target = document.getElementById('userBloodType');
        if (!target) return;
        try {
            const response = await ApiClient.get('/compatibilidade-sanguinea/api/dashboard/summary.php');
            target.textContent = response.data.user.tipo_sanguineo;
        } catch (error) {
            target.textContent = 'Não disponível';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new AjaxFormController();
    new DashboardController().init();
    new HistoryController().init();
    new ConsultationProfileController().init();
});
