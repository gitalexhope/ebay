<?php

ini_set("display_errors", 1);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	
	//Page header
    public function Header() {
		
	 $salesData = $_SESSION['salesData'];
	//	echo "<pre>"; print_r($salesData['Userprofiledata']); echo "</pre>";
		$tax	 		 	 =	"SALES  ";    
		$invoiceform		 =	"ORDER";    
		$tax_formatted 	 	 = implode(' ', str_split($tax)); 
		$invoice_formatted 	 = implode(' ', str_split($invoiceform)); 
		$pgtotlnm 	= 	$this->getAliasNumPage() . " of " . $this->getAliasNbPages();
		$dd = explode(' ', $salesData['so_details']->doc_date); 
		$SaleDate = date('d/m/Y',strtotime($dd[0]));	
		
		$addr1 = $addr2 = $addr3 = ' ';
		if($salesData['Userprofiledata']->addr1 != '')
		{
			$addr1 = $salesData['Userprofiledata']->addr1.'<br> ';
		}
		if($salesData['Userprofiledata']->addr2 != '')
		{
			$stringAfter = str_replace(",", "",$salesData['Userprofiledata']->addr2);
			$addr2 = $stringAfter .',<br> ';
		}
		if($salesData['Userprofiledata']->addr3 != '')
		{
			$addr3 = $salesData['Userprofiledata']->addr3 .' <br> ';
		}
		
		$address = $addr1.$addr2.$addr3;
		
		$html = '';
	    $html .= '<table width="100%">
		<tbody>
			<tr>
				<td colspan="3"></td>
				<td colspan="5" style="text-align:center;">
					<h1 style="margin-bottom:0; margin-top:0;">'.strtoupper($salesData['Userprofiledata']->cname).'</h1>
					<p style="font-size:10px;margin-top:0px;">'.$address.'Tel No. : '.$salesData['Userprofiledata']->phone1.' &nbsp; Fax No. :  '.$salesData['Userprofiledata']->fax.'</p>
				</td>
				<td colspan="2"></td>
				<td></td>
			</tr>
			
		</tbody>
	</table>
		
	<table>
		<tbody>
			<tr style="font-size:10px; margin-top:5px;">
				<td colspan="2" style="text-align:left;" width="20%"><b>Bill To #<br>' . $salesData['so_details']->name . '</b><br>' . $salesData['so_details']->addr . '</td>
				<td colspan="6"></td>
				<td colspan="4">
					<h2 style="margin-bottom:0;">'.$tax_formatted.'&nbsp;&nbsp;'.$invoice_formatted.'</h2>
					<table style="line-height:1.5;">
						<tr>
							<td style="text-align:left;"><b>No.:</b></td>
							<td style="text-align:left;">' . $salesData['sono'] . '</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align:left;"><b>Date :</b></td>
							<td style="text-align:left;">'.$SaleDate.'</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align:left;"><b>P/O Ref.:</b></td>
							<td> </td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align:left;"><b>Terms:</b></td>
							<td style="text-align:left;">C.O.D</td>
							<td></td>
						</tr>
						<tr>
							<td style="text-align:left;"><b>Page :</b></td>
							<td style="text-align:left;" width="0%">'.$pgtotlnm .'</td>
							<td></td>
						</tr>
					</table>				
				</td>
			</tr>
		</tbody>
	</table>';
	$html.= '<br><br>';
	$html.= '<table>
		<tbody>
			<tr>
				<td colspan="2">
					<table width="100%;" style="text-align:left;font-size:10px; border-collapse: collapse;" cellpadding="5">
						<tr style="font-weight:bold;">
							<th  style="border-top:1px solid #000; border-bottom:1px solid #000; width:30px;">No.</th>
							<th  style="border-top:1px solid #000; border-bottom:1px solid #000; width:40px;">Code</th>
							<th  style="border-top:1px solid #000; border-bottom:1px solid #000; width:250px;">Description</th>
							<th align="right" style="border-top:1px solid #000; border-bottom:1px solid #000; width:50px";>Qty</th>
							<th  align="right" style="border-top:1px solid #000; border-bottom:1px solid #000;">Price</th>
							<th  align="right" style="border-top:1px solid #000; border-bottom:1px solid #000;">Disc. Tax Code</th>
							<th  align="right" style="border-top:1px solid #000; border-bottom:1px solid #000;">Amount/ '.$salesData['so_details']->curr_code.'</th>
						</tr>
					</table>
				</td>
			</tr>			
		</tbody>
		</table>';
	
		$this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);       
    }
	

    public $isLastPage = false;

    public function Footer() {
        $html = '';
        if ($this->isLastPage) {
            $salesData = $_SESSION['salesData'];
            //echo "<pre>"; print_r($salesData); echo "</pre>";				 die;
            $html = '<table width="100%">
						<tbody>
							<tr>
								<td colspan="2" width="0%">';
            $html .='			
				<table width="96%" style="border-collapse: collapse;font-size:10px;margin-top: 50px;border-right: 1px solid #000;border-top: 1px solid #000;" cellpadding="5">
					<tbody>
						<tr style="vertical-align: top;">
							<td width="20%" align="left"><b>' . $salesData['currWord'] . '</b></td>
							<td colspan="2" align="left">' . $salesData['convertNumber'] . ' ONLY</td>
							<td colspan="2" align="right" style="text-align:left;border-bottom: 1px solid #000;border-left: 1px solid #000;">
								<strong>Sub Total (Excluding GST)<br>Discount<br>GST ' . $salesData['so_details']->taxpec1 . ' % on ' . $salesData['so_details']->subtotal . '</strong>
							</td>
							<td align="right" style="text-align:left;border-bottom: 1px solid #000;border-left: 1px solid #000;">
								' . $salesData['so_details']->subtotal . '<br>0.00<br>' . $salesData['so_details']->tax . '
							</td>
						</tr>
						<tr style="vertical-align: top;">
							<td align="left">
								<p><span style="margin-right:50px;float:left; text-decoration:underline;">GST summary</span><br>'.$salesData['so_details']->taxcode.' @ '.bcdiv($salesData['so_details']->taxpec1,1).' %
								</p>
							</td>
							<td align="left">
								<p><span style="margin-right:50px;float:left; text-decoration:underline;">Amount (S$)</span><br>' . $salesData['so_details']->subtotal . '
								</p>
							</td>
							<td align="left">
								<p>
								<span style="margin-right:50px;float:left; text-decoration:underline;">GST(S$)</span>
								<br>' . $salesData['so_details']->tax . '
								</p>
							</td>
							<td align="right" colspan="2" style="text-align:left;border-bottom: 1px solid #000;border-left: 1px solid #000;">
								<strong>Total<br>Rounding Adj.</strong>
							</td>
							<td align="right" style="text-align:left;border-bottom: 1px solid #000;border-left: 1px solid #000;">
								' . $salesData['so_details']->total . '<br>0.00
							</td>
						</tr>
						<tr style="vertical-align: top;">
							<td colspan="2"></td>
							<td></td>
							<td align="right" colspan="2" style="text-align:left;float:left;border-bottom: 1px solid #000;border-left: 1px solid #000;">
								<strong>Grand Total</strong>
							</td>
							<td align="right" style="text-align:left;float:left;border-bottom: 1px solid #000;border-left: 1px solid #000;">
								' . $salesData['so_details']->total . '
							</td>
						</tr>
					</tbody>
				</table>
				';
            $html .='
										</td>
									</tr>
								</tbody>
				</table>';

            $html .='<p></p><p></p><p></p>';
					
			$html .='<table style="position:fixed; bottom:0px;">
						<tbody>
							<tr>
								<td colspan="2">
									<table width="100%" style="font-size:12px;margin-top: 50px;" cellpadding="5">
										<tbody>';
										
											$html .='<tr>
												<td style="text-align:center;border-top: 1px solid #000;">
												<p style="font-size:12px">FOR ' . $salesData['Userprofiledata']->cname . '</p>
												</td>
												<td></td>
												<td style="text-align:center;border-top: 1px solid #000;">
												<p style="font-size:12px">Customer Signature & Stamp</p>
												</td>
											</tr>';
										
										$html .='</tbody>
									</table>';
			$html .='			</td>
							</tr>
						</tbody>
					</table>';
				
			
        }
		$this->SetY(-55);
        $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
    }

    public function lastPage($resetmargins = false) {
        $this->setPage($this->getNumPages(), $resetmargins);
        $this->isLastPage = true;
    }

}

?>