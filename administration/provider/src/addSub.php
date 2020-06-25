<?php
require_once '../../../Class/DatabasesManager.php';

$dbManager = new DatabasesManager();

$stripe = secureData($_POST['stripe']);
$name = secureData($_POST['name']);
$price = secureData($_POST['price']);
$hour = secureData($_POST['hour']);
$day = secureData($_POST['day']);

function secureData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(!isset($_POST['stripe'])){
    header('Location: ../../register.php?error=stripe_missing');
    exit;
}

if(!isset($_POST['name'])){
    header('Location: ../../register.php?error=name_missing');
    exit;
}

if(!isset($_POST['price'])){
    header('Location: ../../register.php?error=price_missing');
    exit;
}

if(!isset($_POST['hour'])){
    header('Location: ../../register.php?error=hour_missing');
    exit;
}

if(!isset($_POST['day'])){
    header('Location: ../../register.php?error=day_missing');
    exit;
}

$dbRequest = $dbManager->getPdo()->prepare(
    'INSERT INTO subscription (stripePlan, nom, description, price, duration, dayAccess, startHourAccess, endHourAccess, active) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

$dbRequest->execute([$stripe, $name, 'testdesc', $price, $hour, $day, '09:00:00', '20:00:00', 0]);


header('Location: ../../subscription.php?add=ok');
exit;