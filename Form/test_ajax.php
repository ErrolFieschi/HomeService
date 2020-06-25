<?php
require_once __DIR__ . '/../Class/DatabasesManager.php';
require_once __DIR__ . '/../pdo.env';


$dbManager = new DatabasesManager();
$s = $_REQUEST['s'];
$req = $dbManager->getPdo()->prepare('SELECT * FROM service WHERE name LIKE "'.$s.'%"');

$req->execute([$s]);

if (!empty($s)) {
    while($check = $req->fetch()){ ?>
            <p><?= $check['name']; ?><p>


    <?php
}}
