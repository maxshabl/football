<?php
require_once 'vendor/autoload.php';
switch ($_GET['actions']) {
    case 'tournament' :
        $teamsPower = (new Classes\Teams())->getTeamsPower();
        echo json_encode((new Classes\Tournament())->playStages($teamsPower));
        break;
    default:
        include_once (__DIR__.DIRECTORY_SEPARATOR.'source'.DIRECTORY_SEPARATOR.'main.html') ;
}