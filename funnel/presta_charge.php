<?php
session_start();
require_once '../pdo.env';
require_once __DIR__ . "../../Class/DatabasesManager.php";

$response = array();
$productName = $_POST["productName"];

if($productPrice == 0){
    $productPrice = 1;
}else{
    $productPrice = $_POST['price'];
}

$currency = "eur";
$stripeAmount = round($productPrice*100, 2);
$rate = $_POST['rate'];
$negHour = $_POST['restHour'];
$fk_account = $_SESSION['id'];

$Stime = $_POST['Stime'];
$Etime = $_POST['Etime'];
$dateS = $_POST['dateS'];
$dateE = $_POST['dateE'];
$description = $_POST['description'];
$ref = $_POST['ref'];
$serv = $_POST['serv'];
$newHour = $_POST['newRemainingHour'];
$test = 1;

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
    $charge = \Stripe\Charge::create(array(
        'customer' => $customer->id,
        'amount'   => $stripeAmount,
        'currency' => $currency,
        'description' => $productName,
    ));

    // Retrieve charge details
    $chargeJson = $charge->jsonSerialize();

    // Check whether the charge is successful
    if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){

        // Order details
        $txnID = $chargeJson['balance_transaction'];
        $paidAmount = ($chargeJson['amount']);
        $paidCurrency = $chargeJson['currency'];
        $status = $chargeJson['status'];
        $orderID = $chargeJson['id'];
        $payerName = $chargeJson['source']['name'];

        // Include database connection file
        require_once "../Class/DatabasesManager.php";

        //Ajout de l'orders pour l'historique STRIPE API
        $dbRequest = new DatabasesManager();
        $data = $dbRequest->getPdo()->prepare("INSERT INTO orders(fk_account, mailAccount, paymentMail, item_name, item_price, item_price_currency, paid_amount, paid_amount_currency, txn_id, payment_status, created, modified) VALUES(12, '$payerName', '$email', '$productName', '$productPrice', '$paidCurrency', '$paidAmount', '$paidCurrency', '$txnID', '$status', NOW(), NOW())");
        $data->execute();
        $last_insert_id = $dbRequest->getPdo()->lastInsertId();

        //Ajout de la prestation
        $dbMan = new DatabasesManager();
        $dbRequest = $dbMan->getPdo()->prepare(
            'INSERT INTO prestation (fk_account,fk_provider, fk_service, description, s_date, end_date, start_time, end_time, status, see, refund)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $dbRequest->execute([$fk_account, 1, $serv, $description, $dateS, $dateE, $Stime, $Etime, 1, 0, 1]);

        //MAJ des heures
        $dbMn = new DatabasesManager();
        $upSub = $dbMn->getPdo()->prepare("UPDATE subscribe SET remainingHour = ? WHERE fk_account = ?");
        $upSub->execute([$newHour, $_SESSION['id']]);

        //RECUP DE l'id fk_prestaion
        $req = $dbManager->getPdo()->prepare("SELECT id, fk_provider, fk_service FROM prestation WHERE fk_account = ? AND see = ?");
        $req->execute([$_SESSION['id'], 0]);
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        //MAJ des heures
        $Manager = new DatabasesManager();
        $Sub= $Manager->getPdo()->prepare("INSERT INTO bills (fk_prestation, bill_date, description, hour, rate, cost)
                   VALUES (?, DATE(), ?, ?, ?, ?)");
        $Sub->execute([$resultat['id'], $description, $negHour, $rate, $productPrice]);


        // If order inserted successfully
        if($last_insert_id && $status == 'succeeded'){
            $response = array(
                'status' => 1,
                'msg' => 'Your Payment has been Successful!',
                'txnData' => $chargeJson
            );
        }else{
            $response = array(
                'status' => 0,
                'msg' => 'Transaction has been failed.'
            );
        }
    }else{
        $response = array(
            'status' => 0,
            'msg' => 'Transaction has been failed.'
        );
    }
}else{
    $response = array(
        'status' => 0,
        'msg' => 'Form submission error...'
    );
}

// Return response
echo json_encode($response);

