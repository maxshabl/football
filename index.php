<?php

require_once 'vendor/autoload.php';

$a = new Classes\Test;
$power = new Classes\Power;
$powerget = $power->getTeamsPower();
$turn = new Classes\MakeTournament();
$turn->playStage($powerget);
$a = [];