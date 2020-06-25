<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/DatabasesManager.php';

$dbManager = new DatabasesManager();

$name = secureData($_POST['name']);
$description = secureData($_POST['description']);
$price = secureData($_POST['price']);


function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (empty($_POST['name']) || empty($_POST['price']) || $_POST['price'] < 5 ) {
   header('Location: ../administration/show_service.php?status=erreur');
    exit();
} else {

    $reqIdMax = $dbManager->getPdo()->prepare('SELECT MAX(id) FROM service');
    $reqIdMax->execute();
    $res = $reqIdMax->fetch(PDO::FETCH_ASSOC);
    $res['MAX(id)'];
    $tmp = $res['MAX(id)'] + 1;

    $insService = $dbManager->getPdo()->prepare('INSERT INTO service (name, description, info, price) VALUES (?, ?, 1, ?)');
    $insService->execute([$name, $description, $price]);

    $insJob = $dbManager->getPdo()->prepare('INSERT INTO job (name,id) VALUES (?, ?)');
    $insJob->execute([$name, $tmp]);

    header('Location: ../administration/show_service.php?status=success');
    exit();
}
