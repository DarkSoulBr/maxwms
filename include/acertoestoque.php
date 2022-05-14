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

    function seleciona($codigoproduto, $dtinicio, $dtfinal, $deposito) {

        //Verifica qual o ultimo ano que existem tabelas de movimentação
        $ano = 8;
        $mes = 1;

        while (true) {

            $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

            //Se a tabela não existe sai do Loop
            $cad = pg_query("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
            if (pg_num_rows($cad) == 0) {
                break;
            }

            $mes ++;
            if ($mes == 13) {
                $mes = 1;
                $ano++;
            }
        }
        $anofim = $ano - 1;

        $ano = 8;
        $j = 0;

        //$anoinicio=intval(substr($dtinicio, 2, 2));
        //$mesinicio=intval(substr($dtinicio, 4, 2));
        $anofinal = intval(substr($dtfinal, 2, 2));
        $mesfinal = intval(substr($dtfinal, 4, 2));

        //$ano=$anoinicio;		
        //if ($ano<8){$ano=8;}

        $ano = 8; //ano sempre começa em 2008
        $mesinicio = 1; //mes sempre começa em Janeiro

        $dtinicio = '20080101';

        //for($i=1; $i<14; $i++) {
        for ($i = $mesinicio; $i < 18; $i++) {

            $mes = $i;


            if ($mes < 10) {
                $mesx = '0' . $mes;
            } else {
                $mesx = $mes;
            }

            if ($ano < 10) {
                $anox = '0' . $ano;
            } else {
                $anox = $ano;
            }

            if ($j == 0) {
                $this->query = "SELECT '0' as pvnumero,";
            } else {
                $this->query = $this->query . "Union SELECT '0' as pvnumero,";
            }
            $this->query = $this->query . " lpad(extract(day from a.movdata),2,0)||'/'||lpad(extract(month from a.movdata),2,0)||'/'||EXTRACT(YEAR FROM a.movdata) as data
			,a.movqtd,a.movvalor,a.movtipo,c.pvtipoped,a.movdata as ordem,a.pvnumero as x,a.movcodigo
			FROM produto b,movestoque" . $mesx . $anox . " a
			LEft Join pvenda as c on c.pvnumero = a.pvnumero
			Where b.procod = '$codigoproduto'
			
			and a.codestoque = '$deposito'			
			
			and EXTRACT(YEAR FROM a.movdata)||
            lpad(extract(month from a.movdata),2,0)||
            lpad(extract(day from a.movdata),2,0)
            >= $dtinicio
            AND EXTRACT(YEAR FROM a.movdata)||
            lpad(extract(month from a.movdata),2,0)||
            lpad(extract(day from a.movdata),2,0)
            <= $dtfinal
			
			and a.procodigo = b.procodigo ";

            if (($mes == 12) and ( $ano == $anofim)) {
                $i = 20;
            }

            if (($mes == $mesfinal) and ( $ano == $anofinal)) {
                $i = 20;
            }

            if (($mes == 12) and ( $i < 20)) {
                $ano++;
                $i = 0;
            }

            $j++;
        }

        $this->query = $this->query . " order by ordem,movtipo ";

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
