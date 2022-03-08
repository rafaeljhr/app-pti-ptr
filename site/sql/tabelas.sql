DROP TABLE IF EXISTS transportadora;
DROP TABLE IF EXISTS base;
DROP TABLE IF EXISTS metodo_transporte;

DROP TABLE IF EXISTS consumidor;
DROP TABLE IF EXISTS encomenda;

DROP TABLE IF EXISTS produto;
DROP TABLE IF EXISTS recursos_consumidos;

DROP TABLE IF EXISTS subcategoria;
DROP TABLE IF EXISTS subcategoria;

DROP TABLE IF EXISTS fornecedor;



CREATE TABLE transportadora(
    telemovel VARCHAR(9) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    nif VARCHAR(9) NOT NULL UNIQUE,
    morada_fiscal VARCHAR(200) NOT NULL,

    CONSTRAINT pk_transportadora_telemovel
        PRIMARY KEY (telemovel)
);


CREATE TABLE base(
    morada VARCHAR(200) NOT NULL,
	telemovel VARCHAR(9) NOT NULL,

    CONSTRAINT pk_transportadora_morada
        PRIMARY KEY (morada),
		
	CONSTRAINT fk_base_telemovel_transportadora
        FOREIGN KEY (telemovel) 
        REFERENCES transportadora(telemovel)
);


CREATE TABLE metodo_transporte(

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


CREATE TABLE consumidor(
    nome VARCHAR(20) NOT NULL,
    telemovel VARCHAR(9) NOT NULL,
    NIF NUMERIC(9) NOT NULL UNIQUE,
    morada VARCHAR(200) NOT NULL,

    CONSTRAINT pk_consumidor_telemovel
        PRIMARY KEY (telemovel)
);


CREATE TABLE encomenda (
    id  integer NOT NULL AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    morada_de_entrega VARCHAR(200) NOT NULL,
    quantidade integer NOT NULL,
    data_realizada DATETIME NOT NULL,
    data_finalizada DATETIME,
    telemovel_consumidor integer NOT NULL,
    id_produto integer NOT NULL,

    CONSTRAINT pk_encomenda_id
        PRIMARY KEY (id),

    CONSTRAINT fk_encomenda_telemovel_consumidor
        FOREIGN KEY (telemovel_consumidor)
        REFERENCES consumidor(telemovel),
    
    CONSTRAINT fk_encomenda_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id)
);


CREATE TABLE produto (
    id  integer NOT NULL AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    data_produção_do_produto DATE NOT NULL,
    data_insercao_no_site DATE NOT NULL,
    poluicao_gerada_por_dia DECIMAL(10,2) NOT NULL, -- poluicao dioxido de carbono (gramas/cm3)
    info_arbitraria VARCHAR(300) NOT NULL,
    id_recursos_consumidos integer NOT NULL,
    id_armazem integer NOT NULL,
    id_fornecedor integer NOT NULL,
    id_categoria integer NOT NULL,
    id_subcategoria integer NOT NULL,

    CONSTRAINT pk_produto_id
        PRIMARY KEY (id),

    CONSTRAINT fk_recursos_consumidos_id
        FOREIGN KEY (id_recursos_consumidos)
        REFERENCES recursos_consumidos(id),

    CONSTRAINT fk_armazem_id
        FOREIGN KEY (id_armazem)
        REFERENCES armazem(id),

    CONSTRAINT fk_produto_id_fornecedor
        FOREIGN KEY (id_fornecedor)
        REFERENCES fornecedor(id),

    CONSTRAINT fk_produto_id_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categoria(id),

    CONSTRAINT fk_produto_id_subcategoria
        FOREIGN KEY (id_subcategoria)
        REFERENCES subcategoria(id)
);










CREATE TABLE recursos_consumidos (
	id integer NOT NULL AUTO_INCREMENT,
    nome_do_recurso VARCHAR(100) NOT NULL,
    quantidade integer NOT NULL,
	
    CONSTRAINT pk_armazem_id
    PRIMARY KEY (id)
);


CREATE TABLE subcategoria (
    id integer NOT NULL AUTO_INCREMENT,
    subcategoria VARCHAR(30) NOT NULL,
    id_categoria integer NOT NULL,

--

    CONSTRAINT pk_subcategoria_id
        PRIMARY KEY (id),

-- 

    CONSTRAINT fk_subcategoria_id_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categoria(id)

);

CREATE TABLE categoria (
    id integer NOT NULL AUTO_INCREMENT,
    categoria VARCHAR(30) NOT NULL,

--

    CONSTRAINT pk_categoria_id
        PRIMARY KEY (id)

);

CREATE TABLE armazem (
	id  integer NOT NULL AUTO_INCREMENT,
    morada VARCHAR(100) NOT NULL,
    recursos_consumidos DECIMAL(10, 2) NOT NULL,
	
	    CONSTRAINT pk_armazem_id
        PRIMARY KEY (id)
);



CREATE TABLE fornecedor (
    id integer NOT NULL AUTO_INCREMENT,
    morada VARCHAR(100) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    NIF VARCHAR(9) NOT NULL UNIQUE,
    telemovel VARCHAR(9) NOT NULL UNIQUE,
    recursos_consumidos DECIMAL(10, 2) NOT NULL,

--

    CONSTRAINT pk_fornecedor_id
        PRIMARY KEY (id)
);

CREATE TABLE cesto (
    id integer NOT NULL  AUTO_INCREMENT,
    quantidade INTEGER(10) NOT NULL,
    id_produto integer NOT NULL,
    id_encomenda integer NOT NULL,

--

    CONSTRAINT pk_cesto_id
        PRIMARY KEY (id, id_produto),

--

    CONSTRAINT fk_cesto_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id),

--

    CONSTRAINT fk_cesto_id_encomenda
        FOREIGN KEY (id_encomenda)
        REFERENCES encomenda(id)

);