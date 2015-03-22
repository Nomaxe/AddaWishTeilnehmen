<?php
class KreditKarte
{
    private $nummer;
    private $inhaber;
    private $monat;
    private $jahr;
    private $pruefnummer;

    function __construct($nummer, $inhaber, $monat, $jahr, $pruefnummer)
    {
        $this->setData($nummer, $inhaber, $monat, $jahr, $pruefnummer);
    }

    function setData($nummer, $inhaber, $monat, $jahr, $pruefnummer)
    {
        $this->nummer = $nummer;
        $this->inhaber = $inhaber;
        $this->monat = $monat;
        $this->jahr = $jahr;
        $this->pruefnummer = $pruefnummer;
    }

    function getNummer()
    {
        return $this->nummer;
    }

    function getInhaber()
    {
        return $this->inhaber;
    }

    function getMonat()
    {
        return $this->monat;
    }

    function getJahr()
    {
        return $this->jahr;
    }

    function getPruefnummer()
    {
        return $this->pruefnummer;
    }
}