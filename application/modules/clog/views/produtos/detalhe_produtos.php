<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<link href="<?php echo base_url('assets/css/default.css'); ?>" rel="stylesheet" type="text/css" />
		<meta name="robots" content="no-cache" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Detalhamento de Produto - Sistema CLog</title>
		<link href="<?php echo base_url('assets/css/default.css'); ?>" rel="stylesheet" type="text/css" />
		<style type="text/css">
			@media print {
				.notPrintable { 
					visibility: hidden; 
				}
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
		<div class="container printable">
			<div class="row printable">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable">
					<h1>Detalhes do produto</h1>
					<hr />
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable">
					<table class="table table-bordered">
						<tr>
							<td>Modelo</td>
							<td><?= $produtos->modelo; ?></td>
						</tr>
						<tr>
							<td>Marca</td>
							<td><?= $produtos->marca; ?></td>
						</tr>
						<tr>
							<td>Grupo</td>
							<td><?= $produtos->grupo; ?></td>
						</tr>
						<tr>
							<td>Quantidade em Estoque Atual</td>
							<td><?= $produtos->quantidade_estoque; ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>
					</table><!--/.table-->
					<hr />
				</div><!--/ .detalhes do produto-->
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<h1>Tombos cadastrados</h1>
					<hr />
					<?php
					if (isset($tombos) && (!is_bool($tombos))) {
						foreach ($tombos as $tombo => $info):
							if ($info === FALSE)
								echo $tombo . " ";
							else {
								?>
								<a href="" class="modal-hist-trigger"><?php echo $tombo; ?></a>
								<?php
							}
						endforeach;
					}
					?>
					<hr />
				</div> <!--/ .tombos cadastrados-->
				<!-- HTML Modal -->
				<div id="modal-hist-prod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content" id="modal-hist-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Histórico</h4>
							</div>
							<div class="modal-body" >
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<!-- HTML Print -->
				<div id="print-hist-prod" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable" data-action>
				</div><!-- /.print -->
			</div><!--/.row-->
		</div><!--/.container-->
	</body>
</html>