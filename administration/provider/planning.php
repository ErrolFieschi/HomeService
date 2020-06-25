<?php
require "src/date/Month.php";
require "src/date/Events.php";
$events = new Events();
$month = new Month(!isset($_GET['month']) ? null : $_GET['month'], !isset($_GET['year']) ? null : $_GET['year']);
$start = $month->getStartingDay();
$start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$weeks = $month->getWeeks();
$end = $start->modify('+' . (6 + 7 * ($weeks - 1)) . ' days');
$events = $events->getEventsBetweenByDay($start, $end);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>
        FloconHome - Administration
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link href="../../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
    <link href="../../assets/demo/demo.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/calendar.css">
</head>

<body class="">
<div class="wrapper ">
    <?php include 'header.php'; ?>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h3 class="card-title">Mon planning</h3>
                        <p class="card-category">Suivez vos rendez-vous sur le mois en cours afin de répondre au mieux à la demande</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
                                    <h1 class="calendar__title"><?= $month->toString(); ?></h1>
                                    <div>
                                        <a href="planning.php?month=<?= $month->previousMonth()->month; ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
                                        <a href="planning.php?month=<?= $month->nextMonth()->month; ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
                                    </div>
                                </div>

                                <!-- Calendar -->
                                <table class="calendar__table calendar__table--<?= $weeks; ?>weeks">
                                    <?php for($i=0; $i < $weeks; $i++){ ?>
                                        <tr>
                                            <?php foreach ($month->days as $k => $day){
                                                $date = $start->modify("+" . ($k + $i * 7) . " days");
                                                $eventsForDay = $events[$date->format('Y-m-d')] ?? [];
                                                ?>
                                                <td class="<?= $month->withinMonth($date) ? '' : 'calendar__othermonth'; ?>">
                                                    <?php if($i === 0){ ?>
                                                        <div class="calendar__weekday"><?= $day; ?></div>
                                                    <?php } ?>
                                                    <div class="calendar__day"><?= $date->format('d'); ?></div>
                                                    <?php foreach ($eventsForDay as $event){ ?>
                                                        <div class="calendar__event">
                                                            <a href="events.php?id=<?= $event['id']; ?>" class="calendar__a"> <?= $event['description']; ?></a>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <!-- End of calendar -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php include 'footer.php'; ?>
    </div>
</div>
</body>

</html>