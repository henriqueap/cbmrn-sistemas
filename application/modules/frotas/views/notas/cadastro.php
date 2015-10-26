
<div class="container">
	<div class="well well-cadastro">
		<h3 class="form-signin-heading">Cadastro de Notas Fiscais.</h3>
		<div class="panel-body">
			<h4>1° Cadastro de Notas Fiscais</h4>
			</br>			  
			<?php echo form_open('frotas/notas/salvar', array('role'=>'form', 'class'=>'form-horizontal', 'id'=>'')); ?>
				<div class="form-group">
			        <label for="numero" class="col-sm-2 control-label">N° Nota Fiscal</label>
				    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
			          	<input type="text" name="numero" class="form-control" id="numero" value="<?php echo ""; ?>" placeholder="N° Nota Fiscal" required/>
				    </div>
		        </div>
		        <div class="form-group">
			        <label for="data" class="col-sm-2 control-label">Data de Emissão</label>
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
		          	<input type="date" name="data" class="form-control" id="data" value="<?php echo ""; ?>" placeholder="Data de Emissão" required/>
			        </div>
		        </div>

		        <div class="form-group">
			        <label for="empresas_id" class="col-sm-2 control-label">Fornecedor</label>
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
		          	<select name="empresas_id" class="form-control" id="empresas_id">
		          		<option>Selecione Empresa</option>
		          		<?php foreach($empresas as $row): ?>
		          		<option value="<?php echo $row->id; ?>"><?php echo $row->nome_fantasia; ?></option>
		          		<?php endforeach; ?>
		          	</select>
			        </div>
		        </div>
		        
		      	<div class="form-group">
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
			        	<button type="submit" class="btn btn-default" id="save-nota-fiscal">Salvar</button>
			        </div>
		        </div>
		    <?php echo form_close(); ?>
		</div>
	</div> <!-- .panel -->
</div> <!-- .col-* -->
	