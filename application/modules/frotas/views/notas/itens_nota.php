
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div> <!-- .col-* -->
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title">2° Cadastro de Itens na Nota Fiscal</h1>
				</div>

				<div class="panel-body">
					<?php echo form_open('clog/notas/itens_nota'.'/'.$info_nota->id, array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<input type="hidden" name="notas_fiscais_id" id="notas_fiscais_id" class="" value="<?php echo $info_nota->id; ?>"/>
						
						<div class="form-group">
			        <label for="valor_unitario" class="col-sm-2 control-label">Valor unitário</label>
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
		          	<input type="text" name="valor_unitario" class="form-control" id="valor_unitario" value="<?php echo ""; ?>" placeholder="Valor Unitário" required/>
			       	</div>
		        </div>

		        <div class="form-group">
			        <label for="quantidade_item" class="col-sm-2 control-label">Quantidade Itens</label>
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
		          	<input type="text" name="quantidade_item" class="form-control" id="quantidade_item" value="<?php echo ""; ?>" placeholder="Quantidade Itens" required/>
			       	</div>
		        </div>

		        <div class="form-group">
			        <label for="produtos_id" class="col-sm-2 control-label">Produtos</label>
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
		          	<select name="produtos_id" id="produtos_id" class="form-control">
		          		<option value="">Produtos</option>
		          		<?php foreach($produtos as $produtos): ?>
		          		<option value="<?php echo $produtos->id; ?>"><?php echo $produtos->modelo; ?></option>
		          		<?php endforeach; ?>
		          	</select>
			       	</div>
		        </div>

		        <div class="form-group">
		        	<label for="select-tombo" class="col-sm-2 control-label">Tipo Produto</label>
		        	<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
				        <select class="form-control" name="select-tombo" id="select-tombo">
				        	<option selected>Consumo</option>
				        	<option value="1">Permanente</option>
				        </select>
		        	</div>
		        </div>

		        <div class="form-group" id="div_numero_tombo">
		        	<label for="numero_tombo" class="col-sm-2 control-label">N° Tombo</label>
		        	<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
				        <textarea class="form-control" rows="5" name="numero_tombo" id="numero_tombo" placeholder="N° do Tombo separado por vírgula"></textarea>
		        	</div>
		        </div>

		        <div class="form-group">
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
			        	<button type="submit" class="btn btn-default">Adicionar Item</button>
			        </div>
		        </div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div> <!-- .col-* -->

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php echo form_open('', array(''=>'')); ?>
				<button type="button" class="btn btn-default" id="alerta" title="Click aqui para concluír a nota fiscal">Concluír nota fiscal</button>
			<?php echo form_close(); ?>
		</div>
			<br>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h1 class="panel-title"><?php echo "N° Nota: ".$info_nota->numero?></h1>
				</div>

				<div class="panel-body">
					<table class="table table-bordered table-condensed">
						<thead>
				      <tr>
			          <th>Produto</th>
			          <th>Valor unitário</th>
			          <th>Quantidade de Itens</th>
			          <th>Ações</th>
				      </tr>
					  </thead>
					  <tbody>
					  	<?php foreach($itens as $itens): ?>
					  	<tr>
					  		<td><?php echo $itens->modelo; ?></td>
					  		<td><?php echo $itens->valor_unitario; ?></td>
					  		<td><?php echo $itens->quantidade_item; ?></td>
					  		<td></td>
					  	</tr>
					  	<?php endforeach;?>
					  </tbody>
					</table>
					
					<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
						<label>Valor Total: R$ <?php echo "1,000.00"; ?></label>
					</div> <!-- Col-* -->
				</div> <!-- .panel-body -->
			</div>
		</div> <!-- .col-* -->
	</div>
</div>
