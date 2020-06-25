<?php

ini_set('display_errors', 1);
require_once __DIR__ . '/Form/select_db.php';

?>
<!DOCTYPE html>
<html>
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
<?php // include('includes/mep/header.php'); ?>
<!-- ------ -->
<main>
    <div class="position-relative">
        <!-- shape Hero -->
        <section class="section section-lg section-shaped pb-250">
            <div class="shape shape-style-1 shape-default">
                <img src="assets/img/icons/cleaner.png" class="ico-1">

                <img src="assets/img/icons/coach.png" class="ico-2">

                <img src="assets/img/icons/delivery-truck.png" class="ico-3">

                <img src="assets/img/icons/farmer.png" class="ico-4">

                <img src="assets/img/icons/hair.png" class="ico-5">

                <img src="assets/img/icons/mechanic.png" class="ico-6">

                <img src="assets/img/icons/paint-brush.png" class="ico-7">

                <img src="assets/img/icons/wash.png" class="ico-8">

                <img src="assets/img/icons/rent.png" class="ico-9">
            </div>
            <div class="container py-lg-md d-flex">
                <div class="col px-0">
                    <div class="row">
                        <div class="col-lg-6">
                            <h1 class="display-3  text-white">Un concierge à <span>votre service 24H sur 24 !</span></h1>
                            <p class="lead  text-white">Et si vous faisiez partie de l'équipe Flocon dans nos nombreuses agences</p>
                            <div class="btn-wrapper">
                                <a href="#" class="btn btn-info btn-icon mb-3 mb-sm-0">
                                    <span class="btn-inner--icon"><i class="fas fa-cookie-bite"></i></span>
                                    <span class="btn-inner--text">Devenir partenaire</span>
                                </a>
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
        <!-- 3 BANNER -->
    </div>

    <section class="section section-lg pt-lg-0 mt--200">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row row-grid">
                        <?php
                        $req = service();
                        while ($resultat = $req->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="col-lg-4">
                            <div class="card card-lift--hover shadow border-0">

                                <div class="card-body py-5">
                                    <div class="icon icon-shape icon-shape-primary rounded-circle mb-4">
                                        <i class="fas fa-rocket"></i>
                                    </div>
                                    <h6 class="text-primary text-uppercase"><?php echo $resultat['name']; ?> </h6>
                                    <p class="description mt-3"> <?php echo $resultat['description'];  ?> </p>
                                    <a href="quote.php?t=1&id=<?= $resultat['id'] ?>" class="btn btn-primary mt-4">Choisir ce service</a>
                                </div>
                            </div>
                        </div> <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-lg">
        <div class="container">
            <div class="row row-grid align-items-center">
                <div class="col-md-6 order-md-2">
                    <img src="assets/img/caroussel/dish7.png" style="border-radius: 3%;" class="img-fluid floating">
                </div>
                <div class="col-md-6 order-md-1">
                    <div class="pr-md-5">
                        <div class="icon icon-lg icon-shape icon-shape-success shadow rounded-circle mb-5">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h3>Recette du jour <br>Carpaccio de boeuf</h3>
                        <p>Étaler les tranches de boeuf sur un plat. Verser le jus du citron et l'huile d'olive, sur la viande. <br>Ensuite, ajouter les baies roses, les graines de coriandre et l'oignon haché finement puis saupoudrer de parmesan. <br>Pour finir, laisser mariner au moins 2 heures.</p>
                        <ul class="list-unstyled mt-5">
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="badge badge-circle badge-success mr-3">
                                            <i class="fas fa-bacon"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">400 g de boeuf</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="badge badge-circle badge-success mr-3">
                                            <i class="fas fa-wine-bottle"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">4 cuillères à soupe d'huile d'olive</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="badge badge-circle badge-success mr-3">
                                            <i class="fas fa-seedling"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">1 bouquet de ciboulette</h6>
                                    </div>
                                </div>
                            </li>
                            <li class="py-2">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <div class="badge badge-circle badge-success mr-3">
                                            <i class="fas fa-cheese"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="mb-0">30 g de parmesan râpé</h6>
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
                        <img src="assets/img/ill/ill-2.svg" class="img-center img-fluid">
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
                            <h4 class="display-3 text-white">Work friendly</h4>
                            <p class="text-white">Que vous soyez au travail ou en vacance, flocon reste toujours aussi proche de vous sur le web ou depuis notre application mobile.</p>
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
                                    <h5 class="title text-success">Plateforme web</h5>
                                    <p>Flocon a été optimisé pour le web afin de répondre au mieux à vos besoins. Nos nombreux partenariats avec vos supermarchés favoris rendent votre vie plus simple.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow shadow-lg--hover mt-5">
                        <div class="card-body">
                            <div class="d-flex px-3">
                                <div>
                                    <div class="icon icon-shape bg-gradient-warning rounded-circle text-white">
                                        <i class="fas fa-mobile"></i>
                                    </div>
                                </div>
                                <div class="pl-4">
                                    <h5 class="title text-warning">Application mobile</h5>
                                    <p>Afin de vous faciliter la vie, Flocon est également disponible sur tous les appareils iOS et Android. </p>
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
<!-- Js -->

</body>
</html>
