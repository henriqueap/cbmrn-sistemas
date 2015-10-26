<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Listar Ocorrências</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
						<tr>
							<th>Ordem</th>
							<th>Código</th>
							<th>Ocorrência</th>
							<th>Localidade</th>
							<th>Idade</th>
							<th>Data</th>
							<th>Horário</th>
							<th>Ações</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						$count = 1; 
						if (isset($consulta) && (! is_bool($consulta))) {
							foreach($consulta as $ocorrencia): 
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $ocorrencia->codigo; ?></td>
								<td><?php echo $ocorrencia->ocorrencia; ?></td>
								<td><?php echo $ocorrencia->localidade; ?></td>
								<td><?php echo ($ocorrencia->idade == 0) ? "-" :  $ocorrencia->idade; ?></td>
								<td><?php echo date("d/m/Y", strtotime($ocorrencia->data_ocorrencia)); ?></td>
								<td><?php echo $ocorrencia->horario; ?></td>
								<td>
									<button onclick="confirmarExcluir('<?= base_url("index.php/ocorrencias/ocorrencias/excluir/$ocorrencia->ocorrencias_id"); ?>')"  data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs">Apagar</button>
									<a href="<?= base_url("index.php/ocorrencias/ocorrencias/editar/$ocorrencia->ocorrencias_id"); ?>" class="btn btn-default btn-xs">Editar</a>
								</td>
							</tr>
							<?php
							endforeach;
						}
						else {
						?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php 
						}   
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->