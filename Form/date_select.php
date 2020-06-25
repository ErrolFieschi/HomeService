<?php
require_once __DIR__ . '/../Class/DatabasesManager.php';
require_once __DIR__ . '/../pdo.env';


function datePretationSelect()
{
    $dbManager = new DatabasesManager();
    $dateSearch = secureData($_POST['searchDate']);
    $tmp = date("Y-m-d", strtotime($dateSearch));
    $fromDate = $dbManager->getPdo()->prepare("SELECT * FROM prestation WHERE s_date = ? AND fk_provider = 1");
    $fromDate->execute([$tmp]);
    return $fromDate;
}

function nameService(){
    $dbManager = new DatabasesManager();
    $nameSearch = secureData($_POST['nameSearch']);
    $nameServ = $dbManager->getPdo()->prepare('SELECT * FROM service WHERE name LIKE "%' . $nameSearch . '%" ');
    $nameServ->execute([$nameSearch]);
    return $nameServ;
}
