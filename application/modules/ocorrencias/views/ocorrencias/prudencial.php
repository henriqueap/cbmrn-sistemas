<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1><?= (!isset($data[0])) ? "Cadastro de ocorrências" : "Edição de ocorrências" ; ?></h1>
			<?= form_open('', array('role'=>'form', 'class'=>'form-horizontal')); ?>
				<input type="hidden" name="id" value="<?= (isset($data[0])) ? "" : "" ; ?>">
				<div class="form-group">
					<label for="data" class="col-sm-2 control-label">Data</label>
					<div class="col-sm-4">
						<input type="date" name="data" id="data" class="form-control input-sm" placeholder="Data">
					</div>
				</div>
				<div class="form-group">
					<label for="quantidade" class="col-sm-2 control-label">Quantidade</label>
					<div class="col-sm-4">
						<input type="number" name="quantidade" id="quantidade" class="form-control input-sm" placeholder="Quantidade de ocorrências" required>
					</div>
				</div>
				<div class="form-group">
					<label for="local" class="col-sm-2 control-label">Localidade</label>
					<div class="col-sm-4">
						<select name="localidade" class="form-control" id="localidade">
							<?php foreach($locais as $row): ?>
							<option value="<?php echo $row->id; ?>"  <?php echo (isset($data[0]->tipo_ocorrencias_id) AND $data[0]->tipo_ocorrencias_id == $row->id) ? "selected" : "" ;?> ><?php echo $row->cidade . ' - '. $row->localidade; ?></option>
							<?php endforeach; ?>
						</select>
					</div><!--.col-->
				</div><!--.gorm-group-->
				<div class="form-group">
					<label for="tipo_ocorrencia" class="col-sm-2 control-label">Tipo Ocorrência</label>
					<div class="col-sm-3">
						<select id="tipo_ocorrencia" class="form-control" name="tipo_ocorrencia">
							<?php foreach($tipo_ocorrencia as $row): ?>
							<option value="<?= $row->id; ?>"  <?php echo (isset($data[0]->gbs_locais_id) AND $data[0]->gbs_locais_id == $row->id) ? "selected" : "" ;?> ><?= $row->ocorrencia; ?></option>
							<?php endforeach; ?>
						</select>
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
	</div><!--/.row-->
</div><!--/.container-->