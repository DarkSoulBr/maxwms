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
//echo "INSERT INTO $tabela $campos VALUES $valores";
        //print($this->query);
        //die;
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

}

?>