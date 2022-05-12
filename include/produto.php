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
        //echo $this->query;
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $procodigo) {
        $this->query = "DELETE FROM $tabela WHERE procodigo=$procodigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $procodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE procodigo=$procodigo";
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

}

?>