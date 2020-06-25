<?php
session_start();
require_once __DIR__ . "/Class/DatabasesManager.php";

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: login.php');
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
    header('Location: index.php');
    exit;
}

//active subscription
$dbRequest = new DatabasesManager();
$dbRequest = $dbRequest->getPdo()->prepare('SELECT * FROM subscription WHERE active = 1');
$dbRequest->execute();
?>

<!DOCTYPE html>
<html style="overflow-x :hidden ;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="flocon, générateur de repas, course, aliment, nourriture, planning de course, liste de course">
    <meta name="description" content="Flocon a été développé pour optimiser l'organisation de vos repas au quotidien. Indiquez vos préférences culinaires et il s'occupera du reste !">
    <meta name="author" content="Flocon">
    <title>FloconHome - Un concierge à votre service 24H sur 24 !</title>
    <!-- Favicon -->
    <link href="assets/img/brand/favicon.ico" rel="icon" type="image/ico">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2586f30b2f.js"></script>
    <!-- Flocon CSS -->
    <link type="text/css" href="assets/css/flocon.css?v=1.1.0" rel="stylesheet">
</head>

<body>
<!-- HEADER -->
<?php include('includes/mep/header.php'); ?>
<!-- ------ -->
<main>
    <div class="position-relative">
        <!-- shape Hero -->
        <section class="section section-lg section-shaped pb-250">
            <div class="<?php if($connected) echo 'shape section-connected'; else echo 'shape shape-style-1 shape-default';?>">
                <img alt="IMGCLEANER" src="assets/img/icons/cleaner.png" class="ico-1">

                <img alt="IMGCOACH" src="assets/img/icons/coach.png" class="ico-2">

                <img alt="IMGTRUCK" src="assets/img/icons/delivery-truck.png" class="ico-3">

                <img alt="IMGFARMER" src="assets/img/icons/farmer.png" class="ico-4">

                <img alt="IMGHAIR" src="assets/img/icons/hair.png" class="ico-5">

                <img alt="IMGMECHANIC" src="assets/img/icons/mechanic.png" class="ico-6">

                <img alt="IMGBRUSH" src="assets/img/icons/paint-brush.png" class="ico-7">

                <img alt="IMGWASH" src="assets/img/icons/wash.png" class="ico-8">

                <img alt="IMGRENT" src="assets/img/icons/rent.png" class="ico-9">
            </div>
            <!-- SEPARATEUR SVG -->
            <div class="separator separator-bottom separator-skew">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </section>
        <!-- 3 BANNER -->
    </div>
    <section class="section section-lg pt-lg-0 mt--200" style="margin-top: -120px !important;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row row-grid">
                        <?php
                        $rows = $dbRequest->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($rows as $row) {
                            ?>

                            <div class="col-lg-4">
                                <div class="card card-lift--hover shadow border-0" style="box-shadow: -1px 1px 10px 3px rgba(0, 0, 0, 0.12); border-radius: 8px;">
                                    <div class="card-body py-5">
                                        <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                            <i class="fas fa-snowflake"></i>
                                        </div>
                                        <h4 class="text-primary text-uppercase"><?php echo $row['nom']; ?></h4>
                                        <p class="description mt-3"><?php echo _("Accès privilégié "); ?>
                                            <b><?php echo $row['dayAccess'] . _("j/7 de ") . substr($row['startHourAccess'], -8, 5) . _(" à ") . substr($row['endHourAccess'], -8, 5); ?></b><br><?php echo _("Demandes "); ?>
                                            <b><?php echo _("illimitées"); ?></b><?php echo _(" de renseignements"); ?>
                                            <br><b><?php echo $row['duration']; ?></b><?php echo _("h de services/mois"); ?>
                                        </p>
                                        <div>
                                            <span
                                                class="badge badge-pill badge-primary"><?php echo $row['price'] . _("€ TTC /mois"); ?></span>
                                        </div>
                                        <a href="funnel/index.php?subscription=<?php echo $row['id']; ?>"
                                           class="btn btn-primary mt-4"><?php echo _("Souscrire"); ?></a>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
        <!-- SEPARATEUR SVG -->
        <div class="separator separator-bottom separator-skew">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
</main>
<!-- FOOTER -->
<?php include('includes/mep/footer.php'); ?>
</body>
</html>
