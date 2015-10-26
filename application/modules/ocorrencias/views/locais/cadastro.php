<div class="container">
	<div class="row">
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?= (empty($data)) ? "<h1>Cadastro de Locais</h1>" : "<h1>Editar Locais</h1>"; ?>
			<hr>
			<?= form_open('ocorrencias/locais/salvar', array('form'=>'role', 'class'=>'form-horizontal', 'method'=>'POST')); ?>
				<!-- .hidden -->
				<input type="hidden" name="id" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->id; ?>">

				<div class="form-group">
					<label for="cidade" class="col-sm-2 control-label">Cidade</label>
					<div class="col-sm-4">

						<select name="cidade" class="form-control" id="cidade-consulta">
							<?php foreach ($cidades as $row): ?>
							<option value="<?= $row->cidade; ?>" <?php echo (isset($data[0]->id) AND $data[0]->cidade == $row->cidade) ? "selected" : "" ;?>><?= $row->cidade; ?></option>
							<?php endforeach; ?>
						</select>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<!--
				<div class="form-group">
					<label for="estado" class="col-sm-2 control-label">Estado</label>
					<div class="col-sm-4">
						<input type="text" name="estado" class="form-control input-sm" id="estado" placeholder="Estado Local" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->estado; ?>" title="" required>
					</div>
				</div>
				-->

				<div class="form-group">
					<label for="localidade" class="col-sm-2 control-label">Localidade</label>
					<div class="col-sm-4">
						<input type="text" name="localidade" class="form-control input-sm" id="localidade" placeholder="Localidade dentro da cidade" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->localidade; ?>" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="" class="col-sm-2 control-label"></label>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-default btn-sm">Salvar</button>
					</div><!--.col-->
				</div><!--.gorm-group-->
			<?= form_close(); ?>
		</div>
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
	</div>
</div>
