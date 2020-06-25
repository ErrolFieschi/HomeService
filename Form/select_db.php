<?php
require_once __DIR__ . '/../Class/DatabasesManager.php';
require_once __DIR__ . '/../pdo.env';


function reqService()
{
    $id = $_GET['id'];
    $dbManager = new DatabasesManager();
    $reqServ = $dbManager->getPdo()->prepare("SELECT * FROM service WHERE id = ?");
    $reqServ->execute([$id]);
    return $reqServ;
}

function cmpServ($a)
{
    $dbManager = new DatabasesManager();
    $reqServ = $dbManager->getPdo()->prepare("SELECT name FROM service WHERE id = ?");
    $reqServ->execute([$a]);
    $resultServ = $reqServ->fetch(PDO::FETCH_ASSOC);
    echo $resultServ['name'];
}

function cmpAccount($a)
{
    $dbManager = new DatabasesManager();
    $reqServ = $dbManager->getPdo()->prepare("SELECT lastname,firstname FROM account WHERE id = ?");
    $reqServ->execute([$a]);
    $resultServ = $reqServ->fetch(PDO::FETCH_ASSOC);
    echo $resultServ['lastname'] . " " . $resultServ['firstname'];
}


function reqPaginationHistorique($MAX)
{
    $dbManager = new DatabasesManager();
    $totalReq = $dbManager->getPdo()->prepare('SELECT * FROM prestation WHERE fk_provider <> 1 OR s_date < NOW() ');
    $totalReq->execute();
    $totalRow = $totalReq->rowCount();
    $pagesTotal = ceil($totalRow / $MAX);
    return $pagesTotal;
}

function reqInfosHistorique($MAX,$pagesCourante)
{
    $dbManager = new DatabasesManager();
    $depart = ($pagesCourante - 1) * $MAX;
    $infos = $dbManager->getPdo()->prepare('SELECT * FROM prestation WHERE fk_provider <> 1 OR s_date < NOW() LIMIT ' . $depart . ',' . $MAX);
    $infos->execute();
    return $infos;
}

function reqPaginationWaitingLine($MAX){
    $dbManager = new DatabasesManager();
    $req = $dbManager->getPdo()->prepare("SELECT * FROM prestation WHERE fk_provider = 1 AND s_date > NOW()");
    $req->execute();
    $totalRow = $req->rowCount();
    $pagesTotal = ceil($totalRow / $MAX);
    return $pagesTotal;

}
function reqInfosWaitingLine($MAX,$pagesCourante)
{
    $dbManager = new DatabasesManager();
    $depart = ($pagesCourante - 1) * $MAX;
    $infos = $dbManager->getPdo()->prepare('SELECT * FROM prestation WHERE fk_provider = 1 AND s_date > NOW() LIMIT ' . $depart . ',' . $MAX);
    $infos->execute();
    return $infos;
}

function searchPresta($a){
    $dbManager = new DatabasesManager();
    $searchPresta = $dbManager->getPdo()->prepare("SELECT * FROM prestation WHERE id = ?");
    $searchPresta->execute([$a]);
    return $searchPresta;
}

function searchProvider($a){
    $dbManager = new DatabasesManager();
    $searchPro= $dbManager->getPdo()->prepare("SELECT * FROM provider WHERE fk_job = ?");
    $searchPro->execute([$a]);
    return $searchPro;
}

function selectPro($a, $b, $job){ // select en fonction de si le presta est dispo ou non
    $dbManager = new DatabasesManager();
    $selectPro = $dbManager->getPdo()->prepare("SELECT DISTINCT fk_provider, fk_service FROM prestation WHERE DATE_ADD(CAST(s_date as datetime), INTERVAL start_time HOUR_SECOND)  NOT BETWEEN ? AND ?
                                                AND DATE_ADD(CAST(end_date as datetime), INTERVAL end_time HOUR_SECOND)  NOT BETWEEN ? AND ? AND (NOT DATE_ADD(CAST(s_date as datetime), INTERVAL start_time HOUR_SECOND)  < ? OR NOT DATE_ADD(CAST(end_date as datetime), INTERVAL end_time HOUR_SECOND)  > ?)
                                                AND fk_provider NOT IN (SELECT fk_provider FROM prestation WHERE DATE_ADD(CAST(s_date as datetime), INTERVAL start_time HOUR_SECOND)  BETWEEN ? AND ?
                                                OR DATE_ADD(CAST(end_date as datetime), INTERVAL end_time HOUR_SECOND)  BETWEEN ? AND ?
                                                OR (DATE_ADD(CAST(s_date as datetime), INTERVAL start_time HOUR_SECOND)  < ? AND DATE_ADD(CAST(end_date as datetime), INTERVAL end_time HOUR_SECOND)  > ?))
                                                AND fk_service = ?");
    $selectPro->execute([$a, $b, $a, $b, $a, $b,$a, $b,$a, $b,$a, $b, $job]);
    return $selectPro;

}

function selectProJob($a, $b){
    $dbManager = new DatabasesManager();
    $findPro = $dbManager->getPdo()->prepare("SELECT * FROM provider WHERE id = ? AND fk_job = ?");
    $findPro->execute([$a, $b]);
    return $findPro;
}

function proto($a, $b){ // select en fonction de si le presta est dispo ou non
    $dbManager = new DatabasesManager();
    $selectPro = $dbManager->getPdo()->prepare("SELECT * FROM prestation INNER JOIN provider ON provider.id = prestation.fk_provider  WHERE s_date NOT BETWEEN ? AND ? AND end_date NOT BETWEEN ? AND ? AND (NOT s_date < ? OR NOT end_date > ?)");
    $selectPro->execute([$a, $b, $a, $b, $a, $b]);
    return $selectPro;
}


function convertTime($time, $format = '%02d:%02d'){
    if ($time < 1) {return;}
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function service()
{
    $dbManager = new DatabasesManager();
    $reqServ = $dbManager->getPdo()->prepare("SELECT * FROM service WHERE id <> 1");
    $reqServ->execute();
    return $reqServ;
}

function servicePresta()
{
    $dbManager = new DatabasesManager();
    $serPre = $dbManager->getPdo()->prepare("SELECT * FROM service WHERE info  <> 2");
    $serPre->execute();
    return $serPre;
}

function providerAddJob()
{
    $dbManager = new DatabasesManager();
    $proNjob = $dbManager->getPdo()->prepare("SELECT * FROM provider WHERE fk_job = 1 AND id <> 1");
    $proNjob->execute();
    return $proNjob;
}

function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}







