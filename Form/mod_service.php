<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/DatabasesManager.php';
require_once __DIR__ . '/../pdo.env';

$sup = $_GET['sup'];

if ($sup == 0) {

    $dbManager = new DatabasesManager();
    $a = secureData($_POST['name']);
    $b = secureData($_POST['description']);
    $c = $_GET['id'];
    $d = secureData($_POST['price']);

    if (empty($_POST['name']) || empty($_POST['price']) || $_POST['price'] < 5) {
        header('Location: ../show_service.php?status=erreur');
        exit();
    } else {

        function reqService($a)
        {
            $dbManager = new DatabasesManager();
            $reqServ = $dbManager->getPdo()->prepare("SELECT * FROM service WHERE id = ?");
            $reqServ->execute([$a]);
            return $reqServ;
        }


        function upService($a, $b, $c)
        {
            $dbManager = new DatabasesManager();
            $upServ = $dbManager->getPdo()->prepare("UPDATE service SET name = ?, description = ?, price = ? WHERE id = ?");
            $upServ->execute([$a, $b,$_POST['price'] , $c]); // ne veut pas prendre en compte $d
            return $upServ;
        }

        function upJob($a, $c)
        {
            $dbManager = new DatabasesManager();
            $upJob = $dbManager->getPdo()->prepare("UPDATE job SET name = ? WHERE id = ?");
            $upJob->execute([$a, $c]);
            return $upJob;

        }

        upService($a, $b, $c);
        upJob($a, $c);
        header('Location: ../administration/show_service.php?status=success');
        exit();

    }
}

if ($sup == 1) {
    $c = $_GET['id'];
    function desServ($c)
    {
        $dbManager = new DatabasesManager();
        $desaServ = $dbManager->getPdo()->prepare("UPDATE service SET info = 2 WHERE id = ?");
        $desaServ->execute([$c]);
        return $desaServ;
    }

    desServ($c);
    header('Location: ../administration/show_service.php?status=success');
    exit();

}

if ($sup == 2) {
    $c = $_GET['id'];
    function actServ($c)
    {
        $dbManager = new DatabasesManager();
        $actServ = $dbManager->getPdo()->prepare("UPDATE service SET info = 1 WHERE id = ?");
        $actServ->execute([$c]);
        return $actServ;
    }

    actServ($c);
    header('Location: ../administration/show_service.php?status=success');
    exit();

}

function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



