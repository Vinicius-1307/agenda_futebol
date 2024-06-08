CREATE DATABASE TCC_RODRIGO;
USE TCC_RODRIGO;

CREATE TABLE profissionais (
	id_prof INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	cpf VARCHAR(45) NOT NULL,
	rg VARCHAR(45) NOT NULL,
	telefone VARCHAR(45) NOT NULL,
	ano_cadastro YEAR NOT NULL,
	nome VARCHAR(45) NOT NULL,
	inicio_atendimento TIME NOT NULL,
	fim_atendimento TIME NOT NULL
);

CREATE TABLE servicos (
	id_servico INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	nome_servico VARCHAR(45) NOT NULL
);

CREATE TABLE horarios (
	id_horario INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	dia_semana DATE NOT NULL,
	horario_inicio TIME NOT NULL,
	horario_fim TIME NOT NULL
);

CREATE TABLE clientes (
	cpf VARCHAR(45) NOT NULL PRIMARY KEY,
	nome VARCHAR(45) NOT NULL,
	telefone VARCHAR(45) NOT NULL,
    email VARCHAR(45) NOT NULL,
    senha VARCHAR(45) NOT NULL
);

CREATE TABLE fotos_servicos (
	id_foto INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	nome_arquivo VARCHAR(45) NOT NULL,
	id_servico INT(11) NOT NULL,
	FOREIGN KEY (id_servico) REFERENCES servicos (id_servico)
);

CREATE TABLE servico_profissional (
	id_servico_prof INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	id_servico INT(11) NOT NULL,
	id_prof INT(11) NOT NULL,
	preco_servico INT(11) NOT NULL,
	tempo_servico TIME NOT NULL,
	FOREIGN KEY (id_servico) REFERENCES servicos (id_servico),
	FOREIGN KEY (id_prof) REFERENCES profissionais (id_prof)
);

CREATE TABLE agendas (
	id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	cpf_cliente VARCHAR(45) NOT NULL,
	FOREIGN KEY (cpf_cliente) REFERENCES clientes (cpf),
	id_horario INT(11) NOT NULL,
	FOREIGN KEY (id_horario) REFERENCES horarios (id_horario),
	id_servico_prof INT(11) NOT NULL,
	FOREIGN KEY (id_servico_prof) REFERENCES servico_profissional (id_servico_prof)
);
