<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-login">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php echo validation_errors('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>'); ?>
				
			</div>
			<center>
				<a href="<?php echo base_url(); ?>"><img src="http://www2.defesasocial.rn.gov.br/cbmrn/cbdocs/cbmrn.png" alt="CBMRN" id="cbmrn"></a>
			</center>
			
			<?php echo form_open('acesso/loggin', array('class'=>'form-horizontal', 'role'=>'form', 'method'=>'POST')); ?>
				<div class="control-group">
			    <label class="control-label" for="sistema">Sistemas</label>
			    <div class="controls">
			      <select name="sistema" class="form-control">
			      	<option value="">Escolha o sistema</option>
			      	<?php foreach($modulos->result() as $modulos): ?>
			      	<option value="<?php echo $modulos->id; ?>"><?php echo $modulos->nome; ?></option>
			      	<?php endforeach;?>
			      </select>
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <label class="control-label" for="matricula">Matricula</label>
			    <div class="controls">
			      <input type="text" id="matricula" name="matricula" rel="matricula" class="form-control" id="matricula"  placeholder="Matrícula do Militar" required />
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <label class="control-label" for="senha">Senha</label>
			    <div class="controls">
			      <input id="senha" name="senha" class="form-control" type="password" placeholder="Sua Senha">
			    </div>
			  </div>
			  
			  <div class="control-group">
			    <div class="controls">
			      <br>
			      <!--
			      	<label class="checkbox"><input type="checkbox" /> Lembrar senha</label>
			    	-->
			      <button class="btn btn-primary btn-sm" type="submit">Acessar</button>
			    </div>
			  </div>
			<?php echo form_close(); ?>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->