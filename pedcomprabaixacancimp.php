<?
require("verifica2.php");
?>
<html>
    <head>
        <title>Exporta Cancelamento de Baixa</title>
    </head>
    <body>

        <?
        require_once("include/conexao.inc.php");


        $nota = trim($_GET["pcnumero"]);
        $pcseq = trim($_GET["pcseq"]);


        $seq = "00" . $pcseq;
        $seq = trim(substr($seq, -2, 2));


        $not = "000000" . $nota;
        $not = trim(substr($not, -6, 6));
        $not = $not . $seq;
        //$not=trim(substr($not, -8, 8 ));
        //$nome = "/home/delta/".$not.".pcb";
        $nome = $not . ".pcb";

        /*
        if (file_exists($nome)) {
            unlink($nome);
        }

        $arquivo = fopen("$nome", "x+");

        $linha = "A";

        $linha = $linha . ";" . $not;


        fputs($arquivo, "$linha\r\n");

        fclose($arquivo);
         * 
         */
        ?>
        <script>

            //imprime_lpt1();
        </script>
<?
// echo "<meta HTTP-EQUIV='Refresh' CONTENT='1;URL=pedcomprabaixa.php'>";
exit;
?>
