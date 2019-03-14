
			<div class="row">
				<div class="breadcrumbs">
					<p class="pull-left">Inventory</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Edit Inventory</p>
				</div>
			</div>

			<div class="content_sec">
				<div class="margin_40"></div>
				<div class="ajax_report alert-message alert  updateclientdetailsInv" role="alert" style="display:none">
						<span class="ajax_message updateclientmessageInv">Hello Message</span>
				</div>
				<?php echo Form::open(array('url' => 'update-inventory', 'method' => 'post','class'=>'form','id'=>'inventoryEditForm','enctype'=>'multipart/form-data'));?>
				<?php echo Form::hidden('imagesName',$inventoryInfo[0]->imageName,array('class'=>'form-control success imagesName','placeholder'=>'Brand Name'));?>
				<?php echo Form::hidden('description',$inventoryInfo[0]->description,array('class'=>'form-control success description'));?>
				<?php echo Form::hidden('productRef',$inventoryInfo[0]->productId,array('class'=>'form-control success productRef'));?>
				<div class="inv_detail">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<b>Brand Name</b>
								<?php echo Form::text('brandName',$inventoryInfo[0]->brandName,array('class'=>'form-control success listValue','placeholder'=>'Brand Name'));?>
								<?php //echo Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S');?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Model</b>
								<?php echo Form::text('modelName',$inventoryInfo[0]->modelName,array('class'=>'form-control success listValue','placeholder'=>'Model'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Date</b>
								<?php
											$date=date_create($inventoryInfo[0]->invDate);
											$date = date_format($date,"d/m/Y");
								?>
								<?php echo Form::text('invDate',$date,array('class'=>'form-control success datePicker listValue','placeholder'=>'Date'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Color</b>
								<?php echo Form::text('color',$inventoryInfo[0]->color,array('class'=>'form-control success','placeholder'=>'Color'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Quantity</b>
									<?php echo Form::text('quantity',$inventoryInfo[0]->quantity,array('class'=>'form-control success number listValue','placeholder'=>'Quantity'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>IMEI/MEID Number</b>
								<?php echo Form::text('ImeNum',$inventoryInfo[0]->ImeNum,array('class'=>'form-control success meidNum listValue','placeholder'=>'IMEI/MEID Number'));?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<b>Stock Number</b>
								<?php echo Form::text('stockNumber',$inventoryInfo[0]->stockNumber,array('class'=>'form-control success listValue','placeholder'=>'Stock Number'));?>
							</div>

						</div>
						<div class="col-md-3">
							<div class="form-group">
								<b>Kit Cost</b>
								<?php echo Form::text('kitCost',$inventoryInfo[0]->kitCost,array('class'=>'form-control success checkPrice','placeholder'=>'Kit Cost'));?>
							</div>

						</div>
						<div class="col-md-3">
							<div class="form-group">
								<b>Cost</b>
								<?php echo Form::text('cost',$inventoryInfo[0]->cost,array('class'=>'form-control success checkPrice','placeholder'=>'Cost'));?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<b>Total Cost</b>
								<?php echo Form::text('totalCost',$inventoryInfo[0]->totalCost,array('class'=>'form-control success checkPrice listValue','placeholder'=>'Total Cost'));?>
							</div>
						</div>
					</div>

				<div class="panel panel-default">
					<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Add a description</a>
					</h4>
					</div>
					<div id="collapse3" class="panel-collapse collapse">
						<div class="col-md-12">
							<div class="col-lg-12 nopadding">
							<textarea id="txtEditor"><?php echo $inventoryInfo[0]->description;?></textarea>
						</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="panel panel-default new_margin">
						<div class="panel-heading">
						<h4 class="panel-title">
							<span>Add photos</span>
						</h4>
						</div>
						<div id="collapse2" class="panel-collapse in collapse">
						<div class="open_inv_box">

					<div class="col-md-12">
						<div class="photo">
						Click to add photos
						 <div class="form-group">
							<span class="input-group-btn absolute">
								<span class="btn btn-default btn-file">
								 <input type="file" id="imgInp" class="submitImg" name="invImage"/>
								</span>
							</span>
						</div>
						<div class="clearfix"></div>
						<div class="upload_imgs"><?php
						$imgs = explode(',',$inventoryInfo[0]->imageName);
					for($i=0;$i<count($imgs);$i++){
							?>
							<img class="img-upload1" src="<?php echo URL::asset('/assets/inventoryImage/'.$imgs[$i]);?>" />
							<?php
						}?></div>
					</div>
					</div>
						</div> </div>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-12">
						<?php echo Form::button($value = 'Update Inventory', $attributes = array('class' => 'btn btn-primary checkform2 editInventoryDetail')); ?>
						<?php echo Form::button($value = 'Back', $attributes = array('class' => 'btn btn-primary backArrow')); ?>
					</div>

					</div>
						<?php echo Form::close()?>
				<div class="search_boxs new_margin pull-right text-right">

					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">List on Amazon</button>
					<?php if($inventoryInfo[0]->listedEbay != 1) { ?>
					<button type="button" class="btn btn-primary" onclick="myFunction()" >List on eBay</button></div>
					<?php } else{
						?>
							<button type="button" class="btn btn-primary" onclick="myFunction()" >Already Listed on eBay, View Details</button></div>
						<?php
					} ?>

				<div class="clearfix"></div>
					<?php echo Form::open(array('url' => 'list-inventory-ebay', 'method' => 'post','class'=>'form','id'=>'inventoryAddEbay','enctype'=>'multipart/form-data'));?>
						<?php echo Form::hidden('productRef',$inventoryInfo[0]->productId,array('class'=>'form-control success productRef'));?>
				<div id="eBay_collapse">
				 <div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" class="descriptionItem" data-parent="#accordion" href="#collapse1">Describe your item</a>
						</h4>
						</div>
						<div id="collapse1" class="panel-collapse collapse in padding_inner">
						<div class="form-group">
						<div class="col-md-4">
							<label>Title</label>
							<?php echo Form::text('titleName',$inventoryInfo[0]->titleName,array('class'=>'form-control successEbay checkEbayList','placeholder'=>'Title'));?>
						</div>
						<div class="col-md-4">
							<label>Subtitle</label>
							<?php echo Form::text('subTitle',$inventoryInfo[0]->subTitle,array('class'=>'form-control successEbay checkEbayList','placeholder'=>'Sub Title'));?>
						</div>
						<div class="col-md-4">
							<label>Condition</label>
							<?php echo Form::select('conditionId', array('1000' => 'Brand New', '2750' => 'Like New','4000'=>'Very Good','5000'=>'Good','6000'=>'Acceptable'),$inventoryInfo[0]->conditionId,array('class'=>'form-control successEbay checkEbayList')); ?>

						</div>
						<div class="clearfix"></div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<label>Condition description</label>
							<p>Highlight any defects, missing parts, scratches or wear and tear also described in your item description. Use this field only for your item's condition to comply with our selling practices policy.</p>
							<textarea type="text" class="form-control successEbay checkEbayList" value="<?php echo $inventoryInfo[0]->conditionDescription;?>" name="conditionDescription" placeholder="Condition Description"></textarea>
							<p>Note: 1000 character limit </p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-4">
							<label>UPC</label>
							<select class="form-control successEbay checkEbayList" name="upc">
								<option>Does not apply</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
					<div class="heading_form">Add item specifics <hr></div>
					<p>Buyers often refine their search using these item specifics. If you don't provide these details here, your listing may not appear in their search results<br>
					Based on your title and category, we've suggested some item specifics that you left blank when you listed. If these values aren't correct, please revise them.</p>
					</div>
					<!--div class="form-group">
						<div class="col-md-4">
							<label>MPN</label>
							<select class="form-control successEbay">
								<option>Does Not Apply</option>
							</select>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="form-group">
						<div class="col-md-4">
							<label>Compatible Brand</label>
							<select class="form-control successEbay">
								<option>Universal</option>
							</select>
						</div>
						<div class="col-md-4">
							<label>Bundle Listing </label>
							<select class="form-control successEbay">
								<option>Yes</option>
							</select>
						</div-->
						<div class="col-md-4">
							<label>Country/Region of Manufacture</label>
							<?php echo Form::select('country', array('IN' => 'India', 'US' => 'US'),$inventoryInfo[0]->country,array('class'=>'form-control successEbay checkEbayList')); ?>

						</div>
					</div>

					<div class="clearfix"></div>
						</div>
					</div>

						<div class="panel panel-default">
							<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Choose a format and price</a>
							</h4>
							</div>
							<div id="collapse4" class="panel-collapse collapse">
							<div class="open_inv_box">
								<div class="form-group">
									<div class="col-md-4">
										<label>Buy It Now Price </label>
											<?php echo Form::text('price',$inventoryInfo[0]->price,array('class'=>'form-control successEbay checkPrice','placeholder'=>'Buy Price'));?>

									</div>
								</div>

								<div class="form-group">
									<div class="col-md-3">
										<label>Quantity  </label><br>
										<?php echo Form::text('quantityEbay',$inventoryInfo[0]->quantityEbay,array('class'=>'form-control successEbay number','placeholder'=>'Quantity'));?>

									</div>
									<div class="col-md-3">
										<label>Duration</label>
										<?php echo Form::select('duration', array('Days_7' => '7 Days'),$inventoryInfo[0]->duration,array('class'=>'form-control successEbay')); ?>

									</div>
								</div>
								<div class="col-md-12">
									<?php if($inventoryInfo[0]->listedEbay != 1) { ?>
									<?php echo Form::button($value = 'List Inventory on Ebay', $attributes = array('class' => 'btn btn-primary  addInventoryEbay')); ?>
									<?php } ?>
								</div>
								<div class="clearfix"></div>
							</div>
							</div>
						</div>
					</div>


<div class="ajax_report alert-message alert  updateclientdetails" role="alert" style="display:none">

			<span class="ajax_message updateclientmessage">Hello Message</span>
		</div>
				<div class="clearfix"></div>

			</div>
	<?php echo Form::close()?>

<script>
function myFunction() {
    var x = document.getElementById("eBay_collapse");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "block";
    }
}
</script>
<script>
$(document).ready( function() {
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {

		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;

		    if( input.length ) {
		        input.val(log);
		    } else {
		        //if( log ) alert(log);
		    }

		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
							$('.upload_imgs').append('<img class="img-upload1" src="'+e.target.result+'" /><span><i class="fa fa-remove"></i></span>');
		            //$('#img-upload').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		});
	});
	</script>
