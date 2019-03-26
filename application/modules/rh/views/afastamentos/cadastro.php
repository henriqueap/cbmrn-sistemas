
<div class="container">
		<div class="col-lg-12 col-md-12 col-xs-12">
				<h1><?= (!isset($data->id)) ? 'Cadastro de Afastamento de Militar' : 'Editar Afastamento de Militar'; ?></h1>
				<hr />
				<?php echo form_open('rh/afastamentos/salvar/', array('role' => 'form', 'class' => 'form-horizontal', 'method'=>'POST')); ?>
				<!--hidden-->
				<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />
				<input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />

				<div class="form-group">
						<label for="matricula" class="col-sm-2 control-label">Matrícula</label>
						<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<input type="text" rel="matricula" class="form-control input-xs" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required />
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id" name="chefe_militares_id" />                
						</div>
						<div class="col-sm-6">
								<label class="control-label" id="nome_militar"></label>
						</div>
				</div>

				<div class="form-group">
						<label for="tipo_afastamentos_id" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Tipo de Afastamentos</label>
						<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
								<select name="tipo_afastamentos_id" class="form-control" id="tipo_afastamentos_id">
										<option value="">Tipo de afastamentos</option>
										<?php foreach($listar_afastamentos->result() as $afastamentos) : ?>
										<option value="<?php echo $afastamentos->id; ?>"><?php echo $afastamentos->nome; ?></option>
										<?php endforeach; ?>
								</select>
						</div>
				</div>

				<div class="form-group">
						<label for="data_inicio" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Data de início</label>
						<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
								<input type="date" name="data_inicio" class="form-control" id="data_inicio" value="<?= set_value('data_inicio', isset($data->data_inicio) ? $data->data_inicio : ""); ?>" placeholder="" required />
						</div>
				</div>

				<div class="form-group">
						<label for="data_fim" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Quantidade de dias</label>
						<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
								<input type="text" name="data_fim" class="form-control" id="data_fim" value="<?= set_value('data_fim', isset($data->data_fim) ? $data->data_fim : ""); ?>" placeholder="Quantidade de dias" />
						</div>
				</div>

				<div class="form-group">
						<label for="numero_processo" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">N° Processo</label>
						<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
							<input type="text" name="numero_processo" class="form-control" id="numero_processo" value="<?= set_value('numero_processo', isset($data->numero_processo) ? $data->numero_processo : ""); ?>" placeholder="N° Processo" />
						</div>
				</div>

				<div class="form-group">
						<label for="justificativas" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Justificativas</label>
						<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
								<textarea name="justificativas" class="form-control" id="justificativas" rows="7" placeholder="Justificativas para o afastamento"></textarea>
						</div>
				</div>
				
				<div class="form-group">
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<input type="submit" value="Salvar" class="btn btn-primary" />
						</div>
				</div>
				<?php echo form_close(); ?>
		</div>
</div>