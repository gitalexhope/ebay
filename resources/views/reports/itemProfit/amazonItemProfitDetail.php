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
        <h4> <?php echo $detail->itemName;?></h4>
        <div class="ship_descrip">
          <strong><?php echo $detail->itemName;?></strong>
          <strong>(Seller SKU:- <span><?php echo $detail->sellerSku;?></span>)</strong>
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
        $orderCount         = (trim($itemProfitDetail[0]->orderCount)        !='' && is_numeric($itemProfitDetail[0]->orderCount))         ? $itemProfitDetail[0]->orderCount         : 0 ;
        $amazonReturnCharge = (trim($itemProfitDetail[0]->amazonReturnCharge)!='' && is_numeric($itemProfitDetail[0]->amazonReturnCharge)) ? $itemProfitDetail[0]->amazonReturnCharge : 0 ;
        $amazonTotalAmount  = (trim($itemProfitDetail[0]->amazonTotalAmount) !='' && is_numeric($itemProfitDetail[0]->amazonTotalAmount))  ? $itemProfitDetail[0]->amazonTotalAmount  : 0 ;
        $amazonFinalValue   = (trim($itemProfitDetail[0]->amazonFinalValue)  !='' && is_numeric($itemProfitDetail[0]->amazonFinalValue))   ? $itemProfitDetail[0]->amazonFinalValue   : 0 ;
        $QuantityShipped    = (trim($itemProfitDetail[0]->QuantityShipped)   !='' && is_numeric($itemProfitDetail[0]->QuantityShipped))    ? $itemProfitDetail[0]->QuantityShipped    : 0 ;

       ?>
          <tr>
            <td colspan="3"><b>No. of Orders</b></td>
            <td colspan="8"></td>
            <td align="right"> <?php echo $orderCount;?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Total Items Sale</b></td>
            <td colspan="8"></td>
            <td align="right"></i> <?php echo $QuantityShipped;?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Total Amount</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($amazonTotalAmount,2);?></td>
          </tr>
          <tr>
            <td colspan="3"><b>Final Value Fee</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($amazonFinalValue,2);?></td>
          </tr>
          <tr>
              <td colspan="3"><b>Return Charges</b> </td>
              <td colspan="8"></td>
              <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($amazonReturnCharge,2);?></td>
          </tr>
          <tr>
            <?php
              $itemCharges  = abs($amazonFinalValue) + $amazonReturnCharge;
              $profitAmount = $amazonTotalAmount - $itemCharges;
             ?>
            <td colspan="3"><b>Total Profit</b></td>
            <td colspan="8"></td>
            <td align="right"><i class="fa fa-usd"></i> <?php echo number_format($profitAmount,2);?></td>
          </tr>
  </table>

  </div>
  </div>
</div>
