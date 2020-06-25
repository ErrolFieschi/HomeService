<?php
session_start();
require_once "../Class/DatabasesManager.php";

$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: ../login.php');
    exit;
}
$count = new DatabasesManager();
$count = $count->getPdo()->prepare('SELECT COUNT(id) FROM subscribe WHERE fk_subscription = ?');

//active subscription
$dbRequest = new DatabasesManager();
$dbRequest = $dbRequest->getPdo()->prepare('SELECT * FROM subscription WHERE active = 1');
$dbRequest->execute();

//inactive subscription
$dbInactive = new DatabasesManager();
$dbInactive = $dbInactive->getPdo()->prepare('SELECT * FROM subscription WHERE active = 0');
$dbInactive->execute();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        FloconHome - Administration
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/2586f30b2f.js"></script>
    <!-- CSS Files -->
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body class="">

<div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
        <!--
          Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

          Tip 2: you can also add an image using data-image tag
      -->
        <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
                Flocon Home
            </a></div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item active  ">
                    <a class="nav-link" href="./dashboard.html">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="./us<!DOCTYPE html">
<i class="material-icons">person</i>
<p>User Profile</p>
</a>
</li>
<li class="nav-item ">
    <a class="nav-link" href="tables.php">
        <i class="material-icons">content_paste</i>
        <p>Table List</p>
    </a>
</li>
<li class="nav-item ">
    <a class="nav-link" href="./notifications.html">
        <i class="material-icons">notifications</i>
        <p>Notifications</p>
    </a>
</li>
</ul>
</div>
</div>


<div class="main-panel">

    <?php
    if(isset($_GET['error']) && $_GET['error'] == 'arrayMax'){
        echo ' <div class="content">
        <div class="alert alert-primary" role="alert">
            This is a primary alert—check it out!
        </div>';
    }
    ?>

    <!-- Navbar -->
        <div class="card">
            <div class="card-header card-header-tabs card-header-success" style="margin-top: 20px;">
                <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                        <span class="nav-tabs-title" style="font-size: 20px;">ABONNEMENTS ACTIFS</span>
                    </div>
                </div>
                <button onclick="reloader(0, 'form')" data-toggle="modal" data-target="#exampleModal" type="submit" class="btn btn-warning pull-right">Ajouter un abonnement</button>
            </div>


        <div class="container-fluid" id="container_reload">
            <div class="row">

                <!-- DEBUT -->
                <?php
                $rows = $dbRequest->fetchAll(PDO::FETCH_ASSOC);

                if(empty($rows)){
                    echo '<div class="card-body">

                            <p class="card-category">
                                Aucun abonnement actif en cours
                            </p>
                        </div>
                    
                    ';
                }

                foreach ($rows as $row) {
                    $count->execute([$row['id']]);
                    $counter = (int)$count->fetch(PDO::FETCH_NUM)[0];
                ?>
                <div class="col-md-4">
                    <div class="card card-chart" style="margin-top: 65px !important;">
                        <div class="card-header card-header-success">
                            <div class="ct-chart" id="dailySalesChart">
                                <h4 class="card-title"><?php echo 'Abonnement ' . $row['nom']; ?></h4>
                            </div>
                        </div>
                        <div class="card-body">

                            <p class="card-category">
                                Accès privilégié <span class="text-success"><?php echo $row['dayAccess']; ?>j/7 de <?php echo substr($row['startHourAccess'], -8, 5); ?> à <?php echo substr($row['endHourAccess'], -8, 5); ?></span>
                            </p>
                            <p class="card-category">
                                Demandes <span class="text-success">illimitées</span> de renseignements
                            </p>
                            <p class="card-category">
                                <span class="text-success"><?php echo $row['duration']; ?></span>h de services/mois
                            </p>
                            <p class="card-category">
                                <span class="text-success"><?php echo $row['price'] . '€'; ?></span> TTC par mois
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <p class="card-category">
                                    <?php if($counter == 0){ ?>
                                    <span class="text-warning"><i class="fa fa-long-arrow-down"></i> <?php echo $counter; ?> </span> abonnement vendu</p>
                                    <?php }else{ ?>
                                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> <?php echo $counter; ?> </span> abonnements vendus</p>
                                    <?php } ?>
                            </div>
                            <button id="clickme" onclick="reloader(<?php echo $row['id']; ?>, 'unactive')" type="submit" class="btn btn-success pull-right">Désactiver</button>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <!-- FIN -->
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12" id="subscription_reload">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Abonnements inactifs</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                <th>Type</th>
                                <th>Prix</th>
                                <th>Temps d'accès</th>
                                <th>Jours d'accès</th>
                                <th></th>
                                </thead>
                                <tbody>
                                <?php
                                    $results = $dbInactive->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($results as $result) {
                                ?>
                                <tr>
                                    <td><?= $result['nom']; ?></td>
                                    <td><?= $result['price'] .  '€'; ?></td>
                                    <td><?= $result['duration'] . 'h'; ?></td>
                                    <td><?= $result['dayAccess'] . 'j/7'; ?></td>
                                    <td><button onclick="reloader(<?php echo $result['id']; ?>, 'active')" data-toggle="modal" data-target="#exampleModal" type="submit" class="btn btn-warning pull-right">Activer</button></td>
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

    <!-- Modal -->
    <div class="modal" id="getCodeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> ABONNEMENT ACTIF MAXIMUM ATTEINT !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Le nombre maximum d'abonnement actif est de 3, veuillez désactiver un abonnement actif en cours afin d'en activer un autre.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- Form -->
    <div class="modal fade" id="getCodeForm" tabindex="-1" role="">
        <div class="modal-dialog modal-login" role="document">
            <div class="modal-content">
                <div class="card card-signup card-plain">
                    <div class="modal-header">
                        <div class="card-header card-header-warning text-center">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <i class="material-icons">clear</i>
                            </button>

                            <h4 class="card-title" style="padding-left: 126px; padding-right: 79px; display: inline;">Ajouter un abonnement</h4>

                        </div>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="provider/src/addSub.php">
                            <div class="card-body">

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fab fa-cc-stripe"></i></div>
                                        </div>
                                        <input type="text" name="stripe" class="form-control" placeholder="StripePlan ID">
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-file-signature"></i></div>
                                        </div>
                                        <input type="text" name="name" class="form-control" placeholder="Intitulé de l'abonnement">
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-money-check"></i></div>
                                        </div>
                                        <input type="number" name="price" class="form-control" placeholder="Coût de l'abonnement par mois">
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                        </div>
                                        <input type="number" name="hour" class="form-control" placeholder="Nombre d'heures de service inclus">
                                    </div>
                                </div>

                                <div class="form-group bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-calendar-day"></i></div>
                                        </div>
                                        <select id="inputState" name="day" class="form-control">
                                            <option selected>Choisir le nombre de jour d'accès au service</option>
                                            <option value="1">1j/7</option>
                                            <option value="2">2j/7</option>
                                            <option value="3">3j/7</option>
                                            <option value="4">4j/7</option>
                                            <option value="5">5j/7</option>
                                            <option value="6">6j/7</option>
                                            <option value="7">7j/7</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-warning pull-right">Valider</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form -->




    <footer class="footer">
        <div class="container-fluid">
            <nav class="float-left">
                <ul>
                    <li>
                        <a href="https://www.creative-tim.com">
                            FloconHome
                        </a>
                    </li>
                    <li>
                        <a href="https://creative-tim.com/presentation">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="http://blog.creative-tim.com">
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="https://www.creative-tim.com/license">
                            Licenses
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright float-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with <i class="material-icons">favorite</i> by
                <a href="#" target="_blank">FloconHome</a> for a better web.
            </div>
        </div>
    </footer>
</div>
</div>



<script>

    function reloader(id, status) {
        $.ajax({
            url: 'provider/src/update.php', // Le nom du fichier indiqué dans le formulaire
            type: "POST", // La méthode indiquée dans le formulaire (get ou post)
            data: 'id=' + id + '&status=' + status,
            success: function (response) { // Je récupère la réponse du fichier PHP
                if (response ==  "error") {
                    $("#getCodeModal").modal("show");

                } else if(response ==  "success") {
                    $("#container_reload").load(window.location.href + " #container_reload");
                    $("#subscription_reload").load(window.location.href + " #subscription_reload");
                }else if(response ==  "form") {
                    $("#getCodeForm").modal("show");
                }
            }
        });
    }
</script>

</body>

</html>