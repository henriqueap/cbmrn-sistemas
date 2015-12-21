<?php if (NULL === $this->session->userdata('idmilitar')) header("location: base_url('index.php/acesso/logout')"); ?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta name="robots" content="no-cache" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="600; <?php echo base_url('index.php/acesso/logout'); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?php echo (isset($title)) ? $title : 'CBM-RN'; ?></title>
		<link href="<?php echo base_url('assets/css/default.css'); ?>" rel="stylesheet" type="text/css" />
		<style type="text/css">
			@media print {
				.printable { 
					visibility: visible; 
				} 
			}
		</style>
		<script type="text/javascript">
			// Constante importante para o código FRONT-END!!!
			BASE_URL = "<?php echo base_url(); ?>";
		</script>
	</head>

	<body>
		<header id="top">
			<div class="container" >
				<div class="row">
					<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
						<div id="logo" class="pull-left">
							<h4>
								<a href="<?php echo base_url('clog/clog'); ?>">
									<img src="http://www2.defesasocial.rn.gov.br/cbmrn/cbdocs/cbmrn.png" alt="CBMRN" width="80" height="80" />
								</a>
							</h4>
						</div>
						<div>
							<h3>Centro de Logística - CLOG</h3>
							<h5>Corpo de Bombeiros Militar do Rio Grande do Norte - CBM-RN</h5>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<div class="pull-right">
							<ul class="ulUser">
								<li><span class="glyphicon glyphicon-user"></span></li>
								<li><?php echo $this->session->userdata['militar']; ?></li>
								<li>|</li>
								<li><a href="<?php echo base_url('index.php/acesso/logout'); ?>">Sair</a></li>
							</ul>
						</div> <!--.pull-rigth-->
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
							<li><?php echo anchor('clog/clog', 'Início'); ?></li>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastros <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?php echo anchor('clog/grupos/index', 'Criar Grupos', array('title' => 'Cadastro de Grupos dos Produtos')); ?></li>
									<li><?php echo anchor('clog/marcas/index', 'Criar Marcas', array('title' => 'Cadastro de Marcas de Produtos')); ?></li>
									<li><?php echo anchor('clog/produtos/index', 'Produtos', array('title' => 'Cadastro de Produtos')); ?></li>
									<li><?php echo anchor('clog/empresa/index', 'Empresas', array('title' => 'Cadastro de Empresas')); ?></li>
									<li><?php echo anchor('clog/cadastra_sala', 'Cadastrar Salas', array('title' => 'Cadastro de Salas')); ?></li>
								</ul>
							</li> <!--/.dropdown-->

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Movimentação <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li role="presentation" class="disabled"><a href="#">Entradas </a></li>
									<li><?php echo anchor('clog/notas/index', 'Entrada por Nota Fiscal', array('title' => 'Entrada de Material por Nota Fiscal')); ?></li>
									<li><?php echo anchor('clog/notas/entrada_avulsa', 'Entrada Avulsa', array('title' => 'Entrada de Material Avulsa')); ?></li>
									<li role="separator" class="divider"></li>
									<li role="presentation" class="disabled"><a href="#">Saídas </a></li>
									<li><?php echo anchor('clog/cautelas/index', 'Cautela de Material', array('title' => 'Cadastro de Cautela de Material')); ?></li>
									<li><?php echo anchor('clog/cautelas/index?tp=1', 'Distribuição para Militar', array('title' => 'Cadastro de Distribuição para Militar')); ?></li>
									<li><?php echo anchor('clog/cautelas/index?tp=3', 'Distribuição para Setor', array('title' => 'Cadastro de Distribuição para Setor')); ?></li>
									<!--<li><?php #echo anchor('clog/cautelas/saida_retroativa', 'Saída Retroativa de Material', array('title' => 'Cadastro de Saída de Material - Retroativa')); ?></li>-->
									<li><?php echo anchor('clog/cautelas/transferencia_material', 'Transferência de Material', array('title' => 'Transferência de Material')); ?></li>
								</ul>
							</li> <!--/.dropdown-->

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultas <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?php echo anchor('clog/notas/consulta', 'Notas Fiscais', array('title' => 'Consulta de Notas Fiscais')); ?></li>
									<li><?php echo anchor('clog/notas/listar_avulsas', 'Entradas Avulsas', array('title' => 'Listar todas as entradas avulsas')); ?></li>
									<li><?php echo anchor('clog/produtos/estoque', 'Estoque', array('title' => 'Consulta de Estoque')); ?></li>
									<li><?php echo anchor('clog/produtos/consulta', 'Produtos', array('title' => 'Consulta de Produtos')); ?></li>
									<li><?php echo anchor('clog/empresa/consulta', 'Empresas', array('title' => 'Consulta de Empresas Cadastradas')); ?></li>
									<li><?php echo anchor('clog/cautelas/consulta_cautelas', 'Cautelas', array('title' => 'Consulta de Cautelas')); ?></li>
									<li><?php echo anchor('clog/cautelas/consulta_distros', 'Distribuição', array('title' => 'Consulta de Distribuições')); ?></li>
									<li><?php echo anchor('clog/cautelas/consulta_transferencias', 'Transferência', array('title' => 'Consulta de Transferências')); ?></li>
									<li><?php echo anchor('clog/cautelas/consulta_tombo', 'Tombo', array('title' => 'Consulta de Tombo')); ?></li>
								</ul>
							</li> <!--/.dropdown-->

							<!--<li class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ordens de Serviço <b class="caret"></b></a>
											<ul class="dropdown-menu">
												<li><?php //echo anchor('clog/os/equipe', 'Criar Equipe', array('title'=>'Cadastro de Equipe'));  ?></li>
												<li><?php //echo anchor('clog/os/index', 'Criar Ordem de Serviço', array('title'=>'Cadastro de Ordem de Serviço'));  ?></li>
												<li><?php //echo anchor('clog/os/listar_equipe', 'Listar Equipes', array('title'=>'Listar Equipes'));  ?></li>
												<li><?php //echo anchor('clog/os/listar', 'Listar Ordens de Serviço', array('title'=>'Listar Ordens de Serviço'));  ?></li>
											</ul>
							</li>--> <!--/.dropdown-->

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Permissões <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><?php echo anchor('clog/permissao/index', 'Criar Permissão', array('title' => 'Cadastro de Permissões')); ?></li>
									<li><?php echo anchor('clog/permissao/criarGrupo', 'Criar Grupo de Permissão', array('title' => 'Cadastro de Grupos')); ?></li>
									<li><?php echo anchor('clog/permissao/listarGrupos', 'Listar Grupos', array('title' => 'Listar Grupos')); ?></li>
									<!--<li><?php //echo anchor('clog/permissao/editarGrupo', 'Gerenciar Permissões de Grupo', array('title'=>'Gerenciar Permissões de Grupo'));  ?></li>-->
									<li><?php echo anchor('clog/permissao/permissoesUsuario', 'Incluir Usuário em Grupo', array('title' => 'Incluir Usuário em Grupo')); ?></li>
								</ul>
							</li> <!--/.dropdown-->

							<li><?php echo anchor('clog/auditoria', 'Auditoria'); ?></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</header>

		<!-- Exibição dos Erros no Sistema! -->
		<div class="container">
			<?php
			$msg = $this->session->flashdata('mensagem');
			echo validation_errors('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
			if (!empty($msg)):
				?>
				<div class="alert <?= $msg['type']; ?> alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?= $msg['msg']; ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Layout do Sistema! -->
		<div class="wrap">
			<?php echo isset($layout) ? $layout : ''; ?>
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
						<a type="button" class="btn btn-primary" id="bt-modal-confirmar-exclusao">Sim</a>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-4">
						<p>&copy; Centro de Processamento de Dados - <a href="http://www.cbm.rn.gov.br/" target="_blank">CBM-RN</a></p>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8"></div>
				</div> <!--.row-->
			</div> <!--.container-->
		</footer>

		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.twbsPagination.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskMoney.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/select2_locale_pt-BR.js'); ?>"></script>
		<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/gerenciamento.js'); ?>"></script>
		<script type="text/javascript">
			(function ($) {
				"use strict";
				$.extend($.fn.select2.defaults, {
					formatNoMatches: function () {
						return "Nenhum resultado encontrado.";
					},
					formatInputTooShort: function (input, min) {
						var n = min - input.length;
						return "Informe " + n + " caractere" + (n == 1 ? "" : "s");
					},
					formatInputTooLong: function (input, max) {
						var n = input.length - max;
						return "Remova " + n + " caractere" + (n == 1 ? "" : "s");
					},
					formatSelectionTooBig: function (limit) {
						return "Só é possível selecionar " + limit + " cliente." + (limit == 1 ? "" : "s");
					},
					formatLoadMore: function (pageNumber) {
						return "Carregando mais resultados...";
					},
					formatSearching: function () {
						return "Buscando...";
					}
				});
			});
			(jQuery);
		</script>
	</body>
</html>