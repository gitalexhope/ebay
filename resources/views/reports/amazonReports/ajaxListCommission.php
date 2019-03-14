<?php // echo '<pre>'; print_r($ebayList); ?>
<?php if(isset($_GET['ebay'])){ ?>
  <div id="ebay" class="tab-pane fade active in">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th width="200px">Order Number</th>
          <th  width="50px">Qty</th>
          <th width="120px">Total Paid</th>
          <th>Return Charges</th>
          <th>Final Value Fee</th>
          <th>PayPal Fee</th>
          <th>Total Prfit</th>
          <th>Sale Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($ebayList))
        {
          $retunCharges 			= 0;
          $totalPaid    			= 0;
          $totalFinalValue    = 0;
          $totalProfit    		= 0;
          $paypalAmount				= 0;
          foreach($ebayList as $detail)
          {
              $getReturnCharges = Helper::returnCharge($detail->orderRef,1);
              $retunrChargeValue = ($getReturnCharges[0]->returnCharge) ? $getReturnCharges[0]->returnCharge = $getReturnCharges[0]->returnCharge : 0.00 ;


            ?>
            <tr class="tr<?php echo $detail->orderRef;?>">
              <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
              <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->totalItemPurchased;?></td>
              <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->amountPaid,2);?></td>
              <td><?php echo number_format($retunrChargeValue,2); ?></td>
              <td><?php echo $detail->FinalValueFee;?></td>
              <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->FeeOrCreditAmount,2);?></td>
              <td><?php $paidAmount 	= $detail->amountPaid;
                        $orderCharges = $detail->FinalValueFee + $retunrChargeValue + $detail->FeeOrCreditAmount;
                        $profitAmount = $paidAmount - $orderCharges;
                        echo number_format($profitAmount,2);
               ?></td>
              <td id="createdDate<?php echo $detail->orderRef; ?>"><?php  $date=date_create($detail->lastModifiedDate);echo date_format($date,"d/m/Y");?></td>
              <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->checkoutStatus;?></td>
              <td class="text-left">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                      <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                        <li><a href="javascript:void(0)" class="viewOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
                      </ul>
                    </div>

                  </td>
                </tr>
                <?php
                // Total Values
                $retunCharges 			+= $retunrChargeValue;
                $totalPaid				  += $detail->amountPaid;
                $totalFinalValue    += $detail->FinalValueFee;
                $totalProfit    		+= $profitAmount;
                $paypalAmount				+= $detail->FeeOrCreditAmount;
              }
              echo "<tr>
              <td colspan='2'><strong>Total</strong></td>
              <td><i class='fa fa-usd'></i> ".number_format($totalPaid,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($retunCharges,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($totalFinalValue,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($paypalAmount,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($totalProfit,2)."</td>
              <td colspan='4'></td>
              </tr>";
              ?>
              <tr>
                <td colspan='2'><strong>Order Summary Total<strong></td>
                <?php
                //echo "<pre>";print_r($ebayProfitSummary);echo "</pre>";
                $ebayAmountPaid 	 = $ebayProfitSummary[0]->ebayAmountPaid;
                $ebayFinalValueFee = $ebayProfitSummary[0]->ebayFinalValueFee;
                $ebayReturnCharge  = $ebayProfitSummary[0]->ebayReturnCharge;
                $ebayPaypalAmount  = $ebayProfitSummary[0]->ebayPaypalAmount;
                $ebayTotalChargeValue = $ebayFinalValueFee + $ebayReturnCharge +$ebayPaypalAmount;
                $ebayProfitValue   = $ebayAmountPaid - $ebayTotalChargeValue;
                 ?>
                <td> <i class="fa fa-usd"></i>  <?php echo  number_format($ebayAmountPaid,2); ?></td>
                <td> <i class="fa fa-usd"></i> <?php echo number_format($ebayReturnCharge,2); ?></td>
                <td> <i class="fa fa-usd"></i>  <?php echo number_format($ebayFinalValueFee,2);?></td>
                <td> <i class="fa fa-usd"></i>  <?php echo number_format($ebayPaypalAmount,2);?></td>
                <td> <i class="fa fa-usd"></i>  <?php echo number_format($ebayProfitValue,2);?></td>
                <td></td>
              </tr>
              <?php
            }
            else
            {
              echo '<tr><td colspan="10">No record found.</td></tr>';
            }

            ?>
          </tbody>
        </table>
        <div class="inventoryList">
          <?php echo $ebayList->links();?>
        </div>
  </div>
  <div id="amazon" class="tab-pane fade">
  <table class="table table-bordered table-responsive">
    <thead class="thead-inverse">
    <tr>
      <th width="20" >Order Number</th>
      <th>Status</th>
      <th>Total Shipped</th>
      <th>Total Price</th>
      <th>Return Charges</th>
      <th>item Charge</th>
      <th>Profit</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
      <?php if(count($amazonList))
      {
          $totalPrice 			= 0;
          $itemCharge 			= 0;
          $profit     			= 0;
          $singleItemCharge = 0;
          $singleItemPrice  = 0;
          $retunValuePrice  = 0;
          foreach($amazonList as $detail)
          {
            $getAmazonReturnCharges = Helper::returnCharge($detail->AmazonOrderId,2);
            $AmazonRetunrChargeValue = ($getAmazonReturnCharges[0]->returnCharge !='') ? $getAmazonReturnCharges[0]->returnCharge = $getAmazonReturnCharges[0]->returnCharge : 0.00 ;

            $singleItemCharge += abs($detail->CommissionFeeAmt);
            $singleItemCharge += abs($detail->FixedClosingFee);
            $singleItemCharge += abs($detail->GiftwrapCommissionAmt);
            $singleItemCharge += abs($detail->SalesTaxCollectionFeeAmt);
            $singleItemCharge += abs($detail->ShippingHBAmt);
            $singleItemCharge += abs($detail->VariableClosingFeeAmt);

            $singleItemPrice  += abs($detail->ItemPrice);
            $singleItemPrice  += abs($detail->ShippingCharge);
            $singleItemPrice  += abs($detail->GiftWrapPrice);
            $singleItemPrice  += abs($detail->ItemTaxAmount);
            $singleItemPrice  += abs($detail->ShippingTaxAmount);
            $singleItemPrice  += abs($detail->GiftWrapTaxAmount);
            // Return orders charges
            $singleItemCharge += $AmazonRetunrChargeValue; // Plus Return Charges if apply to ItemCharge
            $retunValuePrice 	+= $AmazonRetunrChargeValue;

            $price 			 = $singleItemPrice - $singleItemCharge ;
            $totalPrice += $singleItemPrice;
            $itemCharge += $singleItemCharge;
            $profit     += $price;
      ?>
    <tr>
      <td><span id="brandNameList<?php echo $detail->AmazonOrderId; ?>"><?php echo $detail->AmazonOrderId;?></td>
      <td id="stockNumber<?php echo $detail->AmazonOrderId; ?>"><?php echo "Shipped";?></td>
      <td id="stockNumber<?php echo $detail->AmazonOrderId; ?>"><?php echo $detail->QuantityShipped;?></td>
      <td id="imeNum<?php echo $detail->AmazonOrderId; ?>"><?php echo number_format($singleItemPrice,2);?></td>
      <td  id="returnCharge<?php echo $detail->AmazonOrderId; ?>"><?php echo number_format($AmazonRetunrChargeValue,2); ?></td>
      <td id="imeNum<?php echo $detail->AmazonOrderId; ?>"><?php echo number_format($singleItemCharge,2);?></td>
      <td id="createdDate<?php echo $detail->AmazonOrderId; ?>"><?php  echo number_format($price,2);?></td>
      <td class="text-center">
          <div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
          <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
             <li><a href="javascript:void(0)" class="amazoneOrderDetails" rel="<?php echo $detail->AmazonOrderId; ?>">View Order Detail</a></li>
          </ul>
          </div>
      </td>
    </tr>
    <?php
        }
      echo "<tr>
              <td colspan='3'><strong>Total</strong></td>
              <td> <i class='fa fa-usd'></i>  ".number_format($totalPrice,2)."</td>
              <td> <i class='fa fa-usd'></i>  ".number_format($retunValuePrice,2)."</td>
              <td> <i class='fa fa-usd'></i>  ".number_format($itemCharge,2)."</td>
              <td> <i class='fa fa-usd'></i>  ".number_format($profit,2)."</td>

            </tr>";
     }
      else
      {
        echo '<tr><td colspan="10">No record found.</td></tr>';
      }
      ?>
      <tr>
        <td colspan='3'><strong>Order Summary</strong></td>
        <?php
        $amazonFinalValue 			= 	($commsionSummary[0]->amazonFinalValue);
        $VariableClosingFeeAmt  = 	abs($commsionSummary[0]->VariableClosingFeeAmt);
        $amazonReturnCharge  = 	($commsionSummary[0]->amazonReturnCharge);
        $profit   							= 	$amazonFinalValue - $VariableClosingFeeAmt;
         ?>
        <td> <i class="fa fa-usd"></i>  <?php echo  number_format($amazonFinalValue,2); ?></td>
        <td> <i class="fa fa-usd"></i>  <?php echo  number_format($amazonReturnCharge,2); ?></td>
        <td> <i class="fa fa-usd"></i> <?php echo number_format($VariableClosingFeeAmt,2); ?></td>
        <td> <i class="fa fa-usd"></i>  <?php echo number_format($profit,2);?></td>
        <td></td>
      </tr>
    </tbody>
  </table>
   <div class="inventoryList">
     <?php echo $amazonList->links();?>
   </div>
 </div>

</div>
<?php } elseif(isset($_GET['amazon'])) { ?>
  <div id="ebay" class="tab-pane fade ">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th width="200px">Order Number</th>
          <th  width="50px">Qty</th>
          <th width="120px">Total Paid</th>
          <th>Return Charges</th>
          <th>Final Value Fee</th>
          <th>PayPal Fee</th>
          <th>Total Prfit</th>
          <th>Sale Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(count($ebayList))
        {
          $retunCharges 			= 0;
          $totalPaid    			= 0;
          $totalFinalValue    = 0;
          $totalProfit    		= 0;
          $paypalAmount				= 0;
          foreach($ebayList as $detail)
          {
              $getReturnCharges = Helper::returnCharge($detail->orderRef,1);
              $retunrChargeValue = ($getReturnCharges[0]->returnCharge) ? $getReturnCharges[0]->returnCharge = $getReturnCharges[0]->returnCharge : 0.00 ;


            ?>
            <tr class="tr<?php echo $detail->orderRef;?>">
              <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
              <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->totalItemPurchased;?></td>
              <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->amountPaid,2);?></td>
              <td><?php echo number_format($retunrChargeValue,2); ?></td>
              <td><?php echo $detail->FinalValueFee;?></td>
              <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->FeeOrCreditAmount,2);?></td>
              <td><?php $paidAmount 	= $detail->amountPaid;
                        $orderCharges = $detail->FinalValueFee + $retunrChargeValue + $detail->FeeOrCreditAmount;
                        $profitAmount = $paidAmount - $orderCharges;
                        echo number_format($profitAmount,2);
               ?></td>
              <td id="createdDate<?php echo $detail->orderRef; ?>"><?php  $date=date_create($detail->lastModifiedDate);echo date_format($date,"d/m/Y");?></td>
              <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->checkoutStatus;?></td>
              <td class="text-left">
                <div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                      <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                        <li><a href="javascript:void(0)" class="viewOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
                      </ul>
                    </div>

                  </td>
                </tr>
                <?php
                // Total Values
                $retunCharges 			+= $retunrChargeValue;
                $totalPaid				  += $detail->amountPaid;
                $totalFinalValue    += $detail->FinalValueFee;
                $totalProfit    		+= $profitAmount;
                $paypalAmount				+= $detail->FeeOrCreditAmount;
              }
              echo "<tr>
              <td colspan='2'><strong>Total</strong></td>
              <td><i class='fa fa-usd'></i> ".number_format($totalPaid,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($retunCharges,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($totalFinalValue,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($paypalAmount,2)."</td>
              <td><i class='fa fa-usd'></i> ".number_format($totalProfit,2)."</td>
              <td colspan='4'></td>
              </tr>";
              ?>
              <tr>
                <td colspan='2'><strong>Order Summary Total<strong></td>
                <?php
                //echo "<pre>";print_r($ebayProfitSummary);echo "</pre>";
                $ebayAmountPaid 	 = $ebayProfitSummary[0]->ebayAmountPaid;
                $ebayFinalValueFee = $ebayProfitSummary[0]->ebayFinalValueFee;
                $ebayReturnCharge  = $ebayProfitSummary[0]->ebayReturnCharge;
                $ebayPaypalAmount  = $ebayProfitSummary[0]->ebayPaypalAmount;
                $ebayTotalChargeValue = $ebayFinalValueFee + $ebayReturnCharge +$ebayPaypalAmount;
                $ebayProfitValue   = $ebayAmountPaid - $ebayTotalChargeValue;
                 ?>
                <td> <i class="fa fa-usd"></i>  <?php echo  number_format($ebayAmountPaid,2); ?></td>
                <td> <i class="fa fa-usd"></i> <?php echo number_format($ebayReturnCharge,2); ?></td>
                <td> <i class="fa fa-usd"></i>  <?php echo number_format($ebayFinalValueFee,2);?></td>
                <td> <i class="fa fa-usd"></i>  <?php echo number_format($ebayPaypalAmount,2);?></td>
                <td> <i class="fa fa-usd"></i>  <?php echo number_format($ebayProfitValue,2);?></td>
                <td></td>
              </tr>
              <?php
            }
            else
            {
              echo '<tr><td colspan="10">No record found.</td></tr>';
            }

            ?>
          </tbody>
        </table>
        <div class="inventoryList">
          <?php echo $ebayList->links();?>
        </div>
  </div>
  <div id="amazon" class="tab-pane fade active in">
  <table class="table table-bordered table-responsive">
    <thead class="thead-inverse">
    <tr>
      <th width="20" >Order Number</th>
      <th>Status</th>
      <th>Total Shipped</th>
      <th>Total Price</th>
      <th>Return Charges</th>
      <th>item Charge</th>
      <th>Profit</th>
      <th>Action</th>
    </tr>
    </thead>
    <tbody>
      <?php if(count($amazonList))
      {
          $totalPrice 			= 0;
          $itemCharge 			= 0;
          $profit     			= 0;
          $retunValuePrice  = 0;
          foreach($amazonList as $detail)
          {
            $singleItemCharge = 0;
            $singleItemPrice  = 0;
            $getAmazonReturnCharges = Helper::returnCharge($detail->AmazonOrderId,2);
            $AmazonRetunrChargeValue = ($getAmazonReturnCharges[0]->returnCharge !='') ? $getAmazonReturnCharges[0]->returnCharge = $getAmazonReturnCharges[0]->returnCharge : 0.00 ;

            $singleItemCharge += abs($detail->CommissionFeeAmt);
            $singleItemCharge += abs($detail->FixedClosingFee);
            $singleItemCharge += abs($detail->GiftwrapCommissionAmt);
            $singleItemCharge += abs($detail->SalesTaxCollectionFeeAmt);
            $singleItemCharge += abs($detail->ShippingHBAmt);
            $singleItemCharge += abs($detail->VariableClosingFeeAmt);

            $singleItemPrice  += abs($detail->ItemPrice);
            $singleItemPrice  += abs($detail->ShippingCharge);
            $singleItemPrice  += abs($detail->GiftWrapPrice);
            $singleItemPrice  += abs($detail->ItemTaxAmount);
            $singleItemPrice  += abs($detail->ShippingTaxAmount);
            $singleItemPrice  += abs($detail->GiftWrapTaxAmount);
            // Return orders charges
            // $singleItemCharge += $AmazonRetunrChargeValue; // Plus Return Charges if apply to ItemCharge
            $retunValuePrice 	+= $AmazonRetunrChargeValue;

            $price 			 = $singleItemPrice - $singleItemCharge ;
            $price       = $price - $AmazonRetunrChargeValue;
            $totalPrice += $singleItemPrice;
            $itemCharge += $singleItemCharge;
            $profit     += $price;
      ?>
    <tr>
      <td><span id="brandNameList<?php echo $detail->AmazonOrderId; ?>"><?php echo $detail->AmazonOrderId;?></td>
      <td id="stockNumber<?php echo $detail->AmazonOrderId; ?>"><?php echo "Shipped";?></td>
      <td id="stockNumber<?php echo $detail->AmazonOrderId; ?>"><?php echo $detail->QuantityShipped;?></td>
      <td id="imeNum<?php echo $detail->AmazonOrderId; ?>"><?php echo number_format($singleItemPrice,2);?></td>
      <td  id="returnCharge<?php echo $detail->AmazonOrderId; ?>"><?php echo number_format($AmazonRetunrChargeValue,2); ?></td>
      <td id="imeNum<?php echo $detail->AmazonOrderId; ?>"><?php echo number_format($singleItemCharge,2);?></td>
      <td id="createdDate<?php echo $detail->AmazonOrderId; ?>"><?php  echo number_format($price,2);?></td>
      <td class="text-center">
          <div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
          <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
             <li><a href="javascript:void(0)" class="amazoneOrderDetails" rel="<?php echo $detail->AmazonOrderId; ?>">View Order Detail</a></li>
          </ul>
          </div>
      </td>
    </tr>
    <?php
        }
      echo "<tr>
              <td colspan='3'><strong>Total</strong></td>
              <td> <i class='fa fa-usd'></i>  ".number_format($totalPrice,2)."</td>
              <td> <i class='fa fa-usd'></i>  ".number_format($retunValuePrice,2)."</td>
              <td> <i class='fa fa-usd'></i>  ".number_format($itemCharge,2)."</td>
              <td> <i class='fa fa-usd'></i>  ".number_format($profit,2)."</td>

            </tr>";
     }
      else
      {
        echo '<tr><td colspan="10">No record found.</td></tr>';
      }
      ?>
      <tr>
        <td colspan='3'><strong>Order Summary</strong></td>
        <?php
        $amazonFinalValue 			= 	($commsionSummary[0]->amazonFinalValue);
        $VariableClosingFeeAmt  = 	abs($commsionSummary[0]->VariableClosingFeeAmt);
        $amazonReturnCharge  		= 	($commsionSummary[0]->amazonReturnCharge);
        $totalProfit   					= 	$amazonFinalValue - $VariableClosingFeeAmt;
        $totalProfit            =   $totalProfit - $amazonReturnCharge;
         ?>
        <td> <i class="fa fa-usd"></i>  <?php echo  number_format($amazonFinalValue,2); ?></td>
        <td> <i class="fa fa-usd"></i>  <?php echo  number_format($amazonReturnCharge,2); ?></td>
        <td> <i class="fa fa-usd"></i> <?php echo number_format($VariableClosingFeeAmt,2); ?></td>
        <td> <i class="fa fa-usd"></i>  <?php echo number_format($totalProfit,2);?></td>
        <td></td>
      </tr>
    </tbody>
  </table>
   <div class="inventoryList">
     <?php echo $amazonList->links();?>
   </div>
 </div>
<?php } ?>
