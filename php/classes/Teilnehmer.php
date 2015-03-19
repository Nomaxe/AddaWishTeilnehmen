<?php
use Symfony\Component\HttpFoundation\Request;

class Teilnehmer
{
    private $vorname;
    private $nachname;
    private $email;
    private $teilbetrag;

    private $bezahlArt;
    private $paypalId;
    private $ueberweisungInhaber;
    private $ueberweisungNummer;
    private $ueberweisungBLZ;
    private $kreditKarteNummer;
    private $kreditKarteInhaber;
    private $kreditKarteMonat;
    private $kreditKarteJahr;
    private $kreditKartePruefnummer;

    function setData($request, $empholenerTeilbetrag)
    {
        $this->vorname = $request->request->get('vorname');
        $this->nachname = $request->request->get('nachname');
        $this->email = $request->request->get('email');
        $this->teilbetrag = $request->request->get('teilbetrag', $empholenerTeilbetrag);

        $this->bezahlArt = $request->request->get('bezahlart');
        $this->paypalId = $request->request->get('benutzerPaypal');
        $this->ueberweisungInhaber = $request->request->get('inhaberUeberweisung', $this->getName());
        $this->ueberweisungNummer = $request->request->get('nummerUeberweisung');
        $this->ueberweisungBLZ = $request->request->get('blzUeberweisung');
        $this->kreditKarteNummer = $request->request->get('nummerVisa', $request->query->get('nummerMasterCard'));
        $this->kreditKarteInhaber = $request->request->get('inhaberVisa', $request->query->get('inhaberMasterCard'));
        $this->kreditKarteMonat = $request->request->get('ablaufmonatVisa', $request->query->get('ablaufmonatMasterCard'));
        $this->kreditKarteJahr = $request->request->get('ablaufJahrVisa', $request->query->get('ablaufJahrMasterCard'));
        $this->kreditKartePruefnummer = $request->request->get('pruefnummerVisa', $request->query->get('pruefnummerMasterCard'));
    }

    function getVorname()
    {
        return $this->vorname;
    }

    function getNachname()
    {
        return $this->nachname;
    }

    function getName()
    {
        if (!empty($this->vorname) && !empty($this->nachname))
            return $this->vorname . " " . $this->nachname;
        else
            return "";
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

    function getPaypalID()
    {
        return $this->paypalId;
    }

    function getUeberweisungInhaber()
    {
        return $this->ueberweisungInhaber;
    }

    function getUeberweisungNummer()
    {
        return $this->ueberweisungNummer;
    }

    function getUeberweisungBLZ()
    {
        return $this->ueberweisungBLZ;
    }

    function getKreditKarteNummer()
    {
        return $this->kreditKarteNummer;
    }

    function getKreditKarteMonat()
    {
        return $this->kreditKarteMonat;
    }

     function getKreditKarteInhaber()
    {
        return $this->kreditKarteInhaber;
    }

    function getKreditKarteJahr()
    {
        return $this->kreditKarteJahr;
    }

    function getKreditKartePruefnummer()
    {
        return $this->kreditKartePruefnummer;
    }

    function isChecked($bezahlart)
    {
        if ($this->bezahlArt == $bezahlart)
            return 'checked="checked"';
    }
} 