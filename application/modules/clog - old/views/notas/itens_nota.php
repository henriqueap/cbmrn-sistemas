<?php #foreach($produtos as $produto): var_dump($produto); endforeach; ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div> <!-- .col-* -->		
		<?php if($info_nota->concluido == 0): ?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1 class="panel-title">2° Cadastro de Itens na Nota Fiscal</h1>
					</div>

					<div class="panel-body">
						<?php echo form_open('clog/notas/itens_nota'.'/'.$info_nota->id, array('role'=>'form', 'class'=>'form-horizontal')); ?>
							<input type="hidden" name="notas_fiscais_id" id="notas_fiscais_id" class="" value="<?php echo $info_nota->id; ?>"/>
							
							<div class="form-group">
								<label for="valor_unitario" class="col-sm-2 control-label">Valor unitário</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
									<input type="text" name="valor_unitario" class="form-control" rel="preco" id="valor_unitario" value="<?php echo ""; ?>" placeholder="Valor Unitário" required>
								</div>
							</div>

							<div class="form-group">
								<label for="quantidade_item" class="col-sm-2 control-label">Quantidade Itens</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
									<input type="text" name="quantidade_item" class="form-control" id="quantidade_item" value="<?php echo ""; ?>" placeholder="Quantidade Itens" required>
								</div>
							</div>

							<?php if ($info_nota->tipo != 1) : # Comparação caso a nota fiscal seja de serviço ou compra. ?>
								<div class="form-group">
									<label for="produtos_id" class="col-sm-2 control-label">Produtos</label>
									<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<select  name="produtos_id" id="produtos" class="form-control produtos">
											<option value="">Produtos</option>
											<?php foreach($produtos as $produto): ?>
											<option value="<?php echo $produto->id; ?>"><?php echo $produto->modelo; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>

								<!--<div class="form-group">
									<label for="select-tombo" class="col-sm-2 control-label">Tipo Produto</label>
									<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<select class="form-control" name="select_tombo" id="select-tombo">
											<option value="0" selected>Consumo</option>
											<option value="1">Permanente</option>
										</select>
									</div>
								</div>-->

								<div class="form-group" id="div_numero_tombo">
									<label for="numero_tombo" class="col-sm-2 control-label">N° Tombo</label>
									<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<textarea class="form-control" rows="5" name="numero_tombo" id="numero_tombo" placeholder="Número(s) de tombo" title="Os tombos (ex: 1000) ou intervalos (ex: 1000-1010) devem ser separados por vírgula"></textarea>
										<h6>* Os tombos (ex: 1000) ou intervalos (ex: 1000-1010) devem ser separados por vírgula</h6>
									</div>
								</div>
								<?php else: ?>
								<div class="form-group">
									<label class="col-sm-2 control-label" for="tipo_servico">Tipo do Serviço</label>
									<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<select class="form-control" name="tipo_servicos_id" id="tipo_servico">
											<option>Tipo de Serviços</option>
											<?php foreach($tipo_servicos as $tipo_servico): ?>
												<option value="<?php echo $tipo_servico->id; ?>"><?php echo $tipo_servico->nome; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							<?php endif; ?>

							<div class="form-group">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
									<button type="submit" class="btn btn-default">Adicionar Item</button>
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div> <!-- .col-* -->

			<?php #echo form_open('', array('class'=>'form-horizontal')); ?>
			
			<?php #echo form_close(); ?>
			<?php #else: exit('Voc&ecirc; n&atilde;o tem acesso a essa p&aacute;gina!'); ?>
		<?php endif; ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h1 class="panel-title"><?php echo "N° Nota: ".$info_nota->numero; ?></h1>
					</div>

					<div class="panel-body">
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th><?php echo ($info_nota->tipo != 1) ? "Produtos" : "Serviços" ;?></th>
									<th>Valor unitário</th>
									<th>Quantidade de Itens</th>
									<?php if ($info_nota->concluido == 0){ echo "<th>Ações</th>"; }?>
								</tr>
							</thead>
							<tbody>
								<?php $count=0; $resultado=0; $float_max = 9.99; ?>
								<?php foreach($itens as $item): ?>	  	
									<input type="hidden" name="" value="">
									<input type="hidden" name="" value="<?= $item->quantidade_item; ?>">
									<tr>
										<td><?php echo (isset($item->modelo)) ? $item->modelo : $item->tipo_servicos; ?></td>
										<td><?php echo "R$: " . number_format($item->valor_unitario, 2, ',', '.'); ?></td>
										<td><?php echo $item->quantidade_item; ?></td>
										<?php 
										if ($info_nota->concluido == 0) { ?>
											<td>
												<!--<a href="#" onclick="confirmarExcluir('<?php //echo base_url("index.php/clog/notas/excluir_itens_nota/$item->id_itens/$info_nota->id"); ?>')" class="btn btn-xs btn-default" id="bt-modal-confirmar-exclusao"><span class="glyphicon glyphicon-remove"></span> Excluír</a>-->
												<button type="button" id="btn-excluir" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal-excluir" onclick="$('#bt-modal-confirmar-exclusao').attr('href','<?php echo base_url("index.php/clog/notas/excluir_itens_nota/$item->id_itens/$info_nota->id"); ?>');">Excluir</button>
												<!--<a href="<?php //echo base_url('index.php/clog/notas/excluir_itens_nota/$item->id_itens/$info_nota->id'); ?>" data-toggle="modal" data-target="myModal-excluir"><span class="glyphicon glyphicon-remove"></span> Excluír</a>-->
											</td>
											<?php
										} ?> 
									</tr>
									<?php 
										$count = ($item->valor_unitario * $item->quantidade_item);
										$resultado = $resultado + $count;
									?>
								<?php endforeach; ?>
							</tbody>
						</table>

						<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
							<input type="hidden" name="valor" id="valor" value="<?php echo $resultado; ?>">
							<input type="hidden" name="id" id="id" value="<?php echo $info_nota->id; ?>">
							<label>Valor Total: R$ <?php echo number_format($resultado, 2, ',', '.'); ?></label>
						</div> <!-- Col-* -->
						<?php if ($info_nota->concluido == 0){?>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<button type="button" class="btn btn-xs btn-default" id="btn-concluir-nota" title="Clique aqui para concluir a nota fiscal">Concluir nota fiscal</button>
									<br />
								</div>
						<?php } ?>
						
					</div> <!-- /.panel-body -->
				</div>
			</div> <!-- /.col-* -->
	</div> <!--/.row-->
</div> <!--/.container-->