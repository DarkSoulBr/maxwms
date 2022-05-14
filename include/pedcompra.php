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

    function seleciona($pcnumero) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao
		
		        ,a.pcisaldo
				,a.pcipreco
				,a.desc1
				,a.desc2
				,a.desc3
				,a.desc4
				,a.ipi
				,a.pcentrega
				,a.pcibaixa		
				,c.proref
				
				FROM pcitem a,produto c
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona2($pcnumero) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao
				,a.pcisaldo
				,d.estqtd as est9
				,e.estqtd as est1
				,f.estqtd as est2
				,a.lojan
			    ,a.loja
				,a.pcicodigo
				,c.proemb
				,a.pcibaixa
				
				FROM pcitem a,produto c
				left join estoqueatual as d on (d.procodigo = c.procodigo and d.codestoque=9)
				left join estoqueatual as e on (e.procodigo = c.procodigo and e.codestoque=1)
				left join estoqueatual as f on (f.procodigo = c.procodigo and f.codestoque=2)
				
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
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

    function altera($tabela, $alteracao, $pcnumero) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE pcnumero=$pcnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function altera2($tabela, $alteracao, $pcicodigo) {
        $this->query = "UPDATE $tabela SET $alteracao WHERE pcicodigo=$pcicodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>
