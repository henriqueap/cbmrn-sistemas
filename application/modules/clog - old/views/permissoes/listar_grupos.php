<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Listar Grupos de Permissão</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
						<tr>
							<th>Grupo</th>
							<th>Ações</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						$count = 1; 
						if (isset($listarGrupos)) {
							foreach($listarGrupos as $grupo): ?>
							<tr>
								<td><?php echo $grupo->nome; ?></td>
								<td>
									<input type="button" name="btnOS" id="btnOS" value="Gerenciar Permissões" onclick="location.href = '<?php echo BASE_URL('index.php/clog/permissao/editarGrupo').'?id='.$grupo->id; ?>';">
									<!--<input type="button" name="btnOS" id="btnOS" value="Cancelar" onclick="location.href = '<?php #echo BASE_URL('clog/os/cancelarOS').'?id='.$grupo->id; ?>';">-->
								</td>
							</tr>
							<?php endforeach; 
						}
						else {
						?>
							<tr>
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
	<div id="lista_permissoes_grupo" class="row">
	</div> <!-- .row -->	
</div> <!-- .container -->