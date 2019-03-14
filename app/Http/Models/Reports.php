<?php

namespace App\Http\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
     protected $table = 'users';

    //  public static function getEbayProfit(){
    //    $result =  DB::table('ebayInventory')->select('*')->orderBy('id','DESC')->paginate(5,['*'],'ebay');
    //    return $result;
    //  }

     public static function getAmazonProfit(){
        $result =  DB::table('amazoneCommission')->select('*')
        ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
        ->orderBy('amazoneCommission.id','DESC')->groupBy('AmazonOrderId')->paginate(5,['*'],'amazon');
        return $result;
      }
      public static function getEbayProfit(){
        $result =  DB::table('orderDetail')->select('*')
        ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
        ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
        ->where('orderDetail.checkoutStatus', 'Complete')
        ->orderBy('orderDetail.id','DESC')->paginate(5,['*'],'ebay');
       return $result;
      }

      public static function getEbayProfitSummary(){
        $ebayAmountPaid =  DB::table('orderDetail')->select(\DB::raw("SUM(amountPaid) as ebayAmountPaid"),\DB::raw("SUM(FinalValueFee) AS ebayFinalValueFee"), \DB::raw("SUM(returnCharge) AS ebayReturnCharge"),\DB::raw("SUM(FeeOrCreditAmount) AS ebayPaypalAmount"))
        ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
        ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
        ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'orderTransaction.orderRefId')
        ->where('orderDetail.checkoutStatus', 'Complete')
        ->get();
        return $ebayAmountPaid;
      }
     public static function getAmazonProfitSummary(){
      //  DB::enableQueryLog();
          $result =  DB::table('amazoneCommission')->select(\DB::raw("SUM(returnCharge) AS amazonReturnCharge"),\DB::raw("SUM(`amaEb_amazoneCommission`.ItemPrice) + SUM(`amaEb_amazoneCommission`.ShippingCharge) + SUM(`amaEb_amazoneCommission`.GiftWrapPrice) + SUM(`amaEb_amazoneCommission`.ItemTaxAmount) + SUM(`amaEb_amazoneCommission`.ShippingTaxAmount) + SUM(`amaEb_amazoneCommission`.GiftWrapTaxAmount) AS amazonFinalValue")
          , \DB::raw("SUM(`amaEb_amazoneCommission`.CommissionFeeAmt) + SUM(`amaEb_amazoneCommission`.FixedClosingFee) + SUM(`amaEb_amazoneCommission`.GiftwrapCommissionAmt) + SUM(`amaEb_amazoneCommission`.SalesTaxCollectionFeeAmt) + SUM(`amaEb_amazoneCommission`.ShippingHBAmt) + SUM(`amaEb_amazoneCommission`.VariableClosingFeeAmt) AS VariableClosingFeeAmt"))
          //->join('amazonOrder', 'amazonOrder.orderRef', '=', 'amazoneCommission.AmazonOrderId')
          ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
          ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'amazoneOrderItem.orderId')
          ->get();
          // dd(DB::getQueryLog());die();
          //echo "<pre>";print_r($result);
          return $result;
      }

      /**********************************************************************************/
       public static function getInventoryData()
       {
          $result = DB::table('ebayInventory')->get();
          return $result;
       }
       public static function InventoryGraph($param)
       {
         $data = array();
         switch ($param['searchType']) {
          case "Day":
              $result = DB::table('ebayInventory')->select(DB::raw('count(quantityEbay) as quantityEbay,startTimeEbay'))->where('addedOn','like', '%'.$param['date'].'%')->first();
              $data = $result;
              break;
          case "Days":

              //DB::enableQueryLog();
            //  $result = DB::table('ebayInventory')->select(DB::raw('count(quantityEbay) as quantityEbay,startTimeEbay'))->whereBetween('startTimeEbay',[$param['startDate'],$param['endDate']])->get();
                $result = DB::select("select count(quantityEbay) as quantityEbay,addedOn from amaEb_ebayInventory where addedOn >= '".$param['startDate']."' and addedOn < '".$param['endDate']."' group by addedOn");
              //dd(DB::getQueryLog());die;
              $data = array();
              foreach ($result as $value)
              {
                  //$date = new \DateTime($value->startTimeEbay);
                  //$startTimeEbay = $date->format("Y-m-d");
                  $data[$value->addedOn] = $value;
              }
              break;

              break;
          case "Months":
         //DB::enableQueryLog();
          $result = DB::select("select monthname(addedOn) as month , count(quantityEbay) as quantityEbay,addedOn from amaEb_ebayInventory where addedOn >= '".$param['startDate']."' and addedOn < '".$param['endDate']."'  group by monthname(addedOn)");
          //dd(DB::getQueryLog());die;
              foreach ($result as $value)
              {
                  // $date = new \DateTime($value->startTimeEbay);
                  // $startTimeEbay = $date->format("Y-m-d");
                  $data[$value->month] = $value;
              }
              break;
      }

      return $data;
       }
       public static function amazonInventoryGraph($param)
       {
         $data = array();
         switch ($param['searchType']) {
          case "Day":
              $result = DB::table('amazonInventory')->select(DB::raw('count(quantity) as quantity,addedOn'))->where('addedOn','like', '%'.$param['date'].'%')->first();
              $data = $result;
              break;
          case "Days":

              DB::enableQueryLog();
            //  $result = DB::table('ebayInventory')->select(DB::raw('count(quantityEbay) as quantityEbay,startTimeEbay'))->whereBetween('startTimeEbay',[$param['startDate'],$param['endDate']])->get();
                $result = DB::select("select count(quantity) as quantity,addedOn from amaEb_amazonInventory where addedOn >= '".$param['startDate']."' and addedOn < '".$param['endDate']."' group by addedOn");
              //dd(DB::getQueryLog());die;
              $data = array();
              foreach ($result as $value)
              {
                  //$date = new \DateTime($value->startTimeEbay);
                  //$startTimeEbay = $date->format("Y-m-d");
                  $data[$value->addedOn] = $value;
              }
              break;

              break;
          case "Months":
         //DB::enableQueryLog();
          $result = DB::select("select monthname(addedOn) as month , count(quantity) as quantity,addedOn from amaEb_amazonInventory where addedOn >= '".$param['startDate']."' and addedOn < '".$param['endDate']."'  group by monthname(addedOn)");
          //dd(DB::getQueryLog());die;
              foreach ($result as $value)
              {
                  // $date = new \DateTime($value->startTimeEbay);
                  // $startTimeEbay = $date->format("Y-m-d");
                  $data[$value->month] = $value;
              }
              break;
       }

      return $data;
       }
      /**********************************************************************************/

      public static function getPdfAmazonProfit($startDate,$endDate)
      {
         if (trim($startDate)!="" && trim($endDate) !="") {
           $result =  DB::table('amazoneCommission')->select('*')
           ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
           ->whereBetween('amazoneOrderItem.createdDate',[$startDate,$endDate])
           ->orderBy('amazoneCommission.id','DESC')->groupBy('AmazonOrderId')->get();
         }
         else
         {
           $result =  DB::table('amazoneCommission')->select('*')
           ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
           ->orderBy('amazoneCommission.id','DESC')->groupBy('AmazonOrderId')->get();
         }
         return $result;
       }
       public static function getPdfEbayProfit($startDate,$endDate)
       {
        // DB::enableQueryLog();
         if (trim($startDate)!="" && trim($endDate) !="")
         {
           $result =  DB::table('orderDetail')->select('*')
           ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
           ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
           ->where('orderDetail.checkoutStatus', 'Complete')
           ->whereBetween('orderDetail.addedOn',[$startDate,$endDate])
           ->orderBy('orderDetail.id','DESC')->get();
         }
         else {
           $result =  DB::table('orderDetail')->select('*')
           ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
           ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
           ->where('orderDetail.checkoutStatus', 'Complete')
           ->orderBy('orderDetail.id','DESC')->get();
         }
        // dd(DB::getQueryLog());die('asdfnasndf');
        return $result;
       }

       public static function getEbayItemProfit()
       {

        //DB::enableQueryLog();
         $result =  DB::table('ebayInventory')->select('*')
         //->leftJoin('orderDetail', 'orderDetail.orderRef','=' ,'orderItem.orderId' )
         ->Join('orderItem', 'orderItem.itemId' ,'=' ,'ebayInventory.ebayItemRef')
         //->where('orderDetail.checkoutStatus', 'Complete')
         ->orderBy('ebayInventory.id','DESC')->groupBy('itemId')->paginate(5,['*'],'ebay');
        //dd(DB::getQueryLog());die('asdfnasndf');
         return $result;
       }
       public static function getAmazonItemProfit()
       {
         $result =  DB::table('amazonInventory')->select('*')
         ->Join('amazoneOrderItem', 'amazoneOrderItem.SellerSKU' ,'=' ,'amazonInventory.sellerSku')
         ->Join('amazonOrder', 'amazonOrder.orderRef' ,'=' ,'amazoneOrderItem.orderId')
         ->where('amazonOrder.orderStatus','Shipped')
         ->orderBy('amazonInventory.id','DESC')->groupBy('amazoneOrderItem.SellerSKU')->paginate(5,['*'],'amazon');
         return $result;
       }

       public static function ebayItemProfitDetail($ebayItemRef)
       {
         $result =  DB::table('orderDetail')->select('*')
         ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
         ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
         ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'orderTransaction.orderRefId')
         ->where('orderDetail.checkoutStatus', 'Complete')
         ->where('orderItem.itemId', $ebayItemRef)
         ->orderBy('orderDetail.id','DESC')->get();
         return $result;
       }

       public static function ebayItemDetail($ebayItemRef)
       {
        //DB::enableQueryLog();
         $result =  DB::table('ebayInventory')->select('*')
        ->where('ebayInventory.ebayItemRef', $ebayItemRef)->get();
        //dd(DB::getQueryLog());die('asdfnasndf');
         return $result;
       }
       public static function amazonItemProfitDetail($amazonSellerSKU)
       {
         $result =  DB::table('amazoneCommission')->select(\DB::raw("count(amaEb_amazoneCommission.id) AS orderCount"),\DB::raw("SUM(returnCharge) AS amazonReturnCharge"),\DB::raw("SUM(`amaEb_amazoneCommission`.ItemPrice) + SUM(`amaEb_amazoneCommission`.ShippingCharge) + SUM(`amaEb_amazoneCommission`.GiftWrapPrice) + SUM(`amaEb_amazoneCommission`.ItemTaxAmount) + SUM(`amaEb_amazoneCommission`.ShippingTaxAmount) + SUM(`amaEb_amazoneCommission`.GiftWrapTaxAmount) AS amazonTotalAmount")
         , \DB::raw("SUM(`amaEb_amazoneCommission`.CommissionFeeAmt) + SUM(`amaEb_amazoneCommission`.FixedClosingFee) + SUM(`amaEb_amazoneCommission`.GiftwrapCommissionAmt) + SUM(`amaEb_amazoneCommission`.SalesTaxCollectionFeeAmt) + SUM(`amaEb_amazoneCommission`.ShippingHBAmt) + SUM(`amaEb_amazoneCommission`.VariableClosingFeeAmt) AS amazonFinalValue"),\DB::raw("SUM(amaEb_amazoneCommission.QuantityShipped) AS QuantityShipped"))
         ->join('amazoneOrderItem','amazoneOrderItem.orderId','=','amazoneCommission.AmazonOrderId')
         ->leftJoin('returnCharges', 'returnCharges.orderId', '=', 'amazoneCommission.AmazonOrderId')
         ->where('amazoneOrderItem.SellerSKU', $amazonSellerSKU)->get();
         return $result;
       }

       public static function amazonItemDetail($amazonSellerSKU)
       {
        //DB::enableQueryLog();
         $result =  DB::table('amazonInventory')->select('*')
        ->where('amazonInventory.sellerSku', $amazonSellerSKU)->get();
        //dd(DB::getQueryLog());die('asdfnasndf');
         return $result;
       }


       public static function updateFinance($data)
       {
         if(!empty($data))
         {
           foreach ($data as $key => $finance)
           {
             $result =  DB::table('amazoneCommission')
             ->where('AmazonOrderId', $finance['AmazonOrderId'])
             ->update($finance);
           }
         }
       }

}
