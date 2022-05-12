<?php

/**
 * <b>Update.class:</b>
 * Classe responsável por atualizações genericas de todo o Banco de Dados!
 * 
 * @copyright (c) 2017, Luis Ramires DELTA MAIS TECNOLOGIA
 */
class Update extends Conn {

    private $Tabela;
    private $Dados;
    private $Termos;
    private $Places;
    private $Result;
    private $Erro;

    /** @var PDOStatement */
    private $Update;

    /** @var PDO */
    private $Conn;

    /**
     * <b>Exe Update:</b> Executa uma atualização simplificada com Prepared Statments. Basta informar o 
     * nome da tabela, os dados a serem atualizados em um Array Atribuitivo, as condições e uma 
     * analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param ARRAY $Dados = [ NomeDaColuna ] => Valor ( AtribuiÃ§Ã£o )
     * @param STRING $Termos = WHERE coluna = :link AND.. OR..
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function ExeUpdate($Tabela, array $Dados, $Termos, $ParseString) {
        $this->Tabela = (string) $Tabela;
        $this->Dados = $Dados;
        $this->Termos = (string) $Termos;
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna um array com todos os resultados obtidos. Envelope primário nnmérico. Para obter
     * um resultado chame o Índice getResult()[0]!
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
     * <b>Contar Registros: </b> Retorna o número de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRowCount() {
        return $this->Update->rowCount();
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
        $this->Update = $this->Conn->prepare($this->Update);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {

        foreach ($this->Dados as $Key => $Value) {

            $Places[] = $Key . ' =:' . $Key;
        }

        $Places = implode(', ', $Places);
        $this->Update = "UPDATE {$this->Tabela} SET {$Places} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();

        try {
            $this->Update->execute(array_merge($this->Dados, $this->Places));           
            $this->Result = true;
            $this->Erro = null;
        } catch (PDOException $e) {
            $this->Result = null;
            $this->Erro = $e->getMessage();
        }
    }

}
