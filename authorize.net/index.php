<?php
include_once './sdk-php/autoload.php';

$live_url = 'https://secure.authorize.net/gateway/transact.dll';
$test_url = 'https://test.authorize.net/gateway/transact.dll';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
  "http://www.w3.org/TR/html4/loose.dtd">
<HTML lang='en'>
<HEAD>
    <TITLE> Sample SIM Implementation </TITLE>
</HEAD>
<BODY>
<form method="post" action="<?php echo $test_url; ?>">
<?php
	$api_login_id 		= '69Bf7cUh8';
	$transaction_key 	= '2na7R3hmUB93WY3R';
	$amount 			= "9.99";
	$description 		= 'item one';
	$fp_sequence 		= "123";
	$time 				= time();
	$invoice 			= '001';
	$testMode 			= TRUE;

	$fingerprint = AuthorizeNetSIM_Form::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $time);
	$sim = new AuthorizeNetSIM_Form(
		array(
		'x_login'         => $api_login_id,
		'x_amount'        => $amount,
		'x_description'	  => $description,
		'x_fp_sequence'   => $fp_sequence,
		'x_fp_hash'       => $fingerprint,
		'x_fp_timestamp'  => $time,
		'x_relay_response'=> TRUE,
		'x_relay_url'	=> 'http://10.0.4.4/rakesh/authorize.net/success.php',
		'x_show_form'	=> 'PAYMENT_FORM',
		'x_invoice_num' => $invoice,
		'x_test_request' => $testMode
		)
	);
	echo $sim->getHiddenFieldString();
?>
	<input type="submit" value="Pay Now">
</form>
</BODY>
</HTML>
