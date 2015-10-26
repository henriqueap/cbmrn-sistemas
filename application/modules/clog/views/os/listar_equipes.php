<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Listar Equipes</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo form_open('clog/os/listar_equipe', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<div class="form-group">
								<label for="os_idlotacao" class="col-sm-2 control-label">Setor</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="lotacoes_id" class="form-control" id="os_idlotacao">
										<option value="0">Selecione o Setor</option>
										<?php foreach($setores as $rowS): ?>
										<option value="<?php echo $rowS->id; ?>"><?php echo $rowS->sigla; ?></option>
										<?php endforeach; ?>
								</select>
								<div id="arvore"></div>
								</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Mostrar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
	<?php
	if (isset($equipe)) { ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h1>Equipe</h1>
			</div>
			<hr>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
						if($equipe !== FALSE) { ?>
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Ordem</th>
										<th>Setor</th>
										<th>Posto/Graduação</th>
										<th>Nome de Guera</th>
										<th>Ações</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$count = 1; 
									foreach($equipe->result() as $membro): ?>
										<tr>
											<td><?php echo $count++; ?></td>
											<td><?php echo $membro->setor; ?></td>
											<td><?php echo $membro->patente; ?></td>
											<td><?php echo $membro->nome_guerra; ?></td>
											<td>
												<input type="button" value="Retirar" onclick="location.href = '<?php echo BASE_URL('clog/os/retiraMembro').'?id='.$membro->id; ?>';">
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<?php
						}
						else echo "Este setor não possui equipe cadastrada.";
						?>
					</div>
				</div>
			</div>
		</div> <!-- .row -->
		<?php
	} ?>
</div> <!-- .container -->