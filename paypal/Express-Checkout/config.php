<?php

  //start session in all pages
  if (session_status() == PHP_SESSION_NONE) { session_start(); } //PHP >= 5.4.0
  //if(session_id() == '') { session_start(); } //uncomment this line if PHP < 5.4.0 and comment out line above

	// sandbox or live
	define('PPL_MODE', 'sandbox');

	if(PPL_MODE=='sandbox'){
		
		define('PPL_API_USER', 'info.seanrock-facilitator_api1.gmail.com');
		define('PPL_API_PASSWORD', 'FR6UGFUXW8WTD2DQ');
		define('PPL_API_SIGNATURE', 'AFcWxV21C7fd0v3bYYYRCpSSRl31AUYryt8JZ4rcbUtf61ZAsw8JimaW');
	}
	else{
		
		define('PPL_API_USER', 'somepaypal_api.yahoo.co.uk');
		define('PPL_API_PASSWORD', '123456789');
		define('PPL_API_SIGNATURE', 'opupouopupo987kkkhkixlksjewNyJ2pEq.Gufar');
	}
	
	define('PPL_LANG', 'EN');
	
	define('PPL_LOGO_IMG', 'https://www.smartprac.com/dev/images/SmartPrac-Logo-02.svg');
	
	define('PPL_RETURN_URL', 'http://localhost/payment_gatways/paypal/Express-Checkout/process.php');
	define('PPL_CANCEL_URL', 'http://localhost/payment_gatways/paypal/Express-Checkout/cancel_url.php');

	define('PPL_CURRENCY_CODE', 'EUR');


/* Buyer Email :
 * info.seanrock-buyer@gmail.com
 * 
 * Credit Card Number
 * 4032030460472146
 * VISA
 * 06/2021
 * */
