<!-- HTML Modal -->
<div id="modal">
	<div class="modal fade" id="myModal-desativar-tipo-servico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	<div class="modal fade" id="myModal-reativar-tipo-servico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		<?php echo form_open('frotas/tipo_servico/cadastrar', array('role' => 'form', 'class' => 'form-horizontal')); ?>       
		<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>"/>
		<h3 class="form-signin-heading">Tipo de Serviço</h3> 
		<div class="panel-body"> 
			<form class="form-horizontal" role="form">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Cadastrar ou Editar</h3>
							</div>      
							<div class="panel-body">
								<div class="form-group">
									<label for="txtTipoServico" class="col-sm-4 control-label"><?= (!isset($data->id)) ? 'Tipo de Serviço' : 'Editar o Serviço'; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" name="txtTipoServico" id="txtTipoServico" required>
									</div>  	
								</div>
								<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10"> 
									<center>
										<button type="submit" class="btn btn-danger">Salvar</button>
									</center>
								</div>
							</div>                        
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h3 class="panel-title">Listar</h3>
						</div>      
						<div class="panel-body">
							<table class="table table-striped table-responsive">
								<tr>
									<th>Nº</th>
									<th>Tipo de Serviço</th>
									<th>&nbsp;</th>
									<th>Situação</th>
								</tr>
								<?php $cont=1; 
								foreach ($listaservico->result() as $servicos) : 
									?>
								<tr>

									<td><?php echo $cont++; ?></td>
									<td><?php echo $servicos->nome ?></td>
									<td>
										<a type="button" class="btn btn-info btn-xs" title="Editar" href="<?php echo base_url('index.php/frotas/tipo_servico/editar').'/'.$servicos->id;?>">
											<span class="glyphicon glyphicon-pencil"></span>
										</a>
									</td>

									<?php if ($servicos->ativo==1) { ?>
									<td>
										<a type="button" data-toggle="modal" data-target="#myModal-desativar-tipo-servico" class="btn btn-success btn-xs center" onclick="confirmarDesativarTipoServico('<?php echo base_url('index.php/frotas/tipo_servico/testes').'/'.$servicos->id; ?>')">
											<span title="Desativar tipo de serviço" class="glyphicon glyphicon-ok"></span>
										</a>
									</td>
									<?php } else { ?>
									<td>
										<a type="button" data-toggle="modal" data-target="#myModal-reativar-tipo-servico" class="btn btn-danger btn-xs center" onclick="confirmarReativarTipoServico('<?php echo base_url('index.php/frotas/tipo_servico/testes').'/'.$servicos->id; ?>')">
											<span title="Reativar tipo de serviço" class="glyphicon glyphicon-remove"></span>
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