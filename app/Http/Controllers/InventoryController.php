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
use App\Http\Models\Order as Order;
use App\Services\ebay\getcommon;
use Sonnenglas\AmazonMws\AmazonFeed;
use Sonnenglas\AmazonMws\AmazonInventoryList;
use Sonnenglas\AmazonMws\AmazonFeedResult;
use Sonnenglas\AmazonMws\AmazonFeedList;
use Sonnenglas\AmazonMws\AmazonReportList;
use Sonnenglas\AmazonMws\AmazonReport;
use Sonnenglas\AmazonMws\AmazonReportRequest;
use Sonnenglas\AmazonMws\AmazonReportRequestList;
use Sonnenglas\AmazonMws\AmazonProductInfo;
use Sonnenglas\AmazonMws\AmazonProductSearch;
use Sonnenglas\AmazonMws\AmazonOrderItemList;

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
			$resultVal['matchingList'] 			=   Inventory::searchMatchingInventory($request->get('lowerCase'),$request->get('upperCase'));
			$resultVal['inventoryList'] 			=   Inventory::searchInventory($request->get('lowerCase'),$request->get('upperCase'));
			$resultVal['amazonInventoryList'] =   Inventory::searchAmazonInventory($request->get('lowerCase'),$request->get('upperCase'));
			// echo "<pre>";print_r($resultVal);die;
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
			$matchingInventory = Inventory::getMatchingInventory();
			$ebayInventory	 	 = Inventory::getEbayInventory();
			$amazonInventory 	 = Inventory::getAmazonInventory();
			$resultVal = array(
												'matchingList'  		 	=> $matchingInventory,
												'inventoryList'			 	=> $ebayInventory,
												'amazonInventoryList'	=> $amazonInventory,
												);
			if(isset($_GET['ajax'])){
				return view('inventory.getInventorySearch',$resultVal) ;
			}
			else{
				echo Helper::adminHeader();
				return view('inventory.getInventory',$resultVal) ;
			}
		}
		public function addInventoryEbay(Request $request)
		{
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
			/***************--------------------------------------------*************/
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
			if (trim($detailForm['titleName']) !='' && trim($detailForm['modelName']) !='') {
				$titleName = $detailForm['titleName'].' '.$detailForm['modelName'];
			}
			else
			{
				$titleName = $detailForm['titleName'];
			}
			$requestXmlBodyAddItem = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBodyAddItem .= '<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBodyAddItem .= '<Item>
	    <Title>'.trim($titleName).'</Title>
	    <Description>'.strip_tags($detailForm['description']).'</Description>
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
			<ItemSpecifics>
					<NameValueList>
							<Name>Brand</Name>
							<Value>Sumsung</Value>
					</NameValueList>
					<NameValueList>
							<Name>MPN</Name>
							<Value>BrandMPN</Value>
					</NameValueList>
			</ItemSpecifics>
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
	$requestXmlBodyAddItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	$requestXmlBodyAddItem .= '</AddItemRequest>';
	$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBodyAddItem);
			$response = Helper::ebayApiResponse($responseXml);
			//echo '<pre>';print_r($response);
			$detailForm['productRef'] 		= $detailForm['productRef'];
			$detailForm['version'] 				= $response->Version;
			$detailForm['build'] 					= $response->Build;
			$detailForm['ebayItemRef'] 		= $response->ItemID;
			$detailForm['startTimeEbay'] 	= $response->StartTime;
			$detailForm['endTimeEbay'] 		= $response->EndTime;
			$detailForm['addedOn'] 				= date('Y-m-d');
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

		public function amazonProductsSearch(){

			// $obj = new AmazonReportRequest("store1");
		  // $obj->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
		  // $obj->requestReport();
		  // $result= $obj->getResponse();
			// // echo '<pre>' ;print_r($result);
			// sleep(260);
		  // $obj = new AmazonReportRequestList("store1");
		  // $obj->setUseToken();
			// $obj->setRequestIds($result['ReportRequestId']);
		  // $obj->setReportTypes('_GET_MERCHANT_LISTINGS_DATA_');
		  // $obj->fetchRequestList();
		  // $result =  $obj->getList();
			//
		  // $obj = new AmazonReport("store1");
		  // $obj->setReportId($result[0]['GeneratedReportId']);
		  // $resultArray =  $obj->fetchReport();
		  // echo '<pre>' ;print_r($resultArray);
			//
			// $rows = explode("\t", $resultArray);
      //       if (!empty($rows)) {
      //           if (isset($rows[0]) && $rows[0] == 'item-name') {
      //               $reportData = array_chunk($rows, 39);
			// 							echo '<pre>' ;print_r($reportData);
      //           }
      //       }
			// 			die;
			$xml ='<?xml version="1.0" encoding="utf-8"?>
								<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
								<Header>
									<DocumentVersion>1.01</DocumentVersion>
									<MerchantIdentifier>$merchant_token</MerchantIdentifier>
								</Header>
								<MessageType>Price</MessageType>
								<Message>
									<MessageID>1</MessageID>
									<Price>
									<SKU>KL-N77D-C702</SKU>
									<StandardPrice currency="USD">50</StandardPrice>
									</Price>
								</Message>
							 </AmazonEnvelope>';


							/*$xml = '<?xml version="1.0"?>
													<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
														<Header>
																<DocumentVersion>1.01</DocumentVersion>
																<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
														</Header>
														<MessageType>Inventory</MessageType>
														<Message>
																<MessageID>1</MessageID>
																<OperationType>Update</OperationType>
																<Inventory>
																	<SKU>KL-N77D-C702</SKU>
																	<Quantity>45</Quantity>
																  <FulfillmentLatency>1</FulfillmentLatency>
																</Inventory>
														</Message>
												</AmazonEnvelope>';*/
											//***********Quantity Update*************//
							 // $amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
 							 // $amz->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
 							 // $amz->setMarketplaceIds('ATVPDKIKX0DER');
 							 // $amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
 							 // $amz->submitFeed(); //this is what actually sends the request
 							 // $result1 = $amz->getResponse();
 							 // echo json_encode($result1);die;

							 // $amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
							 // $amz->setFeedType("_POST_PRODUCT_PRICING_DATA_"); //feed types listed in documentation
							 // $amz->setMarketplaceIds('ATVPDKIKX0DER');
							 // $amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
							 // $amz->submitFeed(); //this is what actually sends the request
							 // $result = $amz->getResponse();
							 // echo json_encode($result);die;
							//
							$amz=new AmazonFeedList("store1");
				 			$amz->setTimeLimits('- 10 min'); //limit time frame for feeds to any updated since the given time
				 			$amz->setFeedStatuses(array("_SUBMITTED_", "_IN_PROGRESS_", "_DONE_")); //exclude cancelled feeds
				 			$amz->fetchFeedSubmissions();
				 		  $result = $amz->getFeedList();
				 			echo "<pre>";print_r($result);die;
							//
							// $amz	=	new AmazonFeedResult("store1"); //store name matches the array key in the config file
							// $amz->setFeedId('107935017792'); //feed types listed in documentation
							// $amz->fetchFeedResult();
							// $result = $amz->getRawFeed();
							// echo "<pre>";print_r($amz);die;

							$xml = '<?xml version="1.0" encoding="utf-8" ?>
											<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd">
											<Header>
											<DocumentVersion>1.01</DocumentVersion>
											<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
											</Header>
											<MessageType>ProductImage</MessageType>
											<Message>
											<MessageID>1</MessageID>
											<OperationType>Update</OperationType>
											<ProductImage>
											<SKU>NL-N89D-C407</SKU>
											<ImageType>Main</ImageType>
											<ImageLocation>https://static.toiimg.com/photo/59980514/Samsung-Galaxy-Note-9.jpg</ImageLocation>
											</ProductImage>
											</Message>
											</AmazonEnvelope>';
/*<ASIN>B07HFTG5MN</ASIN>*/
							$amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
							$amz->setFeedType("_POST_PRODUCT_IMAGE_DATA_"); //feed types listed in documentation
							$amz->setMarketplaceIds('ATVPDKIKX0DER');
							$amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
							$amz->submitFeed(); //this is what actually sends the request
							$result1 = $amz->getResponse();
							echo json_encode($result1);die;
		}

		public function amazonProduct()
		{
			// php artisan cache:clear
			// php artisan view:clear
			// php artisan route:clear
			// php artisan clear-compiled
			//  php artisan config:cache
			// $obj = new AmazonReport("store1"); //store name matches the array key in the config file
		  // $obj->setReportId('7502002245017512');
			// $result =  $obj->fetchReport();
			// echo '<pre>';print_r($result);die;
			// /***************** ReportRequestId **********/
			// $obj = new AmazonReportRequest("store1"); //store name matches the array key in the config file
		  // $obj->setReportType('_GET_MERCHANT_LISTINGS_ALL_DATA_');
			// $obj->setTimeLimits('- 1 year');
			// $obj->requestReport();
			// $result= $obj->getResponse();
			// echo '<pre>';print_r($result);die;
			//
			// /********** AmazonReportRequestList getting GeneratedReportId */
			// $obj = new AmazonReportRequestList("store1"); //store name matches the array key in the config file
			// $obj->setUseToken(); //tells the object to automatically use tokens right away
			// $obj->setRequestIds('77150017512');
			// //$obj->setReportTypes(' _GET_XML_ALL_ORDERS_DATA_BY_LAST_UPDATE_'); //this is what actually sends the request
			// //$obj->setTimeLimits('- 72 hours','- 1 hour');
			// $obj->fetchRequestList(); //this is what actually sends the request
			// $result =  $obj->getList();
			// echo '<pre>' ;print_r($result);die;
			//
			//
			// $obj 	= new AmazonFeedList("store1"); //store name matches the array key in the config file
			// $obj->setUseToken();
			// $obj->fetchFeedSubmissions(); //tells the object to automatically use tokens right away
			// $obj->setFeedTypes('_POST_PRODUCT_DATA_'); //tells the object to automatically use tokens right away
			// $obj->fetchFeedSubmissions();
			// $result = $obj->getFeedList();
			// echo "<pre>";print_r($result);die;
			//

			// $obj 	= new AmazonFeedResult("store1"); //store name matches the array key in the config file
			// $obj->setFeedId('76293017504'); //tells the object to automatically use tokens right away
			// $obj->fetchFeedResult();
			// $result = $obj->getRawFeed();
			// echo "<pre>";print_r($obj);die;
			//
			//

		$xml = '<?xml version="1.0"?>
								<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
									<Header>
											<DocumentVersion>1.01</DocumentVersion>
											<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
									</Header>
									<MessageType>Inventory</MessageType>
									<Message>
										 <MessageID>1</MessageID>
										 <OperationType>Update</OperationType>
										 <Product>
												 <SKU>QW-N365-L454</SKU>
												 <ProductTaxCode>A_GEN_TAX</ProductTaxCode>
												 <LaunchDate>2016-12-19T16:00:00-08:00</LaunchDate>
												 <DescriptionData>
														 <Title>Samsung Galaxy S9</Title>
														 <Brand>Samsung</Brand>
																		 <Description>A richly hydrating all-natural lipstick in shades that complement every skin tone.</Description>
																		 <BulletPoint>This all-natural lipstick is handmade with nourishing botanicals and precisely blended pigments to glide on smoothly and deliver full color payoff. Each shade creates a universally flattering effect to match any mood.   Rosewater, a sheer blushing rose. Stardust, a sheer neutral with pink and brown undertones. Undone, a semi-matte, full-coverage pink-brown neutral. Darkroom, a semi-matte, full-coverage plum.</BulletPoint>
																		 <BulletPoint>Green tea, rosehip, and grapeseed oils are powerful antioxidants that heal cells and fight free radicals to reverse environmental damage.</BulletPoint>
																		 <BulletPoint>Mango and shea butters heal, moisturize, and protect lips while preventing formation of fine lines.</BulletPoint>
																		 <BulletPoint>Sweet orange oil is a collagen-booster with a luxurious, uplifting scent.</BulletPoint>
																		 <BulletPoint>Free of parabens, phthalates, and sulfates.</BulletPoint>
														 <Manufacturer>Kosas</Manufacturer>
														 <ItemType>Makeup</ItemType>
														 <IsGiftWrapAvailable>true</IsGiftWrapAvailable>
														 <IsGiftMessageAvailable>true</IsGiftMessageAvailable>
														 <IsDiscontinuedByManufacturer>false</IsDiscontinuedByManufacturer>
												 </DescriptionData>
												 <ProductData>
														 <Beauty>
																 <ProductType>
																		 <BeautyMisc>
																				 <VariationData>
																						 <Parentage>parent</Parentage>
																						 <VariationTheme>Color</VariationTheme>
																				 </VariationData>
																		 </BeautyMisc>
																 </ProductType>
														 </Beauty>
												 </ProductData>
										 </Product>
								 </Message>
								</AmazonEnvelope>';
			/***********************************/

			/*$xml = '<?xml version="1.0" ?>
								<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd">
								<Header>
									<DocumentVersion>1.01</DocumentVersion>
									<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
								</Header>
								<MessageType>Product</MessageType>
								<PurgeAndReplace>true</PurgeAndReplace>
								<Message>
										<MessageID>1</MessageID>
										<OperationType>Update</OperationType>
										<Product>
												<SKU>TY-D77F-G997</SKU>
												<ProductTaxCode>A_GEN_TAX</ProductTaxCode>
												<LaunchDate>2005-07-26T00:00:01</LaunchDate>
												<DescriptionData>
														<Title>Lyric 500 tc Queen Flat Sheet, Ivory</Title>
														<Brand>Peacock Alley</Brand>
														<Description>Lyric sheeting by Peacock Alley is the epitome of simple and classic elegance. The flat sheets
														and pillowcases feature a double row of hemstitching. The fitted sheets fit mattresses up to 21 inches deep.
														The sheets are shown at left with tone on tone monogramming, please call for monogramming details and prices.
														Please note, gift wrapping and overnight shipping are not available for this style.</Description>
														<BulletPoint>made in Italy</BulletPoint>
														<BulletPoint>500 thread count</BulletPoint>
														<BulletPoint>plain weave (percale)</BulletPoint>
														<BulletPoint>100% Egyptian cotton</BulletPoint>
														<Manufacturer>Peacock Alley</Manufacturer>
														<SearchTerms>bedding</SearchTerms>
														<SearchTerms>Sheets</SearchTerms>
														<ItemType>flat-sheets</ItemType>
														<IsGiftWrapAvailable>false</IsGiftWrapAvailable>
														<IsGiftMessageAvailable>false</IsGiftMessageAvailable>
														<RecommendedBrowseNode>60583031</RecommendedBrowseNode>
														<RecommendedBrowseNode>60576021</RecommendedBrowseNode>
												</DescriptionData>
												<ProductData>
													<Home>
														<Parentage>variation-parent</Parentage>
														<VariationData>
																<VariationTheme>Size-Color</VariationTheme>
														</VariationData>
														<Material>cotton</Material>
														<ThreadCount>500</ThreadCount>
													</Home>
												</ProductData>
										</Product>
								</Message>
								<Message>
								</AmazonEnvelope>';*/
			// $amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
			// $amz->setFeedType("_POST_PRODUCT_DATA_"); //feed types listed in documentation
			// $amz->setMarketplaceIds('ATVPDKIKX0DER');
			// $amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
			// $amz->submitFeed(); //this is what actually sends the request
			// $result = $amz->getResponse();
			// echo "<pre>";print_r($result);die;
			/********* check status of feed **/
			$amz=new AmazonFeedList("store1");
			$amz->setTimeLimits('- 1 hour'); //limit time frame for feeds to any updated since the given time
			$amz->setFeedStatuses(array("_SUBMITTED_", "_IN_PROGRESS_", "_DONE_")); //exclude cancelled feeds
			$amz->fetchFeedSubmissions();
		  $result = $amz->getFeedList();
			echo "<pre>";print_r($result);die;
			/** check status of feed **/
			$amz	=	new AmazonFeedResult("store1"); //store name matches the array key in the config file
			$amz->setFeedId('108093017793'); //feed types listed in documentation
			$amz->fetchFeedResult();
			$result = $amz->getRawFeed();
			echo "<pre>";print_r($amz);

		}

		public function manageEbayInventory()
		{
				$result['ebayInventory'] = Inventory::manageEbayInventory();
				echo "<pre>";print_r($result['ebayInventory']);
		}
		public function  duration_strtotime($str, $sho=FALSE)
		{
		    // REMOVE THE AMBIGUITY OF MONTH AND MINUTE -- MAKE MONTH = X
		    $arr = explode('T', $str);
		    $arr[0] = str_replace('M', 'X', $arr[0]);
		    $new = implode('T', $arr);

		    // EXPAND THE STRING INTO SOMETHING SENSIBLE
		    $new = str_replace('S', 'seconds ', $new);
		    $new = str_replace('M', 'minutes ', $new);
		    $new = str_replace('H', 'hours ',   $new);
		    $new = str_replace('T', ' ',        $new);
		    $new = str_replace('D', 'days',     $new);
		    $new = str_replace('X', 'months ',  $new);
		    $new = str_replace('Y', 'years ',   $new);
		    $new = str_replace('P', NULL,       $new);

		    if ($sho) var_dump($new);

		    // RETURN THE NUMBER OF SECONDS IN THE DURATION
		    return strtotime($new) - strtotime('NOW');
		}

		public function updateAmzInventoryQty($sku , $quantity){
			/**** Update Quantity in amazon *****/
			$xml = '<?xml version="1.0"?>
							<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
								<Header>
										<DocumentVersion>1.01</DocumentVersion>
										<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
								</Header>
								<MessageType>Inventory</MessageType>
								<Message>
										<MessageID>1</MessageID>
										<OperationType>Update</OperationType>
										<Inventory>
											<SKU>'.$sku.'</SKU>
											<Quantity>'.$quantity.'</Quantity>
											<FulfillmentLatency>1</FulfillmentLatency>
										</Inventory>
								</Message>
						</AmazonEnvelope>';

				 $amz1	=	new AmazonFeed("store1"); //store name matches the array key in the config file
				 $amz1->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
				 $amz1->setMarketplaceIds('ATVPDKIKX0DER');
				 $amz1->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
				 $amz1->submitFeed(); //this is what actually sends the request
				 $result1 = $amz1->getResponse();
				// echo json_encode($result1); die();
				 return true;
		}

		public function updateEbayInventoryQty($sellerSku,$quantity){
			include(app_path() . '/Services/ebay/getcommon/keys.php');
			$siteID = 0;


			$requestXmlBodyReviseItem = '<?xml version="1.0" encoding="utf-8"?>
				<GetSingleItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				  <!-- Call-specific Input Fields -->
				  <IncludeSelector>GetSingleItem</IncludeSelector>
				  <ItemID>183263579338</ItemID>
				  <VariationSKU>SMG930ASILVER</VariationSKU>
				  <MessageID> string </MessageID>
				</GetSingleItemRequest>';

				$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				//send the request and get response
				$responseXml = $session->sendHttpRequest($requestXmlBodyReviseItem);
				$response['ebay'] = Helper::ebayApiResponse($responseXml);
				echo json_encode($response);die;



			$verb = 'ReviseItem';
			$requestXmlBodyReviseItem  = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBodyReviseItem .= '<ReviseItem xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBodyReviseItem .= '<Item>
    																	<ItemID>'.$sellerSku.'</ItemID>
        															<Quantity>'.$productQuantity.'</Quantity>
  																</Item>';
			$requestXmlBodyReviseItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
			$requestXmlBodyReviseItem .= '</ReviseItem>';
			// Send Req To ebay to update product
			$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBodyReviseItem);
			$response['ebay'] = Helper::ebayApiResponse($responseXml);
			echo json_encode($response);die;
		}

		public function getEbayInventory()
		{
			$reportData = array();
			include(app_path() . '/Services/ebay/getcommon/keys.php');
			$verb = 'GetMyeBaySelling';
			$siteID = 0;
			$getMaxDate = Inventory::getEbayInvMaxDate();
			if(isset($getMaxDate->startTimeEbay) && $getMaxDate->startTimeEbay !='')
			{
				$CreateTimeFrom =$getMaxDate->startTimeEbay;
			}
			else
			{
				$CreateTimeFrom = gmdate("Y-m-d\TH:i:s",time()-18000000);
			}
			//current time minus 30 minutes
		  $CreateTimeTo = gmdate("Y-m-d\TH:i:s");
			$requestXmlBodyAddItem = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBodyAddItem .= '<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBodyAddItem .= '<ActiveList>
    																<Include>true</Include>
																		<DetailLevel>ReturnAll</DetailLevel>
  															 </ActiveList>';
			$requestXmlBodyAddItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
			$requestXmlBodyAddItem .= '</GetMyeBaySellingRequest>';
			$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBodyAddItem);
			$response = Helper::ebayApiResponse($responseXml);
			//  echo "<pre>";print_r($response->ActiveList->PaginationResult->TotalNumberOfPages);die;

			$pagecount = @$response->ActiveList->PaginationResult->TotalNumberOfPages;

			for ($i=1; $i <= $pagecount ; $i++) {
				$requestXmlBodyAddItem = '<?xml version="1.0" encoding="utf-8" ?>';
				$requestXmlBodyAddItem .= '<GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
				$requestXmlBodyAddItem .= '<ActiveList>
	    																<Include>true</Include>
																			<DetailLevel>ReturnAll</DetailLevel>
																	 <PaginationResult>
      											 			 		<TotalNumberOfEntries>10</TotalNumberOfEntries>
      											 			 		<TotalNumberOfPages>'.$i.'</TotalNumberOfPages>
    													 		</PaginationResult>
																	</ActiveList>';
				$requestXmlBodyAddItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
				$requestXmlBodyAddItem .= '</GetMyeBaySellingRequest>';
				$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				//send the request and get response
				$responseXml = $session->sendHttpRequest($requestXmlBodyAddItem);
				$response = Helper::ebayApiResponse($responseXml);

				//---------------------------------------------

					$itemArray = array();
					$itemUpdateArray = array();
					$variationData = array();
					if(is_array($response->ActiveList->ItemArray->Item))
					{
						$ebayData = $response->ActiveList->ItemArray->Item;
					}else{
						$ebayData[0] = $response->ActiveList->ItemArray->Item;
					}
					$iNo = 0;
					$upNo = 0;
					foreach ($ebayData as $key => $items)
					{
						$TimeLeft 	 = $items->TimeLeft;
			 			$dur 				 = InventoryController::duration_strtotime($TimeLeft);
						$t 					 = microtime(true);
						$micro 			 = sprintf("%03d",($t - floor($t)) * 1000);
						$utc = date('Y-m-d', strtotime("NOW + $dur SECONDS"));
						$endTimeEbay 				 = gmdate($utc.'\TH:i:s.', $t).$micro.'Z';

						$recordExits = Order::checkExitsAmazonOrder('ebayInventory',array('ebayItemRef' => $items->ItemID));
						if ($recordExits == 0)
						{
							$itemArray[$iNo]['productRef'] 													= 	Helper::unqNum();
							$itemArray[$iNo]['productSKU'] 													= 	(isset($items->SKU )) ? trim($items->SKU)  : "";
							$itemArray[$iNo]['country'] 														= 	'US';
							$itemArray[$iNo]['ebayItemRef'] 												= 	$items->ItemID;
							$itemArray[$iNo]['duration'] 														= 	$items->ListingDuration;
							$itemArray[$iNo]['price'] 															= 	$items->SellingStatus->CurrentPrice;
							$itemArray[$iNo]['quantityEbay'] 												= 	$items->QuantityAvailable;
							$itemArray[$iNo]['listingStatus'] 											=   'Active';
							$itemArray[$iNo]['titleName'] 													= 	$items->Title;
							$itemArray[$iNo]['startTimeEbay'] 											= 	$items->ListingDetails->StartTime;
							$itemArray[$iNo]['endTimeEbay'] 												= 	$endTimeEbay;
							$itemArray[$iNo]['addedOn'] 														= 	date('Y-m-d');
							$itemArray[$iNo]['modifiedDate'] 												= 	date('Y-m-d');
							$iNo++;
						}
						else
						{
							$itemUpdateArray[$iNo]['productSKU'] 													= 	(isset($items->SKU )) ? trim($items->SKU)  : "";
							$itemUpdateArray[$upNo]['country'] 											= 	'US';
							$itemUpdateArray[$upNo]['ebayItemRef'] 									= 	$items->ItemID;
							$itemUpdateArray[$upNo]['duration'] 										= 	$items->ListingDuration;
							$itemUpdateArray[$upNo]['price'] 												= 	$items->SellingStatus->CurrentPrice;
							$itemUpdateArray[$upNo]['quantityEbay'] 								= 	$items->QuantityAvailable;
							$itemUpdateArray[$upNo]['listingStatus'] 								=   'Active';
							$itemUpdateArray[$upNo]['titleName'] 										= 	$items->Title;
							$itemUpdateArray[$upNo]['startTimeEbay'] 								= 	$items->ListingDetails->StartTime;
							$itemUpdateArray[$upNo]['endTimeEbay'] 								  = 	$endTimeEbay;
							$itemUpdateArray[$upNo]['modifiedDate'] 								= 	date('Y-m-d');
							$upNo++;
						}

						if (isset($items->Variations)) {
							if( !empty($items->Variations->Variation)){
								foreach ($items->Variations->Variation as $key => $value) {
									if(isset($value->Quantity) && isset($value->SellingStatus->QuantitySold)){
										$qty = $value->Quantity - $value->SellingStatus->QuantitySold;
									}else{
										$qty = 0;
									}
									if(isset($value->SKU)){
									//	self::updateAmzInventoryQty($value->SKU,$qty);
									}
									$data['productSKU'] 						= (isset($value->SKU )) ? trim($value->SKU)  : "";
									$data['itemID'] 			 					= (isset($items->ItemID )) ? trim($items->ItemID)  : 0;
									$data['price'] 				 					= (isset($value->StartPrice )) ? trim($value->StartPrice)  : 0;
									$data['quantity'] 		 					= $qty;
									$data['color'] 				 					= (isset($value->VariationSpecifics->NameValueList->Value )) ? trim($value->VariationSpecifics->NameValueList->Value)  : "";
									$data['name'] 				 					= (isset($value->VariationTitle )) ? trim($value->VariationTitle)  : "";
									$variationData[] 	= $data;
								}

							}else{
								if(isset($items->QuantityAvailable)){
									$items->QuantityAvailable = $items->QuantityAvailable;
								}else{
									$items->QuantityAvailable = 0;
								}
								if(isset($items->SKU)){
									// self::updateAmzInventoryQty($items->SKU,$items->QuantityAvailable);
								}
							}
						}else{
							if(isset($items->QuantityAvailable)){
								$items->QuantityAvailable = $items->QuantityAvailable;
							}else{
								$items->QuantityAvailable = 0;
							}
							if(isset($items->SKU)){
								// self::updateAmzInventoryQty($items->SKU,$items->QuantityAvailable);
							}
						}

					}
				$result = Order::commonInsert($itemArray,'ebayInventory');
				$result = Inventory::updateEbayInventory($itemUpdateArray,'ebayInventory');
				if(!empty($variationData))
				{
					$insert = Inventory::insertVaritaion($variationData);
				}
		}
		echo 'Data updated successfully !'; die();
	}
		public function pullAmazonInventory()
		{
			$obj = new AmazonReportRequest("store1"); //store name matches the array key in the config file
		  $obj->setReportType('_GET_MERCHANT_LISTINGS_DATA_');
			// $obj->setTimeLimits('- 15 min');
			$obj->requestReport();
			$result= $obj->getResponse();
			// echo '<pre>';print_r($result['ReportRequestId']);die;
			sleep(120);
			$obj = new AmazonReportRequestList("store1"); //store name matches the array key in the config file
			$obj->setUseToken(); //tells the object to automatically use tokens right away
			// $obj->setTimeLimits('- 1 hour');
			$obj->setRequestIds($result['ReportRequestId']);
			$obj->setReportTypes('_GET_MERCHANT_LISTINGS_DATA_');
			$obj->fetchRequestList(); //this is what actually sends the request
			$result =  $obj->getList();
			echo '<pre>';print_r($result);
			$obj = new AmazonReport("store1"); //store name matches the array key in the config file
		  $obj->setReportId($result[0]['GeneratedReportId']);
			$resultArray =  $obj->fetchReport();
			// echo is_array($resultArray);
			// echo "<pre>";
			// print_r($resultArray);
			// die;
			$resultArray 	= explode("\t",$resultArray);
			$resultArray 	= array_chunk($resultArray,39);
			$resultArray[0][39]  = 'merchant-shipping-group';
			// echo '<pre>' ;print_r(explode(PHP_EOL, $resultArray[1][0]));die;

			$AddInvArray = array();
			$UpdateInvArray = array();
			$arrayAdd=0;
			$arrayUpdate=0;
			foreach (array_slice($resultArray,1) as $key => $value) {
				// echo '<pre>' ;print_r($value);
				if(strpos($value[0],'Samsung') != false || strpos($value[0],'Galaxy') != false || strpos($value[0],'Iphone') != false || strpos($value[0],'Mobile') != false || strpos($value[0],'Phone') != false )
				{
					$recordExits = Order::checkExitsAmazonOrder('amazonInventory',array('sellerSku' => $value[3]));
					// if($value[3]!="" && $value[5]!=""){
					// 	self::updateEbayInventoryQty($value[3],$value[5]);
					// }
					if ($recordExits == 0)
					{
						$AddInvArray[$arrayAdd]['productRef'] 								= 	Helper::unqNum();
						$AddInvArray[$arrayAdd]['itemName'] 									= 	explode(PHP_EOL, $value[0])[1] ;
						$AddInvArray[$arrayAdd]['itemDescription'] 						= 	$value[1];
						$AddInvArray[$arrayAdd]['listingId'] 									= 	$value[2];
						$AddInvArray[$arrayAdd]['sellerSku'] 									= 	$value[3];
						$AddInvArray[$arrayAdd]['price'] 											= 	$value[4];
						$AddInvArray[$arrayAdd]['quantity'] 									= 	$value[5];
						$AddInvArray[$arrayAdd]['openDate'] 									= 	$value[6];;
						$AddInvArray[$arrayAdd]['imageUrl'] 									= 	$value[7];
						$AddInvArray[$arrayAdd]['itemNote'] 									= 	$value[11];
						$AddInvArray[$arrayAdd]['itemCondition'] 							= 	$value[12];
						$AddInvArray[$arrayAdd]['ASIN'] 								    	= 	$value[16];
						$AddInvArray[$arrayAdd]['productId'] 									= 	$value[22];
						$AddInvArray[$arrayAdd]['pendingQuantity'] 						= 	$value[25];
						$AddInvArray[$arrayAdd]['fulfillmentChannel'] 				= 	$value[26];
					  $AddInvArray[$arrayAdd]['status'] 										= 	$value[28];
						$AddInvArray[$arrayAdd]['merchantShippingGroup'] 			= 	$value[38];
						$AddInvArray[$arrayAdd]['addedOn'] 										= 	date('Y-m-d');
						$AddInvArray[$arrayAdd]['modifiedDate'] 							= 	date('Y-m-d');
						$arrayAdd++;
					}
					else
					{
						$UpdateInvArray[$arrayUpdate]['itemName'] 									= 		explode(PHP_EOL, $value[0])[1] ;
						$UpdateInvArray[$arrayUpdate]['itemDescription'] 						= 	$value[1];
						$UpdateInvArray[$arrayUpdate]['listingId'] 									= 	$value[2];
						$UpdateInvArray[$arrayUpdate]['sellerSku'] 									= 	$value[3];
						$UpdateInvArray[$arrayUpdate]['price'] 											= 	$value[4];
						$UpdateInvArray[$arrayUpdate]['quantity'] 									= 	$value[5];
						$UpdateInvArray[$arrayUpdate]['openDate'] 									= 	$value[6];;
						$UpdateInvArray[$arrayUpdate]['imageUrl'] 									= 	$value[7];
						$UpdateInvArray[$arrayUpdate]['itemNote'] 									= 	$value[11];
						$UpdateInvArray[$arrayUpdate]['itemCondition'] 							= 	$value[12];
						$UpdateInvArray[$arrayUpdate]['ASIN'] 								    	= 	$value[16];
						$UpdateInvArray[$arrayUpdate]['productId'] 									= 	$value[22];
						$UpdateInvArray[$arrayUpdate]['pendingQuantity'] 						= 	$value[25];
						$UpdateInvArray[$arrayUpdate]['fulfillmentChannel'] 				= 	$value[26];
					  $UpdateInvArray[$arrayUpdate]['status'] 										= 	$value[28];
						$UpdateInvArray[$arrayUpdate]['merchantShippingGroup'] 			= 	$value[38];
						$UpdateInvArray[$arrayUpdate]['modifiedDate'] 							= 	date('Y-m-d');
						$arrayUpdate++;
					}
				}
			}
			echo "<pre>"; print_r($UpdateInvArray);
			echo "endUpdateArray***************************************************************************************";
			echo "<pre>"; print_r($AddInvArray);
			//die;
			$updateInv  = Inventory::UpdateAmazonInventory($UpdateInvArray,'amazonInventory');
			$insertData = Order::commonInsert($AddInvArray,'amazonInventory');
		}
public function deleteProduct(Request $request)
{
	$data['productRef'] = $request->get('productRef');
	$data['dataTable']  = $request->get('dataTo');
	$result = Inventory::deleteProduct($data);
	echo json_encode($result);die;
}

public function getActiveInvProductData(Request $request){
	$data['itemId'] 	 = trim($request->get('itemId'));
	$data['dataTo'] 	 = trim($request->get('dataTo'));
	$result = Inventory::getActiveInvProductDetails($data);
	echo json_encode($result);
}
public function updateAmazonActiveInventory(Request $request)
{
		$sellerSku 				= trim($request->get('sellerSku'));
		$DataTOUpdate 		= trim($request->get('DataTOUpdate'));
		$productQuantity 	= trim($request->get('productQuantity'));
		$productPrice 		= trim($request->get('productPrice'));
		$oldQuantity		 	= trim($request->get('oldQuantity'));
		$oldPrice 				= trim($request->get('oldPrice'));
		// print_r($_GET);die;
		if($DataTOUpdate == 'ebay')
		{
			include(app_path() . '/Services/ebay/getcommon/keys.php');
			$siteID = 0;
			//the call being made:
			$verb = 'ReviseItem';
			$requestXmlBodyReviseItem  = '<?xml version="1.0" encoding="utf-8" ?>';
			$requestXmlBodyReviseItem .= '<ReviseItem xmlns="urn:ebay:apis:eBLBaseComponents">';
			$requestXmlBodyReviseItem .= '<Item>
    																	<ItemID>'.$sellerSku.'</ItemID>
																			<StartPrice>'.$productPrice.'</StartPrice>
        															<Quantity>'.$productQuantity.'</Quantity>
  																</Item>';
			$requestXmlBodyReviseItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
			$requestXmlBodyReviseItem .= '</ReviseItem>';
			if ($oldQuantity ==$productQuantity && $oldPrice ==$productPrice) {
				// values are same as old value thus no need to update ebay cateloge
				$success['success'] = true;
				$success['WarningMessage'] = 'No Operation performed please try with new entries';
				echo json_encode($success);
			}else{
				// Send Req To ebay to update product
				$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
				//send the request and get response
				$responseXml = $session->sendHttpRequest($requestXmlBodyReviseItem);
				$response['ebay'] = Helper::ebayApiResponse($responseXml);
				echo json_encode($response);die;
			}

		}
		if($DataTOUpdate == 'amazon')
		{
			//// API Call to update product Quantity
			$xml = '<?xml version="1.0"?>
								<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
									<Header>
											<DocumentVersion>1.01</DocumentVersion>
											<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
									</Header>
									<MessageType>Inventory</MessageType>
									<Message>
											<MessageID>1</MessageID>
											<OperationType>Update</OperationType>
											<Inventory>
												<SKU>'.$sellerSku.'</SKU>
												<Quantity>'.$productQuantity.'</Quantity>
											  <FulfillmentLatency>1</FulfillmentLatency>
											</Inventory>
									</Message>
							</AmazonEnvelope>';
							if ($oldQuantity !=$productQuantity) {
								$amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
								$amz->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
								$amz->setMarketplaceIds('ATVPDKIKX0DER');
								$amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
								$amz->submitFeed(); //this is what actually sends the request
								$result1 = $amz->getResponse();
								echo json_encode($result1);die;
								// echo "<pre>";print_r($result);
								sleep(10);
							}
 							//// API Call to update product price
							$xml ='<?xml version="1.0" encoding="utf-8"?>
												<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
												<Header>
													<DocumentVersion>1.01</DocumentVersion>
													<MerchantIdentifier>$merchant_token</MerchantIdentifier>
											  </Header>
												<MessageType>Price</MessageType>
												<Message>
											  	<MessageID>1</MessageID>
													<Price>
													<SKU>'.$sellerSku.'</SKU>
													<StandardPrice currency="USD">'.$productPrice.'</StandardPrice>
													</Price>
											  </Message>
										   </AmazonEnvelope>';
							if ($oldPrice !=$productPrice) {
								$amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
								$amz->setFeedType("_POST_PRODUCT_PRICING_DATA_"); //feed types listed in documentation
								$amz->setMarketplaceIds('ATVPDKIKX0DER');
								$amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
								$amz->submitFeed(); //this is what actually sends the request
								$result = $amz->getResponse();
								echo json_encode($result);
							}
							if ($oldQuantity ==$productQuantity && $oldPrice == $productPrice) {
								$success['success'] = true;
								$success['WarningMessage'] = 'No Operation performed please try with new entries';
								echo json_encode($success);
							}
			/********* check status of feed **/
			// $amz=new AmazonFeedList("store1");
			// $amz->setTimeLimits('- 10 min'); //limit time frame for feeds to any updated since the given time
			// $amz->setFeedStatuses(array("_SUBMITTED_", "_IN_PROGRESS_", "_DONE_")); //exclude cancelled feeds
			// $amz->fetchFeedSubmissions();
		  // $result = $amz->getFeedList();
			// echo "<pre>";print_r($result);die;
			/** check status of feed **/
			// $amz	=	new AmazonFeedResult("store1"); //store name matches the array key in the config file
			// $amz->setFeedId('80264017541'); //feed types listed in documentation
			// $amz->fetchFeedResult();
			// $result = $amz->getRawFeed();
			// echo "<pre>";print_r($amz);
			// $amz	=	new AmazonFeedResult("store1"); //store name matches the array key in the config file
			// $amz->setFeedId('80265017541'); //feed types listed in documentation
			// $amz->fetchFeedResult();
			// $result = $amz->getRawFeed();
			// echo "<pre>";print_r($amz);die;
		}
}

public function testEbayApi()
{



	$amz = new AmazonOrderItemList("store1"); //store name matches the array key in the config file
	$amz->setOrderId('114-4305686-4355441'); 	//oredrId to get order details form order
	$amz->fetchItems();
	$result =  $amz;
	// echo "<pre>";print_r($result);die;
	if($result)
	{
		foreach ($result as $orderItemData)
		{
				$orderArray[] 																= '114-4305686-4355441';


				if( $orderItemData['SellerSKU']!="" && $orderItemData['QuantityOrdered']!=""){

					self::updateEbayInventoryQty1( $orderItemData['SellerSKU'],$orderItemData['QuantityOrdered']);
					die('adfasd');
				}
				//
					// if(strpos(	$orderItemData['Title'],'Apple') != false || strpos($orderItemData['Title'],'iPhone')!= false || strpos($orderItemData['Title'],'Samsung') != false
					// 	|| strpos($orderItemData['Title'],'Mobile')!= false || strpos($orderItemData['Title'],'Phone') != false)
					// {

						// die('adfasd');
							// Inserting Order
							# checking record exits or not
							$orderExits = Order::checkExitsAmazonOrder('amazonOrder',array('orderRef' => '114-4305686-4355441'));


							// $recordExits = 0 for record not exits
							if($orderExits == 0 )
							{
								$orderDetail[$i]['orderRef']											=	'114-4305686-4355441';
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
								$shippingDetail[$i]['orderRefId'] 								= '114-4305686-4355441';
								$i++;
							}
							else
							{
								// update order
								$UpOrderDetail[$upNo]['orderRef']									=	'114-4305686-4355441';
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
								$UpShippingDetail[$upNo]['orderRefId'] 						= '114-4305686-4355441';
								$upNo++;
							}
							/***************************************************************************************************************/
							$itemRecordExits = Order::checkExitsAmazonOrder('amazoneOrderItem',array('orderId' => '114-4305686-4355441','SellerSKU'=>$orderItemData['SellerSKU']));
							// $itemRecordExits = 0 for record not exits



							if($itemRecordExits == 0 )
							{
							//$orderItem Array for add order item
									$orderItem[$j]['itemRefId'] 												= Helper::unqNum();
									$orderItem[$j]['orderId']														= '114-4305686-4355441'; // orderID
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
	/*
	include(app_path() . '/Services/ebay/getcommon/keys.php');
		$siteID = 0;
		$verb = 'ReviseInventoryStatus';
		$requestXmlBodyReviseItem  = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBodyReviseItem .= '<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$requestXmlBodyReviseItem .= '<InventoryStatus>
																		<ItemID>173607779593</ItemID>
														        <SKU>SMG930FGOLD</SKU>
														        <Quantity>2</Quantity>
																	</InventoryStatus>';
		$requestXmlBodyReviseItem .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
		$requestXmlBodyReviseItem .= '</ReviseInventoryStatusRequest>';

			// Send Req To ebay to update product
			$session = new \App\Services\ebay\getcommon\eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
			//send the request and get response
			$responseXml = $session->sendHttpRequest($requestXmlBodyReviseItem);
			$response['ebay'] = Helper::ebayApiResponse($responseXml);
			echo '<pre>'; print_r($response);die;

*/
}


public function updateEbayInventoryQty1($sellerSku,$quantity){
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
			$upQty = 0;
			if (isset($response['ebay']->Item->Variations) ) {
				foreach ($response['ebay']->Item->Variations->Variation as $key => $value)
				{
					if ($value->SKU == $sellerSku) {
						$qty 			= (isset($value->Quantity) ) ? $value->Quantity : 0;
						$qtySold 	= (isset($value->SellingStatus->QuantitySold) ) ? $value->SellingStatus->QuantitySold : 0;
						$qty 			= $qty - $qtySold;
						$upQty 		= $qty - $quantity;
						break;
					}
				}
			}else{
				$qty 			= (isset($response['ebay']->Item->Quantity) ) ? $response['ebay']->Item->Quantity : 0;
				$qtySold 	= (isset($response['ebay']->Item->SellingStatus->QuantitySold) ) ? $response['ebay']->Item->SellingStatus->QuantitySold : 0;
				$qty 			= $qty - $qtySold;
				$upQty 		= $qty - $quantity;
			}
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
			echo '<pre>'; print_r($response);die;
	}

}
public function testAmazonApi(){
	$reportData = array();
	include(app_path() . '/Services/ebay/getcommon/keys.php');

	// $amz	=	new AmazonFeedResult("store1"); //store name matches the array key in the config file
	// $amz->setFeedId('110797017816'); //feed types listed in documentation
	// $amz->fetchFeedResult();
	// $result = $amz->getRawFeed();
	// echo "<pre>";print_r($amz);
	// die();
	/****** Search Products using Name ******/
	$amz_store_search	=	new AmazonProductSearch("store1"); //store name matches the array key in the config file
	$amz_store_search->setQuery("Samsung Galaxy S9 New Phone (Blue)"); //feed types listed in documentation
	$result = $amz_store_search->searchProducts();
	//$result1 = $amz_store_search->searchProducts()['productList'];
	$product_asin = $amz_store_search->getProduct(0)->getData()['Identifiers']['MarketplaceASIN']['ASIN'];
	echo "<pre>"; print_r($product_asin);

  //  echo "<pre>"; print_r($result);
	//  echo '***';
  //  echo "<pre>"; print_r($result1);
	//  echo '***';

	// die;
if($product_asin)
{
	$feed = '<?xml version="1.0"?>
							<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
								<Header>
										<DocumentVersion>1.01</DocumentVersion>
										<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
								</Header>
								<MessageType>Inventory</MessageType>
								<Message>
									 <MessageID>1</MessageID>
									 <OperationType>Update</OperationType>
									 <Product>
											 <SKU>QW-N365-BACEC</SKU>

											 <ProductTaxCode>A_GEN_TAX</ProductTaxCode>
											 <LaunchDate>2016-12-19T16:00:00-08:00</LaunchDate>
											 <DescriptionData>
													 <Title>NEW Samsung Galaxy S6 SM-G920A 32GB ATT Unlocked Android Smartphone - Black</Title>
													 <Brand>Samsung</Brand>
																	 <Description>A richly hydrating all-natural lipstick in shades that complement every skin tone.</Description>
																	 <BulletPoint>This all-natural lipstick is handmade with nourishing botanicals and precisely blended pigments to glide on smoothly and deliver full color payoff. Each shade creates a universally flattering effect to match any mood.   Rosewater, a sheer blushing rose. Stardust, a sheer neutral with pink and brown undertones. Undone, a semi-matte, full-coverage pink-brown neutral. Darkroom, a semi-matte, full-coverage plum.</BulletPoint>
																	 <BulletPoint>Green tea, rosehip, and grapeseed oils are powerful antioxidants that heal cells and fight free radicals to reverse environmental damage.</BulletPoint>
																	 <BulletPoint>Mango and shea butters heal, moisturize, and protect lips while preventing formation of fine lines.</BulletPoint>
																	 <BulletPoint>Sweet orange oil is a collagen-booster with a luxurious, uplifting scent.</BulletPoint>
																	 <BulletPoint>Free of parabens, phthalates, and sulfates.</BulletPoint>
													 <Manufacturer>Samsung</Manufacturer>
													 <ItemType>Phone</ItemType>
													 <IsGiftWrapAvailable>true</IsGiftWrapAvailable>
													 <IsGiftMessageAvailable>true</IsGiftMessageAvailable>
													 <IsDiscontinuedByManufacturer>false</IsDiscontinuedByManufacturer>
											 </DescriptionData>

											 <ProductData>
											 <CE>
													 <ProductType>
															 <Phone>
															 	<InternetApplications>InternetApplications</InternetApplications>

															 </Phone>
													 </ProductType>
											 </CE>
											 </ProductData>
									 </Product>
							 </Message>
							</AmazonEnvelope>';
}
/*$xml = '<?xml version="1.0" encoding="utf-8" ?>
				<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd"
					<Header>
						<DocumentVersion>1.01</DocumentVersion>
						<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
					</Header>
					<MessageType>ProductImage</MessageType>
					<Message>
							<MessageID>1</MessageID>
							<OperationType>Update</OperationType>
							<ProductImage>
									<SKU>QW-N365-LQ12</SKU>
									<ImageType>Main</ImageType>
									<ImageLocation>https://static.toiimg.com/photo/59980514/Samsung-Galaxy-Note-9.jpg</ImageLocation>
							</ProductImage>
					</Message>
				</AmazonEnvelope>';*/


/*$xml ='<?xml version="1.0" encoding="utf-8"?>
					<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
					<Header>
						<DocumentVersion>1.01</DocumentVersion>
						<MerchantIdentifier>$merchant_token</MerchantIdentifier>
					</Header>
					<MessageType>Price</MessageType>
					<Message>
						<MessageID>1</MessageID>
						<Price>
						<SKU>56789</SKU>
						<StandardPrice currency="USD">78</StandardPrice>
						</Price>
					</Message>
				 </AmazonEnvelope>';*/

				 /*$xml = '<?xml version="1.0"?>
	 								<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
	 									<Header>
	 											<DocumentVersion>1.01</DocumentVersion>
	 											<MerchantIdentifier>AGYCG0WRP2CAG</MerchantIdentifier>
	 									</Header>
	 									<MessageType>Inventory</MessageType>
	 									<Message>
	 											<MessageID>1</MessageID>
	 											<OperationType>Update</OperationType>
	 											<Inventory>
	 												<SKU>56789</SKU>
	 												<Quantity>67</Quantity>
	 											  <FulfillmentLatency>1</FulfillmentLatency>
	 											</Inventory>
	 									</Message>
	 							</AmazonEnvelope>';*/


	 try {
		//  $amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
		//  $amz->setFeedType("_POST_PRODUCT_IMAGE_DATA_"); //feed types listed in documentation
		//  $amz->setMarketplaceIds('ATVPDKIKX0DER');
		//  $amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
		//  $amz->submitFeed(); //this is what actually sends the request
		//  $result1 = $amz->getResponse();
		//  echo json_encode($result1);die;

		//  $amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
		//  $amz->setFeedType("_POST_INVENTORY_AVAILABILITY_DATA_"); //feed types listed in documentation
		//  $amz->setMarketplaceIds('ATVPDKIKX0DER');
		//  $amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
		//  $amz->submitFeed(); //this is what actually sends the request
		//  $result1 = $amz->getResponse();
		//  echo json_encode($result1);die;

		//  $amz	=	new AmazonFeed("store1"); //store name matches the array key in the config file
		//  $amz->setFeedType("_POST_PRODUCT_PRICING_DATA_"); //feed types listed in documentation
		//  $amz->setMarketplaceIds('ATVPDKIKX0DER');
		//  $amz->setFeedContent($xml); //can be either XML or CSV data; a file upload method is available as well
		//  $amz->submitFeed(); //this is what actually sends the request
		//  $result = $amz->getResponse();
		//  echo json_encode($result);die;

		/****** Upload Product*********/
		//  $amz=new AmazonFeed("store1"); //if there is only one store in config, it can be omitted
		//  $amz->setMarketplaceIds('ATVPDKIKX0DER');
		//  $amz->setFeedType("_POST_PRODUCT_DATA_"); //feed types listed in documentation
		//  $amz->setFeedContent($feed); //can be either XML or CSV data; a file upload method is available as well
		//  $amz->submitFeed(); //this is what actually sends the request
		//  $result = $amz->getResponse();
		//  echo json_encode($result);die;

		// $amz=new AmazonFeed("store1"); //if there is only one store in config, it can be omitted
		//  $amz->setMarketplaceIds('ATVPDKIKX0DER');
		//  $amz->setFeedType("POST_PRODUCT_IMAGE_DATA"); //feed types listed in documentation
		//  $amz->setFeedContent($feed); //can be either XML or CSV data; a file upload method is available as well
		//  $amz->submitFeed(); //this is what actually sends the request
		//  $result = $amz->getResponse();
		//  echo json_encode($result);die;

		/****** Check uploaded product status *********/
		 $amz=new AmazonFeedList("store1");
		 $amz->setTimeLimits('- 10 min'); //limit time frame for feeds to any updated since the given time
		 $amz->setFeedStatuses(array("_SUBMITTED_", "_IN_PROGRESS_", "_DONE_")); //exclude cancelled feeds
		 $amz->fetchFeedSubmissions();
		 $result = $amz->getFeedList();
		 echo "<pre>";print_r($result);die();

		// $amz	=	new AmazonFeedResult("store1"); //store name matches the array key in the config file
		// $amz->setFeedId('110267017812'); //feed types listed in documentation
		// $amz->fetchFeedResult();
		// $result = $amz->getRawFeed();
		// echo "<pre>";print_r($amz);

	 } catch (Exception $ex) {
			echo 'There was a problem with the Amazon library. Error: '.$ex->getMessage();
	 }
	 die();
}


}
?>
