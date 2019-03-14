<table>
<tbody>
<tr id="nextLine" class="hide">
	<td class="serialNumber">1</td>
	<td>
			<input type="text" class="form-control inputsuccess" name="chargeName[]" placeholder="Title">
			<input type="hidden" class="form-control returnRef" name="returnRef[]">
	</td>
	<td>
				<input type="text" class="form-control inputsuccess validnumber" name="chargePrice[]" placeholder="Price">
	</td>
	<td class="addMins">
	</td>
</tr>
</tbody>
</table>
<div id="IMEINumber" class="modal fade">
		  <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Add IMEI Number</h4>
        </div>
				<div class="ajax_report alert-message alert alert-success EmiNumMsg" role="alert" style="display:none">
							<span class="ajax_message alertAjaxMsg">Hello Message</span>
	      </div>
			  <div class="modal-body dataNotes">
					  <?php echo Form::hidden('orderId','',array('class'=>'form-control success orderIdIMEI'));?>
					  <?php echo Form::hidden('dataTo','',array('class'=>'form-control success dataTo'));?>
						<?php echo Form::text('imieNum','',array('class'=>'form-control success imieNum','placeholder'=>'IMEI Number'));?>
						<?php echo Form::button($value = 'Add IMEI Number', $attributes = array('class' => 'btn btn-primary checkform2 addIMEINumber')); ?>
			  </div>
			  <!-- dialog buttons -->

			</div>
		  </div>
		</div>
<div id="deleteRecordModel" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<?php echo Form::hidden('orderId','',array('class'=>'form-control success productRef'));?>
						<?php echo Form::hidden('dataTo','',array('class'=>'form-control success dataTo'));?>
						<button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
						<h4 class="modal-title">
							<i class="glyphicon glyphicon-trash"></i> Delete !</h4>
					</div>
					<div class="ajax_report alert-message alert alert-success deleteMessage" role="alert" style="display:none">
								<span class="ajax_message alertAjaxMsg">Hello Message</span>
		      </div>
					<div class="modal-body">
						<div class="bootbox-body">Are you sure you want to Delete ?</div>
					</div>
					<div class="modal-footer">
						<button aria-hidden="true" data-dismiss="modal" class=" btn btn-success" type="button">No</button>
						<button class="btn btn-danger deleteCurrentProduct" type="button" data-bb-handler="danger">Delete!</button>
					</div>
				</div>
		</div>
</div>
<div id="StatusRecordModel" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<?php echo Form::hidden('orderId','',array('class'=>'form-control success dataStatusRef'));?>
						<?php echo Form::hidden('dataTo','',array('class'=>'form-control success dataStatusFor'));?>
						<?php echo Form::hidden('orderId','',array('class'=>'form-control success dataStatusTo'));?>
						<?php echo Form::hidden('dataTo','',array('class'=>'form-control success dataStatusTr'));?>
						<button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
						<h4 class="modal-title">
							<i class="glyphicon glyphicon-info-sign"></i> Status Update !</h4>
					</div>
					<div class="ajax_report alert-message alert alert-success alertUpdateMessage" role="alert" style="display:none">
								<span class="ajax_message">Hello Message</span>
		      </div>
					<div class="modal-body">
						<div class="returnChargesDiv" style="margin-bottom:6px; display:none">
							<strong>Note :-</strong> &nbsp; All Return Charges will be cleared and action cannot be undone.
						</div>

						<div class="bootbox-body" id="dataStatus"></div>
					</div>
					<div class="modal-footer">
						<button aria-hidden="true" data-dismiss="modal" class=" btn btn-info" type="button">No</button>
						<button class="btn btn-success updateStatusOrder" type="button" data-bb-handler="danger">Yes!</button>
					</div>
				</div>
		</div>
</div>
<div id="updateAmazonQuantity" class="modal fade">
	<div class="modal-dialog">
		<?php echo Form::open(array('method' => 'get','class'=>'formUpdateInventory'));?>
				<div class="modal-content">
						<div class="modal-header">
							<?php echo Form::hidden('sellerSku','',array('class'=>'form-control success dataSellerSku'));?>
							<?php echo Form::hidden('DataTOUpdate','',array('class'=>'form-control success DataTOUpdate'));?>
							<?php echo Form::hidden('oldQuantity','',array('class'=>'form-control success dataOldQuantity'));?>
							<?php echo Form::hidden('oldPrice','',array('class'=>'form-control success dataOldPrice'));?>
							<button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
							<h4 class="modal-title" >
								<i class="glyphicon glyphicon-info-sign"></i> <span>Update Product </span> !</h4>
						</div>
						<div class="ajax_report alert-message alert alert-success alertUpdateMessage" role="alert" style="display:none">
									<span class="ajax_message">Hello Message</span>
			      </div>
						<div class="modal-body">
							<div class="form-group col-sm-12">
									<div class="col-sm-3 no-padding">
										<h5><b>Product Name :-</b></h5>
									</div>
									<div class="col-sm-9 no-padding">
											<h5> <span id="productName" style="line-height:20px"> NEW Samsung Galaxy S5 SM-G900A 16GB White Android Smartphone ATT GSM UNLOCKED</span></h5>
									</div>
						</div>
							<div class="form-group col-sm-6 col-xs-12">
								<label for="quantity">Quantity</label>
								<?php echo Form::text('productQuantity','',array('class'=>'form-control success productQuantity'));?>
							</div>
							<div class="form-group  col-sm-6 col-xs-12">
								<label for="quantity">Sale Price</label>
								<?php echo Form::text('productPrice','',array('class'=>'form-control success productPrice'));?>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="alertMessageUpdateInv col-sm-12 hide"></div>
						<div class="clearfix"></div>
						<div class="modal-footer">
							<button aria-hidden="true" data-dismiss="modal" class=" btn btn-info" type="button">No</button>
							<button class="btn btn-success" type="submit" data-bb-handler="danger">Update!</button>
						</div>
					</div>
			</form>
		</div>
</div>
<div id="generateInvoice" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
					<div class="modal-header">
						<?php echo Form::hidden('invoiceRef','',array('class'=>'form-control success invoiceRef'));?>
						<?php echo Form::hidden('invoiceDataTo','',array('class'=>'form-control success invoiceDataTo'));?>
						<button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
						<h4 class="modal-title">
							<i class="glyphicon glyphicon-info-sign"></i> Invoice !</h4>
					</div>
					<div class="ajax_report alert-message alert alert-success deleteMessage" role="alert" style="display:none">
								<span class="ajax_message alertAjaxMsg">Hello Message</span>
		      </div>
					<div class="modal-body">
						<div class="bootbox-body">
								<h4 id="OrderRefId"></h4>
								<span>Are you sure you want to generate Invoice?</span>
						</div>
					</div>
					<div class="modal-footer">
						<button aria-hidden="true" data-dismiss="modal" class=" btn btn-success" type="button">No</button>
						<button class="btn btn-primary createInvoice" type="button">Generate!</button>
					</div>
				</div>
		</div>
</div>
<div id="generateShippingLabel" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content">
				<form class="shippingLabelForm" method="post">
					<?php echo Form::hidden('ShippingName','',array('class'=>'form-control  success ShippingName'));?>
					<?php echo Form::hidden('streetFirst','',array('class'=>'form-control success streetFirst'));?>
					<?php echo Form::hidden('streetSec','',array('class'=>'form-control success streetSec'));?>
					<?php echo Form::hidden('cityName','',array('class'=>'form-control success cityName'));?>
					<?php echo Form::hidden('state','',array('class'=>'form-control success state'));?>
					<?php echo Form::hidden('countryName','',array('class'=>'form-control success countryName'));?>
					<?php echo Form::hidden('phone','',array('class'=>'form-control success phone'));?>
					<?php echo Form::hidden('postalCode','',array('class'=>'form-control success postalCode'));?>
					<?php echo Form::hidden('orderID','',array('class'=>'form-control success orderID'));?>
					<div class="modal-header">

						<button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
						<h4 class="modal-title">
							<i class="glyphicon glyphicon-info-sign"></i> Shipping Label !</h4>
					</div>
					<div class="ajax_report alert-message alert alert-success shipingMessageElement" role="alert" style="display:none">
								<span class="ajax_message shipingAlertAjaxMsg"></span>
		      </div>
					<div class="modal-body">
						<div class="bootbox-body clearfix">
							<div class="col-sm-12">
								  <div class="shippingAddressFrom col-sm-6">
										<h4><b>Ship From:- </b></h4>
											<table>
													<tr>
														<td>
															<b>Wsdeals</b>
															<br>
															787 Woodlawn Dr
															<br>
															Thousand oaks , CA 91360
													</tr>
											</table>
								  </div>
									<div class="shippingAddressTo col-sm-6">
										<h4><b>Ship To:- </b></h4>
										<div class="address">

										</div>

								  </div>

									<div class="col-sm-12 no-padding">
										<br><br>
											<div class="col-sm-6">
													<div class="form-group">
														<label for="">Package Type</label>
																<select class="shippingInputsuccess form-control packageType" name="packageType">
																		<option value="">Select Package Type</option>
																		<option value="Large Envelope or Flat">Large Envelope or Flat</option>
																		<option value="Thick Envelope">Thick Envelope</option>
																		<option value="Package">Package</option>
																		<option value="Flat Rate Box">Flat Rate Box</option>
																		<option value="Small Flat Rate Box">Small Flat Rate Box</option>
																		<option value="Large Flat Rate Box">Large Flat Rate Box</option>
																		<option value="Flat Rate Envelope">Flat Rate Envelope</option>
																		<option value="Large Package">Large Package</option>
																		<option value="Oversize Package">Oversize Package</option>
																</select>
													</div>
											</div>
											<div class="col-sm-6">
													<div class="form-group">
															<label for="">Label Type</label>
																<select class="form-control  shippingInputsuccess labelType" name="labelType">
																		<option value="">Select Label Type</option>
																		<option value="Png">Png</option>
																		<option value="Pdf">Pdf</option>
																</select>
													</div>
											</div>
									</div>
									<div class="col-sm-6">
											<label for=""> Select Service Type  </label>
										<div class="form-group">
											<select class="form-control shippingInputsuccess" name="serviceType">
												<option value="">Select Service Type</option>
												<option value="US-FC">USPS First-Class Mail</option>
												<option value="US-MM">USPS Media Mail</option>
												<option value="US-PP">USPS Parcel Post</option>
												<option value="US-PM">USPS Priority Mail</option>
												<option value="US-XM">USPS Priority Mail Express</option>
												<option value="US-EMI">USPS Priority Mail Express International</option>
												<option value="US-PMI">USPS Priority Mail International</option>
												<option value="US-FCI">USPS First Class Mail International</option>
												<option value="US-CM">USPS Critical Mail</option>
												<option value="US-PS">USPS Parcel Select</option>
												<option value="US-LM">USPS Library Mail</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
											<label for=""> Weight Oz </label>
											<div class="form-group">
														<input type="text" class="form-control validnumber shippingInputsuccess" name="setWeightOz" value="">
											</div>
									</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button aria-hidden="true" data-dismiss="modal" class=" btn btn-success" type="button">No</button>
						<button class="btn btn-primary createEbayShippingLabel" type="submit">Generate Shipping Label!</button>
					</div>
				</div>
				</form>
		</div>
</div>

<div id="amazonGenerateShippingLabel" class="modal fade">
	<div class="modal-dialog">
			<div class="modal-content" id="dataShipLabel">
		</div>
</div>

<script type="text/javascript" src="<?php echo URL::asset('/assets/js/jquery.min.js') ; ?>" ></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/jquery.form.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/bootstrap.min.js') ; ?>" ></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/editor.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/jquery-ui.js') ; ?>" ></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/jquery-ui.min.js') ; ?>" ></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/error.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/mycustom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo URL::asset('/assets/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$("#txtEditor").Editor();
// var nowTemp = new Date();
// var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
// var checkin = $('#startDateRange').datepicker({
// }).on('changeDate', function(ev) {
//   if (ev.date.valueOf() > checkout.date.valueOf()) {
//     var newDate = new Date(ev.date)
//     newDate.setDate(newDate.getDate() + 1);
//     checkout.setValue(newDate);
//   }
//   checkin.hide();
//   $('#endDateRange')[0].focus();
// }).data('datepicker');
// var checkout = $('#endDateRange').datepicker({
//   	onRender: function(date) {
//     return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
//   }
// }).on('changeDate', function(ev) {
//    checkout.hide();
// }).data('datepicker')
//
// jQuery('#endDateRange').datepicker({
// 	format: 'dd/mm/yyyy'
// });
// jQuery('#startDateRange').datepicker({
// 	format: 'dd/mm/yyyy'
// });

});
</script>
