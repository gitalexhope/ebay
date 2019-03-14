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
					<p class="pull-left">Item Profit </p>
					<p class="pull-right"><i class="fa fa-home"></i> / Item Profit </p>
				</div>
			<div class="content_sec">
				<ul class="nav nav-tabs col-md-6" style="border-bottom:none !important">
	        <li class="active"><a data-toggle="tab" href="#ebay">Ebay Item Profit</a></li>
	        <li class=""><a data-toggle="tab" href="#amazon">Amazon Item Profit</a></li>
	      </ul>
				<!-- <div class="col-md-6">
					<div class="col-sm-4">
						<input type="text"  placeholder="From Date"name="startDateRange" value="" id="startDateRange" class="datepicker form-control" readonly>
					</div>
					<div class="col-sm-4">
						<input type="text"  placeholder="Date To"name="endDateRange" value="" id="endDateRange" class="datepicker form-control" readonly>
					</div>
					<div class="col-sm-4">
						<div class="btn-group col-sm-12 no-padding">
						<button type="button" class="btn btn-primary col-sm-12 dropdown-toggle" data-toggle="dropdown" aria-expanded="true">PDF <span class="caret"></span></button>
						<ul class="dropdown-menu panel-dropdown pull-right" role="menu">
							 <li><a href="javascript:void(0)" data-ref="ebay" class="getPdf">ebay PDF</a></li>
							 <li><a href="javascript:void(0)" data-ref="amazon" class="getPdf">Amazon PDF</a></li>
						</ul>
						</div>
					</div>
					<div class="clearfix">

					</div>
					<div class="ProfitErrMsg">
					</div>
				</div> -->
				<div class="search_boxs pull-left hide"><input type="text" class="search_boxa" rel="searchOrder" id="searchCustomer" placeholder="Search by Order Number">
					<i class="fa fa-search" aria-hidden="true"></i>
					<img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
				</div>

				<div class="detail-recents clearfix pull-left" id="allRecords">
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
											$getOrderQTY = ($getOrderQTY[0]->orderQty) ? $getOrderQTY[0]->orderQty = $getOrderQTY[0]->orderQty : 0;


										?>
										<tr class="tr<?php echo $detail->productRef;?>">
											<td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->titleName;?></td>
											<td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $getOrderQTY;?></td>
											<td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->ebayItemRef;?></td>
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
									$amazonOrderQTY		= 0;
				 					foreach($amazonItem as $detail)
				 					{
										$getAmazonQTY = Helper::getAmazonOrderQTY($detail->sellerSku);
										//echo "<pre>";print_r($getAmazonQTY);echo "</pre>";die;
										$amazonOrderQTY = ($getAmazonQTY[0]->AmazonOrderQty) ? $getAmazonQTY[0]->AmazonOrderQty = $getAmazonQTY[0]->AmazonOrderQty : 0;
				 			?>
								<tr class="tr<?php echo $detail->productRef;?>">
									<td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->itemName;?></td>
									<td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $amazonOrderQTY;?></td>
									<td><span id="brandNameList<?php echo $detail->productRef; ?>"><?php echo $detail->ASIN;?></td>
									<td class="text-left">
										<div class="btn-group">
												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
													<ul class="dropdown-menu panel-dropdown pull-right" role="menu">
														<li><a href="javascript:void(0)" class="viewAmazonItemDetails" rel="<?php echo $detail->sellerSku; ?>">View Detail</a></li>
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
				</div>
			</div>
		</div>
			<div id="editDetails"></div>
			
				
		</div>
		<div class="clearfix"></div>
		<div class="footer_sec">
			<p>Copyright © XYZ. All Rights Reserved.</p>
		</div>
	</div>
</div>

<a href="#" id="downloadPDF"></a>
<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy'
	});
	$('.datepicker').on('changeDate', function(ev){
		$(this).datepicker('hide');
	});

});
</script>
