<?php
function getCurrentYear()
{
    $timestamp = time();
    return intval(date("Y",$timestamp));
}

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