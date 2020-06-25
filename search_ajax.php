<?php
session_start();
require_once __DIR__ . '/Class/Form.php';
require_once __DIR__ . '/pdo.env';
require_once __DIR__ . '/Form/select_db.php';


$form = new Form($_POST);
$connected = isset($_SESSION['email']) ? true : false;

if(!$connected){
    header('Location: login.php');
    exit;
}

?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description"
              content="Flocon a été développé pour optimiser l'organisation de vos repas au quotidien. Indiquez vos préférences culinaires et il s'occupera du reste !">
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
    <?php include('includes/mep/header.php'); ?>
    <!-- ------ -->
    <main>
        <section class="section section-shaped section-lg">
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
            <div class="container pt-lg-md">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card bg-secondary shadow border-0">
                            <div class="card-header bg-white pb-5">
                                <div class="card-body px-lg-5 py-lg-5">
                                    <div class="text-center text-muted mb-4">
                                        <small>Insérez les informations concernant vos besoins</small>
                                    </div>

                                    <form role="form" method="post" action="funnel/paymentPresta.php">

                                    <input list="show" name="show" class="form-control" onkeyup="showHint(this.value)" />
                                    <datalist id="show">

                                    </datalist>

                                    <div class="form-group">
                                        <label>Date de début : </label>
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-week"></i></span>
                                            </div>
                                            <?php echo $form->input('jj/mm/aaaa', 'Sdate', 'date', 'form-control', '', 'date'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Date de fin : </label>
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-week"></i></span>
                                            </div>
                                            <?php echo $form->input('jj/mm/aaaa', 'Edate', 'date', 'form-control', '', 'date'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Heure de début : </label>
                                        <div class="input-group input-group-alternative mb-3">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>

                                            </div>
                                            <?php echo $form->input('StartTime', 'Stime', 'time', 'form-control', '', ''); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Heure  de fin : </label>
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>

                                            </div>
                                            <?php echo $form->input('EndTime', 'Etime', 'time', 'form-control', '', ''); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <?php echo $form->textArea('description', 'form-control', 'exampleFormControlTextarea1', '3'); ?>
                                        </div>
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

    <script type="text/javascript">

        function showHint(str) {
            var xhttp;
            if (str.length == 0) {
                document.getElementById("show").innerHTML = "";
                return;
            }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("show").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "A-req.php?s="+str, true);
            xhttp.send();
        }

    </script>

    </body>

    </html>

<?php
//}
//header('Location: register.php');
//exit();

?>

<!--
                                        <input list="service" name="service" class="form-control" />
                                        <datalist id="service">
                                            <?php /*
                                            $req = servicePresta();
                                            while ($resultat = $req->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <option value="<?php $resultat['name'] ?>"><?php $resultat['name'] ?></option>
                                            <?php } */?>
                                            </datalist>
                                    </div>
                                    -->

