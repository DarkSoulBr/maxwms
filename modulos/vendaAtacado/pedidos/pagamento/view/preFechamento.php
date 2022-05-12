<?php
//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
require_once($_SERVER['DOCUMENT_ROOT'] . "/$root/include/config.php");



/**
 * Arquivo de Interface de Liberaçãode Pedidos.
 *
 * Entrada de dados do usuario para ter acesso ao sistema.
 * Este arquivo aquivo segue os padroes estabelecidos no dTrade. 
 * 
 * @name liberacaoPEdido
 * @category VendaAtacado/pedido/liberacao
 * @package modulos/VendaAtacado/pedido/liberacao/view
 * @link modulos/VendaAtacado/pedido/liberacao/view/liberacaoPedido.php
 * @version 1.0
 * @since 04/02/2010
 * @author Douglas <douglas@centroatacadista.com.br>
 * @copyright MaxTrade
 */
?>
<!-- incluindo script jquery para validação formulário forma de pagamento -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/pagamento/view/js/verificaPreFechamento.js"></script>


<!-- incluindo script jquery para validação formulário forma de pagamento -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/pagamento/view/js/validaPreFechamento.js"></script>


<!-- incluindo script jquery para validação formulário forma de pagamento -->
<script type="text/javascript" src="modulos/vendaAtacado/pedidos/pagamento/view/js/alteraPreFechamento.js"></script>


<div align="center">
    <div id="retorno"></div>
    <div id="dialog"></div>

    <table width="800" height="170" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
        <tr>
            <td>
                <table width="100%" height="20" border="0" cellpadding="0"
                       cellspacing="0" bgcolor="#3366CC">
                    <tr>
                        <td colspan="5">
                            <div align="center"><font color="#FFFFFF"
                                                      face="Verdana, Arial, Helvetica, sans-serif"><strong>PreFechamento</strong></font></div>
                        </td>
                    </tr>
                </table>

                <table width="100%" height="80" border="0" cellpadding="0"
                       cellspacing="0" bgcolor="#CCCCCC">

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>

                    </tr>

                    <tr bgcolor="#CCCCCC">
                        <td height="10" colspan="4">
                            <!-- incluir componente de pesquisa de pedidos -->
                            <?php include_once(PESQUISA_PEDIDOS); ?>
                        </td>
                    </tr>


                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>

                        <td>&nbsp;</td>
                    </tr>


                    <tr>
                        <td colspan="7" bgcolor="#3366CC">
                            <div align="center"><font color="#FFFFFF"
                                                      face="Verdana, Arial, Helvetica, sans-serif"><strong>PreFechamento</strong></font></div>
                        </td>
                    </tr>

                    <tr>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>




                    <tr>

                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>

                    <form name="formPreFechamento" id="formPreFechamento" method="POST" action="#">


                        <tr>
                            <td>&nbsp;Forma Pagamento:</td>
                            <td><select id="listaFormaPagamento" name="listaFormaPagamento">
                                    <option value="0">Selecione a forma de Pagamento</option>
                                    <option value="100"> 100 - A VISTA </option>
                                    <option value="101"> 101 - DUPLICATAS </option>
                                    <option value="102"> 102 - CARTAO </option>
                                    <option value="103"> 103 - CHEQUE PRE </option>
                                    <option value="110"> 110 - CHEQUE A VISTA </option>
                                    <option value="104"> 104 - ORDEM PAGAMENTO </option>
                                    <option value="105"> 105 - VALES </option>
                                    <option value="111"> 111 - DESCONTOS COMERCIAIS </option>
                                    <option value="112"> 112 - DESCONTOS FINANCEIRO </option>
                                </select></td>
                            <td>Num Docto :</td>
                            <td><input id="fecdocto" type="text" name="fecdocto" size="22"></td>
                        </tr>

                        <tr>

                            <td>&nbsp;Valor :</td>
                            <td><input id="fecvalor" type="text" name="fecvalor" size="10"></td>
                            <td>Duplic. :</td>
                            <td><select id="listaTipoDuplicata" name="listaTipoDuplicata">
                                    <option value="0">Selecione Tipo Duplicata</option>
                                    <option value="1"> Normal </option>
                                    <option value="2"> Carteira </option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;Vencimento Dias. :</td>
                            <td><input id="fecdia" type="text" name="fecdia" size="12"></td>
                            <td>Vencimento :</td>
                            <td><input id="fecvecto" type="text" name="fecvecto"  size="12"></td>
                        </tr>

                        <tr>
                            <td>Tipo Parc. :</td>
                            <td>
                                <select id="listaTipoParcelamento" name="listaTipoParcelamento">
                                    <option value="0">Selecione Tipo Parcela</option>
                                    <option value="1"> A Vista (Gera uma parcela) </option>
                                    <option value="2"> Parcelado (Cond. Comerciais) </option>
                                </select>
                            </td>
                            <td>Emissão :</td>
                            <td><input id="fecdata" type="text" name="fecdata" size="12"></td>
                        </tr>
                        </tr>
                        <tr>
                            <td>&nbsp;Banco :</td>
                            <td><input id="fecbanco" type="text" name="fecbanco" size="10"
                                       maxlength="3"></td>
                            <td>Agencia :</td>
                            <td><input id="fecagencia" type="text" name="fecagencia" size="12"
                                       maxlength="10"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;Cheque :</td>
                            <td><input id="feccheque" type="text" name="feccheque" size="10"
                                       maxlength="3"></td>
                            <td>Conta :</td>
                            <td><input id="fecconta" type="text" name="cobconta" size="12"
                                       maxlength="10"></td>
                        </tr>





                        <tr>
                            <td>Cartões</td>
                            <td>
                                <select id="listaBandeiraCartao" name="listaBandeiraCartao">
                                    <option value="0"> SELECIONE A BANDEIRA DO CARTÃO </option>
                                    <option value="1"> REDESHOP </option>
                                    <option value="2"> REDECARD A VISTA </option>
                                    <option value="3"> REDECARD PARCELADO </option>
                                    <option value="4"> REDECARD ASS.ARQUIVO </option>
                                    <option value="5"> VISA ELECTRON </option>
                                    <option value="10"> INTERNET VISA </option>
                                    <option value="6"> VISA A VISTA </option>
                                    <option value="15"> REDECARD ASS.A.PARC </option>
                                    <option value="7"> VISA PARCELADO </option>
                                    <option value="14"> INTERNET DINERS </option>
                                    <option value="13"> INTERNET AMERICAN </option>
                                    <option value="12"> AMERICAN PARCELADO </option>
                                    <option value="11"> INTERNET MASTER </option>
                                    <option value="9"> AMERICAN EXPRESS </option>
                                    <option value="8"> VISA ASS.ARQUIVO </option>
                                </select>
                            </td>
                            <td>
                                Vencimento:
                            </td>
                            <td>
                                <input name="opcaoVencimento" id="opcaoVencimento" type="radio" value="1" checked>Dias
                                <input name="opcaoVencimento" id="opcaoVencimento" type="radio" value="2">Data
                            </td>
                        </tr>

                        <tr>
                            <td>Vales:</td>
                            <td>

                                <div id="detalhesFormaVale"></div></td>
                            <td colspan="2">
                                <input type="button" id="btnIncluirParcela"  name="btnIncluirParcela" value="Incluir">
                                <input type="button" id="btnAlteraParcela"  name="btnAlteraParcela" value="Alterar">
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>

                        <tr bgcolor="#CCCCCC">
                            <td height="10" colspan="4">
                                <!-- incluir componente de pesquisa de pedidos -->
                                <div id="detalhesFormaPreFechamento"></div>
                            </td>
                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>

                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>

                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;Total : <input id="totalpag" type="text" name="totalpag" size="10" readonly> &nbsp;&nbsp;&nbsp;
                                &nbsp;Soma Parcelas : <input id="somaParcela" type="text" name="somaParcela" size="10" readonly> &nbsp;&nbsp;&nbsp;
                                &nbsp;Diferença : <input id="diferenca" type="text" name="diferenca" size="10" readonly></td>
                        </tr>
                        <tr>

                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="5" align="center">
                                <input id="btnConfirmaPreFechamento" type="button" name="btnConfirmaPreFechamento" size="10" value="Confirma"></td>

                        </tr>


                </table>
            </td>
        </tr>

    </table>


</div>

