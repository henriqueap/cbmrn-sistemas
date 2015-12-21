<?php #foreach($produtos as $produto): var_dump($produto); endforeach; ?>
<div class="container">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h1>Entrada de Material Avulsa
	</h1>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div> <!-- .col-* -->		
		<?php //if($info_nota->concluido == 0): ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1 class="panel-title">Formulário para Entrada de Material Avulsa</h1>
					</div>

					<div class="panel-body">
						<?php echo form_open('clog/notas/entrada_avulsa', array('role'=>'form', 'class'=>'form-horizontal')); ?>
							<!--<input type="hidden" name="notas_fiscais_id" id="notas_fiscais_id" class="" value="<?php //echo $info_nota->id; ?>"/>-->
							<!-- Estoque -->
							<div class="form-group">
								<label for="setores" class="col-sm-2 control-label">Almoxarifado</label>
								<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
									<select name="setores" class="form-control" id="setores" title="Almoxarifado destino do material">
										<option value="0">Selecione</option>
											<?php 
											if(!is_bool($setores)) {
												foreach ($setores->result() as $setor): ?>
													<option value="<?php echo $setor->id; ?>" <?php echo ($setor->id == 23)? "selected" : ""; ?>><?php echo $setor->sigla; ?></option>
												<?php endforeach; 
											} ?>
									</select>
								</div>
							</div>
							<!-- Produto -->
							<div class="form-group">
								<label for="produtos" class="col-sm-2 control-label">Produtos</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
									<select name="produtos" class="form-control" id="produtos" title="Modelo do Produto">
										<option value="">Produtos</option>
										<?php 
										if (!is_bool($produtos)) {
											foreach($produtos->result() as $produto): ?>
											<option value="<?php echo $produto->id; ?>"><?php echo $produto->modelo; ?></option>
											<?php endforeach; 
										}	?>
									</select>
								</div>
							</div>
							<!-- Quantidade -->
							<div class="form-group">
								<label for="quantidade" class="col-sm-2 control-label">Quantidade</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
									<input type="text" name="quantidade" class="form-control" id="quantidade" value="<?php echo ""; ?>" placeholder="Quantidade do Produto" required>
								</div>
							</div>
							<!-- Tombos -->
							<div class="form-group" id="div_numero_tombo">
								<label for="numero_tombo" class="col-sm-2 control-label">N° Tombo</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
									<textarea class="form-control" rows="5" name="numero_tombo" id="numero_tombo" placeholder="Número(s) de tombo" title="Os tombos (ex: 1000) ou intervalos (ex: 1000-1010) devem ser separados por vírgula"></textarea>
									<h6>* Os tombos (ex: 1000) ou intervalos (ex: 1000-1010) devem ser separados por vírgula</h6>
								</div>
							</div>
							<!-- Cor dos Tombos -->
							<div class="form-group">
								<label for="tipo_tombo" class="col-sm-2 control-label">Tipo do Tombo</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
									<select name="tipo_tombo" class="form-control" id="tipo_tombo" title="Cor do tipo do tombo">
										<option value="">Cores</option>
										<option value="vermelho">Vermelho</option>
										<option value="amarelo">Amarelo</option>
										<option value="azul">Azul</option>
									</select>
								</div>
							</div>
							<!-- Botão salvar -->
							<div class="form-group">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
									<button type="submit" class="btn btn-default">Salvar</button>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- .col-* -->
	</div> <!--/.row-->
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h1>Últimas Entradas Avulsas </h1>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th>Ordem</th>						
						<th>Produto</th>
						<th>Tipo</th>
						<th>Quantidade</th>
						<th>Incluído por</th>
						<th>Data</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (! is_bool($entradas)) {
						foreach($entradas->result() as $entrada): ?>
							<tr>
								<td><?php echo $entrada->id; ?></td>
								<td><?php echo $entrada->produto; ?></td>
								<td><?php echo "Material ".(($entrada->consumo == 0) ? 'de Consumo' : ' Permanente'); ?></td>
								<td><?php echo $entrada->quantidade; ?></td>
								<td><?php echo $entrada->militar; ?></td>
								<td><?php echo $entrada->data_inclusao; ?></td>
							</tr>
						<?php endforeach; 
					} ?>
				</tbody>
			</table>
		</div> <!-- .col-* -->
	</div> <!--/.row-->
</div> <!--/.container-->