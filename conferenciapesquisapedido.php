<?php

require_once('./include/config.php');
require_once("include/conexao.inc.php");
require_once("include/conferencia.php");

//$pvnumero = trim($_POST["pvnumero"]);
$pvnumero = trim($_GET["pvnumero"]);

if (MAX_NOVO == 1) {
    $cadastro = new banco($conn, $db);
    $data = $cadastro->seleciona($pvnumero);
} else {

    $sql = "SELECT c.procod as codigo,c.prnome as descricao,a.pviest026 as estoque,b.pvcconfere as conferido
            FROM pvitem a,produto c
            LEFT JOIN pvendaconfere as b on b.procodigo = c.procodigo AND b.pvnumero = {$pvnumero} 
            WHERE a.pvnumero = {$pvnumero} 
            and a.procodigo = c.procodigo
            order by procod";

    $data = pg_query($sql);
}

//se encontrar registros
if (pg_num_rows($data)) {
    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    $xml .= "<dados>";
    $xml .= "<cabecalho>";

    //cabecalho da tabela
    for ($i = 0; $i < sizeof($campos); $i++) {
        $xml .= "<campo>" . $campos[$i] . "</campo>";
    }

    $xml .= "</cabecalho>";

    //corpo da tabela
    while ($row = pg_fetch_object($data)) {
        $xml .= "<registro>";
        for ($i = 0; $i < sizeof($campos); $i++) {
            $xml .= "<item>" . $row->{$campos[$i]} . "</item>";
        }
        $xml .= "</registro>";
    }

    //fim da tabela
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
