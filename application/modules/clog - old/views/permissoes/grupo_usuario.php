<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Gerenciar Permissões de Usuário</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-body">
				<?php echo form_open('clog/permissao/darPermissao', array('role'=>'form', 'class'=>'form-horizontal')); ?>
				<div class="form-group">
					<label for="militares_id" class="col-sm-2 control-label">Militar</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
					<select name="militares_id" class="form-control" id="militares_id">
						<option value="0">Selecione o Militar</option>
						<?php foreach($militares as $row): ?>
						<option value="<?php echo $row->idmilitar; ?>"><?php echo $row->militar; ?></option>
						<?php endforeach; ?>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label for="grupos_id" class="col-sm-2 control-label">Grupo de permissões</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
					<select name="grupos_id" class="form-control" id="grupos_id">
						<option value="0">Selecione o Grupo de Permissões</option>
						<?php foreach($grupos as $row): ?>
						<option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
						<?php endforeach; ?>
					</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
						<button type="submit" class="btn btn-default">Salvar</button>
					</div>
				</div>
			  <?php echo form_close(); ?>
			  </div>
			</div>
		</div>
	</div> <!-- .row -->
	<div id="lista_permissoes_usuario" class="row">
	</div><!--row-->
</div> <!-- .container -->