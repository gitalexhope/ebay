<table class="table table-bordered table-responsive">
  <thead class="thead-inverse">
  <tr>
    <th width="200px">Order Number</th>
    <th width="190px">IMEI Number</th>
    <th>Status</th>
    <th  width="50px">Qty</th>
    <th width="98px">Total Paid</th>
    <th width="92px">Total Price</th>
    <th width="144px" >Tracking Number</th>
    <th>Sale Date</th>
    <th>Order Status</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
    <?php if(count($orderList))
    {

        foreach($orderList as $detail)
        {
    ?>
  <tr class="tr<?php echo $detail->orderRef;?>">
    <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
    <td align="center"><span id="ImeNum<?php echo $detail->orderRef; ?>">
    <?php 	/*if(trim($detail->ImeNum)!='')
              {
                echo "$detail->ImeNum";

              }
            else*/ if(trim($detail->IMEINumber)!='')
              echo "<a href='javascript:void(0)' data-ref='".$detail->orderRef."' data-to='ebay' class='currentIEMI".$detail->orderRef." ImeNum'> ".$detail->IMEINumber." </a>";
              else  echo "<button data-ref='".$detail->orderRef."' data-to='ebay' class='btn btn-success currentIEMI".$detail->orderRef." ImeNum'> Add IMEI NO. </button>";
       ?>
    </td>
    <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->checkoutStatus;?></td>
    <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->totalItemPurchased;?></td>
    <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->amountPaid,2);?></td>
    <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->totalAmt,2);?></td>
    <td class="text-left trackingNum<?php echo $detail->orderRef; ?>"><?php if($detail->trackingNumber == '') { ?><button class="btn btn-success trackNumber" rel="<?php echo $detail->orderRef; ?>">Add</button><?php } else { echo $detail->trackingNumber ; }?></td>
    <td id="createdDate<?php echo $detail->orderRef; ?>">
      <?php
      if (trim($detail->CreatedTime)!='') {
        $date=date_create($detail->CreatedTime);
      }else {
        $date=date_create($detail->lastModifiedDate);
      }
      echo date_format($date,"d/m/Y");
      ?>
    </td>
    <!-- <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo $detail->FinalValueFee;?></td> -->
    <td class="StatusTd"><?php echo $detail->orderAction; ?></td>
    <td class="text-left">
      <!-- <a href="#" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">Send invoice</a> -->

          <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
            <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
                <li><a href="javascript:void(0)" class="viewOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
                <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='orderDetail' data-for="Active" href="javascript:void(0)">Active</a></li>
                <li><a class="returnOrder" data-ref="<?php echo $detail->orderRef; ?>" href="javascript:void(0)">Return</a></li>
                <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='orderDetail' data-for="Complete" href="javascript:void(0)">Complete</a></li>
                <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='orderDetail' data-for="Canceled" href="javascript:void(0)">Canceled</a></li>
                  <?php if (trim($detail->checkoutStatus) =="Complete" && trim($detail->orderAction) !="Return" ): ?>
                    <li><a href="javascript:void(0);" data-ref="<?php  echo $detail->orderRef;?>" data-to="ebay" class='generate_Inv pull-left'>Generate Invoice </a></li>
                  <?php endif; ?>
                <!--<li><a href="#">End item</a></li>
                <li><a href="#">Add note</a></li>
                <li><a href="#">Add to list</a></li> -->
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
  <?php echo $orderList->links();?>
</div>
