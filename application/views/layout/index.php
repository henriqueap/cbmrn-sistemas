<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
	$meta = array( 
	  array('name' => 'robots', 'content' => 'no-cache'),
	  array('name' => 'description', 'content' => ''),
	  array('name' => 'keywords', 'content' => ''),
	  array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
	  array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0')
	);
	echo meta($meta);
?>
<title><?= (isset($title)) ? $title : 'CBMRN - Bombeiros RN' ;?></title>
<?= link_tag('assets/css/default.css'); ?>
</head>

<body>
	<div class="container">
		<div class="row">
			<?php echo validation_errors('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>'); ?>
		</div> <!--/.row-->
	</div> <!--/.conatiner-->
	<?= $layout; ?>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.min.js'); ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?= base_url('assets/js/bootstrap.min.js'); ?>" charset="UTF-8"></script>
<script type="text/javascript" src="<?= base_url('assets/js/gerenciamento.js'); ?>" charset="UTF-8"></script>
</body>
</html>