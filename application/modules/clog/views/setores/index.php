<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<h1><?php echo (FALSE === $this->input->get('id')) ? "Cadastro de Setor" : "Editar Setor" ; ?></h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Formulário para cadastro de setores</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('clog/novo_setor', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<input type="hidden" name="id" id="id" class="" value="<?php echo (! is_bool($onEdit)) ? $onEdit->id : ""; ?>">
						<!-- Sala -->
						<div class="form-group">
							<label for="nome" class="col-sm-2 control-label">Nome do Setor</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="nome" class="form-control" id="nome" value="<?php echo (! is_bool($onEdit)) ? $onEdit->nome : ""; ?>" placeholder="Nome da Sala" required/>
							</div>
						</div>
						<!-- Sigla -->
						<div class="form-group">
							<label for="sigla" class="col-sm-2 control-label">Sigla do Setor</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="sigla" class="form-control" id="sigla" value="<?php echo (! is_bool($onEdit)) ? $onEdit->sigla : ""; ?>" placeholder="Sigla do Setor" required/>
							</div>
						</div>
						<!-- Subordinado a -->
						<div class="form-group">
							<label for="superior_id" class="col-sm-2 control-label">Subordinado a </label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="superior_id" class="form-control" id="superior_id" title="Setor" required>
									<option value="0">Selecione</option>
									<?php
									if (! is_bool($setores)) {
										$selected = '';
										foreach ($setores->result() as $setor): 
											$selected = ((! is_bool($onEdit)) && $onEdit->superior_id == $setor->id) ? 'selected' : ''; ?>
											<option value="<?php echo $setor->id; ?>" <?php echo $selected; ?>><?php echo $setor->sigla; ?></option>
											<?php 
										endforeach; 
									}	?>
								</select>
								<!-- Almoxarifado principal? -->
								<?php
								$params = '';
								if ($almox === FALSE) { ?>
									<div class="checkbox">
										<input type="checkbox" name="almox" value="1"><label for="almox"> Almoxarifado principal</label>
									</div>
									<?php
								} 
								else {
									$params = ($onEdit !== FALSE && $onEdit->almox == 1)? 'checked' : 'disabled'; ?>
									<div class="checkbox">
										<input type="checkbox" name="almox" value="1" <?php echo $params; ?>><label for="almox"> Almoxarifado principal</label>
									</div>
									<?php
								} ?>
							</div>
						</div>
						<!-- Submeter -->
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Salvar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div> <!--Panel-->
		</div> <!--Cols-->
	</div> <!--.row-->
</div> <!--.container-->

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th># </th>
						<th>Nome</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (! is_bool($setores)) {
						$count = 1;
						foreach ($setores->result() as $setor) : 
							if ($setor->sala == 0) { ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $setor->nome; ?></td>
									<td>
										<a href="<?php echo base_url('index.php/clog/cadastra_setor').'?id='.$setor->id; ?>" class="btn btn-default btn-xs" id="">
											<span class="glyphicon glyphicon-pencil"></span> Editar
										</a>
										<a href="#" class="btn btn-default btn-xs" id="" onclick="confirmarExcluir('<?php echo base_url('index.php/clog/excluir').'/'.$setor->id; ?>')" data-toggle="modal" data-target="#myModal-excluir">
											<span class="glyphicon glyphicon-remove"></span> Excluir
										</a>
									</td>
								</tr>
								<?php
							}
						endforeach; 
					}?>
				</tbody>
			</table>
		</div>
	</div> <!--.row-->
</div> <!--.container-->