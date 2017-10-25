<?php

namespace Classes;


class Teams
{

    /**
     * Статистика команд с рассчитаной силой атаки
     * @var DB $db
     */
    public $statistics;


    /**
     * Получаем статистику команд из базы
     * @var DB $db
     */
    public function __construct()
    {

        $this->statistics =  DB::getConnection()->getTeamsStatistics();

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