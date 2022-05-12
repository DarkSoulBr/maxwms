<?php

require_once("include/conexao.inc.php");


$datainicio = explode("/", $_GET['dataini']);
$datafim = explode("/", $_GET['datafim']);

$auxdatainicio = $datainicio[2] . '-' . $datainicio[1] . '-' . $datainicio[0] . ' 00:00:00';
$auxdatafim = $datafim[2] . '-' . $datafim[1] . '-' . $datafim[0] . ' 23:59:59';

$sql = "Select ctecancelado.*,cadusuarios.usdescricao FROM ctecancelado,cadusuarios where ctecancelado.ctedata between '$auxdatainicio' and '$auxdatafim' and ctecancelado.cteusuario = cadusuarios.uscodigo order by ctecancelado.cteccodigo asc";

//print($sql); die;

$cad = pg_query($sql);

if (pg_num_rows($cad)) {
    $row = pg_num_rows($cad);

    header("Content-type: application/xml");
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
    $xml .= "<dadoslista>";
    $valor = 0;
    for ($i = 0; $i < $row; $i++) {

        $xml .= "<registrolista>";


        $ctecprotocolo = pg_fetch_result($cad, $i, "ctecprotocolo");
        $ctecmotivo = pg_fetch_result($cad, $i, "ctecmotivo");
        $usdescricao = pg_fetch_result($cad, $i, "usdescricao");
        $ctedata = pg_fetch_result($cad, $i, "ctedata");

        $ctenumero = pg_fetch_result($cad, $i, "ctenumero");
        $ctenum = pg_fetch_result($cad, $i, "ctenum");
        $ctechaveref = pg_fetch_result($cad, $i, "ctechaveref");

        //Mascara data
        $aux = explode(" ", $ctedata);
        $aux1 = explode("-", $aux[0]);
        $ctedata = $aux1[2] . '/' . $aux1[1] . '/' . $aux1[0];

        $xml .= "<itemlista>" . $ctenumero . "</itemlista>";
        $xml .= "<itemlista>" . $ctenum . "</itemlista>";
        $xml .= "<itemlista>" . $ctechaveref . "</itemlista>";

        $xml .= "<itemlista>" . $ctecprotocolo . "</itemlista>";
        $xml .= "<itemlista>" . $ctecmotivo . "</itemlista>";
        $xml .= "<itemlista>" . $usdescricao . "</itemlista>";
        $xml .= "<itemlista>" . $ctedata . "</itemlista>";



        $xml .= "</registrolista>";
    }
    $xml .= "</dadoslista>";
}
echo $xml;
pg_close($conn);
exit();
?>