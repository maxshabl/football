<?php

namespace Classes;


/**
 * Класс для генерации турнира
*/
class Tournament
{
    /**
     * Участники турнирной стадии
     * @var array
     */
    public $teams;


    /**
     * Итоги стадий турнира
     * @var array
     */
    public $results;


    /**
     * Метод проводит игру, учитывая силу команд. Если рандом выберет число больше силы первой команды, вторая выиграла.
     * Диапазон рандома - сумма сил двух команд. Чем больше сила команды, тем больше вероятность победить
     * @var array $couple
     * @return array
     */
    public function playGame(array $couple)
    {
        $team1power = round($couple[0]['totalPower']);
        $team2power = round($couple[1]['totalPower']);
        $rand = rand(1, $team1power + $team2power);
        if($team1power < $rand) {
            return $couple[1];
        } else {
            return $couple[0];
        }
    }

    /**
     * Метод проводит турнир, сохраняя результаты в $this->results
     * @var array $couple
     * @return array
     */
    public function playStages($teams)
    {
        shuffle($teams);
        $this->teams = array_chunk($teams, 2);
        $winners = [];
        foreach ($this->teams as $itemCouple) {
            $winners[] = [
                'couple' => $itemCouple,
                'winner' => $this->playGame($itemCouple)
            ];
        }
        $this->teams = $winners;
        $this->results[] = $winners;
        if(count($this->teams)>1) {
            $this->playStages($this->teams);
        }
        return $this->results;
    }

}