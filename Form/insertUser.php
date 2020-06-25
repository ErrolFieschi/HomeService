<?php

require_once __DIR__ . '/../Class/DatabasesManager.php';

$dbManager = new DatabasesManager();

$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$password = $_POST['password'];
$email = $_POST['email'];
$city = $_POST['city'];

$stnt = $dbManager->getPdo()->prepare('INSERT INTO users VALUES (NULL, ?, ?, ?, ?, ?)');

$stnt->execute([$firstName, $lastName, $password, $email, $city]);

header('Location: inscription.php');
exit();