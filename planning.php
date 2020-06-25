<?php
require "administration/provider/src/date/Month.php";
require "administration/provider/src/date/Events.php";
require "Form/select_db.php";
include('includes/convert.php');
session_start();

$connected = isset($_SESSION['email']) ? true : false;

if($connected == false){
    header('location: login.php');
    exit;
}

$events = new Events();
$events1 = new Events();
$events2 = new Events();
$events3 = new Events();
$month = new Month(!isset($_GET['month']) ? null : $_GET['month'], !isset($_GET['year']) ? null : $_GET['year']);
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="administration/provider/css/calendar.css">
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
                    <img src="assets/img/theme/planner.png" class="rounded-circle">
                  </a>
                </div>
              </div>
              <div class="col-lg-4 order-lg-3 text-lg-right align-self-lg-center">
                <div class="card-profile-actions py-4 mt-lg-0">
                        <a href="planning.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary calendar-btn">&lt;</a>
                        <a href="planning.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary calendar-btn">&gt;</a>
                </div>
              </div>
              <div class="col-lg-4 order-lg-1">
                <div class="card-profile-stats d-flex justify-content-center">
                    <h1 class="calendar__title"><?= $month->toString(); ?></h1>
                </div>
              </div>
            </div>
            <div class="text-center mt-5">
                <!-- Calendar -->
                <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
                    <?php for($i=0; $i < $weeks; $i++){ ?>
                        <tr>
                            <?php foreach ($month->days as $k => $day){
                                $date = $start->modify("+" . ($k + $i * 7) . " days");
//                                var_dump($date);
                                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                                if($i === 0){ ?>
                                    <div class="calendar__weekday"><?= $day; ?></div>
                                <?php } ?>
                                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                                    <div class="calendar__day"><?= $date->format('d'); ?></div>
                                    <?php foreach ($eventsForDay as $event){ ?>
                                        <div class="calendar__event" id="slider">
                                            <a href="planning.php?prestation=<?= $event['id']; ?>&day=<?= $date->format('d'); ?>&month=<?= $date->format('m'); ?>&year=<?= $date->format('Y'); ?>&horaire=<?= substr($event['start_time'], -8, 5); ?>&user=<?= $event['fk_account']; ?>&provider=<?= $event['fk_provider']; ?>#slider" class="calendar__a"><i class="fas fa-clock"></i> <?= substr($event['start_time'], -8, 5); ?> - RDV</a>
                                        </div>
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
                <!-- End of calendar -->
            </div>
              <?php if(isset($_GET['prestation'])){
                  $description = $events1->getEventsInfo($_GET['prestation']);
                  $user = $events2->getEventsUser($_GET['user']);
                  $provider = $events3->getEventsProvider($_GET['provider']);
                  ?>
            <div class="mt-5 py-5 border-top text-center">
              <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="calendar__description"><?php echo _("DETAILS DE LA PRESTATION"); ?></div>
                  <p style="padding-top: 30px;" class="calendar__global">
                      <b><?php echo _("Intervention chez:"); ?></b> <?= $user[0][0] . ' ' . $user[0][1]; ?><br>
                      <b><?php echo _("Adresse d'intervention:"); ?></b> <?= $user[0][2] . ', ' . $user[0][3] . ', ' . $user[0][4]; ?><br>
                          <b><?php echo _("Intervenant:"); ?></b> <?= $provider[0][0] . ' ' . $provider[0][1]; ?><br>
                  </p>
                    <div class="calendar__description"><?php echo _("DESCRIPTION DE LA PRESTATION"); ?></div>
                    <p style="padding-top: 30px;" class="calendar__global">
                        <?= $description[0][0]; ?>
                    </p>
                </div>
                  <a style="color: #0b4b7d; margin-top: 37px;"><?php echo _("Rendez vous le "); ?><?= $_GET['day'] . ' ' . convertDigit($_GET['month']) . ' ' . $_GET['year']; ?> à <?= $_GET['horaire']; ?></a>
              </div>
            </div>
              <?php } ?>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php include('includes/mep/footer.php'); ?>
</body>

</html>
