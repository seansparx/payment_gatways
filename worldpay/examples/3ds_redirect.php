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

include('header.php');

try {
    $response = $worldpay->authorize3DSOrder($_SESSION['orderCode'], $_POST['PaRes']);

    if (isset($response['paymentStatus']) && ($response['paymentStatus'] == 'SUCCESS' ||  $response['paymentStatus'] == 'AUTHORIZED')) {
        echo 'Order Code: ' . $_SESSION['orderCode'] . ' has been authorized <br/>';
    } else {
        var_dump($response);
        echo 'There was a problem authorizing 3DS order <br/>';
    }
} catch (WorldpayException $e) {
    // Worldpay has thrown an exception
    echo 'Error code: ' . $e->getCustomCode() . '<br/>
    HTTP status code:' . $e->getHttpStatusCode() . '<br/>
    Error description: ' . $e->getDescription()  . ' <br/>
    Error message: ' . $e->getMessage() . ' <br/>' .
    'PaRes: ' . print_r($_POST, true) . '<br/>';
}
