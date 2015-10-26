<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta name="robots" content="no-cache" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php echo (isset($title)) ? $title : 'CBM-RN'; ?></title>
		<link href="<?php echo base_url('assets/css/default.css'); ?>" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			// Constante importante para o código FRONT-END!!!
			BASE_URL = "<?php echo base_url(); ?>";
		</script>
	</head>

	<body>
		<header id="top">
			<div class="container" >
				<dafastamentosss="row">
					<div class="col-lg-9  col-md-9 col-sm-9 col-xs-9">
						<div id="logo" class="pull-left">
							<a href="<?php echo base_url('index.php/ocorrencias/ocorrencias'); ?>">
								<img src="<?php echo base_url('/assets/img/cbmrn_logo.png'); ?>" width="80" height="80" />
							</a>
						</div>
						<div>
							<h3>Centro de Ocorrências</h3>
							<h5>Corpo de Bombeiros Militar do Rio Grande do Norte - CBM-RN</h5>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<div class="pull-right">
							<!-- Exibir imagem do usuário militar existente e sua respectiva patente. -->
							<ul class="ulUser">
								<!--
								<li><span class="glyphicon glyphicon-user"></span></li>
								<li>Sd Pereira</li>
								<li>|</li>
								-->
								<li><h4><a href="<?php echo base_url('index.php/acesso/logout'); ?>">Sair</a></h4></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>

					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li><?php echo anchor('ocorrencias/ocorrencias', 'Início'); ?></li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ocorrências <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?= anchor('ocorrencias/ocorrencias/index', 'Cadastro', array('title'=>''));?></li>
									<li><?= anchor('ocorrencias/ocorrencias/consulta', 'Consulta', array('title'=>''));?></li>
									<li><?= anchor('ocorrencias/ocorrencias/tipo_ocorrencia', 'Tipo Ocorrências', array('title'=>''));?></li>
									<li><?= anchor('ocorrencias/ocorrencias/prudencial', 'Cadastro em Lote', array('title'=>'Ocorrência prudênciais')); ?></li>
									<li><?= anchor('ocorrencias/ocorrencias/mostra_grafico', 'Gráficos', array('title'=>'Gráficos das Ocorrências')); ?></li>
								</ul>
							</li> <!--/.dropdown-->

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Locais <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?= anchor('ocorrencias/locais/cadastro', 'Cadastro', array('title'=>''));?></li>
									<li><?= anchor('ocorrencias/locais/consulta', 'Consulta', array('title'=>''));?></li>
								</ul>
							</li> <!--/.dropdown-->
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</header>

		<!-- Exibição dos Erros no Sistema! -->
		<div class="container">
			<?php
			$msg = $this->session->flashdata('mensagem');
			echo validation_errors('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			if (!empty($msg)): ?>
				<div class="alert <?= $msg['type']; ?> alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?= $msg['msg']; ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Layout do Sistema! -->
		<div class="wrap">
			<?php echo $layout; ?>
		</div>

		<!-- HTML Modal -->
		<div class="modal fade" id="myModal-excluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h3 id="myModalLabel">Atenção!</h3>
					</div>
					<div class="modal-body">
						<p>Deseja realmente excluir?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
						<a type="button" class="btn btn-primary" id="bt-modal-confirmar-exclusao" href="#">Sim</a>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4">
						<p>&copy; Centro de Processamento de Dados - <?php echo anchor('http://www.cbm.rn.gov.br/', 'CBM-RN', array('target' => '_blank')); ?></p>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8"></div>
				</div> <!--.row-->
			</div> <!--.container-->
		</footer>

		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.twbsPagination.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskMoney.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/select2_locale_pt-BR.js'); ?>"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/gerenciamento.js'); ?>"></script>
		<!--<script type="text/javascript" charset="utf-8" src="<?php #echo base_url('assets/js/angular.min.js'); ?>"></script>-->
	</body>
</html>
