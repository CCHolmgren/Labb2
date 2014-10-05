<?php
/**
 * Created by PhpStorm.
 * User: Chrille
 * Date: 2014-09-27
 * Time: 16:50
 */
namespace Model;

class Database{
    protected static $DB_CONNSTRING = "pgsql:host=localhost;dbname=php-lab2";
    protected static $DB_USERNAME = "php";
    protected static $DB_PASSWORD = "password";
    private $connection;

    public function getConnection(){
        if(!$this->connection)
            $this->connection = new \PDO(self::$DB_CONNSTRING, self::$DB_USERNAME,self::$DB_PASSWORD);

        $this->connection ->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $this->connection;
    }
}