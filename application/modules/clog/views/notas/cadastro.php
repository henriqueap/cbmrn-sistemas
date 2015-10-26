<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Cadastro de Notas Fiscais</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">  
				<div class="panel-heading">
					<h3 class="panel-title">1° Passo: Cadastro de Notas Fiscais</h3>
				</div>

				<div class="panel-body">
					<?php echo form_open('clog/notas/salvar', array('role'=>'form', 'class'=>'form-horizontal', 'id'=>'')); ?>
						<div class="form-group">
							<label for="numero" class="col-sm-2 control-label">N° Nota Fiscal</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="numero" class="form-control" id="numero" value="<?php echo ""; ?>" placeholder="N° Nota Fiscal" required/>
							</div>
						</div>

						<div class="form-group">
							<label for="tipo_nota" class="col-sm-2 control-label">Tipo de Nota</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="hidden" name="tipo_nota_fiscal" id="tipo_nota_fiscal" value="0">
								<div class="btn-group" id="tipo_nota">
									<button type="button" class="btn btn-default active" id="btn-compra" value="" >Material</button>
									<button type="button" class="btn btn-default" id="btn-servico" value="">Serviço</button>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="data" class="col-sm-2 control-label">Data de Emissão</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<!--<input type="date" name="data" class="form-control" id="data" value="<?php echo "" ?>" placeholder="Data de Emissão" required/>-->
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data de Emissão" rel="data" readonly required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="empresas_id" class="col-sm-2 control-label">Fornecedor</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select multiple name="empresas_id" class="form-control" id="empresas_id">
									<?php foreach($empresas as $row): ?>
									<option value="<?php echo $row->id; ?>"><?php echo $row->nome_fantasia; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default" id="save-nota-fiscal">Salvar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div> <!-- .panel -->
		</div> <!-- .col-* -->
	</div> <!-- .row -->
	<hr>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php # echo ""; ?>
			<h3>Notas fiscais ainda não concluídas.</h3>
				<hr>
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th># </th>
						<th>N° Nota</th>
						<th>Valor Atual</th>
						<th>Data</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php if(count($info_notas_fiscais) > 0): foreach ($info_notas_fiscais as $info_notas_fiscais): ?>
					<tr>
						<td><?php echo $info_notas_fiscais->id; ?></td>
						<td><?php echo $info_notas_fiscais->numero; ?></td>
						<td><?php echo $info_notas_fiscais->valor; ?></td>
						<td><?php echo $info_notas_fiscais->data; ?></td>
						<td>
							<a href="<?php echo base_url("index.php/clog/notas/itens_nota/$info_notas_fiscais->id"); ?>" class="btn btn-default btn-sm">Continuar Nota</a>
						</td>
					</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div><!--col-->
	</div><!--row-->
</div> <!-- .container -->
