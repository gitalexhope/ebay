<?php


$html1 = "<table width='100%'><tbody><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr><tr><td>dsadadas</td></tr></tbody></table>";


   function generatePDF($html1 = NULL, $name = 'PDF', $path = null, $action = 'D') 
	{
        ob_start();
        ob_clean();
        ini_set('memory_limit', '-1');
        require_once('tcpdf.php');  
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        //$pdf->setFooterData('sasasa');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		//$pdf->addTTFfont('fonts/DroidSansFallback.ttf');
		//$fontname = TCPDF_FONTS::addTTFfont(APPPATH . 'third_party/tcpdf/fonts/arial.ttf', 'TrueTypeUnicode', '', 32);
		
		$pdf->SetFont('helvetica', '', 12, '', false);
        //$pdf->SetFont('dejavusans', '', 10);
		//$pdf->SetFont('kozminproregular', '', 12);
		//$pdf->SetFont('arialuni', '', 12);
        // add a page
        $pdf->AddPage();
		$pdf->SetLineStyle( array( 'width' => 2, 'color' => array(0,0,0)));
		$pdf->Line(0,0,$pdf->getPageWidth(),0); 
		$pdf->Line($pdf->getPageWidth(),0,$pdf->getPageWidth(),$pdf->getPageHeight());
		$pdf->Line(0,$pdf->getPageHeight(),$pdf->getPageWidth(),$pdf->getPageHeight());
		$pdf->Line(0,0,0,$pdf->getPageHeight());

        // output the HTML content
        $pdf->writeHTML($html1, true, false, true, false, '');
        $pdf->Output($name . '.pdf', $action);
    }
	generatePDF();
	
	

?>
