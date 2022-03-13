DROP TABLE IF EXISTS encomenda;
DROP TABLE IF EXISTS recursos_consumidos;
DROP TABLE IF EXISTS eventos_da_cadeia_logistica_do_produto;
DROP TABLE IF EXISTS produto;
DROP TABLE IF EXISTS subcategoria;
DROP TABLE IF EXISTS categoria;
DROP TABLE IF EXISTS armazem;
DROP TABLE IF EXISTS fornecedor;
DROP TABLE IF EXISTS consumidor;
DROP TABLE IF EXISTS metodo_transporte;
DROP TABLE IF EXISTS base;
DROP TABLE IF EXISTS transportadora;


CREATE TABLE transportadora (
    id integer AUTO_INCREMENT,
    telefone VARCHAR(9) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    nif VARCHAR(9) NOT NULL UNIQUE,
    morada_fiscal VARCHAR(200) NOT NULL,

    CONSTRAINT pk_transportadora_id
        PRIMARY KEY (id)
);


CREATE TABLE base (
    id integer AUTO_INCREMENT,
    morada VARCHAR(200) NOT NULL,
    telefone VARCHAR(9) NOT NULL UNIQUE,
	transportadora_id integer NOT NULL,

    CONSTRAINT pk_base_id
        PRIMARY KEY (id),
		
	CONSTRAINT fk_base_id_transportadora
        FOREIGN KEY (transportadora_id) 
        REFERENCES transportadora(id)
);


CREATE TABLE metodo_transporte (
    id integer AUTO_INCREMENT,
    base_id integer NOT NULL,
    nome VARCHAR(200) NOT NULL, 
    consumo NUMERIC NOT NULL,
    tipoCombustivel VARCHAR(200) NOT NULL,

    CONSTRAINT pk_metodo_transporte_id
        PRIMARY KEY (id),

    CONSTRAINT fk_metodo_transporte_base_id
        FOREIGN KEY (base_id) 
        REFERENCES base(id)
);


CREATE TABLE consumidor (
    id integer AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    telemovel VARCHAR(9) NOT NULL UNIQUE,
    nif NUMERIC(9) NOT NULL,
    morada VARCHAR(200) NOT NULL,

    CONSTRAINT pk_consumidor_id
        PRIMARY KEY (id)
);


CREATE TABLE fornecedor (
    id integer AUTO_INCREMENT,
    morada_fiscal VARCHAR(200) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    nif VARCHAR(9) NOT NULL,
    telemovel VARCHAR(9) NOT NULL UNIQUE,

    CONSTRAINT pk_fornecedor_id
        PRIMARY KEY (id)
);


CREATE TABLE armazem (
	id integer AUTO_INCREMENT,
    morada VARCHAR(200) NOT NULL,
    recursos_consumidos_por_dia DECIMAL(10, 2) NOT NULL,
    id_fornecedor integer,
	
    CONSTRAINT pk_armazem_id
    PRIMARY KEY (id),

    CONSTRAINT fk_armazem_id_fornecedor
        FOREIGN KEY (id_fornecedor)
        REFERENCES fornecedor(id)
);


CREATE TABLE categoria (
    nome VARCHAR(200),

    CONSTRAINT pk_categoria_nome
        PRIMARY KEY (nome)
);


CREATE TABLE subcategoria (
    nome VARCHAR(200) NOT NULL,
    nome_categoria VARCHAR(200) NOT NULL,

    CONSTRAINT pk_subcategoria_nome
        PRIMARY KEY (nome),

    CONSTRAINT fk_subcategoria_nome_categoria
        FOREIGN KEY (nome_categoria)
        REFERENCES categoria(nome)
);


CREATE TABLE produto (
    id integer AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    nome VARCHAR(200) NOT NULL,
    data_produção_do_produto DATE NOT NULL,
    data_insercao_no_site DATE NOT NULL,
    -- poluicao dioxido de carbono (gramas/cm3)
    poluicao_gerada_por_dia DECIMAL(10,2) NOT NULL,
    info_arbitraria VARCHAR(255) NOT NULL,
    id_armazem integer NOT NULL,
    id_fornecedor integer NOT NULL,
    nome_categoria VARCHAR(200) NOT NULL,
    nome_subcategoria VARCHAR(200) NOT NULL,

    CONSTRAINT pk_produto_id
        PRIMARY KEY (id),

    CONSTRAINT fk_armazem_id
        FOREIGN KEY (id_armazem)
        REFERENCES armazem(id),

    CONSTRAINT fk_produto_telemovel_nif
        FOREIGN KEY (id_fornecedor)
        REFERENCES fornecedor(id),

    CONSTRAINT fk_produto_nome_categoria
        FOREIGN KEY (nome_categoria)
        REFERENCES categoria(nome),

    CONSTRAINT fk_produto_nome_subcategoria
        FOREIGN KEY (nome_subcategoria)
        REFERENCES subcategoria(nome)
);


CREATE TABLE eventos_da_cadeia_logistica_do_produto (
    id integer AUTO_INCREMENT,
    poluicao_gerada DECIMAL(10,2) NOT NULL,
    descricao_do_evento VARCHAR(255) NOT NULL,
    id_produto integer NOT NULL,

    CONSTRAINT pk_cadeia_logistica_produto_id
        PRIMARY KEY (id),

    CONSTRAINT fk_eventos_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id)
);


CREATE TABLE recursos_consumidos (
    id integer AUTO_INCREMENT,
    nome_do_recurso VARCHAR(200) NOT NULL,
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
    id integer AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    morada_de_entrega VARCHAR(200) NOT NULL,
    quantidade integer NOT NULL,
    data_realizada DATETIME NOT NULL,
    data_finalizada DATETIME,
    id_consumidor integer NOT NULL,
    id_produto integer NOT NULL,
    id_transportadora integer NOT NULL,

    CONSTRAINT pk_encomenda_id
        PRIMARY KEY (id),

    CONSTRAINT fk_encomenda_id_consumidor
        FOREIGN KEY (id_consumidor)
        REFERENCES consumidor(id),
    
    CONSTRAINT fk_encomenda_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id),

    CONSTRAINT fk_encomenda_id_transportadora
        FOREIGN KEY (id_transportadora)
        REFERENCES transportadora(id)
);