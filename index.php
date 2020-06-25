<?php
session_start();
require_once 'Class/DatabasesManager.php';

$connected = isset($_SESSION['email']) ? true : false;
$dbManager = new DatabasesManager();
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

          <img alt="IMGFARMER" src="assets/img/icons/farmer.png" class="ico-4" >

          <img alt="IMGHAIR" src="assets/img/icons/hair.png" class="ico-5">

          <img alt="IMGMECHANIC" src="assets/img/icons/mechanic.png" class="ico-6">

          <img alt="IMGBRUSH" src="assets/img/icons/paint-brush.png" class="ico-7" >

          <img alt="IMGWASH" src="assets/img/icons/wash.png" class="ico-8">

          <img alt="IMGRENT" src="assets/img/icons/rent.png" class="ico-9">
        </div>
        <div class="container py-lg-md d-flex">
          <div class="col px-0">
            <div class="row">
              <div class="col-lg-6">
                  <?php
                    if(!$connected)
                        echo '<h1 class="display-3  text-white">' . _("Un concierge à") . '<span>' . _("votre service 24H sur 24 !") . '</span></h1>
                                <p class="lead  text-white">' . _("Rejoignez la plus grande plateforme de service en vous inscrivant sur Flocon Home !") . '</p>
                              <div class="btn-wrapper">
                                <a href="register.php" class="btn btn-info btn-icon mb-3 mb-sm-0">
                                    <span class="btn-inner--icon"><i class="fas fa-user-tag"></i></span>
                                    <span class="btn-inner--text">' . _("Nous rejoindre") . '</span>
                                </a>
                              </div>';
                    else {
                        echo '<h1 class="display-3  text-white">' . _("Bienvenue") . '<span>' . $_SESSION['lastname'] . ' ' . $_SESSION['firstname'] . '</span></h1>';

                        //Check if user is a subscriber

                        if (count($answer) != 0) {
                            echo '<p class="lead  text-white">' . _("Profitez de votre abonnement pour souscrire à un service sur Flocon Home !") . '</p>
                            <div class="btn-wrapper">
                                <a href="search_ajax.php" class="btn btn-info btn-icon mb-3 mb-sm-0">
                                    <span class="btn-inner--icon"><i class="fas fa-concierge-bell"></i></span>
                                    <span class="btn-inner--text">' . _("Souscire") . '</span>
                                </a>
                            </div>';
                        } else {
                            echo '<p class="lead  text-white">' . _("Vous n'êtes pas abonné ! Rejoignez l'expérience Flocon Home en cliquant sur le bouton ci-dessous") . '</p>
                            <div class="btn-wrapper">
                                <a href="subscription.php" class="btn btn-info btn-icon mb-3 mb-sm-0">
                                    <span class="btn-inner--icon"><i class="fas fa-cookie-bite"></i></span>
                                    <span class="btn-inner--text">' . _("S'abonner") . '</span>
                                </a>
                            </div>';
                        }
                    }
                    ?>
              </div>
            </div>
          </div>
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
    <section class="section section-lg pt-lg-0 mt--200">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row row-grid">
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                      <i class="fas fa-street-view"></i>
                    </div>
                    <h6 class="text-primary text-uppercase"><?php echo _("Philosophie"); ?></h6>
                    <p class="description mt-3"><?php echo _("La conciergerie est un vieux métier, noble, secret que nous avons modernisé sans dénaturer son essence originelle faite d’efficacité absolue et discrétion."); ?> </p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape icon-shape-success rounded-circle mb-4">
                      <i class="far fa-eye"></i>
                    </div>
                    <h6 class="text-success text-uppercase"><?php echo _("Expertise"); ?></h6>
                    <p class="description mt-3"><?php echo _("Nos membres bénéficient en permanence de toutes les ressources de Flocon Home où qu’ils se trouvent sur la planète et quelles que soient leurs demandes."); ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card card-lift--hover shadow border-0">
                  <div class="card-body py-5">
                    <div class="icon icon-shape icon-shape-warning rounded-circle mb-4">
                      <i class="fas fa-user-tie"></i>
                    </div>
                    <h6 class="text-warning text-uppercase"><?php echo _("Professionnalisme"); ?></h6>
                    <p class="description mt-3"><?php echo _("Nos concierges, véritables orfèvres du métier et notre réseau exceptionnel de partenaires, nous permettent de répondre à n’importe quelle requête."); ?> </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section section-lg">
      <div class="container">
        <div class="row row-grid align-items-center">
          <div class="col-md-6 order-md-2">
              <iframe id="WebGL"
                  width="600"
                  height="400"
                  src="WebGL/examples/Rooms.html">
              </iframe>
          </div>
          <div class="col-md-6 order-md-1">
            <div class="pr-md-5">
              <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle mb-5">
                <i class="fas fa-clipboard-list"></i>
              </div>
              <h3><?php echo _("Notre gamme"); ?> <br><?php echo _("de service élite"); ?></h3>
              <p><?php echo _("Flocon Home est un service de haute conciergerie privée à destination d’une clientèle haut de gamme, exigeante, pressée, à qui nous offrons l’excellence, la perfection et le sur-mesure."); ?> <br></p>
              <ul class="list-unstyled mt-5">
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fas fa-calendar-alt"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><?php echo _("Accès privilégié en illimité 7j/7 24h/24"); ?></h6>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fas fa-question"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><?php echo _("Demandes illimitées de renseignements"); ?></h6>
                    </div>
                  </div>
                </li>
                <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fas fa-clock"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><?php echo _("50h de services par mois"); ?></h6>
                    </div>
                  </div>
                </li>
                 <li class="py-2">
                  <div class="d-flex align-items-center">
                    <div>
                      <div class="badge badge-circle badge-success mr-3">
                        <i class="fas fa-paint-roller"></i>
                      </div>
                    </div>
                    <div>
                      <h6 class="mb-0"><?php echo _("De nombreux services proposés"); ?></h6>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section pb-0 bg-gradient-warning" style="padding-bottom: 5% !important;">
      <div class="container">
        <div class="row row-grid align-items-center">
          <div class="col-md-6 order-lg-2 ml-lg-auto">
            <div class="position-relative pl-md-5">
              <img alt="ill" src="assets/img/ill/ill-2.svg" class="img-center img-fluid">
            </div>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="d-flex px-3">
              <div>
                <div class="icon icon-lg icon-shape bg-gradient-white shadow rounded-circle text-primary">
                  <i class="fas fa-smile-beam"></i>
                </div>
              </div>
              <div class="pl-4">
                <h4 class="display-3 text-white"><?php echo _("Work friendly"); ?></h4>
                <p class="text-white"><?php echo _("Que vous soyez au travail ou en vacance, Flocon Home reste toujours aussi proche de vous depuis notre plateforme web simple d'utilisation.") ?></p>
              </div>
            </div>
            <div class="card shadow shadow-lg--hover mt-5">
              <div class="card-body">
                <div class="d-flex px-3">
                  <div>
                    <div class="icon icon-shape bg-gradient-success rounded-circle text-white">
                      <i class="fas fa-wifi"></i>
                    </div>
                  </div>
                  <div class="pl-4">
                    <h5 class="title text-success"><?php echo _("Plateforme web") ?></h5>
                    <p><?php echo _("Flocon Home a été optimisé pour le web afin de répondre au mieux à vos besoins. Nos nombreux partenariats rendent votre vie plus simple au quotidien.") ?></p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- SEPARATEUR SVG -->
        <div class="separator separator-bottom separator-skew">
          <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
          </svg>
        </div>
      </section>
  </main>
  <!-- FOOTER -->
  <?php include('includes/mep/footer.php'); ?>
</body>
</html>
