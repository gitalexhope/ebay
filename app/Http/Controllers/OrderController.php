<?php

namespace App\Http\Controllers;
use Helper;
use Validator;
use Hash;
use Session;
use Redirect;
//use App\User;
//use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Models\Order as Order;
use App\Http\Models\Reports as Reports;
use App\Services\ebay\getcommon;
use Sonnenglas\AmazonMws\AmazonOrderList;
use Sonnenglas\AmazonMws\AmazonInventoryList;
use Sonnenglas\AmazonMws\AmazonProductList;
use Sonnenglas\AmazonMws\AmazonProduct;
use Sonnenglas\AmazonMws\AmazonReportList;
use Sonnenglas\AmazonMws\AmazonReportRequest;
use Sonnenglas\AmazonMws\AmazonReportRequestList;
use Sonnenglas\AmazonMws\AmazonReport;
use Sonnenglas\AmazonMws\AmazonOrderItemList;
use Sonnenglas\AmazonMws\AmazonOrder;
use Sonnenglas\AmazonMws\AmazonShipment;
use Sonnenglas\AmazonMws\AmazonFinancialEventList;
use Sonnenglas\AmazonMws\AmazonFinancialGroupList;
use DOMDocument;
class OrderController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
	public function __construct(){
	 $value = Session::get('amaEbaySessId');
		if($value == ''){
			Redirect::to('/')->send();
		}
	}
	public function orderList(){
		$resultVal['orderList'] = 	Order::getOrderList();
		//echo "<pre>";print_r($resultVal['orderList']);die;
		if(isset($_GET['ajax'])){
					return view('order.orderSearch',$resultVal) ;
		}
		else{
			echo Helper::adminHeader();
			return view('order.index',$resultVal) ;
		}
	}
	public function addTracking(Request $request){
			$checkExits = order::checkExits('orderDetail',array('trackingNumber' => $request->get('trackNum')), 'orderRef',$request->get('order'));
			if($checkExits == 0){
				$resultVal =   Order::addTrackingNum($request->get('order'),$request->get('trackNum'));
			}else{
				$resultVal =   Order::updateTrackingNum($request->get('order'),$request->get('trackNum'));
			}
			include(app_path() . '/Services/ebay/getcommon/keys.php');
			$siteID = 0;
			//the call being made:
			$verb = 'CompleteSale';
			//Time with respect to GMT
			//by default retreive orders in last 30 minutes
			$CreateTimeFrom  = gmdate("Y-m-d\TH:i:s",time()-18000000); //current time minus 30 minutes
			$CreateTimeTo 	 = gmdate("Y-m-d\TH:i:s");
			///Build the request Xml string
			$requestXmlBody  =  '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBody .= '<CompleteSaleRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBody .= '<OrderID>'.$request->get('order').'</OrderID>
  												<OrderLineItemID>'.$request->get('order').'</OrderLineItemID>
  												<Shipped>true</Shipped>
  												<Shipment>
    													<ShipmentTrackingDetails>
       												<ShipmentTrackingNumber>'.$request->get('trackNum').'</ShipmentTrackingNumber>
       												<ShippingCarrierUsed>USPS</ShippingCarrierUsed>
     										 </ShipmentTrackingDetails>
  										 </Shipment>';
			$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
			$requestXmlBody .= '</CompleteSaleRequest>';
			$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBody);
			$response 	 = Helper::ebayApiResponse($responseXml);
			if($response->Ack == 'Success'){
				echo json_encode($resultVal);
			}
	}
	public function orderSearch(Request $request){
		$resultVal['orderList'] =   Order::searchInventoryList($request->get('lowerCase'),$request->get('upperCase'));
		return view('order.orderSearch',$resultVal);
		}

	public function getOrderDetail(Request $request){
			$resultVal['orderDetail'] 		 =   Order::orderDetailById($request->get('order'));
			$resultVal['orderTransaction'] =   Order::orderTransactionDetails($request->get('order'));
			$resultVal['orderItem'] 			 =   Order::orderItemsDetails($request->get('order'));
			$resultVal['returnCharges'] 	 =   Order::getReturnOrderItems($request->get('order'));
			//echo "<pre>";print_r($resultVal['orderItem']);die;
			return view('order.orderDetail',$resultVal) ;
		}

		public function getAmazonOrderList(){
				$resultVal['orderDetail'] =   Order::amazonOrder();
				if(isset($_GET['ajax'])){
							return view('order.amazonOrderlist',$resultVal) ;
				}
				else{
					echo Helper::adminHeader();
					return view('order.amazonOrder',$resultVal) ;
				}
		}

		public function searchAmazoneOrderList(Request $request){
			$resultVal['orderDetail'] =   Order::amazonOrderList($request->get('lowerCase'),$request->get('upperCase'));
			return view('order.amazonOrderlist',$resultVal) ;
		}

		public function getAmazonOrderDetails(Request $request)
		{
			$orderId = $request->get('order');
			$orderItem = array();
			$recordExits = Order::checkExitsAmazonOrder('amazonOrder',array('orderRef'=>$orderId,'modifiedDate'=> date('Y-m-d')));
			// Checking record not updated in current date update infomation
			if($recordExits == 0)
			{
					 $amz = new AmazonOrder("store1"); //store name matches the array key in the config file
					 $amz->setOrderId($orderId); //accepts either specific timestamps or relative times
					 $amz->fetchOrder(); //accepts either specific timestamps or relative times
					 $result =  $amz->getData();
					 $orderDetail = array();
					 $shippingDetail = array();
					 if(count($result) > 0)
					 {
								$orderDetail['purchaseDate']						=	$result['PurchaseDate'];
								$orderDetail['lastUpdatedDate']					=	$result['LastUpdateDate'];
								$orderDetail['orderStatus']							=	$result['OrderStatus'];
								$orderDetail['fullFillmentChannel']			=	$result['FulfillmentChannel'];
								$orderDetail['salesChannel']						=	$result['SalesChannel'];
								$orderDetail['shipServiceLevel']				=	$result['ShipServiceLevel'];
								$orderDetail['totalAmount']							=	$result['OrderTotal']['Amount'];
								$orderDetail['currencyCode']						=	$result['OrderTotal']['CurrencyCode'];
								$orderDetail['numberOfItemsShipped']		=	$result['NumberOfItemsShipped'];
								$orderDetail['numberOfItemsUnshipped']	=	$result['NumberOfItemsUnshipped'];
								if($result['OrderStatus'] != 'Canceled')
								{
									$orderDetail['paymentMethod']						=	$result['PaymentMethod'];
									$orderDetail['marketplaceId']						=	$result['MarketplaceId'];
									$orderDetail['buyerName']								=	$result['BuyerName'];
									$orderDetail['buyerEmail']							=	$result['BuyerEmail'];
									$orderDetail['earliestShipDate']				=	$result['EarliestShipDate'];
									$orderDetail['latestShipDate']					=	$result['LatestShipDate'];
									$orderDetail['earliestDeliveryDate']		=	$result['EarliestDeliveryDate'];
									$orderDetail['latestDeliveryDate']			=	$result['LatestDeliveryDate'];
									$orderDetail['status']	=	0;
									$shippingDetail['customerName'] 	= $result['ShippingAddress']['Name'];
									$shippingDetail['addressLine1'] 	= $result['ShippingAddress']['AddressLine1'];
									$shippingDetail['addressLine2'] 	= $result['ShippingAddress']['AddressLine2'];
									$shippingDetail['addressLine3'] 	= $result['ShippingAddress']['AddressLine3'];
									$shippingDetail['city'] 					= $result['ShippingAddress']['City'];
									$shippingDetail['county'] 				= $result['ShippingAddress']['County'];
									$shippingDetail['district'] 			= $result['ShippingAddress']['District'];
									$shippingDetail['stateOrRegion'] 	= $result['ShippingAddress']['StateOrRegion'];
									$shippingDetail['postalCode'] 		= $result['ShippingAddress']['PostalCode'];
									$shippingDetail['countryCode'] 		= $result['ShippingAddress']['CountryCode'];
									$shippingDetail['phone'] 					= $result['ShippingAddress']['Phone'];
									$orderDetail['modifiedDate']			=	date('Y-m-d');
								}
								/// Array for update shippingDetail
					 }

					$checkRecord = Order::checkExitsAmazonOrder('amazonOrder',array('orderRef'=>$orderId));
					if($result['OrderStatus'] != 'Canceled')
					{
							if($checkRecord == 0)
							{
									 // setting orderRef
									$orderDetail['orderRef']						=	$orderId;
									$shippingDetail['orderRefId']				=	$orderId;
									$insertData = Order::insertAmazoneOrder($orderDetail,$shippingDetail);
							}else
							{
								$updateAmazoneOrder = Order::updateAmazoneOrder($orderDetail,$shippingDetail,$orderId);
							}
					}

			} // end IF condition
						$recordExits = Order::checkExitsAmazonOrder('amazoneOrderItem',array('orderId' => $orderId));
						// $recordExits = 0 for record not exits
						if($recordExits == 0)
						{
							$amz = new AmazonOrderItemList("store1"); //store name matches the array key in the config file
							$amz->setOrderId($orderId); 	//oredrId to get order details form order
							$amz->fetchItems(); //no Amazon-fulfilled orders
							$resultItemList =  $amz;

							if(count($resultItemList) > 0)
							{

							$i = 0;
							foreach ($resultItemList as $order)
								{

									if(strpos($order['Title'],'Apple') != false || strpos($order['Title'],'iPhone') != false || strpos($order['Title'],'Samsung') != false
										 ||strpos($order['Title'],'Mobile') != false || strpos($order['Title'],'Phone') != false )
									{
											//echo "<pre>"; print_r($order); echo "</pre>"; die;
											$orderItem[$i]['itemRefId'] 									= Helper::unqNum();
											$orderItem[$i]['orderId']											= $orderId; // orderID
											$orderItem[$i]['itemId'] 	  									= $order['OrderItemId'];
											$orderItem[$i]['SellerSKU'] 									= $order['SellerSKU'];
											$orderItem[$i]['ASIN'] 												= $order['ASIN'];
											$orderItem[$i]['itemTitle'] 									= $order['Title'];
											$orderItem[$i]['QuantityOrdered'] 						= $order['QuantityOrdered'];
											$orderItem[$i]['QuantityShipped'] 						= $order['QuantityShipped'];
											$orderItem[$i]['ItemPrice'] 									= $order['ItemPrice']['Amount'];
											$orderItem[$i]['ItemPriceCode'] 							= $order['ItemPrice']['CurrencyCode'];
											$orderItem[$i]['ShippingPrice'] 							= $order['ShippingPrice']['Amount'];
											$orderItem[$i]['ShippingPriceCode'] 					= $order['ShippingPrice']['CurrencyCode'];
											$orderItem[$i]['GiftWrapPrice'] 							= $order['GiftWrapPrice']['Amount'];
											$orderItem[$i]['GiftWrapPriceCode'] 					= $order['GiftWrapPrice']['CurrencyCode'];
											$orderItem[$i]['ItemTaxAmount'] 							= $order['ItemTax']['Amount'];
											$orderItem[$i]['ItemTaxCode'] 								= $order['ItemTax']['CurrencyCode'];
											$orderItem[$i]['ShippingTaxAmount'] 					= $order['ShippingTax']['Amount'];
											$orderItem[$i]['ShippingTaxCode'] 						= $order['ShippingTax']['CurrencyCode'];
											$orderItem[$i]['GiftWrapTaxAmount'] 					= $order['GiftWrapTax']['Amount'];
											$orderItem[$i]['GiftWrapTaxCode'] 						= $order['GiftWrapTax']['CurrencyCode'];
											$orderItem[$i]['ShippingDiscountAmount'] 			= $order['ShippingDiscount']['Amount'];
											$orderItem[$i]['ShippingDiscountCode'] 				= $order['ShippingDiscount']['CurrencyCode'];
											$orderItem[$i]['PromotionDiscountAmount'] 		= $order['PromotionDiscount']['Amount'];
											$orderItem[$i]['PromotionDiscountCode'] 			= $order['PromotionDiscount']['CurrencyCode'];
											$orderItem[$i]['createdDate'] 								= date('y-m-d');
											$orderItem[$i]['modifiedDate'] 								= date('y-m-d');
											$i++;
									}
							 	}
				 		}
				 			$insertData = Order::insertAmazonOrderItems($orderItem);
						}

						/* * Get data from finance Api * */

			$resultVal['orderDetail'] 		 =   Order::amazoneOrderDetailById($request->get('order'));
			$resultVal['orderItem']				 =   Order::amazoneOrderItemsDetails($request->get('order'));
			$resultVal['commissionData'] 	 =   Order::OrderCommissionData($request->get('order'));
			$resultVal['returnCharges'] 	 =   Order::getReturnOrderItems($request->get('order'));
			//echo "<pre>"; print_r($resultVal);die;
			return view('order.amazoneOrderDetail',$resultVal) ;

		}

	 public function getAmazonOrders()
	 {
		 
			 $date = Order::getAmazonOrderMaxDate();
			 if($date == '')
			 {
				$date = "- 1 hours";
			 }
			 $amz = new AmazonOrderList("store1"); //store name matches the array key in the config file
			 $amz->setLimits('Modified', "- 12 hour"); //accepts either specific timestamps or relative times
			 $amz->setFulfillmentChannelFilter("MFN"); //no Amazon-fulfilled orders
			 $amz->setOrderStatusFilter( array("Unshipped", "PartiallyShipped", "Canceled", "Unfulfillable"));
			 //no shipped or pending orders
			 $amz->setUseToken(); //tells the object to automatically use tokens right away
			 $amz->fetchOrders(); //this is what actually sends the request
			 $OrderResult =  $amz->getList();
		  	// echo "<pre>";print_r($OrderResult);die;
			 $orderDetail		 		= array();
			 $shippingDetail 		= array();
			 $UpOrderDetail		 	= array();
			 $UpShippingDetail 	= array();
			 $orderItem			 		= array();
			 $orderArray				= array();
			 if(count($OrderResult) > 0)
			 {
					$dateVal = explode('.',$date);
					$i 		= 0;
					$j 		= 0;
					$upNo = 0;
					foreach ($OrderResult as $order)
					{

								$amz = new AmazonOrderItemList("store1"); //store name matches the array key in the config file
								$amz->setOrderId($order->getAmazonOrderId()); 	//oredrId to get order details form order
								$amz->fetchItems();
								$result =  $amz;


								if($result)
								{
									foreach ($result as $orderItemData)
									{
											$orderArray[] 																= $order->getAmazonOrderId();
											if( $orderItemData['SellerSKU']!="" && $orderItemData['QuantityOrdered']!=""){
												self::updateEbayInventoryQty( $orderItemData['SellerSKU'],$orderItemData['QuantityOrdered']);
											}

												// if(strpos(	$orderItemData['Title'],'Apple') != false || strpos($orderItemData['Title'],'iPhone')!= false || strpos($orderItemData['Title'],'Samsung') != false
												// 	|| strpos($orderItemData['Title'],'Mobile')!= false || strpos($orderItemData['Title'],'Phone') != false)
												// {

													// die('adfasd');
														// Inserting Order
														# checking record exits or not
														$orderExits = Order::checkExitsAmazonOrder('amazonOrder',array('orderRef' => $order->getAmazonOrderId()));

														$ss = 	$order->getOrderTotal();
														// $recordExits = 0 for record not exits
														if($orderExits == 0 )
														{

															$orderDetail[$i]['orderRef']											=	$order->getAmazonOrderId();
															$orderDetail[$i]['purchaseDate']									=	$order->getPurchaseDate();
															$orderDetail[$i]['lastUpdatedDate']								=	$order->getLastUpdateDate();
															$orderDetail[$i]['orderStatus']										=	$order->getOrderStatus();
															$orderDetail[$i]['fullFillmentChannel']						=	$order->getFulfillmentChannel();
															$orderDetail[$i]['salesChannel']									=	$order->getSalesChannel();
															$orderDetail[$i]['shipServiceLevel']							=	$order->getShipServiceLevel();
															$orderDetail[$i]['totalAmount']										=	$order->getOrderTotalAmount();
															$orderDetail[$i]['currencyCode']									=	$ss['CurrencyCode'];
															$orderDetail[$i]['numberOfItemsShipped']					=	$order->getNumberOfItemsShipped();
															$orderDetail[$i]['numberOfItemsUnshipped']				=	$order->getNumberOfItemsUnshipped();
															$orderDetail[$i]['paymentMethod']									=	$order->getPaymentMethod();
															$orderDetail[$i]['marketplaceId']									=	$order->getMarketplaceId();
															$orderDetail[$i]['buyerName']											=	$order->getBuyerName();
															$orderDetail[$i]['buyerEmail']										=	$order->getBuyerEmail();
															$orderDetail[$i]['earliestShipDate']							=	$order->getEarliestShipDate();
															$orderDetail[$i]['latestShipDate']								=	$order->getLatestShipDate();
															$orderDetail[$i]['earliestDeliveryDate']					=	$order->getEarliestDeliveryDate();
															$orderDetail[$i]['latestDeliveryDate']						=	$order->getLatestDeliveryDate();
															$orderDetail[$i]['status']												=	1;
															$orderDetail[$i]['createdDate']							  		= date('Y-m-d');
															$orderDetail[$i]['modifiedDate']									= date('Y-m-d');
															$address																					=	$order->getShippingAddress();
															$shippingDetail[$i]['customerName'] 							= $address['Name'];
															$shippingDetail[$i]['addressLine1'] 							= $address['AddressLine1'];
															$shippingDetail[$i]['addressLine2'] 							= $address['AddressLine2'];
															$shippingDetail[$i]['addressLine3'] 							= $address['AddressLine3'];
															$shippingDetail[$i]['city'] 											= $address['City'];
															$shippingDetail[$i]['county'] 										= $address['County'];
															$shippingDetail[$i]['district'] 									= $address['District'];
															$shippingDetail[$i]['stateOrRegion'] 							= $address['StateOrRegion'];
															$shippingDetail[$i]['postalCode'] 								= $address['PostalCode'];
															$shippingDetail[$i]['countryCode'] 								= $address['CountryCode'];
															$shippingDetail[$i]['phone'] 											= $address['Phone'];
															$shippingDetail[$i]['orderRefId'] 								= $order->getAmazonOrderId();
															$i++;
														}
														else
														{
															// update order
															$UpOrderDetail[$upNo]['orderRef']									=	$order->getAmazonOrderId();
															$UpOrderDetail[$upNo]['purchaseDate']							=	$order->getPurchaseDate();
															$UpOrderDetail[$upNo]['lastUpdatedDate']					=	$order->getLastUpdateDate();
															$UpOrderDetail[$upNo]['orderStatus']							=	$order->getOrderStatus();
															$UpOrderDetail[$upNo]['fullFillmentChannel']			=	$order->getFulfillmentChannel();
															$UpOrderDetail[$upNo]['salesChannel']							=	$order->getSalesChannel();
															$UpOrderDetail[$upNo]['shipServiceLevel']					=	$order->getShipServiceLevel();
															$UpOrderDetail[$upNo]['totalAmount']							=	$order->getOrderTotalAmount();
															$UpOrderDetail[$upNo]['currencyCode']							=	$ss['CurrencyCode'];
															$UpOrderDetail[$upNo]['numberOfItemsShipped']			=	$order->getNumberOfItemsShipped();
															$UpOrderDetail[$upNo]['numberOfItemsUnshipped']		=	$order->getNumberOfItemsUnshipped();
															$UpOrderDetail[$upNo]['paymentMethod']						=	$order->getPaymentMethod();
															$UpOrderDetail[$upNo]['marketplaceId']						=	$order->getMarketplaceId();
															$UpOrderDetail[$upNo]['buyerName']								=	$order->getBuyerName();
															$UpOrderDetail[$upNo]['buyerEmail']								=	$order->getBuyerEmail();
															$UpOrderDetail[$upNo]['earliestShipDate']					=	$order->getEarliestShipDate();
															$UpOrderDetail[$upNo]['latestShipDate']						=	$order->getLatestShipDate();
															$UpOrderDetail[$upNo]['earliestDeliveryDate']			=	$order->getEarliestDeliveryDate();
															$UpOrderDetail[$upNo]['latestDeliveryDate']				=	$order->getLatestDeliveryDate();
															$UpOrderDetail[$upNo]['status']										=	1;
															$UpOrderDetail[$upNo]['modifiedDate']							= date('Y-m-d');
															$address																					=	$order->getShippingAddress();
															$UpShippingDetail[$upNo]['customerName'] 					= $address['Name'];
															$UpShippingDetail[$upNo]['addressLine1'] 					= $address['AddressLine1'];
															$UpShippingDetail[$upNo]['addressLine2'] 					= $address['AddressLine2'];
															$UpShippingDetail[$upNo]['addressLine3'] 					= $address['AddressLine3'];
															$UpShippingDetail[$upNo]['city'] 									= $address['City'];
															$UpShippingDetail[$upNo]['county'] 								= $address['County'];
															$UpShippingDetail[$upNo]['district'] 							= $address['District'];
															$UpShippingDetail[$upNo]['stateOrRegion'] 				= $address['StateOrRegion'];
															$UpShippingDetail[$upNo]['postalCode'] 						= $address['PostalCode'];
															$UpShippingDetail[$upNo]['countryCode'] 					= $address['CountryCode'];
															$UpShippingDetail[$upNo]['phone'] 								= $address['Phone'];
															$UpShippingDetail[$upNo]['orderRefId'] 						= $order->getAmazonOrderId();
															$upNo++;
														}
														/***************************************************************************************************************/
														$itemRecordExits = Order::checkExitsAmazonOrder('amazoneOrderItem',array('orderId' => $order->getAmazonOrderId(),'SellerSKU'=>$orderItemData['SellerSKU']));
														// $itemRecordExits = 0 for record not exits

														if($itemRecordExits == 0 )
														{
														//$orderItem Array for add order item
																$orderItem[$j]['itemRefId'] 												= Helper::unqNum();
																$orderItem[$j]['orderId']														= $order->getAmazonOrderId(); // orderID
																$orderItem[$j]['itemId'] 	  												= $orderItemData['OrderItemId'];
																$orderItem[$j]['SellerSKU'] 												= $orderItemData['SellerSKU'];
																$orderItem[$j]['ASIN'] 															=	$orderItemData['ASIN'];
																$orderItem[$j]['itemTitle'] 												=	$orderItemData['Title'];
																$orderItem[$j]['QuantityOrdered'] 									=	$orderItemData['QuantityOrdered'];
																$orderItem[$j]['QuantityShipped'] 									=	$orderItemData['QuantityShipped'];
																// Checking values
																if(isset($orderItemData['ItemPrice']) && isset($orderItemData['ShippingPrice']))
																{
																		$orderItem[$j]['ItemPrice'] 												=	$orderItemData['ItemPrice']['Amount'];
																		$orderItem[$j]['ItemPriceCode'] 										=	$orderItemData['ItemPrice']['CurrencyCode'];
																		$orderItem[$j]['ShippingPrice'] 										=	$orderItemData['ShippingPrice']['Amount'];
																		$orderItem[$j]['ShippingPriceCode'] 								=	$orderItemData['ShippingPrice']['CurrencyCode'];
																		$orderItem[$j]['GiftWrapPrice'] 										=	$orderItemData['GiftWrapPrice']['Amount'];
																		$orderItem[$j]['GiftWrapPriceCode'] 								=	$orderItemData['GiftWrapPrice']['CurrencyCode'];
																		$orderItem[$j]['ItemTaxAmount'] 										=	$orderItemData['ItemTax']['Amount'];
																		$orderItem[$j]['ItemTaxCode'] 											=	$orderItemData['ItemTax']['CurrencyCode'];
																		$orderItem[$j]['ShippingTaxAmount'] 								=	$orderItemData['ShippingTax']['Amount'];
																		$orderItem[$j]['ShippingTaxCode'] 									=	$orderItemData['ShippingTax']['CurrencyCode'];
																		$orderItem[$j]['GiftWrapTaxAmount'] 								=	$orderItemData['GiftWrapTax']['Amount'];
																		$orderItem[$j]['GiftWrapTaxCode'] 									=	$orderItemData['GiftWrapTax']['CurrencyCode'];
																		$orderItem[$j]['ShippingDiscountAmount'] 						=	$orderItemData['ShippingDiscount']['Amount'];
																		$orderItem[$j]['ShippingDiscountCode'] 							=	$orderItemData['ShippingDiscount']['CurrencyCode'];
																		$orderItem[$j]['PromotionDiscountAmount'] 					=	$orderItemData['PromotionDiscount']['Amount'];
																		$orderItem[$j]['PromotionDiscountCode'] 						=	$orderItemData['PromotionDiscount']['CurrencyCode'];
																		$orderItem[$j]['createdDate'] 											= date('y-m-d');
																		$orderItem[$j]['modifiedDate'] 											= date('y-m-d');
																		$j++;
														    } // end filter if condtion
														} // end if
											// }	// end strpos if condtion
									} 	// end $orderItemData foreach
								}

					} // end foreach
			 }
			 		echo "*******************Start orderItem***************************************************";
					echo "<pre>";print_r($orderItem);
					echo "*******************Start UpOrderDetail************************************************";
					echo "<pre>";print_r($UpOrderDetail);
					echo "*******************Start UpShippingDetail*********************************************";
					echo "<pre>";print_r($UpShippingDetail);
					echo "*******************Start orderDetail**************************************************";
					echo "<pre>";print_r($orderDetail);
					echo "*******************Start shippingDetail***********************************************";
					echo "<pre>";print_r($shippingDetail);
					echo "*******************Start orderArray***********************************************";
					echo "<pre>";print_r($orderArray);

					$insertData 	= Order::insertAmazonOrderItems($orderItem);
					$updateRecord = Order::updateAmazonBulkOrders($UpOrderDetail,$UpShippingDetail);
					$inserOrder		= Order::insertAmazonOrderDetail($orderDetail,$shippingDetail);
		}



		public function updateEbayInventoryQty($sellerSku,$quantity){
			include(app_path() . '/Services/ebay/getcommon/keys.php');
			$siteID = 0;
			$verb = 'GetItem';
			$ebayId = '';
			$hh = Order::checkExitsAmazonOrder('productVariation',array('productSKU' => $sellerSku));
			$getCommon = Order::getCommon('productVariation',array('productSKU' => $sellerSku));
			if (!$hh) {
					$hh = Order::checkExitsAmazonOrder('ebayInventory',array('productSKU' => $sellerSku));
					$getCommon = Order::getCommon('ebayInventory',array('productSKU' => $sellerSku));
					$ebayId = $getCommon->ebayItemRef;
			}else{
					$ebayId = $getCommon->itemID;
			}
			if ($ebayId !='') {
				$requestXmlBodyReviseItem = '<?xml version="1.0" encoding="utf-8"?>
					<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
						<ItemID>'.$ebayId.'</ItemID>
						<IncludeItemSpecifics>true</IncludeItemSpecifics>';
							$requestXmlBodyReviseItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials></GetItemRequest>";
					$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
					//send the request and get response
					$responseXml = $session->sendHttpRequest($requestXmlBodyReviseItem);
					$response['ebay'] = Helper::ebayApiResponse($responseXml);
					$upQty = '';
					if (isset($response['ebay']->Item->Variations) ) {
						foreach ($response['ebay']->Item->Variations->Variation as $key => $value)
						{
							if ($value->SKU == $sellerSku) {
								$qty 			= (isset($value->Quantity) ) ? $value->Quantity : 0;
								$qtySold 	= (isset($value->SellingStatus->QuantitySold) ) ? $value->SellingStatus->QuantitySold : 0;
								if ($qty > 0) {
									$qty 			= $qty - $qtySold;
									$upQty 		= $qty - $quantity;
								}
								break;
							}
						}
					}else{
						$qty 			= (isset($response['ebay']->Item->Quantity) ) ? $response['ebay']->Item->Quantity : 0;
						$qtySold 	= (isset($response['ebay']->Item->SellingStatus->QuantitySold) ) ? $response['ebay']->Item->SellingStatus->QuantitySold : 0;
						if ($qty > 0) {
							$qty 			= $qty - $qtySold;
							$upQty 		= $qty - $quantity;
						}
					}

					if ($upQty !='') {
						$verb = 'ReviseInventoryStatus';
						$requestXmlBodyReviseItem  = '<?xml version="1.0" encoding="utf-8" ?>';
						$requestXmlBodyReviseItem .= '<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
						$requestXmlBodyReviseItem .= '<InventoryStatus>
																						<ItemID>'.$ebayId.'</ItemID>
																						<SKU>'.$sellerSku.'</SKU>
																						<Quantity>'.$upQty.'</Quantity>
																					</InventoryStatus>';
						$requestXmlBodyReviseItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
						$requestXmlBodyReviseItem .= '</ReviseInventoryStatusRequest>';
						// Send Req To ebay to update product
						$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
						//send the request and get response
						$responseXml = $session->sendHttpRequest($requestXmlBodyReviseItem);
						$response['ebay'] = Helper::ebayApiResponse($responseXml);
						// echo '<pre>'; print_r($response);die;
					}

			}
		}
		/* OLD method
		public function getAmazonOrders()
 	 {

 	 $date = Order::getAmazonOrderMaxDate();
 	 if($date == '')
 	 {
 		$date = "- 1 hours";
 	 }
 	 $amz = new AmazonOrderList("store1"); //store name matches the array key in the config file
 	 $amz->setLimits('Modified', "- 1 hour"); //accepts either specific timestamps or relative times
 	 $amz->setFulfillmentChannelFilter("MFN"); //no Amazon-fulfilled orders
 	 $amz->setOrderStatusFilter(
 				 array("Unshipped", "PartiallyShipped", "Canceled", "Unfulfillable")
 				 ); //no shipped or pending orders
 	 $amz->setUseToken(); //tells the object to automatically use tokens right away
 	 $amz->fetchOrders(); //this is what actually sends the request
 	 $OrderResult =  $amz->getList();
 	 //echo "<pre>";print_r($OrderResult);
 	 $orderDetail		 		= array();
 	 $shippingDetail 		= array();
 	 $UpOrderDetail		 	= array();
 	 $UpShippingDetail 	= array();
 	 $orderItem			 		= array();
 	 $orderArray				= array();
 	 if(count($OrderResult) > 0)
 	 {
 			$dateVal = explode('.',$date);
 			$i 		= 0;
 			$j 		= 0;
 			$upNo = 0;
 			foreach ($OrderResult as $order)
 			{
 						# checking record exits or not
 						$orderExits = Order::checkExitsAmazonOrder('amazonOrder',array('orderRef' => $order->getAmazonOrderId()));
 						// $recordExits = 0 for record not exits
 						if($orderExits == 0 )
 						{
 							$orderDetail[$i]['orderRef']											=	$order->getAmazonOrderId();
 							$orderDetail[$i]['purchaseDate']									=	$order->getPurchaseDate();
 							$orderDetail[$i]['lastUpdatedDate']								=	$order->getLastUpdateDate();
 							$orderDetail[$i]['orderStatus']										=	$order->getOrderStatus();
 							$orderDetail[$i]['fullFillmentChannel']						=	$order->getFulfillmentChannel();
 							$orderDetail[$i]['salesChannel']									=	$order->getSalesChannel();
 							$orderDetail[$i]['shipServiceLevel']							=	$order->getShipServiceLevel();
 							$orderDetail[$i]['totalAmount']										=	$order->getOrderTotalAmount();
 							$orderDetail[$i]['currencyCode']									=	$order->getOrderCurrencyCode();
 							$orderDetail[$i]['numberOfItemsShipped']					=	$order->getNumberOfItemsShipped();
 							$orderDetail[$i]['numberOfItemsUnshipped']				=	$order->getNumberOfItemsUnshipped();
 							$orderDetail[$i]['paymentMethod']									=	$order->getPaymentMethod();
 							$orderDetail[$i]['marketplaceId']									=	$order->getMarketplaceId();
 							$orderDetail[$i]['buyerName']											=	$order->getBuyerName();
 							$orderDetail[$i]['buyerEmail']										=	$order->getBuyerEmail();
 							$orderDetail[$i]['earliestShipDate']							=	$order->getEarliestShipDate();
 							$orderDetail[$i]['latestShipDate']								=	$order->getLatestShipDate();
 							$orderDetail[$i]['earliestDeliveryDate']					=	$order->getEarliestDeliveryDate();
 							$orderDetail[$i]['latestDeliveryDate']						=	$order->getLatestDeliveryDate();
 							$orderDetail[$i]['status']												=	1;
 							$orderDetail[$i]['createdDate']							  		= date('Y-m-d');
 							$orderDetail[$i]['modifiedDate']									= date('Y-m-d');
 							$address=$order->getShippingAddress();
 							$shippingDetail[$i]['customerName'] 							= $address['Name'];
 							$shippingDetail[$i]['addressLine1'] 							= $address['AddressLine1'];
 							$shippingDetail[$i]['addressLine2'] 							= $address['AddressLine2'];
 							$shippingDetail[$i]['addressLine3'] 							= $address['AddressLine3'];
 							$shippingDetail[$i]['city'] 											= $address['City'];
 							$shippingDetail[$i]['county'] 										= $address['County'];
 							$shippingDetail[$i]['district'] 									= $address['District'];
 							$shippingDetail[$i]['stateOrRegion'] 							= $address['StateOrRegion'];
 							$shippingDetail[$i]['postalCode'] 								= $address['PostalCode'];
 							$shippingDetail[$i]['countryCode'] 								= $address['CountryCode'];
 							$shippingDetail[$i]['phone'] 											= $address['Phone'];
 							$shippingDetail[$i]['orderRefId'] 								= $order->getAmazonOrderId();
 							$i++;
 						}
 						else
 						{
 							$UpOrderDetail[$upNo]['orderRef']									=	$order->getAmazonOrderId();
 							$UpOrderDetail[$upNo]['purchaseDate']							=	$order->getPurchaseDate();
 							$UpOrderDetail[$upNo]['lastUpdatedDate']					=	$order->getLastUpdateDate();
 							$UpOrderDetail[$upNo]['orderStatus']							=	$order->getOrderStatus();
 							$UpOrderDetail[$upNo]['fullFillmentChannel']			=	$order->getFulfillmentChannel();
 							$UpOrderDetail[$upNo]['salesChannel']							=	$order->getSalesChannel();
 							$UpOrderDetail[$upNo]['shipServiceLevel']					=	$order->getShipServiceLevel();
 							$UpOrderDetail[$upNo]['totalAmount']							=	$order->getOrderTotalAmount();
 							$UpOrderDetail[$upNo]['currencyCode']							=	$order->getOrderCurrencyCode();
 							$UpOrderDetail[$upNo]['numberOfItemsShipped']			=	$order->getNumberOfItemsShipped();
 							$UpOrderDetail[$upNo]['numberOfItemsUnshipped']		=	$order->getNumberOfItemsUnshipped();
 							$UpOrderDetail[$upNo]['paymentMethod']						=	$order->getPaymentMethod();
 							$UpOrderDetail[$upNo]['marketplaceId']						=	$order->getMarketplaceId();
 							$UpOrderDetail[$upNo]['buyerName']								=	$order->getBuyerName();
 							$UpOrderDetail[$upNo]['buyerEmail']								=	$order->getBuyerEmail();
 							$UpOrderDetail[$upNo]['earliestShipDate']					=	$order->getEarliestShipDate();
 							$UpOrderDetail[$upNo]['latestShipDate']						=	$order->getLatestShipDate();
 							$UpOrderDetail[$upNo]['earliestDeliveryDate']			=	$order->getEarliestDeliveryDate();
 							$UpOrderDetail[$upNo]['latestDeliveryDate']				=	$order->getLatestDeliveryDate();
 							$UpOrderDetail[$upNo]['status']										=	1;
 							$UpOrderDetail[$upNo]['modifiedDate']							= date('Y-m-d');
 							$address=$order->getShippingAddress();
 							$UpShippingDetail[$upNo]['customerName'] 					= $address['Name'];
 							$UpShippingDetail[$upNo]['addressLine1'] 					= $address['AddressLine1'];
 							$UpShippingDetail[$upNo]['addressLine2'] 					= $address['AddressLine2'];
 							$UpShippingDetail[$upNo]['addressLine3'] 					= $address['AddressLine3'];
 							$UpShippingDetail[$upNo]['city'] 									= $address['City'];
 							$UpShippingDetail[$upNo]['county'] 								= $address['County'];
 							$UpShippingDetail[$upNo]['district'] 							= $address['District'];
 							$UpShippingDetail[$upNo]['stateOrRegion'] 				= $address['StateOrRegion'];
 							$UpShippingDetail[$upNo]['postalCode'] 						= $address['PostalCode'];
 							$UpShippingDetail[$upNo]['countryCode'] 					= $address['CountryCode'];
 							$UpShippingDetail[$upNo]['phone'] 								= $address['Phone'];
 							$UpShippingDetail[$upNo]['orderRefId'] 						= $order->getAmazonOrderId();
 							$upNo++;
 						}
 										/***************************************************************************************************************
 						$recordExits = Order::checkExitsAmazonOrder('amazoneOrderItem',array('orderId' => $order->getAmazonOrderId()));
 						// $recordExits = 0 for record not exits
 						if($recordExits == 0 )
 						{
 								$amz = new AmazonOrderItemList("store1"); //store name matches the array key in the config file
 								$amz->setOrderId($order->getAmazonOrderId()); 	//oredrId to get order details form order
 								$amz->fetchItems();
 								$result =  $amz;
 								//echo "<pre>";print_r($result);
 								if(count($result) > 0)
 								{
 									foreach ($result as $orderItemData)
 									{
 										$orderArray[] 																= $order->getAmazonOrderId();
 											if(isset($orderItemData['ItemPrice']) && isset($orderItemData['ShippingPrice']))
 											{
 												if(strpos(	$orderItemData['Title'],'Apple') != false || strpos(	$orderItemData['Title'],'iPhone') != false || strpos(	$orderItemData['Title'],'Samsung') != false
 													|| strpos(	$orderItemData['Title'],'Mobile') != false || strpos(	$orderItemData['Title'],'Phone') != false || strpos(	$orderItemData['Title'],'Cell') != false )
 												{
 														$orderItem[$j]['itemRefId'] 									= Helper::unqNum();
 														$orderItem[$j]['orderId']											= $order->getAmazonOrderId(); // orderID
 														$orderItem[$j]['itemId'] 	  									= $orderItemData['OrderItemId'];
 														$orderItem[$j]['SellerSKU'] 									= $orderItemData['SellerSKU'];
 														$orderItem[$j]['ASIN'] 												=	$orderItemData['ASIN'];
 														$orderItem[$j]['itemTitle'] 									=	$orderItemData['Title'];
 														$orderItem[$j]['QuantityOrdered'] 						=	$orderItemData['QuantityOrdered'];
 														$orderItem[$j]['QuantityShipped'] 						=	$orderItemData['QuantityShipped'];
 														$orderItem[$j]['ItemPrice'] 									=	$orderItemData['ItemPrice']['Amount'];
 														$orderItem[$j]['ItemPriceCode'] 							=	$orderItemData['ItemPrice']['CurrencyCode'];
 														$orderItem[$j]['ShippingPrice'] 							=	$orderItemData['ShippingPrice']['Amount'];
 														$orderItem[$j]['ShippingPriceCode'] 					=	$orderItemData['ShippingPrice']['CurrencyCode'];
 														$orderItem[$j]['GiftWrapPrice'] 							=	$orderItemData['GiftWrapPrice']['Amount'];
 														$orderItem[$j]['GiftWrapPriceCode'] 					=	$orderItemData['GiftWrapPrice']['CurrencyCode'];
 														$orderItem[$j]['ItemTaxAmount'] 							=	$orderItemData['ItemTax']['Amount'];
 														$orderItem[$j]['ItemTaxCode'] 								=	$orderItemData['ItemTax']['CurrencyCode'];
 														$orderItem[$j]['ShippingTaxAmount'] 					=	$orderItemData['ShippingTax']['Amount'];
 														$orderItem[$j]['ShippingTaxCode'] 						=	$orderItemData['ShippingTax']['CurrencyCode'];
 														$orderItem[$j]['GiftWrapTaxAmount'] 					=	$orderItemData['GiftWrapTax']['Amount'];
 														$orderItem[$j]['GiftWrapTaxCode'] 						=	$orderItemData['GiftWrapTax']['CurrencyCode'];
 														$orderItem[$j]['ShippingDiscountAmount'] 			=	$orderItemData['ShippingDiscount']['Amount'];
 														$orderItem[$j]['ShippingDiscountCode'] 				=	$orderItemData['ShippingDiscount']['CurrencyCode'];
 														$orderItem[$j]['PromotionDiscountAmount'] 		=	$orderItemData['PromotionDiscount']['Amount'];
 														$orderItem[$j]['PromotionDiscountCode'] 			=	$orderItemData['PromotionDiscount']['CurrencyCode'];
 														$orderItem[$j]['createdDate'] 								= date('y-m-d');
 														$orderItem[$j]['modifiedDate'] 								= date('y-m-d');
 														$j++;
 												}
 											}
 									}// end foreach
 					 			}
 						}
 					} // end foreach
 		  }
 			// echo "<pre>";print_r($orderItem);
 			// echo "*******************END orderItem***************************************************";
 			// echo "<pre>";print_r($UpOrderDetail);
 			// echo "*******************END UpOrderDetail***************************************************";
 			// echo "<pre>";print_r($UpShippingDetail);
 			// echo "*******************END UpShippingDetail***************************************************";
 			// echo "<pre>";print_r($orderDetail);
 			// echo "*******************END orderDetail***************************************************";
 			// echo "<pre>";print_r($shippingDetail);
 			// echo "*******************END shippingDetail***************************************************";die;
 			$insertData 	= Order::insertAmazonOrderItems($orderItem);
 			$updateRecord = Order::updateAmazonBulkOrders($UpOrderDetail,$UpShippingDetail);
 			$date 				= Order::insertAmazonOrderDetail($orderDetail,$shippingDetail);
 		}
		*/

		public function amazonAddTracking(Request $request){
			/// Checking tracking number exits......
			$recordExits = Order::checkExitsAmazonOrder('amazonOrder',array('trackingNumber' => $request->get('trackNum')));
			if ($recordExits == 1) {
				echo 2; // for tracking number already exits
			} else {
				$resultVal =   Order::amazonAddTrackingNum($request->get('order'),$request->get('trackNum'));
				echo json_encode($resultVal);
			}
		}


		public function getAmazonOrder(){
			$obj = new AmazonReport("store1"); //store name matches the array key in the config file
			//echo '<pre>';print_r($obj);die;
		  $obj->setReportId('7150119098017485');
			 //	$obj->setReportTypes('_GET_MERCHANT_LISTINGS_ALL_DATA_'); //tells the object to automatically use tokens right away
				//$obj->setMarketplaces("ATVPDKIKX0DER");
			 // $obj->setTimeLimits("- 70 months","- 1 hours");
				 //$obj->requestReport(); //this is what actually sends the request
				 //$obj->getStatus();
				 $result =  $obj->fetchReport();
				 //$path = public_path().'/assets/inventoryImage/reportdata.php';
				 //$obj->saveReport($path);
				 echo '<pre>';
				                   print_r(json_decode(json_encode($result)));die;
			$obj = new AmazonReportRequestList("store1"); //store name matches the array key in the config file
			//echo '<pre>';print_r($obj);die;
		 // $obj->setRequestIds('241616017485');
			 //	$obj->setReportTypes('_GET_MERCHANT_LISTINGS_ALL_DATA_'); //tells the object to automatically use tokens right away
				//$obj->setMarketplaces("ATVPDKIKX0DER");
			 // $obj->setTimeLimits("- 70 months","- 1 hours");
				 //$obj->requestReport(); //this is what actually sends the request
				 //$obj->getStatus();
				 $result =  $obj->fetchRequestList();
				 $result1 =  $obj->getList();
				 echo '<pre>' ;print_r($result1);die;

				 $obj = new AmazonReportRequestList("store1"); //store name matches the array key in the config file
				 	//echo '<pre>';print_r($obj);die;
					// $obj->setRequestIds('241616017485');
					//	$obj->setReportTypes('_GET_MERCHANT_LISTINGS_ALL_DATA_'); //tells the object to automatically use tokens right away
					 //$obj->setMarketplaces("ATVPDKIKX0DER");
					// $obj->setTimeLimits("- 70 months","- 1 hours");
						//$obj->requestReport(); //this is what actually sends the request
						//$obj->getStatus();
						$result =  $obj->fetchRequestList();
						$result1 =  $obj->getList();
						echo '<pre>' ;print_r($result1);die;
						$obj = new AmazonReportList("store1"); //store name matches the array key in the config file
						//echo '<pre>';print_r($obj);die;
        		// $obj->setUseToken(); //tells the object to automatically use tokens right away
        		//$obj->setStartTime("- 70 months");

         $obj->fetchReportList(); //this is what actually sends the request
         $result =  $obj->getList();
				 echo '<pre>' ;print_r($result);die;
				 $obj = new AmazonInventoryList("store1"); //store name matches the array key in the config file
	 			//echo '<pre>';print_r($obj);die;
	 				 $obj->setUseToken(); //tells the object to automatically use tokens right away
	 				$obj->setStartTime("- 70 months");

	 				 $obj->fetchInventoryList(); //this is what actually sends the request
	 				 $result =  $obj->getSupply();
	 				 echo '<pre>' ;print_r($result);die;
			$obj = new AmazonInventoryList("store1"); //store name matches the array key in the config file
			//echo '<pre>';print_r($obj);die;
         $obj->setUseToken(); //tells the object to automatically use tokens right away
        $obj->setStartTime("- 70 months");

         $obj->fetchInventoryList(); //this is what actually sends the request
         $result =  $obj->getSupply();
				 echo '<pre>' ;print_r($result);
			$amz = new AmazonProduct("store1"); //store name matches the array key in the config file
			// $amz->setIdType('ASIN'); //accepts either specific timestamps or relative times
		//	 $amz->setProductIds("B0196HHDV6"); //no Amazon-fulfilled orders

			// $amz->setUseToken(); //tells the object to automatically use tokens right away
			 //$amz->fetchProductList(); //this is what actually sends the request
			 $result =  $amz->getData();
			 echo '<pre>' ;print_r($result);die;
			$amz = new AmazonProductList("store1"); //store name matches the array key in the config file
			 $amz->setIdType('ASIN'); //accepts either specific timestamps or relative times
			 $amz->setProductIds("B0196HHDV6"); //no Amazon-fulfilled orders

			// $amz->setUseToken(); //tells the object to automatically use tokens right away
			 $amz->fetchProductList(); //this is what actually sends the request
			 $result =  $amz->current();
			 echo '<pre>' ;print_r($result);die;
				$amz = new AmazonOrderList("store1"); //store name matches the array key in the config file
			 $amz->setLimits('Modified', "- 1 hours"); //accepts either specific timestamps or relative times
			 $amz->setFulfillmentChannelFilter("MFN"); //no Amazon-fulfilled orders
			 $amz->setOrderStatusFilter(
					 array("Unshipped", "PartiallyShipped", "Canceled", "Unfulfillable")
					 ); //no shipped or pending orders
			 $amz->setUseToken(); //tells the object to automatically use tokens right away
			 $amz->fetchOrders(); //this is what actually sends the request
			 $result =  $amz->getList();
			 echo '<pre>' ;print_r($result);die;
			$obj = new AmazonInventoryList("store1"); //store name matches the array key in the config file
			//echo '<pre>';print_r($obj);die;
         $obj->setUseToken(); //tells the object to automatically use tokens right away
         $obj->setStartTime("- 20 minutes");
         $obj->fetchInventoryList(); //this is what actually sends the request
         $result =  $obj->getSupply();
				 echo '<pre>' ;print_r($result);
		}
    public function dashboard()
    {
			$date = Order::getOrderMaxDate();
			$dateVal = explode('.',$date);

		include(app_path() . '/Services/ebay/getcommon/keys.php');
		//include(app_path() . '/Services/ebay/getcommon/eBaySession.php');
		//Helper::ebayOauthToken();
		$siteID = 0;
		//the call being made:
		$verb = 'GetOrders';
 	  //$CreateTimeFrom = gmdate("Y-m-d\TH:i:s",time()+86400);
		//Time with respect to GMT
		//by default retreive orders in last 30 minutes
		if($date == ''){
			$CreateTimeFrom = gmdate("Y-m-d\TH:i:s",time()-18000000); //current time minus 30 minutes
			$CreateTimeTo = gmdate("Y-m-d\TH:i:s");
		}
		else{
			$CreateTimeFrom = $dateVal[0]; //current time minus 30 minutes
			$CreateTimeTo = gmdate("Y-m-d\TH:i:s",time()+86400);
		}



		//If you want to hard code From and To timings, Follow the below format in "GMT".
		//$CreateTimeFrom = YYYY-MM-DDTHH:MM:SS; //GMT
		//$CreateTimeTo = YYYY-MM-DDTHH:MM:SS; //GMT

		// <OrderStatus>Active</OrderStatus>
		///Build the request Xml string
		$requestXmlBody  = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		/*$requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>
												<CreateTimeFrom>2016-01-01T20:34:44.000Z</CreateTimeFrom>
  											<CreateTimeTo>2018-11-10T20:34:44.000Z</CreateTimeTo>';*/
		 $requestXmlBody .= "<DetailLevel>ReturnAll</DetailLevel><CreateTimeFrom>$CreateTimeFrom</CreateTimeFrom><CreateTimeTo>$CreateTimeTo</CreateTimeTo>";
		$requestXmlBody .= '<OrderRole>Seller</OrderRole><IncludeFinalValueFee>True</IncludeFinalValueFee>';
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= '</GetOrdersRequest>';

		$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		$response = Helper::ebayApiResponse($responseXml);

		$response = json_decode(json_encode($response));
		//  echo '<pre>'; print_r($response); die;
		$method = '';
		$orderInfo = array();
		$orderInfoUpdate = array();

	if(count($response) > 0 ){
		if(count($response) > 1){
			$orderFetchDetail = $response->OrderArray->Order;
		}
		else{
			$orderFetchDetail = $response->OrderArray;
		}
		if (!empty($orderFetchDetail) && isset($orderFetchDetail->Order)) {

			foreach($orderFetchDetail->Order as $key => $orderDetail)
			{
				// echo "<pre>";print_r($orderDetail->ShippingAddress);
				//echo "<pre>";print_r($orderDetail->ShippingDetails->ShippingServiceOptions[0]->ShippingService); die;
				if(is_array($orderDetail->ShippingDetails->ShippingServiceOptions))
				{
					$ShippingService 					= $orderDetail->ShippingDetails->ShippingServiceOptions[0]->ShippingService;
					$ShippingServicePriority	= $orderDetail->ShippingDetails->ShippingServiceOptions[0]->ShippingServicePriority;
				}else {
					$ShippingService 					= $orderDetail->ShippingDetails->ShippingServiceOptions->ShippingService;
					$ShippingServicePriority	= $orderDetail->ShippingDetails->ShippingServiceOptions->ShippingServicePriority;
				}

				if(is_array($orderDetail->TransactionArray->Transaction))
				{
					//ECHO 'AAA'; DIE;
					$oItem									 = $orderDetail->TransactionArray->Transaction[0]->Item;
					$QuantityPurchased 			 = $orderDetail->TransactionArray->Transaction[0]->QuantityPurchased;
					$Email 									 = $orderDetail->TransactionArray->Transaction[0]->Buyer->Email;
					$UserFirstName 					 = $orderDetail->TransactionArray->Transaction[0]->Buyer->UserFirstName;
					$UserLastName 					 = $orderDetail->TransactionArray->Transaction[0]->Buyer->UserLastName;
					$TransactionID 					 = $orderDetail->TransactionArray->Transaction[0]->TransactionID;
					$FinalValueFee 					 = $orderDetail->TransactionArray->Transaction[0]->FinalValueFee;
					$TransactionPrice 			 = $orderDetail->TransactionArray->Transaction[0]->TransactionPrice;
					$TransactionSiteID       = $orderDetail->TransactionArray->Transaction[0]->TransactionSiteID;
					$Platform 							 = $orderDetail->TransactionArray->Transaction[0]->Platform;
					$TotalTaxAmount 				 = $orderDetail->TransactionArray->Transaction[0]->Taxes->TotalTaxAmount;

					// $OriginatingPostalCode = $orderDetail->TransactionArray->Transaction[0]->ShippingDetails->CalculatedShippingRate->OriginatingPostalCode;
					// $PackagingHandlingCosts = $orderDetail->TransactionArray->Transaction[0]->ShippingDetails->CalculatedShippingRate->PackagingHandlingCosts;
					$SellingManagerSalesRecordNumber = $orderDetail->TransactionArray->Transaction[0]->ShippingDetails->SellingManagerSalesRecordNumber;

					$ItemID 								 = $orderDetail->TransactionArray->Transaction[0]->Item->ItemID;
					$Site 									 = $orderDetail->TransactionArray->Transaction[0]->Item->Site;
					$Title 									 = $orderDetail->TransactionArray->Transaction[0]->Item->Title;
					$ConditionID 						 = $orderDetail->TransactionArray->Transaction[0]->Item->ConditionID;
					$ConditionDisplayName 	 = $orderDetail->TransactionArray->Transaction[0]->Item->ConditionDisplayName;

				}else {
					//echo 'sss';echo '<pre>'; print_r( $orderDetail->TransactionArray);print_r( $orderDetail->TransactionArray->Transaction->QuantityPurchased);
					$oItem 									 = $orderDetail->TransactionArray->Transaction->Item;
					$QuantityPurchased 			 = $orderDetail->TransactionArray->Transaction->QuantityPurchased;
					$Email 									 = $orderDetail->TransactionArray->Transaction->Buyer->Email;
					$UserFirstName 					 = $orderDetail->TransactionArray->Transaction->Buyer->UserFirstName;
					$UserLastName 					 = $orderDetail->TransactionArray->Transaction->Buyer->UserLastName;
					$TransactionID 					 = $orderDetail->TransactionArray->Transaction->TransactionID;
					$FinalValueFee 					 = $orderDetail->TransactionArray->Transaction->FinalValueFee;
					$TransactionPrice 			 = $orderDetail->TransactionArray->Transaction->TransactionPrice;
					$TransactionSiteID 			 = $orderDetail->TransactionArray->Transaction->TransactionSiteID;
					$Platform 							 = $orderDetail->TransactionArray->Transaction->Platform;
					$TotalTaxAmount 				 = $orderDetail->TransactionArray->Transaction->Taxes->TotalTaxAmount;

					// $OriginatingPostalCode = $orderDetail->TransactionArray->Transaction->ShippingDetails->CalculatedShippingRate->OriginatingPostalCode;
					// $PackagingHandlingCosts = $orderDetail->TransactionArray->Transaction->ShippingDetails->CalculatedShippingRate->PackagingHandlingCosts;
					$SellingManagerSalesRecordNumber = $orderDetail->TransactionArray->Transaction->ShippingDetails->SellingManagerSalesRecordNumber;
					$ItemID 												 = $orderDetail->TransactionArray->Transaction->Item->ItemID;
					$Site 													 = $orderDetail->TransactionArray->Transaction->Item->Site;
					$Title 													 = $orderDetail->TransactionArray->Transaction->Item->Title;
					$ConditionID 										 = $orderDetail->TransactionArray->Transaction->Item->ConditionID;
					$ConditionDisplayName 					 = $orderDetail->TransactionArray->Transaction->Item->ConditionDisplayName;
				}
				//echo $orderDetail->OrderID;
				// if($key == 'Order'){
				// 	$key = 0;
				// }
				$dateOrder = Order::getOrderById($orderDetail->OrderID);
				if(count($dateOrder) > 0){

					$orderInfoUpdate[$key]['orderRef'] 						= $orderDetail->OrderID;
					$orderInfoUpdate[$key]['orderStatus'] 				= $orderDetail->OrderStatus;
					$orderInfoUpdate[$key]['checkoutStatus'] 			= $orderDetail->CheckoutStatus->Status;
					$orderInfoUpdate[$key]['lastModifiedDate'] 		= $orderDetail->CheckoutStatus->LastModifiedTime;
					$orderInfoUpdate[$key]['modifiedDate'] 				= date('Y-m-d');
					$orderInfoUpdate[$key]['CreatedTime'] 				= $orderDetail->CreatedTime;

					if(isset($orderDetail->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber))
					{
						$orderInfoUpdate[$key]['trackingNumber'] = $orderDetail->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber;
					}
					else
					{
						$orderInfoUpdate[$key]['trackingNumber'] ='';
					}
				}
				else{
					//echo '<pre>';	print_r($orderDetail);die;
					$orderInfo[$key]['orderRef'] 									= $orderDetail->OrderID;
					$orderInfo[$key]['orderStatus'] 							= $orderDetail->OrderStatus;
					$orderInfo[$key]['checkoutStatus'] 						= $orderDetail->CheckoutStatus->Status;
					$orderInfo[$key]['amountPaid']  							= $orderDetail->AmountPaid;
					$orderInfo[$key]['subTotal'] 									= $orderDetail->Subtotal;
					$orderInfo[$key]['shippingService'] 					= $ShippingService;
					$orderInfo[$key]['shippingServiceCost'] 			= $orderDetail->ShippingServiceSelected->ShippingServiceCost;
					$orderInfo[$key]['shippingServicePriority'] 	= $ShippingServicePriority;
					$orderInfo[$key]['lastModifiedDate'] 					= $orderDetail->CheckoutStatus->LastModifiedTime;
					$orderInfo[$key]['CreatedTime'] 				      = $orderDetail->CreatedTime;
					$orderInfo[$key]['addedOn'] 									= date('Y-m-d');
					$orderInfo[$key]['modifiedDate'] 							= date('Y-m-d');
					if(isset($orderDetail->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber))
					{
						$orderInfo[$key]['trackingNumber'] = $orderDetail->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber;
					}
					else
					{
						$orderInfo[$key]['trackingNumber'] = '';
					}

					if(is_array($orderDetail->PaymentMethods))   {
						foreach($orderDetail->PaymentMethods as $keyMethod=>$payDetail){
							if($keyMethod == 1){
								$method = $payDetail;
							}
							else{
								$method = $method.','.$payDetail;
							}
							$orderInfo[$key]['paymentMethod'] = $method;
						}
					}
					else{
						$orderInfo[$key]['paymentMethod'] = $orderDetail->PaymentMethods;
					}
					$orderInfo[$key]['sellerEmail'] 				= $orderDetail->SellerEmail;
					$orderInfo[$key]['totalAmt'] 						= $orderDetail->Total;
					$orderInfo[$key]['totalItemPurchased'] 	= $QuantityPurchased;
					$orderInfo[$key]['buyerEmail'] 					= $Email;
					// $orderDetail['buyerFirstName'] 				= $orderDetail->TransactionArray->Transaction->UserFirstName;
					// $orderDetail['buyerLastName'] 					= $orderDetail->TransactionArray->Transaction->UserLastName;
					$orderInfo[$key]['buyerUserId'] 				= $orderDetail->BuyerUserID;


					$orderTransaction[$key]['orderRefId'] 	 				= $orderDetail->OrderID;
					$orderTransaction[$key]['transactionID'] 				= $TransactionID;
					$orderTransaction[$key]['FinalValueFee'] 				= $FinalValueFee;
					$orderTransaction[$key]['FinalValueFee'] 				= $FinalValueFee;
					$orderTransaction[$key]['ReferenceID'] 					= $orderDetail->MonetaryDetails->Payments->Payment->ReferenceID;
					$orderTransaction[$key]['PaymentAmount'] 				= $orderDetail->MonetaryDetails->Payments->Payment->PaymentAmount;
					$orderTransaction[$key]['FeeOrCreditAmount'] 		= $orderDetail->MonetaryDetails->Payments->Payment->FeeOrCreditAmount;
					$orderTransaction[$key]['transactionPrice'] 		= $TransactionPrice;
					$orderTransaction[$key]['transactionSiteId'] 		= $TransactionSiteID;
					$orderTransaction[$key]['platform'] 						= $Platform;
					$orderTransaction[$key]['totalTaxAmount'] 			= $TotalTaxAmount;
					$orderShipping[$key]['orderIdRef'] 							= $orderDetail->OrderID;
					if(isset($orderDetail->ShippingAddress))
					{
						$orderShipping[$key]['Name'] 									= $orderDetail->ShippingAddress->Name;
						$orderShipping[$key]['shippingName'] 					= $orderDetail->ShippingAddress->Name;
						$orderShipping[$key]['streetFirst'] 					= $orderDetail->ShippingAddress->Street1;
						$orderShipping[$key]['cityName'] 							= $orderDetail->ShippingAddress->CityName;
						$orderShipping[$key]['countryName'] 					= $orderDetail->ShippingAddress->CountryName;
						$orderShipping[$key]['postalCode'] 						= $orderDetail->ShippingAddress->PostalCode;
						$orderShipping[$key]['state'] 								= $orderDetail->ShippingAddress->StateOrProvince;
						$orderShipping[$key]['phone'] 								= $orderDetail->ShippingAddress->Phone;
					}
					if(isset($orderDetail->TransactionArray->Transaction->ShippingDetails->CalculatedShippingRate)){
						//$orderShipping[$key]['originalPostalCode'] = $OriginatingPostalCode;
						//$orderShipping[$key]['packagingHandlingCosts'] = $PackagingHandlingCosts;
						$orderShipping[$key]['sellingManagerSalesRecordNumber'] = $SellingManagerSalesRecordNumber;
					}
					else{
						$orderShipping[$key]['originalPostalCode'] 		 					= 0;
						$orderShipping[$key]['packagingHandlingCosts'] 					= 0;
						$orderShipping[$key]['sellingManagerSalesRecordNumber'] = 0;
					}


					foreach($oItem as $keyItem=>$itemDetail)
					{
						$orderItem[$key]['itemRefId'] 		= Helper::unqNum();
						$orderItem[$key]['orderId'] 			= $orderDetail->OrderID;
						$orderItem[$key]['itemId'] 				= $ItemID;
						$orderItem[$key]['site'] 					= $Site;
						$orderItem[$key]['itemTitle'] 		= $Title;
						$orderItem[$key]['conditionID'] 	= $ConditionID;
						$orderItem[$key]['conditionName'] = $ConditionDisplayName;
					}
				}

			}
		}
		//echo "sfadfasdfasdfasdf".$i;
		if(count($orderInfo) > 0){
			echo '<pre>';print_r($orderInfo);
			Order::orderDetails($orderInfo);
			Order::orderTransaction($orderTransaction);
			Order::orderItem($orderItem);
			Order::orderShipping($orderShipping);
		}
			if(count($orderInfoUpdate) > 0){
				echo '<pre>';print_r($orderInfoUpdate);
				Order::orderDetailsUpdate($orderInfoUpdate);
			}

}

		// echo '<pre>';print_r($response);die;
		// echo Helper::adminHeader();
		// return view('dashboard.index') ;

    }
		public function amazonShipment(Request $request)
		{
				$amz = new AmazonShipment('stroe1');
		}

		public function returnOrder(Request $request)
		{
			//print_r($_GET);die;

			$shipmentCharge    =  $request->get('shipmentCharge');
			$returnType  		   =  $request->get('returnType');
			$chargeName  		   =  $request->get('chargeName');
			$chargePrice 		   =  $request->get('chargePrice');
			$orderId 				   =  $request->get('orderId');
			$returnRef 				 =  $request->get('returnRef');
			$delReturnRef 		 =  $request->get('delReturnRef');
			$addRetunArray 		 =  array();
			$updateReturnArray =  array();

			for ($i = 0; $i < count($chargeName); $i++)
			{
				if(trim($returnRef[$i]) != '')
				{
					$updateReturnArray[$i] = array(
						'returnRef'        	=> $returnRef[$i],
						'orderId'        		=> $orderId,
						'returnType'        => $returnType,
						'ShippingCharge'    => $shipmentCharge,
						'returnTitle'       => $chargeName[$i],
						'returnCharge'      => str_replace(',','',$chargePrice[$i]),
						'addedOn'        		=> date('Y-m-d'),
						'modifiedDate'      => date('Y-m-d'),
					);

				}
				else
				{
					$addRetunArray[$i] = array(
						'returnRef'        	=> Helper::unqNum(),
						'orderId'        		=> $orderId,
						'returnType'        => $returnType,
						'ShippingCharge'    => $shipmentCharge,
						'returnTitle'       => $chargeName[$i],
						'returnCharge'      => str_replace(',','',$chargePrice[$i]),
						'addedOn'        		=> date('Y-m-d'),
						'addedBy'        		=> Session::get('amaEbaySessId'),
						'modifiedDate'      => date('Y-m-d'),
					);
				}
			}
			# Update order $status in Orders table
			/*
			$orderId = orders id;
			$uniqueName = "Table Name"
			*/
			if ($returnType == 1) {
				$tableName = "orderDetail";
			}else {
				$tableName = "amazonOrder";
			}
			$updateOrderDetails = Helper::updateOrderDetails($orderId,$tableName);
			$deleteRecords 			= Order::deleteReturnOrderItems($delReturnRef);
			$updateData		 			= Order::UpdateReturnCharges($updateReturnArray,'returnCharges');
			$insertData		 			= Order::commonInsert($addRetunArray,'returnCharges');
			echo json_encode($insertData);die;
		}
		public function getReturnOrderItems(Request $request)
		{
			$result = Order::getReturnOrderItems($request->get('orderId'));
			//PRINT_R($result); die;
			echo json_encode($result);die;
		}
		public function updateOrderStatus(Request $request)
		{
			$orderId 		= $request->get('orderId');
			$status  		= $request->get('status');
			$tableName  = $request->get('dataTo');
			$updateOrderStatus = Order::updateOrderStatus($orderId,$status,$tableName);
			echo json_encode($updateOrderStatus);die;
		}


		/*
		function to add add IMEI Number
		*/
		public function addIMEINumber(Request $request)
		{
			if($request->get('channel') == 'ebay')
			{
				$tabelname  = 'orderDetail';
			}else
			{
				$tabelname  = 'amazonOrder';
			}

			$recordExits = Order::checkExitsAmazonOrder($tabelname,array('IMEINumber' => $request->get('imieNum')));
			if ($recordExits == 1) {
				echo 2; // for IMEI number already exits
			} else {
				$data = array(
										'IMEINumber'	=> $request->get('imieNum'),
										'orderId'			=> $request->get('order'),
										'tableName'		=> $tabelname,
									);
				$resultVal =   Order::addIMEINumber($data);
				echo json_encode($resultVal);
			}
		}


		/** function for filter orders
		public function AmazonOrderFilter()
		{
					$orderItem = array();
					$result = Order::getAmazonOrders();
					//$orderId = $request->get('order');
					//echo "<pre>"; print_r($result);die;
					 $orderDetail = array();
					 $shippingDetail = array();
					 foreach ($result as $key => $value)
					 {
								$orderId = $value->orderRef;
								$recordExits = Order::checkExitsAmazonOrder('amazoneOrderItem',array('orderId' => $orderId));
								// $recordExits = 0 for record not exits
								if($recordExits == 0)
								{
									$amz = new AmazonOrderItemList("store1"); //store name matches the array key in the config file
									$amz->setOrderId($orderId); 	//oredrId to get order details form order
									$amz->fetchItems(); //no Amazon-fulfilled orders
									$result =  $amz;
									//echo "<pre>"; print_r($result);die;
									if(count($result) > 0)
									{
											$i = 0;
											foreach ($result as $order)
											{
														if(strpos($order['Title'],'Apple') != false || strpos($order['Title'],'iPhone') != false || strpos($order['Title'],'Samsung') != false || strpos($order['Title'],'Mobile') != false || strpos($order['Title'],'Phone') != false
														|| strpos($order['Title'],'Cell') != false || strpos($order['Title'],'LG') != false   )
														{
																$orderItem[$i]['itemRefId'] 									= Helper::unqNum();
																$orderItem[$i]['orderId']											= $orderId; // orderID
																$orderItem[$i]['itemId'] 	  									= @$order['OrderItemId'];
																$orderItem[$i]['SellerSKU'] 									= @$order['SellerSKU'];
																$orderItem[$i]['ASIN'] 												= @$order['ASIN'];
																$orderItem[$i]['itemTitle'] 									= @$order['Title'];
																$orderItem[$i]['QuantityOrdered'] 						= @$order['QuantityOrdered'];
																$orderItem[$i]['QuantityShipped'] 						= @$order['QuantityShipped'];
																$orderItem[$i]['ItemPrice'] 									= @$order['ItemPrice']['Amount'];
																$orderItem[$i]['ItemPriceCode'] 							= @$order['ItemPrice']['CurrencyCode'];
																$orderItem[$i]['ShippingPrice'] 							= @$order['ShippingPrice']['Amount'];
																$orderItem[$i]['ShippingPriceCode'] 					= @$order['ShippingPrice']['CurrencyCode'];
																$orderItem[$i]['GiftWrapPrice'] 							= @$order['GiftWrapPrice']['Amount'];
																$orderItem[$i]['GiftWrapPriceCode'] 					= @$order['GiftWrapPrice']['CurrencyCode'];
																$orderItem[$i]['ItemTaxAmount'] 							= @$order['ItemTax']['Amount'];
																$orderItem[$i]['ItemTaxCode'] 								= @$order['ItemTax']['CurrencyCode'];
																$orderItem[$i]['ShippingTaxAmount'] 					= @$order['ShippingTax']['Amount'];
																$orderItem[$i]['ShippingTaxCode'] 						= @$order['ShippingTax']['CurrencyCode'];
																$orderItem[$i]['GiftWrapTaxAmount'] 					= @$order['GiftWrapTax']['Amount'];
																$orderItem[$i]['GiftWrapTaxCode'] 						= @$order['GiftWrapTax']['CurrencyCode'];
																$orderItem[$i]['ShippingDiscountAmount'] 			= @$order['ShippingDiscount']['Amount'];
																$orderItem[$i]['ShippingDiscountCode'] 				= @$order['ShippingDiscount']['CurrencyCode'];
																$orderItem[$i]['PromotionDiscountAmount'] 		= @$order['PromotionDiscount']['Amount'];
																$orderItem[$i]['PromotionDiscountCode'] 			= @$order['PromotionDiscount']['CurrencyCode'];
																$orderItem[$i]['createdDate'] 								= date('y-m-d');
																$orderItem[$i]['modifiedDate'] 								= date('y-m-d');
																$i++;
													} // END IF
											}// END FOREACH
											$insertData = Order::insertAmazonOrderItems($orderItem);
								 } // END COUNT IF
							} // END IF
					 } // END FOREACH
		}


/*
** Return Orders
*/

public function getReturnOrders()
{
	$resultVal['EbayList'] 	 = 	 Order::getEbayReturnOrderList();
	$resultVal['AmazonList'] =   Order::getAmazonReturnOrder();
	if(isset($_GET['ajax'])){

				return view('returnOrders.searchReturnOrder',$resultVal) ;
	}
	else{
		echo Helper::adminHeader();
		return view('returnOrders.index',$resultVal) ;
	}
}
public function searchReturnList(Request $request){
	$resultVal['EbayList'] 		= 	Order::searchEbayReturnOrderList($request->get('lowerCase'),$request->get('upperCase'));
	$resultVal['AmazonList'] 	=   Order::searchAmazonReturnOrder($request->get('lowerCase'),$request->get('upperCase'));
	return view('returnOrders.searchReturnOrder',$resultVal) ;
}
public function getReturnChargesStatus(Request $request)
{
	$resultVal 	 =   Order::checkExitsAmazonOrder('returnCharges',array('orderId' => trim($request->get('order'))));
	echo json_encode($resultVal);die;
}

public function ebayStore(Request $request){

		include(app_path() . '/Services/ebay/getcommon/keys.php');
		$siteID = 0;
		//the call being made:
		$verb = 'GetTokenStatus';
		//Time with respect to GMT
		//by default retreive orders in last 30 minutes
		$CreateTimeFrom  = gmdate("Y-m-d\TH:i:s",time()-18000000); //current time minus 30 minutes
		$CreateTimeTo 	 = gmdate("Y-m-d\TH:i:s");
		///Build the request Xml string
		$requestXmlBody  =  '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetTokenStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= '</GetTokenStatusRequest>';
		$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);
		$response 	 = Helper::ebayApiResponse($responseXml);
		echo "<pre>";print_r($response);die;
}


}
?>
