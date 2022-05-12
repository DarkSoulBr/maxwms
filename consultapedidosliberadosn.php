<?php
$flagmenu = 3;

require("verifica.php");
//require_once("include/config.php");

include 'include/jquery.php';
include 'include/css.php';

//Verifica se a opção existe no Cadastros de Opção
$opcao = 'CONSULTA LIBERADOS';
$pagina = 'consultapedidosliberadosn.php';
$modulo = 3;  //Logistica
$sub = 11;  //Liberacao
$usuario = $_SESSION["id_usuario"];

$vartxt = $_GET['vartxt'];
$dataIniciox = $_GET['dataInicio'];
$horaIniciox = $_GET['horaInicio'];
$dataFimx = $_GET['dataFim'];
$horaFimx = $_GET['horaFim'];
$tpx = $_GET['tp'];
$tp2x = $_GET['tp2'];
$tptx = $_GET['tpt'];
$tpex = $_GET['tpe'];
$tpzx = $_GET['tpz'];
$tplx = $_GET['tpl'];
$campovet1x = $_GET['campovet1'];
$campovet2x = $_GET['campovet2'];
$campovet3x = $_GET['campovet3'];
?>

<script src="js/consultapedidosliberadosn.js"></script>
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/validaAdm.js"></script>
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/adm/view/js/verificaAdm.js"></script>

<div align="center">
    <div id="retorno"></div>
    <div id="dialog" style="margin-left: 5px; margin-left: 5px;"></div>

<!--<body onload="inicia('<?php echo $usuario ?>');">-->

    <body onload="inicia('<?php echo $usuario ?>', '<?php echo $vartxt ?>', '<?php echo $dataIniciox ?>', '<?php echo $horaIniciox ?>', '<?php echo $dataFimx ?>', '<?php echo $horaFimx ?>', '<?php echo $tpx ?>', '<?php echo $tp2x ?>', '<?php echo $tptx ?>', '<?php echo $tpex ?>', '<?php echo $tpzx ?>', '<?php echo $tplx ?>', '<?php echo $campovet1x ?>', '<?php echo $campovet2x ?>', '<?php echo $campovet3x ?>');">	
        <table id="tblPrincipal" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
            <tr>
                <td>
                    <table width="100%" height="20" border="0" cellpadding="0"
                           cellspacing="0" bgcolor="#3366CC">
                        <tr>
                            <td colspan="5">
                                <div align="center"><font color="#FFFFFF"
                                                          face="Verdana, Arial, Helvetica, sans-serif"><strong>Consulta de Pedidos Liberados</strong></font></div>
                            </td>
                        </tr>
                    </table>

                    <div id="accordion">

                        <h3><a href="#consultapedidosliberadosn.php">Localizar</a></h3>
                        <div style="background:#CCCCCC;">
                            <table width="100%" border="0" cellpadding="0"
                                   cellspacing="0" bgcolor="#CCCCCC">

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>



                                <tr bgcolor="#CCCCCC">
                                    <td valign="middle" align="center" colspan="4">
                                        <table border="0" cellpadding="0" cellspacing="0" width="60%">

                                            <tr bgcolor="#CCCCCC">
                                                <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Periodo Pesquisa:</i></b></td>
                                            </tr>



                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="4">
                                                    <form id="formPeriodo" name="formPeriodo" method="post" action="#">
                                                        <table>
                                                            <tr bgcolor="#CCCCCC">
                                                                <td valign="middle" width="120">Data Inicial:</td>
                                                                <td valign="middle">
                                                                    <input id="dataInicio" type="text" name="dataInicio" size="12">
                                                                </td>
                                                                <td valign="middle" width="120">Hora Inicial:</td>
                                                                <td valign="middle">
                                                                    <input id="horaInicio" type="text" name="horaInicio" size="12">
                                                                </td>
                                                            </tr> 
                                                            <tr bgcolor="#CCCCCC">
                                                                <td valign="middle" width="120">Data Final:</td>
                                                                <td valign="middle">
                                                                    <input id="dataFim" type="text" name="dataFim" size="12">
                                                                </td>
                                                                <td valign="middle" width="120">Hora Final:</td>
                                                                <td valign="middle">
                                                                    <input id="horaFim" type="text" name="horaFim" size="12">
                                                                </td>
                                                            </tr>         
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td height="10" colspan="4"><hr size="1"/></td>
                                            </tr>								

                                        </table>
                                    </td>
                                </tr>





                                <tr bgcolor="#CCCCCC">
                                    <td valign="middle" align="center" colspan="4">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">



                                            <tr bgcolor="#CCCCCC">
                                                <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <b><i>Opções Pesquisa:</i></b></td>
                                            </tr>

                                            <tr>
                                                <td colspan="4" >
                                                    <div align="center">
                                                        <input type="radio" id="radio1" name="radio" value="1" checked>Todos
                                                        <input type="radio" id="radio2" name="radio" value="2">Conferidos
                                                        <input type="radio" id="radio3" name="radio" value="3">Não Conferidos
                                                        <input type="radio" id="radio4" name="radio" value="4">Impressos
                                                        <input type="radio" id="radio5" name="radio" value="5">Divergentes
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>


                                            <tr>
                                                <td colspan="4" >
                                                    <div align="center">
                                                        <input type="radio" id="radio21" name="radio2" value="1" checked>Todos
                                                        <input type="radio" id="radio22" name="radio2" value="2">Expedidos
                                                        <input type="radio" id="radio23" name="radio2" value="3">Não Expedidos
                                                    </div>
                                                </td>
                                            </tr>


                                            <tr>
                                                <td colspan="4" >
                                                    <div align="center">
                                                        <input type="radio" id="radiot1" name="radiot" value="1" checked>Todos
                                                        &nbsp;
                                                        <input type="radio" id="radiot2" name="radiot" value="2" >Urgentes
                                                        &nbsp;
                                                        <input type="radio" id="radiot3" name="radiot" value="3" >Não Urgentes
                                                    </div>
                                                </td>
                                            </tr>	

                                            <tr>
                                                <td colspan="4" >
                                                    <div align="center">
                                                        <input type="radio" id="radioe1" name="radioe" value="1" checked>Todos
                                                        &nbsp;
                                                        <input type="radio" id="radioe2" name="radioe" value="2" >Sem Embarque
                                                        &nbsp;
                                                        <input type="radio" id="radioe3" name="radioe" value="3" >Com Embarque
                                                    </div>
                                                </td>
                                            </tr>	

                                            <tr>
                                                <td colspan="4" >
                                                    <div align="center">
                                                        <input type="radio" id="radioz1" name="radioz" value="1" checked>Todos
                                                        &nbsp;
                                                        <input type="radio" id="radioz2" name="radioz" value="2" >Sem NFe
                                                        &nbsp;
                                                        <input type="radio" id="radioz3" name="radioz" value="3" >Com NFe
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr style="display: none">
                                                <td colspan="4" >
                                                    <div align="center">
                                                        <input type="radio" id="radiol1" name="radiol" value="1" checked>Toymania
                                                        &nbsp;
                                                        <input type="radio" id="radiol2" name="radiol" value="2" >Loja Boa Vista
                                                        &nbsp;
                                                        <input type="radio" id="radiol3" name="radiol" value="3" >Todos
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">&nbsp;</td>
                                            </tr>					  

                                        </table>
                                    </td>
                                </tr>

                                <tr bgcolor="#CCCCCC">
                                    <td valign="middle" align="center" colspan="4">
                                        <table border="0" cellpadding="0" cellspacing="0" width="60%">
                                            <tr bgcolor="#CCCCCC">
                                                <td height="10" colspan="4"><hr size="1"/></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha Tipo de Pedido:</i></b></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="4">
                                                    <form id="formTipoPedido" name="formTipoPedido" method="post" action="#">
                                                        <table>
                                                            <tr bgcolor="#CCCCCC">
                                                                <td valign="middle" width="120">Tipo de Pedido:</td>
                                                                <td valign="middle">
                                                                    <select name="listaTipoPedidos" id="listaTipoPedidos" class="populaTipoPedidos" multiple="multiple" size="6"></select>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>

                                <tr bgcolor="#CCCCCC" style="display: none">
                                    <td valign="middle" align="center" colspan="4">
                                        <table border="0" cellpadding="0" cellspacing="0" width="60%">
                                            <tr bgcolor="#CCCCCC">
                                                <td height="10" colspan="4"><hr size="1"/></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha o Vendedor:</i></b></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="4">
                                                    <form id="formEstoqueFisico" name="formEstoqueFisico" method="post" action="#">
                                                        <table>
                                                            <tr bgcolor="#CCCCCC">
                                                                <td valign="middle" width="120">Vendedor:</td>
                                                                <td valign="middle">
                                                                    <select name="listaEstoqueFisico" id="listaEstoqueFisico" class="populaEstoquesFisico" multiple="multiple" size="6"></select>
                                                                </td>
                                                            </tr>        
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr bgcolor="#CCCCCC" style="display: none">
                                    <td valign="middle" align="center" colspan="4">
                                        <table border="0" cellpadding="0" cellspacing="0" width="60%">
                                            <tr bgcolor="#CCCCCC">
                                                <td height="10" colspan="4"><hr size="1"/></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha a Transportadora:</i></b></td>
                                            </tr>

                                            <tr bgcolor="#CCCCCC">
                                                <td valign="middle" colspan="4">
                                                    <form id="formTransportadora" name="formTransportadora" method="post" action="#">
                                                        <table>
                                                            <tr bgcolor="#CCCCCC">
                                                                <td valign="middle" width="120">Transportadora:</td>
                                                                <td valign="middle">
                                                                    <select name="listaTransportadora" id="listaTransportadora" class="populaTransportadora" multiple="multiple" size="6"></select>
                                                                </td>
                                                            </tr>        
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="5" align="center">
                                        <input id="btnConsultaPedidos" type="button" name="btnConsultaPedidos" size="10" value="LOCALIZAR" onclick="imprimirconsulta();">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input id="btnExcel" type="button" name="btnExcel" size="10" value="Excel" onclick="excel();">                                        
                                        <input id="btnCross" type="hidden" name="btnCross" size="10" value="Cross" onclick="cross();">
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="5" align="center">
                                        <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
                                </tr>	

                            </table>
                        </div>

                        <h3><a href="#">Consulta de Pedidos</a></h3>
                        <div id="divResultado" style="background:#CCCCCC;">
                            <br>	
                            <div align="center">				
                                <table id='tblResultado2'></table>
                                <table id='tblResultado3'></table>
                            </div>
                            <br>
                            <table id='tblResultado'>
                            </table>




                            <div align="center">				
                                <table width="700" border="0">
                                    <tr>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="button" id="botao1" onClick="javascript:voltar();" value="VOLTAR">
                                            <input type="button" id="botao2" onClick=imprimir() value="IMPRIMIR">                                            
                                            <input type="button" id="botao3" onClick=todos() value="TODOS">
                                            <input type="button" id="botao31" onClick=nimp() value="NÃO IMPRESSOS">                                            
                                            <input type="button" id="botao4" onClick=Atualiza() value="ATUALIZAR">
                                            <input type="hidden" id="botao21" onClick=impped() value="IMP. PEDIDOS">
                                            <input type="hidden" id="botao5" onClick=gera_datasul() value="DATASUL">

<!--<input type="button" id="botao5" onClick=exporta() value="PALM">-->
                                            <br>
                                            <!--
                                            <br>
                                             Adm.:<input name="adm" type="password" id="adm" onBlur="verificasenha(this.value);" size="10">
                                            --> 
                                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            Pedido:<input name="pedido" type="text" id="pedido" onBlur="verificapedido(this.value);" size="10">

                                            <!--
                                            
                                           <div id="X">&nbsp;</div>
                                           <form name="formulario2">
                                           PALM :
                                           <select name="palm">
                                           <option id="palm" value="0">____</option>
                                           </select>
                                           &nbsp;&nbsp;
                                           Filtra Liberados:
                                           <input type="radio" name="radio" id="radio1" value="1">Sim
                                           <input type="radio" name="radio" id="radio2" checked>Não
                                           </form>
                                            -->

                                        </td>
                                    </tr>
                                </table>
                            </div>


                        </div>		

                    </div>
                </td>
            </tr>
        </table>

        <!--<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
        <div id="resultado"></div>
        -->

</div>
</body>
