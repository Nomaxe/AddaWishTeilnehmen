<?php
//Returnt das jetzige Jahr
function getCurrentYear()
{
    $timestamp = time();
    return intval(date("Y",$timestamp));
}

//Zeigt die nächsten Jahre als Option für ein Select an
//Wenn das Parameter-Jahr mit einem der nächsten Jahre passt, wird dieses angezeigt
function showYears($year = null)
{
    $currentYear = getCurrentYear();
    for ($i = $currentYear; $i < $currentYear + 12; $i++)
    {
        if ($i == $year)
            echo '<option value=" '. $i . '" selected="selected"> ' . $i . '</option>';
        else
            echo '<option value="' . $i . '"> ' . $i . '</option>';
    }
}

//Zeigt alle Monate als Option für ein Select an
//Wenn der Parameter-Monat mit einem Monar übereinstimmt, wird dieser angezeigt
function showMonths($month = null)
{
    for ($i = 1; $i < 13; $i++)
    {
        if ($i == $month)
            echo '<option value="' . $i . '" selected="selected">' . getZweistellig($i) . '</option>';
        else
            echo '<option value="' . $i . '">' . getZweistellig($i) . '</option>';
    }
}

function getZweistellig($variable)
{
    return intval($variable / 10) . $variable % 10;
}

function getTeilbetragProzent($erreicht, $ziel, $teilbetrag)
{
    if ($erreicht + $teilbetrag > $ziel)
        return $teilbetrag * 100 / ($erreicht + $teilbetrag) . "%";
    else
        return $teilbetrag * 100 / $ziel . "%";
}