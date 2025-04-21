# 🍔 API EaePediu?

Uma API robusta para um aplicativo de pedidos online, inspirada em plataformas como o iFood. Gerencie restaurantes, produtos, pedidos e usuários de forma eficiente! 🚀

---

## 📋 Sobre o Projeto

O **EaePediu?** é uma API para um app de pedidos online, inspirado no iFood, que simplifica pedidos de restaurantes com segurança e praticidade. Ela gerencia restaurantes, produtos, categorias, pedidos e usuários, usando **Laravel Sanctum** para autenticação. Integra **AWS S3** para upload de imagens, como fotos de produtos e restaurantes, e **Stripe** para gerenciar assinaturas: donos de restaurantes assinam planos para criar restaurantes na plataforma e acessar funcionalidades extras, enquanto os pagamentos dos pedidos são gerenciados diretamente por cada restaurante. É uma solução prática para conectar clientes e restaurantes!

## ✨ Funcionalidades

Aqui estão as principais funcionalidades da API:

- **👤 Gerenciamento de Usuários**

  - Cadastro e login de usuários com autenticação segura.
  - Recuperação de senha via e-mail (com envio de e-mail de verificação).
  - Atualização de perfil e upload de avatar.

- **🍽️ Gerenciamento de Restaurantes**

  - Cadastro de novos restaurantes (com verificação de subdomínio).
  - Atualização, exclusão e listagem de restaurantes.
  - Upload de imagens para restaurantes (usando AWS S3).
  - Listagem de restaurantes para administradores e usuários.

- **📦 Gerenciamento de Produtos**

  - Criação, atualização, exclusão e listagem de produtos.
  - Upload de imagens para produtos (usando AWS S3).
  - Associação de produtos a restaurantes específicos.

- **📋 Gerenciamento de Categorias**

  - Criação, atualização, exclusão e listagem de categorias para organizar produtos.
  - Associação de categorias a restaurantes.

- **🛒 Gerenciamento de Pedidos**

  - Criação de pedidos por clientes e restaurantes.
  - Listagem, atualização e exclusão de pedidos.
  - Gerenciamento de pedidos por restaurante (para administradores).

- **💳 Integração com Stripe**

  - Gerenciamento de assinaturas (iniciar, cancelar e retomar).
  - Webhooks para eventos do Stripe.

- **🔐 Autenticação e Segurança**

  - Middleware de autenticação (`auth:sanctum`) para proteger rotas.
  - Verificação de e-mail para novos usuários.
  - Limitação de requisições (throttling) em rotas sensíveis, como recuperação de senha.

---

## 🖥️ Tecnologias Utilizadas

Este projeto foi desenvolvido com as seguintes tecnologias:

- **PHP** como linguagem principal.
- **Laravel** como framework para construção da API.
- **AWS S3** para armazenamento de imagens (avatars, produtos e restaurantes).
- **Stripe** para gerenciamento de pagamentos e assinaturas.
- **Sanctum** para autenticação baseada em tokens.

## 📦 Pré-requisitos

Para rodar o projeto localmente, você precisará das seguintes ferramentas instaladas:

- **Git**
- **PHP** (versão 8.0 ou superior)
- **Composer** para gerenciar dependências do PHP
- **MySQL** ou outro banco de dados compatível com o Laravel
- **AWS S3** (configurado para upload de imagens)
- **Stripe** (chave de API para testes de pagamento)

---

## 🚀 Como Usar

Siga os passos abaixo para configurar e rodar o projeto localmente:

```bash
# Clone o repositório
git clone git@github.com:LucasCavalheri/eaepediu-api.git

# Entre no diretório do projeto
cd eaepediu-api

# Instale as dependências do PHP
composer install

# Configure o arquivo .env com suas credenciais
# (banco de dados, AWS S3, Stripe, etc.)
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Execute as migrações para criar o banco de dados
php artisan migrate

# Inicie o servidor local
php artisan serve
```

A API estará disponível em `http://localhost:8000`.

### Configurações Adicionais

- **AWS S3**: Certifique-se de configurar as credenciais da AWS no arquivo `.env` para uploads de imagens.
- **Stripe**: Adicione suas chaves de API do Stripe no arquivo `.env` para gerenciar assinaturas.
- **E-mail**: Configure um serviço de e-mail (como Mailtrap para testes) para envio de verificações e recuperação de senha.

---

## 🛠️ Endpoints Principais

Aqui estão alguns dos principais endpoints da API:

- **Autenticação**

  - `POST /register` - Registrar um novo usuário
  - `POST /login` - Fazer login
  - `POST /logout` - Fazer logout
  - `POST /send-email-verification` - Enviar e-mail de verificação

- **Restaurantes**

  - `POST /restaurants` - Criar um restaurante
  - `GET /restaurants` - Listar todos os restaurantes (admin)
  - `GET /user/all` - Listar restaurantes do usuário autenticado
  - `POST /restaurants/{id}/upload-image` - Fazer upload de imagem

- **Produtos**

  - `POST /products/{id}` - Criar um produto
  - `GET /products` - Listar todos os produtos
  - `GET /products/restaurant/{id}` - Listar produtos de um restaurante

- **Pedidos**

  - `POST /orders/customer/create` - Criar um pedido como cliente
  - `GET /restaurant/{id}/order/{orderId}` - Obter detalhes de um pedido

- **Stripe**

  - `POST /stripe/swap` - Iniciar uma assinatura
  - `POST /stripe/cancel` - Cancelar uma assinatura

---

## 🤝 Contribuições

Contribuições são muito bem-vindas! Siga os passos abaixo para contribuir:

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Commit suas alterações (`git commit -m 'Adiciona nova feature'`)
4. Envie para o repositório remoto (`git push origin feature/nova-feature`)
5. Abra um Pull Request

---

## 📜 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

---

Criado e desenvolvido por **Lucas Cavalheri** 💻
