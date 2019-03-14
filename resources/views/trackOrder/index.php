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
					<p class="pull-left">Track Order</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Track Order</p>
				</div>
			<div class="content_sec">
        <div class="col-md-5">
			<div class="input-group custom-search-form">
              <input type="text" id="searchTrackNumber" rel="get-track-order" placeholder="Enter Tracking Number" class="form-control">
              <span class="input-group-btn">
              <button type="submit" id="searchTrackNumberBtn"class="btn btn-success"><i class="fa fa-search"></i></button>
              <span class="glyphicon glyphicon-search"></span>
             </button>
             </span>
             </div>	
			  <img src="<?php echo URL::asset('/assets/images/loadsub.gif');?>" class="loadImage" style="display: none;">
        </div>
        <div class="clearfix">

        </div>

        <div id="trackOrderDetail"></div>
			</div>
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
<script type="text/javascript">
  jQuery(document).ready(function(){
      jQuery('#trackOrderDetail').hide();
      jQuery(document).on('click','#searchTrackNumberBtn', function() {
				jQuery('#searchTrackNumber').css('border','1px solid #ccc'); //unset border
        var lowerCase = jQuery('#searchTrackNumber').val().toLowerCase();
        var upperCase = jQuery('#searchTrackNumber').val();
        var pageName = jQuery('#searchTrackNumber').attr('rel');
        if($.trim(lowerCase) !=''){
        pageName = site_url + '/' + pageName + '?' + 'ajax=1&lowerCase=' + lowerCase + '&upperCase=' + upperCase;
        jQuery('.loadImage').show();
        var type = 'html';
        var returnAMt = ajaxHit1(pageName, type);
        returnAMt.success(function(response) {
          jQuery('#trackOrderDetail').show();
          jQuery("#trackOrderDetail").html(response);
          jQuery('.loadImage').hide();
        });
      }else
      {
        jQuery('#searchTrackNumber').attr('placeholder','Please Enter Tracking Number');
        jQuery('#searchTrackNumber').css('border','1px solid #a94442'); // set border
      }


      });
  })
</script>
