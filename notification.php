<?php
session_start();
require_once 'Class/DatabasesManager.php';
require_once 'pdo.env';
$dbManager = new DatabasesManager();

if($_GET['param'] == "update") {

    $subRequest = $dbManager->getPdo()->prepare(
        'UPDATE prestation SET see = 1 WHERE fk_account = 13');
    $subRequest->execute();

}elseif ($_GET['param'] == "count"){

    $updateRequest = $dbManager->getPdo()->prepare(
        'SELECT id, fk_service FROM prestation WHERE fk_account = ? AND see != 1');
    $updateRequest->execute(array($_SESSION['id']));

    $answers = [];

    while($user = $updateRequest->fetch()){
        $answers[] = $user;
    }

    if (count($answers) != 0){
        echo '<span class="badge badge-default"><b>' . count($answers) . '</b></span>' ;
    }
}
