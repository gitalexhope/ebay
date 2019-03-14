<!-- <?php echo '<pre>'; print_r($itemProfitDetail); echo "</pre>"; ?> -->
  <div class="breadcrumbs">
    <p class="pull-left">Item Profit Details</p>
    <p class="pull-right"><i class="fa fa-home"></i> / Item Profit Details</p>
  </div>
  <div class="row">
<div class="col-md-12 btn-back">
<?php echo Form::button($value = 'Back', $attributes = array('class' => 'btn btn-primary backArrow pull-right')); ?>
</div>
</div>
<div class="content_sec clearfix">
<div class="row">
  <div class="col-md-12">
  <div class="order_table">
    <div class="order_table_head">
      <span><b>Item Highlights </b></span>
    </div>
    <div class="row">
      <?php
      $i = 1;
      foreach($itemDetail as $detail){ ?>
      <div class="col-md-12 ship_box remove_border">
      <div class="">
        <h4> <?php echo $detail->titleName;?></h4>
        <div class="ship_descrip">
          <strong><?php echo $detail->titleName;?></strong>
          <span>Price: $<?php echo number_format($detail->price,2);?></span>
        </div>
      </div>
      </div>
      <?php $i++;
      } ?>


    </div>

  </div>
  </div>
  </div>
  <div class="row">
  <div class="col-md-12"  style="margin-top:20px">
    <table id="table" class="table" style="background:#fafafa">
      <div class="order_table_head">
        <span><b>Item Summary </b></span>
      </div>
          <?php
            $amountPaid         = 0;
            $totalItemPurchased = 0;
            $payPalFee          = 0;
            $FinalValueFee      = 0;
            $returnCharge       = 0;
            $tr                 = '';

          foreach ($itemProfitDetail as $key => $value)
          {
            $amountPaid         += $value->amountPaid;
            $totalItemPurchased += $value->totalItemPurchased;
            $payPalFee          += $value->FeeOrCreditAmount;
            $FinalValueFee      += $value->FinalValueFee;
            $returnCharge       += $value->returnCharge;
            // if(trim($value->returnTitle) !='' && trim($value->returnCharge))
            // {
            //   if($key == 0)
            //   {
            //     $tr .= '<tr>
            //                 <td colspan="3"><b>Return Charges</b> </td>
            //                 <td colspan="8"></td>
            //                 <td align="right"><i class="fa fa-usd"></i>'.$returnCharge.'</td>
            //             </tr>';
            //   };
            //
            //   // $tr .='<tr><td colspan="3"><b>'.$value->returnTitle.'</b></td>
            //   // <td colspan="8"></td>
            //   // <td align="right"><i class="fa fa-usd"></i>'.$value->returnCharge.'</td>
            //   // </tr>';
            // }
          }
          ?>

          <tr>
            <td colspan="3"><b>No. of Orders</b></td>
            <td colspan="8"></td>
            <td align="right"> <?php echo count($itemProfitDetail);?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Total Items Sale</b></td>
            <td colspan="8"></td>
            <td align="right"></i> <?php echo $totalItemPurchased;?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Total Amount</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($amountPaid,2);?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Final Value Fee</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($FinalValueFee,2);?></td>
          </tr>
          <tr>
            <td colspan="3"><b>PayPal Fee</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($payPalFee,2);?></td>
          </tr>
          <tr>
              <td colspan="3"><b>Return Charges</b> </td>
              <td colspan="8"></td>
              <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($returnCharge,2);?></td>
          </tr>
          <tr>
            <?php
              $itemCharges  = $FinalValueFee + $payPalFee + $returnCharge;
              $profitAmount = $amountPaid - $itemCharges;
             ?>
            <td colspan="3"><b>Total Profit</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($profitAmount,2);?></td>
          </tr>
  </table>

  </div>
  </div>
</div>
