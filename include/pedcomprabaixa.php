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


        $this->query = "SELECT c.procod as codigo,c.proref
                ,c.prnome as descricao
                ,(a.pcisaldo) as estoque
                ,a.pcipreco as conferido
                ,a.pcicodigo
                ,a.pcibaixa
				
                ,a.desc1
                ,a.desc2
                ,a.desc3
                ,a.desc4
                ,a.ipi
				
				,c.proaltcx
				,c.prolarcx
				,c.procomcx
				,c.propescx
				
				,c.proemb
				
				,d.barcaixa
				,(select e.clanumero from clfiscal e where c.clacodigo = e.clacodigo limit 1) as clanumero
				,c.clacodigo
				,d.barunidade
				
                FROM produto c,pcitem a
				left join cbarras as d on a.procodigo = d.procodigo
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
								
                order by a.pcicodigo";

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

    function alterapcitem($tabela, $alteracao, $pcicodigo) {

        $this->query = "UPDATE $tabela SET $alteracao WHERE pcicodigo=$pcicodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function selecionapre($pcnumero) {

        $this->query = "SELECT pcnumero
                FROM prerecebimento 
                Where pcnumero = $pcnumero";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function selecionapre1($pcnumero) {

        $this->query = "SELECT c.procod as codigo,c.proref
                ,c.prnome as descricao
                ,c.proemb
				,b.embalagem
				
                FROM produto c,pcitem a,prerecebimento b
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
				and a.procodigo = b.procodigo
				and a.pcnumero = b.pcnumero
				and c.proemb <> b.embalagem
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function selecionapre2($pcnumero) {

        $this->query = "SELECT c.procod as codigo,c.proref
                ,c.prnome as descricao
                ,d.barcaixa
				,b.barcaixa as barcaixa2
				
                FROM produto c,prerecebimento b,pcitem a
				
				left join cbarras as d on a.procodigo = d.procodigo
				
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
				and a.procodigo = b.procodigo
				and a.pcnumero = b.pcnumero
				and (d.barcaixa <> b.barcaixa or d.barcaixa isnull)
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function selecionapre3($pcnumero) {

        $this->query = "SELECT c.procod as codigo,c.proref
                ,c.prnome as descricao
                ,d.barunidade
				,b.barunidade as barunidade2
				
                FROM produto c,prerecebimento b,pcitem a
				
				left join cbarras as d on a.procodigo = d.procodigo
				
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
				and a.procodigo = b.procodigo
				and a.pcnumero = b.pcnumero
				and (d.barunidade <> b.barunidade or d.barunidade isnull)
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function selecionapre4($pcnumero) {

        $this->query = "SELECT c.procod as codigo,c.proref
                ,c.prnome as descricao
				
				,c.proaltcx
				,c.prolarcx
				,c.procomcx
				
				,b.altura
				,b.largura 
				,b.comprimento
				
                FROM produto c,prerecebimento b,pcitem a
				
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
				and a.procodigo = b.procodigo
				and a.pcnumero = b.pcnumero
				and (c.proaltcx <> b.altura
				or c.prolarcx <> b.largura 
				or c.procomcx <> b.comprimento
				or (c.proaltcx = 0 and b.altura = 0)
				or (c.proaltcx = 0 and b.altura = 0)
				or (c.proaltcx = 0 and b.altura = 0)
				)
				
                order by a.pcicodigo";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona5($pcnumero) {



        $this->query = "SELECT c.procod as codigo,c.proref
                ,c.prnome as descricao
                ,(a.pcisaldo) as estoque
                ,a.pcipreco as conferido
                ,a.pcicodigo
                ,a.pcibaixa
				
                ,a.desc1
                ,a.desc2
                ,a.desc3
                ,a.desc4
                ,a.ipi
				
				,c.proaltcx
				,c.prolarcx
				,c.procomcx
				,c.propescx
				
				,c.proemb
				
				,d.barcaixa
				,(select e.clanumero from clfiscal e where c.clacodigo = e.clacodigo limit 1) as clanumero
				,c.clacodigo
				,d.barunidade
				
				,f.altura
				,f.largura
				,f.comprimento
				,f.peso
				,f.embalagem
				,f.barcaixa as barcaixa2
				,(select e.clanumero from clfiscal e where f.clacodigo = e.clacodigo limit 1) as clanumero2
				,f.clacodigo as clacodigo2
				,f.barunidade as barunidade2
				,f.quantidade
				
				
                FROM produto c,pcitem a
				left join cbarras as d on a.procodigo = d.procodigo
				left join prerecebimento as f on (a.procodigo = f.procodigo and a.pcnumero = f.pcnumero)
                Where a.pcnumero = $pcnumero
                and a.procodigo = c.procodigo
								
                order by a.pcicodigo";


        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

}

?>
