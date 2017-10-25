<?php

namespace Classes;


class DB
{
    
    
    /**
     * Соединение с базой
     * @var 
     */
    private $db;

    
    /**
     * Экземпляр класса DB
     * @var DB
     */
    public static $instance;


    /**
     * Возвращает экземпляр класса DB
     * @return DB
     */
    public static function getConnection() : DB
    {        
        if(empty(self::$instance))
            self::$instance = new self;

        return self::$instance;
    }

    
    /**
     * Возвращает статистику команд
     * @return array
     */
    public function getTeamsStatistics() : array
    {
        $sql = 'SELECT * FROM statistics';
        $res = $this->db->prepare($sql);
        $res->execute();
        return $res->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Создает подключение к БД на основе config.php
     */
    private function __construct()
    {
        $config = require_once (__DIR__.'\..\config\config.php');
        if($this->db === null) {            
            try {
                $this->db = new \PDO($config['db']['dsn'], $config['db']['user'], $config['db']['password']);
                $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\PDOException $e) {
                echo 'Подключение не удалось: ' . $e->getMessage();
            }

        }
    }


    private function __clone() {}
}