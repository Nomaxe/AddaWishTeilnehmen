<?php
/*
 * HCO testsystem gateway url
 */
$url = "https://test-heidelpay.hpcgw.net/sgw/gtwu";

/*
 * Authentifizierung (kein Zugangsdaten zum Liveaccount) 
 */
$parameters['SECURITY.SENDER'] 				= "31HA07BC810C91F08643A5D477BDD7C0";
$parameters['USER.LOGIN'] 					= "31ha07bc810c91f086431f7471d042d6";
$parameters['USER.PWD'] 					= "password";
$parameters['TRANSACTION.CHANNEL'] 			= "31HA07BC810C91F086433734258F6628";
$parameters['TRANSACTION.MODE'] 			= "CONNECTOR_TEST";

/*
 * Betrag, Währung und Abbuchungstext
 */
$parameters['IDENTIFICATION.TRANSACTIONID'] = 'Kunden- und / oder Bestellnummer';
$parameters['PRESENTATION.USAGE'] 			= 'Abbuchungstext auf Lastschrift';
$parameters['PAYMENT.CODE'] 				= "CC.DB";
$parameters['PRESENTATION.AMOUNT'] 			= 1.99;
$parameters['PRESENTATION.CURRENCY'] 		= "EUR";

/*
 * Steuerung des Bezahlformulars
 */
$parameters['FRONTEND.MODE'] 				= "DEFAULT";
$parameters['FRONTEND.ENABLED'] 			= "true";
$parameters['FRONTEND.POPUP'] 				= "false";
$parameters['FRONTEND.REDIRECT_TIME'] 		= "0";
$parameters['FRONTEND.LANGUAGE_SELECTOR'] 	= "false";
$parameters['FRONTEND.LANGUAGE'] 			= "de";
$parameters['FRONTEND.CSS_PATH'] 			= "https://test-heidelpay.hpcgw.net/sgw/css/hcoFastLane.css";
// dies muss der Händler setzen
$parameters['FRONTEND.RESPONSE_URL'] 		=  'http://localhost/teilnehmen/index.php/';

/*
 * Kundendaten
 */
$parameters['NAME.GIVEN'] 					= "Test";
$parameters['NAME.FAMILY'] 					= "Developer";
$parameters['ADDRESS.STREET'] 				= "Demostraße";
$parameters['ADDRESS.ZIP'] 					= "12345";
$parameters['ADDRESS.CITY'] 				= "Heidelberg";
$parameters['ADDRESS.COUNTRY'] 				= "DE";
$parameters['ADDRESS.STATE'] 				= "DE8";
$parameters['CONTACT.EMAIL'] 				= "example@example.com";

/*
 * Versionierung des Skripts
 */
$parameters['REQUEST.VERSION'] 				= "1.0";

/*
* check response url
*/
if ($parameters['FRONTEND.RESPONSE_URL']) 
{
	/*
	 * Generiere request String
	 */
	$nameValueArray = array();
	foreach ($parameters AS $key => $value) {
		$nameValuePair = strtoupper($key).'='.urlencode($value);
		array_push($nameValueArray, $nameValuePair);
	}
	$keyValStr = stripslashes(implode('&', $nameValueArray));

	/*
	 * Sende request via curl
	 */
	$cpt = curl_init();
	curl_setopt($cpt, CURLOPT_URL, $url);
	curl_setopt($cpt, CURLOPT_USERAGENT, "hcoCall");
	curl_setopt($cpt, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($cpt, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($cpt, CURLOPT_POST, 1);
	curl_setopt($cpt, CURLOPT_POSTFIELDS, $keyValStr);
	curl_setopt($cpt, CURLOPT_RETURNTRANSFER, 1);

	$curlResultString 	= curl_exec($cpt);
	$curlerror 			= curl_error($cpt);
	$curlinfo 			= curl_getinfo($cpt);
	curl_close($cpt);

	$curlResponseArrayTmp  	= explode("&",$curlResultString);
	$curlResponseArray 		= array();

	foreach($curlResponseArrayTmp AS $responseKeyValPair)
	{
		$temp = urldecode($responseKeyValPair);
		$temp = preg_split("#=#",$temp,2);

		if (array_key_exists(0, $temp) && $temp[0]) {

			$responseKey = $temp[0];
			$responseValue = 'NO VALUE FOUND';
			if ( array_key_exists('1', $temp) ) {
				$responseValue = $temp[1];
			}
			$curlResponseArray[$responseKey]=$responseValue;
		}
	}

	/*
	 * Überprüfe, ob der hCO Request gültig ist
	 */
	$processingResultValue = '';
	if ( array_key_exists('POST.VALIDATION', $curlResponseArray) ) {
		$processingResultValue = $curlResponseArray['POST.VALIDATION'];
	}

	/*
	 * Überprüfe, ob die URL des Bezahlformulars zurückgegeben wird
	 */
	$redirectUrlKey = 'FRONTEND.REDIRECT_URL';
	$redirectUrlValue = '';
	if (array_key_exists($redirectUrlKey, $curlResponseArray)) {
		$redirectUrlValue = $curlResponseArray[$redirectUrlKey];
	}

	if ($processingResultValue == "ACK")
	{
		if (strstr($redirectUrlValue, "http"))
		{
			$paymentForm = '';
			$paymentForm .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
			$paymentForm .= '<html lang="en">';
			$paymentForm .= '    <head>';
			$paymentForm .= '        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">';
			$paymentForm .= '        <title>PAY</title>';
			$paymentForm .= '        <style type="text/css" media="screen">';
			$paymentForm .= '            body {';
			$paymentForm .= '                background-color: #f6f6f6;';
			$paymentForm .= '            }';
			$paymentForm .= '            iframe {';
			$paymentForm .= '                align: center;';
			$paymentForm .= '                height: 480px;';
			$paymentForm .= '                width: 480px;';
			$paymentForm .= '                overflow: hidden;';
			$paymentForm .= '            }';
			$paymentForm .= '        </style>';
			$paymentForm .= '    </head>';
			$paymentForm .= '    <body>';
			$paymentForm .= '        <iframe src="'.$redirectUrlValue.'" frameborder="0">Your Browser doesn\'t support iFrames</iframe>';
			$paymentForm .= '    </body>';
			$paymentForm .= '</html>';

			echo $paymentForm;
		}
		else
		{
			echo 'no redirect url found in curl response';
			print_r($curlResponseArray);
		}
	}
	else
	{
		echo 'processing result nok';
		print_r($curlResponseArray);
	}
}
else
{
echo 'Bitte setzen Sie ihre FRONTEND.RESPONSE_URL in diesem Skript (Zeile 39)! ';
}
?>