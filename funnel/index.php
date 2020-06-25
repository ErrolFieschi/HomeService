<?php
session_start();
require_once '../pdo.env';
require_once __DIR__ . "../../Class/DatabasesManager.php";

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: ../login.php');
    exit;
}

$dbRequest = new DatabasesManager();
$dbRequest = $dbRequest->getPdo()->prepare('SELECT * FROM subscription WHERE id = ?');
$dbRequest->execute([$_GET['subscription']]);
$rows = $dbRequest->fetchAll(PDO::FETCH_ASSOC);
$rows = $rows[0];

$stripeAmount = round($rows['price']*100, 2);
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
            <h1 class="order-amount"><?php echo $rows['price'] . ' €' ?></h1>
            <h4 style="font-style: italic;">par abonnement mensuel</h4>
        </div>
        <div class="sr-payment-form payment-view">

            <div id="buynow">
                <button class="stripe-button" id="payButton">Confirmer mon achat</button>
                <input type="hidden" id="payProcess" value="0"/>
            </div>
            <div class="sr-legal-text">
                Vous êtes sur le point de souscrire à un abonnement <b><?php echo $rows['nom']; ?></b>. Votre carte sera débité de <b><?php echo $rows['price'] . '€ tous les mois' ?></b>
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
                N° de commande: <span id="orderID">&#x3C;ORDER_ID&#x3E;</span><br/>
                N° de transaction: <span id="txnID">&#x3C;TX_ID&#x3E;</span><br/>
                Montant: <span id="pamount">&#x3C;PAID_AMOUNT&#x3E;</span><br/>
                Type d'abonnement: <span><?php echo 'Abonnement ' . $rows['nom']; ?></span><br/>
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
                    url: 'stripe_charge.php',
                    type: 'POST',
                    data: {stripeToken: token.id, stripeEmail: token.email, product: '<?php echo $rows['nom']; ?>', stripeAmount: <?php echo $stripeAmount; ?>, productPrice: <?php echo $rows['price']; ?>, duration: <?php echo $rows['duration']; ?>, fk_account: <?php echo $_SESSION['id']; ?>, fk_subscription: <?php echo $_GET['subscription']; ?>, plan: '<?php echo $rows['stripePlan']; ?>'},
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
                            var paidAmount = (data.txnData.plan.amount/100);
                            $('#buynow').hide();
                            $('#txnEmail').html(token.email);
                            $('#orderID').html(data.txnData.id);
                            $('#txnID').html(data.txnData.id);
                            $('#pamount').html(paidAmount+' '+data.txnData.plan.currency);
                            $('#paymentDetails').hide();
                            $('#description').show();
                        }else{
                            $('#payButton').prop('disabled', false);
                            $('#payButton').html('Confirmer mon achat');
                            alert('Un problème est survenu, veuillez réessayer.');
                        }
                    },
                    error: function() {
                        $('#payProcess').val(0);
                        $('#payButton').prop('disabled', false);
                        $('#payButton').html('Confirmer mon achat');
                        alert('Un problème est survenu, veuillez réessayer.');
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
                    description: '<?php echo $rows['nom']; ?>',
                    amount: '<?php echo $stripeAmount; ?>',
                    currency: 'eur',
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
