<?php
session_start();
include('includes/config.php');

$connected = isset($_SESSION['email']) ? true : false;

if($connected == false){
  header('location: login.php');
  exit;
}

?>

<!DOCTYPE html>
<html style="overflow-x :hidden ;">

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
  <?php include('includes/mep/header.php'); ?>
  <main class="profile-page">
    <section class="section-profile-cover section-shaped my-0">
      <!-- Circles background -->
      <div class="shape shape-style-1 shape-primary alpha-4">
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
      <!-- SVG separator -->
      <div class="separator separator-bottom separator-skew">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section>
    <section class="section">
      <div class="container">
        <div class="card card-profile shadow mt--300">
          <div class="px-4">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                  <a>
                    <img src="assets/img/theme/bocuse.jpg" class="rounded-circle">
                  </a>
                </div>
              </div>
              <div class="col-lg-4 order-lg-3 text-lg-right align-self-lg-center">
                <div class="card-profile-actions py-4 mt-lg-0">
                  <a href="" class="btn btn-sm btn-info mr-4">Connecté</a>
                  <a href="#" class="btn btn-sm btn-default float-right">Modifier mon profil</a>
                </div>
              </div>
              <div class="col-lg-4 order-lg-1">
                <div class="card-profile-stats d-flex justify-content-center">
                  <div>
                    <span class="heading">0</span>
                    <span class="description">Amis</span>
                  </div>
                  <div>
                    <span class="heading">0</span>
                    <span class="description">Photos</span>
                  </div>
                  <div>
                    <span class="heading">0</span>
                    <span class="description">Commentaires</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center mt-5">
              <h3>Paul Bocuse<span class="font-weight-light">, 65 ans</span></h3>
              <div class="h6 font-weight-300"><i class="ni location_pin mr-2"></i>Lyon, France</div>
              <div class="h6 mt-4"><i class="ni business_briefcase-24 mr-2"></i>Chef cuisinier - Flocon Entreprise</div>
              <div><i class="ni education_hat mr-2"></i>Université Flocon Inc.</div>
            </div>
            <div class="mt-5 py-5 border-top text-center">
              <div class="row justify-content-center">
                <div class="col-lg-9">
                  <p>La grande cuisine, ce peut être une dinde bouillie, une langouste cuite au dernier moment, une salade cueillie dans le jardin et assaisonnée à la dernière minute.</p>
                  <a href="#">Voir plus</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php include('includes/mep/footer.php'); ?>
</body>

</html>
