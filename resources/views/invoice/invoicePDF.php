<?php

			/** Shipping information **/
			$shippingName						=	$orderDetail[0]->Name;
			$shippingstreetFirst		=	$orderDetail[0]->streetFirst;
			$shippingstreetSec			=	$orderDetail[0]->streetSec;
			$shippingcityName				=	$orderDetail[0]->cityName;
			$shippingstate					=	$orderDetail[0]->state;
			$shippingcountryName		=	$orderDetail[0]->countryName;
			$shippingphone					=	$orderDetail[0]->phone;
			$shippingpostalCode			=	$orderDetail[0]->postalCode;
			$TransactionPrice				= 0;
			$totalTaxAmount					= 0;
      $cityStateCountry = $shippingcityName .', '.$shippingstate.' '.$shippingcountryName;
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
     <td style="width:390px;"><b style="font-size: 38px;">Wsdeals</b><br>787 Woodlawn Dr<br>Thousand oaks , CA 91360
     </td>
     <!-- <td><img src="<?php echo URL::asset('/assets/images/Pdfimages/logo.png')?>"></td> -->
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
                  <?php echo $shippingName ?><br> <?php echo $shippingstreetFirst .' '.$shippingstreetSec ?>
                        <br> <?php echo $cityStateCountry; echo ' '.$shippingpostalCode;?> <br> <?php echo $shippingphone ?>
                </td>
                <td style="font-size:12px;width:60px;">Order # <br>
                Date <br>
                User <br>
                Ship Date
              </td>

              <td style="font-size:12px;width:200px;"><?php echo $orderDetail[0]->orderRef; ?> <br>
                <?php echo date('Y-m-d',strtotime($orderDetail[0]->addedOn)) ?> <br>
                <?php echo $shippingName ?> <br>
                <?php echo date('Y-m-d',strtotime($orderDetail[0]->lastModifiedDate)) ?></td>
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
              <th style="width:100px;padding:5px;font-size:12px;text-align: left;"> Item </th>
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
              $TransactionPrice     =     0;
              $totalTaxAmount       =     0;
              foreach ($orderItem as $key => $value){
              $totalItemPurchased    = 	$orderDetail[0]->totalItemPurchased;
              foreach ($orderTransaction as $key => $orderTransactionValue)
              {
                       $TransactionPrice += $orderTransactionValue->transactionPrice;
                       $totalTaxAmount   += $orderTransactionValue->totalTaxAmount;

              };
              ?>
              <tr>
                 <td style="width:4px;"></td>
                <td style="width:100px;padding:5px;font-size:12px;text-align: left;"><?php echo $value->itemId;?> </td>
                <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"><?php echo $value->titleName;?></td>
                <td style="width:60px;font-size:12px;text-align: center;">$ <?php echo $value->price;?></td>
                <td style="width:100px;font-size:12px;text-align: center;"><?php echo $totalItemPurchased ?></td>
                <td style="width:60px;font-size:12px;text-align:right;padding:5px;">$ <?php echo $value->price;?></td>
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

         <tr>
            <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: center;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Sub Total:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($TransactionPrice,2); ?></td>
         <td style="width:4px;"></td>
            </tr>
           <tr>
              <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: left;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Tax:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($totalTaxAmount,2); ?></td>
         <td style="width:4px;"></td>
            </tr>
           <tr>
              <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: left;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Shipping:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;">0.00</td>
         <td style="width:4px;"></td>
            </tr>
           <tr>
              <td style="width:4px;"></td>
              <td style="width:100px;padding:5px;font-size:12px;text-align: left;"> </td>
        <td style="width:280px;font-size:12px;text-align: left;line-height: 20px;"></td>
        <td style="width:60px;font-size:12px;text-align: left;"></td>
        <td style="width:100px;font-size:12px;text-align: right;"><b>Total:</b></td>
        <td style="width:60px;font-size:12px;text-align:right;padding:5px;"><?php echo number_format($orderDetail[0]->totalAmt,2) ?></td>
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
