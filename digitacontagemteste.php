<?php
$flagmenu = 3;
require("verificateste.php");
//Verifica se a opção existe no Cadastros de Opção   
$opcao = 'CONTAGEM DE ESTOQUE';
$pagina = 'digitacontagem.php';
$modulo = 5;  //ESTOQUE
$sub = 24;  //COLETOR
$usuario = 359;

$sql = "Select opccodigo from opcoes Where opcpagina = '$pagina'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $codpag = pg_fetch_result($sql, 0, "opccodigo");
} else {
    $sql2 = "INSERT INTO OPCOES (opcnome,opcpagina,modcodigo,submcodigo) values ('$opcao','$pagina','$modulo','$sub')";

    pg_query($sql2);

    //Localiza a opcao
    $b = 0;
    while ($b < 1000) {
        $sql = "Select opccodigo from opcoes Where opcpagina = '$pagina'";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {
            $codpag = pg_fetch_result($sql, 0, "opccodigo");
            $b = 1000;
        } else {
            $b++;
        }
    }
}


//Grava na Tabela de Favoritos do Usuário
$sql = "Select favqtd from favoritosusuario Where usucodigo = '$usuario' and opccodigo='$codpag'";
$sql = pg_query($sql);
$row = pg_num_rows($sql);
if ($row) {
    $favqtd = pg_fetch_result($sql, 0, "favqtd");
} else {
    $sql2 = "INSERT INTO favoritosusuario (usucodigo,opccodigo,favqtd) values ('$usuario','$codpag','0')";
    pg_query($sql2);
    $favqtd = 0;
}

$favqtd ++;

$sql3 = "UPDATE favoritosusuario SET favqtd='$favqtd' Where usucodigo='$usuario' and opccodigo='$codpag'";
pg_query($sql3);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title>Contagem</title>

        <script src="js/digitacontagem.js"></script>

        <script language="JavaScript1.2">

        </script>

    <noscript>
        Habilite o Javascript para visualizar esta página corretamente...
    </noscript>
    <style>
        .borda{border: 1px solid;}
        div{font-family: Verdana; font-size: 12px;}
        td{font-family:Verdana ; font-size: 12px;}
        .style3 {color: #000000}
    </style>

</head>
<body onLoad="ver()";>

    <div>

        <form name="formulario">
            <table width="215" height="274" border="2" cellspacing="0" cellpadding="0" bordercolor="#999999">
                <tr>
                    <td width="214" height="270">
                        <table width="100%"  height="20" border="0" cellpadding="0" cellspacing="0" bgcolor="#3366CC">
                            <tr>
                                <td colspan="4" >
                                    <div align="center"><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"><strong>Contagem Inventário</strong></font></div>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">    
                            <tr> 
                                <td height="8">&nbsp;</td>
                                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>	
                            <tr> 
                                <td>&nbsp;</td>
                                <td> <div align="left">Data:</div></td>
                                <td colspan="3"><input name="pvemissao" type="text" id="pvemissao" onKeyPress="maiusculo()" size="10" disabled="disabled" style="BACKGROUND-COLOR: White;COLOR : Black"></td>
                                <td>&nbsp;</td>
                            </tr>              
                            <tr> 
                                <td>&nbsp;</td>
                                <td>Contagem:</td>
                                <td colspan="2"> <select name="conferente">
                                        <option id="conferente" value="0">____________________</option>
                                    </select> </td>
                                <td width="95" align="right">&nbsp;&nbsp;</td>
                                <td width="1"><div align="center"> </div></td>
                            </tr>
                            <tr> 
                                <td>&nbsp;</td>
                                <td>Setor:</td>
                                <td colspan="2"> <select name="separador">
                                        <option id="separador" value="0">____________________</option>
                                    </select> </td>
                                <td width="95" align="right">&nbsp;&nbsp;</td>
                                <td width="1"><div align="center"> </div></td>
                            </tr>
                            <tr> 
                                <td>&nbsp;</td>
                                <td>Coletor:</td>
                                <td colspan="2"> <select name="coletor">
                                        <option id="coletor" value="0">____________________</option>
                                    </select> </td>
                                <td width="95" align="right">&nbsp;&nbsp;</td>
                                <td width="1"><div align="center"> </div></td>
                            </tr>
                            <tr> 
                                <td height="8">&nbsp;</td>
                                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>	
                            <tr> 
                                <td height="18" colspan="6"><div align="center"> 
                                        <input type="button" id="botao" onClick=dadosverifica1() value="Inicia" disabled>                    
                                        <input type="button" id="botao2" onClick=dadosverifica2() value="Fim" disabled>					                   
                                    </div></td>
                            </tr>			
                            <tr> 
                                <td>&nbsp;</td>
                                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr bgcolor="#FF0000" id="linhaerro1" style="display: none;">		
                                <td height="18" colspan="6"><div align="center"><b> 
                                            PRODUTO</b>
                                    </div></td>			        
                            </tr>		
                            <tr bgcolor="#FF0000" id="linhaerro2" style="display: none;">										               		
                                <td height="18" colspan="6"><div align="center"><b> 
                                            NÃO</b>
                                    </div></td>			        
                            </tr>
                            <tr bgcolor="#FF0000" id="linhaerro3" style="display: none;">										               		
                                <td height="18" colspan="6"><div align="center"><b> 
                                            ENCONTRADO</b>
                                    </div></td>			        
                            </tr>		
                            <tr bgcolor="#CCCCCC" id="linhaerro4" style="display: none;">										               		
                                <td>&nbsp;</td>
                                <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>	
                            <tr> 
                                <td><span class="style3"></span></td>
                                <td><span class="style3">Qtd:</span></td>
                                <td colspan="3"><span class="style3"><input id="radio1" name="radiobutton" type="radio" value="radiobutton" checked disabled>Sim 
                                        <input id="radio2" name="radiobutton" type="radio" value="radiobutton" disabled>Não  
                                        <input id="item" type="hidden" name="item" size="3" value="1" onKeyPress="maiusculo()" disabled="disabled"  style="BACKGROUND-COLOR: White;COLOR : Black">

                                    </span></td>
                                <td><span class="style3"></span></td>
                            </tr>
                            <tr> 
                                <td><span class="style3"></span></td>
                                <td><span class="style3">C.Barra</span></td>
                                <td colspan="3"><span class="style3"> 
                                        <!--input id="cbarra" type="text" name="cbarra" size="20"  onKeyPress="entertabx('codigoproduto')"  onBlur="dadospesquisacbarras(this.value);"-->
                                        <input id="cbarra" type="text" name="cbarra" size="20" onkeyup="if (this.value.length > 11) {
                                                    entertabx('codigoproduto');
                                                }" onBlur="dadospesquisacbarras(this.value);" disabled>
                                    </span></td>
                                <td><span class="style3"></span></td>	
                            <span id=dummyspan></span>
                </tr>
                <tr> 
                    <td><span class="style3"></span></td>
                    <td><span class="style3">Codigo</span></td>
                    <td colspan="3"><span class="style3"> 
                            <input id="codigoproduto" type="text" name="codigoproduto" size="6" onfocus="funcaopress()" OnKeyPress="formatar('####-#', this)" onBlur="dadospesquisapertence(this.value)" onkeyup="entertab('produto');" disabled>                  
                        </span></td>
                    <td><span class="style3"></span></td>
                </tr>
                <tr> 
                    <td><span class="style3"></span></td>
                    <td><span class="style3">Produto</span></td>
                    <td colspan="3"><span class="style3">                   
                            <input id="produto" type="text" name="produto" size="20" onKeyPress="maiusculo()" onBlur="convertField(this);pesquisaprodutos(this.value);" disabled>
                        </span></td>
                    <td><span class="style3"></span></td>
                </tr>
                <tr> 
                    <td>&nbsp;</td>
                    <td>Pesquisa</td>
                    <td colspan="3"> <select name="pesquisaproduto" onBlur="pesquisacod(this.value)" disabled>
                            <option id="pesquisaproduto2" value="0">_________________</option>
                        </select> </td>
                    <td>&nbsp;</td>
                </tr>
                <tr> 
                    <td>&nbsp;</td>
                    <td>Quant.</td>
                    <td colspan="2"><input id="quant" type="text" name="quant" size="5" onKeyPress="maiusculo()" disabled>
                        <input name="button" type="button" id="button" onBlur="funcaopress()" onClick="dadospesquisaconfirma()" onKeyDown="enterclik(event, this)" value="Incluir" disabled>  
                    </td>
                    <td  align="left"><!--DWLayoutEmptyCell-->&nbsp; </td>
                    <td>&nbsp;</td>
                </tr>
                <tr> 
                    <td>&nbsp;</td>
                    <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>	
                <tr> 
                    <td height="18" colspan="6"><div align="center"> 
                            <input type="button" id="botao4" onClick=dadosverifica4() value="Ver" disabled>                    
                            <input type="button" id="botao3" onClick=dadosverifica3() value="Encerra" disabled>	
                        </div></td>
                </tr>		
                <tr> 
                    <td>&nbsp;</td>
                    <td><!--DWLayoutEmptyCell-->&nbsp;</td>
                    <td colspan="3">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>		
            </table>
            </td>
            </tr>
            </table>

            <div id="msg" style="visibility: hidden;">&nbsp;<font face="Verdana" size="2">Processando...</font></div>
            <div id="resultado"></div>
            <div id="resultado2"></div>

        </form>

    </div>
    <br>
</body>
</html>

