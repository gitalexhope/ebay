<?php

ini_set("display_errors", 1);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF 
{	
	public $isLastPage = false;
    public function Footer()
	{
        $html = '';
        if ($this->isLastPage)
		{
            $invoiceData = $_SESSION['invoiceData']; 
			$html .= '
					<table width="100%" style="border-collapse:collapse;font-size:8px;margin-top: 50px;border-top: 1px solid #000;font-family:arial;" cellpadding="5">
						<tbody>
							<tr>
								<td align="left" style="font-weight:bold;">Item Count</td>
								<td></td>	
								<td align="right">'.$invoiceData['total_products'].'</td>								
							</tr>
							<tr>
								<td align="left" style="font-weight:bold;">Total (excluding GST)</td>
								<td></td>	
								<td align="right">'.$invoiceData['invoice_details']->subtotal.'</td>								
							</tr>
							<tr>
								<td align="left" style="font-weight:bold;">GST '.bcdiv($invoiceData['invoice_details']->taxpec1,1).' %</td>
								<td></td>	
								<td align="right">' . $invoiceData['invoice_details']->tax . '</td>								
							</tr>
							<tr>
								<td align="left" style="font-weight:bold;"> Total (Inclusive GST)</td>
								<td align="center"> S$ </td>	
								<td align="right"> ' . $invoiceData['invoice_details']->total . '</td>								
							</tr>					
						</tbody>
					</table>';
			$html .= '			
					<table width="100%" style="border-collapse:collapse;font-size:8px;margin-top: 50px;border-top: 1px solid #000;font-family:arial;" cellpadding="5">
						<tbody>
							<tr>
								<td align="left" style="text-decoration:underline;">GST Summary</td>
								<td align="center"style="text-decoration:underline;">Amount (S$)</td>
								<td align="right" style="text-decoration:underline;">GST (S$)</td>
							</tr>
							<tr>
								<td align="left">'.$invoiceData['invoice_details']->taxcode.' @ '.bcdiv($invoiceData['invoice_details']->taxpec1,1).' %</td>
								<td align="center">' . $invoiceData['invoice_details']->subtotal . '</td>
								<td align="right">' . $invoiceData['invoice_details']->tax . '</td>
							</tr>
						</tbody>
					</table>';           
			$this->SetY(-100);
		}
        $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
    }

    public function lastPage($resetmargins = false) 
	{
        $this->setPage($this->getNumPages(), $resetmargins);
        $this->isLastPage = true;
    }
}
?>