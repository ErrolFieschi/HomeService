<?php

if(isset($_GET['error'])){
                if($_GET['error'] == 'email_missing'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Email manquant</div>';
                }
                if($_GET['error'] == 'email_format'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Format d\'email incorrecte</div>';
                }
                if($_GET['error'] == 'email_taken'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Adresse email indisponible</div>';
                }
                if($_GET['error'] == 'password_missing'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Mot de passe manquant</div>';
                }
                if($_GET['error'] == 'password_length'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Le mot de passe doit contenir entre 5 et 12 caractères</div>';
                }
                if($_GET['error'] == 'lastname_missing'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Nom manquant</div>';
                }
                if($_GET['error'] == 'firstname_missing'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Prénom manquant</div>';
                }
                if($_GET['error'] == 'captcha_missing'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Captcha manquant</div>';
                }
                if($_GET['error'] == 'captcha_notcorrect'){
                    echo '<div class="alert alert-danger message" role="alert" style="text-align:center;">Captcha incorrecte</div>';
                }
        }
?>