<?php
require_once ("model.php");
require_once ("classes/Pool.php");
require_once ("classes/Teilnehmer.php");
require_once ("classes/Security.php");

use Symfony\Component\HttpFoundation\Request;

function teilnehmen($poolurl, $request)
{
    $security = new Security();
    $pool = getPoolData($poolurl . ".html");
    $isLegit = $security->test($pool);

    if (!$isLegit)
    {
        require_once('templates/noPool.php');
    }
    else
    {
        $teilnehmer = new Teilnehmer();
        $teilnehmer->setData($request->request->get('vorname'), $request->request->get('nachname'), $request->request->get('email'), $request->request->get('teilbetrag', $pool->getTeilbetrag()));

        require_once("templates/teilnehmen.php");
    }
}