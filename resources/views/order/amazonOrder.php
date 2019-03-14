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
					<p class="pull-left">Amazon Order</p>
					<p class="pull-right"><i class="fa fa-home"></i> /Amazon Order List</p>
				</div>
			<div class="content_sec">
				<div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="searchAmazonOrder" id="searchCustomer" placeholder="Search by Order Number">
					<i class="fa fa-search" aria-hidden="true"></i>
					<img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
				</div>

				<div class="detail-recents clearfix pull-left" id="allRecords">
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
							<td id="stockNumber<?php echo $detail->orderRef; ?>">
								<?php $asin = Helper::amazonGetAsin($detail->orderRef); 
							 	if( $asin)
							 	{
							 		print_r($asin->asin );
							 	}
							 	
							 
							 ?>
							 	
							 </td>
						  <td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->numberOfItemsShipped;?></td>
							<td id="stockNumber<?php echo $detail->orderRef; ?>"><?php echo $detail->numberOfItemsUnshipped;?></td>
							<td id="imeNum<?php echo $detail->orderRef; ?>"><?php echo number_format($detail->totalAmount,2);?></td>
							<td align="center"><span id="ImeNum<?php echo $detail->orderRef; ?>">
								<?php if(trim($detail->IMEINumber)!='')
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
<!-- Modal -->
<div  id="returnOrderModel"  class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"></h4>
			</div>
			<?php echo Form::open(array('method' => 'post','class'=>'form','id'=>'returnOrder'));?>
			<div class="modal-body clearfix">
					<div class="form-group col-md-6 hide">
						<label class="col-form-label" for="recipient-name">Shipment Charge:</label>
						<!-- <input type="text" name="shipmentCharge" id="shipmentCharge" class="form-control inputsuccess ship" placeholder="Shipping Charge"> -->
						<input type="hidden" name="returnType" id="returnType" value="2">
						<input type="hidden" name="orderId" id="orderId" value="">
						<input type="hidden" name="delReturnRef" id="delReturnRef" value="">
					</div>
					<div class="clearfix"></div>
					<div class="form-group col-md-4 no-padding">
						<label class="col-form-label" for="message-text">Charge List:</label>
					</div>
					<div class="clearfix"></div>
					<table class="table table-hover" id="tableList">
									<thead>
											<tr>
													<th>S.No</th>
													<th>Title</th>
													<th>Price</th>
													<th>Action</th>
											</tr>
									</thead>
									<tbody id="returnItems">
									</tbody>
							<td colspan="3">Totol Amount</td>
							<td id="totalAmount">0.00</td>
					</table>
					<div class="alert alert-success" style="display:none">
						<strong>Success!</strong> Order Status updated.
					</div>
		</div>

			<div class="modal-footer">
				<button id="addLayer" type="button" class="btn btn-default pull-left"> <i class="fa fa-plus"></i> Add More</button>
				<button type="button" class="btn btn-success pull-right returnOrderSubmit"> Save</button>
			</div>
		</form>
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
