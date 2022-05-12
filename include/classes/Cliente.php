<?php

require_once("./_app/Config.inc.php");
require_once('./include/classes/EnderecoFaturamento.php');

class Cliente {

    public $clicodigo;
    public $clicod;
    public $clirazao;
    public $clipessoa;
    public $clicnpj;
    public $clicpf;
    public $cliie;
    public $clisuframa;
    public $enderecoFaturamento;
    
    public function pesquisar($codigo) {
    
        $read = new Read;
        $read->FullRead("SELECT clicodigo,
                                clicod,
                                clirazao,
                                clipessoa,
                                clicnpj,
                                clicpf,
                                cliie,
                                clisuframa
                                FROM clientes WHERE clicodigo = {$codigo}");
 
        if ($read->getRowCount() >= 1){
            $this->clicodigo = $read->getResult()[0]['clicodigo'];
            $this->clicod = $read->getResult()[0]['clicod'];
            $this->clirazao = $read->getResult()[0]['clirazao'];
            $this->clipessoa = $read->getResult()[0]['clipessoa'];
            $this->clicnpj = $read->getResult()[0]['clicnpj'];
            $this->clicpf = $read->getResult()[0]['clicpf'];
            $this->cliie = $read->getResult()[0]['cliie'];
            $this->clisuframa = $read->getResult()[0]['clisuframa'];
            $this->enderecoFaturamento = new EnderecoFaturamento;            
            $this->enderecoFaturamento->pesquisar($read->getResult()[0]['clicodigo']);
        }
        $read = null;
 
        
    }

}

