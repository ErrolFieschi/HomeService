<?php
session_start();
require_once '../pdo.env';
require_once "../Class/DatabasesManager.php";

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: ../login.php');
    exit;
}


//RECUPERATION DES VARIABLE POST + TRAITEMENT DES DONNEES DE LA PRESTATION
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


$remaingHour = intval($subInfo['remainingHour']);

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
$currency = "eur";
$maxHour = "24:00:00";

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

            $datetime1 = new DateTime($s_date);
            $datetime2 = new DateTime($Edate);

            $interval = $datetime1->diff($datetime2);
            $tmp = $interval->format('%a');

            if (strtotime($Stime) < strtotime($Etime)) {
                $difference = round(abs(strtotime($dateS) - strtotime($dateE)) / 3600, 2);
                $finalHour = $difference - 24 * $tmp;
                $finalprice = intval($finalHour) * $resultat['price'];

                $description = $_POST['show'];
                $price = $finalprice;
                $rate = intval($resultat['price']); //Tarif à l'heure
                $stripeAmount = round($finalprice*100, 2);
                $hourService = intval($finalHour);
            } else if ($tmp > 0) {

                $testing = round(abs(strtotime($dateS) - strtotime($dateE)) / 3600, 2);
                $finalHour = $testing - 24 * ($tmp - 1);
                $finalprice = ($finalHour * $resultat['price']) * $tmp;

                $description = $_POST['show'];
                $price = $finalprice;
                $rate = intval($resultat['price']); //Tarif à l'heure
                $stripeAmount = round($finalprice*100, 2);
                $hourService = intval($finalHour);

            } else {
                //echo "1 jour";
                $testing = round(abs(strtotime($dateS) - strtotime($dateE)) / 3600, 2);
                $finalHour = $testing - 24 * ($tmp - 1);
                $finalprice = ($finalHour * $resultat['price']) * $tmp;

                $description = $_POST['show'];
                $price = $finalprice;
                $rate = intval($resultat['price']); //Tarif à l'heure
                $stripeAmount = round($finalprice*100, 2);
                $hourService = intval($finalHour);
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

                $description = $_POST['show'];
                $price = $finalprice;
                $rate = intval($resultat['price']); //Tarif à l'heure
                $stripeAmount = round($finalprice*100, 2);
                $hourService = intval($finalHour);
                $newHour =  $newRemainingHour;

            }

        }else{
            header("Location: ../index.php?error=404");
        }
    }else{
        header("Location: ../index.php?error=404");
    }

}else{
    header("Location: ../index.php?error=404");
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flocon Home - Sasse de paiement sécurisé</title>
    <meta name="description" content="Sasse de paiement sécurisé" />

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/global.css" />

    <script src="js/jquery.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>
</head>

<body>
<div class="sr-root" id="paymentDetails">
    <div class="sr-main">
        <header class="sr-header">
            <div class="sr-header__logo"></div>
        </header>
        <div class="sr-payment-summary payment-view">
            <h1 class="order-amount"><?php echo $price . ' €' ?></h1>
            <h4 style="font-style: italic;">Prélevement immédiat</h4>
        </div>
        <div class="sr-payment-form payment-view">

            <div id="buynow">
                <button class="stripe-button" id="payButton">Confirmer mon achat</button>
                <input type="hidden" id="payProcess" value="0"/>
            </div>
            <div class="sr-legal-text">
                Vous êtes sur le point de souscrire à une prestation pour le service de <?php echo $description ?> comprenant <?php echo $hourService ?> heures de service.</b>. Votre carte sera débité de <b><?php echo $price . '€' ?></b>
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

<!-- success part show -->

<div id="description">
    <div class="sr-root">
        <div class="sr-main">
            <header class="sr-header">
                <div class="sr-header__logo"></div>
            </header>
            <div class="sr-payment-summary completed-view" >
                <h1>Paiement réussi!</h1>
                <h4>
                    Détails d'achat:</a>
                </h4>
            </div>
            <div class="sr-section completed-view">
                <div class="sr-callout">
            <pre>
                N° de commande: <span id="orderID">&#x3C;ORDER_ID&#x3E;</span><br>
                N° de transaction: <span id="txnID">&#x3C;TX_ID&#x3E;</span><br>
                Montant: <span id="pamount">&#x3C;PAID_AMOUNT&#x3E;</span><br>
                Type d'abonnement: <span></span><br>
            </pre>
                </div>
            </div>
            <button onclick="window.location.href = '../index.php';">Retour à l'accueil</button>
        </div>
        <div class="sr-content">
            <div class="pasha-image-stack floating" >
                <img src="images/carroussel/1.png" width="140" height="160" class="floating">
                <img src="images/carroussel/2.png" width="140" height="160" class="floating">
                <img src="images/carroussel/3.png" width="140" height="160" class="floating">
                <img src="images/carroussel/3.png" width="140" height="160" class="floating">
            </div>
        </div>
    </div>
</div>

<!-- end of success part -->
<script>
    $('#description').hide();
    var handler = StripeCheckout.configure({
        key: '<?php echo STRIPE_PUBLISHABLE_KEY; ?>',
        image: 'images/flocon.png',
        locale: 'auto',
        token: function(token) {

            $('#payProcess').val(1);
            $.ajax({
                url: 'presta_charge.php',
                type: 'POST',
                data: {stripeToken: token.id, stripeEmail: token.email, stripeAmount: <?php echo $stripeAmount; ?>, price: <?php echo $price; ?>, productName: '<?php echo $description; ?>', rate: <?php echo $rate; ?>, restHour: <?php echo $finalHour; ?>, Stime: '<?php echo $Stime; ?>', Etime: '<?php echo $Etime; ?>', dateE: '<?php echo $dateE; ?>', dateS: '<?php echo $dateS; ?>', description: '<?php echo $description; ?>', ref: <?php echo $ref; ?>, serv: <?php echo intval($serv); ?>, newRemainingHour: <?php echo intval($newRemainingHour); ?>},
                dataType: "json",
                beforeSend: function(){
                    $('body').prepend('<div class="overlay"></div>');
                    $('#payButton').prop('disabled', true);
                    $('#payButton').html('Patienter...');
                },
                success: function(data){
                    $('.overlay').remove();
                    $('#payProcess').val(0);
                    if(data.status == 1){
                        var paidAmount = (data.txnData.amount/100);
                        $('#buynow').hide();
                        $('#txnEmail').html(token.email);
                        $('#orderID').html(data.txnData.id);
                        $('#txnID').html(data.txnData.balance_transaction);
                        $('#pamount').html(paidAmount+' '+data.txnData.currency);
                        $('#paymentDetails').hide();
                        $('#description').show();
                    }else{
                        $('#payButton').prop('disabled', false);
                        $('#payButton').html('Confirmer mon achat');
                        alert('Un problème est survenu, veuillez réessayer.');
                    }
                },
                error: function() {
                    $(location).attr('href',"paymentSucceed.php");
                }
            });
        }
    });

    var stripe_closed = function(){
        var processing = $('#payProcess').val();
        if (processing == 0){
            $('#payButton').prop('disabled', false);
            $('#payButton').html('Confirmer mon achat');
        }
    };

    var eventTggr = document.getElementById('payButton');
    if(eventTggr){
        eventTggr.addEventListener('click', function(e) {
            $('#payButton').prop('disabled', true);
            $('#payButton').html('Patienter...');

            // Open Checkout with further options:
            handler.open({
                name: 'Flocon Home',
                description: '<?php echo $description; ?>',
                amount: <?php echo $stripeAmount; ?>,
                currency: '<?php echo $currency; ?>',
                closed:	stripe_closed
            });
            e.preventDefault();
        });
    }

    // Close Checkout on page navigation:
    window.addEventListener('popstate', function() {
        handler.close();
    });
</script>

</body>
</html>
