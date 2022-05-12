<?php

/**
 * Conn_b.class [ CONEXÃO ]
 * Classe Abstrata de Conexão. Padrão SingleTon
 * Retorna um obejto PDO pelo método estático getConn_b(); 
 * @copyright (c) 2017, Luis Ramires DELTA MAIS TECNOLOGIA
 */
class Conn_b {

    private static $Host = HOST_B;
    private static $User = USER_B;
    private static $Pass = PASS_B;
    private static $Dbsa = DBSA_B;
    
    /** @var PDO */
    private static $Connect = null;

    /**
     * Conecta com o bando de dados com pattern singleton
     * Retorna um objeto PDO!
     */
    private static function Conectar() {

        try {
            if (self::$Connect == null):                
				//$dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
				$dsn = 'pgsql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
				//$options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
				//self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
				self::$Connect = new PDO($dsn, self::$User, self::$Pass);                
            endif;
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }

        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }

    /** Retorna um objeto singleton pattern */
    public static function getConn() {
        return self::Conectar();
    }

}
