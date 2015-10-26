<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Cadastro de Boletins Gerais</h1>
		</div>
	</div><!--.row-->
		<div class="panel-body"> 
			<?php echo form_open_multipart('publico/publico/cadastro', array('id' => 'template-add-form', 'class' => 'form-horizontal')); ?>
    			<?php echo form_fieldset('Dados do Cadastro', array('class' => '')); ?>
					<div class="form-group">
				      	<label for="dataIni" class="col-sm-3  control-label">Número Boletim:</label>
				      	<div class=" col-sm-3 ">
				      		
				        	<input type="text" class="form-control" name="cod" id="cod" rel='cod' required >
				      	</div>  	
				    </div>
			    	<div class="form-group">
				      	<label for="dataIni" class="col-sm-3  control-label">Data em que foi gerado:</label>
				      	<div class=" col-sm-3 ">
				        	<input type="date" class="form-control" name="dataIni" id="dataIni" placeholder="" required>
				      	</div>  	
				    </div>
					<div class="form-group">
			      		<label for="dataPub" class="col-sm-3  control-label">Data em que foi publicado:</label>
				      	<div class=" col-sm-3 ">
				        	<input type="text" class="form-control" name="dataPub" id="dataPub" value="<?php echo date('d/m/Y')?>" disabled/>
				      	</div>  	
				    </div>
				    <div class="form-group">
					   <div class="control-group">
					        <div class="controls col-sm-9 pull-right">
					            <input id="ckbExtra" name="ckbExtra" type="checkbox" value="0" onclick="">
                            	<label for="ckbExtra">Boletim Extra.</label>
					        </div>
				    	</div> 
					</div>
				    <div class="form-group">
					   <div class="control-group">
					        <div class="controls ">
					            <input type="file" name="boletimUpload" style="
    padding-left: 15pc;"/>
					        </div>
				    	</div> 
					</div>
	                <div align="right" class="col-lg-6 col-md-6 col-sm-6 col-xs-6 "> 
	                     <input type="submit" name="add" value="Enviar" class="btn btn-danger align-right" >
	                </div>
			<?php echo form_close ();?>	
	</div>
</div>