<!-- HTML Modal -->
<div id="modal">
		<div class="modal fade" id="myModal-desativar-tipo-odometro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Atenção!</h3>
								</div>
								<div class="modal-body">
										<p>Deseja realmente desativar?</p>
								</div>
								<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
										<a type="button" class="btn btn-primary" id="bt-modal-confirmar-desativar" href="#">Sim</a>
								</div>
						</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
		</div><!-- /.modal --> 
</div>

<!-- HTML Modal -->
<div id="modal">
		<div class="modal fade" id="myModal-reativar-tipo-odometro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
						<div class="modal-content">
								<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h3 id="myModalLabel">Atenção!</h3>
								</div>
								<div class="modal-body">
										<p>Deseja realmente reativar?</p>
								</div>
								<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
										<a type="button" class="btn btn-primary" id="bt-modal-confirmar-reativar" href="#">Sim</a>
								</div>
						</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
		</div><!-- /.modal --> 
</div>

<div class="container">
	<div>
		<?php echo form_open('frotas/tipo_odometro/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
		<input type="hidden" name="id" value="<?= set_value('tipos_odometros_id', isset($data->tipos_odometros_id) ? $data->tipos_odometros_id : ""); ?>" />
		<h3 class="form-signin-heading">Tipo de Odômetro</h3>
		<div class="panel-body"> 
			<form class="form-horizontal" role="form">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Cadastrar ou Editar</h3>
							</div>      
							<div class="panel-body">
								<div class="form-group">
									<label for="txTipoOdo" class="col-sm-4 control-label"><?= (!isset($data->tipos_odometros_id)) ? 'Cadastrar Tipo de Odômetro' : 'Editar o Tipo de Odômetro'; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="txtTipoOdo" value="<?= set_value('tipo_odometro', isset($data->tipo_odometro) ? $data->tipo_odometro : ""); ?>" name="txtTipoOdo" placeholder="<?= (!isset($data->tipos_odometros_id)) ? 'Cadastre um novo tipo de odômetro' : ''; ?>" required>
									</div>  	
								</div>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"> 
									<center>
										<button type="submit" class="btn btn-success">Salvar</button>
									</center>
								</div>
							</div>                        
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Listar todos os Tipos de Odômetro</h3>
						</div>      
						<div class="panel-body">
							<table class="table table-striped table-responsive">
								<tr>
									<th>Nº</th>
									<th>Tipos de Odômetro Cadastrados</th>
									<th>&nbsp;</th>
									<th>Situação</th>
								</tr>
								<?php $cont=1;
								foreach ($tipos->result() as $tipo) : ?> 
								<tr>
									<td><?php echo $cont++; ?></td>
									<td><?php echo $tipo->tipo_odometro; ?></td>
									<td>
										<a type="button" class="btn btn-info btn-xs" title="Editar" href="<?php echo base_url('index.php/frotas/tipo_odometro/editar').'/'.$tipo->tipos_odometros_id; ?>">
											<span class="glyphicon glyphicon-pencil"></span>
										</a>
									</td>

									<?php if ($tipo->ativo==1) { ?>
									<td>
										<a type="button" data-toggle="modal" data-target="#myModal-desativar-tipo-odometro" class="btn btn-success btn-xs center" onclick="confirmarDesativarTipoOdometro('<?php echo base_url('index.php/frotas/tipo_odometro/testes').'/'.$tipo->tipos_odometros_id; ?>')">
											<span title="Desativar tipo de odômetro" class="glyphicon glyphicon-ok"></span>
										</a>
									</td>
									<?php } else { ?>
									<td>
										<a type="button" data-toggle="modal" data-target="#myModal-reativar-tipo-odometro" class="btn btn-danger btn-xs center" onclick="confirmarReativarTipoOdometro('<?php echo base_url('index.php/frotas/tipo_odometro/testes').'/'.$tipo->tipos_odometros_id; ?>')">
											<span title="Reativar tipo de odômetro" class="glyphicon glyphicon-remove"></span>
										</a>
									</td>  
										<?php } ?>
								</tr>
								<?php endforeach; ?>  
							</table>
						</div>
					</div>
				</div>
			</form>
		</div>
		<?php echo form_close(); ?> 
	</div>
</div>