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
					<p class="pull-left">Add Inventory</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Add Inventory</p>
				</div>
			<div class="content_sec">
				<?php if($errors->any()) { ?>
			<div class="ajax_report alert-message alert alert-danger updateclientdetailsagent" role="alert">
				<span class="ajax_message ">
					<?php foreach($errors->all() as $error){
						echo $error.'</br>';
					}?>
				</span>
			</div>
			<?php }
			?>
			<?php if(isset($addedSuccessfull)) { echo $addedSuccessfull; } ?>
				<div class="ajax_report alert-message alert  updateclientdetails" role="alert" style="display:none">
						<span class="ajax_message updateclientmessage">Hello Message</span>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group srch-div">
							<b>Search Product</b>
							<?php echo Form::text('searchName','',array('class'=>'form-control success searchByName carOwner','placeholder'=>'Search Product By Name'));?>
								<img class="loadImage" src="<?php echo URL::asset('/assets/images/loadsub.gif') ; ?>"/>
							<span class="glyphicon glyphicon-search ico" aria-hidden="true"></span>
							<div class="div-position" id="clientList" style="">
								<ul id="clientUl" class="orderproductListUl">
								</ul>
	            </div>
						</div>
					</div>
				</div>
				<?php echo Form::open(array('url' => '/add-inventory', 'method' => 'post','class'=>'form','id'=>'inventoryForm','enctype'=>'multipart/form-data'));?>
				<?php echo Form::hidden('productId','',array('class'=>'form-control success productId'));?>
				<?php echo Form::hidden('description','',array('class'=>'form-control success description'));?>
				<div class="inv_detail">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<b>Title Name</b>
								<?php echo Form::text('titleName','Samsung',array('class'=>'form-control success titleName','placeholder'=>'Brand Name','readonly'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Model</b>
								<?php echo Form::text('modelName','',array('class'=>'form-control success modelName','placeholder'=>'Model','readonly'));?>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<b>Color</b>
								<?php echo Form::text('colorItem','',array('class'=>'form-control success colorNme','placeholder'=>'Color','readonly'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>Quantity</b>
									<?php echo Form::text('quantityEbay','1',array('class'=>'form-control success number totalQuantity','placeholder'=>'Quantity','readonly'));?>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<b>Total Cost</b>
								<?php echo Form::text('price','',array('class'=>'form-control success checkPrice priceVal','placeholder'=>'Total Cost'));?>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<b>IMEI/MEID Number</b>
								<?php echo Form::text('ImeNum','',array('class'=>'form-control success ','placeholder'=>'IMEI/MEID Number'));?>
							</div>
						</div>

						<!--div class="col-md-2">
							<div class="form-group">
								<b>IMEI/MEID Number</b>
								<?php //echo Form::text('ImeNum','',array('class'=>'form-control success meidNum','placeholder'=>'IMEI/MEID Number'));?>
							</div>
						</div-->
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
					<div class="add_b">
						<?php echo Form::button($value = 'Ebay', $attributes = array('class' => 'btn btn-primary checkform2 list-inventory-ebay')); ?>
					</div>
					<div class="row top-buffer ebayList" >
							<div class="col-md-4">
								<label>Condition</label>
								<?php echo Form::select('conditionId', array('1000' => 'Brand New', '2750' => 'Like New','4000'=>'Very Good','5000'=>'Good','6000'=>'Acceptable'),'',array('class'=>'form-control successEbay checkEbayList')); ?>
							</div>
							<div class="col-md-4">
								<label>Country/Region of Manufacture</label>
								<?php echo Form::select('country', array('IN' => 'India', 'US' => 'US'),'',array('class'=>'form-control successEbay checkEbayList')); ?>
							</div>
							<div class="col-md-4">
								<label>Duration</label>
								<?php echo Form::select('duration', array('Days_7' => '7 Days'),'',array('class'=>'form-control successEbay')); ?>
							</div>
							<div class="col-md-4">
								<label>UPC</label>
								<select class="form-control successEbay checkEbayList" name="upc">
									<option>Does not apply</option>
								</select>
							</div>
								<div class="col-md-12">
									<?php echo Form::submit($value = 'Add Inventory on Ebay', $attributes = array('class' => 'btn btn-primary checkform2 listedEbayProduct')); ?>
									<?php echo Form::button($value = 'Cancel', $attributes = array('class' => 'btn btn-primary ')); ?>
								</div>
					</div>
					</div>
					<div class="clearfix"></div>
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
