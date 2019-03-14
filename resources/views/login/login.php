<div class="login_screen">
		<div class="container">
            <div class="row">

				<div class="logo_box"><img src="<?php echo URL::asset('/assets/images/logo.png'); ?>" alt="" class="img-respons"></div>
				<div class="clearfix"></div>
				<div class="login_boxs">
					<h1>Welcome To Company Name</h1>
					<div class="arrow-down"></div>
				<div class="login_form">
					<?php if($errors->any()) { ?>
				<div class="ajax_report alert-message alert alert-danger updateclientdetailsagent" role="alert">
					<span class="ajax_message ">
						<?php foreach($errors->all() as $error){
							echo $error.'</br>';
						}?>
					</span>
				</div>
				<?php }
				if(isset($passError)){
					?>
					<div class="ajax_report alert-message alert alert-danger updateclientdetailsagent" role="alert">
					<span class="ajax_message ">
						<?php echo 	$passError;?>
					</span>
				</div>
					<?php
					} ?>
					<?php echo Form::open(array('url' => '/login', 'method' => 'post','class'=>'form loginForm'));?>
						<div class="input_boxs"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo Form::email($name="emailId", $value = null, $attributes = array('class' => 'success','id'=>'emailIdMail')); ?>
						</div>
						<div class="input_boxs"><i class="fa fa-lock" aria-hidden="true"></i><?php echo Form::password('password',array('class'=>'success')); ?>
						</div>
						<a href="#">Forgot password?</a>
						<?php echo Form::submit($value = 'Sign in Now', $attributes = array('class' => 'button checkLogin')); ?>
					<?php echo Form::close()?>
				</div>
				</div>
            </div>
        </div>
	</div>
<?php echo Helper::adminFooter(); ?><script type="text/javascript">
	jQuery('.checkLogin').click(function () {
		jQuery('.loginForm').submit();
	})
</script>
