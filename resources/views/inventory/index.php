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
				<div class="breadcrumbs">
					<p class="pull-left">Add Product</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Add Product</p>
				</div>
				<div class="content_sec">
				<div class="margin_40"></div>
				<div class="ajax_report alert-message alert  updateclientdetails" role="alert" style="display:none">
						<span class="ajax_message updateclientmessage">Hello Message</span>
				</div>
				<?php echo Form::open(array('url' => '/add-product', 'method' => 'post','class'=>'form','id'=>'inventoryForm','enctype'=>'multipart/form-data'));?>
				<?php echo Form::hidden('imagesName','',array('class'=>'form-control success imagesName','placeholder'=>'Brand Name'));?>
				<?php echo Form::hidden('description','',array('class'=>'form-control success description'));?>
				<div class="inv_detail">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<b>Brand Name</b>
								<?php echo Form::text('brandName','Samsung',array('class'=>'form-control success','placeholder'=>'Brand Name' , 'readonly'));?>
								<?php //echo Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S');?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<b>Model</b>
								<?php echo Form::text('modelName','',array('class'=>'form-control success','placeholder'=>'Model'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Date</b>
								<?php echo Form::text('invDate','',array('class'=>'form-control success datePicker','placeholder'=>'Date'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Color</b>
								<?php echo Form::text('color','',array('class'=>'form-control success','placeholder'=>'Color'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Quantity</b>
									<?php echo Form::text('quantity','',array('class'=>'form-control success number','placeholder'=>'Quantity'));?>
							</div>
						</div>
						<!--div class="col-md-2">
							<div class="form-group">
								<b>IMEI/MEID Number</b>
								<?php //echo Form::text('ImeNum','',array('class'=>'form-control success meidNum','placeholder'=>'IMEI/MEID Number'));?>
							</div>
						</div-->
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<b>Stock Number</b>
								<?php $getStockNumbers = Helper::getStockNumbers(); ?>
								<?php echo Form::text('stockNumber','#'.$getStockNumbers,array('class'=>'form-control success','placeholder'=>'Stock Number', 'readonly'));?>
							</div>

						</div>
						<div class="col-md-3">
							<div class="form-group">
								<b>Kit Cost</b>
								<?php echo Form::text('kitCost','',array('class'=>'form-control success checkPrice','placeholder'=>'Kit Cost'));?>
							</div>

						</div>
						<div class="col-md-3">
							<div class="form-group">
								<b>Cost</b>
								<?php echo Form::text('cost','',array('class'=>'form-control success checkPrice','placeholder'=>'Cost'));?>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<b>Total Cost</b>
								<?php echo Form::text('totalCost','',array('class'=>'form-control success checkPrice','placeholder'=>'Total Cost'));?>
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
							<textarea id="txtEditor"></textarea>
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
						<div class="upload_imgs">  <!--img id='img-upload'/--></div>
					</div>
					</div>
						</div> </div>
						<div class="clearfix"></div>
					</div>
					<div class="col-md-12">
						<?php echo Form::button($value = 'Add Product', $attributes = array('class' => 'btn btn-primary checkform2 addInventory2')); ?>
					</div>
					</div>
						<?php echo Form::close()?>

				<div class="clearfix"></div>

			</div>


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
</div>
<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
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
