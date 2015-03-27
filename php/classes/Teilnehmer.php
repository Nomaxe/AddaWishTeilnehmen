<?php
use Symfony\Component\HttpFoundation\Request;

//Die Teilnehmer-Klasse
//Speichert alle Daten über dein Teilnehmer ab

class Teilnehmer
{
    private $vorname;
    private $nachname;
    private $email;
    private $teilbetrag;

    private $bezahlArt;
    private $ueberweisungInhaber;
    private $ueberweisungNummer;
    private $ueberweisungBLZ;
    private $visa;
    private $mastercard;

    //Weist alle Daten dem Objekt zu
    //$request              Das Request Object von Symfony, um an alle Post-Parameter zu kommen
    //$teilbetragEmpholen   Der vo Initiator empholenen Teilbetrag
    function setData($request, $empholenerTeilbetrag)
    {
        //Daten werden zugewiesen
        $this->vorname = $request->request->get('vorname');
        $this->nachname = $request->request->get('nachname');
        $this->email = $request->request->get('email');
        //Weißt den Teilbetrag zu, falls der nicht gegeben ist, wird der vom Initiator eompholene Teilbetrag genommen
        $this->teilbetrag = $request->request->get('teilbetrag', $empholenerTeilbetrag);

        //Weißt die gewählte Bezahlart zu
        $this->bezahlArt = $request->request->get('bezahlart');
        //Weißt die Daten für die Sofortüberweisung zu
        $this->ueberweisungInhaber = $request->request->get('inhaberUeberweisung', $this->getName());
        $this->ueberweisungNummer = $request->request->get('nummerUeberweisung');
        $this->ueberweisungBLZ = $request->request->get('blzUeberweisung');

        //Weißt die Daten für Visa zu
        $this->visa = new KreditKarte($request->request->get('nummerVisa'),
                                      $request->request->get('inhaberVisa'),
                                      $request->request->get('ablaufmonatVisa'),
                                      $request->request->get('ablaufJahrVisa'),
                                      $request->request->get('pruefnummerVisa'));

        //Weißt die Daten für MasterCard zu
        $this->mastercard = new KreditKarte($request->request->get('nummerMasterCard'),
                                            $request->request->get('inhaberMasterCard'),
                                            $request->request->get('ablaufmonatMasterCard'),
                                            $request->request->get('ablaufJahrMasterCard'),
                                            $request->request->get('pruefnummerMasterCard'));
    }

    //Getters
    function getVorname()
    {
        return $this->vorname;
    }

    function getNachname()
    {
        return $this->nachname;
    }

    //Returnt den Namen (Vorname Nachname)
    //Wenn kein Name gegeben ist, wird ein Leerstring returnt
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

    //Gibt den Teilbetrag als Prozent-Wert aus
    function getTeilbetragProzent($erreicht, $ziel)
    {
        if ($erreicht + $this->teilbetrag > $ziel)
            return $this->teilbetrag * 100 / ($erreicht + $this->teilbetrag) . "%";
        else
            return $this->teilbetrag * 100 / $ziel . "%";
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

    function getVisa()
    {
        return $this->visa;
    }

    function getMasterCard()
    {
        return $this->mastercard;
    }

    function getBezahlart()
    {
        return $this->bezahlArt;
    }

    //Überprüft ob die als Paramter gewählte Bezahlart der Bezahlart entspricht
    //Falls ja, wird ckecked zurückgeben, damit der Radio-Button ausgewählt bleibt
    function isChecked($bezahlart)
    {
        if ($this->bezahlArt == $bezahlart)
            return 'checked="checked"';
    }

    //Gibt an Heidelpay die nötigen Daten, jenachdem welche Bezahlart gewählt wurde
    function setHeidelpayData($parameters)
    {
        if ($this->bezahlArt == 'paypal')
        {
            $parameters['PAYMENT.CODE'] = "VA.DB";
            $parameters['ACCOUNT.BRAND'] = "PAYPAL";
            $parameters['FRONTEND.ENABLED'] = "true";
        }
        else if ($this->bezahlArt == 'sofortueberweisung')
        {
            $parameters['PAYMENT.CODE'] = "OT.BA";
            $parameters['ACCOUNT.HOLDER'] = $this->getUeberweisungInhaber();
            $parameters['ACCOUNT.BANKNAME'] = "osnfosdf";
            $parameters['ACCOUNT.BANK'] = $this->getUeberweisungBLZ();
            $parameters['ACCOUNT.IBAN'] = $this->getUeberweisungNummer();
            $parameters['ACCOUNT.BIC'] = "12345678";
            $parameters['FRONTEND.ENABLED'] = "true";
        }
        else if ($this->bezahlArt == 'visa')
        {
            $parameters['PAYMENT.CODE'] = "CC.RG";
            $parameters['ACCOUNT.HOLDER'] = $this->visa->getInhaber();
            $parameters['ACCOUNT.BRAND'] = "VISA";
            $parameters['ACCOUNT.NUMBER'] = $this->visa->getNummer();
            $parameters['ACCOUNT.EXPIRY_MONTH'] = $this->visa->getMonat();
            $parameters['ACCOUNT.EXPIRY_YEAR'] = $this->visa->getJahr();
            $parameters['ACCOUNT.VERIFICATION'] = $this->visa->getPruefnummer();
            $parameters['FRONTEND.ENABLED'] = "true";
        }
        else if ($this->bezahlArt == 'mastercard')
        {
            $parameters['PAYMENT.CODE'] = "CC.RG";
            $parameters['ACCOUNT.HOLDER'] = $this->mastercard->getInhaber();
            $parameters['ACCOUNT.BRAND'] = "MASTERCARD";
            $parameters['ACCOUNT.NUMBER'] = $this->mastercard->getNummer();
            $parameters['ACCOUNT.EXPIRY_MONTH'] = $this->mastercard->getMonat();
            $parameters['ACCOUNT.EXPIRY_YEAR'] = $this->mastercard->getJahr();
            $parameters['ACCOUNT.VERIFICATION'] = $this->mastercard->getPruefnummer();
            $parameters['FRONTEND.ENABLED'] = "true";
        }

        return $parameters;
    }
} 