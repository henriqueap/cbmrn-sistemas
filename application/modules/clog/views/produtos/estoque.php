<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Gerenciamento de Estoque</h1>
			<hr>
		</div> <!-- .Cols -->
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Consulta Estoque</h3>
				</div>
				<!-- Marca dos produtos -->
				<div class="panel-body">
					<form action="#" method="POST" class="form-horizontal" role="form">
						<!-- Marca dos produtos -->
						<div class="form-group">
							<label for="modelo" class="col-sm-2 control-label">Marca</label>
							<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
								<select name="marcas_produtos_id" id="marcas_produtos_id" class="form-control">
									<option value="">Selecione a marca</option>
									<?php foreach($marcas as $marcas): ?>
									<option value="<?php echo $marcas->id; ?>"><?php echo $marcas->marca; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div> <!-- .form-group -->
						<!-- Produto -->
						<div class="form-group">
							<label for="modelo" class="col-sm-2 control-label">Produto</label>
							<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
								<input type="text" name="modelo" id="modelo" class="form-control input-xs" rel="" placeholder="Nome ou Modelo do Produto"/>
							</div>
						</div> <!-- .form-group -->
						<!-- Tipo produto -->
						<div class="form-group">
							<label for="tipo_produto" class="col-sm-2 control-label">Tipo de Produto</label>
							<div class="col-sm-12 col-md-5 col-lg-5 col-xs-12">
								<select name="tipo_produto" class="form-control" id="tipo_produto">
									<option value="">Todos</option>
									<option value="0">Consumo</option>
									<option value="1">Permanente</option>
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
						<!-- Almoxarifado -->
						<div class="form-group">
							<label for="lotacoes_id" class="col-sm-2 control-label">Almoxarifado</label>
							<div class="col-sm-12 col-md-5 col-lg-5 col-xs-12">
								<select  name="lotacoes_id" class="form-control" id="lotacoes_id">
									<option value="">Selecione o Setor</option>
									<?php foreach($setores as $setor): ?>
									<option value="<?php echo $setor->id; ?>"><?php echo $setor->sigla; ?></option>
									<?php endforeach;?>
								</select>
								<!-- Estoque vazio -->
								<div class="checkbox">
		              <input type="checkbox" id="zerados" name="zerados" value="1"><label for="zerados" class="control-label"> Incluir produtos com estoque vazio</label>
		            </div>
							</div>
						</div> <!-- .form-group -->
						<!-- Consultar -->
						<div class="form-group">
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
			        	<button type="button" class="btn btn-default btn-xs" id="consulta-estoque" title="Consultar Produtos em Estoque">Consulta</button>
			        </div>
		        </div> <!-- .form-group -->
		      </form>
				</div>
			</div> <!-- .panel -->
		</div> <!-- .Cols -->
			<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="result-search">
			<!-- Exibir consultas. -->
		</div> <!-- .Cols -->
</div> <!-- .container -->