<?php
use Symfony\Component\HttpFoundation\Request;
//this page is called after the customer finishes
//payment with the Web Payment Frontend.
//It must be hosted YOUR system and accessible
//to the outside world.
//It always must respond with a URL that defines
//which page the WPF should redirect to.
//this new page also MUST be hosted on your system
//AND it musst be accessible so that the WPF can
//redirect the users browser to it.
// PROCESSING.RESULT gets PROCESSING_RESULT when posting back (URL encoding)
$returnvalue=$_POST['PROCESSING_RESULT'];
if ($returnvalue)
{
    if (strstr($returnvalue,"ACK"))
    {
        // URL after successful transacvtion (change the URL to YOUR success page: e.g. return to shopping)
        require_once ('../model.php');
        $request = Request::createFromGlobals();
        writeTeilnehmen($request);



        print "http://192.168.10.130/teilnehmen/horst-2133155758508/success";
    }
    else
    {
        // URL error in transaction (change the URL to YOUR error page)
        print "http://192.168.10.130/teilnehmen/horst-2133155758508/error";
    }
}
?>
