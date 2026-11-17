# Compatibilidade Sanguínea

Aplicação educativa sobre compatibilidade sanguínea, herança genética, gestação e doação de hemácias.

## Organização do projeto

O código foi separado em três partes principais:

- `app/`: classes responsáveis pelas regras, autenticação, segurança, sessão, banco de dados e acesso aos dados.
- `api/`: pontos de entrada do back-end. Recebem requisições HTTP e devolvem respostas JSON.
- `views/`: páginas HTML/PHP usadas somente para apresentar as telas.
- `assets/`: arquivos de CSS e JavaScript do front-end.
- `database/`: estrutura SQL das tabelas utilizadas pelo sistema.

## Tecnologias

- PHP 8.0 ou superior
- MySQL e PDO MySQL
- HTML5 e CSS3
- JavaScript (classes ES6 e Fetch API)
- Requisições assíncronas AJAX com respostas JSON

## Como executar localmente

1. Instale e abra o XAMPP.
2. Inicie Apache e MySQL.
3. Copie a pasta `compatibilidade-sanguinea` para `C:\xampp\htdocs\`.
4. Abra o phpMyAdmin em `http://localhost/phpmyadmin`.
5. Crie um banco chamado `compatibilidade_sanguinea`.
6. Selecione o banco e importe `database/schema.sql`.
7. Acesse `http://localhost/compatibilidade-sanguinea/`.

No ambiente local, a conexão usa por padrão `127.0.0.1`, banco `compatibilidade_sanguinea`, usuário `root` e senha vazia. Esses valores podem ser substituídos pelas variáveis de ambiente abaixo.

## Configuração do banco

O back-end lê as seguintes variáveis de ambiente:

- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `APP_ENV`

Em hospedagem, configure essas variáveis no ambiente do PHP ou pelo mecanismo indicado pelo administrador do servidor. Não coloque senhas de produção no GitHub.

## Comunicação AJAX e JSON

O front-end utiliza `assets/js/api-client.js` para enviar requisições com `fetch`. Os formulários dinâmicos não enviam dados por navegação tradicional: eles recebem JSON e atualizam a página sem recarregá-la.

Principais rotas:

| Método | Rota | Função |
|---|---|---|
| POST | `api/auth/login.php` | Autenticação |
| POST | `api/auth/register.php` | Cadastro |
| POST | `api/auth/logout.php` | Encerramento da sessão |
| GET | `api/dashboard/summary.php` | Dados do painel inicial |
| POST | `api/consultations/compare.php` | Consulta usando o tipo cadastrado |
| POST | `api/consultations/explore.php` | Consulta livre entre dois tipos |
| GET | `api/history/list.php` | Listagem do histórico |
| POST | `api/history/delete.php` | Exclusão do histórico |

As rotas que alteram dados exigem o token CSRF da sessão. As respostas seguem o formato JSON com os campos `success`, `message` e `data`.

## Classes principais

- `App\\Core\\DatabaseConnection`: cria e mantém a conexão PDO.
- `App\\Core\\SessionManager`: controla sessão, autenticação e CSRF.
- `App\\Core\\PageRenderer`: carrega as telas e o layout.
- `App\\Controllers`: recebe as requisições e coordena os serviços.
- `App\\Services\\AuthService`: valida login e cadastro.
- `App\\Services\\BloodCompatibilityService`: executa os cálculos de compatibilidade e genética.
- `App\\Services\\ConsultationService`: valida e organiza as consultas.
- `App\\Services\\HistoryService`: coordena o histórico.
- `App\\Repositories`: concentra o acesso às tabelas do banco.

## Responsividade

O layout utiliza a meta viewport, grades flexíveis, largura fluida, tabelas com rolagem horizontal e pontos de quebra para telas de até 800 px e 520 px. O quiz, os formulários, as consultas e o histórico podem ser usados em telas menores.

## Observação educativa

O sistema utiliza os sistemas ABO e RhD como modelo simplificado para fins de aprendizagem. As consultas não substituem exames, testes pré-transfusionais, hemocentros ou avaliação profissional.
