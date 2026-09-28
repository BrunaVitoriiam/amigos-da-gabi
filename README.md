# Amigos da Gabi

## Sistema de Cadastro de Amigos

Projeto desenvolvido para a disciplina de Programação WEB II.

O sistema permite o gerenciamento de amigos através das operações CRUD e possui sistema de autenticação de usuários.

## Objetivo

Desenvolver uma aplicação web utilizando HTML, CSS, PHP e MySQL.

## Funcionalidades

- Cadastro de usuário
- Login
- Logout
- Controle de sessão
- Cadastro de amigos
- Consulta de amigos
- Edição de amigos
- Exclusão de amigos

## CRUD

### Create
Cadastro de novos amigos.

### Read
Consulta dos amigos cadastrados.

### Update
Atualização dos dados dos amigos.

### Delete
Exclusão dos amigos.

## Tecnologias

- HTML5
- CSS3
- PHP
- MySQL

## Segurança

O projeto utiliza:

- password_hash()
- password_verify()
- PDO
- consultas preparadas
- sessões PHP
- validação dos dados

## Banco de dados

O sistema possui duas tabelas principais:

### usuarios

Armazena os usuários cadastrados.

### amigos

Armazena os amigos cadastrados.

A tabela amigos possui o campo usuario_id, responsável pelo relacionamento com o usuário.

## Autor

Gabi

## Disciplina

Programação WEB II

## Professora

Alice
