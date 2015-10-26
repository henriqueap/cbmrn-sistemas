<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<h1><?php echo (FALSE === $this->input->get('id')) ? "Cadastro de Sala" : "Editar Sala" ; ?></h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Formulário para cadastro de salas</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('clog/nova_sala', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<input type="hidden" name="id" id="id" class="" value="<?php echo (! is_bool($onEdit)) ? $onEdit->id : ""; ?>">
						<!-- Sala -->
						<div class="form-group">
							<label for="nome" class="col-sm-2 control-label">Nome da Sala</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="nome" class="form-control" id="nome" value="<?php echo (! is_bool($onEdit)) ? $onEdit->nome : ""; ?>" placeholder="Nome da Sala" required/>
							</div>
						</div>
						<!-- Sigla -->
						<div class="form-group">
							<label for="sigla" class="col-sm-2 control-label">Sigla da Sala</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="sigla" class="form-control" id="sigla" value="<?php echo (! is_bool($onEdit)) ? $onEdit->sigla : ""; ?>" placeholder="Sigla da Sala" required/>
							</div>
						</div>

						<!-- Lotação -->
						<div class="form-group">
							<label for="lotacoes_id" class="col-sm-2 control-label">Lotação </label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="lotacoes_id" class="form-control" id="lotacoes_id" title="Setor" required>
									<option value="0">Selecione</option>
									<?php
									if (!is_bool($setores)) {
										$selected = '';
										foreach ($setores->result() as $setor): 
											$selected = ((! is_bool($onEdit)) && $onEdit->superior_id == $setor->id) ? 'selected' : ''; ?>
											<option value="<?php echo $setor->id; ?>" <?php echo $selected; ?>><?php echo $setor->sigla; ?></option>
											<?php 
										endforeach; 
									}	?>
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
					if (! is_bool($salas)) {
						$count = 1;
						foreach ($salas->result() as $sala) : ?>
						<tr>
							<td><?php echo $count++; ?></td>
							<td><?php echo $sala->nome; ?></td>
							<td>
								<a href="<?php echo base_url('index.php/clog/clog/cadastra_sala').'?id='.$sala->id; ?>" class="btn btn-default btn-xs" id="">
									<span class="glyphicon glyphicon-pencil"></span> Editar
								</a>
								<a href="#" class="btn btn-default btn-xs" id="" onclick="confirmarExcluir('<?php echo base_url('index.php/clog/excluir').'/'.$sala->id; ?>')" data-toggle="modal" data-target="#myModal-excluir">
									<span class="glyphicon glyphicon-remove"></span> Excluir
								</a>
							</td>
						</tr> 
						<?php
						endforeach; 
					}?>
				</tbody>
			</table>
		</div>
	</div> <!--.row-->
</div> <!--.container-->