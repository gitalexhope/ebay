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
			<div class="inventoryListDetail">
			<div class="row">
				<div class="breadcrumbs">
					<p class="pull-left">Ebay Commission</p>
					<p class="pull-right"><i class="fa fa-home"></i> /Ebay Commission</p>
				</div>
			</div>
			<div class="content_sec">
				<div class="margin_40"></div>
				<div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="searchEbayOrderCommission" id="searchCustomer" placeholder="Search by Order Number">
					<i class="fa fa-search" aria-hidden="true"></i>
					<img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
				</div>

				<div class="detail-recents clearfix pull-left" id="allRecords">
					<table class="table table-bordered table-responsive">
					  <thead class="thead-inverse">
						<tr>
						  <th width="20" >Order Number</th>
							<th>Status</th>
							<th>Total Tax</th>
							<th>Final Value Fee</th>
							<th>Total Price</th>
						  <th>Action</th>
						</tr>
					  </thead>
					  <tbody>
							<?php if(count($orderDetail)){
									foreach($orderDetail as $detail){
							?>
						<tr>
						  <td><span id="brandNameList<?php echo $detail->orderRef; ?>"><?php echo $detail->orderRef;?></td>
							<td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->orderStatus;?></td>
						  <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php if($detail->totalTaxAmount > 0 ) echo $detail->totalTaxAmount;?></td>
							<td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->FinalValueFee;?></td>
							<td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->transactionPrice,2);?></td>
							<td class="text-center">

									<div class="btn-group">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action <span class="caret"></span></button>
									<ul class="dropdown-menu panel-dropdown pull-right" role="menu">
									<li><a href="javascript:void(0)" class="amazoneOrderDetails" rel="<?php echo $detail->orderRef; ?>">View Order Detail</a></li>
									<li><a class="amazoneShipment" href="javascript:void(0)">Buy Shipping</a></li>
									<li><a href="#">End item</a></li>
									<li><a href="#">Add note</a></li>
									<li><a href="#">Add to list</a></li>
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
				</div>
			</div>
		</div>
			<div id="editDetails"></div>
			
		</div>
		<div class="footer_sec">
					<p>Copyright © XYZ. All Rights Reserved.</p>
					<div class="clearfix"></div>
				</div>
	</div>
</div>
<div id="myModalTrack" class="modal fade">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Tracking Number</h4>
      </div>
				<div class="ajax_report alert-message alert alert-success trackingNum" role="alert" style="display:none">

					<span class="ajax_message trackingMsg">Hello Message</span>

	            </div>
			  <div class="modal-body dataNotes">
							<?php echo Form::hidden('orderId','',array('class'=>'form-control success orderIdTracking','placeholder'=>'Tracking Number'));?>
								<?php echo Form::text('trackNum','',array('class'=>'form-control success trackNum','placeholder'=>'Tracking Number'));?>
								<?php echo Form::button($value = 'Add Tracking Number', $attributes = array('class' => 'btn btn-primary checkform2 addTrackingNum')); ?>

			  </div>
			  <!-- dialog buttons -->

			</div>
		  </div>
		</div>
<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
<script type="text/javascript">
jQuery('#myModalTrack').on('hidden.bs.modal', function (e)
{
		// Reset values when model hide
		 jQuery(this).find("input[type=text],textarea,select").val('').end();
});
</script>
