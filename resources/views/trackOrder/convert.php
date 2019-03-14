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
					<p class="pull-left">PDF Converter</p>
					<p class="pull-right"><i class="fa fa-home"></i> / PDF Converter</p>
				</div>
				<div class="clearfix"></div>
      <div class="m_con">
          <div class="panel panel-default new_margin">
						<div class="panel-heading">
  						<h4 class="panel-title">
  							<span>Add pdf file</span>
  						</h4>
						</div>
            <?php echo Form::open(array('url' => 'converter-img', 'method' => 'post','id'=>'converterPdf','class'=>'form','enctype'=>'multipart/form-data'));?>
						<div class="panel-collapse in collapse" id="collapse2">

    						<div class="open_inv_box">
          					<div class="col-md-12">
          						<div class="photo">
          						<span id="getName">Click to add pdf</span>
          						 <div class="form-group">
          							<span class="input-group-btn absolute">
          								<span class="btn btn-default btn-file">
          								<input type="file" name="myfile" id="getFileName">
          								</span>
          							</span>
          						</div>
          						<div class="clearfix"></div>
          						<div class="upload_imgs hide">  <img id='img-upload'></div>
          					</div>
                    <input type="submit" value="Convert" class="text-center btn btn-success submitConvertReq col-md-4 col-md-offset-4" align="center">
          					</div>
    						</div>
            </div>
          </form>
						<div class="clearfix"></div>
					</div>
        </div>
     </div>
    </div>
  </div>
<?php echo Helper::adminFooter(); ?>
