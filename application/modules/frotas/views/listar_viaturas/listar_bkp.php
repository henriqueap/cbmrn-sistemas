<!-- HTML Modal -->
<div id="modal">
	<div class="modal fade" id="myModal-desativar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Atenção!</h3>
				</div>
				<div class="modal-body">
					<p>Deseja realmente desativar esta viatura?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					<a type="button" class="btn btn-primary" id="bt-modal-confirmar-desativar-viatura" href="#">Sim</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal --> 
</div>
<!-- HTML Modal -->
<div id="modal">
	<div class="modal fade" id="myModal-reativar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Atenção!</h3>
				</div>
				<div class="modal-body">
					<p>Deseja realmente reativar esta viatura?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					<a type="button" class="btn btn-primary" id="bt-modal-confirmar-reativar-viatura" href="#">Sim</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal --> 
</div>
<div class="container">
	<div class="well well-cadastro" >
		<h3 class="form-signin-heading">Lista de Viaturas Ativas</h3>        
		<div class="panel-body">
			<div class="form-group">
				<b class="col-sm-2 control-label">Selecione os Filtros</b>
				<input type="hidden" id="idViatura" value="<?php // echo $idViatura;  ?>" />
				<div class=" text-right">
					<label for="selFiltro" class="simple-text col-sm-1 control-label ">Setor:</label> <!--classe aplicada para alinhar em baixo.-->
				</div>
				<div class=" col-sm-3 ">
					<select class="form-control input-sm" id="selLotacao" >
						<option value="" >Selecione</option>
						<?php foreach($listar_lotacoes->result() as $lotacoes):?>
						<option value="<?php echo $lotacoes->id; ?>" ><?php echo $lotacoes->nome; ?></option>
						<?php endforeach?>
					</select>
				</div> 
				<div class=" text-right">
					<label for="selFiltro2" class="simple-text col-sm-2 control-label ">Tipo de Viatura:</label> <!--classe aplicada para alinhar em baixo.-->
				</div>
				<div class=" col-sm-3 ">
					<select class="form-control input-sm" id="selTipoViatura" >
						<option value="" >Selecione</option>
						<?php foreach($listar_tipo_viaturas->result() as $tipo_viaturas):?>
							<option value="<?php echo $tipo_viaturas->id; ?>" ><?php echo $tipo_viaturas->tipo; ?></option>
						<?php endforeach?>
					</select>
				</div> 
				<button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro-viaturas"><span></span></button>
				<a href="<?php echo base_url('index.php/frotas/listar_viaturas/listar'); ?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a>	
			</div>
			<br />
			<div class="row" id="result-search"> <!--Imprime o resultado da busca --> </div>
			<div id="semFiltro">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="table-responsive">
							<table class="table table-striped">
								<?php $cont=1;
								if ($listar_viaturas_ativos==false){ ?>
									<div class="well alert-danger">Nao existem viaturas ativas.</div>
							   	<?php
								}
								else { ?>
									<tr>
										<th>Nº</th>
										<th>Placa</th>
										<th>Prefixo</th>
										<th>Marca</th>
										<th>Modelo</th>
										<!--<th>Ano</th>
										<th>Óleo(Km)</th>
										<th>Revisão(Km)</th>-->
										<th>Setor</th>
										<!--th>Op.</th-->
										<th>Alt</th>
										<th>Exc</th>
										<!--th>Serv</th-->
										<th>Abst</th>
										<th>Odo</th>
									</tr>
									<?php foreach ($listar_viaturas_ativos->result() as $listar) :  ?>
										<tr>
											<td><?php echo $cont++; ?></td>
											<td><?php echo $listar->placa; ?></td>
											<td><?php echo $listar->prefixo; ?></td>
											<td><?php echo $listar->marca; ?></td>
											<td><?php echo $listar->modelo; ?></td>
											<!--<td><?php //echo "2012"; ?> </td>
											<td><?php //echo "10000"; ?></td>
											<td><?php //echo "10000"; ?></td>-->
											<td><?php echo $listar->sigla; ?></td>
											
											<?php 
											if ($listar->ativo==1) {
												/*if ($listar->operante==0) { ?>
													<!--td>
														<a title="Marcar como Operante" type="button" class="btn-xs btn-danger" href="<?php //echo base_url('index.php/frotas/listar_viaturas/atualizarOperante').'/'.$listar->idviaturas;?>"><span  class="glyphicon glyphicon-remove-circle"></span>
														</a>
													</td--> 
													<?php 
												} else { ?>
													<td>
														<a title="Marcar como Inoperante" type="button" class="btn-xs btn-success"href="<?php echo base_url('index.php/frotas/listar_viaturas/atualizarOperante').'/'.$listar->idviaturas;?>"><span  class="glyphicon glyphicon-ok-circle"></span>
														</a>
													</td--> 
													<?php 
												} */?>
												<td>
													<a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('index.php/frotas/listar_viaturas/editar').'/'.$listar->idviaturas; ?>"><span class="glyphicon glyphicon-pencil"></span>
													</a>
												</td>                                   
												<td>
													<!-- Tentar fazer modal funcionar aqui --> 
													<a title="Excluir viatura" type="button" data-toggle="modal" data-target="#myModal-desativar" class="btn-xs btn-success" onclick="confirmarDesativarViatura('<?php echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>')" href="<?php  //echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>">
														<span class="glyphicon glyphicon-remove"></span>
												  </a>
												</td>
												<!--td>
													<a title="Histórico de Serviços"  class="btn-xs btn-default"  href="<?php //echo base_url('index.php/frotas/listar_viaturas/listarServicos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-usd"></span>
													</a>
												</td-->
												<td>
													<a title="Histórico de Abastecimentos"  class="btn-xs btn-default"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listarAbastecimentos').'/'.$listar->idviaturas;?>">
														<span class="glyphicon glyphicon-filter"></span>
													</a>
												<td>
													<a title="Listar odômetros da viatura" type="button" class=" btn-xs btn-default " href="<?php echo base_url('index.php/frotas/listar_viaturas/listarOdometros').'/'.$listar->idviaturas;?>">
														<span title="Histórico de Odômetro" class="glyphicon glyphicon-map-marker"></span>
													</a>
												</td>
												<?php 
											} else { ?>
													<td title="Função desabilitada"></td>
													<td title="Função desabilitada"></td>					
													<td>
													  <a title="Reativar viatura"  type="button" data-toggle="modal" data-target="#myModal-reativar" class="btn-xs btn-danger" onclick="confirmarReativarViatura('<?php echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>')" href="<?php  //echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>">
													   	<span class="glyphicon glyphicon-ok"></span>
														</a>
													</td>
													<!--td>
														<a title="Histórico de Serviços"  class="btn-xs btn-default"  href="<?php //echo base_url('index.php/frotas/listar_viaturas/listarServicos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-usd"></span>
														</a>
													</td-->
													<td>
														<a title="Histórico de Abastecimentos"  class="btn-xs btn-default"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listarAbastecimentos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-filter"></span>
														</a><span title="Histórico de Abastecimento" class="glyphicon glyphicon-"></span>
													</td>
													<td>
														<a title="Listar odômetros da viatura" type="button" class=" btn-xs btn-default " href="<?php echo base_url('index.php/frotas/listar_viaturas/listarOdometros').'/'.$listar->idviaturas;?>">
															<span title="Histórico de Odômetro" class="glyphicon glyphicon-map-marker"></span>
														</a>
													</td>
													<?php 
											} ?>
										</tr>
									<?php endforeach ;
								} ?>
							</table>
						</div>
					</div>  
				</div>
		  </div>
		</div>
	</div>
</div>
<?php if($listar_viaturas_inativos != FALSE) { ?>
<!-- HTML Modal -->
<div id="modal">
	<div class="modal fade" id="myModal-desativar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Atenção!</h3>
				</div>
				<div class="modal-body">
					<p>Deseja realmente desativar esta viatura?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					<a type="button" class="btn btn-primary" id="bt-modal-confirmar-desativar-viatura" href="#">Sim</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal --> 
</div>
<!-- HTML Modal -->
<div id="modal">
	<div class="modal fade" id="myModal-reativar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">Atenção!</h3>
				</div>
				<div class="modal-body">
					<p>Deseja realmente reativar esta viatura?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
					<a type="button" class="btn btn-primary" id="bt-modal-confirmar-reativar-viatura" href="#">Sim</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal --> 
</div>
<div class="container">
	<div class="well well-cadastro" >
		<h3 class="form-signin-heading">Lista de Viaturas Inativas</h3>        
		<div class="panel-body">
			<div class="row" id="result-search"> <!--Imprime o resultado da busca --> </div>
			<div id="semFiltro">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="table-responsive">
							<table class="table table-striped">
								<tr>
									<th>Nº</th>
									<th>Placa</th>
									<th>Prefixo</th>
									<th>Marca</th>
									<th>Modelo</th>
									<!--<th>Ano</th>
									<th>Óleo(Km)</th>
									<th>Revisão(Km)</th>-->
									<th>Setor</th>
									<!--th>Op.</th-->
									<th>Alt</th>
									<th>Exc</th>
									<!--th>Serv</th-->
									<th>Abst</th>
									<th>Odo</th>
								</tr>
								<?php $cont=1;
								foreach ($listar_viaturas_inativos->result() as $listar) : ?>
									<tr>
										<td><?php echo $cont++; ?></td>
										<td><?php echo $listar->placa; ?></td>
										<td><?php echo $listar->prefixo; ?></td>
										<td><?php echo $listar->marca; ?></td>
										<td><?php echo $listar->modelo; ?></td>
										<!--<td><?php //echo "2012"; ?> </td>
										<td><?php //echo "10000"; ?></td>
										<td><?php //echo "10000"; ?></td>-->
										<td><?php echo $listar->sigla; ?></td>
										
										<?php 
										if ($listar->ativo==1) {
											/*if ($listar->operante==0) {?>
												<td>
													<a title="Marcar como Operante" type="button" class="btn-xs btn-danger" href="<?php echo base_url('index.php/frotas/listar_viaturas/atualizarOperante').'/'.$listar->idviaturas;?>">
														<span  class="glyphicon glyphicon-remove-circle"></span>
													</a>
												</td> 
												<?php 
											} else {
												?>
												<td>
													<a title="Marcar como Inoperante" type="button" class="btn-xs btn-success"href="<?php echo base_url('index.php/frotas/listar_viaturas/atualizarOperante').'/'.$listar->idviaturas;?>">
														<span  class="glyphicon glyphicon-ok-circle"></span>
													</a>
												</td> 
												<?php
											} */?>
											<td>
												<a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('index.php/frotas/listar_viaturas/editar').'/'.$listar->idviaturas; ?>">
													<span class="glyphicon glyphicon-pencil"></span>
												</a>
											</td>                            
											<td>
												<!-- Tentar fazer modal funcionar aqui --> 
												<a title="Excluir viatura" type="button" data-toggle="modal" data-target="#myModal-desativar" class="btn-xs btn-success" onclick="confirmarDesativarViatura('<?php echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>')" href="<?php  //echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>">
													<span class="glyphicon glyphicon-remove"></span>
											   </a>
											</td>
											<td>
												<a title="Histórico de Abastecimento"  class="btn-xs btn-default"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listarServicos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-usd"></span>
												</a>
											</td>
											<td>
												<a title="Histórico de Serviços"  class="btn-xs btn-default"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listarAbastecimentos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-filter"></span>
												</a>
												<span title="Histórico de Abastecimentos" class="glyphicon glyphicon-"></span>
											</td>
											<td>
												<a title="Listar odômetros da viatura" type="button" class=" btn-xs btn-default " href="<?php echo base_url('index.php/frotas/listar_viaturas/listarOdometros').'/'.$listar->idviaturas;?>">
													<span title="Histórico de Odômetro" class="glyphicon glyphicon-map-marker"></span>
												</a>
											</td>
											<?php
										} else { ?>
											<td>
												<a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('index.php/frotas/listar_viaturas/editar').'/'.$listar->idviaturas; ?>">
													<span class="glyphicon glyphicon-pencil"></span>
												</a>
											</td>  				
											<td>
											  <a title="Reativar viatura"  type="button" data-toggle="modal" data-target="#myModal-reativar" class="btn-xs btn-danger" onclick="confirmarReativarViatura('<?php echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas; ?>')" href="<?php  //echo base_url('index.php/frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>">
											   	<span class="glyphicon glyphicon-ok"></span>
												</a>
											</td>
											<!--td>
												<a title="Histórico de Serviços"  class="btn-xs btn-default"  href="<?php //echo base_url('index.php/frotas/listar_viaturas/listarServicos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-usd"></span>
												</a>
											</td-->
											<td>
												<a title="Histórico de Abastecimentos"  class="btn-xs btn-default"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listarAbastecimentos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-filter"></span>
												</a><span title="Histórico de Abastecimento" class="glyphicon glyphicon-"></span>
											</td>
											<td>
												<a title="Listar odômetros da viatura" type="button" class=" btn-xs btn-default " href="<?php echo base_url('index.php/frotas/listar_viaturas/listarOdometros').'/'.$listar->idviaturas;?>">
													<span title="Histórico de Odômetro" class="glyphicon glyphicon-map-marker"></span>
												</a>
											</td>
											<?php 
										}?>
									</tr>
									<?php 
								endforeach; ?>
							</table>
						</div>
					</div>  
				</div>
		  </div>
		</div>
	</div>
</div>
<?php } ?>