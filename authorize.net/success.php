<?php
include_once './sdk-php/autoload.php';

//echo '<pre>';
//print_r($_POST);

mail('rakesh.kumar@sparxitsolutions.com','auth.net', json_encode($_POST));


$response = new AuthorizeNetSIM;
if ($response->isAuthorizeNet())
{
  if ($response->approved)
  {
    // Activate magazine subscription
    print_r($response);
  }
}
?>
