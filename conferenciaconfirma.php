<?php
$codigo=trim($_GET["pvnumero"]);
$conferente=trim($_GET["conferente"]);
$separador=trim($_GET["separador"]);
$sepinicio=trim($_GET["sepinicio"]);
$sepfim=trim($_GET["sepfim"]);
$conini=trim($_GET["conini"]);

?>

<script language="JavaScript1.2">

function voltar(){
                 window.open('conferencia.php?pvnumero=' + <?=$codigo?>
                 + '&conferente=' + <?=$conferente?>
                 + '&separador=' + <?=$separador?>
                 + '&sepinicio=' + "<?=$sepinicio?>"
                 + '&sepfim=' + "<?=$sepfim?>"
                 + '&conini=' + "<?=$conini?>"
                 , '_self');
}
</script>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Tabela</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="js/prototype.lite.js"></script>
<script src="js/moo.ajax.js"></script>
<script src="js/conferencia.js"></script>
<link href="css/max.css" rel="stylesheet" media="all">
<noscript>
Habilite o Javascript para visualizar esta página corretamente...
</noscript>
<style>
.borda{border: 1px solid;}
div{font-family: Verdana; font-size: 12px;}
td{font-family: Verdana; font-size: 12px;}
input{font-family: Verdana; font-size: 12px;}

.row-max .cell-max:nth-child(1) {
    text-align: center;
    padding-left: 5px;
}
.row-max .cell-max:nth-child(2) {
    text-align: center;
    padding-right: 5px;
}
.row-max .cell-max:nth-child(3) {
    text-align: center;
    padding-right: 5px;
}
.row-max .cell-max:nth-child(4) {
    text-align: center;
    padding-right: 5px;
}
</style>

</head>
<body onLoad=load_grid(<?=$codigo?>)>

<div class="result">
    O Pedido: <?=$codigo?> ainda não está conferido.
</div>



<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
<div class="wrapper wrapper--w960">
        <div class="result" id="resultado"></div> 
</div>
<div class="wrapper wrapper--w960">
        <div class="result" id="resultado2"></div> 
</div>
<br>
<div class="p-t-15 centraliza">
  <button class="btn btn--radius-2 btn--blue" type="button" id="botao2" onClick="javascript:voltar();">Voltar</button>
</div>
</body>
</html>
