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
use App\Http\Models\Inventory as Inventory;
use App\Services\ebay\getcommon;
use Sonnenglas\AmazonMws\AmazonFeed;
use DOMDocument;
class inventoryController extends Controller
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
    public function addInventory(Request $request)
    {
				if($_POST){
					$v = Validator::make($request->all(), [
								 'brandName'   => 'required',
								 'modelName' => 'required',
								 'invDate'   => 'required',
								 'color' => 'required',
								 'quantity'   => 'required',
								 'stockNumber'   => 'required',
								 'kitCost' => 'required',
								 'cost'   => 'required',

						 ]);

						 if ($v->fails()) {
		            return redirect()->back()->withErrors($v);
		         }
						 $img = $_POST['imagesName'];
						 unset($_POST['_token']);
						 unset($_POST['invImage']);
						 unset($_POST['imagesName']);
						 $_POST['productRef'] = Helper::unqNum();
						 $_POST['addedBy']=Session::get('amaEbaySessId');
							$result =   Inventory::addInventory($_POST,$img);
							echo json_encode($result);exit;
				}

				echo Helper::adminHeader();
				return view('inventory.index') ;

    }
		public function addImage(Request $request){
			$this->validate($request, [
					'invImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
			]);
			$imageName = time().'.'.$request->invImage->getClientOriginalExtension();
			$request->invImage->move(public_path('../assets/inventoryImage'), $imageName);
			echo json_encode($imageName);exit;
		}
		public function checkMEIMNum(Request $request,$id){
				$returnVal =   Inventory::checkNum($id);
				echo json_encode($returnVal);exit;
		}
		public function getInventory(){
			$resultVal['inventoryList'] =   Inventory::getInventoryList();
			if(isset($_GET['ajax'])){
						return view('inventory.inventorylistSearch',$resultVal) ;
			}
			else{
				echo Helper::adminHeader();
				return view('inventory.inventorylist',$resultVal) ;
			}

		}
		public function searchInventory(Request $request){
			$resultVal['inventoryList'] =   Inventory::searchInventoryList($request->get('lowerCase'),$request->get('upperCase'));
			return view('inventory.inventorylistSearch',$resultVal) ;
		}
		public function searchInventoryList(Request $request){
			$resultVal['inventoryList'] =   Inventory::searchInventory($request->get('lowerCase'),$request->get('upperCase'));
			return view('inventory.getInventorySearch',$resultVal) ;
		}
		public function getInventoryDetail(Request $request){
			$resultVal['inventoryInfo'] =   Inventory::getInventoryInfo($request->get('inventoryInfo'));
			return view('inventory.editInventory',$resultVal) ;
		}
		public function updateInventoryDetail(Request $request){
			$img = $_POST['imagesName'];
			unset($_POST['_token']);
			unset($_POST['invImage']);
			unset($_POST['imagesName']);
			$date = explode('/',$_POST['invDate']);
			$_POST['invDate'] = $date[2].'-'.$date[1].'-'.$date[0];
			$resultVal =   Inventory::updateInventory($_POST,$img);
			echo json_encode($resultVal);exit;
			//print_r($request->all());die;
		}
		public function addNewInventory(Request $request){
			$resultVal = array();
			echo Helper::adminHeader();
			return view('inventory.newInventory',$resultVal) ;
		}
		public function fetchProduct(Request $request){
				$resultProduct['productDetail'] = Inventory::getProductBySearch($request->get('productlower'),$request->get('productup'));
				return view('inventory.fetchProduct',$resultProduct) ;
		}
		public function productDetailByRef(Request $request){
			$resultProduct = Inventory::getProductDetails($request->get('productVal'));
			echo json_encode($resultProduct);exit;
		}
		public function getInventoryList(){
			$resultProduct['inventoryList'] = Inventory::getInventory();
			if(isset($_GET['ajax'])){
						return view('inventory.getInventorySearch',$resultProduct) ;
			}
			else{
				echo Helper::adminHeader();
				return view('inventory.getInventory',$resultProduct) ;
			}

		}
		public function addInventoryEbay(Request $request){
			$resultVal = array();
			if($_POST){
			//	echo '<pre>';	print_r($_POST);die;
			 $errors = Validator::make($request->all(), [
							'productId'   => 'required',
							'titleName' => 'required',
							'modelName' => 'required',
							'colorItem' => 'required',
							'quantityEbay' => 'required',
							'price' => 'required',
							'ImeNum' => 'required',
							'conditionId' => 'required',
							'country' => 'required',
							'duration' => 'required',
					]);
					if ($errors->fails()) {
						 return redirect()->back()->withErrors($errors);
					}
					$_POST['productRef'] = $request->input('productId');
					unset($_POST['productId']);
					//$returnVal = Inventory::ebayInventory($_POST);
		//	echo '<pre>';	print_r($_POST);die;
			 $resultProduct = Inventory::getInventoryInfo($_POST['productRef']);
			 unset($_POST['_token']);
			 $detailForm = $_POST;
			 $imgs = explode(',',$resultProduct[0]->imageName);
			 for($i=0;$i<count($imgs);$i++){
				 if($i == 0){
					 $images = '<PictureDetails><GalleryType>Gallery</GalleryType>
	 				<PictureURL>'.url('/assets/inventoryImage/'.$imgs[$i]).'</PictureURL>
		    </PictureDetails>';
				 }
				 else{
					 $images= $images.','.'<PictureDetails><GalleryType>Gallery</GalleryType>
	 				<PictureURL>'.url('/assets/inventoryImage/'.$imgs[$i]).'</PictureURL>
		    </PictureDetails>';
				 }
			 }
			 if($detailForm['description'] == ''){
				 $detailForm['description'] = 'Test Product';
			 }
			// print_r($result);
		//	print_r($_POST);die;
			include(app_path() . '/Services/ebay/getcommon/keys.php');
			//include(app_path() . '/Services/ebay/getcommon/eBaySession.php');
			//Helper::ebayOauthToken();
			$siteID = 0;
			//the call being made:
			$verb = 'AddItem';
			//Time with respect to GMT
			//by default retreive orders in last 30 minutes
			$CreateTimeFrom = gmdate("Y-m-d\TH:i:s",time()-18000000); //current time minus 30 minutes
			$CreateTimeTo = gmdate("Y-m-d\TH:i:s");
			//If you want to hard code From and To timings, Follow the below format in "GMT".
			//$CreateTimeFrom = YYYY-MM-DDTHH:MM:SS; //GMT
			//$CreateTimeTo = YYYY-MM-DDTHH:MM:SS; //GMT
			///Build the request Xml string
			$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBody .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBody .= '<Item>
	    <Title>'.$detailForm['titleName'].'</Title>
	    <Description>'.$detailForm['description'].'</Description>
	    <PrimaryCategory>
	      <CategoryID>9355</CategoryID>
	    </PrimaryCategory>
	    <StartPrice>'.$detailForm['price'].'</StartPrice>
	    <CategoryMappingAllowed>true</CategoryMappingAllowed>
	    <ConditionID>'.$detailForm['conditionId'].'</ConditionID>
	    <Country>US</Country>
	    <Currency>USD</Currency>
	    <DispatchTimeMax>3</DispatchTimeMax>
	    <ListingDuration>'.$detailForm['duration'].'</ListingDuration>
	    <ListingType>FixedPriceItem</ListingType>
	    <PaymentMethods>PayPal</PaymentMethods>
	    <PayPalEmailAddress>megaonlinemerchant@gmail.com</PayPalEmailAddress>
	    '.$images.'
	    <PostalCode>95125</PostalCode>
	    <ProductListingDetails>
	      <UPC>885909298594</UPC>
	      <IncludeStockPhotoURL>true</IncludeStockPhotoURL>
	      <IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>
	      <UseFirstProduct>false</UseFirstProduct>
	      <UseStockPhotoURLAsGallery>false</UseStockPhotoURLAsGallery>
	      <ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>
	    </ProductListingDetails>
	    <Quantity>'.$detailForm['quantityEbay'].'</Quantity>
	    <ReturnPolicy>
	      <ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
	      <RefundOption>MoneyBack</RefundOption>
	      <ReturnsWithinOption>Days_30</ReturnsWithinOption>
	      <Description>If you are not satisfied, return the item for refund.</Description>
	      <ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
	    </ReturnPolicy>
	    <ShippingDetails>
	      <ShippingType>Flat</ShippingType>
	      <ShippingServiceOptions>
	        <ShippingServicePriority>1</ShippingServicePriority>
	        <ShippingService>UPSGround</ShippingService>
	        <FreeShipping>true</FreeShipping>
	        <ShippingServiceAdditionalCost currencyID="USD">0.00</ShippingServiceAdditionalCost>
	      </ShippingServiceOptions>
	    </ShippingDetails>
	  </Item>';
	$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBody .= '</AddItemRequest>';
	$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBody);
			$response = Helper::ebayApiResponse($responseXml);
			//echo '<pre>';print_r($response);die;
			$detailForm['productRef'] 		= $detailForm['productRef'];
			$detailForm['version'] 				= $response->Version;
			$detailForm['build'] 					= $response->Build;
			$detailForm['ebayItemRef'] 		= $response->ItemID;
			$detailForm['startTimeEbay'] 	= $response->StartTime;
			$detailForm['endTimeEbay'] 		= $response->EndTime;
			$data = Inventory::addEbayList($detailForm);
			if($data == 1){
				$resultVal['addedSuccessfull'] = '<div class="ajax_report alert-message alert alert-success  updateclientdetails" role="alert" >
						<span class="ajax_message updateclientmessage">Inventory added and listed on ebay successfully.</span>
				</div>';
			}
			else if($data == 2){
				$resultVal['addedSuccessfull'] = '<div class="ajax_report alert-message alert alert-danger  updateclientdetails" role="alert" >
						<span class="ajax_message updateclientmessage">Inventory not added and list on ebay. Please try again.</span>
				</div>';
			}
			}

			echo Helper::adminHeader();
			return view('inventory.newInventory',$resultVal) ;
		//	echo json_encode($returnVal);exit;
		//	echo '<pre>';print_r($response);die;
		}
}
?>
