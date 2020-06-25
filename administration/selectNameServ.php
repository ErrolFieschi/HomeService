<?php
ini_set('display_errors', 1);
require_once __DIR__ . '/../Class/Form.php';
require_once __DIR__ . '/../Form/select_db.php';
require_once __DIR__ . '/../Form/date_select.php';
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
    <link src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"/>
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
                    <a class="nav-link" href="show_service.php">
                        <i class="material-icons">dashboard</i>
                        <p>Services</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="add_service.php">
                        <i class="material-icons">dashboard</i>
                        <p>Ajouter un service</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="waiting_line.php">
                        <i class="material-icons">dashboard</i>
                        <p>Adhésion à attribuer</p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="tables.php">
                        <i class="material-icons">dashboard</i>
                        <p>Historique</p>
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
                    <a class="navbar-brand" href="javascript:">GESTION DES SERVICES</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <form class="navbar-form" method="post" action="selectNameServ.php">
                        <div class="input-group no-border">
                            <input type="text" name="nameSearch" class="form-control" placeholder="Search...">
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

                        <?php if(!empty($_GET) && $_GET['status'] == "erreur") {
                            echo  '<div style="background-position-x : 2em " class="alert alert-danger" role="alert"> Veuillez remplir tous les champs (Description facultatif) ou veuillez insérer un prix superieur à 5 !</div>';
                        }?>
                        <?php if(!empty($_GET) && $_GET['status'] == "success") {
                            echo  '<div style="background-position-x : 2em " class="alert alert-success" role="alert"> Opération réussie avec succes ! </div>';
                        }?>

                        <div class="card">
                            <div class="card-header card-header-primary card-color">
                                <h4 class="card-title ">SERVICES</h4>
                                <p class="card-category">Services actuellement proposé</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>ID</th> <th>NAME</th>  <th>DESCRIPTION</th> <th>PRIX HEURE</th>  <th>MODIFIER</th> <th>OPTIONS</th>
                                        </thead>
                                        <?php
                                        $req = nameService();
                                        while ($resultat = $req->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <?php echo $resultat['id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $resultat['name']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $resultat['description']; ?>
                                                </td>

                                                <td>
                                                    <?php echo $resultat['price'] . " €"; ?>
                                                </td>

                                                <td>
                                                    <a href="modification_service.php?id=<?= $resultat['id'] ?>&sup=0"
                                                       class="btn btn-primary-mod mt-2">MODIFIER
                                                    </a>
                                                </td>

                                                <td>
                                                    <?php if($resultat['info'] == 1){ ?>
                                                        <a href="../Form/mod_service.php?id=<?= $resultat['id'] ?>&sup=1"
                                                           class="btn btn-primary-supp mt-2 ">DÉSACTIVER
                                                        </a>
                                                    <?php }else{ ?>
                                                        <a href="../Form/mod_service.php?id=<?= $resultat['id'] ?>&sup=2"
                                                           class="btn btn-primary-act mt-2 ">ACTIVER
                                                        </a>
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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