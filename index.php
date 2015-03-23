<?php
require_once("vendor/autoload.php");
require_once("php/controllers.php");

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$uri = $request->getPathInfo();

if ($uri[0] == '/' && substr_count($uri, '/') <= 2 && strlen($uri) > 1)
{
    $success = false;
    $error = false;

    if (substr_count($uri, '/') == 2 && substr($uri, strlen($uri) - 7, strlen($uri)) == "success")
    {
        echo "<h1>Success</h1>";
    }
    else if (substr_count($uri, '/') == 2 && substr($uri, strlen($uri) - 5, strlen($uri)) == "error")
    {
        echo "<h1>Error</h1>";
    }
    else
    {
        $uri = substr($uri, 1, strlen($uri));
        teilnehmen($uri, $request, $success, $error);
    }
}
else
{
    require_once('templates/wrongInput.php');
}