-- Restaurar o tipobaixa
-- Restaurar o natureza
-- Gerar as Tabelas de Movimentação de 2022

-- Table: public.pcompra

-- DROP TABLE public.pcompra;

CREATE TABLE public.pcompra
(
    pcnumero integer NOT NULL,
    forcodigo integer,
    pcemissao timestamp with time zone,
    tracodigo integer,
    comprador character varying(15) COLLATE pg_catalog."default",
    condicao character varying(30) COLLATE pg_catalog."default",
    aviso character varying(1) COLLATE pg_catalog."default",
    total double precision,
    ipi double precision,
    desconto double precision,
    perdesconto double precision,
    observacao1 character varying(70) COLLATE pg_catalog."default",
    observacao2 character varying(70) COLLATE pg_catalog."default",
    observacao3 character varying(70) COLLATE pg_catalog."default",
    comissao double precision,
    parcela integer,
    tipo integer,
    usuario character varying(3) COLLATE pg_catalog."default",
    pcentrega timestamp with time zone,
    localentrega character varying(1) COLLATE pg_catalog."default",
    tipoparcelas integer,
    parcelas integer,
    parcela1 double precision,
    parcela2 double precision,
    parcela3 double precision,
    parcela4 double precision,
    parcela5 double precision,
    parcela6 double precision,
    parcdata1 timestamp with time zone,
    parcdata2 timestamp with time zone,
    parcdata3 timestamp with time zone,
    parcdata4 timestamp with time zone,
    parcdata5 timestamp with time zone,
    parcdata6 timestamp with time zone,
    parcdia1 integer,
    parcdia2 integer,
    parcdia3 integer,
    parcdia4 integer,
    parcdia5 integer,
    parcdia6 integer,
    observacao4 character varying(70) COLLATE pg_catalog."default",
    observacao5 character varying(70) COLLATE pg_catalog."default",
    tipoped integer,
    pvnumero integer,
    palmcodigo integer,
    serie integer,
    pcprocesso character varying(30) COLLATE pg_catalog."default",
    pcchegada timestamp with time zone,
    pccontainers integer,
    pcempresa integer,
    CONSTRAINT pcnumero PRIMARY KEY (pcnumero)
)

TABLESPACE pg_default;

ALTER TABLE public.pcompra
    OWNER to postgres;
	
	
-- Table: public.condicaopagto

-- DROP TABLE public.condicaopagto;

CREATE TABLE public.condicaopagto
(
    cpgcodigo serial NOT NULL,
    forcodigo integer,
    desc1 double precision,
    desc2 double precision,
    desc3 double precision,
    desc4 double precision,
    desc5 double precision,
    desc6 double precision,
    ipi double precision,
    comissao double precision,
    icm double precision,
    tipo integer,
    parcelas integer,
    tipoparcelas integer,
    parcdata1 timestamp with time zone,
    parcdata2 timestamp with time zone,
    parcdata3 timestamp with time zone,
    parcdata4 timestamp with time zone,
    parcdata5 timestamp with time zone,
    parcdata6 timestamp with time zone,
    parcdia1 integer,
    parcdia2 integer,
    parcdia3 integer,
    parcdia4 integer,
    parcdia5 integer,
    parcdia6 integer,
    CONSTRAINT cpgcodigo PRIMARY KEY (cpgcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.condicaopagto
    OWNER to postgres;
	
-- Table: public.pcitem

-- DROP TABLE public.pcitem;

CREATE TABLE public.pcitem
(
    pcicodigo serial NOT NULL,
    pcnumero integer,
    pcitem smallint,
    procodigo integer,
    pcipreco double precision,
    pcisaldo double precision,
    pcibaixa double precision,
    parcela smallint,
    desc1 double precision,
    desc2 double precision,
    desc3 double precision,
    desc4 double precision,
    ipi double precision,
    pcentrega timestamp with time zone,
    loja double precision,
    lojan double precision,
    CONSTRAINT pcicodigo PRIMARY KEY (pcicodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.pcitem
    OWNER to postgres;
	
	
-- Table: public.notaent

-- DROP TABLE public.notaent;

CREATE TABLE public.notaent
(
    notentcodigo serial NOT NULL,
    pcnumero integer,
    notentdata timestamp with time zone,
    notentemissao timestamp with time zone,
    notentnumero character varying(10) COLLATE pg_catalog."default",
    notentcpof character varying(10) COLLATE pg_catalog."default",
    notentvalor double precision,
    notentprodutos double precision,
    notenticm double precision,
    notentbaseicm double precision,
    notentvaloricm double precision,
    notentisentas double precision,
    notentoutras double precision,
    notentbaseipi double precision,
    notentpercipi double precision,
    notentvaloripi double precision,
    notentseqbaixa integer,
    notentobservacoes text COLLATE pg_catalog."default",
    notentvolumes integer,
    notentp1 character varying(1) COLLATE pg_catalog."default",
    notentp2 character varying(1) COLLATE pg_catalog."default",
    notentp3 character varying(1) COLLATE pg_catalog."default",
    notentp4 character varying(1) COLLATE pg_catalog."default",
    notentp5 character varying(1) COLLATE pg_catalog."default",
    notentp6 character varying(1) COLLATE pg_catalog."default",
    notentp7 character varying(1) COLLATE pg_catalog."default",
    notentp8 character varying(1) COLLATE pg_catalog."default",
    notentp9 character varying(1) COLLATE pg_catalog."default",
    notentp10 character varying(1) COLLATE pg_catalog."default",
    notentp11 character varying(1) COLLATE pg_catalog."default",
    notentp12 character varying(1) COLLATE pg_catalog."default",
    notentp13 character varying(1) COLLATE pg_catalog."default",
    notentp14 character varying(1) COLLATE pg_catalog."default",
    notentp15 character varying(1) COLLATE pg_catalog."default",
    notentp16 character varying(1) COLLATE pg_catalog."default",
    notentp17 character varying(1) COLLATE pg_catalog."default",
    notentp18 character varying(1) COLLATE pg_catalog."default",
    notentp19 character varying(1) COLLATE pg_catalog."default",
    notentp20 character varying(1) COLLATE pg_catalog."default",
    notentp21 character varying(1) COLLATE pg_catalog."default",
    notentp22 character varying(1) COLLATE pg_catalog."default",
    notentp23 character varying(1) COLLATE pg_catalog."default",
    notatualiza character varying(1) COLLATE pg_catalog."default",
    notentserie character varying(3) COLLATE pg_catalog."default",
    outrasipi double precision,
    notentp24 character varying(1) COLLATE pg_catalog."default",
    notentp25 character varying(1) COLLATE pg_catalog."default",
    notentp26 character varying(1) COLLATE pg_catalog."default",
    notentp27 character varying(1) COLLATE pg_catalog."default",
    notentp28 character varying(1) COLLATE pg_catalog."default",
    notentp29 character varying(1) COLLATE pg_catalog."default",
    notentp30 character varying(1) COLLATE pg_catalog."default",
    notentp31 character varying(1) COLLATE pg_catalog."default",
    notentp32 character varying(1) COLLATE pg_catalog."default",
    notentp33 character varying(1) COLLATE pg_catalog."default",
    notentp34 character varying(1) COLLATE pg_catalog."default",
    hinicio character varying(5) COLLATE pg_catalog."default",
    hfinal character varying(5) COLLATE pg_catalog."default",
    ainicio character varying(5) COLLATE pg_catalog."default",
    afinal character varying(5) COLLATE pg_catalog."default",
    referencia character varying(20) COLLATE pg_catalog."default",
    prazo timestamp with time zone,
    observacao text COLLATE pg_catalog."default",
    notexporta timestamp with time zone,
    parcelasr integer,
    tipoparcelasr integer,
    parcela1r double precision,
    parcela2r double precision,
    parcela3r double precision,
    parcela4r double precision,
    parcela5r double precision,
    parcela6r double precision,
    parcdata1r timestamp with time zone,
    parcdata2r timestamp with time zone,
    parcdata3r timestamp with time zone,
    parcdata4r timestamp with time zone,
    parcdata5r timestamp with time zone,
    parcdata6r timestamp with time zone,
    parcdia1r integer,
    parcdia2r integer,
    parcdia3r integer,
    parcdia4r integer,
    parcdia5r integer,
    parcdia6r integer,
    parcelasf integer,
    tipoparcelasf integer,
    parcela1f double precision,
    parcela2f double precision,
    parcela3f double precision,
    parcela4f double precision,
    parcela5f double precision,
    parcela6f double precision,
    parcdata1f timestamp with time zone,
    parcdata2f timestamp with time zone,
    parcdata3f timestamp with time zone,
    parcdata4f timestamp with time zone,
    parcdata5f timestamp with time zone,
    parcdata6f timestamp with time zone,
    parcdia1f integer,
    parcdia2f integer,
    parcdia3f integer,
    parcdia4f integer,
    parcdia5f integer,
    parcdia6f integer,
    notenttcr double precision,
    notenttcf double precision,
    notenttipo integer,
    notentobs text COLLATE pg_catalog."default",
    deposito integer,
    notcfopsubs character varying(10) COLLATE pg_catalog."default",
    notbasesubst double precision,
    notvalorsubst double precision,
    notperciva double precision,
    parcelass integer,
    tipoparcelass integer,
    parcdia1s integer,
    parcdia2s integer,
    parcdia3s integer,
    parcdia4s integer,
    parcdia5s integer,
    parcdia6s integer,
    notenttst double precision,
    parcela1s double precision,
    parcela2s double precision,
    parcela3s double precision,
    parcela4s double precision,
    parcela5s double precision,
    parcela6s double precision,
    parcdata1s timestamp with time zone,
    parcdata2s timestamp with time zone,
    parcdata3s timestamp with time zone,
    parcdata4s timestamp with time zone,
    parcdata5s timestamp with time zone,
    parcdata6s timestamp with time zone,
    reducao double precision,
    chave character varying(44) COLLATE pg_catalog."default",
    notatualizadata timestamp with time zone,
    gerawms integer,
    usuario integer,
    tipobaixa integer,
    CONSTRAINT notentcodigo PRIMARY KEY (notentcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.notaent
    OWNER to postgres;
	
-- Table: public.neitem

-- DROP TABLE public.neitem;

CREATE TABLE public.neitem
(
    neicodigo serial NOT NULL,
    nenumero integer,
    neiitem smallint,
    procodigo integer,
    neisaldo double precision,
    neipreco double precision,
    neipercicm real,
    neipercipi real,
    neserie character varying(3) COLLATE pg_catalog."default",
    notentcodigo integer,
    estfisico character varying(20) COLLATE pg_catalog."default",
    neireal double precision,
    neiipi double precision,
    neidesc1 double precision,
    neidesc2 double precision,
    neidesc3 double precision,
    neidesc4 double precision,
    iva double precision,
    st character varying(1) COLLATE pg_catalog."default",
    valornf double precision,
    total double precision,
    valorst double precision,
    totalreal double precision,
    neianterior double precision,
    neinovo double precision,
    neiprecob double precision,
    neiprecoc double precision,
    neilocal smallint,
    CONSTRAINT neicodigo PRIMARY KEY (neicodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.neitem
    OWNER to postgres;
-- Index: neitem01

-- DROP INDEX public.neitem01;

CREATE INDEX neitem01
    ON public.neitem USING btree
    (notentcodigo ASC NULLS LAST, procodigo ASC NULLS LAST)
    TABLESPACE pg_default;
	
-- Table: public.tipobaixa

-- DROP TABLE public.tipobaixa;

CREATE TABLE public.tipobaixa
(
    tbcodigo serial NOT NULL,
    descricao character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT tbcodigo PRIMARY KEY (tbcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.tipobaixa
    OWNER to postgres;
	
-- Table: public.nfe

-- DROP TABLE public.nfe;

CREATE TABLE public.nfe
(
    nfecodigo serial NOT NULL,
    nfeserie character varying(3) COLLATE pg_catalog."default",
    nfenumero double precision,
    nfecnpj character varying(14) COLLATE pg_catalog."default",
    nfeuf character varying(2) COLLATE pg_catalog."default",
    nfenf double precision,
    nfenatop character varying(50) COLLATE pg_catalog."default",
    nfeindpag character varying(1) COLLATE pg_catalog."default",
    nfemod character varying(2) COLLATE pg_catalog."default",
    nfedemi character varying(10) COLLATE pg_catalog."default",
    nfedsaient character varying(10) COLLATE pg_catalog."default",
    nfetpnf character varying(1) COLLATE pg_catalog."default",
    nfecmunfg character varying(7) COLLATE pg_catalog."default",
    nfetpimp character varying(1) COLLATE pg_catalog."default",
    nfetpemis character varying(1) COLLATE pg_catalog."default",
    nfecdv character varying(1) COLLATE pg_catalog."default",
    nfetpamb character varying(1) COLLATE pg_catalog."default",
    nfefinnfe character varying(1) COLLATE pg_catalog."default",
    nfeprocemi character varying(1) COLLATE pg_catalog."default",
    nfeverproc character varying(50) COLLATE pg_catalog."default",
    nfeemixnome character varying(100) COLLATE pg_catalog."default",
    nfeemixfant character varying(30) COLLATE pg_catalog."default",
    nfeemixlgr character varying(100) COLLATE pg_catalog."default",
    nfeeminro character varying(100) COLLATE pg_catalog."default",
    nfeemixbairro character varying(50) COLLATE pg_catalog."default",
    nfeemicmun character varying(7) COLLATE pg_catalog."default",
    nfeemixmun character varying(50) COLLATE pg_catalog."default",
    nfeemiuf character varying(2) COLLATE pg_catalog."default",
    nfeemicep character varying(8) COLLATE pg_catalog."default",
    nfeemicpais character varying(4) COLLATE pg_catalog."default",
    nfeemixpais character varying(50) COLLATE pg_catalog."default",
    nfeemiie character varying(20) COLLATE pg_catalog."default",
    nfedescnpj character varying(14) COLLATE pg_catalog."default",
    nfedesxnome character varying(100) COLLATE pg_catalog."default",
    nfedesxlgr character varying(100) COLLATE pg_catalog."default",
    nfedesnro character varying(100) COLLATE pg_catalog."default",
    nfedesxbairro character varying(50) COLLATE pg_catalog."default",
    nfedescmun character varying(7) COLLATE pg_catalog."default",
    nfedesxmun character varying(50) COLLATE pg_catalog."default",
    nfedesuf character varying(2) COLLATE pg_catalog."default",
    nfedescep character varying(8) COLLATE pg_catalog."default",
    nfedescpais character varying(4) COLLATE pg_catalog."default",
    nfedesxpais character varying(50) COLLATE pg_catalog."default",
    nfedesfone character varying(20) COLLATE pg_catalog."default",
    nfedesie character varying(20) COLLATE pg_catalog."default",
    nfeentcnpj character varying(14) COLLATE pg_catalog."default",
    nfeentxlgr character varying(100) COLLATE pg_catalog."default",
    nfeentnro character varying(100) COLLATE pg_catalog."default",
    nfeentxbairro character varying(50) COLLATE pg_catalog."default",
    nfeentcmun character varying(7) COLLATE pg_catalog."default",
    nfeentxmun character varying(50) COLLATE pg_catalog."default",
    nfeentuf character varying(2) COLLATE pg_catalog."default",
    nfevbc double precision,
    nfevicms double precision,
    nfevbcst double precision,
    nfevst double precision,
    nfevprod double precision,
    nfevfrete double precision,
    nfevseg double precision,
    nfevdesc double precision,
    nfevii double precision,
    nfevipi double precision,
    nfevpis double precision,
    nfevcofins double precision,
    nfevoutro double precision,
    nfevnf double precision,
    nfetramodfrete character varying(1) COLLATE pg_catalog."default",
    nfetracnpj character varying(14) COLLATE pg_catalog."default",
    nfetraxnome character varying(100) COLLATE pg_catalog."default",
    nfetraxender character varying(100) COLLATE pg_catalog."default",
    nfetraxmun character varying(50) COLLATE pg_catalog."default",
    nfetrauf character varying(2) COLLATE pg_catalog."default",
    nfetraqvol double precision,
    nfetraesp character varying(20) COLLATE pg_catalog."default",
    nfetramarca character varying(20) COLLATE pg_catalog."default",
    nfetranvol character varying(20) COLLATE pg_catalog."default",
    nfenfat character varying(20) COLLATE pg_catalog."default",
    nfevorig double precision,
    nfevliq double precision,
    nfeinfcpl text COLLATE pg_catalog."default",
    CONSTRAINT nfecodigox PRIMARY KEY (nfecodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.nfe
    OWNER to postgres;
	
-- Table: public.nfedp

-- DROP TABLE public.nfedp;

CREATE TABLE public.nfedp
(
    nfedpcodigo serial NOT NULL,
    nfecodigo integer,
    nfedpval double precision,
    nfedpdup character varying(20) COLLATE pg_catalog."default",
    nfedpvec character varying(10) COLLATE pg_catalog."default",
    CONSTRAINT nfedpcodigo PRIMARY KEY (nfedpcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.nfedp
    OWNER to postgres;
	
-- Table: public.nfeit

-- DROP TABLE public.nfeit;

CREATE TABLE public.nfeit
(
    nfeitcodigo serial NOT NULL,
    nfecodigo integer,
    nfeitquant double precision,
    procodigo integer,
    nfeprod character varying(30) COLLATE pg_catalog."default",
    nfexprod character varying(100) COLLATE pg_catalog."default",
    nfencm character varying(8) COLLATE pg_catalog."default",
    nfeextipi character varying(3) COLLATE pg_catalog."default",
    nfecfop character varying(4) COLLATE pg_catalog."default",
    nfeucom character varying(10) COLLATE pg_catalog."default",
    nfevuncom double precision,
    nfevprod double precision,
    nfecean character varying(14) COLLATE pg_catalog."default",
    nfeceantrib character varying(14) COLLATE pg_catalog."default",
    nfeutrib character varying(10) COLLATE pg_catalog."default",
    nfeqtrib double precision,
    nfevuntrib double precision,
    nfeticms character varying(2) COLLATE pg_catalog."default",
    nfeorig character varying(1) COLLATE pg_catalog."default",
    nfecst character varying(2) COLLATE pg_catalog."default",
    nfemodbc character varying(2) COLLATE pg_catalog."default",
    nfepredbc double precision,
    nfevbc double precision,
    nfepicms double precision,
    nfevicms double precision,
    nfemodbcst character varying(2) COLLATE pg_catalog."default",
    nfepmvast double precision,
    nfepredbcst double precision,
    nfevbcst double precision,
    nfepicmsst double precision,
    nfevicmsst double precision,
    nfeipicenq character varying(3) COLLATE pg_catalog."default",
    nfeipicst character varying(2) COLLATE pg_catalog."default",
    nfeipivbc double precision,
    nfeipipipi double precision,
    nfeipivipi double precision,
    nfepiscst character varying(2) COLLATE pg_catalog."default",
    nfepisvbc double precision,
    nfepisppis double precision,
    nfepisvpis double precision,
    nfecofcst character varying(2) COLLATE pg_catalog."default",
    nfecofvbc double precision,
    nfecofpcofins double precision,
    nfecofvcofins double precision,
    nfevdesc double precision,
    CONSTRAINT nfeitcodigo PRIMARY KEY (nfeitcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.nfeit
    OWNER to postgres;
	
-- Table: public.natureza

-- DROP TABLE public.natureza;

CREATE TABLE public.natureza
(
    natcodigo serial NOT NULL,
    natdescr character varying(40) COLLATE pg_catalog."default" NOT NULL,
    nattipo character varying(1) COLLATE pg_catalog."default",
    usucodigo integer,
    observacao1 character varying(100) COLLATE pg_catalog."default",
    observacao2 character varying(100) COLLATE pg_catalog."default",
    observacao3 character varying(100) COLLATE pg_catalog."default",
    observacao4 character varying(100) COLLATE pg_catalog."default",
    observacao5 character varying(100) COLLATE pg_catalog."default",
    natcod character varying(6) COLLATE pg_catalog."default",
    natipi smallint,
    natpis double precision,
    natcofins double precision,
    natdev smallint,
    natcst character varying(3) COLLATE pg_catalog."default",
    natfec integer,
    CONSTRAINT natcodigo PRIMARY KEY (natcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.natureza
    OWNER to postgres;


-- Table: public.estoqueatual

-- DROP TABLE public.estoqueatual;

CREATE TABLE public.estoqueatual
(
    etqatualcodigo serial NOT NULL,
    procodigo integer,
    estqtd integer,
    codestoque integer,
    usucodigo integer,
    CONSTRAINT etqatualcodigo PRIMARY KEY (etqatualcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.estoqueatual
    OWNER to postgres;
-- Index: ESTOQUEATUAL001

-- DROP INDEX public."ESTOQUEATUAL001";

CREATE INDEX "ESTOQUEATUAL001"
    ON public.estoqueatual USING btree
    (procodigo ASC NULLS LAST, codestoque ASC NULLS LAST)
    TABLESPACE pg_default;
	
-- Table: public.logestoque

-- DROP TABLE public.logestoque;

CREATE TABLE public.logestoque
(
    lgqcodigo serial NOT NULL,
    lgqdata timestamp with time zone,
    lgqhora character varying(8) COLLATE pg_catalog."default",
    usucodigo integer,
    lgqpedido integer,
    procodigo integer,
    lgqsaldo double precision,
    lgqquantidade double precision,
    lgqestoque integer,
    lgqtipo character varying(20) COLLATE pg_catalog."default",
    lgqrecupera character varying(1) COLLATE pg_catalog."default",
    lgqseq integer,
    lgqmov integer,
    empresa integer,
    CONSTRAINT lgqcodigo PRIMARY KEY (lgqcodigo)
)

TABLESPACE pg_default;

ALTER TABLE public.logestoque
    OWNER to postgres;
-- Index: logestoque_lgqpedido_idx

-- DROP INDEX public.logestoque_lgqpedido_idx;

CREATE INDEX logestoque_lgqpedido_idx
    ON public.logestoque USING btree
    (lgqpedido ASC NULLS LAST)
    TABLESPACE pg_default;