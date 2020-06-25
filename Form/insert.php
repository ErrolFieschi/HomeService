<?php
require_once __DIR__ . '/../Class/DatabasesManager.php';

$dbManager = new DatabasesManager();

$firstname = secureData($_POST['firstname']);
$lastname = secureData($_POST['lastname']);
$password = hash('sha256', secureData($_POST['password']));
$email = secureData($_POST['email']);
$city = secureData($_POST['city']);
$phone = secureData($_POST['phone']);
$address = secureData($_POST['address']);
$postal_code = secureData($_POST['postal_code']);

function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(!isset($_POST['email'])){
    header('Location: ../register.php?error=email_missing');
    exit;
}

if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    header('Location: ../register.php?error=email_format');
    exit;
}

//vérification que l'email n'est pas déjà utilisé
$mailRequest = $dbManager->getPdo()->prepare(
    'SELECT id, city FROM account WHERE email = ?');

$mailRequest->execute(array($_POST['email']));
$answers = [];
while($user = $mailRequest->fetch()){
    $answers[] = $user;
}
if(count($answers) != 0){
    header('Location: ../register.php?error=email_taken');
    exit;
}

if(!isset($_POST['password'])){
    header('Location: ../register.php?error=password_missing');
    exit;
}

if(strlen($_POST['password']) < 8){
    header('Location: ../register.php?error=password_length');
    exit;
}

if(!isset($_POST['lastname']) || empty($_POST['lastname'])){
    header('Location: ../register.php?error=lastname_missing');
    exit;
}

if(!isset($_POST['firstname']) || empty($_POST['firstname'])){
    header('Location: ../register.php?error=firstname_missing');
    exit;
}

    $dbRequest = $dbManager->getPdo()->prepare(
        'INSERT INTO account (fk_suscription, lastname, firstname, mail, password, phone, address, city, postal_code, status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

$dbRequest->execute([1, $lastname, $firstname, $email, $password, $phone, $address, $city, $postal_code, 1]);

//Pull id from database
$pullId = $dbManager->getPdo()->prepare(
    'SELECT id, firstname, lastname FROM account WHERE mail= ?');

$pullId->execute([$email]);

$results = [];
while($user = $pullId->fetch(PDO::FETCH_ASSOC)){
    $results[] = $user;
}

session_start();
$_SESSION['email'] = $_POST['email'];
$_SESSION['id'] = $results[0]['id'];
$_SESSION['firstname'] = $results[0]['firstname'];
$_SESSION['lastname'] = $results[0]['lastname'];
header('Location: ../index.php?authentication=checked');
exit;