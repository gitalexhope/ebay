<?php

ini_set("display_errors", 1);

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        $clientProNme = $_SESSION['clientProNme'];
        $html = '';
        $html .= '<table width="100%">
                   <tbody>
                          <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                            </tr>

                            <tr>
                                    <td colspan="5" style="text-align:left;">
                                            <h4 style="margin-bottom:50px; margin-top:0;padding-bottom:50px;">CLIENT: ' . $clientProNme['clientproName'] . '</h4>
                                    </td>
                                    
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                            </tr>
                            
                            
                    </tbody>
            </table>';
        $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
    }

    public $isLastPage = false;

    public function Footer() {

        $html = '';
        $html .= '<table width="100%">
                    <tbody>
                            <tr>
                                  <td>Page <b>' . $this->getNumPages() . '</b> of <b>'.$this->getAliasNbPages().'</b></td>
                                  <td>' . date("d-m-Y") . '</td>
                                  <td>YSH STANDARD TERMS</td>
                            </tr>
                    </tbody>
                    </table>';
        $this->writeHTMLCell(0, 0, '', '', $html, 0, 0, false, "L", true);
    }

    public function lastPage($resetmargins = false) {
        $this->setPage($this->getNumPages(), $resetmargins);
        $this->isLastPage = true;
    }

}

?>
