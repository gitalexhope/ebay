<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});
Route::get('/', 'LoginController@loginUser');
Route::post('/login', 'LoginController@loginUser');
Route::get('/logout', 'LoginController@logOutUser');
Route::get('/dashboard', 'DashboardController@dashboard');
Route::get('/orders', 'OrderController@dashboard');
Route::any('/add-product', 'InventoryController@addInventory');
Route::any('/add-image', 'InventoryController@addImage');
Route::get('/checkMEIM/{id}', 'InventoryController@checkMEIMNum');
Route::any('/product-list', 'InventoryController@getInventory');
Route::any('/searchInventory', 'InventoryController@searchInventory');
Route::any('/editInventory', 'InventoryController@getInventoryDetail');
Route::any('/update-inventory', 'InventoryController@updateInventoryDetail');
Route::any('/list-inventory-ebay', 'InventoryController@addInventoryEbay');
Route::get('/order-list', 'OrderController@orderList');
Route::get('/searchOrder', 'OrderController@orderSearch');
Route::get('/add-tracking', 'OrderController@addTracking');
Route::get('/get-order-detail', 'OrderController@getOrderDetail');
Route::any('/add-inventory', 'InventoryController@addInventoryEbay');
Route::get('/fetch-product', 'InventoryController@fetchProduct');
Route::get('/getProductDetails', 'InventoryController@productDetailByRef');
Route::get('/inventory-list', 'InventoryController@getInventoryList');
Route::get('/searchInventoryList', 'InventoryController@searchInventoryList');
Route::get('/testamazonorder', 'OrderController@getAmazonOrders');
Route::get('/amazon-order-list', 'OrderController@getAmazonOrderList');
Route::get('/testorder', 'OrderController@getAmazonOrder');
Route::get('/searchAmazonOrder', 'OrderController@searchAmazoneOrderList');
Route::get('/amazon-order-detail', 'OrderController@getAmazonOrderDetails');
Route::get('/amazon-add-tracking', 'OrderController@amazonAddTracking');
Route::get('/reports', 'ReportsController@reports');
Route::get('/amazon-report', 'ReportsController@amazonFinance');
Route::get('/searchAmazonCommissionData', 'ReportsController@searchCommissionData');
Route::get('/track-order', 'ReportsController@trackTrackingNumber');
Route::get('/get-track-order', 'ReportsController@getTrackOrderDetail');
Route::get('/amazon-shipment', 'ReportsController@amazonShipment');
Route::get('/amazon-product', 'InventoryController@amazonProduct');
Route::get('/amazon-product-search', 'InventoryController@amazonProductsSearch');
Route::get('/InventoryGraph', 'DashboardController@InventoryGraph');
Route::get('/return-order', 'OrderController@returnOrder');
Route::get('/get-return-order-items', 'OrderController@getReturnOrderItems');
Route::get('/get-returnOrder-status', 'OrderController@getReturnChargesStatus');
Route::get('/update-order-status', 'OrderController@updateOrderStatus');
// **********************************************
// inventory pull
Route::get('/ebay-inventory', 'InventoryController@getEbayInventory');
Route::get('/amazon-inventory', 'InventoryController@pullAmazonInventory');
// **********************************************
Route::get('/add-imei-number', 'OrderController@addIMEINumber');
Route::get('/amazonorderfil', 'OrderController@AmazonOrderFilter');
Route::get('/converter', 'ReportsController@imgConverter');
Route::post('/converter-img', 'ReportsController@pdfTojpgConverter');
Route::get('/profitChart', 'DashboardController@profitChart');
Route::get('/generate-pdf', 'PdfController@createPDF');
Route::get('/downloadPdf', 'PdfController@downloadPdf');
Route::get('/profit-report', 'ReportsController@getCommissionData');
Route::get('/item-profit-report', 'ReportsController@itemProfit');
Route::get('/ebay-item-profit-detail', 'ReportsController@EbayItemProfitDetail');
Route::get('/amazon-item-profit-detail', 'ReportsController@AmazonItemProfitDetail');
Route::get('/return', 'OrderController@getReturnOrders');
Route::get('/searchReturnList', 'OrderController@searchReturnList');
Route::get('/delete-product', 'InventoryController@deleteProduct');
Route::get('/get-product-details', 'InventoryController@getActiveInvProductData');
Route::get('/update-active-inventory', 'InventoryController@updateAmazonActiveInventory');
Route::get('/product-sku', 'InventoryController@productSKU');
/*** invoice roots ***/

Route::get('/create-invoice', 'InvoiceController@createInvoice');
Route::get('/invoice-list', 'InvoiceController@invoiceList');
Route::get('/download-invoice', 'InvoiceController@downloadInvoice');
Route::get('/search-invoice', 'InvoiceController@searchInvoice');

/********* Shipping label ebay routes ***/
Route::get('/getShippingDetails', 'ShippingLabelController@getShippingDetails');
Route::any('/print-ebay-shipping-label', 'ShippingLabelController@ebayPrintLabel');
Route::any('/print-amazon-shipping-label', 'ShippingLabelController@amazonShippingLabel');
Route::any('/download-amazon-shipping-label', 'ShippingLabelController@downloadAmzShipLable');

Route::get('/ebay-store', 'OrderController@ebayStore');


Route::get('/create-shipping', 'ReportsController@shippingLabel');

Route::get('/test-amazon-api', 'InventoryController@testAmazonApi');
Route::get('/test-ebay-api', 'InventoryController@testEbayApi');
