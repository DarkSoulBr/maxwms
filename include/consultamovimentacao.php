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

    function seleciona($codigoproduto) {


        $this->query = "SELECT a.pvnumero,
                lpad(extract(day from a.movdata),2,0)||'/'||
                lpad(extract(month from a.movdata),2,0)||'/'||
                EXTRACT(YEAR FROM a.movdata) as data
                ,a.movqtd,a.movvalor,a.movtipo,c.pvtipoped
                FROM produto b,movestoque a
                LEft Join pvenda as c on c.pvnumero = a.pvnumero
                Where b.procod = '$codigoproduto'
                and a.procodigo = b.procodigo
                order by a.movdata";

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

    function altera($tabela, $alteracao, $procodigo, $pvnumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE procodigo=$procodigo AND pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>