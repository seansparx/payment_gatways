<?php
namespace Worldpay;
?>

<?php
echo '<pre>';
print_r($_REQUEST);
die;


require_once('init.php');

$worldpay = new Worldpay('T_S_86e85616-de86-4ae0-8441-64da35f4dcbb');
 
$billing_address = array("address1" => "123 House Road", "address2"=> 'A village', "address3"=> '', "postalCode"=> 'EC1 1AA',"city"=> 'London', "state"=> '', "countryCode"=> 'GB' );

try {
    $response = $worldpay->createOrder(array(
        'token' => $_REQUEST['token'],
        'amount-in-cents' => 500,
        'currencyCode' => 'GBP',
        'name' => 'test name',
        'billingAddress' => $billing_address,
        'orderDescription' => 'Order description',
        'customerOrderCode' => 'Order code'
    ));

    if ($response['paymentStatus'] === 'SUCCESS') {
        $worldpayOrderCode = $response['orderCode'];
    } 
	else {
        throw new WorldpayException(print_r($response, true));
    }
} 
catch (WorldpayException $e) {
    echo 'Error code: ' .$e->getCustomCode() .'
    HTTP status code:' . $e->getHttpStatusCode() . '
    Error description: ' . $e->getDescription()  . '
    Error message: ' . $e->getMessage();
} 
catch (Exception $e) {
    echo 'Error message: '. $e->getMessage();
}
 
?>


