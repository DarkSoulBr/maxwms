-- Table: produtos

-- DROP TABLE produtos;

CREATE TABLE produtos
(
    PROCODIGO serial NOT NULL,
    CGCCLIWMS character varying(14),
    CODPROD character varying(30),
	NOMEPROD character varying(100),
	IWS_ERP integer,
	TPOLRET integer,
	IAUTODTVEN integer,
	QTDDPZOVEN integer,
	ILOTFAB integer,
	IDTFAB integer,
	IDTVEN integer,
	INSER integer,
	CODFAB character varying(20),
	NOMEFAB character varying(100),
	PRODATA timestamp with time zone,
    CONSTRAINT PROCODIGO PRIMARY KEY (PROCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE produtos
    OWNER to postgres;
	
	
-- Table: embalagens

-- DROP TABLE embalagens;

CREATE TABLE embalagens
(
    EMBCODIGO serial NOT NULL,
	PROCODIGO integer,
    CODUNID character varying(20),
	FATOR integer,
    CODBARRA character varying(30),
	PESOLIQ double precision,	
	PESOBRU double precision,
	ALT double precision,
	LAR double precision,
	COMP double precision,
	VOL double precision,
	IEMB_ENT integer,
	IEMB_SAI integer,
    CONSTRAINT EMBCODIGO PRIMARY KEY (EMBCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE embalagens
    OWNER to postgres;
	
	
-- Table: pedidos

-- DROP TABLE pedidos;

CREATE TABLE pedidos
(
    PEDCODIGO serial NOT NULL,
    CGCCLIWMS character varying(14),
	CGCEMINF character varying(14),
    OBSPED text,
	OBSROM text,
	NUMPEDCLI character varying(50),
	NUMPEDRCA character varying(50),
	VLTOTPED double precision,
	CGCDEST character varying(14),
	NOMEDEST character varying(100),
	CEPDEST character varying(8),
	UFDEST character varying(2),
	IBGEMUNDEST character varying(7),
	MUN_DEST character varying(100),
	BAIR_DEST character varying(100),
	LOGR_DEST character varying(100),
	NUM_DEST character varying(6),
	COMP_DEST character varying(50),
	TP_FRETE character varying(1),
	CODVENDEDOR character varying(20),
	NOMEVENDEDOR character varying(100),
	DTINCLUSAOERP timestamp with time zone,
	DTLIBERACAOERP timestamp with time zone,
	DTPREV_ENT_SITE timestamp with time zone,
	EMAILRASTRO character varying(200),	
	DDDRASTRO character varying(2),
	TELRASTRO character varying(50),
	PEDCANCELA timestamp with time zone,
	PEDDATA timestamp with time zone,
    CONSTRAINT PEDCODIGO PRIMARY KEY (PEDCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE pedidos
    OWNER to postgres;
	
-- Table: itens

-- DROP TABLE itens;

CREATE TABLE itens
(
    ITECODIGO serial NOT NULL,
	PEDCODIGO integer,
	NUMSEQ integer,
    CODPROD character varying(30),
	QTPROD integer,
    LOTFAB character varying(100),
    CONSTRAINT ITECODIGO PRIMARY KEY (ITECODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE itens
    OWNER to postgres;
	
	
-- Table: nfentrada

-- DROP TABLE nfentrada;

CREATE TABLE nfentrada
(
    NFECODIGO serial NOT NULL,
    CGCCLIWMS character varying(14),
	CGCREM character varying(14),    
	OBSRESDP character varying(100),
	TPDESTNF character varying(1),
	DEV character varying(1),
	NUMNF integer,
	SERIENF character varying(3),
	DTEMINF timestamp with time zone,
	VLTOTALNF double precision,	
	NUMEPEDCLI character varying(50),
	CHAVENF character varying(50),	
	NFEDATA timestamp with time zone,
    CONSTRAINT NFECODIGO PRIMARY KEY (NFECODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE nfentrada
    OWNER to postgres;
	
-- Table: nfeitens

-- DROP TABLE nfeitens;

CREATE TABLE nfeitens
(
    NFEITECODIGO serial NOT NULL,
	NFECODIGO integer,
	NUMSEQ integer,
    CODPROD character varying(30),
	QTPROD integer,
	VLTOTPROD double precision,	
    NUMPED_COMPRA character varying(50),
    CONSTRAINT NFEITECODIGO PRIMARY KEY (NFEITECODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE nfeitens
    OWNER to postgres;
	
	
-- Table: nfsaida

-- DROP TABLE nfsaida;

CREATE TABLE nfsaida
(
    NFSCODIGO serial NOT NULL,
    CGCCLIWMS character varying(14),
	CGCEMINF character varying(14),
	NUMPEDCLI character varying(50),
	NUMNF integer,
	SERIENF character varying(3),
	DTEMINF timestamp with time zone,
	VLTOTALNF double precision,
	QTVOL integer,
	CHAVE_NF character varying(50),	
	DANFEFILENAME character varying(200),
	DANFEFILESIZE integer,
	DANFEPDFBASE64 text,
	CGCTRANSP character varying(14),	
	NFSDATA timestamp with time zone,
    CONSTRAINT NFSCODIGO PRIMARY KEY (NFSCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE nfsaida
    OWNER to postgres;
	
-- Table: nfsitens

-- DROP TABLE nfsitens;

CREATE TABLE nfsitens
(
    NFSITECODIGO serial NOT NULL,
	NFSCODIGO integer,
	NUMSEQ integer,
    CODPROD character varying(30),
	QTPROD integer,
    CONSTRAINT NFSITECODIGO PRIMARY KEY (NFSITECODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE nfsitens
    OWNER to postgres;
	
	
-- Table: estoques

-- DROP TABLE estoques;

CREATE TABLE estoques
(
    ESTCODIGO serial NOT NULL,
    CD character varying(30),    
	FT integer,
	QC integer,
	QB integer,
	QF integer,
	ESTDATA timestamp with time zone,
    CONSTRAINT ESTCODIGO PRIMARY KEY (ESTCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE estoques
    OWNER to postgres;	
	
	
-- Table: recebto

-- DROP TABLE recebto;

CREATE TABLE recebto
(
    RECCODIGO serial NOT NULL,    
	CHAVE_NFE character varying(50),	
	RECDATA timestamp with time zone,
    CONSTRAINT RECCODIGO PRIMARY KEY (RECCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE recebto
    OWNER to postgres;
	
-- Table: recitens

-- DROP TABLE recitens;

CREATE TABLE recitens
(
    RECITECODIGO serial NOT NULL,
	RECCODIGO integer,
	NUMSEQ integer,
    CODPROD character varying(30),
	QTPROD integer,
	QTAVARIA integer,
	QTFALTA integer,
	LOTFAB character varying(100),
	DTFAB timestamp with time zone,
	DTVEN timestamp with time zone,
	NSER character varying(100),
    CONSTRAINT RECITECODIGO PRIMARY KEY (RECITECODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE recitens
    OWNER to postgres;	
	
-- Table: separacao

-- DROP TABLE separacao;

CREATE TABLE separacao
(
    SEPCODIGO serial NOT NULL,    
	CGCCLIWMS character varying(14),	
	NUMPEDCLI character varying(50),	
	ESPECIE character varying(50),	
	PESOVOL double precision,
	QTVOL integer,
	CGCTRANSP character varying(14),
	SEPDATA timestamp with time zone,
    CONSTRAINT SEPCODIGO PRIMARY KEY (SEPCODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE separacao
    OWNER to postgres;
	
-- Table: sepitens

-- DROP TABLE sepitens;

CREATE TABLE sepitens
(
    SEPITECODIGO serial NOT NULL,
	SEPCODIGO integer,
	NUMSEQ integer,
    CODPROD character varying(30),
	QTPROD integer,
	QTCONF integer,	
	LOTFAB character varying(100),
	DTFAB timestamp with time zone,
	DTVEN timestamp with time zone,
	NSER character varying(100),
    CONSTRAINT SEPITECODIGO PRIMARY KEY (SEPITECODIGO)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE sepitens
    OWNER to postgres;	