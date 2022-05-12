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

    //Selecionar dados do banco
    function seleciona($campos, $tabela, $condicao) {
        $this->query = "SELECT $campos FROM $tabela WHERE $condicao";
        //print($this->query); die;
        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona2($pesquisa1, $pesquisa2) {

        $this->query = "SELECT 
                                    a.rompedcodigo,
                                    a.pvnumero,
                                    c.clirazao,
                                    a.rpvolumes,
                                    lpad(cast(extract(day from b.pvemissao) as varchar),2,'0')||'/'|| lpad(cast(extract(month from b.pvemissao) as varchar),2,'0')||'/'|| EXTRACT(YEAR FROM b.pvemissao) as emissao,a.romcodigo,c.clicodigo
                                    FROM romaneiospedidos a,romaneios d, pvenda b
                                    LEft Join clientes as c on c.clicodigo = b.clicodigo
                                    WHERE d.romnumero = '$pesquisa1'
                                    AND d.romano = '$pesquisa2'
                                    AND a.pvnumero = b.pvnumero
                                    AND d.romcodigo = a.romcodigo
                                    order by a.pvnumero";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function seleciona3($pesquisa1, $pesquisa2) {

        $this->query = "SELECT a.romforcodigo,a.forcodigo,c.clirazao,a.rpvolumes,
                lpad(cast(extract(day from b.pvemissao) as varchar),2,'0')||'/'||
                lpad(cast(extract(month from b.pvemissao) as varchar),2,'0')||'/'||
                EXTRACT(YEAR FROM b.pvemissao) as emissao,a.romcodigo,c.clicodigo
                FROM romaneiospedidos a,romaneios d, pvenda b
                LEft Join clientes as c on c.clicodigo = b.clicodigo
                WHERE d.romnumero = '$pesquisa1'
		AND d.romano = '$pesquisa2'
                AND a.pvnumero = b.pvnumero
		AND d.romcodigo = a.romcodigo
                order by a.pvnumero";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

    function insere($tabela, $campos, $valores) {
        $this->query = "INSERT INTO $tabela $campos VALUES $valores";
        pg_query($this->query) or die("Nao foi possivel inserir o registro na base");
    }

    function apaga($tabela, $rompedcodigo) {
        $this->query = "DELETE FROM $tabela WHERE rompedcodigo=$rompedcodigo
                ";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function apaga1($tabela, $romcodigo) {
        $this->query = "DELETE FROM $tabela WHERE romcodigo=$romcodigo
                ";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function apagaFornecedor($tabela, $romcodigo) {
        $this->query = "DELETE FROM $tabela WHERE romcodigofor=$romcodigo
                ";
        pg_query($this->query) or die("Nao foi possivel apagar o registro na base");
    }

    function altera($tabela, $alteracao, $romcodigo, $pvnumero) {
        $this->query = "UPDATE $tabela SET $alteracao
                WHERE romcodigo=$romcodigo
                AND pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alteraromaneio($tabela, $alteracao, $romcodigo) {
        $this->query = "UPDATE $tabela SET $alteracao
                WHERE romcodigo=$romcodigo";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

    function alterapalmexp($tabela, $alteracao, $pvnumero) {
        $this->query = "UPDATE $tabela SET $alteracao
                WHERE pvnumero=$pvnumero";
        pg_query($this->query) or die("Nao foi possivel alterar o registro na base");
    }

}

?>