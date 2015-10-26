<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<h1>Controle do Patrimônio das Salas </h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Lançar Patrimônio da Sala</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('clog/cautelas/patrimonio_salas', array('role' => 'form', 'class' => 'form-horizontal')); ?>
						<!-- Data da Saída -->
						<div class="form-group">
							<label for="data_saida" class="col-sm-2 control-label">Data Lançamento</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_lancamento" id="data_lancamento" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data" rel="date" title="Data em que foi lançado no sistema" readonly/>
								</div>
							</div>
						</div>
						<!-- Estoque -->
						<div class="form-group">
							<label for="setores" class="col-sm-2 control-label">Origem</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="setores" class="form-control" id="setores" title="Almoxarifado origem do material">
									<option value="0">Selecione</option>
										<?php 
										if(!is_bool($setores)) {
											foreach ($setores->result() as $setor): ?>
												<option value="<?php echo $setor->lotacoes_id; ?>" <?php echo ($setor->lotacoes_id == 23)? "selected" : ""; ?>><?php echo $setor->almoxarifado; ?></option>
											<?php endforeach; 
										} ?>
								</select>
							</div>
						</div>
						<!-- Sala -->
						<div class="form-group">
							<label for="salas" class="col-sm-2 control-label">Sala</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="salas" class="form-control" id="salas" title="Nome da Sala" required>
									<option value="0">Selecione</option>
									<?php 
									if (!is_bool($salas)) {
										foreach ($salas->result() as $sala): ?>
											<option value="<?php echo $sala->id; ?>"><?php echo $sala->nome; ?></option>
											<?php 
										endforeach; 
									}	?>
								</select>
							</div>
						</div>
						<!-- Tombo -->
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Tombo</label>
              <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <input type="text" name="tombo" id="tombo" class="form-control input-sm" placeholder="Nº Tombo" required="required" title="Colocar o número de tombo"/>
                <input type="hidden" class="form-control input-xs" id="distro_id" name="distro_id" value="<?php ?>">
              </div>
              <div class="col-sm-6">
                <label class="control-label" id="tombo_info"></label>
              </div>
            </div>
						<!-- Recebedor -->
						<div class="form-group">
							<label for="search-militar-matricula" class="col-sm-2 control-label">Recebedor</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<input type="text" rel="matricula" class="form-control" id="search-militar-matricula" name="matricula" placeholder="Matrícula" title="Matrícula do recebedor" required>
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="militar_id" value="<?php ?>">
							</div>
							<div class="col-sm-6">
								<label class="control-label" id="nome_militar"></label>
							</div>
						</div>
						<!-- Submeter -->
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Salvar</button>
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