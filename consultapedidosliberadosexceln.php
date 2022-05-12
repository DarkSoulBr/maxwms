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

$dtiniciox = $auxdatainicio;
$dtfinalx = $auxdatafim;

$npedido = $_GET['npedido'];

$tp = $_GET['tp'];
$tp2 = $_GET['tp2'];
$tpt = $_GET['tpt'];
$tpe = $_GET['tpe'];
$tpz = $_GET['tpz'];
$tpl = $_GET['tpl'];

if ($tp == 2) {

    $sql = "Select a.palmcodigo, a.pvnumero as pedido, a.pvinternet,a.pvtipoped, a.pvtpalt as tpalt, (select count(p.pvnumero) from pvitem as p Where a.pvnumero = p.pvnumero limit 1) as itens, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibcivit IS NULL and a.pvlibgre IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibcivit as varchar)='' and cast(a.pvlibgre as varchar)='')) THEN (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferematriz as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferefilial as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) ELSE (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) END as conferido, b.clirazao,a.pvorigem,a.pvdestino, a.pvvalor as valor, to_char(a.pvemissao, 'DD/MM/YYYY') as data, to_char(a.pvlibera, 'DD/MM/YYYY') as data2, a.pvhora as hora, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibgre IS NULL and a.pvlibcivit IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibgre as varchar)='' and cast(a.pvlibcivit as varchar)='')) THEN (select c.notnumero from notagua as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select c.notnumero from notamat as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select c.notnumero from notafil as c Where c.pvnumero = a.pvnumero limit 1) ELSE (select c.notnumero from notavit as c Where c.pvnumero = a.pvnumero limit 1) END as nota, 

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
	,a.pvfaturamento,a.pvbonificacao,a.pvagendaentrega,a.pvagendamento,a.pvreagendamento,r.mtdescricao as pvremotivo,a.pvobsentrega
	,a.vencodigo,a.pvembarque,a.pvlibera
	, (select sum(pviest020+pviest030) from pvitem as z Where a.pvnumero = z.pvnumero) as estoquereserva         
        , a.pvlogdatasul,a.pvprodatasul     
        , (select sum(pviest02) from pvitem as zl Where a.pvnumero = zl.pvnumero) as estoqueloja  

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

    $sql = "Select a.palmcodigo, a.pvnumero as pedido, a.pvinternet,a.pvtipoped, a.pvtpalt as tpalt, (select count(p.pvnumero) from pvitem as p Where a.pvnumero = p.pvnumero limit 1) as itens, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibcivit IS NULL and a.pvlibgre IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibcivit as varchar)='' and cast(a.pvlibgre as varchar)='')) THEN (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferematriz as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select count(h.pvnumero) from pvendaconferefilial as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) ELSE (select count(h.pvnumero) from pvendaconfere as h Where h.pvnumero = a.pvnumero and h.pvcestoque = h.pvcconfere limit 1) END as conferido, b.clirazao,a.pvorigem,a.pvdestino, a.pvvalor as valor, to_char(a.pvemissao, 'DD/MM/YYYY') as data, to_char(a.pvlibera, 'DD/MM/YYYY') as data2, a.pvhora as hora, CASE WHEN (cast(a.pvlibdep as varchar) = '1' or (a.pvlibmat IS NULL and a.pvlibfil IS NULL and a.pvlibdep IS NULL and a.pvlibvit IS NULL and a.pvlibgre IS NULL and a.pvlibcivit IS NULL) or (cast(a.pvlibmat as varchar)='' and cast(a.pvlibfil as varchar)='' and cast(a.pvlibdep as varchar)='' and cast(a.pvlibvit as varchar)='' and cast(a.pvlibgre as varchar)='' and cast(a.pvlibcivit as varchar)='')) THEN (select c.notnumero from notagua as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibmat,'') as integer) = 1) THEN (select c.notnumero from notamat as c Where c.pvnumero = a.pvnumero limit 1) WHEN (cast(NULLIF(a.pvlibfil,'') as integer) = 1) THEN (select c.notnumero from notafil as c Where c.pvnumero = a.pvnumero limit 1) ELSE (select c.notnumero from notavit as c Where c.pvnumero = a.pvnumero limit 1) END as nota, 

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
	,a.pvfaturamento,a.pvbonificacao,a.pvagendaentrega,a.pvagendamento,a.pvreagendamento,r.mtdescricao as pvremotivo,a.pvobsentrega
	,a.vencodigo,a.pvembarque,a.pvlibera   
	, (select sum(pviest020+pviest030) from pvitem as z Where a.pvnumero = z.pvnumero) as estoquereserva        
        ,a.pvlogdatasul,a.pvprodatasul     
        , (select sum(pviest02) from pvitem as zl Where a.pvnumero = zl.pvnumero) as estoqueloja  

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

$data = pg_query($sql);


//se encontrar registros
if (pg_num_rows($data)) {

    header("Content-type: " . "application/vnd.ms-excel");
    header("Content-disposition: attachment; filename=pedidos.xls");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

    $report_names = "Users listing";

    echo "<html>" . "\r\n";
    echo "<head><title>" . $report_names . "</title><meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel\"></head>" . "\r\n";
    echo "<body><table border=\"1\" style=\"font-family:Arial;font-size:12px;\">" . "\r\n";

    echo "<tr>";
    echo "<td bgcolor=\"#CCCCCC\" colspan=\"40\" align=\"center\" height=\"30\"><b>PEDIDOS LIBERADOS DE: " . $dtiniciox . " ATÉ: " . $dtfinalx . "</b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td bgcolor=\"#FFFFFF\" colspan=\"40\">&nbsp;</td>";
    echo "</tr>";


    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }


    echo "<tr>";
    echo "<td></td>";
    echo "<td>Pedido</td>";
    echo "<td>NF-e CAB</td>";
    echo "<td>Vtex</td>";
    echo "<td>Embarque</td>";
    echo "<td>NFe</td>";
    echo "<td>Local</td>";
    echo "<td>Tp</td>";
    echo "<td>Al</td>";
    echo "<td>Itens</td>";
    echo "<td>Conf.</td>";
    echo "<td>Cliente</td>";
    echo "<td>O</td>";
    echo "<td>D</td>";
    echo "<td>Valor</td>";
    echo "<td>Data</td>";
    echo "<td>Liberação</td>";
    echo "<td>Hora</td>";
    //echo "<td>Nota</td>";
    //echo "<td>Data</td>";
    echo "<td>Usuário</td>";
    echo "<td>Cidade</td>";
    echo "<td>UF</td>";
    echo "<td>Frete</td>";
    echo "<td>Transportador</td>";
    echo "<td>C</td>";
    echo "<td>N</td>";
    echo "<td>I</td>";
    //echo "<td>Palm</td>";
    echo "<td>Urgente</td>";
    echo "<td>Datasul</td>";
    echo "<td>Observações</td>";
    echo "<td>Fat.Desejado</td>";
    echo "<td>Bonificacao</td>";
    echo "<td>Agendamento</td>";
    echo "<td>Data Agend.</td>";
    echo "<td>Re-Agend.</td>";
    echo "<td>Motivo</td>";
    echo "<td>Observações Entrega</td>";
    echo "<td>Log Datasul</td>";
    echo "<td>Produtos Datasul</td>";
    echo "<td>Romaneio</td>";
    echo "<td>Data</td>";
    echo "</tr>";



    //corpo da tabela
    $j = 0;
    while ($row = pg_fetch_object($data)) {


        //Estoque Reserva tem que ser 0
        if ($row->{$campos[41]} == 0) {

            $pvembarque = $row->{$campos[39]};

            $continua = 1;

            if ($tpe == 2 && $pvembarque != '') {
                $continua = 0;
            } else if ($tpe == 3 && $pvembarque == '') {
                $continua = 0;
            }

            if ($continua == 1) {

                $estoqueloja = (int) $row->{$campos[44]};

                $mostrar = 1;
                if ($tpl == 1 && $estoqueloja > 0) {
                    $mostrar = 0;
                } else if ($tpl == 2 && $estoqueloja == 0) {
                    $mostrar = 0;
                }

                if ($mostrar == 1) {

                    $pedido = $row->{$campos[1]};

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
                    if ($notnumero_meli) {
                        $mostrar = 0;
                    }

                    if ($mostrar == 1) {


                        if ($row->{$campos[3]} == 'S') {

                            //if (($row->{$campos[8]} == 1 && $row->{$campos[9]} == 11) || ($row->{$campos[8]} == 11 && ($row->{$campos[9]} == 1 || $row->{$campos[9]} == 7))) {
                            if (($row->{$campos[8]} == 2 && $row->{$campos[9]} == 26) || ($row->{$campos[8]} == 26 && $row->{$campos[9]} == 2)) {
                                
                            } else {
                                $mostrar = 0;
                            }
                        }


                        if ($mostrar == 1) {

                            $j++;

                            $vencodigo = $row->{$campos[38]};

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

                            $nfeCab = 0;

                            //Se for um Pedido Cross precisa enviar a Nota de Transferencia da Barão
                            if ($row->{$campos[3]} == 'Y') {

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

                            if ($nfeCab == 0) {
                                $nfeCab = '';
                            }

                            echo "<tr>";
                            for ($i = 0; $i < (sizeof($campos)); $i++) {

                                //Define a cor de acordo com o status
                                if ($row->{$campos[21]} == null) {
                                    //$cor = '#FF0000';
                                    $cor = '#ff4d4d';
                                } else {
                                    $cor = 'white';
                                }

                                if ($i == 0) {
                                    echo "<td bgcolor=" . $cor . ">" . $j . "</td>";
                                }
                                //Se for a Coluna com numero Vtex, inclui na sequencia coluna com o Local
                                else if ($i == 2) {
                                    echo "<td bgcolor=" . $cor . ">" . $nfeCab . "</td>";
                                    echo "<td bgcolor=" . $cor . ">" . $row->{$campos[$i]} . "</td>";
                                    echo "<td bgcolor=" . $cor . ">" . $row->{$campos[39]} . "</td>";
                                    echo "<td bgcolor=" . $cor . ">" . $notnumero . "</td>";

                                    /*
                                      if ($row->{$campos[38]} == 18) {
                                      echo "<td bgcolor=" . $cor . ">" . "B2W" . "</td>";
                                      } else if ($row->{$campos[38]} == 19) {
                                      echo "<td bgcolor=" . $cor . ">" . "WALMART" . "</td>";
                                      } else if ($row->{$campos[38]} == 20) {
                                      echo "<td bgcolor=" . $cor . ">" . "TRICAE" . "</td>";
                                      } else if ($row->{$campos[38]} == 21) {
                                      echo "<td bgcolor=" . $cor . ">" . "CNOVA" . "</td>";
                                      } else if ($row->{$campos[38]} == 22) {
                                      echo "<td bgcolor=" . $cor . ">" . "SHOPFACIL" . "</td>";
                                      } else if ($row->{$campos[38]} == 23) {
                                      echo "<td bgcolor=" . $cor . ">" . "MAGAZINE-LUIZA" . "</td>";
                                      } else if ($row->{$campos[38]} == 35) {
                                      echo "<td bgcolor=" . $cor . ">" . "RI-HAPPY" . "</td>";
                                      } else {
                                      echo "<td bgcolor=" . $cor . ">" . "TOYMANIA" . "</td>";
                                      }
                                     * 
                                     */
                                    echo "<td bgcolor=" . $cor . ">" . $vencodigo . "</td>";
                                } else if ($i == 10) {
                                    $val = number_format($row->{$campos[$i]}, 2, ',', '');
                                    echo "<td bgcolor=" . $cor . ">" . $val . "</td>";
                                } else if ($i == 21) {
                                    if ($row->{$campos[$i]} == null) {
                                        echo "<td bgcolor=" . $cor . ">" . "</td>";
                                        echo "<td bgcolor=" . $cor . ">" . "N</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . "C</td>";
                                        echo "<td bgcolor=" . $cor . ">" . "</td>";
                                    }
                                } else if ($i == 22) {
                                    if ($row->{$campos[$i]} == null) {
                                        echo "<td bgcolor=" . $cor . ">" . "</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . "I</td>";
                                    }
                                } else if ($i == 24) {
                                    if ($row->{$campos[$i]} == 1) {
                                        echo "<td bgcolor=" . $cor . ">" . "RETIRA</td>";
                                    } else if ($row->{$campos[$i]} == 3) {
                                        echo "<td bgcolor=" . $cor . ">" . "HOTEL</td>";
                                    } else if ($row->{$campos[$i]} == 4) {
                                        echo "<td bgcolor=" . $cor . ">" . "AJUSTE FISCAL</td>";
                                    } else if ($row->{$campos[$i]} == 5) {
                                        echo "<td bgcolor=" . $cor . ">" . "EXTRAVIO</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . "NÃO</td>";
                                    }
                                } else if ($i == 26 || $i == 27 || $i == 28 || $i == 29 || $i == 38 || $i == 39 || $i == 14 || $i == 15 || $i == 23 || $i == 39 || $i == 40 || $i == 41 || $i == 44) {
                                    
                                } else if ($i == 31 || $i == 34 || $i == 35) {
                                    if ($row->{$campos[$i]} == null) {
                                        echo "<td bgcolor=" . $cor . ">" . "" . "</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . substr($row->{$campos[$i]}, 0, 10) . "</td>";
                                    }
                                } else if ($i == 7) {
                                    if ($row->{$campos[2]} == 'D') {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[27]} . "</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[$i]} . "</td>";
                                    }
                                } else if ($i == 17) {
                                    if ($row->{$campos[2]} == 'D') {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[28]} . "</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[$i]} . "</td>";
                                    }
                                } else if ($i == 18) {
                                    if ($row->{$campos[3]} == 'D') {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[29]} . "</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[$i]} . "</td>";
                                    }
                                } else if ($i == 6) {
                                    if ($row->{$campos[21]} == null) {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[$i]} . "</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . $row->{$campos[5]} . "</td>";
                                    }
                                } else if ($i == 32 || $i == 33) {
                                    if ($row->{$campos[$i]} == 1) {
                                        echo "<td bgcolor=" . $cor . ">" . "SIM</td>";
                                    } else {
                                        echo "<td bgcolor=" . $cor . ">" . "NÃO</td>";
                                    }
                                } else {
                                    echo "<td bgcolor=" . $cor . ">" . $row->{$campos[$i]} . "</td>";
                                }
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
                                $romnumero = '';
                                $romdata = '';
                            }
                            echo "<td bgcolor=" . $cor . ">" . $romnumero . "</td>";
                            echo "<td bgcolor=" . $cor . ">" . $romdata . "</td>";
                            //echo "<td>".pg_num_rows($data)."</td>";
                            echo "</tr>";
                        }
                    }
                }
            }
        }
    }
}

echo "</table></body></html>" . "\r\n";
pg_close($conn);
exit();

