<div class="container">
	<div class="well well-cadastro" > 
	<?php echo form_open('frotas/viaturas/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
		<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" /> 

		<h3 class="form-signin-heading">Cadastro de Viatura</h3> 
		<div class="panel-body"> 
			<form class="form-horizontal" role="form">
				<div class="form-group">
					<label for="txtPlaca" class="col-sm-2 control-label">Placa</label>
					<div class="col-sm-2">
						<input  type="text" rel="placa" style="text-transform: uppercase" class="form-control"  rel="placa" id="txtPlaca" name="txtPlaca" placeholder="Ex: KWY-1548" required>
					</div>    
				</div>
				<div class="form-group">
				  <label for="txtPrefixo" class="col-sm-2 control-label">Prefixo</label>
				  <div class="col-sm-2">
						<input type="text" rel="prefixo" class="form-control" style="text-transform: uppercase" rel="prefixo" id="txtPrefixo" name="txtPrefixo" placeholder="Ex: AB-01" required>
				  </div>    
				</div>
				<div class="form-group">
						<label for="selTipo" class="col-sm-2 control-label">Tipo de Viatura</label>
					<div class="col-sm-3">
						<select  class="form-control input-sm" id="selTipo" name="selTipo">
							<?php foreach ($listar_tipo_viaturas->result() as $tipo_viaturas ) : ?> 
								<option value="<?php echo $tipo_viaturas->id; ?>"><?php echo $tipo_viaturas->tipo; ?></option>
							<?php endforeach; ?>
					  </select>
					</div>
				</div>
				<div class="form-group">
					<label for="selMarca" class="col-sm-2 control-label">Marca</label>
					<div class="col-sm-4">
						<select class="form-control input-sm" id="selMarca" name"selMarca" >
							<option value="0" selected>Selecione a marca</option>
							<?php foreach($listar_marcas->result() as $marcas) : ?>
								<option value="<?php echo $marcas->id; ?>"><?php echo $marcas->nome; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-group" id="selModelo"></div>

				<div class="form-group">
					<label for="selAnoFab" class="col-sm-2 control-label">Ano de Fabricação</label>
					<div class="col-sm-2">
						 <select  class="form-control input-sm" id="selAnoFab" name="selAnoFab">
							<?php for($i=2014; $i>=1965; $i-- ){?>
								<option value="<?php echo $i?>"><?php echo $i?></option>                        
							<?php }?> 
						 </select>
					</div>
				</div>

				<div class="form-group">
						<label for="selAnoMod" class="col-sm-2 control-label">Ano do Modelo</label>
					<div class="col-sm-2">
						 <select  class="form-control input-sm" id="selAnoMod" name="selAnoMod">
							<?php for($i=2014; $i>=1965; $i-- ){?>
								<option value="<?php echo $i?>"><?php echo $i?></option>                        
							<?php }?> 
					   </select>
					</div>
				</div>

				<div class="form-group">
						<label for="selTracao" class="col-sm-2 control-label">Tração</label>
					<div class="col-sm-2">
						 <select class="form-control input-sm" id="selTracao" name="selTracao" >
							<option value="0" selected>Selecione</option>
							<option value="2WD">2WD</option>
							<option value="4WD">4WD</option>
							<option value="-">-</option>
						</select>
					</div>
				</div>

				<div class="form-group">
				  <label for="txtNumero" class="col-sm-2 control-label">Número do chassis</label>
				  <div class="col-sm-3">
						 <input type="text" class="form-control" rel="chassis" style="text-transform: uppercase" id="txtNumero" name="txtNumero" placeholder="Ex: 9BWZZZ377VT004251" required>
				  </div>    
				</div>

				<div class="form-group">
				  <label for="txtRenavam" class="col-sm-2 control-label">Código RENAVAM</label>
				  <div class="col-sm-2">
						 <input type="text" class="form-control" rel="renavam" id="txtRenavam" rel="renavam" name="txtRenavam" placeholder="Ex: 12345678901-2" required>
				  </div>    
				</div>

				<div class="form-group">
						<label for="selCor" class="col-sm-2 control-label">Cor</label>
					<div class="col-sm-3">
						<select class="form-control input-sm" id="selCor" name="selCor">
							<option value="0" selected>Selecione</option>
							<option value="Vermelha">Vermelha</option>
							<option value="Branca">Branca</option>
							<option value="Prata">Prata</option>
						</select>
					</div>
				</div>

				 <div class="form-group">
						<label for="selSetor" class="col-sm-2 control-label">Setor</label>
				   <div class="col-sm-2">
						<select class="form-control input-sm" id="selSetor" name="selSetor" >
							<option value="0" selected>Sem Setor</option>
							<?php foreach ($setor_lotacao->result() as $lotacao): ?>
							<option value="<?php echo $lotacao->id; ?>"><?php echo $lotacao->nome; ?></option>
							<?php endforeach; ?>
						</select>
				   </div>
				</div>

				 <div class="form-group">
						<label for="selCombustivel" class="col-sm-2 control-label">Tipo de Combustível</label>
					<div class="col-sm-2">
						<select class="form-control input-sm" id="selCombustivel" name="selCombustivel" >
							<option value="0" selected>Selecione</option>
							<?php foreach($tipo_combustivel->result() as $combustivel) : ?> 
							<option value="<?php echo $combustivel->id; ?>"><?php echo $combustivel->nome; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-group">
						<label for="selChip" class="col-sm-2 control-label">Possui CHIP</label>
					<div class="col-sm-2">
						<select class="form-control input-sm" id="selChip" name="selChip" >
							<option selected>Selecione</option>
							<option value="0">Não</option>
							<option value="1">Sim</option> 
						</select>
					</div>
				</div>

				<div class="form-group">
				  <label for="txtLitros" class="col-sm-2 control-label">Cota combustível</label>
				  <div class="col-sm-2">
						 <input type="text" class="form-control" id="txtLitros" name="txtLitros" placeholder="Litros" required>
				  </div>    
				</div>

				<div class="form-group">
				  <label for="txtOleo" class="col-sm-2 control-label">Troca de óleo a cada</label>
				  <div class="col-sm-2">
						 <input type="text" class="form-control" id="txtOleo" name="txtOleo" placeholder="Km" required>
				  </div>    
				</div>

				<div class="form-group">
				  <label for="txtRevisa" class="col-sm-2 control-label">Revisão a cada</label>
				  <div class="col-sm-2">
						 <input type="text" class="form-control" id="txtRevisa" name="txtRevisa" placeholder="Km" required>
				  </div>    
				</div>

				 <div class="form-group">
						<label for="selOrigem" class="col-sm-2 control-label">Origem</label>
					<div class="col-sm-4">
						<select class="form-control input-sm" id="selOrigem" name="selOrigem" >
							<option selected>Selecione</option>
							<option value="Aquisição por licitação">Aquisição por licitação</option>
							<option value="Convênio - IDEMA">Convênio - IDEMA</option>
							<option value="Convênio - SENASP">Convênio - SENASP</option>
							<option value="Doação - DETRAN">Convênio - DETRAN</option>
							<option value="Doação - Educação">Doação - Educação</option>
							<option value="Doação - INFRAERO">Doação - INFRAERO</option>
							<option value="Doação - Governo Federal">Doação - Governo Federal</option>
							<option value="Doação - Polícia Militar">Doação - Polícia Militar</option>
							<option value="Doação - Receita Federal">Doação - Receita Federal</option>
							<option value="Doação - UFRN">Doação - UFRN</option>
						</select>
					</div>
				</div>

				<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" >
						<center>
						<a class="btn btn-info" href="<?php echo base_url('index.php/frotas/index'); ?>" role="button">Home</a>
					</center>
				</div>
				 
				<div class="col-lg-1"> 
					<center>
						<input type="submit" value="Enviar" class="btn btn-success" />
					</center>
				</div>
			</form>
		</div>    
	   <?php echo form_close(); ?> 
	</div> 
</div>