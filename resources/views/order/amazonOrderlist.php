<table class="table table-bordered table-responsive">
  <thead class="thead-inverse">
  <tr>
    <th width="190px" >Order Number</th>
    <th>Status</th>
    <th>ASIN</th>
    <th>Total Shipped</th>
    <th>Total Unshipped</th>
    <th>Total Price</th>
    <th width="70px" >IMEI Number</th>
    <th>Sale Date</th>
    <th>Buyer Name</th>
    <th>Order Status</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
    <?php if(count($orderDetail)){
        foreach($orderDetail as $detail){
    ?>
  <tr class="tr<?php echo $detail->orderRef;?>">
    <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
    <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->orderStatus;?></td>
    <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php $asin = Helper::amazonGetAsin($detail->orderRef); 
                if( $asin)
                {
                  print_r($asin->asin );
                }
                
               
               ?> </td>
    <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->numberOfItemsShipped;?></td>
    <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->numberOfItemsUnshipped;?></td>
    <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->totalAmount,2);?></td>
    <td align="center"><span id="ImeNum<?php echo $detail->orderRef; ?>">
      <?php
              if(trim($detail->IMEINumber)!='')
              echo "<a href='javascript:void(0)' data-ref='".$detail->orderRef."' data-to='amazon' class='currentIEMI".$detail->orderRef." ImeNum'> ".$detail->IMEINumber." </a>";
              else  echo "<button data-ref='".$detail->orderRef."' data-to='amazon' class='btn btn-success currentIEMI".$detail->orderRef." ImeNum'> Add IMEI NO. </button>";
       ?>
    </td>
    <!-- <td class="text-right trackingNum<?php echo $detail->orderRef; ?>"><?php if($detail->trackingNumber == '') { ?><button class="btn btn-success trackNumber" rel="<?php echo $detail->orderRef; ?>">Add</button><?php } else { echo $detail->trackingNumber ; }?></td> -->
    <td id="createdDate<?php echo $detail->orderRef; ?>"><?php  $date=date_create($detail->purchaseDate);echo date_format($date,"d/m/Y");?></td>
    <td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo $detail->buyerName;?></td>
    <td class="StatusTd"><?php echo $detail->orderAction; ?></td>
    <td class="text-left">

        <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
        <ul class="dropdown-menu panel-dropdown pull-right" role="menu">
          <li><a href="javascript:void(0)" class="amazoneOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
          <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='amazonOrder' data-for="Active" href="javascript:void(0)">Active</a></li>
          <li><a class="returnOrder" data-ref="<?php echo $detail->orderRef; ?>" href="javascript:void(0)">Return</a></li>
          <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='amazonOrder' data-for="Complete" href="javascript:void(0)">Complete</a></li>
          <li><a class="orderStatus" data-ref="<?php echo $detail->orderRef; ?>" data-to='amazonOrder' data-for="Canceled" href="javascript:void(0)">Canceled</a></li>
            <?php if (trim($detail->orderStatus) !="Canceled" && trim($detail->orderAction) !="Return" ): ?>
              <li><a href="javascript:void(0);" data-ref="<?php echo $detail->orderRef;?>" data-to="amazon" class='generate_Inv pull-left'>Generate Invoice </a></li>
            <?php endif; ?>
            <?php if (trim($detail->orderStatus) =="Shipped" && trim($detail->orderAction) !="Return" ): ?>
              <li><a href="javascript:void(0);" data-ref="<?php echo $detail->orderRef;?>" data-to="amazon" class='generate_amazonShippingLabel pull-left'>Generate Shipping Label </a></li>
            <?php endif; ?>
        </ul>
        </div>
    </td>
  </tr>
  <?php
      }
    }
    else{
      echo '<tr><td colspan="10">No record found.</td></tr>';
    }
    ?>
  </tbody>
</table>
<div class="inventoryList">
  <?php echo $orderDetail->links();?>
</div>
