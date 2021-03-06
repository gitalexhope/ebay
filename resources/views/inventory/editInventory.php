
			<div class="row">
				<div class="breadcrumbs">
					<p class="pull-left">Product</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Update Product</p>
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
						<!-- <div class="col-md-2">
							<div class="form-group">
								<b>IMEI/MEID Number</b>
								<?php echo Form::text('ImeNum',$inventoryInfo[0]->ImeNum,array('class'=>'form-control success meidNum listValue','placeholder'=>'IMEI/MEID Number'));?>
							</div>
						</div> -->
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<b>Stock Number</b>
								<?php if (trim($inventoryInfo[0]->stockNumber)!=""){
									$stockNum = $inventoryInfo[0]->stockNumber;
								}else {
									$stockNum = Helper::getStockNumbers();;
								} ?>
								<?php echo Form::text('stockNumber','#'.$stockNum,array('class'=>'form-control success listValue','placeholder'=>'Stock Number'));?>
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
						if(trim($inventoryInfo[0]->imageName)!="")
						{
						$imgs = explode(',',$inventoryInfo[0]->imageName);
							for($i=0;$i<count($imgs);$i++){
							?>
							<img class="img-upload1" src="<?php echo URL::asset('/assets/inventoryImage/'.$imgs[$i]);?>" />
						<?php
						}
						}?></div>
					</div>
					</div>
						</div> </div>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-12">
						<?php echo Form::button($value = 'Update Product', $attributes = array('class' => 'btn btn-primary checkform2 editInventoryDetail')); ?>
						<?php echo Form::button($value = 'Back', $attributes = array('class' => 'btn btn-primary backArrow')); ?>
					</div>

					</div>
						<?php echo Form::close()?>

				<div class="clearfix"></div>
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
