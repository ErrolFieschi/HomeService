<?php
session_start();
require_once "../Class/DatabasesManager.php";
require_once 'stripe-php/init.php';

$data = new DatabasesManager();
$delete = new DatabasesManager();

$data = $data->getPdo()->prepare(
    'SELECT * FROM subscribe WHERE fk_account = ? AND status = 1');

$data->execute(array($_SESSION['id']));
$rows = $data->fetchAll(PDO::FETCH_ASSOC);
$rows = $rows[0];
$sub = $rows['stripeSub'];

\Stripe\Stripe::setApiKey('sk_test_KK2690BtVyltuPZ1nO8nvPrf');

$subscription = \Stripe\Subscription::retrieve($sub);
$subscription->delete();

$delete = $delete->getPdo()->prepare(
    'UPDATE subscribe SET stop = 1 WHERE fk_account = ? AND status = 1');

$delete->execute(array($_SESSION['id']));



header('Location: ../index.php');