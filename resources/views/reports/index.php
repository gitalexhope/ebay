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
					<p class="pull-left">Reports</p>
					<p class="pull-right"><i class="fa fa-home"></i> / Reports</p>
				</div>
			<div class="content_sec">
				<div class="detail-recents clearfix pull-left" id="allRecords">

          <div class="col-md-4">
							<a href="<?php echo URL('profit-report');?>">
							<div class="box_md" >
							<div class="number_box blue_box" style="height:122px">
								<div class="col-md-12">
									<img src="<?php echo URL::asset('/assets/images/match.png');?>">
									<p class="pull-right" style="margin-top:22px; font-weight:700">Overall Profit </p>
									<b class="pull-right"></b>
								</div>
							</div>
						</div>
						</a>
          </div>
					<div class="col-md-4">
            <a href="<?php echo URL('item-profit-report');?>">
            <div class="box_md" >
            <div class="number_box blue_box" style="height:122px">
              <div class="col-md-12">
                <img src="<?php echo URL::asset('/assets/images/match.png');?>">
                <p class="pull-right" style="margin-top:22px; font-weight:700">Item Profit</p>
                <b class="pull-right"></b>
              </div>
            </div>
          </div>
          </a>
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

<div id="wait"></div>
<?php echo Helper::adminFooter(); ?>
