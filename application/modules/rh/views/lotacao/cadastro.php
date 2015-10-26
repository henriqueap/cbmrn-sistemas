<div class="container">
	<?php # echo "<pre>"; var_dump($lista_subordinados->result()); echo "</pre>"; die(); ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<h1><?= (!isset($data->id)) ? 'Cadastro de Lotação' : 'Editar Lotação'; ?></h1>
				<hr />
				<?php echo form_open('rh/lotacao/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
				<input type="hidden" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ""); ?>" />
				<input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />

				<div class="form-group">
					<label for="nome" class="col-sm-2 control-label">Seção</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
						<input type="text" name="nome" class="form-control" id="nome" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" placeholder="Seção"/>
					</div>
				</div><!--/.form-group-->

				<div class="form-group">
					<label for="sigla" class="col-sm-2 control-label">Sigla</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
						<input type="text" name="sigla" class="form-control" id="sigla" value="<?= set_value('sigla', isset($data->sigla) ? $data->sigla : ""); ?>" placeholder="Sigla" />
					</div>
				</div><!--/.form-group-->

				<div class="form-group">
					<label for="id_secao_superior" class="col-sm-2 control-label">Subordinado a</label>
					<div class="col-sm-12 col-md-6 col-lge-6 col-xs-12">
						<select name="id_secao_superior" id="id_secao_superior" class="form-control">
							<!-- Listar todos os setores ou seções. -->
							<option value="">Subordinado a</option>
							<?php foreach ($lista_subordinados->result() as $row): 
								if ($row->id == $data->superior_id) { ?>
									<option value="<?php echo $row->id; ?>" selected><?php echo $row->nome; ?></option>
									<?php 
								}
								else { ?>
									<option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
								<?php 
								} 
							endforeach; ?>
						</select>
					</div>
				</div><!--/.form-group-->

				<div class="form-group">
					<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 col-sm-offset-2">
						<input type="submit" value="Salvar" class="btn btn-primary" />
					</div>
				</div><!--/.form-group-->
				<?php echo form_close(); ?>
			</div>
		</div>
</div>