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
					<p class="pull-left">Order</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Order List</p>
				</div>
			<div class="content_sec">
				<div class="search_boxs pull-left"><input type="text" class="search_boxa" rel="searchOrder" id="searchCustomer" placeholder="Search by Order Number">
					<i class="fa fa-search" aria-hidden="true"></i>
					<img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
				</div>

				<div class="detail-recents clearfix pull-left" id="allRecords">
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

												<?php
												$shippingLabelUrl = Helper::ebayLabelUrl($detail->orderRef);

												if (trim($detail->checkoutStatus) =="Complete" && trim($detail->orderAction) !="Return" ): ?>
												<li><a href="javascript:void(0);" data-ref="<?php  echo $detail->orderRef;?>" data-to="ebay" class='generate_Inv pull-left'>Generate Invoice </a></li>
												<?php endif; ?>
												<?php if (!isset($shippingLabelUrl->shippingLabel)){?>
													<li><a href="javascript:void(0);" data-ref="<?php  echo $detail->orderRef;?>" data-to="ebay" class='generate_ShippingLabel pull-left'>Generate Shipping Label </a></li>
												<?php }else{ ?>
													<li><a target="_blank" href="<?php if(isset($shippingLabelUrl->shippingLabel)) echo $shippingLabelUrl->shippingLabel; ?>" data-ref="<?php  echo $detail->orderRef;?>" data-to="ebay" class='pull-left'>Reprint Shipping Label </a></li>
												<?php }; ?>
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
				</div>
			</div>
		</div>
			<div id="editDetails"></div>

		</div>
		<div class="clearfix"></div>
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
						<?php echo Form::button($value = 'Add Tracking Number', $attributes = array('class' => 'btn btn-primary checkform2 addTrackingNumEbay')); ?>
			  </div>
			  <!-- dialog buttons -->

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
		          <div class="form-group col-md-6 ">
		            <label class="col-form-label" for="recipient-name">Shipment Charge:</label>
		            <input type="text" name="shipmentCharge" id="shipmentCharge" class="form-control ship" placeholder="Shipping Charge">
								<input type="hidden" name="returnType" id="returnType" value="1">
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

<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
