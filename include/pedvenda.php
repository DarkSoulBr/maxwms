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

    function seleciona($pvnumero) {
        $this->query = "SELECT
                order by procod";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $procodigo) {
        $this->query = "DELETE FROM $tabela WHERE procodigo=$procodigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $pvnumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>