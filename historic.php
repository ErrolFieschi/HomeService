<?php
require_once __DIR__ . "/Class/DatabasesManager.php";
include('includes/convert.php');

session_start();

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: login.php');
    exit;
}

$dbRequest = new DatabasesManager();
$dbService = new DatabasesManager();
$dbPrestation = new DatabasesManager();

$dbRequest = $dbRequest->getPdo()->prepare('SELECT * FROM prestation WHERE fk_account=?');
$dbRequest->execute([$_SESSION['id']]);

$dbService = $dbService->getPdo()->prepare('SELECT * FROM service WHERE id=?');
$dbPrestation = $dbPrestation->getPdo()->prepare('SELECT * FROM provider WHERE id=?');

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
            <div class="text-center mt-5">
              <h1><?php echo _("Historique des Prestations"); ?></h1>
            </div>
            <div class="mt-5 py-5 border-top text-center">
              <div class="row justify-content-center">
                <div class="col-lg-9">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center"><?php echo _("Service"); ?></th>
                            <th><?php echo _("Prestataire"); ?></th>
                            <th><?php echo _("Date"); ?></th>
                            <th><?php echo _("Horaire"); ?></th>
                            <th class="text-right"><?php echo _("Tarif"); ?></th>
                            <th class="text-right"><?php echo _("Actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows = $dbRequest->fetchAll(PDO::FETCH_ASSOC);
                              if(!$rows)
                                echo '</table><h3>' . _("Aucune prestation") . '</h3>';
                              else
                                foreach ($rows as $row)
                                {
                                    $list = explode('-', $row['s_date']);

                                    //$dbService = $dbService->getPdo()->prepare('SELECT * FROM service WHERE id=?');
                                    $dbService->execute([$row['fk_service']]);
                                    $s = $dbService->fetch();

                                    //$dbPrestation = $dbPrestation->getPdo()->prepare('SELECT * FROM provider WHERE id=?');
                                    $dbPrestation->execute([$row['fk_provider']]);
                                    $p = $dbPrestation->fetch();
                                    ?>
                        <tr>
                            <td><?php echo $s['name']; ?></td>
                            <td><?php echo $p['firstname'] . ' ' . $p['lastname']; ?></td>
                            <td><?php echo $list[2] . ' ' . convertMonth($row['s_date']) . ' ' . $list[0]; ?></td>
                            <td><?= substr($row['start_time'], -8, 5); ?></td>
                            <td class="text-right">20 &euro;</td>
                            <td class="td-actions text-right">
                                <a href="prestation.php?type=define&service=<?php echo $row['fk_service']; ?>"><button href="#" type="button" rel="tooltip" class="btn btn-info btn-icon btn-sm " data-original-title="<?php echo _("Faire appel à nouveau à ce service") ?>" title="<?php echo _("Faire appel à nouveau à ce service") ?>">
                                    <i class="ni ni-circle-08 pt-1"></i>
                                </button></a>
                                <a href="Bill/TCPDF/examples/billGenerator.php?billNumber=<?php echo $row['id']; ?>"><button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm " data-original-title="" title="<?php echo _("Facture") ?>">
                                    <i class="fas fa-file-invoice"></i>
                                </button></a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
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
