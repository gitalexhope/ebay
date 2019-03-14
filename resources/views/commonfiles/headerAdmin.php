<?php   $value = Session::get('amaEbaySessId');
if($value == ''){
			Redirect::to('/')->send();
		}
 ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width" name="viewport">
<meta content="initial-scale=1" name="viewport">
<meta name="viewport" content="user-scalable=no, width=device-width">
<meta content="width=device-width, initial-scale=1" name="viewport">
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/style.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/font-awesome.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/bootstrap.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/bootstrap.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/editor.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/jquery-ui.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo URL::asset('/assets/css/datepicker.css'); ?>" />
<link href="<?php echo URL::asset('/assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,600' rel='stylesheet' type='text/css'/>
<title></title>
<script>
	var site_url = '<?php echo url('/') ; ?>';
</script>
</head>
<body>
