<?php

echo $s_date = "2020-03-26 14:30:00";
echo $end_date = "2020-03-27 17:00:00";

//<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

echo "<br>";
echo time();
echo "<br>";
echo" timestamp aujourd'hui            " .  $date_ajd =  strtotime("now");
echo "<br>";
echo "<br>";
echo " +60 timestamp aujourd'hui " . $date_ajd ;
echo "<br>";
echo "<br>";
echo" date aujourd'hui " .  date("Y-m-d H:i:s" ,strtotime(1588454004));
echo "<br>";
echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";


echo date("d-m-Y", strtotime($s_date));



echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";
echo " VOICI MA DATE D'ESSAI DATETIME " . date("Y-m-d H:i:s" ,strtotime(40400833190000));
echo "<br>";
echo "<br>";
$datetime1 = new DateTime('2009-10-11 14:00:00');
$datetime2 = new DateTime('2009-10-13 17:00:00');
$interval = $datetime1->diff($datetime2);
echo $interval->format('%HH%a days');
echo "<br>";
echo "<br>";
?>

//SELECT DATE_ADD(CAST(s_date as datetime) , INTERVAL start_time HOUR_SECOND), DATE_ADD(CAST(end_date as datetime) , INTERVAL end_time HOUR_SECOND) FROM prestation;

<?php
if(strtotime($s_date) > strtotime($end_date)){
    echo "La date de fin est superieur a la date de commencement";
    }
else{
    echo "Les dates choisis sont bonnes";
}

$start_date = "26/03/2020 11:00"; //s_date
$end_date = "27/03/2020 12:30"; //end_date

$debut = "26/03/2020 10:00";
$fin ="27/03/2020 13:00";

echo "<br>";


$date = new DateTime('now');
$date->add(new DateInterval('PT2H'));
echo strtotime($date->format('d/m/Y H:i:s')) . "\n";

echo "<br>";

if (strtotime($date->format('d/m/Y H:i:s')) < strtotime($s_date)) {

    echo " La date de début est inferieur a la date actuelle !";
}
else{
    echo "OK";
}
?>
</body>
















