<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/DatabasesManager.php';
$dbManager = new DatabasesManager();

$pro = $_GET['id'];
$job = $_POST['service'];

$selJob = $dbManager->getPdo()->prepare('SELECT id FROM service WHERE name = ?');
$selJob->execute([$job]);
$idJob = $selJob->fetch(PDO::FETCH_ASSOC);

$addPro = $dbManager->getPdo()->prepare('UPDATE provider SET fk_job = ? WHERE id = ?');
$addPro->execute([$idJob['id'], $pro]);

$addPre = $dbManager->getPdo()->prepare('INSERT INTO prestation (fk_account,fk_provider, fk_service, description, s_date, end_date, start_time, end_time, status, see, refund) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

$addPre->execute([1, $pro, 1, " ", "2010-05-08", "2010-05-08", "00:00:00", "00:00:00", 1, 1, 1]);

//header('Location: ../administration/ajoutPrestataire.php');
//exit();