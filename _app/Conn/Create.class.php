<?php

/**
 * <b>Create.class:</b>
 * Classe responsável por cadastros genericos de todo o Banco de Dados!
 * 
 * @copyright (c) 2017, Luis Ramires DELTA MAIS TECNOLOGIA
 */
class Create extends Conn {

    private $Tabela;
    private $Sequence;
    private $Dados;
    private $Result;
    private $Erro;

    /** @var PDOStatement */
    private $Create;

    /** @var PDO */
    private $Conn;

    /**
     * <b>ExeCreate:</b> Executa um cadastro simplificado no banco de dados utilizando prepared statements.
     * Basta informar o nome da tabela e um array atribuitivo com nome da coluna e valor!
     * 
     * @param STRING $Tabela = Informe o nome da Tabela
     * @param STRING $Sequence = Informe o nome do Sequence (é obrigatorio para o Postgres)
     * @param ARRAY $Dados = Informe um array atribuitivo. ( Nome da Coluna => Valor )
     */
    public function ExeCreate($Tabela, $Sequence, array $Dados) {
        $this->Tabela = (string) $Tabela;
        $this->Sequence = (string) $Sequence;
        $this->Dados = $Dados;
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna o ID do registro inserido ou FALSE caso nenhum registro seja inserido! 
     * @return INT $Variavel = lastInsertId OR FALSE
     */
    public function getResult() {
        return $this->Result;
    }
    
    /**
     * <b>Obter resultado:</b> Retorna a mensagem de erro caso nenhum registro seja inserido! 
     */
    public function getErro() {
        return $this->Erro;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************     * 
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Create = $this->Conn->prepare($this->Create);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        
        $Fileds = implode(', ', array_keys($this->Dados));
        $Places = ':' . implode(', :', array_keys($this->Dados));
       	
        $this->Create = "INSERT INTO {$this->Tabela} ({$Fileds}) VALUES ({$Places})";
    }

    //Obtem a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        try {
            $this->Create->execute($this->Dados);			
            $this->Result = $this->Conn->lastInsertId($this->Sequence);
            $this->Erro = null;
        } catch (PDOException $e) {
            $this->Result = null;
            $this->Erro = $e->getMessage();
        };
    }

}
