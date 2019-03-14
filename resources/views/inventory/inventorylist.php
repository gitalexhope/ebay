<div id="header">
<div class="col-md-2">
	<div class="logo_sec">
		<img src="<?php echo URL::asset('/assets/images/logo.png');?>">
	</div>
</div>
<div class="col-md-10">
<?php echo view('commonfiles/searchHeader');?>
</div>
</div>
<div class="col-md-12" id="wrapper_panel">
	<div class="row dashboard-amazon">
	<?php echo view('commonfiles/sidebar');?>
	<div class="col-md-10 main_content">
	<div class="inventoryListDetail">
	<div class="breadcrumbs">
	<p class="pull-left Inventory">Inventory</p>
	<p class="pull-right InventoryList"><i class="fa fa-home"></i> / Inventory List</p>
	</div>
	<div class="content_sec">
	<div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="searchInventory" id="searchCustomer" placeholder="Search by Name, IMEI/MEID">
	<i class="fa fa-search" aria-hidden="true"></i>
	<img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
	</div>
	<div class="search_boxs pull-right">
	<button class="btn btn-primary pull-right" onclick="location.href = 'add-product'">Add Product  +</button>
	</div>
	<div class="detail-recents clearfix pull-left" id="allRecords">
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
</div>
</div>
</div>
<div id="editDetails"></div>


</div>
<div class="clearfix"></div>
			<div class="" id="footer">
				<div class="footer_sec">
					<p>Copyright © XYZ. All Rights Reserved.</p>
					<div class="clearfix"></div>
				</div>
			</div>

</div>
</div>

<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
<script type="text/javascript">
	var currenturl = "<?php echo Request::url()?>";
	var urlSplit   = currenturl.split("/");
	urlSplit 			 = urlSplit[urlSplit.length-1]; // getting last element of url
	if(urlSplit === 'product-list')
	{
		jQuery('.breadcrumbs .Inventory').html('Products');
		jQuery('.breadcrumbs .InventoryList').html('Product List');
	}
</script>
