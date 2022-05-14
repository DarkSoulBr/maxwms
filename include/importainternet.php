<?php

class banco {

    private $conn;
    private $db;
    private $query;
    private $data;

    function __construct($cnn, $base) {
        $this->conn = $cnn;
        $this->db = $base;
    }

    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $clicodigo) {
        $this->query = "DELETE FROM $tabela WHERE clicodigo=$clicodigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function apaga2($tabela, $codigo) {
        $this->query = "DELETE FROM $tabela WHERE clecodigo=$codigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function apaga3($tabela, $codigo) {
        $this->query = "DELETE FROM $tabela WHERE clccodigo=$codigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $clicodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE clicodigo=$clicodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alterapro($tabela, $alteracao, $procodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE procodigo=$procodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteragru($tabela, $alteracao, $grucodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE grucodigo=$grucodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteramar($tabela, $alteracao, $marcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE marcodigo=$marcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alterasbm($tabela, $alteracao, $sbmcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE sbmcodigo=$sbmcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteramed($tabela, $alteracao, $medcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE medcodigo=$medcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteralin($tabela, $alteracao, $lincodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE lincodigo=$lincodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alterasgr($tabela, $alteracao, $subcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE subcodigo=$subcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteracon($tabela, $alteracao, $concodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE concodigo=$concodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alterasep($tabela, $alteracao, $sepcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE sepcodigo=$sepcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function inserebar($tabela, $barunidade1, $barcaixa1, $procodigo1) {

        $sql = "
       SELECT procodigo From cbarras
       WHERE procodigo = $procodigo1";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {

            $this->query = "UPDATE $tabela SET barunidade='$barunidade1',barcaixa='$barcaixa1' WHERE procodigo='$procodigo1'";
            pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
        } else {
            $this->query = "INSERT INTO $tabela (barunidade,barcaixa,procodigo) VALUES ('$barunidade1','$barcaixa1','$procodigo1')";
            pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
        }
    }

    function alterafor($tabela, $alteracao, $forcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE forcodigo=$forcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteratra($tabela, $alteracao, $tracodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE tracodigo=$tracodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteraven($tabela, $alteracao, $vencodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE vencodigo=$vencodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteraped($tabela, $alteracao, $pvnumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteranot($tabela, $alteracao, $notnumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE notnumero='$notnumero'";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function apagaite($tabela, $pvnumero) {
        $this->query = "DELETE FROM $tabela WHERE pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function alterausu($tabela, $alteracao, $usucodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE usucodigo=$usucodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function inserepen($tabela, $ender1, $ender2, $ender3, $ender4, $ender5, $ender6, $ender7, $ender8, $ender9, $procodigo1) {

        $sql = "
       SELECT procodigo From endereco
       WHERE procodigo = $procodigo1 and etqcodigo = 9";
        $sql = pg_query($sql);
        $row = pg_num_rows($sql);
        if ($row) {

            $this->query = "UPDATE $tabela SET endlocal='$ender1',endlocal2='$ender2',endlocal3='$ender3',endlocal4='$ender4',endlocal5='$ender5',endlocal6='$ender6',endlocal7='$ender7',endlocal8='$ender8',endlocal9='$ender9' WHERE procodigo='$procodigo1' and etqcodigo=9";
            pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
        } else {
            $this->query = "INSERT INTO $tabela (endlocal,endlocal2,endlocal3,endlocal4,endlocal5,endlocal6,endlocal7,endlocal8,endlocal9,procodigo,etqcodigo) VALUES ('$ender1','$ender2','$ender3','$ender4','$ender5','$ender6','$ender7','$ender8','$ender9','$procodigo1','9')";
            pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
        }
    }

    function alteravei($tabela, $alteracao, $veicodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE veicodigo=$veicodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alterapvitem($tabela, $alteracao, $pvicodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE pvicodigo=$pvicodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteraclf($tabela, $alteracao, $clanumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE clanumero='$clanumero'";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>
