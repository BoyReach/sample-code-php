<?php
  require 'vendor/autoload.php';
  use net\authorize\api\contract\v1 as AnetAPI;
  use net\authorize\api\controller as AnetController;
  
  define("AUTHORIZENET_LOG_FILE", "phplog");

  function getMerchantDetails() {
    // Common Set Up for API Credentials
    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
    $merchantAuthentication->setName(\SampleCode\Constants::MERCHANT_LOGIN_ID);
    $merchantAuthentication->setTransactionKey(\SampleCode\Constants::MERCHANT_TRANSACTION_KEY);

    $refId = 'ref' . time();

    $request = new AnetAPI\GetMerchantDetailsRequest();
    $request->setMerchantAuthentication($merchantAuthentication);

    $controller = new AnetController\GetMerchantDetailsController($request);

    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

    if (($response != null) && ($response->getMessages()->getResultCode() == "Ok"))
    {
      echo "Merchant Name: " . $response->getMerchantName() . "\n";
      echo "Gateway ID: " . $response->getGatewayId() . "\n";
      echo "Processors: ";
      foreach ($response->getProcessors() as $processor)
      {
        echo $processor->getName() . "; ";
      }
    }
    else
    {
      echo  "No response returned \n";
    }

    return $response;
  }

  if(!defined('DONT_RUN_SAMPLES'))
    getMerchantDetails();
?>