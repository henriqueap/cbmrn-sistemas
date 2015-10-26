<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1><?php echo ($cautela->distribuicao == 1) ? "Distribuição de Material" : "Cautela de Material"; ?></h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<p>
				<b>Número:</b> <?php echo $cautela->id; ?><br />
				<b>Estoque de Origem:</b> <?php echo $cautela->estoque_origem." - ".$cautela->estoque_sigla; ?><br />
				<b>Destino:</b> <?php echo $cautela->setor." - ".$cautela->sigla; ?><br />
				<b>Militar:</b> <?php echo $cautela->militar; ?><br />
			</p>
			<hr>
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Ordem</th>
								<th>Produto</th>
								<th>Tombo</th>
								<th>Quantidade</th>
								<th>
									<?php 
									echo ($cautela->distribuicao == 1) ? "Distribuido  em" : "Cautelado em"; ?>
								</th>
								<?php 
								if ($cautela->distribuicao == 0) { ?>
									<th>Devolução prevista</th>
									<?php
									if ($cautela->concluida == 1) echo "<th>Devolvido em</th>";
								} ?>
							</tr>
						</thead>
						<tbody>
							<?php 
							$count = 1; 
							if (isset($itens) && (! is_bool($itens))) {
								foreach($itens->result() as $item): 
									if($item->tombo_id != null){
										foreach($tombos->result() as $tombo): 
											if($item->tombo_id == $tombo->id){?>
												<tr>
													<td><?php echo $count++; ?></td>
													<td><?php echo ($item->ativo == 0) ? $item->produto." (Transferido para ".$cautela->setor.")" : $item->produto; ?></td>
													<td><?php echo $tombo->tombo; ?></td>
													<td><?php echo $item->quantidade; ?></td>
													<td><?php echo $cautela->data_cautela; ?></td>
													<?php 
													if ($cautela->distribuicao == 0) {
														echo "<td>".$cautela->data_prevista."</td>"; 
														if ($cautela->concluida == 1) echo "<td>".$cautela->data_conclusao." ".$cautela->hora_conclusao."</td>"; 
													} ?>
													<!--<td>
														<input type="button" name="btnOS" id="btnOS" value="Mostrar" onclick="location.href = '<?php //echo BASE_URL('clog/os/ordem_servico').'?id='.$os->id; ?>';">
														<?php
														/*
														if ($cautela->concluida == 0) { ?>
														<input type="button" name="btnCancela" id="btnCancela" value="Cancelar Item" onclick="location.href = '<?php echo BASE_URL('clog/cautelas/cancelar_item').'?id='.$item->id; ?>'">
														<?php 
														}
														*/ 
														?>
													</td>-->
												</tr>
												<?php
											}
										endforeach;
									}
									else { ?>
										<tr>
											<td><?php echo $count++; ?></td>
											<td><?php echo $item->produto; ?></td>											
											<td><?php echo "Produto de Consumo" ?></td>												
											<td><?php echo $item->quantidade; ?></td>
											<td><?php echo $cautela->data_cautela; ?></td> 
											<?php 
											if ($cautela->distribuicao == 0) {
												echo "<td>".$cautela->data_prevista."</td>";
												if ($cautela->concluida == 1) echo "<td>".$cautela->data_conclusao." ".$cautela->hora_conclusao."</td>"; 
											}	?>
											<!--<td>
												<input type="button" name="btnOS" id="btnOS" value="Mostrar" onclick="location.href = '<?php //echo BASE_URL('clog/os/ordem_servico').'?id='.$os->id; ?>';">
												<?php
												/*
												if ($cautela->concluida == 0) { ?>
												<input type="button" name="btnCancela" id="btnCancela" value="Cancelar Item" onclick="location.href = '<?php echo BASE_URL('clog/cautelas/cancelar_item').'?id='.$item->id; ?>'">
												<?php 
												}
												*/ 
												?>
											</td>-->
										</tr>
										<?php
									} 
								endforeach;
							}
							else { ?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php 
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
				<!--<button type="button" class="btn btn-default" onclick="location.href = '<?php //echo BASE_URL('clog/cautelas'); ?>'">Lançar Cautela</button>-->
				<?php 
				if ($cautela->concluida == 0) {
					if ($cautela->finalizada == 0) { 
						$btnPrint = BASE_URL('index.php/clog/cautelas/imprimir').'?id='.$cautela->id;
						if ($cautela->distribuicao == 1) {
							$btnCap = "Distribuir Material";
							$btnAct = BASE_URL('index.php/clog/cautelas/finalizar_cautela').'?id='.$cautela->id;
						}
						else {
							$btnCap = "Cautelar";
							$btnAct = BASE_URL('index.php/clog/cautelas/finalizar_cautela').'?id='.$cautela->id;
						} ?>
						<button type="button" class="btn btn-default" onclick="window.open('<?php echo $btnPrint; ?>', '_blank'); location.href = '<?php echo $btnAct; ?>';"><?php echo $btnCap; ?></button>
						<button type="button" class="btn btn-default" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/criar_cautela/'.$cautela->id); ?>';">Incluir itens</button>
						<?php
					}
				} ?>
				<button type="button" class="btn btn-default" onclick="history.back();">Voltar</button>
				<button type="button" class="btn btn-default" onclick="location.href = '<?php echo BASE_URL('clog/cautelas/consulta'); ?>';">Nova Consulta</button>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->