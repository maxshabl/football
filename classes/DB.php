<?php
/**
 * Created by PhpStorm.
 * User: Octo
 * Date: 24.10.2017
 * Time: 23:07
 */

namespace Classes;


class DB
{
    private $db;

    public static $instance;

    public static function getConnection()
    {
        if(empty(self::$instance))
            self::$instance = new self;

        return self::$instance;
    }

    public function getTeamsStatistics()
    {
        $sql = 'SELECT * FROM statistics';
        $res = $this->db->prepare($sql);
        $res->execute();
        $this->statistics = $res->fetchAll(\PDO::FETCH_ASSOC);
    }

    private function __construct(array $config)
    {
        if($this->db === null) {
            $dsn = 'mysql:dbname=bd_football;host=127.0.0.1';
            $user = 'root';
            $password = '';
            try {
                $this->db = new \PDO($dsn, $user, $password);
                $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\PDOException $e) {
                echo 'Подключение не удалось: ' . $e->getMessage();
            }

        }
    }


    private function __clone() {}
}