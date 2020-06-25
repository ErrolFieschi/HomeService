<?php
session_start();
require_once __DIR__ . '/Class/Form.php';
require_once __DIR__ . '/pdo.env';

$form = new Form($_POST);

$options = [
    'Paris',
    'Rennes',
    'Nantes',
    'Marseille',
    'Tours'
];

$connected = isset($_SESSION['email']) ? true : false;

if($connected){
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Flocon a été développé pour optimiser l'organisation de vos repas au quotidien. Indiquez vos préférences culinaires et il s'occupera du reste !">
  <meta name="author" content="Flocon">
  <title>FloconHome - Le site de conciergerie accessible à tous</title>
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
  <?php include('includes/mep/header-rg.php'); ?>
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
                    <div class="text-muted text-center mb-3"><small><?php echo _("Déjà membre ?"); ?></small></div>
                    <div class="btn-wrapper text-center">
                        <a href="login.php" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon"><i class="fas fa-sign-in-alt"></i></span>
                            <span class="btn-inner--text"><?php echo _("Connectez-vous"); ?></span>
                        </a>
                    </div>
                </div>
              <div class="card-body px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                  <small><?php echo _("Ou inscrivez-vous, c'est simple et rapide"); ?></small>
                </div>
                <form role="form" method="post" action="Form/insert.php" onsubmit="return checkForm(this)">
                  <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                      </div>
                        <?php echo $form->input(_("Nom"),'lastname','text','form-control', 'checkUnit(this, 60)', 'name'); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                        <?php echo $form->input(_("Prénom"),'firstname','text','form-control', 'checkUnit(this, 60)', ''); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                      </div>
                        <?php echo $form->input(_("Email"),'email','text','form-control', 'checkMail(this)', ''); ?>
                    </div>
                  </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                            </div>
                            <?php echo $form->input(_("Télephone"),'phone','text','form-control', 'checkReverse(this, 10)', ''); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-marked"></i></span>
                            </div>
                            <?php echo $form->input(_("Adresse"),'address','text','form-control', 'checkAddress(this, 255)', ''); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                            </div>
                            <?php echo $form->input(_("Code postal"),'postal_code','number','form-control', 'checkReverse(this, 5)', ''); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php echo _("Mot de passe"); ?></label>
                        <div id="strTxt" style="margin-top:-8px; margin-bottom: 10px; font-size: 10px;"><i><?php echo _("Minimum 8 caractères, 1 minuscule, 1 majuscule et 1 chiffre"); ?></i></div>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                            </div>
                            <?php echo $form->input(_("Mot de passe"),'password','password','form-control', 'checkPassword(this)', ''); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php echo $form->select(_("Agence de référence"), 'city', $options, "form-control", '', ''); ?>
                    </div>
                  <div class="text-center">
                        <?php echo $form->submit("btn btn-primary mt-4"); ?>
                    </div>
                </form>
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
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <script src="assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="assets/vendor/headroom/headroom.min.js"></script>
  <script src="assets/js/form.js" type="text/javascript"></script>
  <!-- Flocon JS -->
  <script src="assets/js/flocon.js?v=1.1.0"></script>
</body>

</html>
