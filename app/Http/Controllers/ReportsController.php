<?php

namespace App\Http\Controllers;
use Helper;
use Validator;
use Hash;
use Session;
use Redirect;
use URL;
//use App\User;
//use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Models\Order as Order;
use App\Http\Models\Inventory as Inventory;
use App\Http\Models\Reports as Reports;
use App\Services\ebay\getcommon;
use Sonnenglas\AmazonMws\AmazonOrderList;
use Sonnenglas\AmazonMws\AmazonShipmentList;
use Sonnenglas\AmazonMws\AmazonProductList;
use Sonnenglas\AmazonMws\AmazonReport;
use Sonnenglas\AmazonMws\AmazonMerchantServiceList;
use Sonnenglas\AmazonMws\AmazonReportList;
use Sonnenglas\AmazonMws\AmazonReportRequestList;
use Sonnenglas\AmazonMws\AmazonReportRequest;
use Sonnenglas\AmazonMws\AmazonOrderItemList;
use Sonnenglas\AmazonMws\AmazonFinancialEventList;
use Sonnenglas\AmazonMws\AmazonMerchantShipmentCreator;
use Sonnenglas\AmazonMws\AmazonMerchantShipment;
use DOMDocument;
class ReportsController extends Controller
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
	public function reports(){
			echo Helper::adminHeader();
			return view('reports.index') ;
	}

	 public function amazonFinance(){
		/***************************************************************************************************/
		$amz = new AmazonFinancialEventList("store1"); //store name matches the array key in the config file
		$amz->hasToken();
		//$amz->setMaxResultsPerPage(10);
		//$amz->setOrderFilter("114-5045256-0057859");
		$amz->setTimeLimits("-2 hours");
	  	$amz->fetchEventList();
		$result =  $amz->getShipmentEvents();
	  // echo "<pre>";print_r($amz);die;
		$orderItem   = array();
		$orderItemUp = array();
		$i 	= 0;
		$up = 0;
		if(!empty($result))
		{
			foreach ($result as $order)
			{

				// change date format............
				$date = new \DateTime($order['PostedDate']);
				foreach ($order['ShipmentItemList'] as $shipmentItemList)
				{
					// if order exits in db then insert data
					$orderExits = Order::checkExitsAmazonOrder('amazonOrder',array('orderRef' => $order['AmazonOrderId']));
          if ($orderExits == 1)

					{


								$recordExits = Order::checkExitsAmazonOrder('amazoneCommission',array('AmazonOrderId' => $order['AmazonOrderId'],'OrderItemId'=>$shipmentItemList['OrderItemId']));
								if ($recordExits == 0)
								{

								$orderItem[$i]['AmazonOrderId'] 							= $order['AmazonOrderId'];
								$orderItem[$i]['SellerOrderId'] 							= $order['SellerOrderId'];
								$orderItem[$i]['PostedDate'] 									= $date->format('Y-m-d');
								$orderItem[$i]['MarketplaceName'] 						= $order['MarketplaceName'];
								$orderItem[$i]['SellerSKU'] 									= $shipmentItemList['SellerSKU'];
								$orderItem[$i]['OrderItemId'] 								= $shipmentItemList['OrderItemId'];
								$orderItem[$i]['QuantityShipped'] 						= $shipmentItemList['QuantityShipped'];
								$orderItemUp[$i]['modifiedDate'] 						  = date('Y-m-d');
								// getting values of Charge list
								foreach ($shipmentItemList['ItemChargeList'] as $ItemChargeList)
								{
									if ($ItemChargeList['ChargeType'] == 'Principal')
									{
										$orderItem[$i]['ItemPrice'] 												= $ItemChargeList['Amount'];
										$orderItem[$i]['ItemPriceCode'] 										= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'Tax')
									{
										$orderItem[$i]['ItemTaxAmount'] 										= $ItemChargeList['Amount'];
										$orderItem[$i]['ItemTaxCode'] 											= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'GiftWrap')
									{
										$orderItem[$i]['GiftWrapPrice'] 										= $ItemChargeList['Amount'];
										$orderItem[$i]['GiftWrapPriceCode'] 								= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'GiftWrapTax')
									{
										$orderItem[$i]['GiftWrapTaxAmount'] 								= $ItemChargeList['Amount'];
										$orderItem[$i]['GiftWrapTaxCode'] 									= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'ShippingCharge')
									{
										$orderItem[$i]['ShippingCharge'] 										= $ItemChargeList['Amount'];
										$orderItem[$i]['ShippingChargeCode'] 								= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'ShippingTax')
									{
										$orderItem[$i]['ShippingTaxAmount'] 								= $ItemChargeList['Amount'];
										$orderItem[$i]['ShippingTaxCode'] 									= $ItemChargeList['CurrencyCode'];
									}

								}
								// getting values of ItemFeeList.................
								foreach ($shipmentItemList['ItemFeeList'] as $ItemFeeList)
								{
									if ($ItemFeeList['FeeType'] == 'Commission')
									{
										$orderItem[$i]['CommissionFeeAmt'] 									= $ItemFeeList['Amount'];
										$orderItem[$i]['CommissionFeeCode'] 								= $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'FixedClosingFee')
									{
										$orderItem[$i]['FixedClosingFee'] 									 = $ItemFeeList['Amount'];
										$orderItem[$i]['FixedClosingFeeCode'] 							 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'GiftwrapCommission')
									{
										$orderItem[$i]['GiftwrapCommissionAmt'] 						 = $ItemFeeList['Amount'];
										$orderItem[$i]['GiftwrapCommissionCode'] 						 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'SalesTaxCollectionFee')
									{
										$orderItem[$i]['SalesTaxCollectionFeeAmt'] 					 = $ItemFeeList['Amount'];
										$orderItem[$i]['SalesTaxCollectionFeeCode'] 				 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'ShippingHB')
									{
										$orderItem[$i]['ShippingHBAmt'] 										 = $ItemFeeList['Amount'];
										$orderItem[$i]['ShippingHBCode'] 										 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'VariableClosingFee')
									{
										$orderItem[$i]['VariableClosingFeeAmt'] 						 = $ItemFeeList['Amount'];
										$orderItem[$i]['VariableClosingFeeCode'] 						 = $ItemFeeList['CurrencyCode'];
									}
								}
								$i++;
							} // endIf
							else
							{
								$orderItemUp[$up]['AmazonOrderId'] 												= $order['AmazonOrderId'];
								$orderItemUp[$up]['SellerOrderId'] 												= $order['SellerOrderId'];
								$orderItemUp[$up]['MarketplaceName'] 											= $order['MarketplaceName'];
								$orderItemUp[$up]['SellerSKU'] 														= $shipmentItemList['SellerSKU'];
								$orderItemUp[$up]['OrderItemId'] 													= $shipmentItemList['OrderItemId'];
								$orderItemUp[$up]['QuantityShipped'] 											= $shipmentItemList['QuantityShipped'];
								//$orderItemUp[$up]['PostedDate'] 													= $date->format('Y-m-d');
								$orderItemUp[$up]['modifiedDate'] 											  = date('Y-m-d');
								// getting values of Charge list
								foreach ($shipmentItemList['ItemChargeList'] as $ItemChargeList)
								{
									if ($ItemChargeList['ChargeType'] == 'Principal')
									{
										$orderItemUp[$up]['ItemPrice'] 												= $ItemChargeList['Amount'];
										$orderItemUp[$up]['ItemPriceCode'] 										= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'Tax')
									{
										$orderItemUp[$up]['ItemTaxAmount'] 										= $ItemChargeList['Amount'];
										$orderItemUp[$up]['ItemTaxCode'] 											= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'GiftWrap')
									{
										$orderItemUp[$up]['GiftWrapPrice'] 										= $ItemChargeList['Amount'];
										$orderItemUp[$up]['GiftWrapPriceCode'] 								= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'GiftWrapTax')
									{
										$orderItemUp[$up]['GiftWrapTaxAmount'] 								= $ItemChargeList['Amount'];
										$orderItemUp[$up]['GiftWrapTaxCode'] 									= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'ShippingCharge')
									{
										$orderItemUp[$up]['ShippingCharge'] 									= $ItemChargeList['Amount'];
										$orderItemUp[$up]['ShippingChargeCode'] 							= $ItemChargeList['CurrencyCode'];
									}
									elseif ($ItemChargeList['ChargeType'] == 'ShippingTax')
									{
										$orderItemUp[$up]['ShippingTaxAmount'] 								= $ItemChargeList['Amount'];
										$orderItemUp[$up]['ShippingTaxCode'] 									= $ItemChargeList['CurrencyCode'];
									}

								}
								// getting values of ItemFeeList.................
								foreach ($shipmentItemList['ItemFeeList'] as $ItemFeeList)
								{
									if ($ItemFeeList['FeeType'] == 'Commission')
									{
										$orderItemUp[$up]['CommissionFeeAmt'] 								= $ItemFeeList['Amount'];
										$orderItemUp[$up]['CommissionFeeCode'] 								= $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'FixedClosingFee')
									{
										$orderItemUp[$up]['FixedClosingFee'] 									= $ItemFeeList['Amount'];
										$orderItemUp[$up]['FixedClosingFeeCode'] 							= $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'GiftwrapCommission')
									{
										$orderItemUp[$up]['GiftwrapCommissionAmt'] 						 = $ItemFeeList['Amount'];
										$orderItemUp[$up]['GiftwrapCommissionCode'] 					 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'SalesTaxCollectionFee')
									{
										$orderItemUp[$up]['SalesTaxCollectionFeeAmt'] 				 = $ItemFeeList['Amount'];
										$orderItemUp[$up]['SalesTaxCollectionFeeCode'] 				 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'ShippingHB')
									{
										$orderItemUp[$up]['ShippingHBAmt'] 										 = $ItemFeeList['Amount'];
										$orderItemUp[$up]['ShippingHBCode'] 									 = $ItemFeeList['CurrencyCode'];
									}
									elseif ($ItemFeeList['FeeType'] == 'VariableClosingFee')
									{
										$orderItemUp[$up]['VariableClosingFeeAmt'] 						 = $ItemFeeList['Amount'];
										$orderItemUp[$up]['VariableClosingFeeCode'] 					 = $ItemFeeList['CurrencyCode'];
									}
								}
								$up++;
							} // end Else
				}
			} // end ShipmentItemList loop
			}
			// pass two parm 1st data and 2d table name common function for insert data commonInsert();
			 echo "<pre>"; print_r($orderItem); echo "</pre>";
			 echo "************************************************";
			 echo "<pre>"; print_r($orderItemUp); echo "</pre>";
			$insertData = Order::commonInsert($orderItem,'amazoneCommission');
			$updateData = Reports::updateFinance($orderItemUp,'amazoneCommission');
		}
	}

	public function getCommissionData(){

		$result['ebayList']	 					= Reports::getEbayProfit();
		$result['amazonList'] 				= Reports::getAmazonProfit();
		$result['commsionSummary'] 		= Reports::getAmazonProfitSummary();
		$result['ebayProfitSummary']	= Reports::getEbayProfitSummary();

		//echo "<pre>";print_r($result['ebayProfitSummary']);die;
		if(isset($_GET['ajax'])){
					return view('reports.amazonReports.ajaxListCommission',$result);
		}
		else{
			echo Helper::adminHeader();
			return view('reports.amazonReports.commissionData',$result);
		}

	}
	public function searchCommissionData(Request $request){
		$resultVal['commissionData'] =   Reports::amazonCommissionData($request->get('lowerCase'),$request->get('upperCase'));
		return view('reports.amazonReports.ajaxListCommission',$resultVal);
	}

	public function trackTrackingNumber(Request $request)
  {
			echo Helper::adminHeader();
			return view('trackOrder.index') ;
  }
	public function getTrackOrderDetail(Request $request)
  {
		$orderSummary= "";
		if(isset($_GET['ajax']))
		{
			$trackingNumber = $_GET['lowerCase'];
			$url = "http://production.shippingapis.com/shippingAPI.dll";
			$service = "TrackV2";
			$xml = rawurlencode("
			<TrackRequest USERID='8641WAYI2638'>
			 <TrackID ID=\"".$trackingNumber."\"></TrackID>
			 </TrackRequest>");
			$requestUri = $url . "?API=" . $service . "&XML=" . $xml;
			// send the POST values to USPS
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$requestUri);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// parameters to post

			$result = curl_exec($ch);
			curl_close($ch);
			$response = new \SimpleXMLElement($result);
			//echo "<pre>";print_r($response->TrackInfo->TrackDetail); die();
			$orderSummary .= "<h2>".$response->TrackInfo->TrackSummary."</h2>";
			$orderSummary ."<ul class='list-group'>";
			foreach ($response->TrackInfo->TrackDetail as $key => $value) {
				$orderSummary .= "<li class='list-group-item'> <i class='fa fa-circle'></i> " . $value . "</li>";
			}
			$orderSummary .'</ul>';
			echo $orderSummary;
		}
  }
	public function imgConverter()
	{
		echo Helper::adminHeader();
		return view('trackOrder.convert') ;
	}
	public function pdfTojpgConverter()
	{
		 $baseName =  URL::asset('/assets/pdftojpg/');
		 $urlStr = Helper::unqNum();
		 $imageurl = $baseName.'/'.$urlStr;
		//echo $imageurl;die;
		 $post = @$_FILES['myfile'];
		// echo "<pre>"; print_r($_FILES);die;
		 $imagick = new \Imagick($post['tmp_name']);
		 $imagick->setResolution(350,350);
		// $imagick->readImage($post['tmp_name']);
		 $imagick->setImageFormat('jpeg');
		 //$imagick->writeImages('converted.jpg', false);
		 //$imagick->writeImage("converted.jpg");
		 $no_of_Pages =  $imagick->getNumberImages();
		 $images = array();
		 for ($i=0; $i < $no_of_Pages ; $i++)
		 {
				 $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
				 // Set iterator postion
				 $imagick->setIteratorIndex($i);
				 // Set image format
				 $imagick->setImageFormat('jpeg');
				 // Write Images to temp 'upload' folder
				 $imagick->writeImage($DOCUMENT_ROOT.'/ebayamazon/assets/pdftojpg/'.$urlStr.'-'.$i.'.jpg');
				 $images[] = $DOCUMENT_ROOT.'/ebayamazon/assets/pdftojpg/'.$urlStr.'-'.$i.'.jpg';
		 }
		 	$files = $images;
			$zipname = 'file.zip';
			$zip = new \ZipArchive;
			$zip->open($zipname, \ZipArchive::CREATE);
			foreach ($files as $file) {
			  $zip->addFile($file);
			}
			$zip->close();
			header('Content-Type: application/zip');
			header('Content-disposition: attachment; filename='.$zipname);
			header('Content-Length: ' . filesize($zipname));
			header('Expires: 0');
			header('Pragma: no-cache');
			readfile($zipname);
			unlink($zipname);
		  $imagick->destroy();
		 echo 1;
	}

	public function itemProfit()
	{
		$result['ebayItem'] 	= Reports::getEbayItemProfit();
		$result['amazonItem'] = Reports::getAmazonItemProfit();
		//echo "<pre>";print_r($result['amazonItem']);echo "</pre>";die;
		if(isset($_GET['ajax'])){
					return view('reports.itemProfit.searchItemProfit',$result);
		}else{
			echo Helper::adminHeader();
			return view('reports.itemProfit.index',$result) ;
		}
	}
	public function EbayItemProfitDetail(Request $request)
	{
		$itemId = $request->get('itemId');
		$result['itemProfitDetail'] = Reports::ebayItemProfitDetail($itemId);
		$result['itemDetail'] 			= Reports::ebayItemDetail($itemId);
		return view('reports.itemProfit.ebayItemProfitDetail',$result);
	}
	public function AmazonItemProfitDetail(Request $request)
	{
		$itemId = $request->get('itemId');
		$result['itemProfitDetail'] = Reports::amazonItemProfitDetail($itemId);
		$result['itemDetail'] 			= Reports::amazonItemDetail($itemId);
		// echo "<pre>";print_r($result);echo "</pre>";die;
		return view('reports.itemProfit.amazonItemProfitDetail',$result);
	}




}
?>
