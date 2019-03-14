<?php if (isset($_GET['ebay'])): ?>

  <div id="ebay" class="tab-pane fade active in">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th>Item Name</th>
          <th>Ordered Qty</th>
          <th>Item ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($ebayItem) && count($ebayItem))
        {
          $retunCharges 			= 0;
          $totalPaid    			= 0;
          $totalFinalValue    = 0;
          $totalProfit    		= 0;
          $paypalAmount				= 0;
          foreach($ebayItem as $detail)
          {
            $getOrderQTY = Helper::getEbayOrderQTY($detail->ebayItemRef);
            // echo "<pre>";print_r($getOrderQTY);echo "</pre>";
            $getOrderQTY = ($getOrderQTY[0]->orderQty) ? $getOrderQTY[0]->orderQty = $getOrderQTY[0]->orderQty : 0.00 ;


            ?>
            <tr class="tr<?php echo $detail->productRef;?>">
              <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->titleName;?></td>
                <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $getOrderQTY;?></td>
                  <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->ebayItemRef;?></td>
                    <!-- <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo 0;?></td>
                    <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo 0;?></td>
                    <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo 0;?></td> -->
                    <td class="text-left">
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                          <li><a href="javascript:void(0)" class="viewItemDetails" rel="<?php echo $detail->ebayItemRef; ?>">View Detail</a></li>
                        </ul>
                      </div>

                    </td>
                  </tr>
                  <?php
                  // Total Values
                  // $retunCharges 			+= $getOrderQTY;
                  // $totalPaid				  += $detail->amountPaid;
                  // $totalFinalValue    += $detail->FinalValueFee;
                  // $totalProfit    		+= $profitAmount;
                  // $paypalAmount				+= $detail->FeeOrCreditAmount;
                }

              }
              else
              {
                echo '<tr><td colspan="10">No record found.</td></tr>';
              }

              ?>
            </tbody>
          </table>
          <div class="inventoryList">
            <?php if (isset($ebayItem)) {
              echo $ebayItem->links();
            }?>
          </div>
        </div>
  <div id="amazon" class="tab-pane fade">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th>Item Name</th>
          <th>Ordered Qty</th>
          <th>ASIN</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($amazonItem) && count($amazonItem))
        {
          //echo "<pre>";print_r($amazonItem);echo "<pre>";
          $totalPrice 			= 0;
          $itemCharge 			= 0;
          $profit     			= 0;
          $retunValuePrice  = 0;
          foreach($amazonItem as $detail)
          {
            ?>
            <tr class="tr<?php echo $detail->productRef;?>">
              <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->itemName;?></td>
                <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $getOrderQTY;?></td>
                  <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->ASIN;?></td>
                    <td class="text-left">
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                          <li><a href="javascript:void(0)" class="viewItemDetails" rel="<?php echo $detail->sellerSku; ?>">View Detail</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <?php
                }
              }
              else
              {
                echo '<tr><td colspan="10">No record found.</td></tr>';
              }
              ?>

            </tbody>
          </table>
          <div class="inventoryList">
            <?php  if (isset($amazonItem)) {
              echo $amazonItem->links();
            }
            ?>
          </div>
  </div>
<?php else: ?>
  <div id="ebay" class="tab-pane fade">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th>Item Name</th>
          <th>Ordered Qty</th>
          <th>Item ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($ebayItem) && count($ebayItem))
        {
          $retunCharges 			= 0;
          $totalPaid    			= 0;
          $totalFinalValue    = 0;
          $totalProfit    		= 0;
          $paypalAmount				= 0;
          foreach($ebayItem as $detail)
          {
            $getOrderQTY = Helper::getEbayOrderQTY($detail->ebayItemRef);
            // echo "<pre>";print_r($getOrderQTY);echo "</pre>";
            $getOrderQTY = ($getOrderQTY[0]->orderQty) ? $getOrderQTY[0]->orderQty = $getOrderQTY[0]->orderQty : 0.00 ;


            ?>
            <tr class="tr<?php echo $detail->productRef;?>">
              <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->titleName;?></td>
                <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $getOrderQTY;?></td>
                  <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->ebayItemRef;?></td>
                    <!-- <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo 0;?></td>
                    <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo 0;?></td>
                    <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo 0;?></td> -->
                    <td class="text-left">
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                          <li><a href="javascript:void(0)" class="viewItemDetails" rel="<?php echo $detail->ebayItemRef; ?>">View Detail</a></li>
                        </ul>
                      </div>

                    </td>
                  </tr>
                  <?php
                  // Total Values
                  // $retunCharges 			+= $getOrderQTY;
                  // $totalPaid				  += $detail->amountPaid;
                  // $totalFinalValue    += $detail->FinalValueFee;
                  // $totalProfit    		+= $profitAmount;
                  // $paypalAmount				+= $detail->FeeOrCreditAmount;
                }

              }
              else
              {
                echo '<tr><td colspan="10">No record found.</td></tr>';
              }

              ?>
            </tbody>
          </table>
          <div class="inventoryList">
            <?php if (isset($ebayItem)) {
              echo $ebayItem->links();
            }?>
          </div>
        </div>
  <div id="amazon" class="tab-pane fade active in">
    <table class="table table-bordered table-responsive">
      <thead class="thead-inverse">
        <tr>
          <th>Item Name</th>
          <th>Ordered Qty</th>
          <th>ASIN</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($amazonItem) && count($amazonItem))
        {
          //echo "<pre>";print_r($amazonItem);echo "<pre>";
          $totalPrice 			= 0;
          $itemCharge 			= 0;
          $profit     			= 0;
          $retunValuePrice  = 0;
          foreach($amazonItem as $detail)
          {
            ?>
            <tr class="tr<?php echo $detail->productRef;?>">
              <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->itemName;?></td>
                <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $getOrderQTY;?></td>
                  <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->ASIN;?></td>
                    <td class="text-left">
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
                        <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                          <li><a href="javascript:void(0)" class="viewItemDetails" rel="<?php echo $detail->sellerSku; ?>">View Detail</a></li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <?php
                }
              }
              else
              {
                echo '<tr><td colspan="10">No record found.</td></tr>';
              }
              ?>

            </tbody>
          </table>
          <div class="inventoryList">
            <?php  if (isset($amazonItem)) {
              echo $amazonItem->links();
            }
            ?>
          </div>
  </div>
<?php endif; ?>
