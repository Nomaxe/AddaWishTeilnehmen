<?php
require_once ("model.php");
require_once ("helpers.php");
require_once ("classes/Pool.php");
require_once ("classes/Teilnehmer.php");
require_once ("classes/Security.php");
require_once ('classes/KreditKarte.php');

use Symfony\Component\HttpFoundation\Request;

//Die Teilnehmen-Funktion
//Überprüft die nötigen Post-Daten und ruft dann entwerder die Teilnehmen-Seite oder die Heidelpay-Verbindung auf
function teilnehmen($poolurl, $request)
{
    //Sicherheitsüberprüfung
    $security = new Security();
    //Erstellt Pool-Objekt abhängig von der eigegeben URL
    //.Html muss drangehangen werden, da so in der Datenbank gespeichert
    //Das passende Pool-Objekt wird von der Funktion getPoolData returnt (zufinden in der model.php)
    $pool = getPoolData($poolurl . ".html");
    $isLegit = $security->test($pool);

    //Wenn nicht alle Pool-Daten vorhanden
    if (!$isLegit)
    {
        //Ruft die noPool.php-Seite auf
        require_once('templates/noPool.php');
    }
    else
    {
        //Wenn alle Pool-Daten vorhanden, wird ein Teilnehmer-Object erstellt
        $teilnehmer = new Teilnehmer();
        //Teilnehmer-Daten werden in das Objekt geschrieben
        $teilnehmer->setData($request, $pool->getTeilbetrag());
        $isLegit = $security->test($teilnehmer);

        //Wenn die Teilnehmer-Daten in Ordnung sind und auch für die Bezahlmethode alle nötigen Daten eingegeben wurden
        //Rufe die Verbindung für Heidelpay auf
        if ($isLegit)
            require_once("php/heidelpay/hcoFastLane.php");
        //Rufe die Teilnehmen-Seite auf
        else
            require_once("templates/teilnehmen.php");
    }
}

//Wird aufgerufen, wenn die Success-Seite aufgerufen wird
//Speichert die Zahlung in der Datenbank und zeigt dann die Success-Seite an
function einladen ($poolurl, $teilbetrag)
{
    //Sicherheitsüberprüfung
    $security = new Security();
    //Erstellt Pool-Objekt abhängig von der eigegeben URL
    //.Html muss drangehangen werden, da so in der Datenbank gespeichert
    //Das passende Pool-Objekt wird von der Funktion getPoolData returnt (zufinden in der model.php)
    $pool = getPoolData($poolurl . ".html");
    $isLegit = $security->test($pool);

    //Der Test, ob alle Pool-Daten korrekt sind und ob ein gültiger Teilbetrag mitgegeben wurde
    if ($isLegit && $security->isEuro($teilbetrag))
    {
        //Schreibt die Zahlung in die Datenbank
        writeTeilnehmen($poolurl . ".html", $teilbetrag);
        //Zeigt die Success-Seite an
        require_once("templates/success.php");
    }
    //Wenn nicht alle Pool-Daten vorhanden sind oder der Teilbetrag keinem gültigen Format entspricht
    else
    {
        //Zeigt die Error-Seite an
        require_once("templates/error.php");
    }
}