<?php
include 'include/jquery.php';
include 'include/css.php';
?>

<script src="modulos/sac/view/js/reset.js"
type="text/javascript"></script>

<script src="modulos/sac/view/js/pesqTrans.js"
type="text/javascript"></script>

<script src="modulos/sac/view/js/validacao.js"
type="text/javascript"></script>

<script src="modulos/sac/view/js/funcoes.js"
type="text/javascript"></script>

<script src="lib/jquery/max/populaComboxSacProblemaMacro.js"
type="text/javascript"></script>

<script src="lib/jquery/max/populaComboxSacProblema.js"
type="text/javascript"></script>

<script src="modulos/sac/view/js/getPedidos.js"
type="text/javascript"></script>
<script src="modulos/sac/view/js/verificacao.js"
type="text/javascript"></script>

<script src="modulos/sac/view/js/crud.js"
type="text/javascript"></script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<div align="center">
    <div id="retorno"></div>
    <div id="retornoLiberacao"></div>
    <div id="dialog"></div>

    <input type='hidden' name='usuario' id='usuario' value='<? echo $_SESSION['usuario']; ?>'/>

    <table width="796" height="130" border="2" cellspacing="0"
           cellpadding="0" bordercolor="#999999">
        <tr>
            <td width="100%">

                <table width="100%" border="0" cellpadding="0" cellspacing="0"
                       bgcolor="#3366CC">
                    <tr>
                        <td valign="middle" height="25">
                            <div align="center"><font color="#FFFFFF"
                                                      face="Verdana, Arial, Helvetica, sans-serif"> <strong>SAC - CONSULTA DE CHAMADOS</strong> </font></div>
                        </td>
                    </tr>

                    <tr bgcolor="#CCCCCC">
                        <td valign="top" width="100%">

                            <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                <tr bgcolor="#CCCCCC">
                                    <td height="20" colspan="4">&nbsp;</td>
                                </tr>

<!--					<tr bgcolor="#CCCCCC">
                                                <td colspan="4" valign="middle">&nbsp;&nbsp;&nbsp;&nbsp;<b><i>Escolha
                                                o Cliente:</i></b></td>
                                        </tr>-->

                                <tr bgcolor="#CCCCCC">
                                    <td height="17" colspan="4">&nbsp;</td>
                                </tr>

                                <tr bgcolor="#CCCCCC">
                                    <td height="17" colspan="4"><!-- incluir componente de pesquisa de clientes -->
                                        <?php include_once("pesquisaClientesSacCod.php"); ?>

                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                </tr>

                                <tr>
                                    <td colspan="6">&nbsp;</td>
                                </tr>

                                <tr bgcolor="#CCCCCC">
                                    <td height="20" colspan="4">
                                        <hr size="1" />
                                    </td>
                                </tr>
                            </table>


                            <table width="100%" height="599" border="0" cellpadding="2"
                                   cellspacing="0" bgcolor="#CCCCCC">





                                <tr>
                                    <td width="100%">
                                        <form name="formManutencaoSac">


                                            <div align = 'center' id="resultado"></div>

                                            <tr bgcolor="#3366CC">
                                            <!--						<td bgcolor="#3366CC">&nbsp;</td>-->
                                                <td colspan="6" bgcolor="#3366CC">
                                                    <div align="center"><font color="#FFFFFF">Cliente</font></div>
                                                </td>
                                            </tr>





<!--                        <tr>
<td>&nbsp;</td>
<td><i>Dados Cadastrais Alterado por:  </i></td>
<td colspan="3"><div id="altDados"></div></td>

                        </tr>-->

                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Protocolo:</div>
                                                </td>
                                                <td colspan="3"><input id="saccodigo" type="text"
                                                                       name="saccodigo" size="" size="20"  style="font-weight: bold" disabled>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    Problema Macro:<select id="sacproblemmacro"  name="sacproblemmacro"  class="populaProblemaMacro" size="1"></select>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Atendimento:</div>
                                                </td>
                                                <td colspan="3" id="usuariosac" name="usuariosac">
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td nowrap="nowrap">
                                                    <div align="left" >Tipo de Atendimento:</div>
                                                </td>
                                                <td colspan="2">
                                                    <input id="tpatendimento" name="tpatendimento" type="radio" value="1" checked> Ativo
                                                    <input id="tpatendimento"  name="tpatendimento" type="radio" value="2"> Receptivo
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Data Reclamação:</div>
                                                </td>
                                                <td colspan="3" class="datachamado"  name="datachamado" >

                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>


                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Cliente:</div>
                                                </td>
                                                <td colspan="3"><input id="clinguerra" type="text"
                                                                       name="clinguerra" size="40"  style="font-weight: bold" disabled>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    CNPJ:<input id="clicnpj"
                                                                type="text" name="clicnpj" size="16"
                                                                style="text-align: left;" style="font-weight: bold" disabled>
                                                    <input id="clicod"
                                                           type="hidden" name="clicod" size="16"
                                                           style="text-align: left;font-weight: bold" disabled>
                                                    <input id="countajx"
                                                           type="hidden" name="countajx" val ="0" size="16"
                                                           style="text-align: left;font-weight: bold" disabled>

                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Razao Social:</div>
                                                </td>
                                                <td colspan="3"><input id="clirazao" type="text"
                                                                       name="clirazao" size="52"  style="font-weight: bold" disabled>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Cidade:</div>
                                                </td>
                                                <td colspan="3"><input id="clecidade" type="text"
                                                                       name="clecidade" size="52"  style="font-weight: bold" disabled>
                                                    &nbsp;
                                                    UF:<input id="cleuf"
                                                              type="text" name="cleuf" size="4"
                                                              style="text-align: left;font-weight: bold" disabled>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Regiao:</div>
                                                </td>
                                                <td colspan="3"><input id="sacregiao" type="text"
                                                                       name="sacregiao" size="26" maxlength="20">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<!--                                                Vendedor:&nbsp;&nbsp;  <input id="venrazao"
                                                        type="text" name="venrazao" size="20" 
                                                        style="text-align: left;font-weight: bold" disabled />
                                                Codigo: <input id="vencodigo" type="text" name="vencodigo"
                                                               size="4"  style="font-weight: bold" disabled />-->
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Telefone:</div>
                                                </td>
                                                <td colspan="3"><input id="clefone" type="text"
                                                                       name="clefone" size="16"  style="font-weight: bold" disabled>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;
                                                    Contato:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="ccfnome0"
                                                                                                 type="text" name="ccfnome0" size="20"
                                                                                                 style="text-align: left;font-weight: bold" disabled>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Tel. Alternativo:</div>
                                                </td>
                                                <td colspan="3"><input id="sactelalt" type="text"
                                                                       name="sacfone" size="16" maxlength="15">
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>


                                            <tr>
    <!--						<td bgcolor="#3366CC">&nbsp;</td>-->
                                                <td colspan="6" bgcolor="#3366CC">
                                                    <div align="center"><font color="#FFFFFF">Nota Fiscal</font></div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Nota Fiscal Cliente:</div>
                                                </td>
                                                <td colspan="3"><input id="sacnfcli" type="text"
                                                                       name="sacnfcli" size="12" maxlength="20">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;
                                                    Envio:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="sacnfclienvio"
                                                                                                           type="text" name="sacnfclienvio" size="16" maxlength="12"
                                                                                                           style="text-align: left;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Emissão:</div>
                                                </td>
                                                <td colspan="3"><input id="sacnfcliemissao" type="text"
                                                                       name="sacnfcliemissao" size="12" maxlength="12">
                                                <td>&nbsp;</td>
                                            </tr>



                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>



                                            <tr bgcolor="#3366CC">
    <!--						<td bgcolor="#3366CC">&nbsp;</td>-->
                                                <td colspan="6" bgcolor="#3366CC">
                                                    <div align="center"><font color="#FFFFFF">Ocorrência</font></div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Problema:</div>
                                                </td>
                                                <td colspan="3">
                                                    <select class="populaProblema" id="sacproblem" name="sacproblem"></select>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;
                                                    Contato:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="saccontato"
                                                                                                       type="text" name="saccontato" size="23" maxlength="25"
                                                <td>&nbsp;</td>
                                            </tr>

<!--                                        <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                <div align="left">Nota Fiscal:</div>
                                                </td>
                                                <td colspan="3"><input id="nf" type="text"
                                                                       name="nf" size="12"  disabled style="font-weight: bold">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                Local de Faturamento:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="localfaturamento"
                                                        type="text" name="localfaturamento" size="20" 
                                                        style="text-align: left;font-weight: bold" disabled>
                                                <td>&nbsp;</td>
                                        </tr>-->



                                            <tr >
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left" >Pedido:</div>
                                                </td>
                                                <td colspan="3"><input id="clipedido" type="text"
                                                                       name="clipedido" size="12"  style="font-weight: bold" >&nbsp;
                                                    <input type="button" id="btnPesquisaPedidos" name="consulta_pedido" value="Pesquisar" />
                                                    <span id="msgPesqPedido" style="display:none"><em> Processando pesquisa, aguarde conclusão!</em></span>
                                                <td>&nbsp;</td>
                                            </tr>

<!--                                        <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                <div align="left">Data Faturamento:</div>
                                                </td>
                                                <td colspan="3"><input id="dtfaturamento" type="text"
                                                                       name="dtfaturamento" size="12" style="font-weight: bold" disabled>
                                                <td>&nbsp;</td>
                                        </tr>

                                        <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                <div align="left">Tipo de Pedido ........:</div>
                                                </td>
                                                <td colspan="3"><input id="tipopedido" name="tipopedido" type="text"
                                                                       size="22" style="font-weight: bold" disabled>
                                                <td>&nbsp;</td>
                                        </tr>-->
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Observação Canhoto:</div>
                                                </td>
                                                <td colspan="3"><input id="nfobs" type="text"
                                                                       name="nfobs" size="52" style="font-weight: bold" >
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <!--                                                Transp.:<input id="transpPedido"
                                                        type="text" name="transpPedido" size="16"
                                                            style="text-align: left;" style="font-weight: bold" disabled>-->
                                                <td>&nbsp;</td>
                                            </tr>
    <!--                                        <tr>
                                                <td>&nbsp;</td>
                                            </tr>-->
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Observação Cliente:</div>
                                                </td>
                                                <td colspan="2" ><textarea name="cliobs" id="cliobs" cols="86"
                                                                           rows="3"></textarea></td>
                                                <td>&nbsp;</td>
                                            </tr>
    <!--                                        <tr>
                                                    <td>&nbsp;</td>
                                                    <td>
                                                <div align="left">Observação do Pedido:</div>
                                                </td>
                                                    <td colspan="2"><textarea name="pedidoobs" id="pedidoobs" cols="75"
                                                                              rows="3" style="font-weight: bold" disabled></textarea></td>
                                                    <td>&nbsp;</td>
                                        </tr>-->


                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td colspan="6" bgcolor="#3366CC">
                                                    <div align="center"><font color="#FFFFFF">Item</font></div>
                                            </tr>


                                            <tr bgcolor="#FFFFFF">
                                                <td height="25" colspan="6">
                                                    <table width="99%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            <tr bgcolor="#FFFFFF">
                                                                <td width="100%" height="25" colspan="6">
                                                                    &nbsp;
                                                                    <!--<b>
                                                                    <i>¤ Produto(s) Selecionado(s):</i>
                                                                    .................................................................................................................................
                                                                    </b>-->
                                                                </td>
                                                            </tr>
                                                            <tr bgcolor="#FFFFFF"  id="tableproduto" name="tableproduto" style="display:none">
                                                                <td align="center" width="100%" height="25" colspan="6">
                                                                    <div id="gridprodutomsg" align="center" style="width:763px;"></div>
                                                                    <div align="center" style="width:763px;">
                                                                        <table align="center" width="730" cellspacing="0" cellpadding="0" bordercolor="C0C0C0" border="1">
                                                                            <tbody >

                                                                            <tbody id="gridproduto" name="gridproduto">

                                                                                <tr bgcolor="#3366CC"  >
                                                                                    <td align="center" width="50" height="20">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Pedido</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="50" height="20">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Código</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td width="140"  align="center">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Produto</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <!--<td align="center" width="65" nowrap="nowrap">
                                                                                    <font  color="#FFFFFF">
                                                                                    <b>Qtde no Pedido</b>
                                                                                    </font>
                                                                                    </td>-->
                                                                                    <td align="center" width="50">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Qtd</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="50">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Preço</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="50">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Total</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="120" >
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Local de Faturamento</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="50" nowrap="nowrap">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Qtd na Ocorrência</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="120" >
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Responsável</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="120">
                                                                                        <font  color="#FFFFFF">
                                                                                        <b>Observação</b>
                                                                                        </font>
                                                                                    </td>
                                                                                    <td align="center" width="10">
                                                                                        <input type="checkbox" class="selectAllProd">
                                                                                    </td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr bgcolor="#FFFFFF">
                                                                <td align="center" width="100%" height="25" colspan="6">
                                                                    <div  align="center" style="width:763px;"></div>
                                                                    <div  align="center" style="width:763px;"></div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>


<!--					<tr>
                                                <td bgcolor="#3366CC">&nbsp;</td>
                                                <td colspan="6" bgcolor="#3366CC">
                                                <div align="center"><font color="#FFFFFF">Vales</font></div>
                                                </td>
                                        </tr>

<td height="25" colspan="6">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr bgcolor="#FFFFFF">
<td width="100%" height="25" colspan="6">
    &nbsp;
                                            <!--<b>
                                            <i>¤ Produto(s) Selecionado(s):</i>
                                            .................................................................................................................................
                                            </b>
                                            </td>
                                            </tr>
                                            <tr id="tablevale" name="tablevale" bgcolor="#FFFFFF" style="display:none">
                                            <td align="center" width="100%" height="25" colspan="6">
                                            <div align="center" style="width:763px;"></div>
                                            <div  align="center" style="width:763px;">
                                            <table align="center" width="730" cellspacing="0" cellpadding="0" bordercolor="C0C0C0" border="1">
                                            <tbody>

                                            <tbody id="gridvale" name="gridvale" >

                                            <tr bgcolor="#3366CC"  >
                                            <td align="center" width="50" height="20">
                                            <font  color="#FFFFFF">
                                            <b>Vale</b>
                                            </font>
                                            </td>
                                            <td width="50" align="center">
                                            <font  color="#FFFFFF">
                                            <b>Valor</b>
                                            </font>
                                            </td>

                                            </tbody>
                                            </table>
                                            </div>
                                            </td>
                                            </tr>
                                            <tr bgcolor="#FFFFFF">
                                            <td align="center" width="100%" height="25" colspan="6">
                                            <div align="center" style="width:763px;"></div>
                                            <div align="center" style="width:763px;"></div>
                                            </td>
                                            </tr>
                                            </tbody>
                                            </table>
                                            </td>
                                            </tr>-->

                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>



                                            <tr>
    <!--						<td bgcolor="#3366CC">&nbsp;</td>-->
                                                <td colspan="6" bgcolor="#3366CC">
                                                    <div align="center"><font color="#FFFFFF">Finalização</font></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Procedência:</div>
                                                </td>
                                                <td >
                                                    <select id="sacproced" name="sacproced" >
                                                        <option value=""> -- Selecione -- </option>
                                                        <option value="1"> Sim</option>
                                                        <option value="2"> Não </option>
                                                    </select>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Data de Retorno:</div>
                                                </td>
                                                <td colspan="3"><input id="dataretorno" type="text"
                                                                       name="dataretorno" size="12" maxlength="10">
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Forma de Retorno:</div>
                                                </td>
                                                <td colspan="3">
                                                    <select id="sacformretorno" name="sacformretorno" >
                                                        <option value=""> -- Selecione forma de retorno -- </option>
                                                        <option value="1"> Telefone</option>
                                                        <option value="2"> Email </option>
                                                        <option value="3"> Impresso </option>
                                                    </select>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;
                                                    Contato:&nbsp;&nbsp;&nbsp;&nbsp;<input id="saccontatostatus"
                                                                                           type="text" name="saccontatostatus" size="16" maxlength="25"
                                                                                           style="text-align: left;">
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Data Reclamação:</div>
                                                </td>
                                                <td  class="dataChamado"  name="dataChamado" nowrap="nowrap" ></td>
                                                <td  id ="opcoesPesquisaTransp" style="display: none" name ="opcoesPesquisaTransp">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp" value="1" align="middle" checked>Cód.
                                                    <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp" value="2" align="middle">N° Guerra
                                                    <input type="radio" name="opcoesTipoPesquisaTransp" id="opcoesTipoPesquisaTransp" value="3" align="middle" >Razão
                                                </td>
                                            </tr>
   <!--                                         <tr>
                                                   <td>&nbsp;</td>
                                        </tr>-->
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Valor Frete Reverso:</div>
                                                </td>
                                                <td colspan="3"><input id="sacfretereverso" type="text"
                                                                       name="sacfretereverso" size="12" maxlength="10">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;

                                                    Transp.:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="txtPesquisaTransp"
                                                                                                 type="text" name="txtPesquisaTransp" size="16" maxlength="11"
                                                                                                 style="text-align: left;">
                                                    <input type="button" id="consulta_transportadora" name="consulta_transportadora" value="Pesquisar" />
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Assistência Técnica:</div>
                                                </td>
                                                <td >
                                                    <select id="sacassistencia" name="sacassistencia" >
                                                        <option value=""> -- Selecione -- </option>
                                                        <option value="1"> Sim</option>
                                                        <option value="2"> Não </option>
                                                    </select>
                                                </td>
                                                <td id="listTransp" >
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <select id="listaPesquisaTransp" name="listaPesquisaTransp" size="1" style="display: none">
                                                    </select>
                                                </td>


                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Cliente Especial:</div>
                                                </td>
                                                <td >

                                                    <select id="saccliespecial"	name="saccliespecial">
                                                        <option value=""> -- Selecione -- </option>
                                                        <option value="1"> Sim</option>
                                                        <option value="2"> Não </option>
                                                    </select>


                                                </td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    Exceção:
                                                </td>
                                                <td>
                                                    <select id="sacexcecao" name="sacexcecao" >
                                                        <option value=""> -- Selecione -- </option>
                                                        <option value="1"> Sim</option>
                                                        <option value="2"> Não </option>
                                                    </select>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Observação:</div>
                                                </td>
                                                <td colspan="2"><textarea name="sacstatusobs" id="sacstatusobs" cols="75"
                                                                          rows="3"></textarea></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <div align="left">Status:</div>
                                                </td>
                                                <td colspan="3">
                                                    <select id="listaStatus" name="listaStatus" >
                                                        <option value=""> -- Escolha o Status -- </option>
                                                        <option value="1">Aberto</option>
                                                        <option value="2">Em andamento</option>
                                                        <option value="3">Finalizado</option>
                                                    </select>


                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;


                                                    <!--                                                Data:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                                    <!--                                                <input id="dataStatus" type="text" name="dataStatus" size="16" maxlength="11" readonly
                                                        style="text-align: left;">-->
                                            <spam id="dataStatus"  name="dataStatus" 	style="text-align: left;" />
                                            <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;



                                        <!--                                                Data:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                                        <!--                                                <input id="dataStatus" type="text" name="dataStatus" size="16" maxlength="11" readonly
                                                        style="text-align: left;">-->
                                <spam id="dataStatus2"  name="dataStatus2" 	style="text-align: left;" />
                                <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="3">&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


                            <!--                                                Data:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                            <!--                                                <input id="dataStatus" type="text" name="dataStatus" size="16" maxlength="11" readonly
                                                        style="text-align: left;">-->
                    <spam id="dataStatus3"  name="dataStatus3" 	style="text-align: left;" />
                    <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="4">
                <div align="center">
<!--                                                    <input name="btnConcluiFormulario"
                                                        type="button" id="btnConcluiFormulario" value="Concluir">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
                    <input name="btnLimpaFormulario"
                           type="button" id="btnLimpaFormulario" value="Limpar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp; &nbsp; &nbsp;


                </div>
            </td>
        <input name="hidden" type="hidden" id="acao" value="alterar">
        <td>&nbsp;</td>
        </form>

        </tr>

        <!-- incluindo verificar login -->
        <script type="text/javascript">
            usuario = new Object();
            usuario = eval('(' + document.getElementById('usuario').value + ')');

            //inclui script de configuração globais do js
            document.body.appendChild(document.createElement('script')).src = 'lib/jquery/max/config.js';
        </script>


    </table>

</td>
</tr>
</table>
</table>



</div>

<!--<div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana"
size="2">Processando...</font></div>-->
<!--<div align = 'center' id="resultado">
</div>-->

