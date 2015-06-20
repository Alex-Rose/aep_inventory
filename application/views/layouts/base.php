<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bière AEP</title>
	
	<?php echo HTML::style('assets/bootstrap-3.3.4-dist/css/bootstrap.min.css', ['media' => 'all']);?>
	<?php echo HTML::style('assets/font-awesome-4.3.0/css/font-awesome.css', ['media' => 'all']);?>
	<?php echo HTML::style('assets/css/metisMenu.min.css', ['media' => 'all']);?>
	<?php echo HTML::style('assets/css/sb-admin-2.css', ['media' => 'all']);?>
	<?php echo HTML::style('assets/css/morris.css', ['media' => 'all']);?>
	<?php echo HTML::style('assets/css/dataTables.bootstrap.css', ['media' => 'all']);?>
	<?php echo HTML::style('assets/css/dataTables.responsive.css', ['media' => 'all']);?>
	<?php echo HTML::script('assets/js/jquery-2.1.3.min.js'); ?>
	<?php echo HTML::script('assets/bootstrap-3.3.4-dist/js/bootstrap.js'); ?>
	<?php echo HTML::script('assets/js/metisMenu.js'); ?>
	<?php echo HTML::script('assets/js/jquery.dataTables.min.js'); ?>
	<?php echo HTML::script('assets/js/dataTables.bootstrap.min.js'); ?>
	<?php //echo HTML::script('assets/js/raphael-min.js'); ?>
	<?php //echo HTML::script('assets/js/morris.min.js'); ?>
	<?php //echo HTML::script('assets/js/morris-data.js'); ?>
	<?php echo HTML::script('assets/js/sb-admin-2.js'); ?>
	<?php echo HTML::script('assets/js/form.js'); ?>
	<?php
		if (isset($addJs))
		{
			foreach($addJs as $js)
				echo HTML::script($js);
		}

		if (isset($addCss))
		{
			foreach($addCss as $css)
				echo HTML::style($css, ['media' => 'all']);
		}
	?>

</head>

<body>

    <div id="wrapper">

        <?php if (isset($header))echo $header; ?>

		<?php if (isset($content)){?>
			<div id="page-wrapper">
			   <?php echo $content; ?>
			</div>
			<!-- /#page-wrapper -->
		<?php }?>

		<?php if (isset($fullScreen))echo $fullScreen; ?>

    </div>
    <!-- /#wrapper -->
  

</body>

</html>
