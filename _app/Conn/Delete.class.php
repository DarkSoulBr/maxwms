<?php

/**
 * <b>Delete.class:</b>
 * Classe respons�vel por exclus�es genericas de todo o Banco de Dados!
 * 
 * @copyright (c) 2017, Luis Ramires DELTA MAIS TECNOLOGIA
 */
class Delete extends Conn {

    private $Tabela;
    private $Termos;
    private $Places;
    private $Result;
    private $Erro;

    /** @var PDOStatement */
    private $Delete;

    /** @var PDO */
    private $Conn;

    /**
     * <b>Exe Delete:</b> Executa uma exclus�o simplificada com Prepared Statments. Basta informar o 
     * nome da tabela, e as condi��es e uma 
     * analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE coluna = :link AND.. OR..
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function ExeDelete($Tabela, $Termos, $ParseString) {
        $this->Tabela = (String) $Tabela;
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna um array com todos os resultados obtidos. Envelope prim�rio num�rico. Para obter
     * um resultado chame o �ndice getResult()[0]!
     * @return ARRAY $this = Array ResultSet
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
     * <b>Contar Registros: </b> Retorna o n�mero de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRowCount() {
        return $this->Delete->rowCount();
    }

    /**
     * <b>Set Places:</b> Seta as Colunas de acordo com os valores informados!
     * * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************     * 
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Conn = parent::getConn();
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    //Obt�m a Conex�o e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        try {
            $this->Delete->execute($this->Places);
            $this->Result = true;
            $this->Erro = null;
        } catch (PDOException $e) {
            $this->Result = null;
            $this->Erro = $e->getMessage();
        }
    }

}
