<?php

namespace App\lib;
use DB;
/*require_once 'nusoap.php';*/
use nusoap_client;
class ZarinPal
{
public $MerchantID;
public function __construct()
{
$this->MerchantID="ccd4acab-a4dc-416d-9172-b066aa674e2b";
}
public function pay($Amount,$Email,$Mobile)
{
$Description = 'فروش محصول';  // Required
$CallbackURL = url('/Confirmation'); // Required


$client = new nusoap_client('https://www.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
$client->soap_defencoding = 'UTF-8';
$result = $client->call('PaymentRequest', [
[
'MerchantID'     => $this->MerchantID,
'Amount'         => $Amount,
'Description'    => $Description,
'Email'          => $Email,
'Mobile'         => $Mobile,
'CallbackURL'    => $CallbackURL,
],
]);

//Redirect to URL You can do it also by creating a form
if ($result['Status'] == 100) {
return $result['Authority'];
} else {
return false;
}



}

}
