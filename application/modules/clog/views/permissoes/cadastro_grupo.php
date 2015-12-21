<?php # var_dump($grupos_id); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Cadastro de Grupo de Permissões</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-body">
				<?php 
				echo form_open('clog/permissao/novoGrupo', array('role'=>'form', 'class'=>'form-horizontal')); ?>
					<!--<div class="form-group">
						<label for="modulos_id" class="col-sm-2 control-label">Módulo</label>
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
							<select name="modulos_id" class="form-control" id="modulos_id">
								<option value="0">Selecione o Módulo</option>
								<?php 
								#foreach($modulos as $row): 
									#if (isset($grupo_id) && $row->id == $grupo_id) {?>
										<option value="<?php #echo $row->id; ?>" selected><?php #echo $row->nome; ?></option>
										<?php
									#}
									#else {?>
										<option value="<?php #echo $row->id; ?>" selected><?php #echo $row->nome; ?></option>
										<?php
									#}
								#endforeach; ?>
							</select>
						</div>
					</div>-->
					<div class="form-group">
						<label for="grupo_nome" class="col-sm-2 control-label">Nome do Grupo</label>
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
							<input type="text" name="grupo_nome" class="form-control" id="grupo_nome" value="<?php echo (isset($grupo->nome))? $grupo->nome : ''; ?>" placeholder="Grupo de permissão" required/>
							<input type="hidden" name="grupo_id" class="form-control" id="grupo_id" value="<?php echo (isset($grupo->id))? $grupo->id : ''; ?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
							<button type="submit" class="btn btn-default">Salvar</button>
						</div>
					</div>
			  <?php echo form_close(); ?>
			  </div>
			</div>
		</div>
	</div> <!-- .row -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Grupos Cadastrados</h1>
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
							foreach($listarGrupos->result() as $row): ?>
							<tr>
								<td><?php echo $row->nome; ?></td>
								<td>
									<input type="button" value="Renomear" onclick="location.href = '<?php echo BASE_URL('index.php/clog/permissao/criarGrupo').'?id='.$row->id; ?>';">
									<input type="button" value="Gerenciar" onclick="location.href = '<?php echo BASE_URL('index.php/clog/permissao/editarGrupo').'?id='.$row->id; ?>';">
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