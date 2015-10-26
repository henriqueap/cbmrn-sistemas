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
				if (isset($grupo_id)) echo form_open('clog/permissao/editarGrupo', array('role'=>'form', 'class'=>'form-horizontal')); 
				else echo form_open('clog/permissao/novoGrupo', array('role'=>'form', 'class'=>'form-horizontal')); ?>
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
							<input type="text" name="grupo_nome" class="form-control" id="grupo_nome" value="<?php echo ""; ?>" placeholder="Grupo de permissão" required/>
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
</div> <!-- .container -->