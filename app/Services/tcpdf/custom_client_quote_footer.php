<?php
ini_set("display_errors", 1);

// Include the main TCPDF library (search for installa4tion path).
require_once('tcpdf.php');
//echo "string"; die();


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header()
    {

        // echo "<pre>";
        // var_dump($getclientPdfDatasession[0]->projectName);
        // die();
        if ($this->getNumPages())
        {
            $this->SetLeftMargin(12);
            $html = '';
            $html .=    '<table width="100%">
                            <tr>
                            <td style="text-align:center;"><h3>Profit Report </h3></td>
                            </tr>
                        </table>';
            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
        }

    }

    public $isLastPage = false;

    public function Footer()
    {
        if ($this->getNumPages()>1)
        {
            $this->SetLeftMargin(12);
            $this->SetY(-27);
            //$this->SetY(-40);
            $html   = '';
            $html   .=  '<table border="0" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: middle;line-height:28px;text-align:center;border-top:1px solid #ddd;border-bottom:1px solid #ddd;">Page ' . $this->getNumPages() . ' of '.$this->getAliasNbPages().'</td>
                                </tr>
                                <tr>
                                    <td style="font-size:15px; text-align:center;"><b>Have a question? Need more detail? feel free to call us: +44(0)20 3397 3799</b></td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table>
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                 <td>
                                                    <table>
                                                        <tr>
                                                            <td align="center" style="font-size:11px;">Residential</td>

                                                            <td style="font-size:11px;">Commercial</td>

                                                            <td style="font-size:11px;">Marine</td>

                                                            <td style="font-size:11px;">Assisted Living</td>

                                                            <td style="font-size:11px;">Equestrian</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                   </td>
                                </tr>
                                <tr>
                                    <td align="center">Intelligent Building Design,Consultancy,Installation & Project Management</td>
                                </tr>
                            </tbody>
                        </table>';
            $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
        }
    }

    public function lastPage($resetmargins = false)
    {
        $this->setPage($this->getNumPages(), $resetmargins);
        $this->isLastPage = true;
    }

}

?>
