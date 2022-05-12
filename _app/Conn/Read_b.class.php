<?php

/**
 * <b>Read_b.class:</b>
 * Classe responsável por leituras genericas de todo o Banco de Dados!
 * 
 * @copyright (c) 2017, Luis Ramires DELTA MAIS TECNOLOGIA
 */
class Read_b extends Conn_b {

    private $Select;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Read_b;

    /** @var PDO */
    private $Conn_b;

  /**
     * <b>Exe Read_b:</b> Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e uma analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function ExeRead($Tabela, $Termos = null, $ParseString = null) {
        if (!empty($ParseString)):
            //$this->Places = $ParseString;
            parse_str($ParseString, $this->Places);
        endif;
        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";        
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna um array com todos os resultados obtidos. Envelope primário numérico. Para obter
     * um resultado chame o Ã­ndice getResult()[0]!
     * @return ARRAY $this = Array ResultSet
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRowCount() {
        return $this->Read_b->rowCount();
    }

    /**
     * <b>Full Read_b:</b> Executa leitura de dados via query que deve ser montada manualmente para possibilitar
     * seleção de multiplas tabelas em uma única query!
     * @param STRING $Query = Query Select Syntax
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function FullRead($Query, $ParseString = null) {
        $this->Select = (string) $Query;
        if (!empty($ParseString)):
            //$this->Places = $ParseString;
            parse_str($ParseString, $this->Places);
        endif;
        $this->Execute();
    }

    /**
     * <b>Set Places:</b> Seta as Colunas de acordo com os valores informados!
     * * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->Execute();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************     * 
     */
    //ObtÃ©m o PDO e Prepara a query
    private function Connect() {
        $this->Conn_b = parent::getConn();
        $this->Read_b = $this->Conn_b->prepare($this->Select);
        $this->Read_b->setFetchMode(PDO::FETCH_ASSOC);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor) {
                if ($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                $this->Read_b->bindValue(":{$Vinculo}", $Valor, (is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        endif;
    }

    //ObtÃ©m a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read_b->execute();
            $this->Result = $this->Read_b->fetchAll();
        } catch (PDOException $e) {
            $this->Result = null;
            //WSErro("Erro ao Pesquisar:<b>{$e->getMessage()}</b>", $e->getCode());
        }
    }

}
