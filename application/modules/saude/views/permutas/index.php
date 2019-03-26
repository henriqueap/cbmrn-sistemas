
<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<h1>Controle de Permutas </h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Cadastrar Permuta</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('permutas/cadastrar_permuta', array('role' => 'form', 'class' => 'form-horizontal')); ?>
						<!-- Data do Serviço -->
						<div class="form-group">
							<label for="data_servico" class="col-sm-2 control-label">Serviço do Dia</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<div class="input-group">
									<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
									<input name="data_servico" id="data_servico" class="form-control data" type="text" aria-describedby="calendar-add-on" placeholder="Data" rel="date" title="Data do serviço" readonly/>
								</div>
							</div>
						</div>
						<!-- Permutado -->
						<div class="form-group">
							<label for="permutados_id" class="col-sm-2 control-label">Militar Permutado</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="permutados_id" class="form-control" id="permutados_id">
									<option value="0">Selecione o Militar que sai</option>
									<?php 
									if (isset($militares)) {
										foreach($militares as $row): ?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->militar; ?></option>
										<?php endforeach; 
									} ?>
								</select>
							</div>
						</div>
						<!-- Permutante -->
						<div class="form-group">
							<label for="permutantes_id" class="col-sm-2 control-label">Militar Permutante</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="permutantes_id" class="form-control" id="permutantes_id">
									<option value="0">Selecione o Militar que entra</option>
									<?php 
									if (isset($militares)) {
										foreach($militares as $row): ?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->militar; ?></option>
										<?php endforeach; 
									} ?>
								</select>
							</div>
						</div>
						<!-- Autorizado por -->
						<div class="form-group">
							<label for="militares_id" class="col-sm-2 control-label">Autorizado por</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="militares_id" class="form-control" id="militares_id">
									<option value="0">Selecione o militar que está autorizando</option>
									<?php 
									if (isset($militares)) {
										foreach($militares as $row): ?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->militar; ?></option>
										<?php endforeach; 
									} ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="senha_auth" class="col-sm-2 control-label">Senha Autorização</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input id="senha_auth" name="senha_auth" class="form-control" type="password" placeholder="Senha do Militar que está autorizando">
							</div>
						</div>
						<!-- Submeter -->
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Salvar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div> <!-- .panel-->
			</div>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
		</div><!---->
	</div>
</div>
