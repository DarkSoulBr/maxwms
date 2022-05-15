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

    function apaga($tabela, $fpgcodigo) {
        $this->query = "DELETE FROM $tabela WHERE colcodigo=$fpgcodigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $fpgcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE colcodigo=$fpgcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>
