<?php
/*
  if(!$_SERVER['HTTPS']) {
  $protocolo = "https://";
  header( "Location: ".$protocolo.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
  }
 */

// Inicia sessões
session_start();

//pega da pasta de istalacao
$arr = explode("/", $_SERVER['REQUEST_URI']);
$root = $arr[1];

//pega as configurações do servidor
$HTTP_HOST = "http://" . $_SERVER['HTTP_HOST'] . "/$root/";

require_once("include/conexao.inc.php");
require_once("include/banco.php");
require_once("include/config.php");

ini_set('max_execution_time', 0);

if(isset($_GET["flagmenu"])) {
    $flagmenu = $_GET["flagmenu"];
} else {
    $flagmenu = 2;
}

// Verifica se existe os dados da sessão de login
if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"])) {
    // Usuário não logado! Redireciona para a página de login
    header("Location: default.php");
    exit;
} else {
    //Verificar a permissão do usuário referente às páginas que ele pode acessar
    //Primeiro: pegar o nome da página php que o usuário está tentando acessar.
    //Ex: /dtrade/paginaxx.php
    $paginaUrlFull = $_SERVER['PHP_SELF'];

    //Tratar o endereço recebido, pegando apenas o nome da página acessada
    //Ex: paginaxx.php
    //Segundo: Divide o nome da página pela /
    $arrayUrlFull = explode("/", $paginaUrlFull);

    //Conta quantas posições existem no array
    //Como o count começa a conta pelo número 1, devemos subtrair 1 para pegar a posição correta.
    //A variável $auxUrlFull conterá a posição do array referente a página acessada
    $auxUrlFull = count($arrayUrlFull) - 1;

    //Com a posição correta do array, pegamos o nome da página acessada.
    $paginaAcessada = $arrayUrlFull[$auxUrlFull];

    
    echo "<link rel='icon' href='images/favicons.png'/>";
}
?> 

<!DOCTYPE html>
<html>
    <head>
        <title>:: Max WMS ::</title>
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT= "NO-CACHE">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">

        <!-- SmartMenus core CSS (required) -->
        <link href="./css/sm-core-css.css" rel="stylesheet" type="text/css" />

        <!-- "sm-clean" menu theme (optional, you can use your own CSS, too) -->
        <link href="./css/sm-clean/sm-clean.css" rel="stylesheet" type="text/css" />

        <script src="js/prototype.lite.js"></script>
        <script src="js/moo.ajax.js"></script>
        <script src="js/geral.js"></script>                    

        <style>
            .borda{border: 1px solid;}
            div{font-family: Verdana; font-size: 12px;}
            td{font-family: Verdana; font-size: 12px;}
            input{font-family: Verdana; font-size: 12px;}
            select{font-family: Verdana; font-size: 12px;}                
        </style>

    </head>
    <body>            
        <div style="background:#3366CC; font-size:22px; text-align:center; color:#FFF; font-weight:bold; height:36px; padding-top:8px;">Max WMS</div>

        <nav id="main-nav">
            <!-- Sample menu definition -->
            <ul id="main-menu" class="sm sm-clean">
                <!--li><a href="http://localhost/maxwms/maxwms.php"><img id="logo-barao" src="images/logo.png" height="28" alt="barao"></a></li-->
                <li><a href="#">Cadastros</a>
                    <ul>
                        <li>
                            <a href="#"><i class="icon-user"></i> Clientes&nbsp;</a>
                            <ul>                                
                                <li><a href="clientesconssimples.php">Consulta</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-briefcase"></i> Fornecedores&nbsp;</a>
                            <ul>                                
                                <li><a href="fornecedorcons.php">Consulta</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-gift"></i> Produtos&nbsp;</a>
                            <ul>                                
                                <li><a href="consultaprodutonovo.php">Consulta</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-building"></i> Depositante&nbsp;</a>
                            <ul>                                
                                <li><a href="clientesdep.php">Manutenção</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-truck"></i> Transportador&nbsp;</a>
                            <ul>                                
                                <li><a href="transportador.php">Manutenção</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-list"></i> Estoque&nbsp;</a>
                            <ul>                                
                                <li><a href="estoque.php">Estoques</a></li>
                                <li><a href="enderecos.php">Endereços</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Recebimento</a>
                    <ul>
                        <li>
                            <a href="#"><i class="icon-wrench"></i> Pedidos&nbsp;</a>                            
                            <ul>
                                <li><a href="incluirpedcompra.php">Inclusão</a></li>                                                  
                                <li><a href="alterarpedcompra.php">Alteração</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-check"></i> Baixas&nbsp;</a>                            
                            <ul>
                                <li><a href="pedcomprabaixanovo.php">Baixa de Pedidos</a></li>
                                <li><a href="pedcomprabaixacancelanovo.php">Cancela Baixa</a></li>
                                <li><a href="pedcomprabaixaatualizanovo.php">Atualiza Estoque</a></li>
                                <li><a href="pedcomprabaixacancatualnovo.php">Cancela Atualização</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-search"></i> Consultas&nbsp;</a>
                            <ul >
                                <li><a href="pedcompracons.php"> Pedidos</a></li>                            
                                <li>
                                    <a href="#"> Baixados</a>
                                    <ul >
                                        <li><a href="consultapedbaixado.php">Data</a></li>                                                                                                                                                                                
                                        <li><a href="consultapedbaicomfornecedor.php">Fornecedor</a></li>                                        
                                    </ul>
                                </li> 
                                <li><a href="consultapedaberto.php"> Emissão</a></li>                                                        
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-list"></i> Relatórios&nbsp;</a>
                            <ul>                                
                                <li><a href="pedcompraimpressao.php"> Baixa Física</a></li>                                                                
                                <li>
                                    <a href="#"> Saldo</a>
                                    <ul >
                                        <li><a href="relatoriosalpedcomfornecedor.php">Fornecedor</a></li>
                                        <li><a href="relatoriosalpedcomgrupos.php">Grupo</a></li>                                                                                                    
                                    </ul>
                                </li>                                                                                      
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Estoque</a>
                    <ul>
                        <li><a href="#"><i class="icon-list"></i> Movimentação</a>
                          <ul>
                            <li><a href="consultamovimentacao2.php">Analítico</a></li>
                            <li><a href="consultamovimentacao3.php">Sintético</a></li>                            
                          </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">WMS</a>
                    <ul>
                        <li><a href="consultapedidosliberadosn.php"><i class="icon-list"></i> Pedidos</a></li> 
                        <li><a href="conferencia.php"><i class="icon-check"></i> Conferência</a></li> 
                    </ul>
                </li>
                <li>
                    <a href="#">Expedição</a>
                    <ul>
                        <li><a href="motoristas.php"><i class="icon-user"></i> Motoristas</a></li> 
                        <li><a href="veiculo.php"><i class="icon-truck"></i> Veículos</a></li> 
                        <li>
                            <a href="#"><i class="icon-check"></i> Romaneios&nbsp;</a>                            
                            <ul>
                                <li><a href="romaneiosinc.php">Inclusão</a></li>
                                <li><a href="romaneiosalt.php">Alteração</a></li>
                                <li><a href="romaneiosbaixa.php">Baixa</a></li>                                    
                                <li><a href="#">Consultas</a>
                                    <ul>
                                        <li><a href="consultaromaneios.php">Data</a></li>                                                                                                                                                                                   
                                        <li><a href="consultaromaneiospedido.php">Pedido</a></li>                                                                            
                                    </ul>
                                </li>                                
                                <li><a href="#">Arquivo NotFis&nbsp;</a>
                                    <ul>
                                        <li><a href="romaneiosnot.php">Romaneio</a></li>                                                                                 
                                        <li><a href="consultaromaneiosnotfis.php">Datas</a></li>                                          
                                    </ul>
                                </li>                        
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">CT-e</a>
                    <ul>
                        <li>
                            <a href="#"><i class="icon-list"></i> Cadastros&nbsp;</a>
                            <ul>          
                                <li><a href="empresa.php">Emitente</a></li>  
                                <li><a href="clientescte.php">Empresas</a></li>  
                                <li><a href="tipomodal.php">Modal</a></li>                                
                                <li><a href="tiposervico.php">Tipo de Serviço</a></li>
                                <li><a href="tipopagamento.php">Forma de Pagamento</a></li>
                                <li><a href="tipocte.php">Finalidade</a></li>
                                <li><a href="tipoforma.php">Forma de Emissão</a></li>
                                <li><a href="cfop.php">CFOP</a></li>
                                <li><a href="parametros.php">Parâmetros</a></li>
                                <li><a href="estado.php">Estados</a></li>
                                <li><a href="cidade.php">Cidades</a></li>
                                <li><a href="ibge.php">IBGE</a></li>
                                <li><a href="bairros.php">Bairros</a></li>
                                <li><a href="logradouros.php">Logradouros</a></li>
                                <li><a href="cidadetransp.php">Prazo de Entrega</a></li>
                                <li><a href="veiculoscte.php">Veiculos</a></li>
                            </ul>
                        </li>
                        <li>
                            <li><a href="#"><i class="icon-file-alt"></i> CT-e</a>
                            <ul >
                                    <li><a href="incluirctenovo.php"><i class="icon-plus-sign-alt"></i> Inclusão</a></li>                            
                                    <li><a href="alterarcte.php"><i class="icon-edit"></i> Manutenção</a></li>
                                    <li><a href="cancelamentocte.php"><i class="icon-trash"></i> Cancelamento</a></li>						
                                    <li>
                                            <a href="#"><i class="icon-minus-sign"></i> Inutilização</a>
                                            <ul >									                                                
                                                    <li><a href="inutilizacaocte.php" >Normal</a></li> 
                                                    <li><a href="inutilizacaoctexml.php">XML</a></li>									                                                                                                      
                                            </ul>
                                    </li>
                                    <li><a href="cartacorrecaocte.php"><i class="icon-file-alt"></i> Carta Correção</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-search"></i> Consultas</a>
                            <ul > 
                                <li><a href="admcte.php"><i class="icon-wrench"></i> Gerenciamento</a></li>                                
                                <li><a href="consultactecancelados.php"><i class="icon-trash"></i> Cancelamento</a></li>
                                <li><a href="cteconsultapornota.php"><i class="icon-search"></i> NF-e</a></li>                                
                                <li><a href="cartacorrecaocteconsulta.php"><i class="icon-file-alt"></i> Carta Correção</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="icon-wrench"></i> Utilitários</a>
                            <ul >
                                <li>
                                    <a href="#"><i class="icon-upload"></i> Importações</a>
                                    <ul >								
                                        <li><a href="#">CT-e</a>
                                            <ul>
                                                <li><a href="importactexml.php">Autorizado</a></li>                                                                                                                                                                                   
                                                <li><a href="importactexmlrejeitado.php">Rejeitado</a></li>                                                                                                                                                                                                                           
                                            </ul>
                                        </li>									
                                    </ul>
                                </li>  
                                <li>
                                    <a href="#"><i class="icon-copy"></i> Exportações</a>
                                    <ul >
                                        <li><a href="exportadatasulcte.php">Datasul</a></li>
                                        <li><a href="exportaprocedacte.php">Proceda</a></li>									                                                                                                                                                                          
                                    </ul>
                                </li>  
                                <li>
                                    <a href="#"><i class="icon-file-alt"></i> Geração PDF</a>
                                    <ul >
                                        <li><a href="gerapdfnfe.php">Danfe</a></li>
                                        <li><a href="gerapdfcte.php">Dacte</a></li>									                                                                                                                                                                  
                                        <li><a href="gerapdfcce.php">Dacce</a></li>									                                                                                                                                                                  
                                    </ul>
                                </li>                                						                                                     
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">Utilitários</a>
                    <ul>
                        <li><a href="#"><i class="icon-truck"></i> EDI &nbsp;</a>
                            <ul>
                                <li><a href="importaedi.php">Importação</a></li>  
                                <li><a href="importaedi3.php">Destrava</a></li>                                                  
                            </ul>
                        </li>
                        <li><a href="tabelasmovimentacao.php"><i class="icon-list"></i> Tabela Movimentação</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#">Segurança</a>
                    <ul>     
                        <li><a href="cadusuarios.php"><i class="icon-user"></i> Usuários</a></li>						
                        <li>
                            <a href="#"><i class="icon-lock"></i> Alterar Senha&nbsp;</a>
                            <ul >
                                <li><a href="ususenha.php">Administrador</a></li>
                                <li><a href="ususenhau.php">Usuários</a></li>                                                                                                                                          
                            </ul>
                        </li>						                            
                    </ul>
                </li>
                <li>
                    <a href="#">Módulos</a>
                    <ul>                         
                        <li><a href="maxwms.php?flagmenu=2"><i class="icon-desktop"></i> WMS</a></li>						
                        <li><a href="login_encerra.php"><i class="icon-signout"></i> Encerrar Sessão</a></li>
                    </ul>
                </li>					
            </ul>
        </nav>

        <!-- jQuery -->
        <script type="text/javascript" src="./libs/jquery/jquery.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="./libs/jquery.smartmenus.js"></script>



        <script type="text/javascript">
            var $mn = jQuery.noConflict()
        </script>

        <!-- SmartMenus jQuery init -->
        <script type="text/javascript">
            $mn(function () {
                $mn('#main-menu').smartmenus({
                    subMenusSubOffsetX: 1,
                    subMenusSubOffsetY: -8
                });
            });
        </script>



    </body>
    <br>
    <br>
</html>                                            

