<?php
require("verifica2.php");
require_once("modulos/compras/manutencao/pedidos/controller/PedidoComprasController.php");
?>
<html>
    <head>
        <title>Exporta Cancelamento de Baixa</title>
    </head>
    <body>

        <?php
        require_once("include/conexao.inc.php");


        $nota = trim($_GET["pcnumero"]);
        $pcseq = trim($_GET["pcseq"]);

        $sql = "SELECT notentdata,pcnumero,notentseqbaixa,notentcodigo,deposito, notentnumero, notentemissao
	  FROM notaent Where pcnumero = $nota and notentseqbaixa = $pcseq ";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);

        if ($row) {
            $pvfdatahora = pg_fetch_result($sql, 0, "notentdata");
            $pcnumero = pg_fetch_result($sql, 0, "pcnumero");
            $notentseqbaixa = pg_fetch_result($sql, 0, "notentseqbaixa");
            $notentcodigo = pg_fetch_result($sql, 0, "notentcodigo");

            $codestoque = pg_fetch_result($sql, 0, "deposito");

            $notentnumero = pg_fetch_result($sql, 0, "notentnumero");
            $notentemissao = pg_fetch_result($sql, 0, "notentemissao");

            $vnumero = $pcnumero . '-' . $notentseqbaixa;

            // ENVIAR NOTIFICACAO DE ESTOQUE ATUALIZADO AOS USUARIOS REGISTRADOS
            $PedidoComprasController = new PedidoController();
            $PedidoComprasController->notificar($pcnumero, $notentnumero, $notentemissao, 4);
        }
        //---------------------------------------


        
        ?>
        <script>

            //imprime_lpt1();
        </script>
        <?
        // echo "<meta HTTP-EQUIV='Refresh' CONTENT='1;URL=pedcomprabaixa.php'>";
        exit;
        ?>
