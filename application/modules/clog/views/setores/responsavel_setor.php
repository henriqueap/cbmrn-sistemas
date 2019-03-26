<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<h1>
				<?php 
					$tipo_lotacao = ($sala == 0)? "Setor" : "Sala";
					echo (! $this->input->get('id'))? "Cadastro de Responsável por $tipo_lotacao" : "Editar Responsável $tipo_lotacao"; ?>
			</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Formulário para Cadastro de Responsável por <?php echo $tipo_lotacao; ?></h3>
				</div>
				<div class="panel-body">
					<?php echo form_open('clog/cadastra_responsavel', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<!-- Setor -->
						<div class="form-group">
							<label for="lotacoes_id" class="col-sm-2 control-label"><?php echo $tipo_lotacao; ?> </label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<select name="lotacoes_id" class="form-control" id="lotacoes_id" title="Setor" required>
									<option value="0">Selecione</option>
									<?php
									if (! is_bool($lotacoes)) {
										$selected = '';
										foreach ($lotacoes->result() as $lotacao): ?>
											<option value="<?php echo $lotacao->id; ?>"><?php echo $lotacao->sigla; ?></option>
											<?php
										endforeach; 
									}	?>
								</select>
							</div>
						</div>
						<!-- Responsável -->
						<div class="form-group">
							<label for="search-militar-matricula" class="col-sm-2 control-label">Matrícula</label>
							<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
								<input type="text" rel="matricula" class="form-control" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required="required" title="Matrícula do militar">
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">
								<!--<input type="hidden" class="form-control input-xs" id="tipo_saida_hidden" name="tipo_saida" value="<?php echo (isset($tipo_saida)) ? $tipo_saida : 0; ?>">-->
							</div>
							<div class="col-sm-6">
								<label class="control-label" id="nome_militar" name="nome_militar" ></label>
								<input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">
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
						<th><?php echo $tipo_lotacao; ?></th>
						<th>Militar</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (! is_bool($lista)) {
						$count = 1;
						foreach ($lista->result() as $linha) : 
							if ($linha->sala == $sala) { ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $linha->nome; ?></td>
									<td><?php echo $linha->responsavel; ?></td>
									<td>
										<a href="#" class="btn btn-default btn-xs" id="" onclick="confirmarExcluir('<?php echo base_url('index.php/clog/excluirLinha').'?id='.$linha->id.'&tbl=responsavel_lotacoes'; ?>')" data-toggle="modal" data-target="#myModal-excluir">
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