<div class="container">
	<div class="row">
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<?php if ($cautela->distribuicao == 1) {
				$destino = " - Distribuição de Material de Consumo para ".(is_null($cautela->setor_id) ? "Militar" : "Setor");
			}
			else { 
				$destino = " - Transferência de Material Permanente para Setor"; 
			} ?>
			<h1>Incluir Ítens <?php echo $destino; ?></h1>
			<hr>
		</div>
		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php echo ($cautela->distribuicao > 0) ? "Termo de Entrega" : "Cautela"; ?> de Material</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open("clog/cautelas/criar_cautela/$cautela->id", array('role' => 'form', 'class' => 'form-horizontal')); ?>
					<!-- Tipo produto -->
					<div class="form-group">
						<?php if ($cautela->distribuicao == 0) { ?>
							<label for="consumo" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">Tipo Produto</label>
							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
								<select name="consumo" class="form-control" id="consumo" title="Se consumo ou permanente" required >
									<option value="2" selected>Selecione</option>
									<option value="0">Consumo</option>
									<option value="1">Permanente</option>
								</select>
							</div>
							<?php
						} 
						else { ?>
							<input type="hidden" name="consumo" id="consumo" value="<?php echo ($cautela->distribuicao == 2) ? 1 : 0; ?>">
							<?php
						} ?>
						<input type="hidden" name="estoques_id" id="estoques_id" value="<?php echo $cautela->origem_id; ?>">
					</div>
					<!-- Lista de produtos -->
					<div class="form-group">
						<label for="produtos_cautela" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">Produtos</label>
						<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
							<select name="produtos_cautela" id="produtos_cautela" class="form-control" title="Lista de produtos cadastrados" required >
								<option value="" selected="">Selecione</option>
								<?php foreach ($produtos->result() as $produto): ?>
									<option value="<?php echo $produto->id; ?>"><?php echo $produto->nome_produtos; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div id="tombos-disp" class="col-xs-12 col-sm-12 col-md-10 col-lg-10 pull-right">
							<textarea id="tombos_produto" class="tombos-disp form-control" title="Lista de tombos disponíveis" disabled></textarea>
						</div>
					</div>
					<!-- Quantidade -->
					<div class="form-group">
						<label for="quantidade_itens" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label">Quantidade</label>
						<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
							<input type="text" name="quantidade_itens" class="form-control" id="quantidade_itens" placeholder="Quantidade de Itens" title="Quantidade de itens" required>
						</div>
					</div>
					<!-- Tombos -->
					<div class="form-group" id="div_numero_tombo">
						<label for="numero_tombo" class="col-sm-2 control-label">N° Tombo</label>
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
							<textarea class="form-control" rows="5" name="numero_tombo" id="numero_tombo" placeholder="Número(s) de tombo" title="Os tombos (ex: 1000) ou intervalos (ex: 1000-1010) devem ser separados por vírgula"></textarea>
							<h6>* Os tombos (ex: 1000) ou intervalos (ex: 1000-1010) devem ser separados por vírgula</h6>
							<input type="hidden" name="distribuicao" id="distribuicao" value="<?php echo $cautela->distribuicao; ?>">
						</div>
					</div>
					<!--<div class="form-group" id="tombamento">
									<label for="tombo" class="col-sm-2 control-label">Número de Tombamento</label>
									<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12" id="quantidade_tombos">
									</div>
									<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12" id="quantidade_tombos_validacao">
									</div>
					</div>-->
					<div class="form-group">
						<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
							<button type="submit" class="btn btn-default">Incluir</button>
						</div>
					</div>
					<?php //echo form_close(); ?>
				</div> <!-- .-->
			</div>
		</div>

		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12"></div>
	</div> <!-- .row -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1><?php echo ($cautela->distribuicao > 0) ? "Termo de Entrega" : "Cautela de Material"; ?> - Visualização</h1>
		</div>
		<hr>

		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Ordem</th>
								<th>Produto</th>
								<th>Tombo</th>
								<th>Quantidade</th>
								<th>Ações</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$count = 1;
							if (isset($itens) && (!is_bool($itens))) {
								foreach ($itens->result() as $item):
									#if (! isset($itens_cautela[$item->produtos_id])) {
									?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $item->produto; ?></td>
										<td><?php echo is_null($item->tombo_id) ? "-" : $tombo_info[$item->tombo_id]; ?></td>
										<td><?php echo $item->quantidade; ?></td>
										<td>
											<!--<input type="button" name="btnOS" id="btnOS" value="Mostrar" onclick="location.href = '<?php //echo BASE_URL('clog/os/ordem_servico').'?id='.$os->id; ?>';">-->
											<?php if ($cautela->concluida == 0) { ?>
												<input type="button" name="btnCancela" id="btnCancela" value="Cancelar Item" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/cancelar_item') . '?id=' . $item->id_item; ?>'">
												<?php }
											?>
										</td>
									</tr>
									<?php
								endforeach;
							} else {
								?>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?php }
							?>
						</tbody>
					</table>
					<div class="col-sm-3 col-md-6 col-lg-6 col-xs-3 ">
						<button type="button" class="btn btn-default" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/cautelar') . '?id=' . $cautela->id; ?>';">Gerar <?php echo ($cautela->distribuicao > 0) ? "Termo de Entrega" : "Cautela"; ?></button>
					</div>
				</div>

			</div>
		</div>

		<?php echo form_close(); ?>
	</div> <!-- .row -->
</div> <!-- .container -->