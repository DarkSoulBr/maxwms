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

    function seleciona($dtinicio, $dtfinal) {


        $this->query = "Select a.romnumero as romaneio,a.romano as ano,
		lpad(cast(extract(day from a.romdata) as varchar),2,'0')||'/'||
                lpad(cast(extract(month from a.romdata) as varchar),2,'0')||'/'||
                EXTRACT(YEAR FROM a.romdata) as data,
                a.romveiculo as codigo,
                b.veitipo as tipo,
				b.veiplaca as placa,
				lpad(cast(extract(day from a.rombaixa) as varchar),2,'0')||'/'||
                lpad(cast(extract(month from a.rombaixa) as varchar),2,'0')||'/'||
                EXTRACT(YEAR FROM a.rombaixa) as baixa,a.romcodigo as romcodigo,
				(select sum(1) as total  from romaneiospedidos as c Where c.romcodigo = a.romcodigo) as pedidos,
				(select sum(c.rpvolumes) from romaneiospedidos as c Where c.romcodigo = a.romcodigo) as volumes

      				,a.romvalor
      				,a.romcodigo


				FROM romaneios a, veiculos b
                WHERE EXTRACT(YEAR FROM a.romdata)||
                lpad(cast(extract(month from a.romdata) as varchar),2,'0')||
                lpad(cast(extract(day from a.romdata) as varchar),2,'0')
                >= '$dtinicio'
                AND EXTRACT(YEAR FROM a.romdata)||
                lpad(cast(extract(month from a.romdata) as varchar),2,'0')||
                lpad(cast(extract(day from a.romdata) as varchar),2,'0')
                <= '$dtfinal'
				AND a.romveiculo = b.veicodigo
                order by a.romdata,a.romnumero";

        $result = pg_query($this->query) or die("Nao foi possivel selecionar na base");
        return $result;
    }

}

?>