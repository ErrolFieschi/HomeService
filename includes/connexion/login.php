<?php
require_once __DIR__ . '/../../Class/DatabasesManager.php';

$dbManager = new DatabasesManager();
$dbDate = new DatabasesManager();
$dbUpdate = new DatabasesManager();
$dbSubscription = new DatabasesManager();

$email = secureData($_POST['email']);
$password = hash('sha256', secureData($_POST['password']));

function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$dbRequest = $dbManager->getPdo()->prepare(
    'SELECT id, firstname, lastname FROM account WHERE mail= ? AND password= ?');

$dbRequest->execute([$email, $password]);

$results = [];
while($user = $dbRequest->fetch(PDO::FETCH_ASSOC)){
	$results[] = $user;
}

if(count($results) == 0){
	header('location: ../../login.php?error=mailorpassword');
	exit;
}else{
    session_start();

    $_SESSION['email'] = $_POST['email'];
    $_SESSION['id'] = $results[0]['id'];
    $_SESSION['firstname'] = $results[0]['firstname'];
    $_SESSION['lastname'] = $results[0]['lastname'];
    $today = date("Y-m-d H:i:s");

    //check subscribe date
    $dbDate = $dbDate->getPdo()->prepare(
        'SELECT * FROM subscribe WHERE fk_account = ? AND status = 1');

    $dbDate->execute([$_SESSION['id']]);
    $rows = $dbDate->fetchAll(PDO::FETCH_ASSOC);
    $rows = $rows[0];
    
        //check subscription hour
        $dbSubscription = $dbSubscription->getPdo()->prepare(
            'SELECT * FROM subscription WHERE id = ?');

        $dbSubscription->execute([$rows['fk_subscription']]);
        $res = $dbSubscription->fetchAll(PDO::FETCH_ASSOC);
        $res = $res[0];
        //end of

        $old = date_create($rows['nextRecurrence'], timezone_open('Europe/Paris'));
        $today = new DateTime(date("Y-m-d H:i:s"));

        $old = $old->getTimestamp();
        $today = $today->getTimestamp();

        if ($today > $old) {
            $dbUpdate = $dbUpdate->getPdo()->prepare(
                'UPDATE subscribe SET nextRecurrence = (? + INTERVAL 30 DAY), remainingHour = ?, status = ? WHERE fk_account = ? AND status = ?');
            if($rows['stop'] == 0) {
                $dbUpdate->execute([$rows['nextRecurrence'], $res['duration'], 1, $_SESSION['id'], 1]);
                header('location: ../../index.php?update_sub=checked');
                exit;
            }elseif($rows['stop'] == 1){
                $dbUpdate->execute([$rows['nextRecurrence'], 0, 0, $_SESSION['id'], 1]);
                header('location: ../../index.php?sub=finish');
                exit;
            }
        }
        //end of check subscribe date

	header('location: ../../index.php?authentication=checked');
	exit;
}