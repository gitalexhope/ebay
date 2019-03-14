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
use App\Http\Models\ShippingLabel as ShippingLabel;
use App\Services\ebay\getcommon;
use Sonnenglas\AmazonMws\AmazonMerchantShipmentCreator;
use Sonnenglas\AmazonMws\AmazonMerchantShipment;
use Sonnenglas\AmazonMws\AmazonMerchantServiceList;
include(app_path() . '/Services/stamps.com/vendor/autoload.php');
use Slicvic\Stamps\Address;
use Slicvic\Stamps\Api;

use DOMDocument;
class ShippingLabelController extends Controller
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
  public function getShippingDetails(Request $request)
  {
		if ($request->get('type') == "ebay") {
			$resultVal['orderDetail'] 		 =   Order::orderShipingDetailById($request->get('order'));
			echo json_encode($resultVal['orderDetail']); exit;
		}
		if ($request->get('type') == "amazon") {
			$resultVal['data'] 		 =   ShippingLabel::getServiceList($request->get('order'));
			$customerName     =     $resultVal['data']['amazonShipping'][0]->customerName;
			$addressLine1     =     $resultVal['data']['amazonShipping'][0]->addressLine1;
			$addressLine2     =     $resultVal['data']['amazonShipping'][0]->addressLine2;
			$addressLine3     =     $resultVal['data']['amazonShipping'][0]->addressLine3;
			$city             =     $resultVal['data']['amazonShipping'][0]->city;
			$county           =     $resultVal['data']['amazonShipping'][0]->county;
			$district         =     $resultVal['data']['amazonShipping'][0]->district;
			$stateOrRegion    =     $resultVal['data']['amazonShipping'][0]->stateOrRegion;
			$postalCode       =     $resultVal['data']['amazonShipping'][0]->postalCode;
			$countryCode      =     $resultVal['data']['amazonShipping'][0]->countryCode;
			$phone            =     $resultVal['data']['amazonShipping'][0]->phone;
			$orderRefId       =     $resultVal['data']['amazonShipping'][0]->orderRefId;
			$buyerEmail       =     $resultVal['data']['amazonShipping'][0]->buyerEmail;

			$amz = new AmazonMerchantServiceList("store1"); //store name matches the array key in the config file
			$amz->setOrderId($request->get('order'));
			// $amz->setMaxArrivalDate(date('Y-m-d'));
			$setPackageDimensionsArray = array(
				'Length'  => '5' ,
				'Width' 	=> '5',
				'Height'  => '5',
				'Unit'    => 'inches'
			);

			$amz->setPackageDimensions($setPackageDimensionsArray);
			$amz->setWeight(10);
			// $amz->setShipDate(date('Y-m-d', strtotime('+ 2 days')));
			$setAddressArray = array(
					'Name' 				 				=> 	ucwords($customerName) ,
					'AddressLine1' 				=> 	$addressLine1,
					'AddressLine2' 				=> 	$addressLine2,
					'AddressLine3' 				=> 	$addressLine3,
					'City' 				 				=> 	$city,
					'StateOrProvinceCode' => 	$stateOrRegion,
					'PostalCode' 					=> 	$postalCode,
					'CountryCode' 				=> 	$countryCode,
					'Email' 							=> 	$buyerEmail,
					'Phone' 							=> 	$phone,
				);

			$amz->setAddress($setAddressArray);
			// $amz->setPredefinedPackage('USPS_SmallFlatRateBox');
			$amz->setDeliveryOption('DeliveryConfirmationWithoutSignature');
			$amz->setCarrierWillPickUp(false);
			$amz->setDeclaredValue(2,'USD');
			$setItemsArray = array();
			foreach ($resultVal['data']['itemResult'] as $key => $value) {
				$setItemsArray[] = array(
					'OrderItemId'  => $value->itemId ,
					'Quantity' 		 => $value->QuantityOrdered,
				);
			}
			$amz->setItems($setItemsArray);
			$amz->fetchServices();
			$result = $amz->getServiceList();
			$data = array(
					"data" => $resultVal['data'],
					"getService" => $result
			);
			return view('shippinglabel.amazonLabel',$data);
		}

  }

  public function ebayPrintLabel(Request $request)
  {
    $orderID      = $request->get('orderID');
    $ShippingName = $request->get('ShippingName');
    $streetFirst  = $request->get('streetFirst');
    $streetSec    = $request->get('streetSec');
    $cityName     = $request->get('cityName');
    $state        = $request->get('state');
    $countryName  = $request->get('countryName');
    $phone        = $request->get('phone');
    $packageType  = $request->get('packageType');
    $labelType    = $request->get('labelType');
    $postalCode   = $request->get('postalCode');
    $serviceType  = $request->get('serviceType');
    $serviceType  = $request->get('serviceType');
    $setWeightOz  = $request->get('setWeightOz');

    if (!empty($_GET)) {
      $to = (new \Slicvic\Stamps\Address\Address)
              ->setFullname($ShippingName)
              ->setAddress1($streetFirst)
              ->setAddress2($streetSec)
              ->setCity($cityName)
              ->setState($state)
              ->setZipcode($postalCode)
              ->setCountry($countryName);

      $from = (new \Slicvic\Stamps\Address\Address)
          ->setFullname('Wsdeals')
          ->setAddress1('787 Woodlawn Dr')
          ->setAddress2('')
          ->setCity('Thousand oaks')
          ->setState('CA')
          ->setZipcode('91360')
          ->setCountry('US');

      try {
          $shippingLabel = (new \Slicvic\Stamps\Api\ShippingLabel)
              ->setApiUrl('') // Leave out for default
              ->setApiIntegrationId('bf1e6551-e4b5-44db-9230-58d6068f75c7')
              ->setApiUserId('1wayit-001')
              ->setApiPassword('postage1')
              ->setImageType($labelType)
              ->setPackageType($packageType)
              // ->setServiceType(\Slicvic\Stamps\Api\ShippingLabel::SERVICE_TYPE_FC)
							->setServiceType($serviceType)
              ->setFrom($from)
              ->setTo($to)
              ->setIsSampleOnly(false)
              ->setWeightOz($setWeightOz)
              ->setShipDate(date('Y-m-d'))
              ->setShowPrice(false);
          // Generate label and get URL to the PDF or PNG
          // Takes an optional filename argument to save label to file
          $indiciumResponse = $shippingLabel->create();


          $dataArray = array(
            "labelRef" 				=> Helper::unqNum(),
            "labelType" 			=> 1,
            "orderId" 				=> $orderID,
            "shippingLabel" 	=> $indiciumResponse->URL,
            "StampsTxID" 			=> $indiciumResponse->StampsTxID,
            "IntegratorTxID" 	=> $indiciumResponse->IntegratorTxID,
            "TrackingNumber" 	=> $indiciumResponse->TrackingNumber,

          );
					// $updateOrderTrackingNum = ShippingLabel::updateEbayTrackingNum($dataArray,$orderID);

          $checkExits = Order::checkExits('shippingLabels',array("orderId" => $orderID));
          if($checkExits == 0){
            $dataArray['addedOn'] = date('Y-m-d');
            $dataArray['modifiedDate'] = date('Y-m-d');
            $data = Order::commonInsert($dataArray,'shippingLabels');
          }else{
            $dataArray['modifiedDate'] = date('Y-m-d');
            $data = ShippingLabel::ShippingLabelUpdate($dataArray);
          }
          $result = array("data"=> $data,"success" => true,"successMessage"=>"Label Created successfully",'labelUrl' => $indiciumResponse->URL);
      } catch(\Exception $e) {
        $result = array(
					"success" => false,
					"exception" => $e
				);
      }
    }else{
      $result = array(
        "success" => false,
        "error" => "Whoops, looks like something went wrong please try again",
      );
    }
    echo json_encode($result); die;
  }

	public function amazonShippingLabel(Request $request)
	{
		/*
			// echo "<pre>"; print_r($_GET);
		  $resultVal 		 =   ShippingLabel::getServiceList($request->get('orderID'));
			// echo "<pre>"; print_r($resultVal['itemResult']); die;
		$ShippingName					=					$request->get('ShippingName');
    $addressLine1					=					$request->get('addressLine1');
    $addressLine2					=					$request->get('addressLine2');
    $addressLine3					=					$request->get('addressLine3');
    $cityName							=					$request->get('cityName');
    $state								=					$request->get('state');
    $countryName					=					$request->get('countryName');
    $phone								=					$request->get('phone');
    $postalCode						=					$request->get('postalCode');
    $orderID							=					$request->get('orderID');
    $ShippingServiceId		=					$request->get('ShippingServiceId');
    $labelType						=					$request->get('labelType');
    $dimension						=					$request->get('dimension');
    $buyerEmail						=					$request->get('buyerEmail');

		$amz = new AmazonMerchantShipmentCreator("store1"); //store name matches the array key in the config file
		$amz->setService($ShippingServiceId);
		$amz->setOrderId($orderID);
		$amz->setCustomText('ABC123');
		$amz->setLabelId('AmazonOrderId');
		// $amz->setMaxArrivalDate(date('Y-m-d'));
		// $setPackageDimensionsArray = array(
		// 	'Length'  => '5' ,
		// 	'Width' 	=> '5',
		// 	'Height'  => '5',
		// 	'Unit'    => 'inches'
		// );
		// $amz->setPackageDimensions($setPackageDimensionsArray);
		$amz->setPredefinedPackage($dimension);
		$amz->setWeight(10,'oz');
		// $amz->setShipDate(date('Y-m-d', strtotime('+ 2 days')));
		$setAddressArray = array(
				'Name' 				 				=> 	ucwords($ShippingName) ,
				'AddressLine1' 				=> 	$addressLine1,
				'AddressLine2' 				=> 	$addressLine2,
				'AddressLine3' 				=> 	$addressLine3,
				'City' 				 				=> 	$cityName,
				'StateOrProvinceCode' => 	$state,
				'PostalCode' 					=> 	$postalCode,
				'CountryCode' 				=> 	$countryName,
				'Email' 							=> 	$buyerEmail,
				'Phone' 							=> 	$phone,
			);
		$amz->setAddress($setAddressArray);
		$amz->setDeliveryOption('DeliveryConfirmationWithoutSignature');
		$amz->setCarrierWillPickUp(false);
		$amz->setDeclaredValue(0,'USD');
		$amz->setLabelFormat($labelType);
		foreach($resultVal['itemResult'] as $value)
		{

			$setItemsArray1[] = array(
				'OrderItemId'  => $value->itemId,
				'Quantity' 		 => $value->QuantityOrdered,
			);
	}
		$amz->setItems($setItemsArray1);
		$amz->createShipment();
		$result = $amz->getShipment();
		$shipmentId = $result['ShipmentId'];
		$labeltypeResData =	$result['Label']['FileContents']['FileType'];
		$labeltypeRes = explode('/',$labeltypeResData);
		$fileData = gzdecode(base64_decode($result['Label']['FileContents']['Contents'];
		$dataArray = array(
			"labelRef" => Helper::unqNum(),
			"labelType" => 2,
			"orderId" => $orderID,
			"shippingLabelid" => $shipmentId,
		);
		$checkExits = Order::checkExits('shippingLabels',array("orderId" => $orderID));
		if($checkExits == 0){
			$dataArray['addedOn'] = date('Y-m-d');
			$dataArray['modifiedDate'] = date('Y-m-d');
			$data = Order::commonInsert($dataArray,'shippingLabels');
		}

*/
		$shipmentId =   '73486530-39d7-4c95-8edd-93d810cda505';
		$shipmentId =   '6e4af1f4-536b-44c9-988f-81a76d4820ca';
		$amz = new AmazonMerchantShipment("store1"); //store name matches the array key in the config file
		$amz->setShipmentId($shipmentId);
		$amz->fetchShipment();
		$result 					= $amz->getData();
		echo "<pre>";
		print_r($amz);
		die;
		$labeltypeResData =	$result['Label']['FileContents']['FileType'];
		$labeltypeRes 		= explode('/',$labeltypeResData);
		$result 					= $amz->getLabelFileContents();
		$fileData 				= $result;

		$data 						= $this->compress_output_option($fileData,end($labeltypeRes),$labeltypeResData);
		if($data)
			$resultArray = array("success" => true);
		else
			$resultArray = array("success" => false);
		echo json_encode($resultArray);

	}

	public function compress_output_option($output,$fileType,$labeltypeResData)
	{
			$DOCUMENT_ROOT 		= $_SERVER['DOCUMENT_ROOT'];
			//create file
			$fileName 				= Helper::unqNum().'.'.$fileType.'.gz';
			file_put_contents($DOCUMENT_ROOT.'/ebayamazon/assets/pdf/'.$fileName,' ');
			$filelocation 		= $DOCUMENT_ROOT.'/ebayamazon/assets/pdf/'.$fileName;
			$fp 						= gzopen($filelocation, "w");
			fwrite($fp, $output);
			fclose($fp);

			//This input should be from somewhere else, hard-coded in this example
			$file_name = $DOCUMENT_ROOT.'/ebayamazon/assets/pdf/'.$fileName;
			$buffer_size = 5096; // read 4kb at a time
			$out_file_name = str_replace('.gz', '', $file_name);
			$file = gzopen($file_name, 'rb');
			$out_file = fopen($out_file_name, 'wb');
			while (!gzeof($file)) {
			    fwrite($out_file, gzread($file, $buffer_size));
			}
			// $fileName = explode('.gz', $fileName);
			// Files are done, close files
			Session::set('shippingLabelInfo',$fileName);
			Session::set('fileType', $fileType);
			fclose($out_file);
			gzclose($file);
			return false;

	}

	public function downloadAmzShipLable()
	{
		$shippingLabelInfo	 	= 	Session::get('shippingLabelInfo');
		$gzipfile = $shippingLabelInfo;
		$shippingLabelInfo 		= explode('.gz', $shippingLabelInfo);
		$fileType	 						= 	Session::get('fileType');

		if (!empty($shippingLabelInfo) && trim($fileType) !="")
		{
			// Session::forget('shippingLabelInfo');
		  // Session::forget('fileType');
			$fileName  			=   $shippingLabelInfo[0];
			$DOCUMENT_ROOT 	= 	$_SERVER['DOCUMENT_ROOT'];
			$upload_path 		= 	$DOCUMENT_ROOT.'/ebayamazon/assets/pdf/'.$shippingLabelInfo[0];
			$headers 				= 	['Content-Type:"application/'.$fileType.'"'];
			#$fileName 			= 	time().'.pdf';
			unlink($DOCUMENT_ROOT.'/ebayamazon/assets/pdf/'.$gzipfile);
			return response()->download($upload_path,$fileName,$headers)->deleteFileAfterSend(true);
		}
}
		public function getShippingLabel(Request $request)
		{
				if (trim($request->get('shipmentId') !="")) {
						$shipmentId =  $request->get('shipmentId');
				}else {
						$shipmentId =   '6e4af1f4-536b-44c9-988f-81a76d4820ca';
				}
				$amz = new AmazonMerchantShipment("store1"); //store name matches the array key in the config file
				$amz->setShipmentId($shipmentId);
				$amz->fetchShipment();
				$result 					= $amz->getData();
				$labeltypeResData =	$result['Label']['FileContents']['FileType'];
				$labeltypeRes 		= explode('/',$labeltypeResData);
				$result 					= $amz->getLabelFileContents();
				$fileData 				= $result;
				$data 						= $this->compress_output_option($fileData,end($labeltypeRes),$labeltypeResData);
				if($data)
					$resultArray = array("success" => true);
				else
					$resultArray = array("success" => false);
				echo json_encode($resultArray);
		}



}
?>
