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
                $isLegit = $this->setTrue($isLegit);
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
                $isLegit = array(4);
                $isLegit = $this->setTrue($isLegit);
                $isLegit[0] = $this->isText($object->getVorname());
                $isLegit[1] = $this->isText($object->getNachname());
                $isLegit[2] = $this->isEmail($object->getEmail());
                $isLegit[3] = $this->isEuro($object->getTeilbetrag());

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
        $match = "/(\w+)@(\w+)\.de/";

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

    private function isEuro($variable)
    {
        return is_numeric($variable);
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