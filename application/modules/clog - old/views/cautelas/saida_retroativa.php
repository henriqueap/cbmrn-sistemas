<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<h1>Saída de Material - Retroativa</h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lançar Saída</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('clog/cautelas/salvar_cautela', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<!-- Solicitante -->
						<div class="form-group">
							<label for="search-militar-matricula" class="col-sm-2 control-label">Matrícula</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<input type="text" rel="matricula" class="form-control input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required="required" title="Matrícula do solicitante">
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">                
							</div>
							<div class="col-sm-6">
								<label class="control-label" id="nome_militar"></label>
							</div>
						</div>
						<!-- Setor -->
						<div class="form-group">
							<label for="setor_id" class="col-sm-2 control-label">Setor</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="setor_id" class="form-control" id="setor_id" title="Setor solicitante">
									<option value="0">Selecione o setor</option>
									<?php 
									foreach ($setores as $setor): ?>
										<option value="<?php echo $setor->id; ?>"><?php echo $setor->sigla; ?></option>
										<?php 
									endforeach; ?>
								</select>
							</div>
						</div>
						<!-- Data da Saída -->
						<div class="form-group">
							<label for="data_saida" class="col-sm-2 control-label">Data de saída</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<!--<input type="date" name="data_prevista" id="data_devolucao" class="form-control input-sm" rel="date" title="Colocar data prevista apenas se for cautela"/>-->
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_saida" id="data_saida" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data da saída" rel="date" title="Data em que saiu o material" readonly required/>
								</div>
							</div>
						</div>
						<!-- Devolução prevista -->
						<div class="form-group">
							<label for="data_devolucao" class="col-sm-2 control-label">Devolução prevista</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<!--<input type="date" name="data_prevista" id="data_devolucao" class="form-control input-sm" rel="date" title="Colocar data prevista apenas se for cautela"/>-->
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_prevista" id="data_devolucao" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data prevista" rel="date" title="Data prevista para devolução, se for cautela" readonly required/>
								</div>
							</div>
							<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
								<h6>* Colocar data prevista apenas se for cautela</h6>
							</div>
						</div>
						<!-- Submeter -->
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Iniciar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div> <!-- .panel-->
			</div>
		</div>
		
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
		</div><!---->
	</div>
</div>