<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<h1>Consulta de Saída de Material <?php echo $tipo_saida == 0 ? "- Cautela" : "- Distribuição"; ;?></h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Filtrar Saída</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open("clog/cautelas/filtra_cautela", array('role'=>'form', 'class'=>'form-horizontal'));
						# Militar
						if (isset($tipo_saida) && $tipo_saida == 0) { ?>	
							<div class="form-group">
								<label for="search-militar-matricula" class="col-sm-2 control-label">Matrícula</label>
								<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
									<input type="text" rel="matricula" class="form-control input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula">
									<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">
								</div>
								<div class="col-sm-6">
									<label class="control-label" id="nome_militar"></label>
								</div>
							</div>
							<?php
						}
						# Setor
						if (isset($tipo_saida) && $tipo_saida > 0) { ?>
							<div class="form-group">
								<label for="setor_id" class="col-sm-2 control-label">Setor</label>
								<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
									<select name="setor_id" class="form-control" id="setor_id">
										<option value="0">Selecione o setor</option>
										<?php 
										foreach ($setores as $setor): ?>
											<option value="<?php echo $setor->id; ?>"><?php echo $setor->sigla; ?></option>
											<?php 
										endforeach; ?>
									</select>
								</div>
							</div>
							<?php
						} ?>
						<!-- Hidden com o tipo de saída -->
						<input type="hidden" class="form-control" id="distribuicao" name="distribuicao" value="<?php if (isset($tipo_saida)) echo $tipo_saida; ?>">
						<!-- Data inicial -->
						<div class="form-group">
							<label for="data" class="col-sm-2 control-label">Data Início</label>
							<div class="col-sm-2">
								<!--<input type="date" name="data_inicio" class="form-control input-sm" id="data" placeholder="Data cautela" title="">-->
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_inicio" class="form-control data" type="text" aria-describedby="calendar-add-on" rel="data" placeholder="Data inicial" readonly/>
								</div>
							</div><!--.col-->
						</div><!--.form-group-->
						<!-- Data final -->
						<div class="form-group">
							<label for="data" class="col-sm-2 control-label">Data Fim</label>
							<div class="col-sm-2">
								<!--<input type="date" name="data_fim" class="form-control input-sm" id="data" placeholder="Data cautela" title="">-->
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_fim" class="form-control data" type="text" aria-describedby="calendar-add-on" rel="data" placeholder="Data final" readonly/>
								</div>
								<?php
								if (isset($tipo_saida) && $tipo_saida == 0) { ?>
									<div class="checkbox">
										<input type="checkbox" name="concluida" value="0" checked><label for="concluida"> Em aberto</label>
									</div>
									<?php
								} ?>
							</div><!--.col-->
						</div><!--.form-group-->
						<!-- Submeter -->
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Consultar</button>
							</div><!--.col-->
						</div><!--.form-group-->
					<?php echo form_close(); ?>
				</div> <!-- .panel-->
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->