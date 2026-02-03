# TCC - iRead

Este repositório contém o desenvolvimento do meu Trabalho de Conclusão de Curso (TCC), realizado na ETEC de Vila Formosa. Onde o objetivo foi sistematizar o gerenciamento da biblioteca escolar.

o projeto foi desenvolvido com foco no gerenciamento dos livros e monitoramento de alunos que reservaram livros, aplicando práticas adiquiridas ao longo do curso.

# Objetivos

- Criar uma aplicação web, para auxiliar no monitoramento dos livros.
- Aplicar conceitos de MVC, autenticação, CRUD, controle de acesso com middlewares  e roteamento.
- Consolidar conhecimentos em lógica de programação, PHP, back-end e banco de dados.

# Problema abordado

Durante o planejamento do projeto, identificamos que a biblioteca escolar, recém-inaugurada, utilizava um processo manual para gerenciar livros e monitorar as reservas de livros. Pensando no trabalho eficiente, bolamos uma aplicação web que demonstra o catálogo de livros disponíveis para reserva e os respectivos alunos que reservaram tais livros. Assim, facilitando o processo de gerência e reserva.

# Tecnologias

- PHP 8.2.12.
- MySQL/ MariaDB 10.
- XAMPP 8.2.12.
- Composer e Twig.
- Conceitos: MVC, autenticação, roteamento, CRUD e Middlewares.

# Funcionalidades

- Reservar livros.
- Monitorar alunos.
- Adicionar livros.
- Autenticação de usuários.

# Grupo

O desenvolvimento do projeto foi feito por mim, responsável pelo Back-end e Front-end, e outro integrante, responsável pelo design das telas.

# Dependências

- XAMPP 8.2.12.
- Composer 2.7.

# Como executar

1. Clone o repositório.

        git clone https://github.com/loganForte/TCC-gerenciador-biblioteca.git

2. Instale as depencências.

        composer install

3. Abra o XAMPP e ligue o módulo MySQL.

4. Execute este comando para criar o banco de dados:

        composer run db:create

5. Ligue o módulo do Apache e entre no projeto.

6. Para autenticação no sistema:
    - Para alunos, o email é user@email.com e a senha é 123.
    - Para bibliotecarios, o email é biblio@email.com e a senha é biblio123.