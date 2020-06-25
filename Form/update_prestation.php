<?php

ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/DatabasesManager.php';

$dbManager = new DatabasesManager();


$pro = $_GET['id'];
$getIdPresta = $_GET['pro'];


$ins = $dbManager->getPdo()->prepare('UPDATE prestation SET fk_provider = ?  WHERE id = ?');
$ins->execute([$pro, $getIdPresta]);

header('Location: ../administration/waiting_line.php');
exit();
