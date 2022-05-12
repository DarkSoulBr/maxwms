<?php

require_once("./_app/Config.inc.php");

class NotaFiscal {

    public $pvnumero;
    public $notnumero;
    public $notemissao;
    public $chave;
    public $notvolumes;
    public $notvalor;
    public $natcodigo;
    public $tipoIcms;
        
    public function pesquisar($codigo) {
        
        //Verifica de qual local vai fazer a pesquisa
        $read = new Read;
        $read->FullRead("SELECT count(*) as qtd 
                                FROM pvitem 
                                WHERE pvnumero = {$codigo}
                                AND pviest02 > 0");
 
        $itensLoja = 0;                        
        if ($read->getRowCount() >= 1){
            $itensLoja = $read->getResult()[0]['qtd'];                   
        }
        $read = null;
        
        if($itensLoja) {
            $tabela_nota = 'notafil';            
        } else {
            $tabela_nota = 'notagua';           
        }
    
        $read = new Read;
        $read->FullRead("SELECT pvnumero,
                                notnumero,
                                to_char( notemissao, 'dd/mm/yyyy') as notemissao,
                                chave,
                                notvolumes,
                                notvalor,
                                natcodigo
                                FROM {$tabela_nota} WHERE pvnumero = {$codigo}");
 
        if ($read->getRowCount() >= 1){
            $this->pvnumero = trim($read->getResult()[0]['pvnumero']);
            $this->notnumero = $read->getResult()[0]['notnumero'];            
            $this->notemissao = $read->getResult()[0]['notemissao'];            
            $this->chave = $read->getResult()[0]['chave'];            
            $this->notvolumes = trim($read->getResult()[0]['notvolumes']);            
            $this->notvalor = $read->getResult()[0]['notvalor'];            
            $this->natcodigo = $read->getResult()[0]['natcodigo'];
            $this->tipoIcms = "NORMAL";            
        }
        $read = null;
 
        
    }

}

