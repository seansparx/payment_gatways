<?php
namespace Worldpay;
?>

<?php
/**
 * PHP library version: 2.0.0
 */
require_once('../init.php');

// Initialise Worldpay class with your SERVICE KEY
$worldpay = new Worldpay("T_S_86e85616-de86-4ae0-8441-64da35f4dcbb");

// Sometimes your SSL doesnt validate locally
// DONT USE IN PRODUCTION
$worldpay->disableSSLCheck(true);

$worldpayOrderCode = $_POST['orderCode'];

include("header.php");

// Try catch
try {
    // Cancel the authorized order using the Worldpay order code
    $worldpay->cancelAuthorizedOrder($worldpayOrderCode);
    echo 'Authorized order <span id="order-code">'.$worldpayOrderCode.'</span>
        has been cancelled';
} catch (WorldpayException $e) {
    // Worldpay has thrown an exception
    echo 'Error code: ' . $e->getCustomCode() . '<br/>
    HTTP status code:' . $e->getHttpStatusCode() . '<br/>
    Error description: ' . $e->getDescription()  . ' <br/>
    Error message: ' . $e->getMessage();
}
