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
        $this->query = "DELETE FROM $tabela WHERE contcodigo=$fpgcodigo";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $fpgcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE contcodigo=$fpgcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function seleciona($invdata, $contagem, $setor, $coletor) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao,a.quantidade as estoque 
                FROM inventariocontagemsetorproduto a,produto c                
                Where a.invdata = '$invdata' and a.concodigo = $contagem and a.setcodigo = $setor and a.colcodigo = $coletor 
                and a.procodigo = c.procodigo
                order by c.procod";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function selecionaold($invdata, $contagem, $setor, $coletor) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao,a.quantidade as estoque,a.procodigo  
                FROM inventariocontagemsetorproduto a,produto c                
                Where a.invdata = '$invdata' and a.concodigo = $contagem and a.setcodigo = $setor and a.colcodigo = $coletor 
                and a.procodigo = c.procodigo
                order by c.procod";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function selecionanovo($invdata, $contagem, $setor, $coletor) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao,a.quantidade as estoque,a.procodigo,c.proref,d.barunidade   
                FROM inventariocontagemsetorproduto a,produto c                
				left join cbarras d on c.procodigo=d.procodigo 
                Where a.invdata = '$invdata' and a.concodigo = $contagem and a.setcodigo = $setor and a.colcodigo = $coletor 
                and a.procodigo = c.procodigo
                order by c.procod";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

}

?>
