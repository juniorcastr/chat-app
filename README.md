# ChatApp

Um sistema de chat criado com Laravel, incluindo autenticação, comunicação em tempo real e gerenciamento de usuários.

## Requisitos do Sistema

- PHP >= 8.1
- Composer
- Laravel 10.x ou mais recente
- MySQL ou outro banco de dados suportado
- Redis para filas e cache (opcional, mas recomendado)

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-repositorio/chatapp.git
   cd chatapp
   
2. Instale as dependências
   ```bash
   composer install
   npm install && npm run dev
   
3. Duplique o .env.example para .env e ajuste as variáveis de ambiente.

4. Execute as migrações com os seeds
   ```bash
   php artisan migrate --seed
   
5. Gere a chave da aplicação
   ```bash
   php artisan key:generate

6. Execute o servidor local:
   ```bash
   php artisan serve

## Uso
Página inicial: Acesse a interface de chat em http://localhost:8000/.

Autenticação: Utilize o Laravel Jetstream para registro/login.

## Funcionalidades
Sistema de chat em tempo real usando Pusher e Laravel Echo.

CRUD de usuários com perfis de administrador.

Integração de Redis para cache e filas de mensagens.

## Documentação da API
Acesse a documentação da API gerada automaticamente com Swagger em http://localhost:8000/api/documentation.

## Testes
Para executar os testes automatizados:
```bash
   php artisan serve

