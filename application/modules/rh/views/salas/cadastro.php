<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12">
		<h1><?= isset($data->id) ? 'Editar Sala' : 'Cadastro de Sala'; ?></h1>
		<hr />
		<?php echo form_open('rh/salas/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
		<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />
		<input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />

		<div class="form-group">
			<label for="setor-select" class="col-sm-2 control-label">Seção</label>
			<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
				<select name="id_secao_superior" id="id_secao_superior" class="form-control" required>
					<!-- Listar todos os setores ou seções. -->
					<option value="">Seção</option>
					<?php foreach ($secoes->result() as $row): ?>
					<option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="nome" class="col-sm-2 control-label">Sala</label>
			<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
				<input type="text" name="nome" class="form-control" id="nome" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" placeholder="Nome da Sala"/>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12  col-sm-offset-2">
				<input type="submit" value="Salvar" class="btn btn-primary" />
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
