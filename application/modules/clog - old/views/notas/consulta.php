
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Consulta de Notas Fiscais</h1>
			<hr>
		</div>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Consulta Notas</h3>
				</div>

				<div class="panel-body">
					<form action="#" method="post" class="form-horizontal" role="form"> 
						<div class="form-group">
							<label for="nota_fiscal" class="col-sm-2 control-label">N° Nota</label>
							<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
								<input type="text" name="nota_fiscal" id="nota_fiscal" class="form-control input-xs" rel="" placeholder="Número da Nota">
							</div>
						</div> <!-- .form-group -->

						<div class="form-group">
							<label for="data" class="col-sm-2 control-label">Data de Emissão</label>
							<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
								<!--<input type="date" name="data" id="data" class="form-control xs-input" rel="" placeholder="">-->
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data" id="data" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data de Emissão" rel="data" readonly required/>
									
								</div>
							</div>
						</div> <!-- .form-group -->

						<div class="form-group">
							<label for="empresas_id" class="col-sm-2 control-label">Empresa</label>
							<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
								<select class="form-control" name="empresas_id" id="empresas_id">
									<option value="0">Empresa</option>
									<?php foreach($empresas as $row): ?>
									<option value="<?php echo $row->id; ?>"><?php echo $row->nome_fantasia; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div> <!-- .form-group -->

						<div class="form-group">
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
			        	<button type="button" class="btn btn-default btn-xs" id="consulta-nota-fiscal">Consulta</button>
			        </div>
		        </div>
		      </form> <!--.form-->
				</div>
			</div>
		</div> <!-- .col-* -->
			<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="result-search">
			<!-- Resultado da consulta. -->
		</div> <!-- .Cols #result-search -->
	</div> <!--.row-->
</div> <!--.container-->
