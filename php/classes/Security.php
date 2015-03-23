<?php
class Security
{
    function test($object)
    {
        if (is_object($object))
        {
            if (is_a($object, "Pool"))
            {
                $isLegit = array(13);
                $isLegit[0] = $this->isNumber($object->getId());
                $isLegit[1] = $this->isUrl($object->getUrl());
                $isLegit[2] = $this->isText($object->getName());
                $isLegit[3] = $this->isPath($object->getBildPfad());
                $isLegit[4] = $this->isName($object->getInitiator());
                $isLegit[5] = $this->isText($object->getBeschreibung());
                $isLegit[6] = $this->isNumber($object->getTage());
                $isLegit[7] = $this->isNumber($object->getStunden());
                $isLegit[8] = $this->isNumber($object->getMinuten());
                $isLegit[9] = $this->isNumber($object->getSekunden());
                $isLegit[10] = $this->isEuro($object->getErreicht());
                $isLegit[11] = $this->isEuro($object->getTeilbetrag());
                $isLegit[12] = $this->isEuro($object->getZiel());

                return $this->trueTest($isLegit);
            }
            else if (is_a($object, "Teilnehmer"))
            {
                $isLegit = array(10);
                $isLegit = $this->setTrue($isLegit);
                $isLegit[0] = $this->isText($object->getVorname());
                $isLegit[1] = $this->isText($object->getNachname());
                $isLegit[2] = $this->isEmail($object->getEmail());
                $isLegit[3] = $this->isEuro($object->getTeilbetrag());
                $isLegit[4] = $this->isText($object->getBezahlart());

                if ($object->getBezahlart() == 'sofortueberweisung')
                {
                    $isLegit[5] = $this->isName($object->getUeberweisungInhaber());
                    $isLegit[6] = $this->isNumber($object->getUeberweisungNummer());
                    $isLegit[7] = $this->isNumber($object->getUeberweisungBLZ());
                }
                else if ($object->getBezahlart() == 'visa')
                {
                    $visa = $object->getVisa();
                    $isLegit[5] = $this->isNumber($visa->getNummer());
                    $isLegit[6] = $this->isName($visa->getInhaber());
                    $isLegit[7] = $this->isMonth($visa->getMonat());
                    $isLegit[8] = $this->isYear($visa->getJahr());
                    $isLegit[9] = $this->isNumber($visa->getPruefnummer());
                }
                else if ($object->getBezahlart() == 'mastercard')
                {
                    $mastercard = $object->getMasterCard();
                    $isLegit[5] = $this->isNumber($mastercard->getNummer());
                    $isLegit[6] = $this->isName($mastercard->getInhaber());
                    $isLegit[7] = $this->isMonth($mastercard->getMonat());
                    $isLegit[8] = $this->isYear($mastercard->getJahr());
                    $isLegit[9] = $this->isNumber($mastercard->getPruefnummer());
                }
                else if ($object->getBezahlart() != 'paypal')
                {
                    return false;
                }

                return $this->trueTest($isLegit);
            }
        }
        return false;
    }

    private function isName($variable)
    {
        $match = "((\w+) (\w+))";
        return preg_match_all($match, $variable);
    }

    private function isText($variable)
    {
        return !empty($variable);
    }

    private function isEmail($variable)
    {
        $match = "/(\w+)@(\w+)\.(\w)/";

        return preg_match_all($match, $variable);
    }

    private function isUrl($variable)
    {
        $match = "([0-9a-zA-Z]-(\d+)\.(html))";
        return preg_match_all($match, $variable);
    }

    private function isPath($variable)
    {
        $match = "((/(\w+))*)";
        return preg_match_all($match, $variable);
    }

    private function isNumber($variable)
    {
        return is_numeric($variable);
    }

    private function isMonth($variable)
    {
        return $this->isNumber($variable) && $variable % 1 == 0 && $variable > 0 && $variable < 13;
    }

    private function isYear($variable)
    {
        return $this->isNumber($variable) && $variable % 1 == 0;
    }

    private function isEuro($variable)
    {
        return is_numeric($variable) && $variable * 100 % 1 == 0;
    }

    private function setTrue($array)
    {
        if (is_array($array))
        {
            for ($i = 0; $i < count($array); $i++)
            {
                $array[$i] = true;
            }
            return $array;
        }
        return null;
    }

    private function trueTest($array)
    {
        if (is_array($array))
        {
            for ($i = 0; $i < count($array); $i++)
            {
                if (!$array[$i])
                {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
} 