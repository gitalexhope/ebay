<div class="col-lg-12">
  <div class="breadcrumbs">
    <p class="pull-left">Order details</p>
    <p class="pull-right"><i class="fa fa-home"></i> / Order details</p>
  </div>
</div>
<div class="col-md-12 btn-back">
  <div class="col-md-6 no-padding">
    <?php
      $url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : " ";
      $url = explode('/',$url);
      if (end($url) != "return"){
       ?>


         <a href="javascript:void(0);" data-ref="<?php echo $orderDetail[0]->orderRef;?>" data-to="ebay" class='btn btn-primary generate_Inv pull-left'>Generate Invoice </a>
         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
         <a href="javascript:void(0);" data-ref="<?php echo $orderDetail[0]->orderRef;?>" data-to="ebay" class='btn btn-primary generate_ShippingLabel pull-left'>Generate Shipping Label </a>


<?php } ?>

  </div>
  <div class="col-md-6">
    <?php echo Form::button($value = 'Back', $attributes = array('class' => 'btn btn-primary backArrow pull-right')); ?>
  </div>
</div>
<div class="content_sec clearfix">

<div class="col-md-6">
  <div class="row">
      <div class="col-md-12">
  <div class="order_table Walmart_table">
    <div class="order_table_head">
      <span><b>Order Detail</b></span>
    </div>
    <div class="row">
      <div class="col-md-12 Walmart_box">
        <span><b> Order No</b>: <?php echo $orderDetail[0]->orderRef;?></span>
        <span><b>Order Placed </b>: <?php echo date("d-m-Y",strtotime($orderDetail[0]->lastModifiedDate)) ?></span>
        <span><b>Tracking Number</b>: <?php echo $orderDetail[0]->trackingNumber;?></span>
        <span><b>Total Quantity</b>: <?php echo $orderDetail[0]->totalItemPurchased;?></span>
        <span><b>Price</b>: $ <?php echo number_format($orderDetail[0]->totalAmt,2);?></span>
      </div>

    </div>

  </div>
  </div>
  </div>

</div>
<div class="col-md-6">
  <div class="row">
  <div class="col-md-12">
  <div class="order_table Walmart_table">
    <div class="order_table_head">
      <span><b>Customer Detail</b></span>
    </div>

    <div class="row">
      <div class="col-md-12 Walmart_box">
        <span><b>Name</b>: <?php echo $orderDetail[0]->Name;?></span>
        <span><b>Phone Number </b>: <?php echo $orderDetail[0]->phone;?></span>
        <span><b>Email </b>: <?php $retVal = (trim($orderDetail[0]->buyerEmail)!='' && $orderDetail[0]->buyerEmail != 'Invalid Request') ? $orderDetail[0]->buyerEmail : "Not available" ;echo $retVal;?></span>
        <span><b>Pin Code </b>: <?php echo $orderDetail[0]->postalCode;?></span>
        <span><b>Shipping Address: </b><?php echo $orderDetail[0]->streetFirst;?> <?php echo $orderDetail[0]->streetFirst;?>,<?php echo $orderDetail[0]->state;?>,<?php echo $orderDetail[0]->cityName;?>,<?php echo $orderDetail[0]->countryName;?></span>
      </div>

    </div>

  </div>
  </div>
  </div>
</div>
  <div class="col-md-12">
  <div class="order_table">
    <div class="order_table_head">
      <span><b>Order items </b></span>


    </div>
    <div class="row">
      <?php
      $i = 1;
      foreach($orderItem as $detail){ ?>
      <div class="col-md-12 ship_box remove_border">
      <div class="">
        <h4><?php echo $i ?>. <?php echo $detail->itemTitle;?></h4>

        <div class="ship_descrip">
          <strong><?php echo $detail->itemTitle;?></strong>
          <span>Price: $<?php echo number_format($detail->price,2);?></span>
        </div>
      </div>
      </div>
      <?php $i++;
      } ?>


    </div>

  </div>
  </div>
  <div class="col-md-12"  style="margin-top:20px">
    <table id="table" class="table" style="background:#fafafa">
      <div class="order_table_head">
        <span><b>Order Summary </b></span>
      </div>
          <tr>
            <td colspan="3">Price</td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($orderDetail[0]->totalAmt,2);?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Total Price</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($orderDetail[0]->totalAmt,2);?></td>
          </tr>
          <tr>
            <td colspan="3">Final Value Fee</td>
            <td colspan="8"></td>
            <td align="right">
              <?php
                $FinalValueFee = 0;
                foreach ($orderTransaction as $key => $value) {
                  $FinalValueFee += $value->FinalValueFee;
                }
                echo '<i class="fa fa-usd"></i> '.number_format(-$FinalValueFee,2);
                $totalAmount = $orderDetail[0]->totalAmt - $FinalValueFee;
              ?>
           </td>
          </tr>
          <tr>
            <td colspan="3">PayPal Fee</td>
            <td colspan="8"></td>
            <td align="right">
              <?php
                $FeeOrCreditAmount = 0;
                foreach ($orderTransaction as $key => $value) {
                  $FeeOrCreditAmount += $value->FeeOrCreditAmount;
                }
                echo '<i class="fa fa-usd"></i> '.number_format(-$FeeOrCreditAmount,2);
                $totalAmount = $totalAmount - $FeeOrCreditAmount;
              ?>
           </td>
          </tr>
          <tr>
            <?php if(!empty($returnCharges)){ ?>
            <td colspan="3"><b>Return Charges:-</b> </td>
            <td colspan="9"></td>
          </tr>
          <?php
          // ProfitPrice Var for Total Profit

           if(!empty($returnCharges))
                {
                  foreach ($returnCharges as $key => $value)
                  {
                    $totalAmount = $totalAmount-$value->returnCharge;
                    ?>
                    <tr>
                        <td colspan="3"><?php echo ucfirst($value->returnTitle) ?> </td>
                        <td colspan="8"></td>
                        <td align="right"><i class="fa fa-usd"></i> <?php echo number_format(-abs($value->returnCharge),2); ?></td>
                    </tr>
            <?php }
                }
            }
           ?>
          <tr>
            <td colspan="3"><b>Profit</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i>
              <?php echo $totalAmount ?>
           </td>
          </tr>
  </table>

  </div>
</div>
