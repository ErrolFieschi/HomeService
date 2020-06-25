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


$service = secureData($_POST['service']);

echo $service . "<br>";

$req = $dbManager->getPdo()->prepare("SELECT id, info, price FROM service WHERE name = ?");
$req->execute([$service]);
$resultat = $req->fetch(PDO::FETCH_ASSOC);

$sub = $dbManager->getPdo()->prepare("SELECT * FROM subscribe WHERE fk_account = ?");
$sub->execute([$_SESSION['id']]);
$subInfo = $sub->fetch(PDO::FETCH_ASSOC);

$aboInfo =  $subInfo['fk_subscription'];
$subAbo = $dbManager->getPdo()->prepare("SELECT * FROM subscription WHERE id = ?");
$subAbo->execute([$aboInfo]);
$subAboInfo = $subAbo->fetch(PDO::FETCH_ASSOC);



echo "Nombre d'heure restante en fonction de l'id : " . $subInfo['remainingHour'] . "<br>";

$remaingHour = $subInfo['remainingHour'];

$check_status_service = $resultat['info'];

if ($check_status_service == 2) {
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

$maxHour = "24:00:00";


echo "Id du service : " . $serv . "<br>";
echo "Sdate : " . $dateS . "<br>";
echo "Edate : " . $dateE . "<br>";
function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


$totalPrice = 0;

if (!empty($_POST['Sdate']) && !empty($_POST['Edate']) && !empty($_POST['Stime']) && !empty($_POST['Etime'])) {

    if (strtotime($dateS) < strtotime($dateE)) {
        if (strtotime($date->format('Y-m-d H:i:s')) < strtotime($dateS)) {


            echo "prix de la prestion à l'heure : " . $resultat['price'] . "<br>";

            $datetime1 = new DateTime($s_date);
            $datetime2 = new DateTime($Edate);

            $interval = $datetime1->diff($datetime2);
            $tmp = $interval->format('%a');

            if (strtotime($Stime) < strtotime($Etime)) {
                //echo "tu es dans le premier IF" . "<br>";
                $difference = round(abs(strtotime($dateS) - strtotime($dateE)) / 3600, 2);
                $finalHour = $difference - 24 * $tmp . "<br>";
                $finalprice = intval($finalHour) * $resultat['price'];
                //echo $finalprice . "€" . "<br>";

                // Si la date dure plus de 1 jour et si le starthour > au endhour
            } else if ($tmp > 0) {


                //echo 'tmp : ' . $tmp . "<br>";
                //echo "plus de 1 jours" . "<br>";
                $testing = round(abs(strtotime($dateS) - strtotime($dateE)) / 3600, 2);
                $finalHour = $testing - 24 * ($tmp - 1);
                $finalprice = ($finalHour * $resultat['price']) * $tmp;
                //echo "temps de prestation : " . $finalHour . "<br>";
                //echo "prix final " . $finalprice . "€" . "<br>";

                // Si la date dure 1 seul jour et si le starthour > au endhour
            } else {
                //echo "1 jour";
                $testing = round(abs(strtotime($dateS) - strtotime($dateE)) / 3600, 2);
                $finalHour = $testing - 24 * ($tmp - 1);
                $finalprice = ($finalHour * $resultat['price']) * $tmp;
                //echo "temps de prestation : " . $finalHour . "<br>";
                //echo "prix final " . $finalprice . "€" . "<br>";

            }

            if(intval($remaingHour) > 0 && $subInfo['status'] == 1 &&strtotime($Stime . ":00") > strtotime($subAboInfo['startHourAccess']) && strtotime($Stime . ":00") < strtotime($subAboInfo['endHourAccess'])
                && strtotime($Etime . ":00") > strtotime($subAboInfo['startHourAccess']) && strtotime($Etime . ":00" ) < strtotime($subAboInfo['endHourAccess'])){

                $newRemainingHour = intval($remaingHour) - intval($finalHour);
                if($newRemainingHour >= 0){
                    $finalprice = 0;
                }else{
                    $finalHour = $finalHour - $remaingHour;
                    $finalprice = $finalHour * $resultat['price'];
                }
                echo $newRemainingHour . "<br>";
            }






            // finalHour = durée de la prestation demandé -> nombre d'heure a retirer
            // finalprice = prix final de la prestation
            // tmp = nombre de jours de la prestation
            // $newRemainingHour = le nouveau nombre d'heure qui lui reste sur son forfait.

        }
    }
}
echo "<br>" . strtotime($Stime . ":00");
echo "<br>" . $subAboInfo['startHourAccess'];

 if(strtotime($Stime . ":00") > strtotime($subAboInfo['startHourAccess']) && strtotime($Stime . ":00") < strtotime($subAboInfo['endHourAccess'])
 && strtotime($Etime . ":00") > strtotime($subAboInfo['startHourAccess']) && strtotime($Etime . ":00" ) < strtotime($subAboInfo['endHourAccess'])
 ){
     echo "ok";
 }

/*
 if(intval($remaingHour) > 0 && $subInfo['status'] == 1 &&
    $Stime . ":00"  > $subInfo['startHourAccess'] &&
    $Stime . ":00" < $subInfo['endHourAccess'] && $Etime . ":00" > $subInfo['startHourAccess'] && $Etime . ":00" < $subInfo['endHourAccess'] ){
    $newRemainingHour = intval($remaingHour) - intval($finalHour);
*/


//if ($Enow > $Snow) { CODE pour verifier si l'heure est inferieur a l'heure de fin
//$Stime_int = str_replace(":", "", $Stime);
//$Snow = intval(((($Stime_int / 100) % 100) * 60) + $Stime_int % 100);
//$Etime_int = str_replace(":", "", $Etime);
//$Enow = intval(((($Etime_int / 100) % 100) * 60) + $Etime_int % 100);


