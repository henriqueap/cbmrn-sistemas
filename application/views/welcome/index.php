
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
				<div class="col-lg-12 col-md-12">
					<h1>CBM-RN Corpo de Bombeiros RN</h1>
					<br>
					<h2>Sistemas Integrados </h2>

					<div class="row">
						
						<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
							<a href="<?php echo base_url('rh/'); ?>"><img src="<?php echo base_url('assets/img/img1.jpg'); ?>" class="img-responsive" alt="Responsive image"></a>
							<center><div>Sistemas de Recursos Humanos - CRH</div></center>
						</div>
						
						<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo base_url('assets/img/img2.png');?>" class="img-responsive" alt="Responsive image">
							<center><div>Sistema Acadêmico - CSFA                  </div></center>
						</div>
						
						<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo base_url('assets/img/img3.jpg');?>" class="img-responsive" alt="Responsive image">
							<center><div>Controle de Frotas - CLOG       </div></center>
						</div>
						
						<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo base_url('assets/img/img4.jpg');?>" class="img-responsive" alt="Responsive image">
							<center><div>Sistema de Missões - CSM                  </div></center>
						</div>
						
						<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo base_url('assets/img/img5.jpg');?>" class="img-responsive" alt="Responsive image">
							<center><div>Ensino a Distância - CSFA                </div></center>
						</div>
						
						<div class="col-lg-4 col-xs-12 col-sm-6 col-md-4">
							<img src="<?php echo base_url('assets/img/img6.jpg');?>" class="img-responsive" alt="Responsive image">
							<center><div>Ordens de Serivço - CPD</div></center>
						</div>
					</div>
				</div>
			</div> <!--/.row -->
		</div> <!--/.container -->
	</body>
</html>