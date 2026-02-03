create database sistema_gestao_biblioteca
character set utf8mb4
collate utf8mb4_unicode_ci;

use sistema_gestao_biblioteca;

create table alunos(
	id_aluno int primary key not null auto_increment,
    RM char(5) unique not null,
	email_institucional varchar(90) not null unique,
    senha varchar(80) not null
);

create table autor(
	id_autor int primary key not null  auto_increment,
    nome varchar(90) not null
);

create table bibliotecaria(
	id_bibliotecaria int primary key not null auto_increment,
    nome varchar(90) not null,
    email_institucional varchar(90) not null unique,
    senha varchar(80) not null,
    telefone varchar(20) not null
);

create table livro(
	id_livro int primary key not null  auto_increment,
    titulo varchar(100) not null,
    emprestado boolean default false not null,
    fk_autor int,
    fk_bibliotecaria int,
    categoria varchar(50) not null,
    url varchar(100) not null,
    editora varchar(50) not null,
    ano_publicacao int not null,
    quantidade int not null
);

alter table livro add constraint foreign key (fk_autor) references autor(id_autor);
alter table livro add constraint foreign key (fk_bibliotecaria) references bibliotecaria(id_bibliotecaria);

create table emprestimo(
	id_emprestimo int primary key not null auto_increment,
    data_emprestimo date not null,
    data_devolucao date not null,
    fk_livro int,
    fk_aluno int,
    constraint fk_livro foreign key(fk_livro) references livro(id_livro),
    constraint fk_aluno foreign key(fk_aluno) references alunos(id_aluno)
);

INSERT INTO alunos (RM, email_institucional, senha) VALUES 
('12345', 'user@email.com', '$2y$10$ASPivfMiH9eBgbzOx9Iu1.xO4XHhvq7y6OvgCtPAHKzGSDvRkP5Aa');

INSERT INTO bibliotecaria (nome, email_institucional, senha, telefone) VALUES 
('Bibliotecaria', 'biblio@email.com', '$2y$10$UvxvLXDDGKmilGTwz454ieq084s8livzDcvxCIRPCb3Ia1xE9bBBy', '0987654321');