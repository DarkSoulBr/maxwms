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

    function seleciona($nota) {

        $this->query = "SELECT c.procod as codigo,c.prnome as descricao,a.neisaldo as estoque,
                a.neipreco as preco,a.procodigo
                FROM neitem a,produto c
                Where a.nenumero = $nota
                and a.procodigo = c.procodigo
                order by a.neicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $alteracao) {

        $this->query = "DELETE FROM $tabela WHERE $alteracao";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $procodigo, $pvnumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE procodigo=$procodigo AND pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>