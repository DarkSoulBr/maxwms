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
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao,(a.pcisaldo) as estoque,a.pcipreco as conferido
                FROM pcitem a,produto c
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona_aberto($pcnumero) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao, a.pcisaldo as saldo, a.pcibaixa as baixa, a.pcipreco as preco
                FROM pcitem a,produto c
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                and (a.pcisaldo > a.pcibaixa or a.pcibaixa isnull)
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona_faturados($pcnumero) {
        $this->query = "SELECT c.procod as codigo,c.prnome as descricao, a.pcibaixa as baixa, a.pcipreco as preco
                FROM pcitem a,produto c
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
                and (a.pcibaixa > '0' and not a.pcibaixa isnull)
                order by a.pcicodigo";

        $resultf = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $resultf;
    }

    function seleciona_baixasparciais($pcnumero) {
        $this->query = "SELECT b.notentseqbaixa as baixa, to_char(b.notentdata, 'DD/MM/YYYY') as data, c.procod as codigo,c.prnome as descricao, a.neisaldo as quantidade, a.neipreco as valor
		FROM neitem a,produto c, notaent b
		Where b.pcnumero =  $pcnumero
		and a.procodigo = c.procodigo
		and a.notentcodigo = b.notentcodigo
		order by a.neiitem";

        $resultb = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $resultb;
    }

    function seleciona_baixasparciais2($pcnumero, $pcbaixa, $codigoproduto) {
        $this->query = "SELECT b.notentseqbaixa as baixa, to_char(b.notentdata, 'DD/MM/YYYY') as data, c.procod as codigo,c.prnome as descricao, a.neisaldo as quantidade, a.neipreco as valor
		FROM neitem a,produto c, notaent b
		Where b.notentseqbaixa = $pcbaixa 
		and b.pcnumero = $pcnumero
		and c.procod = '$codigoproduto'
		and a.procodigo = c.procodigo
		and a.notentcodigo = b.notentcodigo
		order by a.neiitem";

        $resultb = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $resultb;
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