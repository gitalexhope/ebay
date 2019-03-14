<?php
namespace App\Http\Controllers;

use Helper;
use Validator;
use Hash;
use Session;
use Redirect;
use URL;
//use App\User;
//use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Models\Login as Login;
use App\Http\Models\Order as Order;
use App\Http\Models\Reports as Reports;
use App\Services\ebay\getcommon;
use App\Services\TCPDF;
use DOMDocument;
class PdfController extends Controller
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
    public function createPDF(Request $request)
    {
			$html1 = '';
			$startDateRange = date('Y-m-d',strtotime($request->get('startDateRange')));
			$endDateRange 	= date('Y-m-d',strtotime($request->get('endDateRange')));
			$dataRef 				= $request->get('dataRef');
			$result = array();
			if( $startDateRange != '' && $startDateRange != '0000-00-00' && $startDateRange != '1970-01-01')
	          $startDateRange = date('Y-m-d',strtotime($startDateRange));
	      else
	          $startDateRange = '';

	      if( $endDateRange != '' && $endDateRange != '0000-00-00' && $endDateRange != '1970-01-01')
	          $endDateRange = date('Y-m-d',strtotime($endDateRange));
	      else
	          $endDateRange = '';
			if($dataRef == 'ebay')
			{
				$result['ebayProfit']  = Reports::getPdfEbayProfit($startDateRange,$endDateRange);
			}
			else
			{
				$result['amazonProfit'] = Reports::getPdfAmazonProfit($startDateRange,$endDateRange);
			}
			//echo "<pre>";print_r($result);die;
			$i = 0;
			if(!empty($result['ebayProfit']) || !empty($result['amazonProfit']))
			{
				//print_r($result);
				if(isset($result['ebayProfit']))
				{
					$html1 = '<table cellpadding="5px;" cellspacing="0" style="border: 1px solid #ddd;padding:5px; width:620px; text-align:left; font-size:11px;">
					<thead>
					<tr>
					<th style="border: 1px solid #ddd;font-weight:bold;">Sr.No.</th>
					<th style="border: 1px solid #ddd;width:170px; font-weight:bold;">Order Number</th>
					<th style="border: 1px solid #ddd;width:30px;font-weight:bold;">Qty</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Total Paid</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Return Charges</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Final Value Fee</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">PayPal Fee</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Total Profit</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Sale Date</th>
					</tr>
					</thead>';
					//  getting information
					$retunCharges 			= 0;
					$totalPaid    			= 0;
					$totalFinalValue    = 0;
					$totalProfit    		= 0;
					$FeeOrCreditAmount  = 0;
					foreach ($result['ebayProfit'] as $key => $ebayValue) {
						$i++;
						$getReturnCharges = Helper::returnCharge($ebayValue->orderRef,1);
						$retunrChargeValue = ($getReturnCharges[0]->returnCharge) ? $getReturnCharges[0]->returnCharge = $getReturnCharges[0]->returnCharge : 0.00 ;
						$retunrChargeValue = ($retunrChargeValue) ? $retunrChargeValue : 0 ;
						$paidAmount 	= $ebayValue->amountPaid;
						$orderCharges = $ebayValue->FinalValueFee +  $ebayValue->FeeOrCreditAmount + $retunrChargeValue;
						$profitAmount = $paidAmount - $orderCharges;
						$date=date_create($ebayValue->lastModifiedDate);
						$html1 .='<tbody>
						<tr>
						<td style="border: 1px solid #ddd;">'.$i.'</td>
						<td style="width:170px;border: 1px solid #ddd;">'.$ebayValue->orderRef.'</td>
						<td style="width:30px;border: 1px solid #ddd;">'.$ebayValue->totalItemPurchased.'</td>
						<td style="border: 1px solid #ddd;">'.number_format($ebayValue->amountPaid,2).'</td>
						<td style="border: 1px solid #ddd;">'.number_format($retunrChargeValue,2).'</td>
						<td style="border: 1px solid #ddd;">'.number_format($ebayValue->FinalValueFee,2).'</td>
						<td style="border: 1px solid #ddd;">'.number_format($ebayValue->FeeOrCreditAmount,2).'</td>
						<td style="border: 1px solid #ddd;">'.number_format($profitAmount,2).'</td>
						<td style="border: 1px solid #ddd;">'.date_format($date,"d/m/Y").'</td>
						</tr>';
						$retunCharges 			+= $retunrChargeValue;
						$totalPaid				  += $ebayValue->amountPaid;
						$totalFinalValue    += $ebayValue->FinalValueFee;
						$FeeOrCreditAmount  += $ebayValue->FeeOrCreditAmount;
						$totalProfit    		+= $profitAmount;
					}
				$html1 .= '<tr>
											<td colspan="3" style="border: 1px solid #ddd; text-align:right;">Totals</td>
											<td style="border: 1px solid #ddd;">'.number_format($totalPaid,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($retunCharges,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($totalFinalValue,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($FeeOrCreditAmount,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($totalProfit,2).'</td>
											<td colspan="1" style="border: 1px solid #ddd;"></td>
									</tr>
							</tbody>
					</table>';
				}
				else
				{
					$html1 = '<table cellpadding="5px;" cellspacing="0" style="border: 1px solid #ddd;padding:5px; width:620px; text-align:left; font-size:11px;">
					<thead>
					<tr>
					<th style="width:45px;border: 1px solid #ddd;font-weight:bold;">Sr.No.</th>
					<th style="border: 1px solid #ddd;width:135px; font-weight:bold;">Order Number</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">QTY Shipped</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Total Price</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Return Charges</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Item Charge</th>
					<th style="border: 1px solid #ddd;font-weight:bold;">Total Profit</th>
					</tr>
					</thead>';
							//  getting information
							$totalPrice 			= 0;
							$itemCharge 			= 0;
							$profit     			= 0;
							$retunValuePrice  = 0;

							foreach($result['amazonProfit'] as $detail)
							{
								$i++;
								$singleItemCharge = 0;
								$singleItemPrice  = 0;
								$getAmazonReturnCharges = Helper::returnCharge($detail->AmazonOrderId,2);
								$AmazonRetunrChargeValue = ($getAmazonReturnCharges[0]->returnCharge !='') ? $getAmazonReturnCharges[0]->returnCharge = $getAmazonReturnCharges[0]->returnCharge : 0.00 ;

								$singleItemCharge += abs($detail->CommissionFeeAmt);
								$singleItemCharge += abs($detail->FixedClosingFee);
								$singleItemCharge += abs($detail->GiftwrapCommissionAmt);
								$singleItemCharge += abs($detail->SalesTaxCollectionFeeAmt);
								$singleItemCharge += abs($detail->ShippingHBAmt);
								$singleItemCharge += abs($detail->VariableClosingFeeAmt);

								$singleItemPrice  += abs($detail->ItemPrice);
								$singleItemPrice  += abs($detail->ShippingCharge);
								$singleItemPrice  += abs($detail->GiftWrapPrice);
								$singleItemPrice  += abs($detail->ItemTaxAmount);
								$singleItemPrice  += abs($detail->ShippingTaxAmount);
								$singleItemPrice  += abs($detail->GiftWrapTaxAmount);
								// Return orders charges
								$retunValuePrice 	+= $AmazonRetunrChargeValue;

								$price 						 = $singleItemPrice - $singleItemCharge ;
								$price 						 = $price - $AmazonRetunrChargeValue ;
								$totalPrice 			+= $singleItemPrice;
								$itemCharge 			+= $singleItemCharge;
								$profit     			+= $price;

								$html1 .='<tr>
									<td style="border: 1px solid #ddd;width:45px;">'.$i.'</td>
									<td style="width:135px;border: 1px solid #ddd;">'.$detail->AmazonOrderId.'</td>
									<td style="border: 1px solid #ddd;">'.$detail->QuantityShipped.'</td>
									<td style="border: 1px solid #ddd;">'.number_format($singleItemPrice,2).'</td>
									<td style="border: 1px solid #ddd;">'.number_format($AmazonRetunrChargeValue,2).'</td>
									<td style="border: 1px solid #ddd;">'.number_format($singleItemCharge,2).'</td>
									<td style="border: 1px solid #ddd;">'.number_format($price,2).'</td>
								</tr>';
						}
				$html1 .= '<tr>
											<td colspan="3" style="border: 1px solid #ddd; text-align:right;">Totals</td>
											<td style="border: 1px solid #ddd;">'.number_format($totalPrice,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($retunValuePrice,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($itemCharge,2).'</td>
											<td style="border: 1px solid #ddd;">'.number_format($profit,2).'</td>
									</tr>
							</tbody>
					</table>';
				}

				//echo $html1;

			include(app_path() . '/Services/tcpdf/custom_client_quote_footer.php');
			$pdf = new \MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			$pdf->SetPrintHeader(true);
			$pdf->setPrintFooter(true);
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
			// set margins
			$pdf->SetMargins(10, 25, 25, $keepmargins = false);
			$pdf->SetAutoPageBreak(TRUE, 27);
			$pdf->SetHeaderMargin(10);
			//$pdf->SetFooterMargin(30);
			// set auto page breaks
			$pdf->SetFont('helvetica', '', 12, '', false);
			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
			//  $pdf->SetFont('stsongstdlight','B', 12);
			//
			// add a page
			$pdf->AddPage();
			$pgtotlnm = $pdf->getAliasNbPages();
			$html1 = str_replace('{pgs}', $pgtotlnm, $html1);
			//$pdf->SetMargins(10, 25, 25, $keepmargins = false);
			//echo $html1; die;
			$pdf->writeHTML($html1, true, false, true, false, '');
			//$pdf->Output($name, $action);
			$pdf->lastPage();
			$name = Helper::unqNum();
			$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
			$filelocation = $DOCUMENT_ROOT.'/ebayamazon/assets/pdf';
			$fileNL = $filelocation . "/" . $name.'.pdf';
			$pdf->Output($fileNL, 'F');
			//echo $fileNL;
			Session::set('pdfName', $name.'.pdf');
			$successArray = array('success' => true, );
			echo json_encode($successArray);
			}
			else
			{
				$successArray = array('success' => false, );
				echo json_encode($successArray);
			}
    }
		public function downloadPdf()
    {

			$fileNameData	 	= 	Session::get('pdfName');
			if(trim($fileNameData !=''))
			{
				Session::forget('pdfName');
				$DOCUMENT_ROOT 	= 	$_SERVER['DOCUMENT_ROOT'];
				$upload_path 		= 	$DOCUMENT_ROOT.'/ebayamazon/assets/pdf/'.$fileNameData;
				$headers 				= 	['Content-Type: application/pdf'];
				$fileName 			= 	time().'.pdf';
				return response()->download($upload_path,$fileName,$headers)->deleteFileAfterSend(true);
			}
			$invoicePDF	 	= 	Session::get('invoicePdf');
			if (trim($invoicePDF)!='')
			{
				Session::forget('invoicePdf');
				$fileName  			=   $invoicePDF;
				$DOCUMENT_ROOT 	= 	$_SERVER['DOCUMENT_ROOT'];
				$upload_path 		= 	$DOCUMENT_ROOT.'/ebayamazon/assets/invoicePdf/'.$invoicePDF;
				$headers 				= 	['Content-Type: application/pdf'];
				#$fileName 			= 	time().'.pdf';
				return response()->download($upload_path,$fileName,$headers);
			}

    }


}
?>
