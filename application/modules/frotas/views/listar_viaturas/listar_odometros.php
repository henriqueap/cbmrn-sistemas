<?php //var_dump($listarOdometrosId); ?>

<div class="container">
	<div class="well well-cadastro" >
		<h3 class="form-signin-heading">
			Lista de Odômetros<?php echo (! $viatura)? "  de Viatura": " - ".$viatura->modelo."($viatura->placa)"; ?>		
		</h3>        
		<div class="panel-body">
			<div class="form-group"> 
				<div class="col-sm-1 ">
					<a type="button" class="glyphicon glyphicon-list-alt btn btn-sm btn-info" title="Voltar para a lista de viaturas"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listar')?>" >
						<span></span>
					</a>
				</div>
				<!-- Form do filtro -->
				<form action="#" method="post" class="form-horizontal" role="form">
					<input name="inputIdViaturas" id="inputIdViaturas" type="hidden" value="<?php  echo $idViatura; ?>"/>
					<label  class="col-sm-2 control-label">Período entre</label>
					<div class=" col-sm-3 ">
						<input name="dataInicial" class="form-control" type="date" id="dataInicial" size="10" value="<?php echo date('Y-m-d')?>"/>
					</div>
					<label  class="col-sm-1 control-label">e </label>
					<div class=" col-sm-3 ">
						<input name="dataFinal" class="form-control" type="date" id="dataFinal" size="10" value="<?php echo date('Y-m-d')?>" />
					</div>
					<button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-success" title="Aplicar Filtro" id="btn-buscar-filtro"><span></span></button>
					<a href="<?php echo base_url('index.php/frotas/listar_viaturas/listarOdometros').'/'.$idViatura?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro">
						<span></span>
					</a>
				</form>

			</div>
			<br />
			<div class="row" id="result-search">
				<!--Imprime o resultado da busca -->
			</div>
			<div id="semFiltro">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<?php  $cont=1;
						$vazioTeste=$listarOdometrosId;
						if (!$vazioTeste):
							echo "Esta viatura não tem registro de odômetro."; 
						else : ?>
							<div class="table-responsive">
								<table class="table table-striped">
									<tr>
										<th>Nº</th>
										<th>Odômetro</th>
										<th>Data</th>
										<th>Alteração</th>
										<th>Destino</th>
										<th>Tipo</th>
										<th>Usuário</th>
										<th></th> 
									</tr>
									<?php
									foreach ($vazioTeste as $listar) : ?>
										<tr>
											<td><?php echo $cont++; ?></td>
											<td><?php echo $listar->odometro; ?></td>
											<td><?php echo date('d/m/Y', strtotime($listar->dia)); ?></td>
											<td><?php echo $listar->alteracao; ?></td>
											<td><?php echo $listar->destino; ?> </td>
											<?php 
											switch ($listar->tipo_odometro) {
												case 1:
													echo "<td>"."Saída do quartel"."</td>";
													break;
												case 2:
													echo "<td>"."Retorno ao quartel"."</td>";
													break;
												case 3:
													echo "<td>"."Início de Serviço Operacional"."</td>";
													break;
												case 4:
													echo "<td>"."Término de Serviço Operacional"."</td>";
													break;
												case 5:
													echo "<td>"."Início de Serviço na viatura"."</td>";
													break;
												case 6:
													echo "<td>"."Conclusão de Serviço na viatura"."</td>";
													break;
												case 7:
													echo "<td>"."Abastecimento"."</td>";
													break;
												default:
													# code...
													break;
											} ?>
											<td><?php echo $listar->militar; ?></td>
											<td>  
												<a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('index.php/frotas/listar_viaturas/editarOdometros').'/'.$listar->odometros_id; ?>">
													<span class="glyphicon glyphicon-pencil"></span>
												</a>
											</td>
										</tr>
										<?php
									endforeach; ?>
								</table>
							</div>
							<?php
						endif; ?>
					</div>
				</div> 
			</div>
		</div>
	</div>
</div>