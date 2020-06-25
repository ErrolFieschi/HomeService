<?php
require_once __DIR__ . '/Class/DatabasesManager.php';
require_once __DIR__ . '/pdo.env';


$s = $_REQUEST['s'];

$dbManager = new DatabasesManager();
$req = $dbManager->getPdo()->prepare('SELECT * FROM service WHERE name LIKE "'.$s.'%" AND info  <> 2');
$req->execute([$s]);

if (!empty($s)) {
    while($check = $req->fetch()){
        ?>
        <option value="<?= $check['name']; ?>">
        <?php
    }
}

?>

<script type="text/javascript">

</script>



