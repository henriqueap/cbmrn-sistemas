<div class="container">
	<div class="row">
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<form role="form" class="form-horizontal">
				<div class="form-group">
					<label for="idade" class="col-sm-2 control-label">Idade</label>
					<div class="col-sm-2">
						<input type="text" name="idade" class="form-control input-sm" id="idade" placeholder="Idade da vítima" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="cidade" class="col-sm-2 control-label">Localidade</label>
					<div class="col-sm-4">
						<select name="local" class="form-control" id="localidade">
							<option></option>
							<?php foreach($locais as $row): ?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->cidade . " - " . $row->localidade; ?></option>
							<?php endforeach; ?>
						</select>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="data" class="col-sm-2 control-label">Data Início</label>
					<div class="col-sm-2">
						<input type="date" name="data_inicio" class="form-control input-sm" id="data" placeholder="Data ocorrência" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="data" class="col-sm-2 control-label">Data Fim</label>
					<div class="col-sm-2">
						<input type="date" name="data_fim" class="form-control input-sm" id="data" placeholder="Data ocorrência" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="tipo_ocrrencia" class="col-sm-2 control-label">Tipo Ocorrência</label>
					<div class="col-sm-3">
						<select id="tipo_ocorrencia" class="form-control" name="tipo_ocorrencia">
							<option></option>
							<?php foreach($tipo_ocorrencia as $row): ?>
							<option value="<?= $row->id; ?>"><?= $row->ocorrencia; ?></option>
							<?php endforeach; ?>
						</select>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="" class="col-sm-2 control-label"></label>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default btn-xs" id="consulta-ocorrencias">Consulta</button>
						<button type="button" class="btn btn-default btn-xs" onclick="location.href = 'http://www2.defesasocial.rn.gov.br/cbmrn/new/index.php/ocorrencias/ocorrencias/consulta'">Limpar</button>
					</div><!--.col-->
				</div>
			</form>
		</div><!--.col-->
	
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="result-search">
			<!-- #result-search -->
		</div>
	</div>
</div>