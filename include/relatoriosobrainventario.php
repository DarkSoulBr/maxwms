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

    //Selecionar dados do banco
    function seleciona($campos, $tabela, $condicao) {
        $this->query = "SELECT $campos FROM $tabela WHERE $condicao";
        //print($this->query); die;
        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    //Inserir dados do banco
    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        //print($this->query); die;
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    //Alterar dados do banco
    function altera($tabela, $campos, $condicao) {
        $this->query = "UPDATE $tabela SET $campos WHERE $condicao";
        //print($this->query); die;
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    //Apagar dados do banco
    function apaga($tabela, $condicao) {
        $this->query = "DELETE FROM $tabela WHERE $condicao";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

}

?>