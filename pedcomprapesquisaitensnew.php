<?php

require_once("include/conexao.inc.php");

$pcnumero = trim($_GET["pcnumero"]);

$sql = "SELECT c.procod as codigo,c.prnome as descricao		
        ,a.pcisaldo
        ,a.pcipreco
        ,a.desc1
        ,a.desc2
        ,a.desc3
        ,a.desc4
        ,a.ipi
        ,a.pcentrega
        ,a.pcibaixa		
        ,c.proref 		
        ,a.procodigo 
        FROM pcitem a,produto c
        Where a.pcnumero = {$pcnumero} 
        and a.procodigo = c.procodigo
        order by a.pcicodigo";

$data = pg_query($sql);

//se encontrar registros
if (pg_num_rows($data)) {
    header("Content-type: application/xml");

    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";

    //preenchimento da Array com o nome dos campos
    for ($i = 0; $i < pg_num_fields($data); $i++) {
        $campos[$i] = pg_field_name($data, $i);
    }

    $xml .= "<dados>";
    $xml .= "<cabecalho>";

    //cabecalho da tabela
    for ($i = 0; $i < (sizeof($campos)-1); $i++) {
        $xml .= "<campo>" . $campos[$i] . "</campo>";
    }
    $xml .= "<campo>" . "baixado" . "</campo>";
    $xml .= "</cabecalho>";


    //corpo da tabela
    while ($row = pg_fetch_object($data)) {
        $xml .= "<registro>";
        for ($i = 0; $i < (sizeof($campos)); $i++) {

            if ($row->{$campos[$i]} != null) {

                if ($i == 9) {
                    $dat = $row->{$campos[$i]};
                    $dat = substr($dat, 8, 2) . '/' . substr($dat, 5, 2) . '/' . substr($dat, 0, 4);
                    $xml .= "<item>" . $dat . "</item>";
                } else {
                    if ($i == 2) {
                        if ($row->{$campos[10]} != null) {
                            $saldo = $row->{$campos[$i]} - $row->{$campos[10]};
                        } else {
                            $saldo = $row->{$campos[$i]};
                        }
                        $xml .= "<item>" . $saldo . "</item>";
                    } else {
                        $xml .= "<item>" . $row->{$campos[$i]} . "</item>";
                    }
                }
            } else {
                $xml .= "<item>0</item>";
            }
        }
        
        $codigo = $row->{$campos[12]};

        $baixa = 0;

        //Verifica se tem alguma Baixa
        $sqlbai = "select a.neicodigo from neitem a,notaent b where a.notentcodigo = b.notentcodigo and b.pcnumero = $pcnumero and a.procodigo = $codigo";

        $cadbai = pg_query($sqlbai);

        $baixa = 0;

        if (pg_num_rows($cadbai)) {
            $baixa = 1;
        }
          

        $xml .= "<item>" . $baixa . "</item>";
        $xml .= "</registro>";
    }

    //fim da tabela
    $xml .= "</dados>";
}

echo $xml;
pg_close($conn);
exit();
?>
