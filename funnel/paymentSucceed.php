<?php
session_start();

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: ../login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flocon Home - Paiement réussi</title>
    <meta name="description" content="Unsubscribe" />

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/global.css" />
</head>

<body class="body">
<div class="sr-root" id="paymentDetails">
    <div class="sr-main">
        <header class="sr-header">
            <div class="sr-header__logo"></div>
        </header>
        <div class="sr-payment-summary payment-view">
            <h1 class="order-amount">Paiement accepté</h1>
            <!--            <h4 style="font-style: italic;">par abonnement mensuel</h4>-->
        </div>
        <div class="sr-payment-form payment-view">
            <button onclick="window.location.href='<?php echo ' ../index.php'; ?>'" class="stripe-button unsubButton">Retour au site</button>
            <input type="hidden" id="payProcess" value="0"/>
            <div class="sr-legal-text">
                Votre paiement a bien été pris en compte et nous vous remercions de faire confiance à FloconHome<b></b>
            </div>
        </div>
    </div>
    <div class="sr-content">
        <div class="pasha-image-stack">
            <img src="images/carroussel/1.png" width="140" height="160" class="floating">
            <img src="images/carroussel/2.png" width="140" height="160" class="floating">
            <img src="images/carroussel/3.png" width="140" height="160" class="floating">
            <img src="images/carroussel/3.png" width="140" height="160" class="floating">
        </div>
    </div>
</div>


<!-- end of success part -->

<script>

</script>
</body>
</html>
