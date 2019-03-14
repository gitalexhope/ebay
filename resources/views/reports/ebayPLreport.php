<div class="col-md-12">
	<div class="row">
		<?php echo view('commonfiles/sidebar');?>
		<div class="col-md-10 main_content">
			<?php echo view('commonfiles/searchHeader');?>
			<div class="inventoryListDetail">
			<div class="row">
				<div class="breadcrumbs">
					<p class="pull-left">Reports</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Reports</p>
				</div>
			</div>
			<div class="content_sec">
				<div class="margin_40"></div>
				<div class="detail-recents clearfix pull-left" id="allRecords">
          <div class="col-md-4">
            <a href="<?php echo URL('ebay-report');?>">
            <div class="box_md" >
            <div class="number_box blue_box" style="height:122px">
              <div class="col-md-12">
                <img src="http://localhost/ebayamazon/assets/images/match.png">
                <p class="pull-right" style="margin-top:22px; font-weight:700">Ebay P&L Report</p>
                <b class="pull-right"></b>
              </div>
            </div>
          </div>
          </a>
          </div>
					<!-- <div class="col-md-4">
						<a href="javascript:void(0)" class="btn trackOrder btn-primary"> Track Order</a>
          </div> -->
				</div>
			</div>
		</div>
			<div id="editDetails"></div>
			<div class="row">
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
<script type="text/javascript">
	jQuery(document).on('click','.trackOrder',function()
	{
		$.ajax({
          type: "POST",
          url: site_url + '/track-order',
          data: {'detailLower' : $(this).val() , 'detailUpper' : $(this).val()},
          beforeSend  : function () {
    				 $(".loader_div").show();
    			},
    			complete: function () {
    				 $(".loader_div").hide();
    			},
          success: function (response) {
              if(response.length > 1){
                $('#creditorSearchList').html(response);
                  $('#popover-form').addClass('hide');
              }
          }
      });
	})
</script>
