<?php

$parameterNameProcessingResult = 'PROCESSING_RESULT';

$processingResult = '';

if ( array_key_exists($parameterNameProcessingResult, $_POST) ) {

	$processingResult = $_POST[$parameterNameProcessingResult];
}

if ($processingResult)
{
	if ( $processingResult == 'ACK' )
	{
		// URL after successful transacvtion (change the URL to YOUR success page: e.g. return to shopping)
		echo 'http://www.example.com/success.html';
	}
	else
	{
		// URL error in transaction (change the URL to YOUR error page)
		echo 'http://www.example.com/error.html';
	}
}

?>