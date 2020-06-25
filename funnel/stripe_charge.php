<?php
session_start();
require_once __DIR__ . "../../Class/DatabasesManager.php";
require_once '../pdo.env';

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: ../login.php');
    exit;
}

$subRequest = new DatabasesManager();
$subRequest = $subRequest->getPdo()->prepare(
    'SELECT id, status FROM subscribe WHERE fk_account = ? AND status = 1');

$subRequest->execute(array($_SESSION['id']));
$answers = [];
while ($user = $subRequest->fetch()) {
    $answers[] = $user;
}
if (count($answers) != 0) {
    header('Location: ../index.php');
    exit;
}

$response = array();
$productName = $_POST['product'];
$productPrice = $_POST['productPrice'];
$stripeAmount = $_POST['stripeAmount'];
$duration = $_POST['duration'];
$fk_account = $_POST['fk_account'];
$fk_subscription = $_POST['fk_subscription'];
$stripePlan = $_POST['plan'];

// Check whether stripe token is not empty
if(!empty($_POST['stripeToken'])){

    // Get token and buyer info
    $token  = $_POST['stripeToken'];
    $email  = $_POST['stripeEmail'];

    require_once 'stripe-php/init.php';

    \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

    // Add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => $email,
        'source'  => $token
    ));

    // Charge a credit or a debit card
    $charge = \Stripe\Subscription::create(array(
        'customer' => $customer->id,
        'items' => [[
            'plan' => $stripePlan
        ]],
    ));



    // Retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    // REVOIR LES charJson
    if($chargeJson['status'] == 'active'){

        // REVOIR LES charJson
        $txnID = $chargeJson['id'];
        $paidAmount = $chargeJson['plan']['amount'];
        $paidCurrency = $chargeJson['plan']['currency'];
        $status = $chargeJson['status'];
        $orderID = $chargeJson['id'];
        $payerName = 'User';

        // Include database connection file
        require_once "../Class/DatabasesManager.php";

        $dbRequest = new DatabasesManager();
        $data = $dbRequest->getPdo()->prepare("INSERT INTO orders(fk_account, mailAccount, paymentMail, item_name, item_price, item_price_currency, paid_amount, paid_amount_currency, txn_id, payment_status, created, modified) VALUES(12, '$payerName', '$email', '$productName', '$productPrice', '$paidCurrency', '$paidAmount', '$paidCurrency', '$txnID', '$status', NOW(), NOW())");
        $data->execute();
        $last_insert_id = $dbRequest->getPdo()->lastInsertId();

        $dbSubscribe = new DatabasesManager();
        $sub = $dbSubscribe->getPdo()->prepare("INSERT INTO subscribe(stripeSub, fk_account, fk_subscription, remainingHour, created, nextRecurrence, status, stop) VALUES('$txnID' ,$fk_account, $fk_subscription, $duration, NOW(), (NOW() + INTERVAL 30 DAY), 1, 0)");
        $sub->execute();

        // If order inserted successfully
        if($last_insert_id && $status == 'active'){
            $response = array(
                'status' => 1,
                'msg' => 'Votre paiement a réussi!',
                'txnData' => $chargeJson
            );
        }else{
            $response = array(
                'status' => 0,
                'msg' => 'La transaction a échoué.'
            );
        }
    }else{
        $response = array(
            'status' => 0,
            'msg' => 'La transaction a échoué.'
        );
    }
}else{
    $response = array(
        'status' => 0,
        'msg' => 'Erreur de soumission du formulaire...'
    );
}

// Return response
echo json_encode($response);