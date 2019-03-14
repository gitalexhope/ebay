<?php
require_once('.config.inc.php');
$order = __autoload('MarketplaceWebServiceOrders/Model');

// More endpoints are listed in the MWS Developer Guide
// North America:
//$serviceUrl = "https://mws.amazonservices.com/Orders/2013-09-01";
// Europe
//$serviceUrl = "https://mws-eu.amazonservices.com/Orders/2013-09-01";
// Japan
//$serviceUrl = "https://mws.amazonservices.jp/Orders/2013-09-01";
// China
//$serviceUrl = "https://mws.amazonservices.com.cn/Orders/2013-09-01";
$serviceUrl = "https://mws.amazonservices.in/Orders/2013-09-01";

 $config = array (
   'ServiceURL' => $serviceUrl,
   'ProxyHost' => null,
   'ProxyPort' => -1,
   'ProxyUsername' => null,
   'ProxyPassword' => null,
   'MaxErrorRetry' => 3,
 );

 $service = new MarketplaceWebServiceOrders_Client(
        AWS_ACCESS_KEY_ID,
        AWS_SECRET_ACCESS_KEY,
        APPLICATION_NAME,
        APPLICATION_VERSION,
        $config);

/************************************************************************
 * Uncomment to try out Mock Service that simulates MarketplaceWebServiceOrders
 * responses without calling MarketplaceWebServiceOrders service.
 *
 * Responses are loaded from local XML files. You can tweak XML files to
 * experiment with various outputs during development
 *
 * XML files available under MarketplaceWebServiceOrders/Mock tree
 *
 ***********************************************************************/
 // $service = new MarketplaceWebServiceOrders_Mock();

/************************************************************************
 * Setup request parameters and uncomment invoke to try out
 * sample for List Orders Action
 ***********************************************************************/
 // @TODO: set request. Action can be passed as MarketplaceWebServiceOrders_Model_ListOrders
 $t1 = date("c", time() - 7 * 24 * 60 * 60);
$t2 = date("c", time() - 1 * 24 * 60 * 60);
 $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
 $request->setSellerId(MERCHANT_ID);
 $request->setLastUpdatedAfter($t1);
$request->setLastUpdatedBefore($t2);
$request->setMarketplaceId(MARKETPLACE_ID);
 // object or array of parameters
 invokeListOrders($service, $request);

/**
  * Get List Orders Action Sample
  * Gets competitive pricing and related information for a product identified by
  * the MarketplaceId and ASIN.
  *
  * @param MarketplaceWebServiceOrders_Interface $service instance of MarketplaceWebServiceOrders_Interface
  * @param mixed $request MarketplaceWebServiceOrders_Model_ListOrders or array of parameters
  */

  function invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request)
  {
      try {
        $response = $service->ListOrders($request);

        echo ("Service Response\n");
        echo ("=============================================================================\n");

        $dom = new DOMDocument();
        $dom->loadXML($response->toXML());
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        echo $dom->saveXML();
        echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

     } catch (MarketplaceWebServiceOrders_Exception $ex) {
        echo("Caught Exception: " . $ex->getMessage() . "\n");
        echo("Response Status Code: " . $ex->getStatusCode() . "\n");
        echo("Error Code: " . $ex->getErrorCode() . "\n");
        echo("Error Type: " . $ex->getErrorType() . "\n");
        echo("Request ID: " . $ex->getRequestId() . "\n");
        echo("XML: " . $ex->getXML() . "\n");
        echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
     }
 }
 ?>

