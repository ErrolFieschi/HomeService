<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/Form.php';
require_once __DIR__ . '/../Form/select_db.php';


$info = 0;
$MAX = 7;
if(isset($_GET['page']) AND !empty($_GET['page'])AND $_GET['page'] >0){
    $_GET['page'] = intval($_GET['page']);
    $pagesCourante = $_GET['page'];
}else{
    $pagesCourante = 1;
}
$pagesTotal = reqPaginationHistorique($MAX);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>
        FloconHome - Administration
    </title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport'/>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet"/>
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet"/>

    <style> td{ text-align: center; } th{ text-align: center; }</style>
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
                    <a class="nav-link" href="tables.php">
                        <i class="material-icons">dashboard</i>
                        <p>Historique</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="waiting_line.php">
                        <i class="material-icons">dashboard</i>
                        <p>Adhésion à attribuer</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="modification_prestation.php">
                        <i class="material-icons">dashboard</i>
                        <p>Modification prestation</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="show_service.php">
                        <i class="material-icons">dashboard</i>
                        <p>Services</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="javascript:;">Table List</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <form class="navbar-form">
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:;">
                                <i class="material-icons">dashboard</i>
                                <p class="d-lg-none d-md-block">
                                    Stats
                                </p>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">notifications</i>
                                <span class="notification">5</span>
                                <p class="d-lg-none d-md-block">
                                    Some Actions
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Mike John responded to your email</a>
                                <a class="dropdown-item" href="#">You have 5 new tasks</a>
                                <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                                <a class="dropdown-item" href="#">Another Notification</a>
                                <a class="dropdown-item" href="#">Another One</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- End Navbar -->

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Demandes de prestation</h4>
                                <p class="card-category"> Voici toutes les attentes en actuelles</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>ID</th> <th>Compte</th> <th>Prestataire</th> <th>Service</th> <th> Date début </th>
                                        <th>Date fin </th><th>Abonnement</th><th>Description</th>
                                        </thead>
                                        <?php
                                        $videos = reqInfosHistorique($MAX,$pagesCourante);
                                        while ($resultat = $videos->fetch(PDO::FETCH_ASSOC)){ $info += 1;?>
                                            <tbody>
                                            <tr>
                                                <td>

                                                    <?php echo $resultat['id']; ?>
                                                </td>
                                                <td>
                                                    <?php $reqServ = cmpAccount($resultat['fk_account']); ?>
                                                </td>
                                                <td>
                                                    <?php if($resultat['fk_provider'] ==1 && $resultat['refund']== 1){echo "à rembourser ";}
                                                    else{ echo $resultat['fk_provider']; }?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $reqServ = cmpServ($resultat['fk_service']);
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d/m/Y" ,strtotime($resultat['s_date'])) . " " .  $resultat['start_time']; ?>
                                                </td>
                                                <td>
                                                    <?php echo date("d/m/Y" ,strtotime($resultat['end_date'])) . " " . $resultat['end_time']; ?>
                                                </td>
                                                <td>
                                                    <p> Premium</p>
                                                </td>
                                                <td>
                                                    <?php echo $resultat['description']; ?>
                                                </td>
                                            </tr>
                                            </tbody>
                                        <?php }  ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item">
                                    <?php
                                    $prev = $_GET['page'] -1;
                                    if($prev <1 ){ $prev = 1;}
                                    echo '<a class="page-link" href="testAdmin.php?page=' . $prev .'" >Previous</a>'
                                    ?>
                                </li>

                                <?php
                                for ($i = 1; $i < $pagesTotal ; $i++) {
                                    echo ' <li class="page-item"><a class="page-link" href="testAdmin.php?page=' . $i.'">' . $i . '</a></li>';
                                }
                                ?>

                                <li class="page-item">
                                    <?php
                                    $next = $_GET['page'] +1;
                                    if($next > $pagesTotal){ $next = $pagesTotal;}
                                    echo '<a class="page-link" href="testAdmin.php?page=' . $next .'" >Next</a>'
                                    ?>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
                <?php if($info == 1){ ?>
                    <div class="alert alert-warning" role="alert">Information ! Veuillez ajouté un prestataire dans l'onglet PRÉSTATION ATTRIBUÉ</div>
                <?php }?>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="float-left">
                    <ul>
                        <li>
                            <a href="https://www.creative-tim.com">
                                Creative Tim
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
                    </script>
                    , made with <i class="material-icons">favorite</i> by
                    <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
                </div>
            </div>
        </footer>
    </div>
</div>
</body>
</html>




?>
