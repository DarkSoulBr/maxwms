-- Table: public.inventario

-- DROP TABLE public.inventario;

CREATE TABLE public.inventario
(
    invcodigo serial NOT NULL,
    procodigo integer,
    estcodigo integer,
    invdata timestamp with time zone,
    invantigo double precision,
    invatual double precision,
    CONSTRAINT invcodigo PRIMARY KEY (invcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.inventario
    OWNER to postgres;
-- Index: INV001

-- DROP INDEX public."INV001";

CREATE INDEX "INV001"
    ON public.inventario USING btree
    (procodigo ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: INV002

-- DROP INDEX public."INV002";

CREATE INDEX "INV002"
    ON public.inventario USING btree
    (estcodigo ASC NULLS LAST, invdata ASC NULLS LAST)
    TABLESPACE pg_default;
	
	
-- Table: public.setor

-- DROP TABLE public.setor;

CREATE TABLE public.setor
(
    setcodigo serial NOT NULL,
    setor character varying(30) COLLATE pg_catalog."default",
    codigosetor character varying(14) COLLATE pg_catalog."default",
    CONSTRAINT setcodigo PRIMARY KEY (setcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.setor
    OWNER to postgres;
	
-- Table: public.contagem

-- DROP TABLE public.contagem;

CREATE TABLE public.contagem
(
    contcodigo serial NOT NULL,
    contnome character varying(30) COLLATE pg_catalog."default",
    usucodigo integer,
    opcao integer,
    CONSTRAINT contcodigo PRIMARY KEY (contcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.contagem
    OWNER to postgres;
	
-- Table: public.inventariocontagem

-- DROP TABLE public.inventariocontagem;

CREATE TABLE public.inventariocontagem
(
    icocodigo serial NOT NULL,
    invdata timestamp with time zone,
    invstatus integer,
    CONSTRAINT icocodigo PRIMARY KEY (icocodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.inventariocontagem
    OWNER to postgres;
	
-- Table: public.inventariocontagemcon

-- DROP TABLE public.inventariocontagemcon;

CREATE TABLE public.inventariocontagemcon
(
    icccodigo serial NOT NULL,
    invdata timestamp with time zone,
    invstatus integer,
    concodigo integer,
    CONSTRAINT icccodigo PRIMARY KEY (icccodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.inventariocontagemcon
    OWNER to postgres;

-- Table: public.inventariocontagemsetor

-- DROP TABLE public.inventariocontagemsetor;

CREATE TABLE public.inventariocontagemsetor
(
    icscodigo serial NOT NULL,
    invdata timestamp with time zone,
    invstatus integer,
    setcodigo integer,
    concodigo integer,
    CONSTRAINT icscodigo PRIMARY KEY (icscodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.inventariocontagemsetor
    OWNER to postgres;
	
-- Table: public.inventariocontagemsetorproduto

-- DROP TABLE public.inventariocontagemsetorproduto;

CREATE TABLE public.inventariocontagemsetorproduto
(
    icpcodigo serial NOT NULL,
    invdata timestamp with time zone,
    setcodigo integer,
    concodigo integer,
    procodigo integer,
    quantidade double precision,
    colcodigo integer,
    CONSTRAINT icpcodigo PRIMARY KEY (icpcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.inventariocontagemsetorproduto
    OWNER to postgres;
-- Index: ICSP001

-- DROP INDEX public."ICSP001";

CREATE INDEX "ICSP001"
    ON public.inventariocontagemsetorproduto USING btree
    (procodigo ASC NULLS LAST, invdata ASC NULLS LAST, concodigo ASC NULLS LAST)
    TABLESPACE pg_default;