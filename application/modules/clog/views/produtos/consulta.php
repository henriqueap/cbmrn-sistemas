<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Consulta de Produtos</h1>
			<hr>
		</div> <!-- Cols -->

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Consulta Produtos</h3>
				</div>

				<div class="panel-body">
					<?php echo form_open('', array('class'=>'form-horizontal')); ?>
						<!-- Marca dos produtos -->
						<div class="form-group">
							<label for="marcas_produtos_id" class="col-sm-2 control-label">Marca</label>
							<div class="col-sm-12 col-md-5 col-lg-5 col-xs-12">
								<select name="marcas_produtos_id" class="form-control" id="marcas_produtos_id">
									<option value="">Selecione o Marca de Produtos</option>
									<?php foreach($marcas_produtos as $marcas_produtos): ?>
									<option value="<?php echo $marcas_produtos->id; ?>"><?php echo $marcas_produtos->marca; ?></option>
									<?php endforeach;?>
								</select>
							</div>
						</div> <!-- .form-group -->
						<!-- Grupo de produtos -->
						<div class="form-group">
							<label for="grupo_produtos" class="col-sm-2 control-label">Grupo de Produtos</label>
							<div class="col-sm-12 col-md-5 col-lg-5 col-xs-12">
								<select name="grupo_produtos" id="grupo_produtos" class="form-control">
									<option value="">Selecione o Grupo de Produtos</option>
									<?php foreach ($grupo_produtos as $grupo_produtos): ?>
									<option value="<?php echo $grupo_produtos->id; ?>"><?php echo $grupo_produtos->nome; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div> <!-- .form-group -->
						<!-- Produto -->
						<div class="form-group">
							<label for="modelo" class="col-sm-2 control-label">Produto</label>
							<div class="col-sm-12 col-md-5 col-lg-5 col-xs-12">
								<input type="text" name="modelo" id="modelo" class="form-control input-xs" placeholder="Nome produto"/>
							</div>
						</div> <!-- .form-group -->
						<!-- Consultar -->
						<div class="form-group">
			        <div class="col-sm-12 col-md-5 col-lg-5 col-xs-12 col-sm-offset-2">
			        	<button type="button" class="btn btn-default btn-xs" id="consulta-produtos">Consulta</button>
			        </div>
		        </div> <!-- .form-group -->
					<?php echo form_close(); ?>
				</div>
			</div> <!-- .panel -->
		</div> <!-- .Cols -->
			<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="result-search">
			<!-- Resultado consulta -->
		</div> <!-- .Cols -->
	</div>
</div>