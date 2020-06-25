<?php
require "Class/DatabasesManager.php";

class Events
{
    public function getEventsBetween($start, $end){
        $dbRequest = new DatabasesManager();
        $dbRequest = $dbRequest->getPdo()->prepare("SELECT * FROM prestation WHERE status = 1 AND s_date BETWEEN '{$start->format('Y-m-d')}'  AND '{$end->format('Y-m-d')}' AND fk_account = ?");
        $dbRequest->execute([$_SESSION['id']]);
        $results = $dbRequest->fetchAll();

        return $results;
    }

    public function getEventsInfo($id){
        $dbInfo = new DatabasesManager();
        $dbInfo = $dbInfo->getPdo()->prepare("SELECT description FROM prestation WHERE id = ?");
        $dbInfo->execute([$id]);
        $results = $dbInfo->fetchAll();

        return $results;
    }

    public function getEventsUser($id){
        $dbUser = new DatabasesManager();
        $dbUser = $dbUser->getPdo()->prepare("SELECT lastname, firstname, address, city, postal_code FROM account WHERE id = ?");
        $dbUser->execute([$id]);
        $results = $dbUser->fetchAll();

        return $results;
    }

    public function getEventsProvider($id){
        $dbProvider = new DatabasesManager();
        $dbProvider = $dbProvider->getPdo()->prepare("SELECT firstname, lastname FROM provider WHERE id = ?");
        $dbProvider->execute([$id]);
        $results = $dbProvider->fetchAll();

        return $results;
    }

    public function getEventsBetweenByDay($start, $end){
        $events = $this->getEventsBetween($start, $end);
        $days = [];

        foreach ($events as $event){
            $date = $event['s_date'];

            if(!isset($days[$date])){
                $days[$date] = [$event];
            }else{
                $days[$date][] = $event;
            }
        }
        return $days;
    }
}