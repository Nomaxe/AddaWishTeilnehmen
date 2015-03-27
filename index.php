<?php
require_once("vendor/autoload.php");
require_once("php/controllers.php");

use Symfony\Component\HttpFoundation\Request;

//Erstelle Symfony-Request-Objekt und lese daraus die Uri aus
$request = Request::createFromGlobals();
$uri = $request->getPathInfo();

//Teste die Uri
if ($uri[0] == '/' && substr_count($uri, '/') <= 2 && strlen($uri) > 1)
{
    //Die Succes Seite
    if (substr_count($uri, '/') == 2 && substr($uri, strlen($uri) - 7, strlen($uri)) == "success")
    {
        //Success und den Slash entfernen, damit der Poolname erreichbar wird
        $uri = substr($uri, 1, strlen($uri) - 9);
        //Ruft die einladen-Funktion von controllers.php auf
        //Später auf den returnten Teilbetrag von Heidelpay ändern!
        //einladen($uri, $request->request->get('PRESENTATION.AMOUNT');
        einladen($uri, 20);
    }
    //Die Error-Seite
    else if (substr_count($uri, '/') == 2)
    {
        //Zeigt die Error-Seite an
        require_once ("templates/error.php");
    }
    //Die normale Teilnehmen-Seite
    else
    {
        //Den Slash entfernen, damit der Poolname erreichbar wird
        $uri = substr($uri, 1, strlen($uri));
        //Ruft die Teilnehmen-Funktion von controllers.php auf
        teilnehmen($uri, $request);
    }
}
else
{
    require_once('templates/wrongInput.php');
}