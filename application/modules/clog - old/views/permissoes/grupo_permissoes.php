<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Gerenciar Grupo</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-body">
				<?php echo form_open('clog/permissao/gerenciarGrupo', array('role'=>'form', 'class'=>'form-horizontal')); ?>
				<div class="form-group">
					<label for="grupos_id" class="col-sm-2 control-label">Grupo de permissões</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
						<?php if (! $grupos_id) { ?>
							<select name="grupos_id" class="form-control" id="grupos_id">
								<option value="0">Selecione o Grupo de Permissões</option>
								<?php foreach($grupos as $row): ?>
								<option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
								<?php endforeach; ?>
							</select>
							<?php
						} 
						else { ?>
							<input type="text" name="grupo" class="form-control" id="grupo" value="<?php echo $grupos->nome; ?>" disabled />
							<input type="hidden" name="grupos_id" class="form-control" id="grupos_id" value="<?php echo $grupos_id; ?>" />
							<?php
						} ?>
					</div>
				</div>
				<div class="form-group">
					<label for="permissoes_id" class="col-sm-2 control-label">Permissão</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
					<select name="permissoes_id" class="form-control" id="permissoes_id">
						<option value="0">Selecione a permissão</option>
						<?php 
						if (isset($permissoes_grupo)) {
							# Criando um array com as permissões que o grupo possui
							foreach ($permissoes_grupo as $permissao):
								$grupo_permissoes[] = $permissao->permissoes_id;
							endforeach;
							# Carregando as permissões
							foreach($permissoes as $row): 
								# Testando se a permissão existe no array $grupo_permissoes
								if (FALSE === array_search($row->permissoes_id, $grupo_permissoes)) { ?>
									<option value="<?php echo $row->permissoes_id; ?>"><?php echo $row->permissao." (".$row->sigla_modulo.")"; ?></option>
									<?php 
								}
							endforeach; 
						}
						else {
							foreach($permissoes as $row): ?>
								<option value="<?php echo $row->permissoes_id; ?>"><?php echo $row->permissao." (".$row->sigla_modulo.")"; ?></option>
								<?php 
							endforeach;
						} ?>
					</select>
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
	<?php 
	if (FALSE !== $grupos_id && isset($permissoes_grupo)) { ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<hr>
				<h3>Permissões do Grupo</h3>
				<hr>
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th># </th>
							<th>Permissão</th>
							<th>ID</th>
							<th>Módulo</th>
							<th>Página</th>
							<th>Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if(count($permissoes_grupo) > 0): 
							$count = 1;
							foreach ($permissoes_grupo as $permissao): ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $permissao->permissao; ?></td>
									<td><?php echo $permissao->permissoes_id; ?></td>
									<td><?php echo $permissao->modulo; ?></td>
									<td><?php echo $permissao->pagina; ?></td>
									<td>
										<button type="button" id="btn-excluir" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal-excluir" onclick="$('#bt-modal-confirmar-exclusao').attr('href','<?php echo base_url("index.php/clog/permissao/excluir_permissao/$permissao->permissoes_id/$permissao->grupos_permissoes_id"); ?>');">Excluir</button>
									</td>
								</tr>
								<?php 
							endforeach; 
						endif; ?>
					</tbody>
				</table>
			</div><!--col-->
		</div><!--row-->
		<?php
	} 
	else { ?>
		<div id="lista_permissoes_grupo" class="row">
		</div><!--row-->
		<?php
	} ?>
</div> <!-- .container -->