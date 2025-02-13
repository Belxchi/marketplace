# Marketplace

Teste técnico de marketplace com Vue.js 3 no frontend e Laravel 10 no backend.

## Tecnologias

- Frontend:
  - Vue.js 3
  - Tailwind CSS
  - Vue Router
  - Vue Toastification
  - Chart.js
  - Vite

- Backend:
  - Laravel 10
  - PHP 8.1+
  - MariaDB

## Pré-requisitos

- PHP 8.1 ou superior
- Composer
- Node.js 16 ou superior
- MariaDB
- Git

## Instalação

### Backend

1. Clone o repositório

2. Entre na pasta do backend

3. Instale as dependências (composer install)

4. Configure o arquivo `.env` com as credenciais do banco de dados
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=marketplace
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha

5. Execute as migrações (php artisan migrate)

- 5.1. Opcional: Execute as seeds (php artisan db:seed)

- 5.2. Opcional: Execute as migrations e seeds juntas (php artisan migrate:fresh --seed)

6. Inicie o servidor (php artisan serve)

### Frontend

1. Entre na pasta do frontend

2. Instale as dependências (npm install)

3. Configure o arquivo .env com a URL da API (VITE_API_URL=http://localhost:8000/api)

4. Inicie o servidor (npm run dev)

5. Acesse a aplicação no navegador (http://localhost:5173)