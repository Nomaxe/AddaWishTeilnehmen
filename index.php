<?php
require_once("vendor/autoload.php");
require_once("php/controllers.php");

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$uri = $request->getPathInfo();

if ($uri[0] == '/' && substr_count($uri, '/') == 1 && strlen($uri) > 1)
{
    teilnehmen(substr($uri, 1, strlen($uri) - 1), $request);
}
else
{
    require_once('templates/wrongInput.php');
}