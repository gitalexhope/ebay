<?php

namespace App\Http\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // protected $table = 'users';
    public static function addInventory($detail,$image){
      //  echo '<pre>';print_r($detail);die;
      $date = explode('/',$detail['invDate']);
      $detail['invDate'] =$date[2].'-'.$date[1].'-'.$date[0];
      $detail['createdDate']=date('Y-m-d');
      $detail['status']=1;
      $num =   DB::table('inventory')->insert($detail);
        $dataSet[] = [
         'productId'  => $detail['productRef'],
         'imageName'    => $image,
      ];
      DB::table('images')->insert($dataSet);
      return $num;
    }
    public static function checkNum($det){
        $result = DB::table('inventory')->where('ImeNum', $det)->value('ImeNum');
        return $result;
    }
    public static function getInventoryList(){
      $result =  DB::table('inventory')->select('*')->orderBy('id','DESC')->paginate(5);
      return $result;
    }
    public static function searchInventoryList($lower,$upper){
      $result =  DB::table('inventory')->select('*')->where('ImeNum','like',$lower.'%')->orwhere('brandName','like',$lower.'%')->orwhere('ImeNum','like',$upper.'%')->orwhere('brandName','like',$upper.'%')->orderBy('id','DESC')->paginate(2);
      return $result;
    }
    public static function getInventoryInfo($ref){
      //$result =  DB::table('inventory')->select('*')->join('images', 'images.productId', '=', 'inventory.productRef')->leftJoin('ebayInventory', 'ebayInventory.productRef', '=', 'inventory.productRef')->where('inventory.productRef',$ref)->get();
      $result =  DB::table('inventory')->select('*')->join('images', 'images.productId', '=', 'inventory.productRef')->where('inventory.productRef',$ref)->get();
      return $result;
    }
    public static function updateInventory($detail,$img){
       $result = DB::table('inventory')->where('productRef',$detail['productRef'])->update($detail);
       $result2 = DB::table('images')->where('productId',$detail['productRef'])->update(['imageName' => $img]);
       return array($result,$result2);
    }
    public static function addEbayList($detailInfo){
      $num = DB::table('ebayInventory')->insert($detailInfo);
      $result2 = DB::table('inventory')->where('productRef',$detailInfo['productRef'])->update(['listedEbay' => 1]);
      return $num;
    }
    public static function getProductBySearch($lower,$upper){
      $result =  DB::table('inventory')->select('productRef','brandName')->where('brandName','like',$lower.'%')->orwhere('brandName','like',$upper.'%')->orderBy('id','DESC')->paginate(20);
      return $result;
    }
    public static function getProductDetails($ref){
      $result =  DB::table('inventory')->select('modelName','color','totalCost','description','brandName')->where('productRef',$ref)->get();
      return $result;
    }
    public static function addEbayInventory($detail){
      //echo '<pre>';print_r($detail);die;
    }
    public static function getMatchingInventory(){
      //DB::enableQueryLog();
      $result =  DB::table('amazonInventory')
      ->select('amazonInventory.itemName as amazonProName','amazonInventory.sellerSku','amazonInventory.quantity as amazonQty','amazonInventory.price as amazonPrice','ebayInventory.titleName as ebayProName','ebayInventory.price as ebayPrice','ebayInventory.quantityEbay as ebayQty','productVariation.name as varEbayProName','productVariation.price as varEbayPrice','productVariation.quantity as varEbayQty')
      ->leftJoin('ebayInventory','ebayInventory.productSKU','=','amazonInventory.sellerSku')
      ->leftJoin('productVariation','productVariation.productSKU','=','amazonInventory.sellerSku')
      ->where('ebayInventory.id','!=',null)
      ->orwhere('productVariation.id','!=',null)
      ->orderBy('amazonInventory.quantity','DESC')
      ->paginate(5,['*'],'matching');
      $dfd = DB::getQueryLog();
      // print_r(
      //     $dfd[0]['query']
      // );
      // die('asd');
      return $result;
    }
    public static function getEbayInventory(){
      $result =  DB::table('ebayInventory')->select('*')->orderBy('endTimeEbay','DESC')->paginate(5,['*'],'ebay');
      return $result;
    }
    public static function getAmazonInventory(){
      $result =  DB::table('amazonInventory')->select('*')->orderBy('quantity','DESC')->paginate(5,['*'],'amazon');
      return $result;
    }
    public static function searchMatchingInventory($lower,$upper){
      DB::enableQueryLog();
      $result =  DB::table('amazonInventory')
      ->select('amazonInventory.itemName as amazonProName','amazonInventory.sellerSku','amazonInventory.quantity as amazonQty','amazonInventory.price as amazonPrice','ebayInventory.titleName as ebayProName','ebayInventory.price as ebayPrice','ebayInventory.quantityEbay as ebayQty','productVariation.name as varEbayProName','productVariation.price as varEbayPrice','productVariation.quantity as varEbayQty')
      ->leftJoin('ebayInventory','ebayInventory.productSKU','=','amazonInventory.sellerSku')
      ->leftJoin('productVariation','productVariation.productSKU','=','amazonInventory.sellerSku')
      ->where(function($query)
          {
           $query->where('ebayInventory.id','!=',null)
           ->orwhere('productVariation.id','!=',null);
          })
      ->where(function($query) use ($lower,$upper)
          {
           $query->where('amazonInventory.itemName','like','%'.$lower.'%')
           ->orwhere('amazonInventory.sellerSku','like','%'.$lower.'%')
           ->orwhere('amazonInventory.itemName','like','%'.$upper.'%')
           ->orwhere('amazonInventory.sellerSku','like','%'.$upper.'%');
          })
      ->orderBy('amazonInventory.quantity','DESC')
      ->paginate(5,['*'],'matching');

      // dd(
      //      DB::getQueryLog()
      //  );

      return $result;
    }
    public static function searchInventory($lower,$upper){
      $result =  DB::table('ebayInventory')->select('*')->where('ImeNum','like',$lower.'%')->orwhere('titleName','like',$lower.'%')->orwhere('ImeNum','like',$upper.'%')->orwhere('titleName','like',$upper.'%')
      ->orderBy('endTimeEbay','DESC')->paginate(5,['*'],'ebay');
      return $result;
    }
    public static function searchAmazonInventory($lower,$upper){
      $result =  DB::table('amazonInventory')->select('*')->where('itemName','like',$lower.'%')
      ->orwhere('itemName','like',$lower.'%')
      ->orwhere('ASIN','like',$lower.'%')->orwhere('ASIN','like',$upper.'%')
      ->orwhere('sellerSku','like',$upper.'%')->orwhere('sellerSku','like',$upper.'%')
      ->orderBy('quantity','DESC')->paginate(5,['*'],'amazon');
      return $result;
    }
    public static function manageEbayInventory(){
      $result =  DB::table('ebayInventory')->select('*')->join('orderItem','orderItem.itemId','=','ebayInventory.ebayItemRef')->get();
      return $result;
    }
    public static function UpdateAmazonInventory($data,$table)
    {
      foreach ($data as $key => $value)
      {
        $result =  DB::table($table)
        ->where('sellerSku', $value['sellerSku'])
        ->update($value);
      }
    }

    public static function getEbayInvMaxDate(){
      $result =  DB::table('ebayInventory')->select('startTimeEbay')->orderBy('startTimeEbay', 'desc')->first();
      return $result;
    }
    public static function updateEbayInventory($data,$table)
    {
      foreach ($data as $key => $value)
      {
        $result =  DB::table($table)
        ->where('ebayItemRef', $value['ebayItemRef'])
        ->update($value);
      }
    }
    public static function deleteProduct($param)
    {
      $result = DB::table($param['dataTable'])->where('productRef','=', $param['productRef'])->delete();
      return $result;
    }
    public static function getActiveInvProductDetails($param)
    {

      if($param['dataTo'] == 'ebay')
      {
        $result['ebay'] = DB::table("ebayInventory")->select('*')->where('ebayItemRef','=', $param['itemId'])->get();
      }else{
        $result['amazon'] = DB::table("amazonInventory")->select('*')->where('sellerSku','=', $param['itemId'])->get();
      }
      return $result;
    }
    public static function insertProduct($data)
    {
      // echo "<pre>";
      // print_r($data);die;
      foreach ($data['products'] as $insertData) {
        $result = DB::table("amazoneProduct")->select('*')->where('itemID','=', $insertData['itemID'])->get();
        if(!empty($result)){
          $updateDate = array(
                          'updated_at' => date("Y-m-d- H:i:s")
                        );
          array_shift($insertData);
          $updateData   = array_merge($insertData,$updateDate);
          $updateResult = DB::table('amazoneProduct')
                          ->where('itemID', $insertData['itemID'])
                          ->update($updateData);
          foreach ($data['productsVariation'] as $productsVariation) {
            $variationData = array_merge($productsVariation,$updateDate);
            if($variationData['itemID'] == $result[0]->itemID){
              array_shift($variationData);
              $updateResult = DB::table('productVariation')
                              ->where('itemID', $variationData['itemID'])
                              ->update($variationData);
              $response     = $updateResult;
            }
          }
         }else{
          $productResult = DB::table('amazoneProduct')->insert($insertData);
          $productId     = DB::getPdo()->lastInsertId();
          $result        = DB::table("amazoneProduct")->select('*')->where('id','=', $productId)->get();
          $response      = $productResult;
          if(!empty($data['productsVariation'])){
            foreach ($data['productsVariation'] as $productsVariation) {
              if($productsVariation['itemID'] == $result[0]->itemID){
                $variationResult = DB::table('productVariation')->insert($productsVariation);
                $response        = $variationResult;
              }
            }
          }
        }
      }
      return $response;
    }

    public static function insertVaritaion($param)
    {
      foreach ($param as $insertData) {
        $result = DB::table("productVariation")->select('*')
        ->where('itemID','=', $insertData['itemID'])
        ->where('name','=', $insertData['name'])
        ->get();
        if(!empty($result)){
          $insertData['updated_at'] = date("Y-m-d- H:i:s");
          $updateResult = DB::table('productVariation')
                          ->where('itemID', $insertData['itemID'])
                          ->where('name','=', $insertData['name'])
                          ->update($insertData);
          $response     = $updateResult;
        }else{
          $variationResult = DB::table('productVariation')->insert($insertData);
          $response        = $variationResult;
        }
      }
      return $response;
    }

    public static function searchAmazonInventoryProduct($lower,$upper){
      // DB::enableQueryLog();
      $result =  DB::table('amazonInventory')->select('*')->where('itemName','like','%'.trim($lower).'%')
      ->orwhere('itemName','like','%'.trim($lower).'%')
      ->get();
      // $query = DB::getQueryLog();
      // $query = end($query);
// print_r($query);
      return $result;
    }

    public static function mapping($detailInfo){
      //print_r($detailInfo);
      $num = DB::table('amaEb_mapping')->insert($detailInfo);
      return $num;
    }
}
