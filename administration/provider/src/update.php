<?php
session_start();
require_once '../../../Class/DatabasesManager.php';
require_once '../../../pdo.env';
$dbManager = new DatabasesManager();

if($_POST['status'] == "unactive") {

    $subRequest = $dbManager->getPdo()->prepare(
        'UPDATE subscription SET active = 0 WHERE id = ?');
    $subRequest->execute([$_POST['id']]);
    $response = 'success';
    echo $response;
}

if($_POST['status'] == "form") {
    $response = 'form';
    echo $response;
}

if($_POST['status'] == "active") {
    $count = new DatabasesManager();
    $count = $count->getPdo()->prepare('SELECT COUNT(id) FROM subscription WHERE active = 1');
    $count->execute();
    $counter = (int)$count->fetch(PDO::FETCH_NUM)[0];

    if($counter > 2){
        $response = 'error';
        echo $response;
    }else{
        $response = 'success';
        $subRequest = $dbManager->getPdo()->prepare(
            'UPDATE subscription SET active = 1 WHERE id = ?');
        $subRequest->execute([$_POST['id']]);

        echo $response;
    }
}

