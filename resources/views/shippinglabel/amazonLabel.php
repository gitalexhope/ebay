<?php

$html = '';
$customerName     =     $data['amazonShipping'][0]->customerName;
$addressLine1     =     $data['amazonShipping'][0]->addressLine1;
$addressLine2     =     $data['amazonShipping'][0]->addressLine2;
$addressLine3     =     $data['amazonShipping'][0]->addressLine3;
$city             =     $data['amazonShipping'][0]->city;
$county           =     $data['amazonShipping'][0]->county;
$district         =     $data['amazonShipping'][0]->district;
$stateOrRegion    =     $data['amazonShipping'][0]->stateOrRegion;
$postalCode       =     $data['amazonShipping'][0]->postalCode;
$countryCode      =     $data['amazonShipping'][0]->countryCode;
$phone            =     $data['amazonShipping'][0]->phone;
$orderRefId       =     $data['amazonShipping'][0]->orderRefId;
$buyerEmail       =     $data['amazonShipping'][0]->buyerEmail;

//echo "<pre>"; print_r($getService); die;
$html .='<form class="amazonShippingLabelForm" method="post">
  <input type="hidden" name="ShippingName" class="form-control  success ShippingName" value="'.$customerName.'">
  <input type="hidden" name="addressLine1" class="form-control success addressLine1" value="'.$addressLine1.'">
  <input type="hidden" name="addressLine2" class="form-control success addressLine2" value="'.$addressLine2.'">
  <input type="hidden" name="addressLine3" class="form-control success addressLine3" value="'.$addressLine3.'">
  <input type="hidden" name="cityName" class="form-control success cityName" value="'.$city.'">
  <input type="hidden" name="state" class="form-control success state" value="'.$stateOrRegion.'">
  <input type="hidden" name="countryName" class="form-control success countryName" value="'.$countryCode.'">
  <input type="hidden" name="phone" class="form-control success phone" value="'.$phone.'">
  <input type="hidden" name="postalCode" class="form-control success postalCode" value="'.$postalCode.'">
  <input type="hidden" name="orderID" class="form-control success orderID" value="'.$orderRefId.'">
  <input type="hidden" name="buyerEmail" class="form-control success orderID" value="'.$buyerEmail.'">
  <div class="modal-header">
    <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
    <h4 class="modal-title">
      <i class="glyphicon glyphicon-info-sign"></i> Shipping Label !</h4>
  </div>
  ';
  $phoneTr = '';
  if (trim($phone) != '') {
      $phoneTr = '<tr>
          <td><b>Phone</b></td>
          <td>'.$phone.'</td>
        </tr>';

  }
  $emailTr = '';
  if (trim($buyerEmail) != '') {
      $emailTr = '<tr>
          <td><b>Buyer Email</b></td>
          <td>'.$buyerEmail.'</td>
        </tr>';

  }
  $html .= '<div class="bootbox-body clearfix">
    <div class="col-sm-12">
    <div class="shipingMessageElement" ></div>
        <div class="shippingAddressTo col-sm-12">
          <h4><b>Ship To:- </b></h4>
          <div class="address">
                <table class="table">
                    <tr>
                      <td style="width:24%;"><b>Customer Name</b></td>
                      <td style="">'.ucwords($customerName).'</td>
                    </tr>
                    <tr>
                      <td><b>Full AddressLine</b></td>
                      <td>'.$addressLine1.' '.$addressLine2.' '. $addressLine3.'<br>
                      <b>City :-</b> '.$city.'<br> <b>State :-</b> '. $stateOrRegion.'<br> <b> Postal Code :-</b> '.$postalCode.' <br><b> Country :-</b> '. $countryCode .'
                      </td>
                    </tr>
                    '.$phoneTr.'
                    '.$emailTr.'
                </table>
          </div>
        </div>';
if(!empty($getService) && count($getService) > 0)
{

  $html .='<div class="col-sm-12 no-padding">
    <br>
      <div class="col-sm-6">
          <div class="form-group">
            <label for="">Package Type</label>
                <select class="shippingInputsuccess form-control ShippingServiceId" name="ShippingServiceId">
                    <option value="">Select Package Type</option>';
                    foreach ($getService as $key => $shipvalue) {
                    $html .='
                    <option data-ref="'.$shipvalue['CarrierName'].'" value="'.$shipvalue['ShippingServiceId'].'">'.$shipvalue['ShippingServiceName'].'. &nbsp;&nbsp;&nbsp;&nbsp;Ship Date ('.date('Y-m-d',strtotime($shipvalue['ShipDate'])).')</option>
                    ';
                    }
                    $html .='
                </select>
          </div>
      </div>';

}
    $html .='
        <div class="col-sm-6">
            <div class="form-group">
                <label for="">Label Type</label>
                  <select class="form-control shippingInputsuccess labelType" name="labelType">
                      <option value="">Select Label Type</option>
                      <option value="PNG">PNG</option>
                      <option value="PDF">PDF</option>
                      <option value="ShippingServiceDefault">ShippingServiceDefault</option>
                  </select>
            </div>
        </div>
        <div class="col-sm-12">
        <br>
            <div class="form-group">
            <label for="diamestion"> Select Predefined Packages </label>
              <select class="form-control shippingInputsuccess dimension" name="dimension">
              <option Value=""> Select Predefined Packages </option>
                  <optgroup label="Fedex">
                    <option value="FedEx_Box_10kg">FedEx_Box_10kg ~ 15.81 x 12.94 x 10.19 in</option>
                    <option value="FedEx_Box_25kg">FedEx_Box_25kg ~ 54.80 x 42.10 x 33.50 in</option>
                    <option value="FedEx_Box_Extra_Large_1">FedEx_Box_Extra_Large_1 ~ 11.88 x 11.00 x 10.75 in</option>
                    <option value="FedEx_Box_Extra_Large_2">FedEx_Box_Extra_Large_2 ~ 15.75 x 14.13 x 6.00 in</option>
                    <option value="FedEx_Box_Large_1">FedEx_Box_Large_1 ~ 	17.50 x 12.38 x 3.00 in</option>
                    <option value="FedEx_Box_Large_2">FedEx_Box_Large_2 ~ 11.25 x 8.75 x 7.75 in</option>
                    <option value="FedEx_Box_Medium_1">FedEx_Box_Medium_1 ~ 13.25 x 11.50 x 2.38 in</option>
                    <option value="FedEx_Box_Medium_2">FedEx_Box_Medium_2 ~ 11.25 x 8.75 x 4.38 in</option>
                    <option value="FedEx_Box_Small_1">FedEx_Box_Small_1 ~ 12.38 x 10.88 x 1.50 in</option>
                    <option value="FedEx_Box_Small_2">FedEx_Box_Small_2 ~ 11.25 x 8.75 x 4.38 in</option>
                    <option value="FedEx_Envelope">FedEx_Envelope ~ 12.50 x 9.50 x 0.80 in</option>
                    <option value="FedEx_Padded_Pak">FedEx_Padded_Pak ~ 11.75 x 14.75 x 2.00 in</option>
                    <option value="FedEx_Pak_1">FedEx_Pak_1 ~ 15.50 x 12.00 x 0.80 in</option>
                    <option value="FedEx_Pak_2">FedEx_Pak_2 ~ 12.75 x 10.25 x 0.80 in</option>
                    <option value="FedEx_Tube">FedEx_Tube ~ 38.00 x 6.00 x 6.00 in</option>
                    <option value="FedEx_XL_Pak">FedEx_XL_Pak ~ 17.50 x 20.75 x 2.00 in</option>
                  </optgroup>
                  <optgroup label="UPS">
                      <option value="UPS_Box_10kg">UPS_Box_10kg ~ 41.00 x 33.50 x 26.50 cm</option>
                      <option value="UPS_Box_25kg">UPS_Box_25kg ~ 48.40 x 43.30 x 35.00 cm</option>
                      <option value="UPS_Express_Box">UPS_Express_Box ~ 46.00 x 31.50 x 9.50 cm</option>
                      <option value="UPS_Express_Box_Large">UPS_Express_Box_Large ~ 18.00 x 13.00 x 3.00 in</option>
                      <option value="UPS_Express_Box_Medium">UPS_Express_Box_Medium ~ 15.00 x 11.00 x 3.00 in</option>
                      <option value="UPS_Express_Box_Small">UPS_Express_Box_Small ~ 13.00 x 11.00 x 2.00 in</option>
                      <option value="UPS_Express_Envelope">UPS_Express_Envelope ~ 12.50 x 9.50 x 2.00 in</option>
                      <option value="UPS_Express_Hard_Pak">UPS_Express_Hard_Pak ~ 14.75 x 11.50 x 2.00 in</option>
                      <option value="UPS_Express_Legal_Envelope">UPS_Express_Legal_Envelope ~ 15.00 x 9.50 x 2.00 in</option>
                      <option value="UPS_Express_Pak">UPS_Express_Pak ~ 16.00 x 12.75 x 2.00 in</option>
                      <option value="UPS_Express_Tube">UPS_Express_Tube ~ 97.00 x 19.00 x 16.50 cm</option>
                      <option value="UPS_Laboratory_Pak">UPS_Laboratory_Pak ~ 17.25 x 12.75 x 2.00 in</option>
                      <option value="UPS_Pad_Pak">UPS_Pad_Pak ~ 14.75 x 11.00 x 2.00 in</option>
                      <option value="UPS_Pallet">UPS_Pallet ~ 120.00 x 80.00 x 200.00 cm</option>
                  </optgroup>
                  <optgroup label="USPS">
                      <option value="USPS_Card">USPS_Card ~ 6.00 x 4.25 x 0.01 in </option>
                      <option value="USPS_Flat">USPS_Flat ~ 15.00 x 12.00 x 0.75 in </option>
                      <option value="USPS_FlatRateCardboardEnvelope">USPS_FlatRateCardboardEnvelope ~ 12.50 x 9.50 x 4.00 in </option>
                      <option value="USPS_FlatRateEnvelope">USPS_FlatRateEnvelope ~ 12.50 x 9.50 x 4.00 in </option>
                      <option value="USPS_FlatRateGiftCardEnvelope">USPS_FlatRateGiftCardEnvelope ~ 10.00 x 7.00 x 4.00 in </option>
                      <option value="USPS_FlatRateLegalEnvelope">USPS_FlatRateLegalEnvelope ~ 15.00 x 9.50 x 4.00 in </option>
                      <option value="USPS_FlatRatePaddedEnvelope">USPS_FlatRatePaddedEnvelope ~ 12.50 x 9.50 x 4.00 in </option>
                      <option value="USPS_FlatRateWindowEnvelope">USPS_FlatRateWindowEnvelope ~ 10.00 x 5.00 x 4.00 in </option>
                      <option value="USPS_LargeFlatRateBoardGameBox">USPS_LargeFlatRateBoardGameBox ~ 24.06 x 11.88 x 3.13 in </option>
                      <option value="USPS_LargeFlatRateBox">USPS_LargeFlatRateBox ~ 12.25 x 12.25 x 6.00 in </option>
                      <option value="USPS_Letter">USPS_Letter ~ 11.50 x 6.13 x 0.25 in </option>
                      <option value="USPS_MediumFlatRateBox1">USPS_MediumFlatRateBox1 ~ 11.25 x 8.75 x 6.00 in </option>
                      <option value="USPS_MediumFlatRateBox2">USPS_MediumFlatRateBox2 ~ 14.00 x 12.00 x 3.50 in </option>
                      <option value="USPS_RegionalRateBoxA1">USPS_RegionalRateBoxA1 ~ 10.13 x 7.13 x 5.00 in </option>
                      <option value="USPS_RegionalRateBoxA2">USPS_RegionalRateBoxA2 ~ 13.06 x 11.06 x 2.50 in </option>
                      <option value="USPS_RegionalRateBoxB1">USPS_RegionalRateBoxB1 ~ 16.25 x 14.50 x 3.00 in </option>
                      <option value="USPS_RegionalRateBoxB2">USPS_RegionalRateBoxB2 ~ 12.25 x 10.50 x 5.50 in </option>
                      <option value="USPS_RegionalRateBoxC">USPS_RegionalRateBoxC ~ 15.00 x 12.00 x 12.00 in </option>
                      <option value="USPS_SmallFlatRateBox">USPS_SmallFlatRateBox ~ 8.69 x 5.44 x 1.75 in </option>
                      <option value="USPS_SmallFlatRateEnvelope">USPS_SmallFlatRateEnvelope ~ 10.00 x 6.00 x 4.00 in </option>
                  </optgroup>
              </select>
            </div>

        </div>
    </div>
</div>
</div>';
$html .= '
<div class="modal-footer">
<button aria-hidden="true" data-dismiss="modal" class=" btn btn-success" type="button">No</button>
<button class="btn btn-primary createAmazonShippingLabel" type="submit">Generate Shipping Label!</button>
</div>
</div>
</form>';

echo $html;
 ?>
