<?php
//Die Pool-Klasse
//Speichert alle Daten für den Pool

class Pool
{
    private $id;
    private $url;
    private $name;
    private $bildPfad;
    private $initiator;
    private $beschreibung;
    private $deadline;
    private $nochTage;
    private $nochStunden;
    private $nochMinuten;
    private $nochSekunden;
    private $erreicht;
    private $teilbetragEmpfohlen;
    private $ziel;

    //Schreibt alle Daten in das Pool-Objekt
    //$id                   ID des Pools
    //$url                  Url des Pool
    //$name                 Name / Titel des Pools
    //$bildPfad             Pfad zum Bild des Pools, immoment der Pfad zum Bild des gewählten Produktes
    //$initiator            Name des Initiators
    //$beschreibung         Beschreibung des Pools
    //&deadline             Die Deadline als Datum (Muss für die date-Klasse von php als Datum erkennbar sein)
    //$erreicht             Der momentan erreichte Betrag
    //$teilbetragEmpfohlen   Der vom Initiator empholenen Teilbetrag
    //$ziel                 Der gewünschte Ziel-Betrag
    function setData($id, $url, $name, $bildPfad, $initiator, $beschreibung, $deadline, $erreicht, $teilbetragEmpholen, $ziel)
    {
        //Schreibt die Daten in das Pool-Objekt
        $this->id = $id;
        $this->url = $url;
        $this->name = $name;
        $this->bildPfad = $bildPfad;
        $this->initiator = $initiator;
        $this->beschreibung = $beschreibung;
        $this->deadline = $deadline;
        $this->erreicht = $erreicht;
        $this->teilbetragEmpfohlen = $teilbetragEmpholen;
        $this->ziel = $ziel;

        //Generiert jetzige Datm
        $timestamp = time();
        $jetzt = date("j.n.Y G:i:s",$timestamp);
        //Wandelt die beiden Daten in die Systemsekunden um und diese miteinander zu verrechnen
        //Bekomme die Sekunden zwischen diesen beiden Daten
        $sekundenBetween = strtotime($deadline) - strtotime($jetzt);

        //Wenn noch Zeit übrig ist
        if ($sekundenBetween > 0)
        {
            $this->nochTage = $this->getZweistellig(intval($sekundenBetween / 60 / 60 / 24));
            $this->nochStunden = $this->getZweistellig($sekundenBetween / 60 / 60 % 24);
            $this->nochMinuten = $this->getZweistellig($sekundenBetween / 60 % 60);
            $this->nochSekunden = $this->getZweistellig($sekundenBetween % 60);
        }
        //Wenn keine Zeit mehr übrig ist
        else
        {
            $this->nochTage = "00";
            $this->nochStunden = "00";
            $this->nochMinuten = "00";
            $this->nochSekunden = "00";
        }
    }

    //Getters
    function getId()
    {
        return $this->id;
    }

    function getUrl()
    {
        return $_SERVER['SERVER_NAME'] . "/teilnehmen/index.php/" . substr($this->url, 0, strlen($this->url) - 5);
    }

    function getName()
    {
        return $this->name;
    }

    function getBildPfad()
    {
        return $this->bildPfad;
    }

    function getInitiator()
    {
        return $this->initiator;
    }

    function getBeschreibung()
    {
        return $this->beschreibung;
    }

    function getTage()
    {
        return $this->nochTage;
    }

    function getStunden()
    {
        return $this->nochStunden;
    }

    function getMinuten()
    {
        return $this->nochMinuten;
    }

    function getSekunden()
    {
        return $this->nochSekunden;
    }

    function getErreicht()
    {
        return $this->erreicht;
    }

    //Erzeugt wieviel Prozent schon erreicht ist
    //Wenn Teilbetrag und der momentan erreichte Betrag höher als der Ziel-Betrag sind, wird dieser Wert als 100% genommen
    function getErreichtProzent($teilbetrag)
    {
        if ($this->erreicht + $teilbetrag > $this->ziel)
            return $this->erreicht * 100 / ($this->erreicht + $teilbetrag) . "%";
        else
            return $this->erreicht * 100 / $this->ziel . "%";
    }

    function getErreichtEuro()
    {
        return $this->erreicht . "€";
    }

    function getTeilbetrag()
    {
        return $this->teilbetragEmpfohlen;
    }

    function getZiel()
    {
        return $this->ziel;
    }

    //Erzeugt den Prozent-Wert vom Zielbetrag
    function getZielProzent($teilbetrag)
    {
        if ($this->erreicht + $teilbetrag > $this->ziel)
            return $this->ziel * 100 / ($this->erreicht + $teilbetrag) . "%";
        else
            return "100%";
    }

    //Returnt die eingegebe Zahl zweistellig
    private function getZweistellig($variable)
    {
        return intval($variable / 10) . $variable % 10;
    }
}