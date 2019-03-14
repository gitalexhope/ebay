<?php

			/** Shipping information **/
			$shippingName						=	   ($orderDetail[0]->buyerName != '0') ? $orderDetail[0]->buyerName : '';
      $buyerEmail             =    ($orderDetail[0]->buyerEmail != '0') ? $orderDetail[0]->buyerEmail : '';
			$shippingstreetSec			=	    $orderDetail[0]->addressLine1 . " ". $orderDetail[0]->addressLine3;
			$shippingcityName				=	    $orderDetail[0]->city;
			$shippingstate					=   	$orderDetail[0]->stateOrRegion;
			$shippingphone					=	    ($orderDetail[0]->phone != '0') ? $orderDetail[0]->phone : '';;
			$shippingpostalCode			=	    $orderDetail[0]->postalCode;
			$TransactionPrice				= 0;
			$totalTaxAmount					= 0;
      $cityStateCountry = $shippingcityName .', '.$shippingstate;


 ?>

<div style="width:800px; margin 0 auto">
<table cellpadding="0" cellspacing="0" style="background-color: #fff;padding:0;width: 100%;">
   <tr>
     <td style="background-color:#808080;text-align:center;color:#fff;font-size:14px;line-height:26px;vertical-align:middle;">Packing Slip</td>
   </tr>
   <tr>
   <td>
   <table style="width:100%;">
     <tr>
     <td style="width:390px;"><b style="font-size: 38px;">Tonics Express</b><br>787 Woodlawn Dr<br>Thousand oaks , CA 91360
     </td>
     <td></td>
   </tr>
   </table>
   </td>
   </tr>
   <tr>
   <td> &nbsp; </td>
   </tr>
      <tr>
           <td>
             <table style="width:100%;">
              <tr>
              <td style="font-size: 12px;line-height: 23px;width: 58px;vertical-align: top;"><b>Ship To:</b></td>
                <td style="font-size: 12px;line-height: 23px;vertical-align:top;width:320px;">
                  <?php echo $shippingName ?><br> <?php echo $shippingstreetSec ?>
                        <br> <?php echo $cityStateCountry; echo ' '.$shippingpostalCode;?> <br> <?php echo $shippingphone ?>
                </td>
                <td style="font-size:12px;width:60px;">Order # <br>
                Date <br>
                User <br>
                Ship Date
              </td>

              <td style="font-size:12px;width:200px;"><?php echo $orderDetail[0]->orderRef; ?> <br>
                <?php echo date('Y-m-d',strtotime($orderDetail[0]->purchaseDate)) ?> <br>
                <?php echo $shippingName ?> <br>
                <?php echo date('Y-m-d',strtotime($orderDetail[0]->earliestShipDate)) ?></td>
            </tr>
           </table>
         </td>
   </tr>
   <tr>
   <td> &nbsp; </td>
   </tr>
    <tr>
           <td>
             <table cellpadding="0" cellspacing="0" style="width:100%;">
              <tr style="background-color:#808080;color:#fff;">
                <th style="width:4px;"></th>
              <th style="width:100px;padding:5px;font-size:12px;text-align: left;"> Seller SKU </th>
        <th style="width:280px;font-size:12px;text-align: left;"> Description </th>
        <th style="width:60px;font-size:12px;text-align: center;"> Price </th>
        <th style="width:100px;font-size:12px;text-align: center;"> Qty </th>
        <th style="width:60px;font-size:12px;text-align:right;padding:5px;"> Ext.Price </th>
        <th style="width:4px;"></th>
            </tr>
           <tr>
             <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;"></td>
        <td style="width:280px;font-size:12px;text-align: left;">
</td>
        <td style="width:60px;font-size:12px;text-align: center;"></td>
        <td style="width:100px;font-size:12px;text-align: center;"></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"></td>
         <td style="width:4px;"></td>
            </tr>

            <?php

              foreach ($orderItem as $key => $value){

              ?>
              <tr>
                 <td style="width:4px;"></td>
                <td style="width:100px;padding:5px;font-size:12px;text-align: left;"><?php echo $value->SellerSKU;?> </td>
                <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"><?php echo $value->itemTitle;?></td>
                <td style="width:60px;font-size:12px;text-align: center;">$ <?php echo $value->ItemPrice;?></td>
                <td style="width:100px;font-size:12px;text-align: center;"><?php echo $value->QuantityOrdered; ?></td>
                <td style="width:60px;font-size:12px;text-align:right;padding:5px;">$ <?php echo $value->ItemPrice;?></td>
                 <td style="width:4px;"></td>
              </tr>
            <?php } ?>


           </table>
       </td>
       </tr>
       <tr>
       <td>
       </td>
       </tr>
       <tr>
           <td>
             <table cellpadding="0" cellspacing="0" style="width:100%;padding:10px;">
               <?php
               $singleItemCharge  = 0;
               $singleItemPrice   = 0;
               $ItemPrice         = 0;
               $profitPrice       = 0;
               $ShippingCharge    =0 ;
               $totalAmount       =0;
               $CommissionFeeAmt = $FixedClosingFee =$GiftwrapCommissionAmt = $SalesTaxCollectionFeeAmt= $ShippingHBAmt = $VariableClosingFeeAmt = 0;
               $ShippingCharge = $GiftWrapPrice =$ItemTaxAmount = $ShippingTaxAmount= $GiftWrapTaxAmount   = 0;
                 foreach ($commissionData as $key => $value)
                 {
                 $ItemPrice        += $value->ItemPrice;

                 $ShippingCharge   += abs($value->ShippingCharge);

                 $singleItemPrice  += $GiftWrapPrice            = abs($value->GiftWrapPrice);
                 $singleItemPrice  += $ItemTaxAmount            = abs($value->ItemTaxAmount);
                 $singleItemPrice  += $ShippingTaxAmount        = abs($value->ShippingTaxAmount);
                 $singleItemPrice  += $GiftWrapTaxAmount        = abs($value->GiftWrapTaxAmount);

                 $totalAmount += $ItemPrice  + $singleItemPrice;
               }
                 ?>
         <tr>
            <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: center;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Sub Total:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($ItemPrice,2) ?></td>
         <td style="width:4px;"></td>
            </tr>
           <tr>
              <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: left;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Tax:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($singleItemPrice,2); ?></td>
         <td style="width:4px;"></td>
            </tr>
           <tr>
              <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: left;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Shipping:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($ShippingCharge,2) ?></td>
         <td style="width:4px;"></td>
            </tr>
           <tr>
              <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: left;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Total:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($totalAmount,2) ?></td>
           <td style="width:4px;"></td>
           </tr>
           </table>
       </td>
       </tr>
        <tr>
           <td>
             <table cellpadding="0" cellspacing="0" style="width:100%;padding:10px;">

         <tr>
              <td style="font-size:14px;text-align:center;">Thank you for your business! Were happy to notify you that we just left you a positive feedback for your purchase. </td>
            </tr>
        <tr><td> &nbsp; </td></tr>
        <tr>
        <td style="font-size:14px;text-align:center;">We would like to respectfully ask you to leave us a positive feedback as well when you receive the item. FiveStar Service Is Our Goal!!! We strive to earn 100% perfect
"FIVE STAR" scores and a Positive feedback from you.</td>
        </tr>
        <tr><td> &nbsp; </td></tr>
          <tr>
        <td style="font-size:14px;text-align:center;">If you feel that you cannot leave us a 5 star rating or if you cannot leave us a positive feedback then please contact us. If you also feel like you cannot leave us a good
star rating because of item not as described or any other reasons, please let us know so that we can make improvements for our next customer.</td>
        </tr>
        <tr><td> &nbsp; </td></tr>
          <tr>
        <td style="font-size:14px;text-align:center;">We want our customers to be happy with their purchase. We also would like to get your comments (if you have any) as to improving our listings, communications,
shipping and or any other comments you may have so that we can better our Listings.</td>
        </tr>
        <tr><td> &nbsp; </td></tr>
          <tr>
        <td style="font-size:14px;text-align:center;">Please call us at 8189631425 or email us at wsdeals2010@gmail.com if you have any questions or concerns.</td>
        </tr>
        <tr><td> &nbsp; </td></tr>
          <tr>
                <td style="text-align:center"></td>
           </tr>
           </table>
       </td>
       </tr>
   </table>
</div>
