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
        $ano = 22;
        $mes = 1;

        while (true) {

            $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

            //Se a tabela não existe sai do Loop
            $cad = pg_query("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
            if (pg_num_rows($cad) == 0) {
                break;
            }

            $mes++;
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

        $ano = 22; //ano sempre começa em 2008
        $mesinicio = 1; //mes sempre começa em Janeiro

        $dtinicio = '20220101';

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
                $this->query = "SELECT a.pvnumero,";
            } else {
                $this->query = $this->query . "Union SELECT a.pvnumero,";
            }
            $this->query = $this->query . " lpad(cast(extract(day from a.movdata) as varchar),2,'0')||'/'||lpad(cast(extract(month from a.movdata) as varchar),2,'0')||'/'||EXTRACT(YEAR FROM a.movdata) as data
			,a.movqtd,a.movvalor,a.movtipo,c.pvtipoped,a.movdata as ordem,a.movcodigo
			FROM produto b,movestoque" . $mesx . $anox . " a
			LEft Join pvenda as c on c.pvnumero = a.pvnumero
			Where b.procod = '$codigoproduto'
			
			and a.codestoque = '$deposito'
			
			and EXTRACT(YEAR FROM a.movdata)||
            lpad(cast(extract(month from a.movdata) as varchar),2,'0')||
            lpad(cast(extract(day from a.movdata) as varchar),2,'0')
            >= '$dtinicio'
            AND EXTRACT(YEAR FROM a.movdata)||
            lpad(cast(extract(month from a.movdata) as varchar),2,'0')||
            lpad(cast(extract(day from a.movdata) as varchar),2,'0')
            <= '$dtfinal'
			
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

        $this->query = $this->query . " order by ordem,movcodigo ";

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

    function selecionanovo($codigoproduto, $dtinicio, $dtfinal, $deposito) {

        //Verifica qual o ultimo ano que existem tabelas de movimentação
        $ano = 22;
        $mes = 1;

        while (true) {

            $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

            //Se a tabela não existe sai do Loop
            $cad = pg_query("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
            if (pg_num_rows($cad) == 0) {
                break;
            }

            $mes++;
            if ($mes == 13) {
                $mes = 1;
                $ano++;
            }
        }
        $anofim = $ano - 1;


        $dtinicioOriginal = $dtinicio;

        //Localiza o Ultimo Inventario antes da Data Inicial para Processar só daquele mes para Frente

        $auxmes = 0;
        $auxano = 0;

        $ano = 8;
        $j = 0;

        $anofinal = intval(substr($dtinicio, 2, 2));
        $mesfinal = intval(substr($dtinicio, 4, 2));

        if ($mesfinal == 1) {
            $mesfinal = 12;
            $anofinal = $anofinal - 1;
        } else {
            $mesfinal = $mesfinal - 1;
        }

        $ano = 22; //ano sempre começa em 2008
        $mesinicio = 1; //mes sempre começa em Janeiro

        $dtinicio = '20220101';

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

            $sql = "Select a.movtipo ";
            $sql = $sql . "FROM produto b,movestoque" . $mesx . $anox . " a			
			Where b.procod = '$codigoproduto'			
			and a.codestoque = '$deposito'			
			and a.movtipo = '1'						
			and a.procodigo = b.procodigo ";

            $sql = pg_query($sql);
            $row = pg_num_rows($sql);

            if ($row) {
                $auxmes = $mes;
                $auxano = $ano;
            }

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

        $ano = 8;
        $j = 0;

        //$anoinicio=intval(substr($dtinicio, 2, 2));
        //$mesinicio=intval(substr($dtinicio, 4, 2));
        $anofinal = intval(substr($dtfinal, 2, 2));
        $mesfinal = intval(substr($dtfinal, 4, 2));

        //$ano=$anoinicio;		
        //if ($ano<8){$ano=8;}


        if ($auxmes == 0) {
            $ano = 8; //ano sempre começa em 2008
            $mesinicio = 1; //mes sempre começa em Janeiro
            //Se não Localizou nenhum Inventario é provavel que seja um produto Novo
            //Nesses casos o Inicio será a Data Inicial 									
            $ano = (int) substr($dtinicioOriginal, 2, 2);
            $mesinicio = (int) substr($dtinicioOriginal, 4, 2);
        }
        //Se Houver inventário antes da data inicial será nesse mes que começa o processamento
        else {
            $ano = $auxano; //ano sempre começa em 2008
            $mesinicio = $auxmes; //mes sempre começa em Janeiro
        }

        $dtinicio = '20080101';

        //for($i=1; $i<14; $i++) {
        for ($i = $mesinicio; $i < 18; $i++) {

            $mes = $i;

            //LEft Join pvenda as c on c.pvnumero = a.pvnumero

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
                $this->query = "SELECT a.pvnumero,";
            } else {
                $this->query = $this->query . "Union SELECT a.pvnumero,";
            }
            $this->query = $this->query . " lpad(cast(extract(day from a.movdata) as varchar),2,'0')||'/'||lpad(cast(extract(month from a.movdata) as varchar),2,'0')||'/'||EXTRACT(YEAR FROM a.movdata) as data
			,a.movqtd,a.movvalor,a.movtipo,' ' as pvtipoped,a.movdata as ordem,a.movcodigo
			FROM produto b,movestoque" . $mesx . $anox . " a
			
			Where b.procod = '$codigoproduto'
			
			and a.codestoque = '$deposito'
			
			and EXTRACT(YEAR FROM a.movdata)||
            lpad(cast(extract(month from a.movdata) as varchar),2,'0')||
            lpad(cast(extract(day from a.movdata) as varchar),2,'0')
            >= '$dtinicio'
            AND EXTRACT(YEAR FROM a.movdata)||
            lpad(cast(extract(month from a.movdata) as varchar),2,'0')||
            lpad(cast(extract(day from a.movdata) as varchar),2,'0')
            <= '$dtfinal'
			
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

        $this->query = $this->query . " order by ordem,movcodigo ";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona_novo($codigoproduto, $dtinicio, $dtfinal, $deposito) {

        //Verifica qual o ultimo ano que existem tabelas de movimentação
        $ano = 22;
        $mes = 1;

        while (true) {

            $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

            //Se a tabela não existe sai do Loop
            $cad = pg_query("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
            if (pg_num_rows($cad) == 0) {
                break;
            }

            $mes++;
            if ($mes == 13) {
                $mes = 1;
                $ano++;
            }
        }
        $anofim = $ano - 1;

        $dtinicioOriginal = $dtinicio;

        //Localiza o Ultimo Inventario antes da Data Inicial para Processar só daquele mes para Frente

        $anofinal = (int) substr($dtinicio, 2, 2);
        $mesfinal = (int) substr($dtinicio, 4, 2);

        if ($mesfinal == 1) {
            $mesfinal = 12;
            $anofinal--;
        } else {
            $mesfinal--;
        }

        $auxmes = 0;
        $auxano = 0;

//Loopinp do Ano será regressivo até 2008 que é quando começaram as operações 
        for ($i = $anofinal; $i >= 22; $i--) {

            if ($i == $anofinal) {
                $i3 = $mesfinal;
            } else {
                $i3 = 12;
            }

            //Looping do Mês
            for ($i2 = $i3; $i2 > 0; $i2--) {

                $tabelaEstoque = "movestoque" . str_pad($i2, 2, "0", STR_PAD_LEFT) . str_pad($i, 2, "0", STR_PAD_LEFT);


                $sql = "SELECT a.movtipo FROM produto b,{$tabelaEstoque} a			
                WHERE b.procod = '{$codigoproduto}'			
                AND a.codestoque = {$deposito}			
                AND a.movtipo = '1'						
                AND a.procodigo = b.procodigo ";

                $sql = pg_query($sql);
                $row = pg_num_rows($sql);

                if ($row) {
                    $auxmes = $i2;
                    $auxano = $i;
                    break 2;
                }
            }
        }


        $anofinal = intval(substr($dtfinal, 2, 2));
        $mesfinal = intval(substr($dtfinal, 4, 2));



        if ($auxmes == 0) {
            $ano = 22; //ano sempre começa em 2008
            $mesinicio = 1; //mes sempre começa em Janeiro
            //Se não Localizou nenhum Inventario é provavel que seja um produto Novo
            //Nesses casos o Inicio será a Data Inicial 									
            $ano = (int) substr($dtinicioOriginal, 2, 2);
            $mesinicio = (int) substr($dtinicioOriginal, 4, 2);
        }
        //Se Houver inventário antes da data inicial será nesse mes que começa o processamento
        else {
            $ano = $auxano; //ano sempre começa em 2008
            $mesinicio = $auxmes; //mes sempre começa em Janeiro
        }

        $dtinicio = '20220101';

        $j = 0;

        //for($i=1; $i<14; $i++) {
        for ($i = $mesinicio; $i < 18; $i++) {

            $mes = $i;

            //LEft Join pvenda as c on c.pvnumero = a.pvnumero

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
                $this->query = "SELECT a.pvnumero,";
            } else {
                $this->query = $this->query . "Union SELECT a.pvnumero,";
            }
            $this->query = $this->query . " lpad(cast(extract(day from a.movdata) as varchar),2,'0')||'/'||lpad(cast(extract(month from a.movdata) as varchar),2,'0')||'/'||EXTRACT(YEAR FROM a.movdata) as data
			,a.movqtd,a.movvalor,a.movtipo,' ' as pvtipoped,a.movdata as ordem,a.movcodigo,a.empresa 
			FROM produto b,movestoque" . $mesx . $anox . " a
			
			Where b.procod = '$codigoproduto'
			
			and a.codestoque = '$deposito'
			
			and EXTRACT(YEAR FROM a.movdata)||
            lpad(cast(extract(month from a.movdata) as varchar),2,'0')||
            lpad(cast(extract(day from a.movdata) as varchar),2,'0')
            >= '$dtinicio'
            AND EXTRACT(YEAR FROM a.movdata)||
            lpad(cast(extract(month from a.movdata) as varchar),2,'0')||
            lpad(cast(extract(day from a.movdata) as varchar),2,'0')
            <= '$dtfinal'
			
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

        $this->query = $this->query . " order by ordem,movcodigo ";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

}

?>
