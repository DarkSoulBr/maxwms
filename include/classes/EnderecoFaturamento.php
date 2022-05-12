<?php

require_once("./_app/Config.inc.php");
require_once('./include/classes/Cidade.php');

class EnderecoFaturamento {

    public $cleendereco;
    public $clenumero;
    public $clecomplemento;
    public $clebairro;
    public $cidade;
    public $clecep;
    public $cidcodigo;
    public $clefone;
    
    public function pesquisar($codigo) {
    
        $read = new Read;
        $read->FullRead("SELECT cleendereco,
                                clenumero,
                                clecomplemento,
                                clebairro,
                                clecep,
                                cidcodigoibge,
                                cidcodigo,
                                clefone 
                                FROM cliefat WHERE clicodigo = {$codigo}");
 
        if ($read->getRowCount() >= 1){
            $this->cleendereco = trim($read->getResult()[0]['cleendereco']);
            $this->clenumero = trim($read->getResult()[0]['clenumero']);
            $this->clecomplemento = $read->getResult()[0]['clecomplemento'];
            $this->clebairro = trim($read->getResult()[0]['clebairro']);
            $this->clecep = $read->getResult()[0]['clecep'];
            $this->cidcodigo = $read->getResult()[0]['cidcodigoibge'];
            $this->clefone = $read->getResult()[0]['clefone'];
            $this->cidade = new Cidade;            
            $this->cidade->pesquisar($read->getResult()[0]['cidcodigo']);
        }
        $read = null;
 
        
    }

}

