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

    function seleciona2($tabela, $tabela2, $pesquisa, $pesquisa2) {

        $this->query = "SELECT b.vincodigo,a.clicod,a.clirazao FROM $tabela2 a, $tabela b
                Where a.clicodigo = b.clicodigo
                and vlccodigo = '$pesquisa2'
				and b.clicodigo <> '$pesquisa'
                order by clirazao";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $vincodigo) {
        $this->query = "DELETE FROM $tabela WHERE vincodigo=$vincodigo
                ";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $clvcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE clvcodigo=$clvcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>
