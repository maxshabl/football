<?php

namespace Classes;

class Power
{
    public $statistics;

    public function __construct()
    {
        $dsn = 'mysql:dbname=bd_football;host=127.0.0.1';
        $user = 'root';
        $password = '';
        try {
            $dbh = new \PDO($dsn, $user, $password);
            $dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            echo 'Подключение не удалось: ' . $e->getMessage();
        }
        $sql = 'SELECT * FROM statistics';
        $res = $dbh->prepare($sql);
        $res->execute();
        $this->statistics = $res->fetchAll(\PDO::FETCH_ASSOC);

    }

    /**
     * Генерируем силу атаки, обороны и общую силу. На основе последней определяется победитель турнира.
     * @var array $couple
     * @return array
     */
    public function getTeamsPower() : array
    {
        $teams = [];
        foreach ($this->statistics as $itemTeam) {
            $powerAttack = $this->getPowerAttack($itemTeam);
            $powerDefense = $this->getPowerDefense($itemTeam);
            $totalPower = round($powerAttack + $powerDefense) > 0 ? round($powerAttack + $powerDefense) : 1 ;
            $teams[$itemTeam['id']] = [
                'id' => $itemTeam['id'],
                'country' => $itemTeam['Country'],
                'powerAttack' => $powerAttack,
                'powerDefense' => $powerDefense,
                'totalPower' => $totalPower
            ];
        }

        return $teams;
    }


    /**
     * Получаем силу атаки, на основе статистики забитых мячей, побед и сигранных матчей.
     * @var array $params
     * @return float
     */
    public function getPowerAttack(array $params): float
    {
        $powerAttack = ($params['Goals_for']/$params['Played'])*($params['Wins']/$params['Played'])*10;

        return $powerAttack;
    }


    /**
     * Получаем силу обороны, на основе статистики пропущенных мячей мячей, поражений и сигранных матчей.
     * @var array $params
     * @return float
     */
    public function getPowerDefense(array $params): float
    {
        $powerDefense = 1/(($params['Goals_against']/$params['Played'])*($params['Losses']/$params['Played']))*10;

        return $powerDefense;
    }



}