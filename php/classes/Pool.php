<?php
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
    private $teilbetragEmpholen;
    private $ziel;

    function setData($id, $url, $name, $bildPfad, $initiator, $beschreibung, $deadline, $erreicht, $teilbetragEmpholen, $ziel)
    {
        $this->id = $id;
        $this->url = $url;
        $this->name = $name;
        $this->bildPfad = $bildPfad;
        $this->initiator = $initiator;
        $this->beschreibung = $beschreibung;
        $this->deadline = $deadline;
        $this->erreicht = $erreicht;
        $this->teilbetragEmpholen = $teilbetragEmpholen;
        $this->ziel = $ziel;

        $timestamp = time();
        $jetzt = date("j.n.Y G:i:s",$timestamp);
        $sekundenBetween = strtotime($deadline) - strtotime($jetzt);

        if ($sekundenBetween > 0)
        {
            $this->nochTage = $this->getZweistellig(intval($sekundenBetween / 60 / 60 / 24));
            $this->nochStunden = $this->getZweistellig($sekundenBetween / 60 / 60 % 24);
            $this->nochMinuten = $this->getZweistellig($sekundenBetween / 60 % 60);
            $this->nochSekunden = $this->getZweistellig($sekundenBetween % 60);
        }
        else
        {
            $this->nochTage = "00";
            $this->nochStunden = "00";
            $this->nochMinuten = "00";
            $this->nochSekunden = "00";
        }
    }

    function getId()
    {
        return $this->id;
    }

    function getUrl()
    {
        return $this->url;
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

    function getErreichtProzent($teilbetrag)
    {
        if ($this->erreicht + $teilbetrag > $ziel)
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
        return $this->teilbetragEmpholen;
    }

    function getZiel()
    {
        return $this->ziel;
    }

    private function getZweistellig($variable)
    {
        return intval($variable / 10) . $variable % 10;
    }
}