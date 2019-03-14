
<table class="table table-bordered table-responsive">
  <thead class="thead-inverse">
  <tr>
    <th>Product Name</th>
    <th>Stock Number</th>
    <th>Date</th>
    <th>Total Cost</th>
    <th>Quantity</th>
    <th>Listed on Ebay</th>
    <th>Listed on Amazon</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
    <?php if(count($inventoryList)){
        foreach($inventoryList as $detail){
     ?>
     <tr id="productRef<?php echo $detail->productRef; ?>">
     <td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->brandName?></span>(<span id="modelName<?php echo $detail->productRef; ?>"><?php echo $detail->modelName; ?> </span>)</td>
     <td id="stockNumber<?php echo $detail->productRef; ?>"><?php echo $detail->stockNumber;?></td>
     <td id="createdDate<?php echo $detail->productRef; ?>"><?php  $date=date_create($detail->invDate);echo date_format($date,"d/m/Y");?></td>
     <td id="totalCost<?php echo $detail->productRef; ?>">$<?php echo number_format($detail->totalCost,2);?></td>
     <td id="quantity<?php echo $detail->productRef; ?>"><?php echo $detail->quantity;?></td>
     <td id="ebaylisted<?php echo $detail->productRef; ?>"><?php if($detail->listedEbay != 1)echo 'Not Listed'; else echo 'Listed';?></td>
     <td id="amazonListed<?php echo $detail->productRef; ?>"><?php if($detail->listedAmazon != 1)echo 'Not Listed';else echo 'Listed';?></td>
     <td><a href="javascript:void(0)" rel="<?php echo $detail->productRef; ?>" src="editInventory" class="editInventory"><i class="fa fa-pencil" aria-hidden="true"></i></a>
         <a href="javascript:void(0)" class="deleteProduct"  data-ref="<?php echo $detail->productRef; ?>" data-to="inventory">
           <i class="fa fa-trash" aria-hidden="true"></i>
         </a>
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
  <?php echo $inventoryList->links();?>
</div>
