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

    function seleciona2($tabela, $tabela2, $pesquisa) {

        $this->query = "SELECT b.regccodigo,a.descricao,a.uf,a.codestado,a.codcidade,a.id FROM $tabela b
				Left Join $tabela2 as a on a.id = b.cidcodigo				
                Where regcodigo = '$pesquisa'				
                order by a.descricao";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $trjcodigo) {
        $this->query = "DELETE FROM $tabela WHERE regccodigo=$trjcodigo
                ";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $clvcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE clvcodigo=$clvcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>