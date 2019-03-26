<div class="modal-header printable">
	<button type="button" class="close" aria-label="Close" onclick="location.reload();"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Histórico - Tombo nº <span id="numero_tombo"><?php echo $tombo_info->tombo; ?></span> ( <?php echo $tombo_info->produto; ?>)</h4>
</div>
<div class="modal-body printable" >
	<table class="table table-hover table-bordered table-condensed printable">
		<thead>
			<tr>
				<th class="center">Ordem</th>
				<th class="center">Nº Saída</th>
				<th class="center">Tipo de saída</th>
				<th class="center">Origem</th>
				<th class="center">Destino</th>
				<th class="center">Data</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 1;
			foreach ($historico as $row):
				if (($row->distribuicao == 2 && $row->ativa == 0) || ($row->distribuicao == 0 && !(is_null($row->concluida == 0))))  { ?>
					<tr>
						<td class="center"><?php echo $count++; ?></td>
						<td class="center">-</td>
						<td class="center">
							<?php
							switch ($row->distribuicao) {
									case 1:
										echo "Distribuição";
										break;
									case 2:
										echo "Transferência Devolvida";
										break;
									default:
										echo "Cautela Devolvida";
										break;
							}  ?>
						</td>
						<td class="center"><?php echo (is_null($row->sigla)) ? $row->militar : $row->sigla; ?></td>
						<td class="center"><?php echo $row->almoxarifado; ?></td>
						<td class="center"><?php echo $row->devolvido; ?></td>
					</tr>
					<?php
				} ?>
				<tr>
					<td class="center"><?php echo $count++; ?></td>
					<td class="center"><a href="<?php echo BASE_URL('index.php/clog/cautelas/cautelar').'?id='.$row->cautelas_id; ?>"><?php echo $row->cautelas_id; ?></td>
					<td class="center">
						<?php
						switch ($row->distribuicao) {
								case 1:
									echo "Distribuição";
									break;
								case 2:
									echo "Transferência";
									break;
								default:
									echo "Cautela";
									break;
						}  ?>
					</td>
					<td class="center"><?php echo $row->almoxarifado; ?></td>
					<td class="center"><?php echo (is_null($row->sigla)) ? $row->militar : $row->sigla; ?></td>
					<td class="center"><?php echo $row->dia; ?></td>
				</tr>
				<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<?php $url = BASE_URL('index.php/clog/produtos/printDetProdutos?tombo='.$tombo_info->tombo); ?>
	<button type="button" class="btn btn-default" onclick="location.href = '<?php echo $url; ?>';" id="imprime-historico">Imprimir</button>
	<!--<button type="button" class="btn btn-default" data-dismiss="modal" id="imprime-historico" onclick="window.open('<?php #echo $url;  ?>'+$('#numero_tombo').text(), '_blank');">Imprimir</button>-->
</div>