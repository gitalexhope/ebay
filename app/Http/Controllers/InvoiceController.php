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
use App\Http\Models\Invoice as Invoice;
use App\Services\ebay\getcommon;
use DOMDocument;
class InvoiceController extends Controller
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
	public function createInvoice(Request $request)
	{



			if (trim($request->get('invoiceDataTo')) == "ebay")
			{
				$resultVal['orderDetail'] 		 	=   Order::orderDetailById($request->get('invoiceRef'));
				$resultVal['orderTransaction'] 	=   Order::orderTransactionDetails($request->get('invoiceRef'));
				$resultVal['orderItem'] 			 	=   Order::orderItemsDetails($request->get('invoiceRef'));
				include(app_path() . '/Services/tcpdf/custom_client_quote_footer.php');
				include(app_path() . '/Services/tcpdf/tcpdf_barcodes_1d_include.php');
				// $barcodeobj = new \TCPDFBarcode($request->get('invoiceRef'), 'C128','', '', '', 18, 0.4, $style, 'N');
				// $resultVal['barcode'] =  $barcodeobj->getBarcodeHTML(2, 50, 'black');
				$html = view('invoice.invoicePDF',$resultVal);

				$html1 = $html;
				$pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetPrintHeader(false);
				$pdf->setPrintFooter(false);
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				// set margins
				$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
				$img  = file_get_contents($DOCUMENT_ROOT.'ebayamazon/assets/images/Pdfimages/logo.png');
        		$pdf->Image('@' . $img, 24 ,15, '162', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

				$pdf->SetMargins(8, 20, 20, $keepmargins = false);
				$pdf->SetAutoPageBreak(TRUE, 27);
				$pdf->SetHeaderMargin(5);
				//$pdf->SetFooterMargin(30);
				// set auto page breaks
				$pdf->SetFont('helvetica', '', 12, '', false);
				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				//  $pdf->SetFont('stsongstdlight','B', 12);
				// add a page
				$pdf->AddPage();
				// define barcode style
				$style = array(
						'position' 		 => 'C',
						'align' 	 		 => 'C',
						'stretch'  		 => false,
						'fitwidth' 		 => true,
						'cellfitalign' => '',
						'border' 			 => false,
						'hpadding' 		 => 'auto',
						'vpadding' 		 => 'auto',
						'fgcolor' 		 => array(0,0,0),
						'bgcolor' 		 => false, //array(255,255,255),
						'text' 				 => false,
						'font' 				 => 'helvetica',
						'fontsize' 		 => 8,
						'stretchtext'  => 4
				);
				$pgtotlnm = $pdf->getAliasNbPages();
				$html1 = str_replace('{pgs}', $pgtotlnm, $html1);
				//$pdf->SetMargins(10, 25, 25, $keepmargins = false);
				// echo $html1; die;
				$pdf->writeHTML($html1, true, false, true, false, '');
				$pdf->write1DBarcode($request->get('invoiceRef'), 'C128', '', '', '', 15, 0.4, $style, '');
				//$pdf->Output($name, $action);
				$pdf->lastPage();
				$invoiceRefNum = $request->get('invoiceRef');
				$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
				$filelocation  = $DOCUMENT_ROOT.'ebayamazon/assets/invoicePdf';
				$fileNL = $filelocation . "/" . $invoiceRefNum.'.pdf';
				$pdf->Output($fileNL, 'F');
				Session::set('invoicePdf', $invoiceRefNum.'.pdf');
				$checkExits  = order::checkExits('invoices',array('invoiceNum'=>$invoiceRefNum));
				if($checkExits == 0)
				{
					$invoiceData = array(
						'invoiceRef'   => 	Helper::unqNum(),
						'invoiceNum'   => 	$invoiceRefNum,
						'invoiceType'  =>  $request->get('invoiceDataTo'),
						'invoiceName'  =>  $invoiceRefNum.'.pdf',
						'addedOn' 		 =>  date('Y-m-d'),
						'modifiedDate' =>  date('Y-m-d'),
						'addedBy' 		 =>  Session::get('amaEbaySessId'),
						'status' 			 =>  1,
				);
					$add_Invoice	=	order::commonInsert($invoiceData,'invoices');
				}else {
					$add_Invoice = 1;
				}

				if ($add_Invoice == 1) {
					$successArray['success'] =	true;
				}else {
					$successArray['success'] =	false;
				}
			}
			else if (trim($request->get('invoiceDataTo')) == "amazon")
			{
				$resultVal['orderDetail'] 		 =   Order::amazoneOrderDetailById($request->get('invoiceRef'));
				$resultVal['orderItem']				 =   Order::amazoneOrderItemsDetails($request->get('invoiceRef'));
				$resultVal['commissionData'] 	 =   Order::OrderCommissionData($request->get('invoiceRef'));

				include(app_path() . '/Services/tcpdf/custom_client_quote_footer.php');
				include(app_path() . '/Services/tcpdf/tcpdf_barcodes_1d_include.php');
				// $barcodeobj = new \TCPDFBarcode($request->get('invoiceRef'), 'C128','', '', '', 18, 0.4, $style, 'N');
				// $resultVal['barcode'] =  $barcodeobj->getBarcodeHTML(2, 50, 'black');
				$html = view('invoice.amazonInvoicePDF',$resultVal);

				$html1 = $html;
				$pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$pdf->SetPrintHeader(false);
				$pdf->setPrintFooter(false);
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				// set margins
				$pdf->SetMargins(8, 20, 20, $keepmargins = false);
				$pdf->SetAutoPageBreak(TRUE, 27);
				$pdf->SetHeaderMargin(5);
				//$pdf->SetFooterMargin(30);
				// set auto page breaks
				$pdf->SetFont('helvetica', '', 12, '', false);
				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				//  $pdf->SetFont('stsongstdlight','B', 12);
				// add a page
				$pdf->AddPage();
				// define barcode style
				$style = array(
						'position' 		 => 'C',
						'align' 	 		 => 'C',
						'stretch'  		 => false,
						'fitwidth' 		 => true,
						'cellfitalign' => '',
						'border' 			 => false,
						'hpadding' 		 => 'auto',
						'vpadding' 		 => 'auto',
						'fgcolor' 		 => array(0,0,0),
						'bgcolor' 		 => false, //array(255,255,255),
						'text' 				 => false,
						'font' 				 => 'helvetica',
						'fontsize' 		 => 8,
						'stretchtext'  => 4
				);
				$pgtotlnm = $pdf->getAliasNbPages();
				$html1 = str_replace('{pgs}', $pgtotlnm, $html1);
				//$pdf->SetMargins(10, 25, 25, $keepmargins = false);
				// echo $html1; die;
				$pdf->writeHTML($html1, true, false, true, false, '');
				$pdf->write1DBarcode($request->get('invoiceRef'), 'C128', '', '', '', 15, 0.4, $style, '');
				//$pdf->Output($name, $action);
				$pdf->lastPage();
				$invoiceRefNum = $request->get('invoiceRef');
				$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
				$filelocation  = $DOCUMENT_ROOT.'ebayamazon/assets/invoicePdf';
				$fileNL = $filelocation . "/" . $invoiceRefNum.'.pdf';
				$pdf->Output($fileNL, 'F');
				Session::set('invoicePdf', $invoiceRefNum.'.pdf');
				$checkExits  = order::checkExits('invoices',array('invoiceNum'=>$invoiceRefNum));
				if($checkExits == 0)
				{
					$invoiceData = array(
															'invoiceRef'   => 	Helper::unqNum(),
															'invoiceNum'   => 	$invoiceRefNum,
															'invoiceType'  =>  $request->get('invoiceDataTo'),
															'invoiceName'  =>  $invoiceRefNum.'.pdf',
															'addedOn' 		 =>  date('Y-m-d'),
															'modifiedDate' =>  date('Y-m-d'),
															'addedBy' 		 =>  Session::get('amaEbaySessId'),
															'status' 			 =>  1,
													);
					$add_Invoice	=	order::commonInsert($invoiceData,'invoices');
				}else {
					$add_Invoice = 1;
				}

				if ($add_Invoice == 1) {
					$successArray['success'] =	true;
				}else {
					$successArray['success'] =	false;
				}
			}
			echo json_encode($successArray);
	}

	public function invoiceList(){
		$resultVal['ebayInvoiceList'] 	=	Invoice::ebayInvoiceList();
		$resultVal['amazonInvoiceList'] =	Invoice::amazonInvoiceList();
		// echo "<pre>";print_r($resultVal);die;
		if(isset($_GET['ajax'])){
					return view('invoice.invoiceSearch',$resultVal) ;
		}
		else{
			echo Helper::adminHeader();
			return view('invoice.index',$resultVal) ;
		}
	}

	public function searchInvoice(Request $request){
		$resultVal['ebayInvoiceList'] 	=	Invoice::searchEbayInvoiceList($request->get('lowerCase'),$request->get('upperCase'));
		$resultVal['amazonInvoiceList'] =	Invoice::searchAmazonInvoiceList($request->get('lowerCase'),$request->get('upperCase'));
		return view('invoice.invoiceSearch',$resultVal) ;
		}
	public function downloadInvoice(Request $request)
	{
		$invoiceRefNum = $request->get('invoiceRef');
		Session::set('invoicePdf', $invoiceRefNum.'.pdf');
		if(session()->has('invoicePdf')){
			$success['success'] = true;
			$success['data'] = Session::get('invoicePdf');
		}else {
			$success['success'] = false;
		}
		echo json_encode($success);
	}
}
?>
