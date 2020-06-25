<?php

function convertDate($date) {

	$jour_semaine = array(1=>"LUNDI", 2=>"MARDI", 3=>"MERCREDI", 4=>"JEUDI", 5=>"VENDREDI", 6=>"SAMEDI", 7=>"DIMANCHE");

	list($annee, $mois, $jour) = explode ("-", $date);

	$timestamp = mktime(0,0,0, date($mois), date($jour), date($annee));
	$njour = date("N",$timestamp);

	return $jour_semaine[$njour];

}

function convertMonth($date){
	$list = explode("-", $date);
	$date = 'empty';

	if($list[1] == '01'){
		$date='JANVIER';
	}elseif($list[1] == '02'){
		$date='FEVRIER';
	}elseif($list[1] == '03'){
		$date='MARS';
	}elseif($list[1] == '04'){
		$date='AVRIL';
	}elseif($list[1] == '05'){
		$date='MAI';
	}elseif($list[1] == '06'){
		$date='JUIN';
	}elseif($list[1] == '07'){
		$date='JUILLET';
	}elseif($list[1] == '08'){
		$date='AOUT';
	}elseif($list[1] == '09'){
		$date='SEPTEMBRE';
	}elseif($list[1] == '10'){
		$date='OCTOBRE';
	}elseif($list[1] == '11'){
		$date='NOVEMBRE';
	}elseif($list[1] == '12'){
		$date='DECEMBRE';
	}
	return $date;
}

function convertDigit($date){

    if($date == '01'){
        $date='JANVIER';
    }elseif($date == '02'){
        $date='FEVRIER';
    }elseif($date == '03'){
        $date='MARS';
    }elseif($date == '04'){
        $date='AVRIL';
    }elseif($date == '05'){
        $date='MAI';
    }elseif($date == '06'){
        $date='JUIN';
    }elseif($date == '07'){
        $date='JUILLET';
    }elseif($date == '08'){
        $date='AOUT';
    }elseif($date == '09'){
        $date='SEPTEMBRE';
    }elseif($date == '10'){
        $date='OCTOBRE';
    }elseif($date == '11'){
        $date='NOVEMBRE';
    }elseif($date == '12'){
        $date='DECEMBRE';
    }
    return $date;
}

?>