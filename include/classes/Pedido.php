<?php

require_once("./_app/Config.inc.php");
require_once('./include/classes/Cliente.php');
require_once('./include/classes/NotaFiscal.php');

class Pedido {

    public $pvnumero;
    public $pvemissao;
    public $pvtipoped;
    public $pvtipofrete;
    public $cliente;
    public $notafiscal;
    
    public function pesquisar($pedido) {
    
        $read = new Read;
        $read->FullRead("SELECT pvnumero,pvemissao,pvtipoped,pvtipofrete,clicodigo FROM pvenda WHERE pvnumero = {$pedido}");
 
        if ($read->getRowCount() >= 1){
            $this->pvnumero = $read->getResult()[0]['pvnumero'];
            $this->pvemissao = $read->getResult()[0]['pvemissao'];
            $this->pvtipoped = $read->getResult()[0]['pvtipoped'];
            $this->pvtipofrete = $read->getResult()[0]['pvtipofrete'] ? trim($read->getResult()[0]['pvtipofrete']) : null;
            $this->cliente = new Cliente();            
            $this->cliente->pesquisar($read->getResult()[0]['clicodigo']);
            $this->notafiscal = new NotaFiscal();            
            $this->notafiscal->pesquisar($read->getResult()[0]['pvnumero']);
        }
        $read = null;
 
        
    }

}

