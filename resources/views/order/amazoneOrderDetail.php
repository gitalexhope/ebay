<div class="col-lg-12">
  <div class="breadcrumbs">
    <p class="pull-left">Amazone Order details</p>
    <p class="pull-right"><i class="fa fa-home"></i> / Order details</p>
  </div>
</div>
<div class="content_sec clearfix" style="min-height:600px">
  <div class="col-md-12 btn-back">
    <div class="col-md-6 no-padding">
      <?php
      $url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : " ";
      $url = explode('/',$url);
      if (end($url) != "return")
      {
       ?>
        <a href="javascript:void(0);" data-ref="<?php echo $orderDetail[0]->orderRef;?>" data-to="amazon" class='btn btn-primary generate_Inv pull-left'>Generate Invoice </a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if (trim($orderDetail[0]->orderStatus) =="Shipped" && trim($orderDetail[0]->orderAction) !="Return" ): ?>
          <a href="javascript:void(0);" data-ref="<?php echo $orderDetail[0]->orderRef;?>" data-to="amazon" class='btn btn-primary generate_amazonShippingLabel pull-left'>Generate Shipping Label </a>
        <?php endif; ?>
<?php } ?>
    </div>
    <div class="col-md-6">
      <?php echo Form::button($value = 'Back', $attributes = array('class' => 'btn btn-primary backArrow pull-right')); ?>
    </div>
  </div>
  <div style="clear:both"></div>

<div class="col-md-8">

  <div class="row">
  <div class="col-md-12">

  <div class="order_table">
    <div class="order_table_head">
      <span><b>Order items </b></span>
    </div>
    <div class="row">
      <?php
      // echo "<pre>";
      // print_r($orderItem);
      // echo "</pre>";
      // echo "<pre>";
      // print_r($orderDetail);
      // echo "</pre>";die;
      $i = 1;
      foreach($orderItem as $detail){ ?>
      <div class="col-md-12 ship_box remove_border">
      <div class="">
        <h4><?php echo $i ?>. <?php echo $detail->itemTitle;?></h4>

        <div class="ship_descrip">
          <strong><?php echo $detail->itemTitle;?></strong>
          <span>Price: $<?php echo number_format($detail->ItemPrice,2);?></span>
        </div>
      </div>
      </div>
      <?php } ?>


    </div>

  </div>
  </div>
  <div class="col-md-12"  style="margin-top:20px">
    <table id="table" class="table" style="background:#fafafa">
      <?php
      $url = $_SERVER['HTTP_REFERER']; $url = explode('/',$url);
      //if (end($url) == "amazon-commission-report")
      if(!empty($commissionData))
      { ?>
      <div class="order_table_head">
        <span><b>Order Summary </b></span>
      </div>
      <?php
      $singleItemCharge  = 0;
      $singleItemPrice   = 0;
      $ItemPrice         = 0;
      $profitPrice       = 0;
      $CommissionFeeAmt = $FixedClosingFee =$GiftwrapCommissionAmt = $SalesTaxCollectionFeeAmt= $ShippingHBAmt = $VariableClosingFeeAmt = 0;
      $ShippingCharge = $GiftWrapPrice =$ItemTaxAmount = $ShippingTaxAmount= $GiftWrapTaxAmount   = 0;
        foreach ($commissionData as $key => $value)
        {
        $ItemPrice        += $value->ItemPrice;

        $singleItemCharge += $CommissionFeeAmt         = $value->CommissionFeeAmt;
        $singleItemCharge += $FixedClosingFee          = $value->FixedClosingFee;
        $singleItemCharge += $GiftwrapCommissionAmt    = $value->GiftwrapCommissionAmt;
        $singleItemCharge += $SalesTaxCollectionFeeAmt = $value->SalesTaxCollectionFeeAmt;
        $singleItemCharge += $ShippingHBAmt            = $value->ShippingHBAmt;
        $singleItemCharge += $VariableClosingFeeAmt    = $value->VariableClosingFeeAmt;

        $singleItemPrice  += $ShippingCharge           = abs($value->ShippingCharge);
        $singleItemPrice  += $GiftWrapPrice            = abs($value->GiftWrapPrice);
        $singleItemPrice  += $ItemTaxAmount            = abs($value->ItemTaxAmount);
        $singleItemPrice  += $ShippingTaxAmount        = abs($value->ShippingTaxAmount);
        $singleItemPrice  += $GiftWrapTaxAmount        = abs($value->GiftWrapTaxAmount);
      }
        ?>
          <tr>
            <?php if($ItemPrice != 0){ ?>
            <td colspan="3">Price</td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($ItemPrice,2); ?> </td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($ShippingCharge != 0){ ?>
            <td colspan="3">Shipping Charge</td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($ShippingCharge,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($GiftWrapPrice != 0){ ?>
            <td colspan="3">Gift Wrap</td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($GiftWrapPrice,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($ItemTaxAmount != 0){ ?>
            <td colspan="3">Tax</td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($ItemTaxAmount,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($ShippingTaxAmount != 0){ ?>
            <td colspan="3">Shipping Tax</td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($ShippingTaxAmount,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($GiftWrapTaxAmount != 0){ ?>
            <td colspan="3">Gift Wrap Tax </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($GiftWrapTaxAmount,2); ?></td>
          </tr>
        <?php } ?>
        <!--  -->
        <tr>
          <td colspan="3"><b>Total Amount</b> </td>
          <td colspan="8"></td>
          <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($ItemPrice + $singleItemPrice,2); ?></td>
        </tr>
        <!--  -->
          <tr>
            <?php if($CommissionFeeAmt != 0){ ?>
            <td colspan="3">Commission Fee </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($CommissionFeeAmt,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($FixedClosingFee != 0){ ?>
            <td colspan="3">Fixed Closing Fee </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($FixedClosingFee,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($GiftwrapCommissionAmt != 0){ ?>
            <td colspan="3">Gift wrap Commission </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($GiftwrapCommissionAmt,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($SalesTaxCollectionFeeAmt != 0){ ?>
            <td colspan="3">Sales Tax Collection Fee </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($SalesTaxCollectionFeeAmt,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($ShippingHBAmt != 0){ ?>
            <td colspan="3">Shipping HB </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($ShippingHBAmt,2); ?></td>
          </tr>
        <?php } ?>
          <tr>
            <?php if($VariableClosingFeeAmt != 0){ ?>
            <td colspan="3">Variable Closing Fee </td>
            <td colspan="8"></td>
            <td align="right"><?php echo number_format($VariableClosingFeeAmt,2); ?></td>
            </tr>
          <?php } ?>
          <tr>
            <?php
             $profitPrice = $ItemPrice + $singleItemPrice - abs($singleItemCharge);
             if(!empty($returnCharges)){ ?>
            <td colspan="3"><b>Return Charges:-</b> </td>
            <td colspan="9"></td>
          </tr>
          <?php
          // ProfitPrice Var for Total Profit

           if(!empty($returnCharges))
                {
                  foreach ($returnCharges as $key => $value)
                  {
                    $profitPrice = $profitPrice-$value->returnCharge;
                    ?>
                    <tr>
                        <td colspan="3"><?php echo ucfirst($value->returnTitle) ?> </td>
                        <td colspan="8"></td>
                        <td align="right"><?php echo number_format(-abs($value->returnCharge),2); ?></td>
                    </tr>
            <?php }
                }
            }
           ?>
          <tr>
            <td colspan="3"><b>Profit :-</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($profitPrice,2); ?></td>
          </tr>
      <?php
     } ?>
  </table>

  </div>
  </div>

</div>
<div class="col-md-4">
  <div class="row">
  <div class="col-md-12">
  <div class="order_table Walmart_table">
    <div class="order_table_head">
      <span><b>Customer Detail</b></span>
    </div>
    <div class="row">
      <div class="col-md-12 Walmart_box">
        <span><b> Name             </b> : <?php $buyerName  = ($orderDetail[0]->buyerName != '0') ? $orderDetail[0]->buyerName : '';echo ucwords($buyerName);?></span>
        <span><b> Phone Number     </b> : <?php $phone      = ($orderDetail[0]->phone != '0') ? $orderDetail[0]->phone : '';echo ($buyerName);?></span>
        <span><b> Email            </b> : <?php $buyerEmail = ($orderDetail[0]->buyerEmail != '0') ? $orderDetail[0]->buyerEmail : '';echo ucwords($buyerEmail);?></span>
        <span><b> Pin Code         </b> : <?php echo $orderDetail[0]->postalCode;?></span>
        <span><b> Shipping Address </b> : <?php echo $orderDetail[0]->addressLine1;?> <?php echo $orderDetail[0]->addressLine3; ?>,<?php echo $orderDetail[0]->stateOrRegion;?>,<?php echo $orderDetail[0]->city;?></span>
      </div>

    </div>

  </div>
  </div>
  <div class="col-md-12">
  <div class="order_table Walmart_table">
    <div class="order_table_head">
      <span><b>Order Detail</b></span>
    </div>
    <div class="row">
      <div class="col-md-12 Walmart_box">
        <span><b> Order No      </b>  : <?php echo $orderDetail[0]->orderRef;?></span>
        <span><b>Order Placed   </b>  : <?php echo date('d M Y',strtotime($orderDetail[0]->earliestShipDate));?></span>
        <span><b>Tracking Number</b>  : <?php echo $orderDetail[0]->trackingNumber;?></span>
        <span><b>Order Status</b>  : <?php echo $orderDetail[0]->orderStatus;?></span>
        <span><b>Total Quantity </b>  : <?php echo count($orderItem);?></span>
        <span><b>Price          </b>  : $<?php echo number_format($orderDetail[0]->totalAmount,2);?></span>
      </div>

    </div>


  </div>
  </div>


  </div>
  </div>
  <!--  --
  <div class="col-md-12"  style="margin-top:20px">
    <table id="table" class="table" style="background:#fafafa">
      <?php $url = $_SERVER['HTTP_REFERER']; $url = explode('/',$url);
      if (end($url) == "amazon-commission-report")
      {
      foreach($orderItem as $detail){ ?>

      <div class="order_table_head" >
        <span><b><?php echo $detail->itemTitle ?></b></span>
      </div>
      <thead>
        <th>Price</th>
        <th>Shipping Charge</th>
        <th>Gift Wrap</th>
        <th>Tax</th>
        <th>Shipping Tax</th>
        <th>Gift Wrap Tax </th>
        <th>Commission Fee </th>
        <th>Fixed Closing Fee </th>
        <th>Gift wrap Commission </th>
        <th>Sales Tax Collection Fee </th>
        <th>Shipping HB </th>
        <th>Variable Closing Fee </th>
      </thead>
      <?php
      $singleItemCharge  = 0;
      $singleItemPrice   = 0;
      $ItemPrice         = 0;
        foreach ($commissionData as $key => $value)
        {
        $ItemPrice        += $value->ItemPrice;

        $singleItemCharge += abs($value->CommissionFeeAmt);
        $singleItemCharge += abs($value->FixedClosingFee);
        $singleItemCharge += abs($value->GiftwrapCommissionAmt);
        $singleItemCharge += abs($value->SalesTaxCollectionFeeAmt);
        $singleItemCharge += abs($value->ShippingHBAmt);
        $singleItemCharge += abs($value->VariableClosingFeeAmt);

        $singleItemPrice  += abs($value->ShippingCharge);
        $singleItemPrice  += abs($value->GiftWrapPrice);
        $singleItemPrice  += abs($value->ItemTaxAmount);
        $singleItemPrice  += abs($value->ShippingTaxAmount);
        $singleItemPrice  += abs($value->GiftWrapTaxAmount);
        ?>
          <tr>
            <td><?php echo number_format($ItemPrice,2); ?> </td>
            <td><?php echo number_format($value->ShippingCharge,2); ?></td>
            <td><?php echo number_format($value->GiftWrapPrice,2); ?></td>
            <td><?php echo number_format($value->ItemTaxAmount,2); ?></td>
            <td><?php echo number_format($value->ShippingTaxAmount,2); ?></td>
            <td><?php echo number_format($value->GiftWrapTaxAmount,2); ?></td>
            <td><?php echo number_format($value->CommissionFeeAmt,2); ?></td>
            <td><?php echo number_format($value->FixedClosingFee,2); ?></td>
            <td><?php echo number_format($value->GiftwrapCommissionAmt,2); ?></td>
            <td><?php echo number_format($value->SalesTaxCollectionFeeAmt,2); ?></td>
            <td><?php echo number_format($value->ShippingHBAmt,2); ?></td>
            <td><?php echo number_format($value->VariableClosingFeeAmt,2); ?></td>
          </tr>
          <tr>
            <td colspan="7"></td>
            <td></td>
            <td><b>Total Amount :-</b></td>
            <td><i class="fa fa-usd"></i> <?php echo number_format($value->ItemPrice + $singleItemPrice,2); ?></td>
            <td><b>Profit :-</b></td>
            <td><i class="fa fa-usd"></i> <?php echo number_format($value->ItemPrice + $singleItemPrice - $singleItemCharge,2); ?></td>
          </tr>
      <?php }
    } ?>
  </table>

  </div>
  <?php  } ?>
  <!--  -->

</div>

</div>
