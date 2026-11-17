class ApiClient {
    static csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    static async request(url, options = {}) {
        const method = (options.method || 'GET').toUpperCase();
        const headers = { Accept: 'application/json' };
        const request = { method, headers, credentials: 'same-origin' };

        if (method !== 'GET') {
            headers['Content-Type'] = 'application/json';
            headers['X-CSRF-Token'] = this.csrfToken();
            request.body = JSON.stringify({ ...(options.data || {}), _csrf: this.csrfToken() });
        }

        let response;
        try {
            response = await fetch(url, request);
        } catch (error) {
            throw new Error('Não foi possível conectar ao servidor. Verifique sua conexão e tente novamente.');
        }

        let payload;
        try {
            payload = await response.json();
        } catch (error) {
            throw new Error('O servidor retornou uma resposta que não pôde ser interpretada.');
        }

        if (!response.ok || !payload.success) {
            throw new Error(payload.message || 'Não foi possível concluir a operação.');
        }

        return payload;
    }

    static get(url) {
        return this.request(url);
    }

    static post(url, data = {}) {
        return this.request(url, { method: 'POST', data });
    }
}

window.ApiClient = ApiClient;
