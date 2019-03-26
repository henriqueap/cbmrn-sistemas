<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<h1>Consultar Patrimônio de Salas</h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Filtrar Saída</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open("clog/cautelas/listar_patrimonio_sala", array('role' => 'form', 'class' => 'form-horizontal')); ?>
						<!--Militar-->
						<!--<div class="form-group">
							<label for="search-militar-matricula" class="col-sm-2 control-label">Responsável</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<input type="text" rel="matricula" class="form-control input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula">
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">
							</div>
							<div class="col-sm-6">
								<label class="control-label" id="nome_militar"></label>
							</div>
						</div> -->
						<!-- Sala -->
						<div class="form-group">
							<label for="setor_id" class="col-sm-2 control-label">Sala</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="salas_id" class="form-control" id="salas_id">
									<option value="0">Selecione a sala</option>
									<?php
									if (isset($salas) && (!is_bool($salas))) {
										foreach ($salas->result() as $sala): ?>
											<option value="<?php echo $sala->id; ?>"><?php echo $sala->nome; ?></option>
											<?php 
										endforeach; 
									}	?>
								</select>
							</div>
						</div>
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