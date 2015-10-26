<div class="container">
	<div class="row">
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?=	(!isset($data[0]->id)) ? "<h1>Cadastro de ocorrências</h1>" : "<h1>Editar ocorrências</h1>"; ?>
			<hr>
			<?= form_open('ocorrencias/ocorrencias/salvar', array('form'=>'role', 'class'=>'form-horizontal')); ?>
				<!--.hidden-->
				<input type="hidden" name="id" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->id; ?>">
				
				<div class="form-group">
					<label for="domicilio" class="col-sm-2 control-label">Domicílio</label>
					<div class="col-sm-4">
						<input type="text" name="domicilio" class="form-control input-sm" id="domicilio" placeholder="Domicílio" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->domicilio; ?>" title="">
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="localidade" class="col-sm-2 control-label">Localidade</label>
					<div class="col-sm-4">
						<select name="localidade" class="form-control" id="localidade">
							<?php foreach($locais as $row): ?>
							<option value="<?php echo $row->id; ?>"  <?php echo (isset($data[0]->tipo_ocorrencias_id) AND $data[0]->tipo_ocorrencias_id == $row->id) ? "selected" : "" ;?> ><?php echo $row->cidade . ' - '. $row->localidade; ?></option>
							<?php endforeach; ?>
						</select>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="idade" class="col-sm-2 control-label">Idade</label>
					<div class="col-sm-2">
						<input type="number" name="idade" class="form-control input-sm" id="idade" placeholder="Idade da vítima" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->idade; ?>" title="">
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="data" class="col-sm-2 control-label">Data</label>
					<div class="col-sm-2">
						<input type="date" name="data" class="form-control input-sm" id="data" placeholder="Data ocorrência" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->data;?>" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="horario" class="col-sm-2 control-label">Horário</label>
					<div class="col-sm-2">
						<input type="text" name="horario" rel="hora" class="form-control input-sm" id="horario" placeholder="Horário ocorrência" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->data;?>" title="" required>
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
		</div><!--.col-->
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
	</div>
</div>