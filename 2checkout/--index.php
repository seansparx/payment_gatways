<?php
	require_once("2checkout/lib/Twocheckout.php");
	
	Twocheckout::privateKey('745E51DF-218E-44FA-AABB-C3FFD0B0D694');
	Twocheckout::sellerId('901299003');

	try {
		$charge = Twocheckout_Charge::auth(array(
			"sellerId" => "901299003",
			"merchantOrderId" => "123",
			"token" => 'MjFiYzIzYjAtYjE4YS00ZmI0LTg4YzYtNDIzMTBlMjc0MDlk',
			"currency" => 'USD',
			"total" => '10.00',
			"billingAddr" => array(
				"name" => 'Testing Tester',
				"addrLine1" => '123 Test St',
				"city" => 'Columbus',
				"state" => 'OH',
				"zipCode" => '43123',
				"country" => 'USA',
				"email" => 'testingtester@2co.com',
				"phoneNumber" => '555-555-5555'
			),
			"shippingAddr" => array(
				"name" => 'Testing Tester',
				"addrLine1" => '123 Test St',
				"city" => 'Columbus',
				"state" => 'OH',
				"zipCode" => '43123',
				"country" => 'USA',
				"email" => 'testingtester@2co.com',
				"phoneNumber" => '555-555-5555'
			)
		));
		echo $charge['response']['responseCode'];
	} 
	catch (Twocheckout_Error $e) {
		echo $e->getMessage();
	}
?>
