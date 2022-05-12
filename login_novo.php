<?php
include_once("sicops/conexao.php");
//Query count numero de processos abertos
$query_processos_aberto = pg_query("select count(*) from sicops_processo where idstatus = 1");
$array_processos_aberto = pg_fetch_row($query_processos_aberto);

//Query count numero de processos em andamento
$query_processos_andamento = pg_query("select * from sicops_processo where idstatus BETWEEN 2 and 11");
$array_processos_andamento = pg_fetch_row($query_processos_andamento);

//Query count numero de processos concluidos
$query_processos_concluido = pg_query("select count(*) from sicops_processo where idstatus = 12");
$array_processos_concluido = pg_fetch_row($query_processos_concluido);

//Query período de dados exibidos
$query_periodo = pg_query("select datainicial from sicops_processo datainicial order by datainicial asc limit 1");
$array_periodo = pg_fetch_object($query_periodo);
$query_periodo_fim = pg_query("select datainicial from sicops_processo datainicial order by datainicial desc limit 1");
$array_periodo_fim = pg_fetch_object($query_periodo_fim);

list($ano_pi,$mes_pi,$dia_pi)=split("-",$array_periodo->datainicial,3);
list($ano_pf,$mes_pf,$dia_pf)=split("-",$array_periodo_fim->datainicial,3);
$periodo_1 = ''.$dia_pi.'/'.$mes_pi.'/'.$ano_pi.'';
$periodo_2 = ''.$dia_pf.'/'.$mes_pf.'/'.$ano_pf.'';	
?>
<html>
<head>
<title>MAX TRADE</title>
<script src="js/geral.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
td img {display: block;}.style5 {font-family: Arial, Helvetica, sans-serif; font-size: medium; font-weight: bold; }
.style6 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #CC0000;
}
</style>
<!--Fireworks CS3 Dreamweaver CS3 target.  Created Fri Dec 19 10:15:21 GMT-0200 2008-->
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
<table border="0" width="100%" height="100%" align="center">
<tr>
<td width="49%" height="475" align="center" valign="middle">
<table border="0" cellpadding="0" cellspacing="0" width="475">
<tr>
<td rowspan="4">
<table border="0" cellpadding="0" cellspacing="0" width="475">
<form method="post" action="login_vai.php">
  <!-- fwtable fwsrc="maxtrade.png" fwpage="Page 1" fwbase="index2.gif" fwstyle="Dreamweaver" fwdocid = "622025872" fwnested="0" -->
  <tr>
    <td><img src="imagenmax/spacer.gif" width="120" height="1" border="0" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="48" height="1" border="0" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="156" height="1" border="0" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="41" height="1" border="0" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="110" height="1" border="0" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="5"><img name="index2_r1_c1" src="imagenmax/index2_r1_c1.gif" width="475" height="142" border="0" id="index2_r1_c1" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="1" height="142" border="0" alt="" /></td>
  </tr>
  <tr>
    <td rowspan="4"><img name="index2_r2_c1" src="imagenmax/index2_r2_c1.gif" width="120" height="172" border="0" id="index2_r2_c1" alt="" /></td>
    <td rowspan="3"><img name="index2_r2_c2" src="imagenmax/index2_r2_c2.gif" width="48" height="70" border="0" id="index2_r2_c2" alt="" /></td>
    <td rowspan="3" background="imagenmax/index2_r2_c3.gif">
<div ><input name="login" type="text" style="width:150px;" onBlur="convertField(this)" onKeyPress="maiusculo()" size="18">
</div>
<div style="margin-top:5px; margin-bottom:15px;"><input type="password" name="senha" onBlur="convertField(this)" onKeyPress="maiusculo()" style="width:150px;"></div>
    </td>
    <td><img name="index2_r2_c4" src="imagenmax/index2_r2_c4.gif" width="41" height="24" border="0" id="index2_r2_c4" alt="" /></td>
    <td rowspan="4"><img name="index2_r2_c5" src="imagenmax/index2_r2_c5.gif" width="110" height="172" border="0" id="index2_r2_c5" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="1" height="24" border="0" alt="" /></td>
  </tr>
  <tr>
    <td><input type="image" src="imagenmax/index2_r3_c4.gif"></td>
    <td><img src="imagenmax/spacer.gif" width="1" height="26" border="0" alt="" /></td>
  </tr>
  <tr>
    <td><img name="index2_r4_c4" src="imagenmax/index2_r4_c4.gif" width="41" height="20" border="0" id="index2_r4_c4" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="1" height="20" border="0" alt="" /></td>
  </tr>
  <tr>
    <td colspan="3"><img name="index2_r5_c2" src="imagenmax/index2_r5_c2.gif" width="245" height="102" border="0" id="index2_r5_c2" alt="" /></td>
    <td><img src="imagenmax/spacer.gif" width="1" height="102" border="0" alt="" /></td>
  </tr>
</form>
</table>

</td>
   </tr>
</table>
</td>
<td width="51%" height="475" align="center" valign="middle">

<table border="0" cellpadding="0" cellspacing="0" width="475">
<form>
<!-- fwtable fwsrc="sicops.png" fwpage="Page 1" fwbase="index.gif" fwstyle="Dreamweaver" fwdocid = "622025872" fwnested="0" -->
  <tr>
   <td><img src="imagensicops/spacer.gif" width="29" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="53" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="121" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="35" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="34" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="121" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="60" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="22" height="1" border="0" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="1" border="0" alt="" /></td>
  </tr>

  <tr>
   <td colspan="8"><img name="index_r1_c1" src="imagensicops/index_r1_c1.gif" width="475" height="120" border="0" id="index_r1_c1" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="120" border="0" alt="" /></td>
  </tr>
  <tr>
   <td rowspan="4" colspan="4"><img name="index_r2_c1" src="imagensicops/index_r2_c1.gif" width="238" height="88" border="0" id="index_r2_c1" alt="" /></td>
   <td colspan="3" background="imagensicops/index_r2_c5.gif"><span class="style5">
     <?=$array_processos_aberto[0];?></span></td>
   <td rowspan="4"><img name="index_r2_c8" src="imagensicops/index_r2_c8.gif" width="22" height="88" border="0" id="index_r2_c8" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="22" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3" background="imagensicops/index_r3_c5.gif"><span class="style5">
     <?=$array_processos_andamento['0'];?></span></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="22" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3" background="imagensicops/index_r4_c5.gif"><span class="style5">
     <?=$array_processos_concluido['0'];?></span></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="22" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="3" background="imagensicops/index_r5_c5.gif"><span class="style5">
     <?=$periodo_1;?> 
     - 
     <?=$periodo_2;?></span></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="22" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="4"><img name="index_r6_c1" src="imagensicops/index_r6_c1.gif" width="238" height="34" border="0" id="index_r6_c1" alt="" /></td>
   <td colspan="4"><img name="index_r6_c5" src="imagensicops/index_r6_c5.gif" width="237" height="34" border="0" id="index_r6_c5" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="34" border="0" alt="" /></td>
  </tr>
  <tr>
   <td colspan="2"><img name="index_r7_c1" src="imagensicops/index_r7_c1.gif" width="82" height="31" border="0" id="index_r7_c1" alt="" /></td>
   <td><a href="sicops/verifica.php"><img name="index_r7_c3" src="imagensicops/index_r7_c3.gif" width="121" height="31" border="0" id="index_r7_c3" alt="" /></a></td>
   <td rowspan="2"><img name="index_r7_c4" src="imagensicops/index_r7_c4.gif" width="35" height="72" border="0" id="index_r7_c4" alt="" /></td>
   <td><img name="index_r7_c5" src="imagensicops/index_r7_c5.gif" width="34" height="31" border="0" id="index_r7_c5" alt="" /></td>
   <td><a href="sicops/processos.php"><img name="index_r7_c6" src="imagensicops/index_r7_c6.gif" width="121" height="31" border="0" id="index_r7_c6" alt="" /></a></td>
   <td colspan="2"><img name="index_r7_c7" src="imagensicops/index_r7_c7.gif" width="82" height="31" border="0" id="index_r7_c7" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="31" border="0" alt="" /></td>
  </tr>
  <tr>
   <td><img name="index_r8_c1" src="imagensicops/index_r8_c1.gif" width="29" height="41" border="0" id="index_r8_c1" alt="" /></td>
   <td colspan="2"><img name="index_r8_c2" src="imagensicops/index_r8_c2.gif" width="174" height="41" border="0" id="index_r8_c2" alt="" /></td>
   <td colspan="4"><img name="index_r8_c5" src="imagensicops/index_r8_c5.gif" width="237" height="41" border="0" id="index_r8_c5" alt="" /></td>
   <td><img src="imagensicops/spacer.gif" width="1" height="41" border="0" alt="" /></td>
  </tr>
</form>
</table>
</td>
</tr>
<tr>
<td colspan="2" align="center" valign="top"><span class="style6"><a href="http://www.baraobrinquedos.com.br/chamado/">Acesso ao Sistema de Atendimento - HelpDesk</a></span></td>
</tr>
</table>

</body>
</html>