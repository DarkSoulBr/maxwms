<?php

require_once("include/conexao.inc.php");
require_once('include/classes/Conexao.php');

if (isset($_GET["1"])) {
    $c01 = $_GET["1"];
} else {
    $c01 = [];
}
if (isset($_GET["2"])) {
    $c02 = $_GET["2"];
} else {
    $c02 = [];
}
if (isset($_GET["3"])) {
    $c03 = $_GET["3"];
} else {
    $c03 = [];
}

$auxdatainicio = $_GET['dataInicio'];
$auxdatafim = $_GET['dataFim'];

$npedido = $_GET['npedido'];

$tp = $_GET['tp'];
$tp2 = $_GET['tp2'];
$tpt = $_GET['tpt'];
$tpe = $_GET['tpe'];
$tpz = $_GET['tpz'];
$tpl = $_GET['tpl'];

if ($tp == 2) {

    $sql = "Select a.palmcodigo, a.pvnumero as pedido, a.pvtipoped, a.pvtpalt as tpalt, (select count(p.pvnumero) from pvitem as p Where a.pvnumero = p.pvnumero limit 1) as itens, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibcivit IS NULL and a.pvlibgre IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibcivit as varchar)='' and cast(a.pvlibgre as varchar)='')) THEN (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferematriz as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferefilial as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) ELSE (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) END as conferido, b.clirazao,a.pvorigem,a.pvdestino, a.pvvalor as valor, to_char(a.pvemissao, 'DD/MM/YYYY') as data, to_char(a.pvlibera, 'DD/MM/YYYY') as data2, a.pvhora as hora, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibgre IS NULL and a.pvlibcivit IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibgre as varchar)='' and cast(a.pvlibcivit as varchar)='')) THEN (select c.notnumero from notagua as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select c.notnumero from notamat as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select c.notnumero from notafil as c Where c.pvnumero = a.pvnumero limit 1) ELSE (select c.notnumero from notavit as c Where c.pvnumero = a.pvnumero limit 1) END as nota, 

	CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibgre IS NULL and a.pvlibcivit IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibgre as varchar)='' and cast(a.pvlibcivit as varchar)='')) THEN (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notagua as c Where c.pvnumero = a.pvnumero limit 1) 
	WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notamat as c Where c.pvnumero = a.pvnumero limit 1) 
	WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notafil as c Where c.pvnumero = a.pvnumero limit 1) 
	ELSE (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notavit as c Where c.pvnumero = a.pvnumero limit 1) END as datanota

	, (select e.usulogin from usuarios as e Where a.usuario = e.usucodigo limit 1) as usulogin
	, d.descricao as cidade, d.uf as estado, CASE WHEN a.pvtipofrete='1' THEN 'CIF' ELSE 'FOB' END as tipofrete, t.tranguerra as transportadora, 

	CASE WHEN (a.pvlibdep = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibcivit IS NULL) or (a.pvlibmat='' and a.pvlibfil='' and a.pvlibdep='' and a.pvlibvit='' and a.pvlibcivit='')) THEN (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) 
	WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1)  
	WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1)  
	ELSE (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) END as finalizado	 

	, a.pvimpresso, (select f.descricao from palm as f Where a.palmcodigo = f.palmcodigo limit 1) as palm, a.pvurgente, to_char(a.datasul, 'DD/MM/YYYY') as wms,'1' as gerawms, g.forrazao,h.descricao as cidadefor,h.uf as estadofor
	,a.pvnewobs
	, (select sum(pviest020+pviest030) from pvitem as z Where a.pvnumero = z.pvnumero) as estoquereserva 
        , (select sum(pviest02) from pvitem as zl Where a.pvnumero = zl.pvnumero) as estoqueloja  
	,a.pvfaturamento,a.pvagendamento,a.pvreagendamento,r.mtdescricao as pvremotivo,a.pvagendaentrega,a.pvbonificacao,a.pvobsentrega,a.pvinternet,a.vencodigo,a.pvembarque,a.pvlibera,a.pvlogdatasul,a.pvprodatasul      

	FROM pvendafinalizado xx 	
	left join pvenda as a on xx.pvnumero= a.pvnumero 	
	left join clientes as b on a.clicodigo= b.clicodigo left join transportador as t on a.tracodigo=t.tracodigo left join cliefat as c on b.clicodigo= c.clicodigo left join cidades as d on c.cidcodigo= d.cidcodigo left join fornecedor as g on a.clicodigo= g.forcodigo left join forecom as i on g.forcodigo= i.forcodigo left join cidades as h on i.cidcodigo= h.cidcodigo 

	left join tipoped on a.pvtipoped = tipoped.tipsigla
	LEft Join motreage as r on a.remotcodigo = r.mtcodigo

	WHERE (xx.pvfdatahora between '$auxdatainicio' and '$auxdatafim') ";

    if ($tpt == 2) {
        $sql .= " And ((a.pvurgente=1) or (a.pvurgente=3) or (a.pvurgente=4) or (a.pvurgente=5)) ";
    } else if ($tpt == 3) {
        $sql .= " And ((a.pvurgente=2) or (a.pvurgente is NULL)) ";
    }

    if ($tp == 2) {
        $sql .= " And ( (not (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) is NULL) ";
        $sql .= " or (not (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1) is NULL) ";
        $sql .= " or (not (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1) is NULL) )";
    } else if ($tp == 3) {
        $sql .= " And (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadovitoria as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
    } else if ($tp == 5) {
        $sql .= " And (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadovitoria as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";

        $sql .= " And ((select count(hx.pvnumero) from pvendaconfere as hx Where hx.pvnumero = a.pvnumero and hx.pvcestoque = hx.pvcconfere limit 1) > 0";
        $sql .= " Or (select count(hx.pvnumero) from pvendaconferematriz as hx Where hx.pvnumero = a.pvnumero and hx.pvcestoque = hx.pvcconfere limit 1) > 0";
        $sql .= " Or (select count(hx.pvnumero) from pvendaconferefilial as hx Where hx.pvnumero = a.pvnumero and hx.pvcestoque = hx.pvcconfere limit 1) > 0)";
    } else if ($tp == 4) {
        $sql .= " AND (a.pvimpresso)=1";
    }

    if ($tp2 == 2) {
        $sql .= " And not (select d1.pvnumero from romaneiospedidos as d1 Where d1.pvnumero = a.pvnumero limit 1) is NULL ";
    }
    if ($tp2 == 3) {
        $sql .= " And (select d1.pvnumero from romaneiospedidos as d1 Where d1.pvnumero = a.pvnumero limit 1) is NULL ";
    }

    if (sizeof($c01) > 0) {

        for ($i = 0; $i < sizeof($c01); $i++) {
            if ($c01[$i] != 0) {
                //echo $c01[$i];
                if ($i == 0) {
                    $sql .= "and (tipoped.tipcodigo = $c01[$i] ";
                }
                if ($i != 0) {
                    $sql .= "or tipoped.tipcodigo = $c01[$i] ";
                }
            }
        }
        $sql .= ")";
    } else {
        //$sql.= "and (a.pvtipoped <> 'S')";
    }


    if (sizeof($c02) > 0) {

        for ($i = 0; $i < sizeof($c02); $i++) {
            if ($c02[$i] != 0) {
                if ($i == 0) {
                    $sql .= "and (a.vencodigo = $c02[$i] ";
                }
                if ($i != 0) {
                    $sql .= "or a.vencodigo = $c02[$i] ";
                }
            }
        }
        $sql .= ")";
    }

    if (sizeof($c03) > 0) {

        for ($i = 0; $i < sizeof($c03); $i++) {
            if ($c03[$i] != 0) {
                if ($i == 0) {
                    $sql .= "and (a.tracodigo = $c03[$i] ";
                }
                if ($i != 0) {
                    $sql .= "or a.tracodigo = $c03[$i] ";
                }
            }
        }
        $sql .= ")";
    }

    $sql .= " order by pvlibera,pedido";
} else {

    $sql = "Select a.palmcodigo, a.pvnumero as pedido, a.pvtipoped, a.pvtpalt as tpalt, (select count(p.pvnumero) from pvitem as p Where a.pvnumero = p.pvnumero limit 1) as itens, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibcivit IS NULL and a.pvlibgre IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibcivit as varchar)='' and cast(a.pvlibgre as varchar)='')) THEN (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferematriz as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferefilial as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) ELSE (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) END as conferido, b.clirazao,a.pvorigem,a.pvdestino, a.pvvalor as valor, to_char(a.pvemissao, 'DD/MM/YYYY') as data, to_char(a.pvlibera, 'DD/MM/YYYY') as data2, a.pvhora as hora, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibgre IS NULL and a.pvlibcivit IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibgre as varchar)='' and cast(a.pvlibcivit as varchar)='')) THEN (select c.notnumero from notagua as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select c.notnumero from notamat as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select c.notnumero from notafil as c Where c.pvnumero = a.pvnumero limit 1) ELSE (select c.notnumero from notavit as c Where c.pvnumero = a.pvnumero limit 1) END as nota, 

	CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibgre IS NULL and a.pvlibcivit IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibgre as varchar)='' and cast(a.pvlibcivit as varchar)='')) THEN (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notagua as c Where c.pvnumero = a.pvnumero limit 1) 
	WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notamat as c Where c.pvnumero = a.pvnumero limit 1) 
	WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notafil as c Where c.pvnumero = a.pvnumero limit 1) 
	ELSE (select to_char(c.notemissao, 'DD/MM/YYYY')as notemissao from notavit as c Where c.pvnumero = a.pvnumero limit 1) END as datanota

	, (select e.usulogin from usuarios as e Where a.usuario = e.usucodigo limit 1) as usulogin
	, d.descricao as cidade, d.uf as estado, CASE WHEN a.pvtipofrete='1' THEN 'CIF' ELSE 'FOB' END as tipofrete, t.tranguerra as transportadora, 

	CASE WHEN (a.pvlibdep = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibcivit IS NULL) or (a.pvlibmat='' and a.pvlibfil='' and a.pvlibdep='' and a.pvlibvit='' and a.pvlibcivit='')) THEN (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) 
	WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1)  
	WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1)  
	ELSE (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) END as finalizado	 

	, a.pvimpresso, (select f.descricao from palm as f Where a.palmcodigo = f.palmcodigo limit 1) as palm, a.pvurgente, to_char(a.datasul, 'DD/MM/YYYY') as wms,'1' as gerawms, g.forrazao,h.descricao as cidadefor,h.uf as estadofor
	,a.pvnewobs
	, (select sum(pviest020+pviest030) from pvitem as z Where a.pvnumero = z.pvnumero) as estoquereserva 
        , (select sum(pviest02) from pvitem as zl Where a.pvnumero = zl.pvnumero) as estoqueloja 
	,a.pvfaturamento,a.pvagendamento,a.pvreagendamento,r.mtdescricao as pvremotivo,a.pvagendaentrega,a.pvbonificacao,a.pvobsentrega,a.pvinternet,a.vencodigo,a.pvembarque,a.pvlibera,a.pvlogdatasul,a.pvprodatasul           

	FROM pvenda as a left join clientes as b on a.clicodigo= b.clicodigo left join transportador as t on a.tracodigo=t.tracodigo left join cliefat as c on b.clicodigo= c.clicodigo left join cidades as d on c.cidcodigo= d.cidcodigo left join fornecedor as g on a.clicodigo= g.forcodigo left join forecom as i on g.forcodigo= i.forcodigo left join cidades as h on i.cidcodigo= h.cidcodigo 

	left join tipoped on a.pvtipoped = tipoped.tipsigla
	LEft Join motreage as r on a.remotcodigo = r.mtcodigo

	WHERE (a.pvlibera between '$auxdatainicio' and '$auxdatafim') ";

    if ($tpt == 2) {
        $sql .= " And ((a.pvurgente=1) or (a.pvurgente=3) or (a.pvurgente=4) or (a.pvurgente=5)) ";
    } else if ($tpt == 3) {
        $sql .= " And ((a.pvurgente=2) or (a.pvurgente is NULL)) ";
    }

    if ($tp == 2) {
        $sql .= " And ( (not (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) is NULL) ";
        $sql .= " or (not (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1) is NULL) ";
        $sql .= " or (not (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1) is NULL) )";
    } else if ($tp == 3) {
        $sql .= " And (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadovitoria as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
    } else if ($tp == 5) {
        $sql .= " And (select d.pvnumero from pvendafinalizado as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadomatriz as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadofilial as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";
        $sql .= " And (select d.pvnumero from pvendafinalizadovitoria as d Where d.pvnumero = a.pvnumero limit 1) is NULL ";

        $sql .= " And ((select count(hx.pvnumero) from pvendaconfere as hx Where hx.pvnumero = a.pvnumero and hx.pvcestoque = hx.pvcconfere limit 1) > 0";
        $sql .= " Or (select count(hx.pvnumero) from pvendaconferematriz as hx Where hx.pvnumero = a.pvnumero and hx.pvcestoque = hx.pvcconfere limit 1) > 0";
        $sql .= " Or (select count(hx.pvnumero) from pvendaconferefilial as hx Where hx.pvnumero = a.pvnumero and hx.pvcestoque = hx.pvcconfere limit 1) > 0)";
    } else if ($tp == 4) {
        $sql .= " AND (a.pvimpresso)=1";
    }

    if ($tp2 == 2) {
        $sql .= " And not (select d1.pvnumero from romaneiospedidos as d1 Where d1.pvnumero = a.pvnumero limit 1) is NULL ";
    }
    if ($tp2 == 3) {
        $sql .= " And (select d1.pvnumero from romaneiospedidos as d1 Where d1.pvnumero = a.pvnumero limit 1) is NULL ";
    }

    if (sizeof($c01) > 0) {

        for ($i = 0; $i < sizeof($c01); $i++) {
            if ($c01[$i] != 0) {
                //echo $c01[$i];
                if ($i == 0) {
                    $sql .= "and (tipoped.tipcodigo = $c01[$i] ";
                }
                if ($i != 0) {
                    $sql .= "or tipoped.tipcodigo = $c01[$i] ";
                }
            }
        }
        $sql .= ")";
    } else {
        //$sql.= "and (a.pvtipoped <> 'S')";
    }


    if (sizeof($c02) > 0) {

        for ($i = 0; $i < sizeof($c02); $i++) {
            if ($c02[$i] != 0) {
                if ($i == 0) {
                    $sql .= "and (a.vencodigo = $c02[$i] ";
                }
                if ($i != 0) {
                    $sql .= "or a.vencodigo = $c02[$i] ";
                }
            }
        }
        $sql .= ")";
    }

    if (sizeof($c03) > 0) {

        for ($i = 0; $i < sizeof($c03); $i++) {
            if ($c03[$i] != 0) {
                if ($i == 0) {
                    $sql .= "and (a.tracodigo = $c03[$i] ";
                }
                if ($i != 0) {
                    $sql .= "or a.tracodigo = $c03[$i] ";
                }
            }
        }
        $sql .= ")";
    }

    $sql .= " order by a.pvlibera,length(trim(a.pvhora)),trim(a.pvhora),a.pvnumero";
}

$cad = pg_query($sql);

$row = pg_num_rows($cad);

$valor = 0;

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dados>";

$k;


if ($row > 0) {

    for ($i = 0; $i < $row; $i++) {

        $cadastro = '';

        $pvembarque = trim(pg_fetch_result($cad, $i, "pvembarque"));

        $mostrar = 1;
        if ($tpe == 2 && $pvembarque != '') {
            $mostrar = 0;
        } else if ($tpe == 3 && $pvembarque == '') {
            $mostrar = 0;
        }

        $localestoque = '_';
        if ($mostrar == 1) {

            $estoquereserva = pg_fetch_result($cad, $i, "estoquereserva");
            if ($estoquereserva == '') {
                $estoquereserva = '0';
            }

            if ($estoquereserva == 0) {
                
                $estoqueloja = (int) pg_fetch_result($cad, $i, "estoqueloja");
                
                $mostrar = 1;
                if ($tpl == 1 && $estoqueloja > 0) {
                    $mostrar = 0;
                } else if ($tpl == 2 && $estoqueloja == 0) {
                    $mostrar = 0;
                }

                if ($mostrar == 1) {
                
                    $pedido = pg_fetch_result($cad, $i, "pedido");
                    
                    $notnumero_meli = 0;

                    //Verifica se o pedido ja tem nota emitida				
                    $notnumero = '';
                    //Verifica se o Pedido tem Nota Emitida
                    $sql2 = "SELECT notnumero,notemissao 
                                    FROM  notagua
                                    where pvnumero = '$pedido'";
                    //EXECUTA A QUERY
                    $sql2 = pg_query($sql2);
                    $row2 = pg_num_rows($sql2);
                    if ($row2) {
                        $notnumero = pg_fetch_result($sql2, 0, "notnumero");
                    } else {
                        $sql2 = "SELECT notnumero,notemissao 
                                    FROM  notafil 
                                    where pvnumero = '$pedido'";
                        //EXECUTA A QUERY
                        $sql2 = pg_query($sql2);
                        $row2 = pg_num_rows($sql2);
                        if ($row2) {
                            $notnumero = pg_fetch_result($sql2, 0, "notnumero");
                        } else {
                            $sql2 = "SELECT notnumero,notemissao 
                                    FROM  notavit 
                                    where pvnumero = '$pedido'";
                            //EXECUTA A QUERY
                            $sql2 = pg_query($sql2);
                            $row2 = pg_num_rows($sql2);
                            if ($row2) {
                                $notnumero_meli = (int) pg_fetch_result($sql2, 0, "notnumero");
                            }
                        }
                    }

                    $mostrar = 1;
                    if ($tpz == 2 && $notnumero != '') {
                        $mostrar = 0;
                    } else if ($tpz == 3 && $notnumero == '') {
                        $mostrar = 0;
                    }
                    
                    //Se Tiver Notas Meli não deve mostrar
                    if($notnumero_meli) {
                        $mostrar = 0;
                    }

                    if ($mostrar == 1) {

                        $pvtipoped = pg_fetch_result($cad, $i, "pvtipoped");
                        $pvorigem = pg_fetch_result($cad, $i, "pvorigem");
                        $pvdestino = pg_fetch_result($cad, $i, "pvdestino");

                        $mostrar = 1;
                        if ($pvtipoped == 'S') {
                            //if (($pvorigem == 1 && $pvdestino == 11) || ($pvorigem == 11 && ($pvdestino == 1 || $pvdestino == 7))) {
                            if (($pvorigem == 2 && $pvdestino == 26) || ($pvorigem == 26 && $pvdestino == 2)) {

                            } else {
                                $mostrar = 0;
                            }
                        }

                        if ($mostrar == 1) {

                            $k++;

                            $xml .= "<registro>";


                            $palmcodigo = pg_fetch_result($cad, $i, "palmcodigo");
                            $pedido = pg_fetch_result($cad, $i, "pedido");

                            $tpalt = pg_fetch_result($cad, $i, "tpalt");
                            $itens = pg_fetch_result($cad, $i, "itens");
                            $conferido = pg_fetch_result($cad, $i, "conferido");
                            $clirazao = pg_fetch_result($cad, $i, "clirazao");

                            $valor = pg_fetch_result($cad, $i, "valor");
                            $data = pg_fetch_result($cad, $i, "data");
                            $data2 = pg_fetch_result($cad, $i, "data2");
                            $hora = pg_fetch_result($cad, $i, "hora");
                            $nota = pg_fetch_result($cad, $i, "nota");

                            $datanota = pg_fetch_result($cad, $i, "datanota");

                            $usulogin = pg_fetch_result($cad, $i, "usulogin");
                            $cidade = pg_fetch_result($cad, $i, "cidade");
                            $estado = pg_fetch_result($cad, $i, "estado");
                            $tipofrete = pg_fetch_result($cad, $i, "tipofrete");
                            $transportadora = pg_fetch_result($cad, $i, "transportadora");
                            $finalizado = pg_fetch_result($cad, $i, "finalizado");
                            $pvimpresso = pg_fetch_result($cad, $i, "pvimpresso");
                            $palm = pg_fetch_result($cad, $i, "palm");
                            $pvurgente = pg_fetch_result($cad, $i, "pvurgente");
                            $wms = pg_fetch_result($cad, $i, "wms");
                            $gerawms = pg_fetch_result($cad, $i, "gerawms");
                            $pvnewobs = pg_fetch_result($cad, $i, "pvnewobs");

                            $forrazao = pg_fetch_result($cad, $i, "forrazao");
                            $cidadefor = pg_fetch_result($cad, $i, "cidadefor");
                            $estadofor = pg_fetch_result($cad, $i, "estadofor");

                            $pvfaturamento = trim(pg_fetch_result($cad, $i, "pvfaturamento"));
                            $pvagendamento = trim(pg_fetch_result($cad, $i, "pvagendamento"));
                            $pvreagendamento = trim(pg_fetch_result($cad, $i, "pvreagendamento"));
                            $pvremotivo = trim(pg_fetch_result($cad, $i, "pvremotivo"));

                            $pvagendaentrega = trim(pg_fetch_result($cad, $i, "pvagendaentrega"));
                            $pvbonificacao = trim(pg_fetch_result($cad, $i, "pvbonificacao"));
                            $pvobsentrega = trim(pg_fetch_result($cad, $i, "pvobsentrega"));
                            $pvinternet = trim(pg_fetch_result($cad, $i, "pvinternet"));
                            $vencodigo = trim(pg_fetch_result($cad, $i, "vencodigo"));

                            $pvembarque = trim(pg_fetch_result($cad, $i, "pvembarque"));
                            $pvlogdatasul = trim(pg_fetch_result($cad, $i, "pvlogdatasul"));
                            $pvlogdatasul = str_replace("&", "E", $pvlogdatasul);

                            $pvprodatasul = trim(pg_fetch_result($cad, $i, "pvprodatasul"));

                            $cor = '#000000';


                            if ($palmcodigo == '') {
                                $palmcodigo = '0';
                            }
                            if ($pedido == '') {
                                $pedido = '0';
                            }
                            if ($pvtipoped == '') {
                                $pvtipoped = '0';
                            }
                            if ($tpalt == '') {
                                $tpalt = '0';
                            }
                            if ($itens == '') {
                                $itens = '0';
                            }
                            if ($conferido == '') {
                                $conferido = '0';
                            }
                            if ($clirazao == '') {
                                $clirazao = '0';
                            }
                            if ($pvorigem == '') {
                                $pvorigem = '0';
                            }
                            if ($pvdestino == '') {
                                $pvdestino = '0';
                            }
                            if ($valor == '') {
                                $valor = '0';
                            }
                            if ($data == '') {
                                $data = '0';
                            }
                            if ($data2 == '') {
                                $data2 = '0';
                            }
                            if ($hora == '') {
                                $hora = '0';
                            }
                            if ($nota == '') {
                                $nota = '0';
                            }

                            if ($datanota == '') {
                                $datanota = '0';
                            }

                            if ($usulogin == '') {
                                $usulogin = '0';
                            }
                            if ($cidade == '') {
                                $cidade = '0';
                            }
                            if ($estado == '') {
                                $estado = '0';
                            }
                            if ($tipofrete == '') {
                                $tipofrete = '0';
                            }
                            if ($transportadora == '') {
                                $transportadora = '0';
                            }
                            if ($finalizado == '') {
                                $finalizado = '0';
                            }
                            if ($pvimpresso == '') {
                                $pvimpresso = '0';
                            }
                            if ($palm == '') {
                                $palm = '0';
                            }
                            if ($pvurgente == '') {
                                $pvurgente = '0';
                            }
                            if ($wms == '') {
                                $wms = '0';
                            }
                            if ($gerawms == '') {
                                $gerawms = '0';
                            }

                            if ($pvnewobs == '') {
                                $pvnewobs = '0';
                            }

                            if ($forrazao == '') {
                                $forrazao = '0';
                            }
                            if ($cidadefor == '') {
                                $cidadefor = '0';
                            }
                            if ($estadofor == '') {
                                $estadofor = '0';
                            }

                            if ($pvembarque == '') {
                                $pvembarque = '0';
                            }
                            if ($notnumero == '') {
                                $notnumero = '0';
                            }
                            if ($pvlogdatasul == '') {
                                $pvlogdatasul = '_';
                            }
                            if ($pvprodatasul == '') {
                                $pvprodatasul = '_';
                            }

                            if (trim($pvfaturamento) == "") {
                                $pvfaturamento = "_";
                            } else {
                                $aux = $pvfaturamento;
                                $pvfaturamento = substr($aux, 8, 2) . '/' . substr($aux, 5, 2) . '/' . substr($aux, 0, 4);
                            }
                            if (trim($pvagendamento) == "") {
                                $pvagendamento = "_";
                            } else {
                                $aux = $pvagendamento;
                                $pvagendamento = substr($aux, 8, 2) . '/' . substr($aux, 5, 2) . '/' . substr($aux, 0, 4);
                            }
                            if (trim($pvreagendamento) == "") {
                                $pvreagendamento = "_";
                            } else {
                                $aux = $pvreagendamento;
                                $pvreagendamento = substr($aux, 8, 2) . '/' . substr($aux, 5, 2) . '/' . substr($aux, 0, 4);
                            }
                            if (trim($pvremotivo) == "") {
                                $pvremotivo = "_";
                            }

                            //Branco ou Zero manda o Default Não que é 2
                            if (trim($pvagendaentrega) == "" || trim($pvagendaentrega) == "0" || trim($pvagendaentrega) == "2") {
                                $pvagendaentrega = "NAO";
                            } else {
                                $pvagendaentrega = "SIM";
                            }

                            //Branco ou Zero manda o Default Não que é 2
                            if (trim($pvbonificacao) == "" || trim($pvbonificacao) == "0" || trim($pvbonificacao) == "2") {
                                $pvbonificacao = "NAO";
                            } else {
                                $pvbonificacao = "SIM";
                            }

                            if (trim($pvobsentrega) == "") {
                                $pvobsentrega = "_";
                            }
                            if (trim($pvinternet) == "") {
                                $pvinternet = "_";
                            }

                            /*
                              if ($vencodigo == 18) {
                              $vencodigo = "B2W";
                              } else if ($vencodigo == 19) {
                              $vencodigo = "WALMART";
                              } else if ($vencodigo == 20) {
                              $vencodigo = "TRICAE";
                              } else if ($vencodigo == 21) {
                              $vencodigo = "CNOVA";
                              } else if ($vencodigo == 22) {
                              $vencodigo = "SHOPFACIL";
                              } else if ($vencodigo == 23) {
                              $vencodigo = "MAGAZINE-LUIZA";
                              } else if ($vencodigo == 35) {
                              $vencodigo = "RI-HAPPY";
                              } else {
                              $vencodigo = "TOYMANIA";
                              }
                             * 
                             */

                            //Localiza o Vendedor que estava Fixo                       
                            $sql2x = "SELECT vennguerra FROM vendedor WHERE vencodigo = {$vencodigo}";
                            $cad2x = pg_query($sql2x);
                            $row2x = pg_num_rows($cad2x);
                            $vendedor = '_';
                            if ($row2x > 0) {
                                $vendedor = trim(pg_fetch_result($cad2x, 0, "vennguerra"));
                                if ($vencodigo == 2) {
                                    $vencodigo = "TOYMANIA";
                                } else {
                                    $vencodigo = $vendedor;
                                }
                            } else {
                                $vencodigo = "TOYMANIA";
                            }


                            if ($pvtipoped == 'S') {
                                $clirazao = 'CENTRO ATACADISTA BARAO';
                            }

                            //Vai passar a Enviar o Romaneio
                            $sql2 = "SELECT b.pvnumero,
                                    c.romnumero,
                                    c.romdata,
                                    c.romano 
                                    FROM romaneiospedidos b, romaneios c  
                                    WHERE b.romcodigo = c.romcodigo 
                                    AND b.pvnumero = {$pedido}";
                            $sql2 = pg_query($sql2);
                            $row2 = pg_num_rows($sql2);
                            if ($row2) {
                                $romnumero = trim(pg_fetch_result($sql2, 0, "romnumero")) . '/' . trim(pg_fetch_result($sql2, 0, "romano"));
                                $romdata = date("d/m/Y", strtotime(pg_fetch_result($sql2, 0, "romdata")));
                            } else {
                                $romnumero = '_';
                                $romdata = '_';
                            }

                            $nfeCab = 0;

                            //Se for um Pedido Cross precisa enviar a Nota de Transferencia da Barão
                            if ($pvtipoped == 'Y') {

                                $sql2 = "SELECT pvflag FROM pvenda WHERE pvnumero = {$pedido}";
                                $sql2 = pg_query($sql2);
                                $row2 = pg_num_rows($sql2);
                                if ($row2) {
                                    $pvflag = pg_fetch_result($sql2, 0, "pvflag");
                                }
                            } else {
                                $pvflag = 0;
                            }

                            if ($pvflag == 5 || $pvflag == 6 || $pvflag == 7 || $pvflag == 8) {

                                $controleCross = 0;

                                //Verifica se já tem o pedido abastecimento   
                                $pcnumero = 0;
                                $sql2x = "Select pcnumero from pvendaliberacross where pvnumero = {$pedido}";
                                $cad2x = pg_query($sql2x);
                                $row2x = pg_num_rows($cad2x);
                                if ($row2x > 0) {
                                    $pcnumero = pg_fetch_result($cad2x, 0, "pcnumero");
                                }

                                $pedidoBarao = 0;

                                //Localiza o Pedido de Compra para a partir da observacao que é fixa
                                if ($pcnumero) {
                                    $sql2x = "SELECT pvnewobs FROM pvenda WHERE pvnumero = {$pcnumero}";
                                    $cad2x = pg_query($sql2x);
                                    $row2x = pg_num_rows($cad2x);
                                    $auxObs = '';
                                    if ($row2x > 0) {
                                        $auxObs = pg_fetch_result($cad2x, 0, "pvnewobs");
                                    }

                                    if (substr($auxObs, 0, 41) == "CRIADO AUTOMATICAMENTE A PARTIR DO PEDIDO") {
                                        $pedidoBarao = (int) substr($auxObs, 42, 7);
                                    }
                                }

                                //Localiza a NF-e na Base Barão
                                if ($pedidoBarao > 0) {

                                    $sql_barao = "SELECT notnumero FROM notadep WHERE pvnumero = {$pedidoBarao}";
                                    $sql_barao = pg_query($conn_2, $sql_barao);
                                    $row_barao = pg_num_rows($sql_barao);
                                    if ($row_barao) {
                                        $nfeCab = pg_fetch_result($sql_barao, 0, "notnumero");
                                    }
                                }
                            }


                            $j = $i + 1;

                            $xml .= "<item>" . $k . "</item>";


                            $xml .= "<item>" . $palmcodigo . "</item>";
                            $xml .= "<item>" . $pedido . "</item>";
                            $xml .= "<item>" . $pvtipoped . "</item>";
                            $xml .= "<item>" . $tpalt . "</item>";
                            $xml .= "<item>" . $itens . "</item>";
                            $xml .= "<item>" . $conferido . "</item>";
                            $xml .= "<item>" . $clirazao . "</item>";
                            $xml .= "<item>" . $pvorigem . "</item>";
                            $xml .= "<item>" . $pvdestino . "</item>";
                            $xml .= "<item>" . $valor . "</item>";
                            $xml .= "<item>" . $data . "</item>";
                            $xml .= "<item>" . $data2 . "</item>";
                            $xml .= "<item>" . $hora . "</item>";
                            //$xml.="<item>".$nota."</item>";
                            //$xml.="<item>".$datanota."</item>";
                            $xml .= "<item>" . $pvembarque . "</item>";
                            $xml .= "<item>" . $notnumero . "</item>";

                            $xml .= "<item>" . $usulogin . "</item>";
                            $xml .= "<item>" . $cidade . "</item>";
                            $xml .= "<item>" . $estado . "</item>";
                            $xml .= "<item>" . $tipofrete . "</item>";
                            $xml .= "<item>" . $transportadora . "</item>";
                            $xml .= "<item>" . $finalizado . "</item>";
                            $xml .= "<item>" . $pvimpresso . "</item>";
                            $xml .= "<item>" . $palm . "</item>";
                            $xml .= "<item>" . $pvurgente . "</item>";
                            $xml .= "<item>" . $wms . "</item>";
                            $xml .= "<item>" . $gerawms . "</item>";

                            $xml .= "<item>" . $pvnewobs . "</item>";

                            $xml .= "<item>" . $forrazao . "</item>";
                            $xml .= "<item>" . $cidadefor . "</item>";
                            $xml .= "<item>" . $estadofor . "</item>";

                            $xml .= "<item>" . $pvfaturamento . "</item>";
                            $xml .= "<item>" . $pvagendamento . "</item>";
                            $xml .= "<item>" . $pvreagendamento . "</item>";
                            $xml .= "<item>" . $pvremotivo . "</item>";

                            $xml .= "<item>" . $pvagendaentrega . "</item>";
                            $xml .= "<item>" . $pvbonificacao . "</item>";
                            $xml .= "<item>" . $pvobsentrega . "</item>";
                            $xml .= "<item>" . $pvinternet . "</item>";
                            $xml .= "<item>" . $vencodigo . "</item>";
                            $xml .= "<item>" . $romnumero . "</item>";
                            $xml .= "<item>" . $romdata . "</item>";
                            $xml .= "<item>" . $nfeCab . "</item>";
                            $xml .= "<item>" . $pvlogdatasul . "</item>";
                            $xml .= "<item>" . $pvprodatasul . "</item>";

                            $xml .= "</registro>";
                        }
                    }
                }
            }
        }
    }
} else {
    /*
      $xml.="<registro>";
      $xml.="<item>0</item>";
      $xml.="</registro>";
     */
}


$xml .= "</dados>";

echo $xml;
pg_close($conn);

function convertem($term, $tp) {
    if ($tp == "1")
        $palavra = strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    elseif ($tp == "0")
        $palavra = strtr(strtolower($term), "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß", "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $palavra;
}

exit();
?>
