<?php

namespace App\Http\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $table = 'users';

   public static function getOrderList()
   {
       $result =  DB::table('orderDetail')->select('*')
       ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
       ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
       ->where('orderDetail.orderAction','!=','Return')
       //->join('ebayInventory', 'ebayInventory.ebayItemRef' ,'=' ,'orderItem.itemId')
       ->orderBy('orderDetail.id','DESC')->paginate(5);
     	 return $result;
   }
   public static function getOrderMaxDate(){
   			$result =  DB::table('orderDetail')->max('lastModifiedDate');
   			return $result;
   	}

	public static function orderItem($orderItems){
			$result =  DB::table('orderItem')->insert($orderItems);
			return $result;
	}
  public static function orderDetails($orderDetail){
			$result =  DB::table('orderDetail')->insert($orderDetail);
			return $result;
	}
  public static function orderTransaction($orderTrans){
			$result =  DB::table('orderTransaction')->insert($orderTrans);
			return $result;
	}
  public static function orderShipping($orderShip){
			$result =  DB::table('orderShippingDetail')->insert($orderShip);
			return $result;
	}
	public static function userLogin($emailId){
		$result =  DB::table('users')->select('*',DB::raw('AES_DECRYPT(emailId,"/*awshp$*/") as email') )->where(DB::raw('AES_DECRYPT(emailId,"/*awshp$*/")'),$emailId)->get();
		return $result;
	}
  public static function getOrderById($ref){
    $result = Db::table('orderDetail')->select('orderRef')->where('orderRef',$ref)->get();
    return $result;
  }
  public static function orderDetailsUpdate($details){
    //echo '<pre>';print_r($details);die;
    for($i=0;$i<count($details);$i++){
      DB::table('orderDetail')
      ->where('orderRef', $details[$i]['orderRef'])
      ->update($details[$i]);
    }
  }
  public static function searchInventoryList($lower,$upper){
    $result =  $result =  DB::table('orderDetail')->select('*')->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')->where('orderRef','like',$lower.'%')->orwhere('orderRef','like',$upper.'%')->paginate(5);
    return $result;
  }
  public static function addTrackingNum($orderId,$track){
  $result =   DB::table('orderDetail')
    ->where('orderRef', $orderId)
    ->update(['trackingNumber' => $track]);
      return $result;
  }
  public static function updateTrackingNum($orderId,$track){
  $result =   DB::table('orderDetail')
    ->where('orderRef', $orderId)
    ->update(['trackingNumber' => $track]);
      return $result;
  }
  public static function orderDetailById($orderId){
    $result =  DB::table('orderDetail')->select('*')->leftJoin('orderShippingDetail', 'orderShippingDetail.orderIdRef', '=', 'orderDetail.orderRef')->where('orderDetail.orderRef',$orderId)->get();
    return $result;
  }
  public static function orderShipingDetailById($orderId){
    $result =  DB::table('orderShippingDetail')->select('*')->where('orderIdRef',$orderId)->get();
    return $result;
  }
  public static function orderTransactionDetails($orderId){
    $result =  DB::table('orderTransaction')->select('*')->where('orderTransaction.orderRefId',$orderId)->get();
    return $result;
  }
  public static function orderItemsDetails($orderId){
    //DB::enableQueryLog();
    $result =  DB::table('orderItem')->select('*')->leftJoin('ebayInventory', 'ebayInventory.ebayItemRef', '=', 'orderItem.itemId')->where('orderItem.orderId',$orderId)->get();
    //$result =  DB::table('orderItem')->select('*')->where('orderItem.orderId',$orderId)->get();
    //dd(DB::getQueryLog());die();
    return $result;
  }
  public static function getAmazonOrderMaxDate(){
       $result =  DB::table('amazonOrder')->max('lastUpdatedDate');
       return $result;
   }
   public static function insertAmazonOrderDetail($detail,$ship){
     $result =  DB::table('amazonOrder')->insert($detail);
     DB::table('amazonShippingDetail')->insert($ship);
     echo $result;
   }
   public static function amazonOrder(){
     //old method
    // $result =  DB::table('amazonOrder')->select('*')->orderBy('id','DESC')->paginate(5);
     $result =  DB::table('amazonOrder')->select('amazonOrder.*')
     ->Leftjoin('amazoneOrderItem','amazoneOrderItem.orderId','=','amazonOrder.orderRef')
     ->where('amazonOrder.orderAction','!=','Return')
     ->orderBy('id','DESC')->groupBy('orderRef')->paginate(5);
     return $result;

   }
   public static function amazonOrderList($lowerCase, $upperCase){
     $result =  DB::table('amazonOrder')->select('*')->where('orderRef','like',$lowerCase.'%')->orwhere('orderRef','like',$upperCase.'%')->orderBy('id','DESC')->paginate(5);
    return $result;
   }
   /** function for checking record exits or not send two param table Name and the other one conditon in array('id' = 1)*/
   public static function checkExitsAmazonOrder($tableName,$where)
   {
    //  DB::enableQueryLog();
     $recordExits = DB::table("$tableName")->where($where)->first();
    //  dd(DB::getQueryLog());die('asdfnasndf');

     if (!empty($recordExits))
     {
           // It exists-
           return 1;
     }
     else
     {
         // It does not exist
         return 0;
     }
   }

   public static function insertAmazonOrderItems($items){
     $result =  DB::table('amazoneOrderItem')->insert($items);
   }
   public static function updateAmazoneOrder($orderDetail,$shippingDetail,$orderId){
     $result =   DB::table('amazonOrder')
                    ->where('orderRef', $orderId)
                    ->update($orderDetail);
                DB::table('amazonShippingDetail')
                   ->where('orderRefId', $orderId)
                   ->update($shippingDetail);
    return $result;
   }
   public static function insertAmazoneOrder($orderDetail,$shippingDetail){
     $result =   DB::table('amazonOrder')->insert($orderDetail);
                 DB::table('amazonShippingDetail')->insert($shippingDetail);
    return $result;
   }

   public static function amazoneOrderDetailById($orderId){
     $result =  DB::table('amazonOrder')->select('*')->leftJoin('amazonShippingDetail', 'amazonShippingDetail.orderRefId', '=', 'amazonOrder.orderRef')->where('amazonOrder.orderRef',$orderId)->groupBy('orderRef')->get();
     return $result;
   }
   public static function amazoneOrderItemsDetails($orderId){
     $result =  DB::table('amazoneOrderItem')->select('*')->where('amazoneOrderItem.orderId',$orderId)->get();
     return $result;
   }

   public static function amazonAddTrackingNum($orderId,$track){
   $result =   DB::table('amazonOrder')
     ->where('orderRef', $orderId)
     ->update(['trackingNumber' => $track]);
     return $result;
   }
   /** function for Commission Data **/
   public static function commonInsert($data,$table){
    $result =  DB::table($table)->insert($data);
     return $result;
   }

   public static function OrderCommissionData($orderId){
     $result =  DB::table('amazoneCommission')->select('*')->where('AmazonOrderId',$orderId)->groupBy('AmazonOrderId')->get();
     return $result;
   }
   public static function getReturnOrderItems($orderId){
     $result =  DB::table('returnCharges')->select('*')->where('orderId',$orderId)->get();
     return $result;
   }
   public static function deleteReturnOrderItems($returnRef){
     $expReturnRef = explode(',',$returnRef);
     $result =  DB::table('returnCharges')->whereIn('returnRef',$expReturnRef)->delete();
     return $result;
   }
   public static function UpdateReturnCharges($data,$table){
     for ($i=0; $i < count($data); $i++)
     {
       $result =  DB::table($table)
       ->where('returnRef', $data[$i]['returnRef'])
       ->update($data[$i]);
//       return $result;
     }
   }
   public static function updateOrderStatus($orderId, $status,$tableName)
   {
     $result = DB::table($tableName)->where('orderRef',$orderId)->update(['orderAction' => $status]);
     $data   = DB::table('returnCharges')->where('orderId', '=', $orderId)->delete();
     return $result;
   }
   public static function addIMEINumber($data)
   {
     $result = DB::table($data['tableName'])->where('orderRef',$data['orderId'])->update(['IMEINumber' => $data['IMEINumber']]);
     return $result;
   }

   public static function updateAmazonBulkOrders($UpOrderDetail,$UpShippingDetail)
   {
    //  echo "<pre>";print_r($UpOrderDetail);echo "UpdateShipment Array***************";
     foreach ($UpOrderDetail as $key => $value)
     {
       $result =  DB::table('amazonOrder')
       ->where('orderRef', $value['orderRef'])
       ->update($value);
     }
     foreach ($UpShippingDetail as $key => $Shipment)
     {
       //echo "<pre>";print_r($Shipment['orderRefId']);die;
       $result =  DB::table('amazonShippingDetail')
       ->where('orderRefId', $Shipment['orderRefId'])
       ->update($Shipment);
     }
   }
   public static function getAmazonOrders(){
     $result =  DB::table('amazonOrder')->select('orderRef')->orderBy('id','DESC')->paginate();
     //$result =  DB::table('amazonOrder')->select('orderRef')->get();
    return $result;
   }
   public static function getAmazonReturnOrder(){
     $result =  DB::table('amazonOrder')->select('*')
     ->where('amazonOrder.orderAction' ,'=' ,'Return')
     ->orderBy('id','DESC')->paginate(5,['*'],'amazon');
     //$result =  DB::table('amazonOrder')->select('orderRef')->get();
    return $result;
   }


   public static function getCommon($table,$where){
     $result =  DB::table($table)->select('*')
     ->where($where)
     ->orderBy('id','DESC')->first();
     //$result =  DB::table('amazonOrder')->select('orderRef')->get();
    return $result;
   }

   public static function getEbayReturnOrderList()
   {
      //die('sfgsdfgsdfgs');
       $result =  DB::table('orderDetail')->select('*')
       ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
       ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
       ->where('orderDetail.orderAction' ,'=' ,'Return')
       ->orderBy('orderDetail.id','DESC')->paginate(5,['*'],'ebay');
     	 return $result;
   }
   public static function searchAmazonReturnOrder($lower,$upper)
   {
     if (trim($lower) !="" && trim($upper)!="") {
       $result =  DB::table('amazonOrder')->select('*')
       ->where('orderRef','like',$lower.'%')->orWhere('orderRef','like',$upper.'%')
       ->where('amazonOrder.orderAction' ,'=' ,'Return')
       ->orderBy('id','DESC')->paginate(5,['*'],'amazon');
     }
     else {
       $result =  DB::table('amazonOrder')->select('*')
       ->where('amazonOrder.orderAction' ,'=' ,'Return')
       ->orderBy('id','DESC')->paginate(5,['*'],'amazon');
     }
    return $result;
   }

   public static function searchEbayReturnOrderList($lower,$upper)
   {
      if (trim($lower) !="" && trim($upper)!="") {
        $result =  DB::table('orderDetail')->select('*')
        ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
        ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
        ->where('orderRef','like','%'.$lower)->orWhere('orderRef','like',$upper.'%')
        ->where('orderDetail.orderAction' ,'=' ,'Return')
        ->orderBy('orderDetail.id','DESC')->paginate(5,['*'],'ebay');
      }
      else
      {
        $result =  DB::table('orderDetail')->select('*')
        ->leftJoin('orderTransaction', 'orderTransaction.orderRefId' ,'=' ,'orderDetail.orderRef')
        ->leftJoin('orderItem', 'orderItem.orderId' ,'=' ,'orderDetail.orderRef')
        ->where('orderDetail.orderAction' ,'=' ,'Return')
        ->orderBy('orderDetail.id','DESC')->paginate(5,['*'],'ebay');
      }

       //dd(DB::getQueryLog());die();

     	 return $result;
   }
   public static function checkExits($tableName,$where,$colName = null , $colValue = null)
   {
    // DB::enableQueryLog();
     if (trim($colName)!='' && trim($colValue)!='') {
       $recordExits = DB::table("$tableName")
       ->where($where)
       ->where($colName,'!=',$colValue)
       ->first();
     } else {
       $recordExits = DB::table("$tableName")->where($where)->first();

     }

      // dd(DB::getQueryLog());die('asdfnasndf');

     if (!empty($recordExits))
     {
           // It exists-
           return 1;
     }
     else
     {
         // It does not exist
         return 0;
     }
   }
}

/**********

182728198463-1765825551008!140000119139435
10006209486714

3 months
MS Office and typing

6 months
coral drow + c + c++ html + basic

1 year
html c c+ tally foxpro + basic + coral drow + photoshop

***********/
