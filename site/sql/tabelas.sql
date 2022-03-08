DROP TABLE IF EXISTS subcategoria;
DROP TABLE IF EXISTS categoria;
DROP TABLE IF EXISTS encomenda;
DROP TABLE IF EXISTS recursos_consumidos;
DROP TABLE IF EXISTS eventos_da_cadeia_logistica_do_produto;
DROP TABLE IF EXISTS produto;
DROP TABLE IF EXISTS armazem;
DROP TABLE IF EXISTS fornecedor;
DROP TABLE IF EXISTS consumidor;
DROP TABLE IF EXISTS metodo_transporte;
DROP TABLE IF EXISTS base;
DROP TABLE IF EXISTS transportadora;


CREATE TABLE transportadora (
    telemovel VARCHAR(9) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    nif VARCHAR(9) NOT NULL UNIQUE,
    morada_fiscal VARCHAR(200) NOT NULL,

    CONSTRAINT pk_transportadora_telemovel
        PRIMARY KEY (telemovel)
);


CREATE TABLE base (
    morada VARCHAR(200) NOT NULL,
	telemovel VARCHAR(9) NOT NULL,

    CONSTRAINT pk_transportadora_morada
        PRIMARY KEY (morada),
		
	CONSTRAINT fk_base_telemovel_transportadora
        FOREIGN KEY (telemovel) 
        REFERENCES transportadora(telemovel)
);


CREATE TABLE metodo_transporte (
    id integer NOT NULL AUTO_INCREMENT,
    morada VARCHAR(200) NOT NULL,
    nome VARCHAR(20) NOT NULL, 
    consumo NUMERIC NOT NULL,
    tipoCombustivel VARCHAR(20) NOT NULL,

    CONSTRAINT pk_metodo_transporte_id
        PRIMARY KEY (id),

    CONSTRAINT fk_metodo_transporte_morada
        FOREIGN KEY (morada) 
        REFERENCES base(morada)
);


CREATE TABLE consumidor (
    nome VARCHAR(20) NOT NULL,
    telemovel VARCHAR(9) NOT NULL,
    NIF NUMERIC(9) NOT NULL UNIQUE,
    morada VARCHAR(200) NOT NULL,

    CONSTRAINT pk_consumidor_telemovel
        PRIMARY KEY (telemovel)
);


CREATE TABLE fornecedor (
    morada_fiscal VARCHAR(100) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    NIF VARCHAR(9) NOT NULL UNIQUE,
    telemovel VARCHAR(9) NOT NULL UNIQUE,

    CONSTRAINT pk_fornecedor_telemovel
        PRIMARY KEY (telemovel)
);


CREATE TABLE armazem (
	id integer NOT NULL AUTO_INCREMENT,
    morada VARCHAR(100) NOT NULL,
    recursos_consumidos_por_dia DECIMAL(10, 2) NOT NULL,
    telemovel_fornecedor VARCHAR(9),
	
    CONSTRAINT pk_armazem_id
    PRIMARY KEY (id),

    CONSTRAINT fk_armazem_telemovel_fornecedor
        FOREIGN KEY (telemovel_fornecedor)
        REFERENCES fornecedor(telemovel)
);


CREATE TABLE categoria (
    id integer NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,

    CONSTRAINT pk_categoria_id
        PRIMARY KEY (id)
);


CREATE TABLE subcategoria (
    id integer NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    id_categoria integer NOT NULL,

    CONSTRAINT pk_subcategoria_id
        PRIMARY KEY (id),

    CONSTRAINT fk_subcategoria_id_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categoria(id)
);


CREATE TABLE produto (
    id integer NOT NULL AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    data_produção_do_produto DATE NOT NULL,
    data_insercao_no_site DATE NOT NULL,
    -- poluicao dioxido de carbono (gramas/cm3)
    poluicao_gerada_por_dia DECIMAL(10,2) NOT NULL,
    info_arbitraria VARCHAR(300) NOT NULL,
    id_armazem integer NOT NULL,
    telemovel_fornecedor VARCHAR(9),
    id_categoria integer NOT NULL,
    id_subcategoria integer NOT NULL,

    CONSTRAINT pk_produto_id
        PRIMARY KEY (id),

    CONSTRAINT fk_armazem_id
        FOREIGN KEY (id_armazem)
        REFERENCES armazem(id),

    CONSTRAINT fk_produto_telemovel_fornecedor
        FOREIGN KEY (telemovel_fornecedor)
        REFERENCES fornecedor(telemovel),

    CONSTRAINT fk_produto_id_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categoria(id),

    CONSTRAINT fk_produto_id_subcategoria
        FOREIGN KEY (id_subcategoria)
        REFERENCES subcategoria(id)
);


CREATE TABLE eventos_da_cadeia_logistica_do_produto (
    id integer NOT NULL AUTO_INCREMENT,
    poluicao_gerada DECIMAL(10,2) NOT NULL,
    descricao_do_evento VARCHAR(300) NOT NULL,
    id_produto integer NOT NULL,

    CONSTRAINT pk_cadeia_logistica_produto_id
        PRIMARY KEY (id),

    CONSTRAINT fk_recursos_consumidos_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id)
);


CREATE TABLE recursos_consumidos (
	id integer NOT NULL AUTO_INCREMENT,
    nome_do_recurso VARCHAR(100) NOT NULL,
    quantidade integer NOT NULL,
    -- pode ser nulo se este recurso consumido for destinado a um evento ou armazem
    id_produto integer,
    -- pode ser nulo se este recurso consumido for destinado a um produto ou armazem
    id_evento integer,
    -- pode ser nulo se este recurso consumido for destinado a um produto ou evento
    id_armazem integer,
	
    CONSTRAINT pk_recursos_consumidos_id
    PRIMARY KEY (id),

    CONSTRAINT fk_recursos_consumidos_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id),

    CONSTRAINT fk_recursos_consumidos_id_evento
        FOREIGN KEY (id_evento)
        REFERENCES eventos_da_cadeia_logistica_do_produto(id),

    CONSTRAINT fk_recursos_consumidos_id_armazem
        FOREIGN KEY (id_armazem)
        REFERENCES armazem(id)
);


CREATE TABLE encomenda (
    id integer NOT NULL AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    morada_de_entrega VARCHAR(200) NOT NULL,
    quantidade integer NOT NULL,
    data_realizada DATETIME NOT NULL,
    data_finalizada DATETIME,
    telemovel_consumidor integer NOT NULL,
    id_produto integer NOT NULL,
    telemovel_transportadora integer NOT NULL,

    CONSTRAINT pk_encomenda_id
        PRIMARY KEY (id),

    CONSTRAINT fk_encomenda_telemovel_consumidor
        FOREIGN KEY (telemovel_consumidor)
        REFERENCES consumidor(telemovel),
    
    CONSTRAINT fk_encomenda_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id),

    CONSTRAINT fk_encomenda_telemovel_transportadora
        FOREIGN KEY (telemovel_transportadora)
        REFERENCES transportadora(telemovel)
);