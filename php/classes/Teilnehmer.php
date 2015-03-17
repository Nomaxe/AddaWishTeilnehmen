<?php
class Teilnehmer
{
    private $vorname;
    private $nachname;
    private $email;
    private $teilbetrag;

    function setData($vorname, $nachname, $email, $teilbetrag)
    {
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->email = $email;
        $this->teilbetrag = $teilbetrag;
    }

    function getVorname()
    {
        return $this->vorname;
    }

    function getNachname()
    {
        return $this->nachname;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getTeilbetrag()
    {
        return $this->teilbetrag;
    }

    function getTeilbetragProzent($erreicht, $ziel)
    {
        if ($erreicht + $this->teilbetrag > $ziel)
            return $this->teilbetrag * 100 / ($erreicht + $this->teilbetrag) . "%";
        else
            return $this->teilbetrag * 100 / $ziel . "%";
    }
} 