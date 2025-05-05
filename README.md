# Contact List

Aplicação para gerenciamento de contatos, construída com Vue 3 no frontend e Laravel 12 com SQLite no backend.

---

## Tecnologias

- Vue 3
- Laravel 12
- PHP 8
- SQLite
- Axios
- Tailwind CSS

---

## Requisitos

- PHP >= 8.1
- Node.js >= 18
- Composer
- SQLite
- Git

---

## Instalação e Execução

### 1. Clone o projeto

```
git clone https://github.com/judsonmb/contact-list.git
cd contact-list
```

### 2. Instale as dependências do backend (Laravel)

```
composer install
```

### 3. Configure o .env

Crie o arquivo `.env` com base no `.env.example`:

```
cp .env.example .env
```

No arquivo `.env`, configure a conexão com o banco SQLite:

```
DB_CONNECTION=sqlite
DB_DATABASE=DB_DATABASE=./database/database.sqlite
```

Crie uma conta no https://mailtrap.io/ e adicione suas credenciais username e password aqui:

MAIL_USERNAME=
MAIL_PASSWORD=

O restante já está configurado para o mailtrap

### 4. Gere a chave da aplicação

```
php artisan key:generate
```

### 5. Rode as migrations e seeders

```
php artisan migrate --seed
```

---

### 6. Instale as dependências do frontend (Vue)

```
npm install
```

---

### 7. Rode os servidores

Backend (Laravel):

```
php artisan serve
```

Frontend (Vite):

Em outro terminal:

```
npm run dev
```

A aplicação estará disponível em:

http://localhost:8000

---

## Funcionalidades

- Cadastro de contatos
- Edição e exclusão
- Busca automática de endereço via CEP (API ViaCEP)
- Formulário com preenchimento automático
- Integração de API Laravel com frontend Vue

---

## Autor

Desenvolvido por Judson Melo Bandeira
GitHub: https://github.com/judsonmb
