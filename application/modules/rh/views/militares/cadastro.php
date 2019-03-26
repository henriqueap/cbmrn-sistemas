<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12">
		<h1><?= isset($data->id) ? 'Editar Militar' : 'Cadastro de Militar'; ?></h1>
		<hr />
		<?php echo form_open('rh/militares/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
		<!--hidden-->
		<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />        
		
		<fieldset>
			<legend>Informações Pessoais</legend>
			<div class="form-group">
				<label for="matricula" class="col-sm-2 control-label">Matrícula</label>
				<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
					<input type="text" id="matricula" name="matricula" rel="matricula" class="form-control" id="matricula" value="<?= set_value('matricula', isset($data->matricula) ? $data->matricula : ""); ?>" placeholder="Matrícula do Militar" required />
				</div>
			</div><!--/.form-group-->
			<div class="form-group">
				<label for="nome" class="col-sm-2 control-label">Nome</label>
				<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
					<input type="text" id="nome" name="nome" class="form-control" id="nome" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" placeholder="Nome do Militar" required/>
				</div>
			</div><!--/.form-group-->
			<div class="form-group">
				<label for="cpf" class="col-sm-2 control-label">CPF</label>
				<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
					<input type="text" id="cpf" name="cpf" rel="cpf" class="form-control" value="<?= set_value('cpf', isset($data->cpf) ? $data->cpf : ""); ?>" placeholder="CPF do Militar" required />
				</div>
			</div><!--/.form-group-->
			<div class="form-group">
				<label for="rg" class="col-sm-2 control-label">RG</label>
				<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
					<input type="text" id="rg" name="rg" class="form-control" id="rg" value="<?= set_value('rg', isset($data->rg) ? $data->rg : ""); ?>" placeholder="RG do Militar" required />
				</div>
			</div><!--/.form-group-->
		</fieldset>
		
		<fieldset>
			<legend>Informações de Militares</legend>
			<div class="form-group">
				<label for="nome_guerra" class="col-sm-2 control-label">Nome de Guerra</label>
				<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
					<input type="text" id="nome_guerra" name="nome_guerra" class="form-control" id="nome_guerra" value="<?= set_value('nome_guerra', isset($data->nome_guerra) ? $data->nome_guerra : ""); ?>" placeholder="Nome de Guerra do Militar" required />
				</div>
			</div><!--/.form-group-->
			<div class="form-group">
				<label for="patente_patentes_id" class="col-sm-2 control-label">Patente</label>
				<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
					<select name="patente_patentes_id" id="patente_patentes_id" class="form-control">
						<option value="">Patentes</option>
						<?php foreach ($listPatentes->result() as $patente): ?>
							<option value="<?= $patente->id ?>" <?php echo ($patente->id == $data->patente_patentes_id)? "selected" : ""; ?>><?= $patente->nome ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div><!--/.form-group-->
			<div class="form-group">
				<label for="num_praca" class="col-sm-2 control-label">Número Praça</label>
				<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
					<input type="text" id="num_praca" name="num_praca" class="form-control" value="<?= set_value('num_praca', isset($data->num_praca) ? $data->num_praca : ""); ?>" placeholder="Número de praça"/>
				</div>
			</div><!--/.form-group-->
			<!--<div class="form-group">
				<label for="id_secao_superior" class="col-sm-2 control-label">Seção</label>
				<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
					<select name="id_secao_superior" id="id_secao_superior" class="form-control" required>
						<!-- Listar todos os setores ou seções. -->
						<!--<option value="">Subordinado a</option>
						<?php #foreach ($lista_subordinados->result() as $row): ?>
						<option value="<?php #echo $row->id; ?>"><?php #echo $row->nome; ?></option>
						<?php #endforeach; ?>
					</select>
				</div>
			</div><!--/.form-group-->
			<!--<div class="form-group">
				<label for="sala_salas_id" class="col-sm-2 control-label">Sala</label>
				<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
					<select name="sala_salas_id" id="sala_salas_id" class="form-control" id="sala-select">
						<option value="">Salas</option>
						<?php #foreach ($lista_salas->result() as $lista_salas): ?>
						<option value="<?php #echo $lista_salas->id; ?>"><?php #\echo $lista_salas->nome; ?></option>
						<?php #endforeach; ?>
					</select>
				</div>
			</div><!--/.form-group-->
		</fieldset>
		
		<fieldset>
			<legend>Informações de Contato</legend>
			<div class="form-group">
				<label for="email" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">E-mail</label>
				<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
					<input type="text" id="email" name="email" class="form-control" value="<?= set_value('email', isset($data->email) ? $data->email : ""); ?>" placeholder="E-mail do Militar" required />
				</div>
			</div><!--/.form-group-->

			<div class="form-group">
				<label for="telefone" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Telefone</label>
				<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
					<input type="text" id="telefone" rel="telefone" name="telefone" class="form-control" value="<?= set_value('email', isset($data->telefone) ? $data->telefone : ""); ?>" placeholder="Telefone do Militar" />
				</div>
			</div><!--/.form-group-->
		</fieldset>
		
		<input type="button" onclick="$('#atualizar_senha').show(); $('#senha').attr('required', 'true');" value="Alterar Senha" />

		<fieldset id="atualizar_senha">
			<legend>Informações de Acesso</legend>
			<div class="form-group">
				<label for="senha" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Senha</label>
				<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
					<input type="password" id="senha" name="senha" class="form-control" />
				</div>
			</div><!--/.form-group-->
		</fieldset>
		
		<hr />
		<div class="form-group">
			<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 col-sm-offset-2">
				<input type="submit" value="Salvar" class="btn btn-primary" />
			</div>
		</div><!--/.form-group-->
		<?php echo form_close(); ?>
	</div>
</div>