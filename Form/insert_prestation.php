<?php
session_start();
ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/DatabasesManager.php';
$connected = isset($_SESSION['email']) ? true : false;
if (!$connected) {
    header('Location: login.php');
    exit;
}

function idClient()
{
    $dbManager = new DatabasesManager();
    $reqId = $dbManager->getPdo()->prepare("SELECT id FROM account WHERE mail = ?");
    $reqId->execute([$_SESSION['email']]);
    return $reqId;
}

$date = new DateTime('now');
$date->add(new DateInterval('PT2H'));
$dbManager = new DatabasesManager();


$service = secureData($_POST['show']);

echo $service . "<br>";

$req = $dbManager->getPdo()->prepare("SELECT id,info FROM service WHERE name = ?");
$req->execute([$service]);
$resultat = $req->fetch(PDO::FETCH_ASSOC);

$check_status_service = $resultat['info'];

if($check_status_service == 2){
    header('Location: ../prestation.php?error=serviceError');
    exit();
}

$serv = $resultat['id'];

$s_date = secureData($_POST['Sdate']);
$Edate = secureData($_POST['Edate']);

$Stime = secureData($_POST['Stime']);
$Etime = secureData($_POST['Etime']);
$ref = 1;

$description = secureData($_POST['description']);
$fk_account = $_SESSION['id'];
$fk_provider = 1;

$dateS = $s_date . " " . $Stime . ":00";
$dateE = $Edate . " " . $Etime . ":00";

// faire calcule entre s time et e time x le nombre de jours * pris de la presta

echo "test du service : " . $serv;

function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(!empty($_POST['Sdate']) && !empty($_POST['Edate']) && !empty($_POST['Stime']) && !empty($_POST['Etime'])) {

    if (strtotime($dateS) < strtotime($dateE)) {
        if (strtotime($date->format('Y-m-d H:i:s')) < strtotime($dateS)) {
            $dbRequest = $dbManager->getPdo()->prepare(
                'INSERT INTO prestation (fk_account,fk_provider, fk_service, description, s_date, end_date, start_time, end_time, refund) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

            $dbRequest->execute([$fk_account, $fk_provider, $serv, $description, $s_date, $Edate, $Stime, $Etime, $ref]);
            header('Location: ../index.php');
            exit();

        } else {
            header('Location: ../prestation.php?error=dateNow');
            exit();
        }
    } else {
        header('Location: ../prestation.php?error=endDate');
        exit();
    }
} else{
    header('Location: ../prestation.php?error=emptyValue');
    exit();
}




//if ($Enow > $Snow) { CODE pour verifier si l'heure est inferieur a l'heure de fin
//$Stime_int = str_replace(":", "", $Stime);
//$Snow = intval(((($Stime_int / 100) % 100) * 60) + $Stime_int % 100);
//$Etime_int = str_replace(":", "", $Etime);
//$Enow = intval(((($Etime_int / 100) % 100) * 60) + $Etime_int % 100);


