<?php

/**
 * Connection class to mySQL Server
 * @author S. Martin
 * @link http://www.hevs.ch
 */
class MySqlConn
{
    const HOST = "127.0.0.1";
    const PORT = "3306";
    const DATABASE = "cas_php";
    const USER = "root";
    const PWD = "";
    const ENCODING = "utf8";

    private static $instance;
    private $_conn;

    /**
     * prevent from direct creation of object
     */
    private function __construct()
    {
        try {
            $this->_conn = new PDO('mysql:host=' . self::HOST .
                ';port=' . self::PORT .
                ';dbname=' . self::DATABASE .
                ';charset='.self::ENCODING,
                self::USER, self::PWD);
        } catch (PDOException $e) {
            die ('Connection failed: ' . $e->getMessage());
        }

    }

    /**
     * singleton method
     * @return resource
     */
    public static function getInstance()
    {
        if (!isset(self::$instance) || self::$instance == null) {
            $c = __CLASS__;
            self::$instance = new $c();
        }
        return self::$instance;
    }

    public function selectDB($query)
    {
        $result = $this->_conn->query($query)
        or die(print_r($this->_conn->errorInfo(), true));

        return $result;
    }

    public function executeQuery($query)
    {
        $result = $this->_conn->exec($query);
        $e = $this->_conn->errorInfo();
        if ($e[1] != null) {
            if ($e[1] == 1062)
                return 'Doublon: the username exists already!';
            else
                die(print_r($this->_conn->errorInfo(), true));
        }
        return $result;
    }
}