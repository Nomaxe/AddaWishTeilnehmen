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
    private $visa;
    private $mastercard;

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

        $this->visa = new KreditKarte($request->request->get('nummerVisa'),
                                      $request->request->get('inhaberVisa'),
                                      $request->request->get('ablaufmonatVisa'),
                                      $request->request->get('ablaufJahrVisa'),
                                      $request->request->get('pruefnummerVisa'));

        $this->mastercard = new KreditKarte($request->request->get('nummerMasterCard'),
                                            $request->request->get('inhaberMasterCard'),
                                            $request->request->get('ablaufmonatMasterCard'),
                                            $request->request->get('ablaufJahrMasterCard'),
                                            $request->request->get('pruefnummerMasterCard'));
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

    function isChecked($bezahlart)
    {
        if ($this->bezahlArt == $bezahlart)
            return 'checked="checked"';
    }

    function setHeidelpayData($parameters)
    {
        if ($this->bezahlArt == 'paypal')
        {
            $parameters['PAYMENT.CODE'] = "VA.DB";
            $parameters['ACCOUNT.BRAND'] = "PAYPAL";
        }
        else if ($this->bezahlArt == 'sofortueberweisung')
        {
            $parameters['PAYMENT.CODE'] = "OT.BA";
            $parameters['ACCOUNT.HOLDER'] = $this->getUeberweisungInhaber();
            $parameters['ACCOUNT.BANKNAME'] = "osnfosdf";
            $parameters['ACCOUNT.BANK'] = $this->getUeberweisungBLZ();
            $parameters['ACCOUNT.IBAN'] = $this->getUeberweisungNummer();
            $parameters['ACCOUNT.BIC'] = "12345678";
        }
        else if ($this->bezahlArt == 'visa')
        {
            $parameters['PAYMENT.CODE'] = "CC.RG";
            $parameters['ACCOUNT.HOLDER'] = $this->visa->getInhaber();
            $parameters['ACCOUNT.BRAND'] = "VISA";
            $parameters['ACCOUNT.NUMBER'] = $this->visa->getNummer();
            $parameters['ACCOUNT.EXPIRY_MONTH'] = "09";
            $parameters['ACCOUNT.EXPIRY_YEAR'] = "2015";
            $parameters['ACCOUNT.VERIFICATION'] = $this->visa->getPruefnummer();
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
        }

        return $parameters;
    }
} 