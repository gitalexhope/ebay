<?php

namespace App\Http\Models;
use DB;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
     protected $table = 'users';

    //  public static function getEbayProfit(){
    //    $result =  DB::table('ebayInventory')->select('*')->orderBy('id','DESC')->paginate(5,['*'],'ebay');
    //    return $result;
    //  }

     public static function ebayInvoiceList(){
        $result =  DB::table('invoices')->select('*')
        ->where('invoiceType','ebay')
        ->orderBy('invoices.id','DESC')->groupBy('invoiceNum')->paginate(5,['*'],'ebay');
        return $result;
      }
     public static function amazonInvoiceList(){
        $result =  DB::table('invoices')->select('*')
        ->where('invoiceType','amazon')
        ->orderBy('invoices.id','DESC')->groupBy('invoiceNum')->paginate(5,['*'],'amazon');
        return $result;
      }
     public static function searchEbayInvoiceList($lower,$upper){
        $result =  DB::table('invoices')->select('*')
        ->orWhere(function($query) use ($lower,$upper){
                 $query->where('invoiceNum','like','%'.$lower);
                 $query->where('invoiceNum','like',$upper.'%');
         })
        ->where('invoiceType','ebay')
        ->orderBy('invoices.id','DESC')->groupBy('invoiceNum')->paginate(5,['*'],'ebay');
        return $result;
      }
     public static function searchAmazonInvoiceList($lower,$upper){
        $result =  DB::table('invoices')->select('*')
        ->orWhere(function($query) use ($lower,$upper){
                 $query->where('invoiceNum','like','%'.$lower);
                 $query->where('invoiceNum','like',$upper.'%');
         })
        ->where('invoiceType','amazon')
        ->orderBy('invoices.id','DESC')->groupBy('invoiceNum')->paginate(5,['*'],'amazon');
        return $result;
      }


}
