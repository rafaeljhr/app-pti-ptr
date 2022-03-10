CREATE TABLE PL_Acoes_Horario (
    horario_id int NOT NULL AUTO_INCREMENT,
    acao_id int NOT NULL,
    dia varchar(255) NOT NULL,
    periodo varchar(5) NOT NULL,
 
    PRIMARY KEY (horario_id),
    FOREIGN KEY (acao_id) REFERENCES PL_Inst_Acoes(acao_id)
);

CREATE TABLE PL_Admin (
  admin_id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(30) NOT NULL UNIQUE,
  senha varchar(30) NOT NULL,

  PRIMARY KEY (admin_id)
);

CREATE TABLE PL_Areas_Interesse (
  area_int int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(255) NOT NULL,

  PRIMARY KEY(area_int)
);

CREATE TABLE PL_Chat (
	id_mensagem INT AUTO_INCREMENT,
	mensagem VARCHAR(255) NOT NULL,
	volun_id INT,
	inst_id INT, 
	sender VARCHAR(20) NOT NULL,

	PRIMARY KEY (id_mensagem),
	FOREIGN KEY (volun_id) REFERENCES PL_Voluntario (volun_id),
	FOREIGN KEY (inst_id) REFERENCES PL_Instituicao(inst_id)
);

CREATE TABLE PL_Instituicao (
    inst_id int NOT NULL AUTO_INCREMENT,
    nome varchar(255) UNIQUE NOT NULL,
    telefone varchar(9) UNIQUE NOT NULL,
    email varchar(255) UNIQUE NOT NULL,
    email_representante varchar(255) UNIQUE NOT NULL,

    nome_representante varchar(255) NOT NULL,
    descricao varchar(255) NOT NULL,
    morada varchar(255) NOT NULL,
    distrito varchar(255) NOT NULL,
    concelho varchar(255) NOT NULL,
    freguesia varchar(255) NOT NULL,
    senha varchar(255) NOT NULL,
    website varchar(255),
    foto varchar(255),
 
    
    PRIMARY KEY (inst_id)
);

CREATE TABLE PL_Inst_Acoes (
    acao_id int AUTO_INCREMENT,
    inst_id int NOT NULL,

    nome varchar(255) NOT NULL,

    distrito varchar(255) UNIQUE NOT NULL,
    concelho varchar(255) NOT NULL,
    freguesia varchar(255) NOT NULL,
    funcao varchar(255) NOT NULL,
    numero_vagas int NOT NULL,
    Ativo varchar(3) NOT NULL,
 
    PRIMARY KEY (acao_id),
    FOREIGN KEY (inst_id) REFERENCES PL_Instituicao(inst_id)

);
´
CREATE TABLE PL_Inst_Acoes_Volun_Candidato (
	candidatura_id int AUTO_INCREMENT,
	volun_id int NOT NULL,
   	acao_id int NOT NULL,
	estado VARCHAR(20) NOT NULL,
 
   	PRIMARY KEY (candidatura_id),
   	FOREIGN KEY (volun_id) REFERENCES PL_Voluntario(volun_id),
   	FOREIGN KEY (acao_id) REFERENCES PL_Inst_Acoes(acao_id)
);

CREATE TABLE PL_Inst_Interesse (
    acao_id int NOT NULL,
    area_int int NOT NULL,
 
    PRIMARY KEY (acao_id, area_int),
    FOREIGN KEY (acao_id) REFERENCES PL_Inst_Acoes(acao_id),
    FOREIGN KEY (area_int) REFERENCES PL_Areas_Interesse(area_int)

);

CREATE TABLE PL_Inst_Popul_Alvo (
    acao_id int NOT NULL,
    id_popul_alvo int NOT NULL,
 
    PRIMARY KEY (acao_id, id_popul_alvo),
    FOREIGN KEY (acao_id) REFERENCES PL_Inst_Acoes(acao_id),
    FOREIGN KEY (id_popul_alvo) REFERENCES PL_Populacao_Alvo(id_populacao_alvo)

);

CREATE TABLE PL_Populacao_Alvo (
  id_populacao_alvo int(11) NOT NULL,
  nome varchar(255) NOT NULL,

  PRIMARY KEY (id_populacao_alvo)
);

CREATE TABLE PL_Voluntario (
    volun_id int NOT NULL AUTO_INCREMENT,
    username varchar(255) UNIQUE NOT NULL,
    email varchar(255) UNIQUE NOT NULL,
    telefone varchar(9) UNIQUE NOT NULL,
    cartao_cidadao varchar(8) UNIQUE NOT NULL,
    
    carta_conducao bit NOT NULL,
    genero varchar(255) NOT NULL,
    nome varchar(255) NOT NULL,
    freguesia varchar(255) NOT NULL,
    concelho varchar(255) NOT NULL,
    senha varchar(255) NOT NULL,
    nascimento date NOT NULL,
    foto varchar(255) NOT NULL,
    
    PRIMARY KEY (volun_id)
);

CREATE TABLE PL_Volun_Horario (
    horario_id int NOT NULL AUTO_INCREMENT,
    volun_id int NOT NULL,

    dia varchar(255) NOT NULL,
    hora_inicio varchar(5) NOT NULL,
    hora_fim varchar(5) NOT NULL,
 
    PRIMARY KEY (horario_id),
    FOREIGN KEY (volun_id) REFERENCES PL_Voluntario(volun_id)

);

CREATE TABLE PL_Volun_Interesse (
  area_int int(11) NOT NULL,
  volun_id int(11) NOT NULL,

  PRIMARY KEY(area_int, volun_id),
  FOREIGN KEY (volun_id) REFERENCES PL_Voluntario(volun_id),
  FOREIGN KEY area_int REFERENCES PL_Areas_Interesse(area_int)
);

CREATE TABLE PL_Volun_Populacao_Alvo (
    id_populacao_alvo int NOT NULL,
    volun_id int NOT NULL,
 
    PRIMARY KEY (id_populacao_alvo, volun_id),
    FOREIGN KEY (volun_id) REFERENCES PL_Voluntario(volun_id),
    FOREIGN KEY (id_populacao_alvo) REFERENCES PL_Populacao_Alvo(id_populacao_alvo)

);