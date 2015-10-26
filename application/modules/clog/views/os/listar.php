<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Listar Ordens de Serviço</h1></div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Ordem</th>
								<th>Solicitante</th>
								<th>Solicitação</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$count = 1; 
							if (isset($listarOS)) {
								foreach($listarOS as $os): ?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $os->solicitante; ?></td>
										<td><?php echo $os->descricao; ?></td>
										<td>
											<input type="button" name="btnOS" id="btnOS" value="Mostrar" onclick="location.href = '<?php echo BASE_URL('clog/os/ordem_servico').'?id='.$os->id; ?>';">
											<input type="button" name="btnOS" id="btnOS" value="Cancelar" onclick="location.href = '<?php echo BASE_URL('clog/os/cancelarOS').'?id='.$os->id; ?>';">
										</td>
									</tr>
								<?php endforeach; 
							}
							else { ?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php 
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->