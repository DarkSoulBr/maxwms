<?php

require('./_app/Config.inc.php');

$flag = trim($_GET["flag"]);

header("Content-type: application/xml");
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>";
$xml .= "<dadosc>";
$xml .= "<registroc>";

if ($flag == 1) {

    $ano = 22;
    $mes = 1;

    while (true) {

        $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

        //Se a tabela não existe sai do Loop
        $read = new Read;
        $read->FullRead("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
        if ($read->getRowCount() == 0) {
            $read = null;
            break;
        }
        $read = null;

        $mes ++;
        if ($mes == 13) {
            $mes = 1;
            $ano++;
        }
    }

    $ano += 2000;
    $fim = $ano - 1;

    $xml .= "<itemc>" . $ano . "</itemc>";
    $xml .= "<itemc>" . $fim . "</itemc>";
} else {


    $ano = $_GET["ano"];
    
    $ano -= 2000;

    for ($mes = 1; $mes <= 12; $mes++) {        
        
        $tabela = 'movestoque' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);

        //Se a tabela não existe sai do Loop
        $read = new Read;
        $read->FullRead("SELECT relname FROM pg_class WHERE relname = '{$tabela}'");
        if ($read->getRowCount() == 0) {
            
            $chaveprimaria = 'movcodigo' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT);
            $indice = 'mov' . str_pad($mes, 2, '0', STR_PAD_LEFT) . str_pad($ano, 2, '0', STR_PAD_LEFT) . '_01';
       
            $sql = "CREATE TABLE {$tabela} (
                      pvnumero character varying(10),
                      movdata timestamp with time zone,
                      procodigo integer,
                      movqtd integer,
                      movvalor double precision,
                      movtipo smallint,
                      movcodigo serial NOT NULL,
                      codestoque integer,
                      empresa integer,
                      CONSTRAINT {$chaveprimaria} PRIMARY KEY (movcodigo)
                    ) WITH (
                      OIDS=FALSE
                    )";
            
            $create = new Read;
            $create->FullRead($sql);
            $create = null;
            
            $sql = "ALTER TABLE {$tabela} OWNER TO centro";
            $create = new Read;
            $create->FullRead($sql);
            $create = null;
            
            $sql = "CREATE INDEX {$indice} ON {$tabela}
                    USING btree
                    (procodigo, codestoque, movtipo, movdata)
                    TABLESPACE pg_default";
            
            $create = new Read;
            $create->FullRead($sql);
            $create = null;            
                        
        }
        $read = null;

        
    }
   
    $xml .= "<itemc>1</itemc>";
}
$xml .= "</registroc>";
$xml .= "</dadosc>";

echo $xml;

