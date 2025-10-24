CREATE DATABASE agenda_futebol;
USE agenda_futebol;

CREATE TABLE profissionais (
	id_prof INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	cpf VARCHAR(45) NOT NULL,
	rg VARCHAR(45) NOT NULL,
	telefone VARCHAR(45) NOT NULL,
	ano_cadastro YEAR NOT NULL,
	nome VARCHAR(45) NOT NULL,
	inicio_atendimento TIME NOT NULL,
	fim_atendimento TIME NOT NULL,
	email VARCHAR(45),
	senha VARCHAR(45)
);

CREATE TABLE proprietarios (
	id_prop INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	cpf VARCHAR(45) NOT NULL,
	rg VARCHAR(45) NOT NULL,
	telefone VARCHAR(45) NOT NULL,
	nome VARCHAR(45) NOT NULL,
	email VARCHAR(45),
	senha VARCHAR(45)
);

CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(15) NULL,
	cpf VARCHAR(45) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
	senha VARCHAR(45) NOT NULL,
	is_admin INT(11) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE campos (
    id_campo INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nome VARCHAR(45) NOT NULL,
    inicio_operacao TIME NOT NULL,
    fim_operacao TIME NOT NULL,
    duracao_slot INT NOT NULL,
    id_cliente INT NOT NULL,
    preco_slot DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE reservas (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    
    id_campo INT NOT NULL,
    id_cliente INT NOT NULL,
    
    data_reserva DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    
    valor_total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) NOT NULL, 
    
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- DEFINIÇÃO DAS CHAVES ESTRANGEIRAS
    FOREIGN KEY (id_campo) REFERENCES campos(id_campo),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    
    UNIQUE KEY uk_campo_data_horario (id_campo, data_reserva, hora_inicio)
) ENGINE=InnoDB;

CREATE TABLE precos_por_horario (
    id_preco INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_campo INT NOT NULL,
    dia_semana INT NOT NULL, 
    hora_inicio TIME NOT NULL,
    hora_fim TIME NOT NULL,
    preco_slot DECIMAL(10, 2) NOT NULL,
    
    FOREIGN KEY (id_campo) REFERENCES campos(id_campo),
    
    UNIQUE KEY uk_preco_campo_dia_horario (id_campo, dia_semana, hora_inicio)
) ENGINE=InnoDB;

CREATE TABLE horarios (
	id_horario INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
	dia_semana DATE NOT NULL,
	horario_inicio TIME NOT NULL,
	horario_fim TIME NOT NULL
);
