<?php
class Month{

    public $days = ['Lundi', 'Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    public $month;
    public $year;
    /**
     * month constructor. mois compris entre 1 et 12
     */
    public function __construct($month = null, $year = null)
    {
        if($month === null || $month < 1 || $month >12){
            $month = (int)date('m');
        }

        if($year === null){
            $year = (int)date('Y');
        }
//        $month = $month % 12;
        $this->month = $month;
        $this->year = $year;
    }

    public function getStartingDay(){
        return new DateTimeImmutable("{$this->year}-{$this->month}-01");
    }

    public function toString(){
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    public function getWeeks(){
        $start = $this->getStartingDay();
        $end = $start->modify('+ 1 month - 1 day');
        $startWeek = (int)$start->format('W');
        $endWeek = (int)$end->format('W');

        if($endWeek === 1){
            $endWeek = (int)$end->modify('- 7 days')->format('W') + 1;
        }

        $weeks = $endWeek - $startWeek + 1;

        if($weeks < 0){
            $weeks = (int)$end->format('W');
        }
        return $weeks;
    }

    public function withinMonth($date){
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    public function nextMonth(){
        $month = $this->month + 1;
        $year = $this->year;
        if($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    public function previousMonth(){
        $month = $this->month - 1;
        $year = $this->year;
        if($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }


}