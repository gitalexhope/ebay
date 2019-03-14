<?php

namespace App\Http\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class ShippingLabel extends Model
{
     protected $table = 'users';

    //  public static function getEbayProfit(){
    //    $result =  DB::table('ebayInventory')->select('*')->orderBy('id','DESC')->paginate(5,['*'],'ebay');
    //    return $result;
    //  }

     public static function ShippingLabelUpdate($data){

       $result = DB::table('shippingLabels')
            ->where('orderID', $data['orderId'])
            ->update($data);
        return $result;
      }
     public static function updateEbayTrackingNum($data,$orderRef){

       $result = DB::table('orderDetail')
            ->where('orderRef', $orderRef)
            ->update(['trackingNumber' => $data['TrackingNumber'],'modifiedDate' => date('Y-m-d')]);
        return $result;
      }

      public static function getServiceList($orderId)
      {
            $result['amazonShipping'] =  DB::table('amazonShippingDetail')->select('amazonShippingDetail.*','amazonOrder.buyerEmail')
            ->leftJoin('amazonOrder','amazonOrder.orderRef','=','amazonShippingDetail.orderRefId')
            ->where('amazonShippingDetail.orderRefId',$orderId)
            ->get();
            $result['itemResult'] = DB::table('amazoneOrderItem')->select('*')
            ->where('orderId',$orderId)
            ->get();

            return $result;
      }



}
