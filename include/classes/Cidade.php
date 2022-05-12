<?php

require_once("./_app/Config.inc.php");

class Cidade {

    public $descricao;
    public $uf;
        
    public function pesquisar($codigo) {
    
        $read = new Read;
        $read->FullRead("SELECT descricao,
                                uf 
                                FROM cidades WHERE cidcodigo = {$codigo}");
 
        if ($read->getRowCount() >= 1){
            $this->descricao = $read->getResult()[0]['descricao'];
            $this->uf = $read->getResult()[0]['uf'];            
        }
        $read = null;
 
        
    }

}

