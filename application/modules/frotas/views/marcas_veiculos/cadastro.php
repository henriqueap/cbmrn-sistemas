<!-- HTML Modal -->
<div id="modal">
		<div class="modal fade" id="myModal-desativar-tipo-marca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		<div class="modal fade" id="myModal-reativar-tipo-marca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		<?php echo form_open('frotas/marcas_veiculos/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
		<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />        
		<h3 class="form-signin-heading">Tipo de Marca</h3> 
		<div class="panel-body"> 
			<form class="form-horizontal" role="form">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Cadastrar ou Editar</h3>
							</div>      
							<div class="panel-body">
								<div class="form-group">
									<label for="txtMarcas" class="col-sm-4 control-label"><?= (!isset($data->id)) ? 'Cadastrar Marca' : 'Editar a Marca'; ?></label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="txtMarcas" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" name="txtMarcas" placeholder="<?= (!isset($data->id)) ? 'Cadastre uma nova marca' : ''; ?>" required>
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
							<h3 class="panel-title">Listar todas as Marcas</h3>
						</div>      
						<div class="panel-body">
							<table class="table table-striped table-responsive">
								<tr>
									<th>Nº</th>
									<th>Marcas cadastradas</th>
									<th>Situação</th>
									<th>&nbsp;</th>
								</tr>
								<?php $cont=1;
								foreach ($marcas_veiculos->result() as $marcas) : ?> 
								<tr>
									<td><div class="div-toggle-switch"><?php echo $cont++; ?></td></div>
									<td><div class="div-toggle-switch"><?php echo $marcas->nome; ?></td></div>
									

									<?php if ($marcas->ativo==1) { ?>
									<td>
										<!-- <a type="button" data-toggle="modal" data-target="#myModal-desativar-tipo-marca" class="btn btn-success btn-xs center" onclick="confirmarDesativarTipoMarca('<?php //echo base_url('index.php/frotas/marcas_veiculos/testes').'/'.$marcas->id; ?>')">
											<span title="Desativar marca" class="glyphicon glyphicon-ok"></span>
										</a> -->
										<div class="div-toggle-switch">
											<label class="switch">
												<input type="checkbox" checked data-toggle="modal" data-target="#myModal-desativar-tipo-marca" onclick="confirmarDesativarTipoMarca('<?php echo base_url('index.php/frotas/marcas_veiculos/testes').'/'.$marcas->id; ?>')"  >
												<span class="slider round"  title="Ativar/Inativar"></span>
											</label> <b> Ativo</b>
										</div>
									</td>
									<?php } else { ?>
									<td>
										<!-- <a type="button" data-toggle="modal" data-target="#myModal-reativar-tipo-marca" class="btn btn-danger btn-xs center" onclick="confirmarReativarTipoMarca('<?php //echo base_url('index.php/frotas/marcas_veiculos/testes').'/'.$marcas->id; ?>')">
											<span title="Reativar marca" class="glyphicon glyphicon-remove"></span>
										</a> -->
										<div class="div-toggle-switch">
											<label class="switch">
												<input type="checkbox" data-toggle="modal" data-target="#myModal-reativar-tipo-marca" onclick="confirmarReativarTipoMarca('<?php echo base_url('index.php/frotas/marcas_veiculos/testes').'/'.$marcas->id; ?>')">
												<span class="slider round" title="Ativar/Inativar" ></span> 
											</label><b> Inativo</b>
										</div>
									</td>  
									<?php } ?>
									<td>
										<div class="div-toggle-switch">
											<a type="button" class="btn btn-info btn-xs" title="Editar" href="<?php echo base_url('index.php/frotas/marcas_veiculos/editar').'/'.$marcas->id; ?>">
												<span class="glyphicon glyphicon-pencil"></span>
											</a><b> Editar</b>
										</div>
									</td>	
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