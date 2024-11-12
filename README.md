# ChatApp

Um sistema de chat criado com Laravel, incluindo autenticação, comunicação em tempo real e gerenciamento de usuários.

## Requisitos do Sistema

- PHP >= 8.1
- Composer
- Laravel 10.x ou mais recente
- MySQL ou outro banco de dados suportado
- Redis para filas e cache (opcional, mas recomendado)


## Funcionalidades Principais
- Sistema de chat em tempo real utilizando Pusher para comunicação via WebSockets.
- Implementação de cache com Redis para otimização de consultas de mensagens.
- Processamento de mensagens assíncrono utilizando filas.
- Design stateless para facilitar a escalabilidade horizontal.
- Monitoramento detalhado com Laravel Telescope para observabilidade de desempenho e operações.
- Testes unitários e de integração com cobertura mínima de 80%.


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

usuário padrão
admin@admin.com
123123123

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

## Estrutura do Projeto
#Controladores
ChatController: Gerencia as operações de exibição e envio de mensagens com caching e eventos de broadcast.
UserController: Gerencia as operações de CRUD de usuários e perfis.

## Eventos
NewMessage: Evento que dispara quando uma nova mensagem é enviada, integrando com Pusher para comunicação em tempo real.

##Redis
Utilizado para armazenamento em cache de mensagens e gerenciamento de filas.
Observabilidade com Laravel Telescope
O Laravel Telescope foi configurado para monitorar operações como:

Requisições HTTP
Consultas ao banco de dados
Jobs na fila
Eventos e logs
Testes
Cobertura mínima de 80% nos testes.
Testes unitários e de integração configurados para garantir a qualidade do código.

## Documentação da API
A documentação da API foi gerada com Swagger/OpenAPI. Para visualizar a documentação:

Certifique-se de que o L5 Swagger foi configurado e instale as dependências necessárias.
Acesse a rota /api/documentation para visualizar o Swagger UI.

