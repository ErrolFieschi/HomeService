<?php
session_start();
require_once __DIR__ . '/Class/Form.php';
require_once __DIR__ . '/pdo.env';

$form = new Form($_POST);

$connected = isset($_SESSION['email']) ? true : false;

if($connected){
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html  lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Flocon a été développé pour optimiser l'organisation de vos repas au quotidien. Indiquez vos préférences culinaires et il s'occupera du reste !">
  <meta name="author" content="Flocon">
  <title>Flocon - Le générateur d'idées culinaires accessible à tous</title>
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
  <?php include('includes/mep/header-lg.php'); ?>
  <!-- ------ -->
  <main>
    <section class="section section-shaped section-lg">
      <div class="shape shape-style-1 bg-gradient-default">
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
      <div class="container pt-lg-md">
        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="card bg-secondary shadow border-0">
              <div class="card-header bg-white pb-5">
                <div class="text-muted text-center mb-3"><small><?php echo _("Vous êtes nouveau ?"); ?></small></div>
                <div class="btn-wrapper text-center">
                  <a href="register.php" class="btn btn-neutral btn-icon">
                    <span class="btn-inner--icon"><i class="fas fa-sign-in-alt"></i></span>
                    <span class="btn-inner--text"><?php echo _("Inscrivez-vous"); ?></span>
                  </a>
                </div>
              </div>
              <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                  <small><?php echo _("Ou connectez-vous avec votre adresse mail"); ?></small>
                </div>
                <form role="form" method="post" action="includes/connexion/login.php">
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                      </div>
                        <?php echo $form->input(_("Email"),'email','email','form-control email', '', ''); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                      </div>
                        <?php echo $form->input(_("Mot de passe"),'password','password','form-control password', '', ''); ?>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary my-4"><?php echo _("Connexion"); ?></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <!--<a href="#" class="text-light" style="color: white !important;"><small>Mot de passe oublié?</small></a> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- FOOTER -->
  <?php include('includes/mep/footer.php'); ?>
  <!-- Core -->
  <script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <script src="assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="assets/vendor/headroom/headroom.min.js"></script>
  <!-- Flocon JS -->
  <script src="assets/js/flocon.js?v=1.1.0"></script>
</body>

</html>
