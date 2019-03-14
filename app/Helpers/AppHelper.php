<?php
namespace App\Helpers;
use DOMDocument;
use DB;
class AppHelper {
    public static function loginHeader(){
        return view('commonfiles.header');
    }
    public static function adminHeader(){
        return view('commonfiles.headerAdmin');
    }
    public static function adminFooter(){
        return view('commonfiles.adminFooter');
    }
  public static function ebayApiResponse($responseXml){
		if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
			die('<P>Error sending request');

		//Xml string is parsed and creates a DOM Document object
		$responseDoc = new DomDocument();
		$responseDoc->loadXML($responseXml);
		$response = simplexml_import_dom($responseDoc);
		$response = json_decode(json_encode($response));
		return $response;
	}
  public static function unqNum(){
    $length = 6;
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    $randomString1 = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    $randomString = $randomString.$randomString1;
    return $randomString;
  }

  public static function soldOn($ebayItemRef){
    $result['soldOn'] = DB::table('orderItem')->select('*')->where('itemId',$ebayItemRef)->get();
    return $result;
  }
  public static function getCountInventory(){
    $result['ebay'] = DB::table('ebayInventory')->select('*')->count();
    $result['amazon'] = DB::table('amazonInventory')->select('*')->count();
    $count = $result['ebay'] + $result['amazon'];
    return $count;
  }
  public static function getCountEbayOrder(){
    $result = DB::table('orderDetail')->select('*')->count();
    return $result;
  }
  public static function getCountAmazonOrder(){
    $result = DB::table('amazonOrder')->select('*')->where('orderStatus','!=','Canceled')
    ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazonOrder.orderRef')->count();
    return $result;
  }
  public static function getMonthsName()
  {
    $months = array(
              'January','February','March','April','May','June','July','August','September','October','November','December',
              );
    return $months;
}
public static function updateOrderDetails($orderId,$tableName){
  $result = DB::table($tableName)->where('orderRef','=',$orderId)->update(['orderAction'=>'Return']);
  return $result;
}
public static function ebayLabelUrl($orderId){
  $result = DB::table('shippingLabels')
  ->where('orderId','=',$orderId)
  ->where('labelType','=',1)
  ->first();
  return $result;
}
public static function returnCharge($orderId,$type)
{
  $result = DB::table('returnCharges')
            ->select(\DB::raw("SUM(returnCharge) AS returnCharge"))
            ->where('orderId','=',$orderId)
            ->where('returnType','=',$type)
            ->get();
  return $result;
}
public  static function getProfitAndLost($param)
{

  $startDate = $param['startDate'];
  $endDate   = $param['endDate'];
     if ($param['searchType'] == 'overall') {
       $ebayData =  DB::table('orderDetail')->select(\DB::raw("SUM(amountPaid) as ebayAmountPaid"),\DB::raw("SUM(FinalValueFee) AS ebayFinalValueFee"), \DB::raw("SUM(returnCharge) AS ebayReturnCharge"),\DB::raw("SUM(FeeOrCreditAmount) AS ebayPaypalAmount"))
       ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
       ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
       ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'orderTransaction.orderRefId')
       ->where('orderDetail.checkoutStatus', 'Complete')

       ->get();
      // dd(DB::getQueryLog());die();
       $amazonData =  DB::table('amazoneCommission')->select(\DB::raw("SUM(returnCharge) AS amazonReturnCharge"),\DB::raw("SUM(`amaEb_amazoneCommission`.ItemPrice) + SUM(`amaEb_amazoneCommission`.ShippingCharge) + SUM(`amaEb_amazoneCommission`.GiftWrapPrice) + SUM(`amaEb_amazoneCommission`.ItemTaxAmount) + SUM(`amaEb_amazoneCommission`.ShippingTaxAmount) + SUM(`amaEb_amazoneCommission`.GiftWrapTaxAmount) AS amazonTotalAmount")
       , \DB::raw("SUM(`amaEb_amazoneCommission`.CommissionFeeAmt) + SUM(`amaEb_amazoneCommission`.FixedClosingFee) + SUM(`amaEb_amazoneCommission`.GiftwrapCommissionAmt) + SUM(`amaEb_amazoneCommission`.SalesTaxCollectionFeeAmt) + SUM(`amaEb_amazoneCommission`.ShippingHBAmt) + SUM(`amaEb_amazoneCommission`.VariableClosingFeeAmt) AS amazonFinalValue"))
       //->join('amazonOrder', 'amazonOrder.orderRef', '=', 'amazoneCommission.AmazonOrderId')
       ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
       ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'amazoneCommission.AmazonOrderId')

       ->get();
     }else {
       $ebayData =  DB::table('orderDetail')->select(\DB::raw("SUM(amountPaid) as ebayAmountPaid"),\DB::raw("SUM(FinalValueFee) AS ebayFinalValueFee"), \DB::raw("SUM(returnCharge) AS ebayReturnCharge"),\DB::raw("SUM(FeeOrCreditAmount) AS ebayPaypalAmount"))
       ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
       ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
       ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'orderTransaction.orderRefId')
       ->where('orderDetail.checkoutStatus', 'Complete')
       ->whereBetween('orderDetail.addedOn',[$startDate,$endDate])
       ->get();
      // dd(DB::getQueryLog());die();
       $amazonData =  DB::table('amazoneCommission')->select(\DB::raw("SUM(returnCharge) AS amazonReturnCharge"),\DB::raw("SUM(`amaEb_amazoneCommission`.ItemPrice) + SUM(`amaEb_amazoneCommission`.ShippingCharge) + SUM(`amaEb_amazoneCommission`.GiftWrapPrice) + SUM(`amaEb_amazoneCommission`.ItemTaxAmount) + SUM(`amaEb_amazoneCommission`.ShippingTaxAmount) + SUM(`amaEb_amazoneCommission`.GiftWrapTaxAmount) AS amazonTotalAmount")
       , \DB::raw("SUM(`amaEb_amazoneCommission`.CommissionFeeAmt) + SUM(`amaEb_amazoneCommission`.FixedClosingFee) + SUM(`amaEb_amazoneCommission`.GiftwrapCommissionAmt) + SUM(`amaEb_amazoneCommission`.SalesTaxCollectionFeeAmt) + SUM(`amaEb_amazoneCommission`.ShippingHBAmt) + SUM(`amaEb_amazoneCommission`.VariableClosingFeeAmt) AS amazonFinalValue"))
       //->join('amazonOrder', 'amazonOrder.orderRef', '=', 'amazoneCommission.AmazonOrderId')
       ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
       ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'amazoneCommission.AmazonOrderId')
       ->whereBetween('amazoneOrderItem.createdDate',[$startDate,$endDate])
       ->get();
     }


 // $result1 = DB::table('amazonOrder')
 //           #->select(\DB::raw("SUM(returnCharge) AS amazonReturnCharge"),\DB::raw("SUM(`amaEb_amazoneCommission`.ItemPrice) + SUM(`amaEb_amazoneCommission`.ShippingCharge) + SUM(`amaEb_amazoneCommission`.GiftWrapPrice) + SUM(`amaEb_amazoneCommission`.ItemTaxAmount) + SUM(`amaEb_amazoneCommission`.ShippingTaxAmount) + SUM(`amaEb_amazoneCommission`.GiftWrapTaxAmount) AS amazonFinalValue"), \DB::raw("SUM(totalAmount) AS totalAmount"))
 //           ->select(\DB::raw("SUM(returnCharge) AS amazonReturnCharge"),\DB::raw("SUM(`amaEb_amazoneCommission`.CommissionFeeAmt) + SUM(`amaEb_amazoneCommission`.FixedClosingFee) + SUM(`amaEb_amazoneCommission`.GiftwrapCommissionAmt) + SUM(`amaEb_amazoneCommission`.SalesTaxCollectionFeeAmt) + SUM(`amaEb_amazoneCommission`.ShippingHBAmt) + SUM(`amaEb_amazoneCommission`.VariableClosingFeeAmt) AS amazonFinalValue"), \DB::raw("SUM(totalAmount) AS totalAmount"))
 //           //->join('amazoneOrderItem', 'amazoneOrderItem.orderId', '=', 'amazonOrder.orderRef')
 //           ->leftJoin('amazoneCommission', 'amazoneCommission.AmazonOrderId', '=', 'amazonOrder.orderRef')
 //           ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazonOrder.orderRef')
 //           ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'amazonOrder.orderRef')
 //           ->whereBetween('amazonOrder.createdDate',[$startDate,$endDate])
 //           ->get();
//echo "<pre>";print_r($result1);die;
  return array(
    'ebay' => $ebayData,
    'amazon' => $amazonData
  );
}

public static function getEbayOrderQTY($itemRef)
{
  $ebayData =  DB::table('orderItem')->select(\DB::raw("count(amaEb_orderItem.id) as orderQty"))
  ->leftJoin('orderDetail', 'orderDetail.orderRef' ,'=' ,'orderItem.orderId')
  ->where('orderDetail.checkoutStatus', 'Complete')
  ->where('orderItem.itemId','=',$itemRef)
  ->get();
  return $ebayData;
}
public static function getAmazonOrderQTY($itemRef)
{
  $AmazonData =  DB::table('amazoneOrderItem')->select(\DB::raw("count(amaEb_amazoneOrderItem.id) as AmazonOrderQty"))
  ->leftJoin('amazonOrder', 'amazonOrder.orderRef' ,'=' ,'amazoneOrderItem.orderId')
  ->where('amazonOrder.orderStatus', 'Shipped')
  ->where('amazoneOrderItem.SellerSKU','=',$itemRef)
  ->get();
  return $AmazonData;
}
public static function getStockNumbers()
{
  $stockNum =  DB::table('inventory')->select('id')
  ->orderBy('id', 'DESC')->first();
  $maxNum     = $stockNum->id;
  $len        = strlen($maxNum);
  $maxNum     = substr($maxNum,0,$len);
  $maxNum     = str_pad($maxNum + 1, 4, 0, STR_PAD_LEFT);
  // $stockNum = strtotime(date('Y-m-d H:i:s'));
  $stockNum   = rand(00,1000).'-'.rand(9000,$maxNum);
  return '100'.$stockNum;
}

 public static function amazonGetAsin($asin){
     $result =  DB::table('amazoneOrderItem')->select('amazoneOrderItem.ASIN as asin')
     ->where('amazoneOrderItem.orderId','=',$asin)
     ->first();
     return $result;
   }

}
?>
