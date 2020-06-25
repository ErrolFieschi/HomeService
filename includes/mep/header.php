<?php
require_once "Class/DatabasesManager.php";
require_once "includes/convert.php";

if(isset($_GET['lang'])){
    $_SESSION['language'] = $_GET['lang'];
}
require 'localization.php';

if ($connected == true) {
    $dbReq = new DatabasesManager();
    $dbSer = new DatabasesManager();
    $dbPre = new DatabasesManager();
    $data = new DatabasesManager();
    $counter = new DatabasesManager();

    $dbReq = $dbReq->getPdo()->prepare('SELECT * FROM prestation WHERE fk_account=? ORDER BY id LIMIT 5 ');
    $dbReq->execute([$_SESSION['id']]);

    $dbSer = $dbSer->getPdo()->prepare('SELECT * FROM service WHERE id=?');
    $dbPre = $dbPre->getPdo()->prepare('SELECT * FROM provider WHERE id=?');

    $counter = $counter->getPdo()->prepare(
                            'SELECT id, status, stop FROM subscribe WHERE fk_account = ? AND status = 1');

    $counter->execute(array($_SESSION['id']));
    $answer = [];
    while ($users = $counter->fetch()) {
        $answer[] = $users;
    }

    if (count($answer) != 0) {
        $data = $data->getPdo()->prepare(
            'SELECT * FROM subscribe WHERE fk_account = ? AND status = 1');

        $data->execute(array($_SESSION['id']));
        $rows = $data->fetchAll(PDO::FETCH_ASSOC);
        $rows = $rows[0];
    }
}
?>


<header class="header-global">
    <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
        <div class="container">
            <a class="navbar-brand mr-lg-5" style="font-size: 27px;" href="index.php"><img src="assets/img/logo.png" alt="logo"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbar_global">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="index.php">FLOCON HOME</a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar_global" aria-controls="navbar_global" aria-expanded="false" aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav navbar-nav-hover align-items-lg-center ml-lg-auto">
                    <li class="nav-item dropdown ml-lg-4">
                        <?php if($connected == true){ ?>
                            <a href="#" data-toggle="dropdown" class="btn btn-neutral btn-icon">
                                <i class="ni ni-ui-04 d-lg-none"></i>
                                <span class="nav-link-inner--text"><?php echo _("Mon compte"); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-xl" style="z-index: 4000 !important;">
                                <div class="dropdown-menu-inner">
                                    <?php if (count($answer) != 0 && $answer[0]['stop'] == 0) { ?>
                                    <a class="media d-flex align-items-center">
                                        <div class="media-body ml-3" style="background-color: #f6f4f4; padding: 10px; border-radius: 10px; margin-left: 3px !important;">
                                            <h8 class="heading text-primary mb-md-1" style="color: #b24545 !important;">Abonnement</h8>
                                            <p class="description d-none d-md-inline-block mb-0" style="padding-top: 5px;"><?php echo _("Il vous reste ")  . '<b>' . $rows['remainingHour'] . 'h</b>' . _(" de service compris dans votre abonnement à utiliser jusqu'au ") . '<b>' . date('d/m/Y', strtotime($rows['nextRecurrence'])) . '</b>'; ?></p>
                                            <button onclick="window.location.href='unsubscribe.php'" class="btn btn-info btn-icon mb-3 mb-sm-0" style="padding: 3px !important; font-size: 10px !important; margin-top: 8px; background-color: #ef6311; border-color: #ef6311;">Se désabonner</button>
                                        </div>
                                    </a>
                                    <?php }elseif (count($answer) != 0 && $answer[0]['stop'] == 1){ ?>
                                    <a class="media d-flex align-items-center">
                                        <div class="media-body ml-3" style="background-color: #f6f4f4; padding: 10px; border-radius: 10px; margin-left: 3px !important;">
                                            <h8 class="heading text-primary mb-md-1" style="color: #b24545 !important;">Abonnement</h8>
                                            <p class="description d-none d-md-inline-block mb-0" style="padding-top: 5px;"><?php echo _("La rupture de votre abonnement a bien été pris en compte, il vous reste encore ")  . '<b>' . $rows['remainingHour'] . 'h</b>' . _(" de service à consommer avant la fin de votre abonnement prévu le"); ?></p>
                                            <p style="color: #000;"><b><?php echo date('d/m/Y', strtotime($rows['nextRecurrence'])); ?></b></p>
                                        </div>
                                    </a>
                                    <?php } ?>
                                    <a href="profile.php" class="media d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-primary rounded-circle text-white">
                                            <i class="fas fa-user-alt"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="heading text-primary mb-md-1"><?php echo _("Profil"); ?></h6>
                                        </div>
                                    </a>
                                    <a href="historic.php" class="media d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-success rounded-circle text-white">
                                            <i class="fas fa-undo-alt"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="heading text-success mb-md-1"><?php echo _("Mon historique"); ?></h6>
                                        </div>
                                    </a>
                                    <a href="planning.php" class="media d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-warning rounded-circle text-white">
                                            <i class="far fa-file-alt"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h5 class="heading text-warning mb-md-1"><?php echo _("Mon planning"); ?></h5>
                                            <p class="description d-none d-md-inline-block mb-0"><?php echo _("Suivez vos prochains rendez-vous !"); ?></p>

                                        </div>
                                    </a>
                                    <a href="planning.php" class="media d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-info rounded-circle text-white">
                                            <i class="fas fa-user-secret"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h5 class="heading text-info mb-md-1">Besoin d'un service ?</h5>
                                            <p class="description d-none d-md-inline-block mb-0">Choisissez nos nombreux services à la carte</p>

                                        </div>
                                    </a>
                                    <a href="disconnect.php" class="media d-flex align-items-center">
                                        <div class="icon icon-shape bg-gradient-dark rounded-circle text-white">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h5 class="heading text-dark mb-md-1"><?php echo _("Déconnexion"); ?></h5>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <a href="login.php" class="btn btn-neutral btn-icon">
                                <span class="nav-link-inner--text"><?php echo _("Connexion"); ?></span>
                            </a>
                        <?php } ?>
                    </li>
                </ul>
                <?php if($connected == true){ ?>
                <ul class="navbar-nav navbar-nav-hover" id="clickme">
                    <li class="nav-item dropdown">
                        <button type="button" class="btn btn-info-bis btn-primary">
                            <i style="padding-right: -10px;" class="fas fa-bell"></i> <span id="count"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-xl">
                            <div class="dropdown-menu-inner">
                                <?php
                                            $rows = $dbReq->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($rows as $row)
                                            {
                                                $list = explode('-', $row['s_date']);

                                                //$dbService = $dbService->getPdo()->prepare('SELECT * FROM service WHERE id=?');
                                                $dbSer->execute([$row['fk_service']]);
                                                $s = $dbSer->fetch();

                                                //$dbPrestation = $dbPrestation->getPdo()->prepare('SELECT * FROM provider WHERE id=?');
                                                $dbPre->execute([$row['fk_provider']]);
                                                $p = $dbPre->fetch();
                                                if($row['status'] == 0) {
                                                    echo '<a class="media d-flex align-items-center">
                                                            <div class="media-body ml-3">
                                                                <h5 class="heading text-primary mb-md-1">' . _("Demande en attente") . '</h5>
                                                                <p class="description d-none d-md-inline-block mb-0" style="margin-right: 70px;">' . _("Votre préstation du") . '<b>' . $list[2] . " " . convertMonth($row['s_date']) . " " . $list[0] . '</b>' . _(" est en attente d\'acceptation par l\'équipe de Flocon Home") . '</b></p>
                                                            </div>
                                                          </a>';
                                                }else if($row['status'] == 1){
                                                    echo '<a href="historic.php" class="media d-flex align-items-center">
                                                            <div class="media-body ml-3">
                                                                <h5 class="heading text-success mb-md-1">' . _("Demande accepté") . '</h5>
                                                                <p class="description d-none d-md-inline-block mb-0" style="margin-right: 70px;">' . _("Votre préstation du ") . '<b>' . $list[2] . ' ' . convertMonth($row['s_date']) . ' ' . $list[0] . '</b>' . _(" a été accepté par le staff de Flocon Home et sera effectué par ") . '<b>' . $p['firstname'] . " " . $p['lastname'] . '</b></p>
                                                            </div>
                                                          </a>';
                                                }else{
                                                    echo '<a class="media d-flex align-items-center">
                                                            <div class="media-body ml-3">
                                                                <h5 class="heading text-warning mb-md-1">' . _("Demande refusé") . '</h5>
                                                                <p class="description d-none d-md-inline-block mb-0" style="margin-right: 70px;">' . _("Votre préstation du ") . '<b>' . $list[2] . ' ' . convertMonth($row['s_date']) . ' ' . $list[0] . '</b>' . _(" a été refusé par l\'équipe de Flocon Home. Vous allez être contacté par téléphone afin de régulariser la situation") . '</b></p>
                                                            </div>
                                                          </a>';
                                                }
                                        }
                                ?>
                                </div>
                            </div>

                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>

<script>

    var element = document.getElementById('clickme');
    var element1 = document.getElementById('clickme');

    element.onmouseover = function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'http://localhost/FloconHome/FloconHome/notification.php?param=update');
        xhr.send(null);
    };

    element1.onmouseleave = function() {
        if (window.XMLHttpRequest) {
            xhrd = new XMLHttpRequest();
        } else {
            xhrd = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xhrd.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("count").innerHTML = this.responseText;
            }
        };
        xhrd.open('GET', 'http://localhost/FloconHome/FloconHome/notification.php?param=count');
        xhrd.send();
    }

    window.onload  = function () {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("count").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "http://localhost/FloconHome/FloconHome/notification.php?param=count");
        xmlhttp.send();
    }
</script>