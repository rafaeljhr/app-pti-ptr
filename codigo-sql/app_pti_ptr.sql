CREATE TABLE tipo_de_conta (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL UNIQUE
);


CREATE TABLE utilizador (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  primeiro_nome VARCHAR(255) NOT NULL,
  ultimo_nome VARCHAR(255) NOT NULL,
  path_imagem VARCHAR(255) DEFAULT NULL,
  numero_telemovel VARCHAR(9) DEFAULT NULL,
  numero_contribuinte VARCHAR(9) DEFAULT NULL,
  morada VARCHAR(255) DEFAULT NULL,
  codigo_postal VARCHAR(255) DEFAULT NULL,
  cidade varchar(255) DEFAULT NULL,
  pais varchar(255) DEFAULT NULL,
  latitude VARCHAR(255) DEFAULT NULL,
  longitude VARCHAR(255) DEFAULT NULL,
  google_id varchar(255) DEFAULT NULL,
  tipo_de_conta INTEGER NOT NULL,
        
  CONSTRAINT fk_utilizador_tipo_de_conta
    FOREIGN KEY (tipo_de_conta)
    REFERENCES tipo_de_conta(id)
);


CREATE TABLE notificacoes (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_utilizador INTEGER NOT NULL,
  mensagem VARCHAR(255) NOT NULL,
  estado INTEGER NOT NULL,
        
  CONSTRAINT fk_notificacoes_id_utilizador
    FOREIGN KEY (id_utilizador) 
    REFERENCES utilizador(id)
);


CREATE TABLE admin (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL
	
	CONSTRAINT fk_admin_cargo
		FOREIGN KEY (cargo)
		REFERENCES cargo(cargo)
);


CREATE TABLE cargo (
    cargo VARCHAR(255) NOT NULL,

    CONSTRAINT pk_cargo
        PRIMARY KEY (cargo)
);


CREATE TABLE base (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  morada VARCHAR(255) DEFAULT NULL,
  codigo_postal VARCHAR(255) DEFAULT NULL,
  cidade varchar(255) DEFAULT NULL,
  pais varchar(255) DEFAULT NULL,
  latitude VARCHAR(255) DEFAULT NULL,
  longitude VARCHAR(255) DEFAULT NULL,
  nome VARCHAR(255) NOT NULL,
  id_transportadora INTEGER NOT NULL,
  path_imagem VARCHAR(255) NOT NULL,
		
  CONSTRAINT fk_base_id_transportadora
    FOREIGN KEY (id_transportadora) 
    REFERENCES utilizador(id)
);


CREATE TABLE tipo_combustivel (
  nome VARCHAR(255) NOT NULL,
  co2_por_km DECIMAL(10,2) DEFAULT NULL,
  kwh_por_km DECIMAL(10,2) DEFAULT NULL,
  
  CONSTRAINT pk_tipo_combustivel_nome
        PRIMARY KEY (nome)
);


CREATE TABLE veiculo (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_base INTEGER NOT NULL,
  id_transportadora INTEGER NOT NULL,
  nome VARCHAR(255) NOT NULL,
  quantidade VARCHAR(255) NOT NULL,
  tipoCombustivel VARCHAR(255) NOT NULL,
  consumo_por_100km VARCHAR(255) NOT NULL,
  path_imagem VARCHAR(255) NOT NULL,

    CONSTRAINT fk_metodo_transporte_id_base
        FOREIGN KEY (id_base) 
        REFERENCES base(id),
        
    CONSTRAINT fk_metodo_transporte_id_transportadora
        FOREIGN KEY (id_transportadora) 
        REFERENCES utilizador(id),
      
    CONSTRAINT fk_tipoCombustivel_id
        FOREIGN KEY (tipoCombustivel) 
        REFERENCES tipo_combustivel(nome)
);


CREATE TABLE armazem (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_fornecedor INTEGER NOT NULL,
  morada VARCHAR(255) NOT NULL,
  codigo_postal VARCHAR(255) DEFAULT NULL,
  cidade varchar(255) DEFAULT NULL,
  pais varchar(255) DEFAULT NULL,
  latitude VARCHAR(255) DEFAULT NULL,
  longitude VARCHAR(255) DEFAULT NULL,
  nome VARCHAR(255) NOT NULL,
  path_imagem VARCHAR(255) NOT NULL,

  CONSTRAINT fk_armazem_id_fornecedor
    FOREIGN KEY (id_fornecedor)
    REFERENCES utilizador(id)
);


CREATE TABLE categoria (
  nome VARCHAR(255) NOT NULL,
  
  CONSTRAINT pk_categoria_nome
        PRIMARY KEY (nome)
);


CREATE TABLE subcategoria (
  nome VARCHAR(255) NOT NULL,
  nome_categoria VARCHAR(255) NOT NULL,
  
  CONSTRAINT pk_subcategoria_nome
        PRIMARY KEY (nome),

    CONSTRAINT fk_subcategoria_nome_categoria
        FOREIGN KEY (nome_categoria)
        REFERENCES categoria(nome)
);


CREATE TABLE produto (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  id_armazem INTEGER NOT NULL,
  id_fornecedor INTEGER NOT NULL,
  quantidade INTEGER NOT NULL,
  nome_categoria VARCHAR(255) NOT NULL,
  nome_subcategoria VARCHAR(255) NOT NULL,
  path_imagem VARCHAR(255) NOT NULL,
  informacoes_adicionais VARCHAR(255) NOT NULL,
  data_producao_do_produto DATE NOT NULL,
  data_insercao_no_site DATE NOT NULL,
  kwh_consumidos_por_dia_no_armazem DECIMAL(10,2) NOT NULL,
  pronto_a_vender INTEGER NOT NULL,

    CONSTRAINT fk_armazem_id
        FOREIGN KEY (id_armazem)
        REFERENCES armazem(id),

    CONSTRAINT fk_produto_telemovel_nif
        FOREIGN KEY (id_fornecedor)
        REFERENCES utilizador(id),

    CONSTRAINT fk_produto_nome_categoria
        FOREIGN KEY (nome_categoria)
        REFERENCES categoria(nome),

    CONSTRAINT fk_produto_nome_subcategoria
        FOREIGN KEY (nome_subcategoria)
        REFERENCES subcategoria(nome)
);


CREATE TABLE categoria_campos_extra(
  campo_extra VARCHAR(255) NOT NULL,
  nome_categoria VARCHAR(255) NOT NULL,
  nome_campo_extra VARCHAR(255) NOT NULL,

  CONSTRAINT pk_categoria_campo_extra
        PRIMARY KEY (campo_extra),

    CONSTRAINT fk_categoria_campos_extra
        FOREIGN KEY (nome_categoria)
        REFERENCES categoria(nome)
);

CREATE TABLE produto_campos_extra(
  id_produto INTEGER NOT NULL,
  campo_extra VARCHAR(255) NOT NULL,
  valor_campo VARCHAR(255) NOT NULL,

  CONSTRAINT pk_produto_campos_extra
        PRIMARY KEY (id_produto, campo_extra),

    CONSTRAINT fk_campos_extra_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id),

    CONSTRAINT fk_categoria_campos_extra_produto
        FOREIGN KEY (campo_extra)
        REFERENCES categoria_campos_extra(campo_extra)
);


CREATE TABLE eventos_da_cadeia_logistica_do_produto (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  id_produto INTEGER NOT NULL,
  id_fornecedor INTEGER NOT NULL,
  nome VARCHAR(255) NOT NULL,
  poluicao_co2_produzida DECIMAL(10,2) DEFAULT NULL,
  kwh_consumidos DECIMAL(10,2) DEFAULT NULL,
  descricao_do_evento VARCHAR(255) NOT NULL,

    CONSTRAINT fk_eventos_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id)
        
    CONSTRAINT fk_encomenda_id_fornecedor
        FOREIGN KEY (id_fornecedor)
        REFERENCES utilizador(id),
);


CREATE TABLE estado_encomenda (
  nome VARCHAR(255) PRIMARY KEY
);


CREATE TABLE encomenda (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  preco DECIMAL(10,2) NOT NULL,
  preco_transporte DECIMAL(10,2) NOT NULL,
  morada VARCHAR(255) NOT NULL,
  codigo_postal VARCHAR(255) NOT NULL,
  cidade varchar(255) NOT NULL,
  pais varchar(255) NOT NULL,
  quantidade INTEGER NOT NULL,
  data_realizada DATETIME NOT NULL,
  data_finalizada DATETIME DEFAULT NULL,
  id_consumidor INTEGER NOT NULL,
  id_produto INTEGER NOT NULL,
  id_transportadora INTEGER NOT NULL,
  id_base INTEGER NOT NULL,
  id_fornecedor INTEGER NOT NULL,
  estado_encomenda VARCHAR(255) NOT NULL,

    CONSTRAINT fk_encomenda_id_consumidor
        FOREIGN KEY (id_consumidor)
        REFERENCES utilizador(id),
    
    CONSTRAINT fk_encomenda_id_produto
        FOREIGN KEY (id_produto)
        REFERENCES produto(id),

    CONSTRAINT fk_encomenda_id_transportadora
        FOREIGN KEY (id_transportadora)
        REFERENCES utilizador(id),
        
    CONSTRAINT fk_encomenda_id_base
        FOREIGN KEY (id_base)
        REFERENCES base(id),
       
    CONSTRAINT fk_encomenda_id_fornecedor
        FOREIGN KEY (id_fornecedor)
        REFERENCES utilizador(id),
        
    CONSTRAINT fk_encomenda_estado
        FOREIGN KEY (estado_encomenda)
        REFERENCES estado_encomenda(nome)
);
