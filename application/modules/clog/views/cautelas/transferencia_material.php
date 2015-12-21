<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<h1>Transferência de Material para outro Estoque</h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lançar Transferência</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('clog/cautelas/transferir_material', array('role' => 'form', 'class' => 'form-horizontal')); ?>
						<!-- Recebedor -->
						<div class="form-group">
							<label for="search-militar-matricula" class="col-sm-3 control-label">Matrícula do Recebedor</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<input type="text" rel="matricula" class="form-control" id="search-militar-matricula" name="matricula" placeholder="Matrícula" title="Matrícula do recebedor" required>
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">
							</div>
							<div class="col-sm-6">
								<label class="control-label" id="nome_militar"></label>
							</div>
						</div>
						<!-- Estoque origem -->
						<div class="form-group">
							<label for="estoque_origem" class="col-sm-3 control-label">Almoxarifado de Origem</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="estoque_origem" class="form-control" id="estoque_origem" title="Estoque de origem do material" required>
									<option value="0">Selecione</option>
									<?php 
									if (!is_bool($estoques)) {
										foreach ($estoques->result() as $estoque) : ?>
											<option value="<?php echo $estoque->lotacoes_id; ?>"><?php echo $estoque->almoxarifado; ?></option>
										<?php endforeach; 
									} ?>
								</select>
							</div>
						</div>
						<!-- Estoque destino -->
						<div class="form-group">
							<label for="estoque_destino" class="col-sm-3 control-label">Setor Destino</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="estoque_destino" class="form-control" id="estoque_destino" title="Estoque destino do material" required>
									<option value="0">Selecione</option>
									<?php 
									if (!is_bool($setores)) {
										foreach ($setores->result() as $setor): ?>
											<option value="<?php echo $setor->id; ?>"><?php echo $setor->sigla; ?></option>
											<?php 
										endforeach; 
									}	?>
								</select>
							</div>
						</div>
						<!-- Data da Saída -->
						<div class="form-group">
							<label for="data_saida" class="col-sm-3 control-label">Data de saída</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_saida" id="data_saida" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data da saída" rel="date" title="Data em que saiu o material" readonly/>
								</div>
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