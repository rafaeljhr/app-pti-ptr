DROP TABLE IF EXISTS transportadora;
DROP TABLE IF EXISTS metodo_transporte;
DROP TABLE IF EXISTS cliente;
DROP TABLE IF EXISTS subcategoria;
DROP TABLE IF EXISTS categoria;
DROP TABLE IF EXISTS produto;
DROP TABLE IF EXISTS fornecedor;
DROP TABLE IF EXISTS cesto;
DROP TABLE IF EXISTS encomenda;


CREATE TABLE transportadora(
    id_trans integer NOT NULL AUTO_INCREMENT,
    telemovel VARCHAR(9) NOT NULL,
    nome VARCHAR(20) NOT NULL,
    NIF VARCHAR(9) NOT NULL UNIQUE,
    morada VARCHAR(100) NOT NULL,

    CONSTRAINT pk_transportadora_id_trans
        PRIMARY KEY (id_trans),
)

CREATE TABLE base(
    id integer NOT NULL AUTO_INCREMENT,
    telemovel VARCHAR(9) NOT NULL,
    NIF VARCHAR(9) NOT NULL UNIQUE,
    morada VARCHAR(100) NOT NULL,
	id_trans INTEGER NOT NULL,

    CONSTRAINT pk_transportadora_id_trans
        PRIMARY KEY (id),
		
	CONSTRAINT fk_base_id_transportadora
        FOREIGN KEY (id_trans) 
        REFERENCES transportadora(id_trans),
)

CREATE TABLE metodo_transporte(

    id_metodo_t integer NOT NULL AUTO_INCREMENT,
    id_base integer NOT NULL,
    nome VARCHAR(20) NOT NULL, 
    consumo NUMERIC NOT NULL,
    tipoCombustivel VARCHAR(20) NOT NULL,

    CONSTRAINT pk_metodo_transporte_id_metodo_t
        PRIMARY KEY (id_metodo_t),

    CONSTRAINT fk_metodo_transporte_id_base
        FOREIGN KEY (id_base) 
        REFERENCES base(id),

)

CREATE TABLE cliente(
    nome VARCHAR(20) NOT NULL,
    id integer NOT NULL AUTO_INCREMENT,
    telemovel VARCHAR(9) NOT NULL UNIQUE,
    NIF NUMERIC(9) NOT NULL UNIQUE,

    CONSTRAINT pk_cliente_id_cliente
        PRIMARY KEY (id),
)


CREATE TABLE subcategoria (
    id  integer NOT NULL AUTO_INCREMENT,
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
    id  integer NOT NULL AUTO_INCREMENT,
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

CREATE TABLE produto (
    id  integer NOT NULL AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    nome VARCHAR(30) NOT NULL,
    data_produção DATE NOT NULL,
    -- Nao sei quais as unidades de poluicao e recursos, corrigir depois!
    poluicao_gerada DECIMAL(10,2) NOT NULL, 
    recursos_consumidos DECIMAL(10, 2) NOT NULL,
    lote integer(10) NOT NULL,
    id_armazem integer NOT NULL,
    id_fornecedor integer NOT NULL,

--

    CONSTRAINT pk_produto_id
        PRIMARY KEY (id),

--

    CONSTRAINT fk_produto_id_fornecedor
        FOREIGN KEY (id_fornecedor)
        REFERENCES fornecedor(id)

--
/* ERRO NO DIAGRAMA?
    CONSTRAINT fk_produto_id_armazem
        FOREIGN KEY (id_armazem)
        REFERENCES armazem(id)
*/
);

CREATE TABLE fornecedor (
    id  integer NOT NULL AUTO_INCREMENT,
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

CREATE TABLE encomenda (
    id  integer NOT NULL AUTO_INCREMENT,
    preco DECIMAL(10, 2) NOT NULL,
    morada VARCHAR(100) NOT NULL,
    estado VARCHAR(30) NOT NULL,
    -- Gastos do que?
    gastos NUMERIC(10) NOT NULL,
    data_realizada DATE NOT NULL,
    data_recolha DATE,
    data_entrega DATE,
    id_cesto integer NOT NULL,
    id_cliente integer NOT NULL,
	id_base integer NOT NULL,

--

    CONSTRAINT pk_encomenda_id
        PRIMARY KEY (id),

--

    CONSTRAINT fk_encomenda_id_cesto
        FOREIGN KEY (id_cesto)
        REFERENCES cesto(id),

--

    CONSTRAINT fk_encomenda_id_cliente
        FOREIGN KEY (id_cliente)
        REFERENCES cliente(id)
		
	CONSTRAINT fk_encomenda_id_base
        FOREIGN KEY (id_base)
        REFERENCES base(id)

);