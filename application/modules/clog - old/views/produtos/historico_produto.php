<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Histórico - Tombo nº <span id="numero_tombo"><?php echo $tombo_info->tombo; ?></span> ( <?php echo $tombo_info->produto; ?>)</h4>
</div>
<div class="modal-body" >	
	<table class="table table-hover table-bordered table-condensed">
		<thead>
			<tr>
				<th class="center">Ordem</th>
				<th class="center">Nº Distr.</th>
				<th class="center">Almoxarifado</th>
				<th class="center">Destino</th>
				<th class="center">Transferido</th>
				<th class="center">Data</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$count = 1;
			foreach($historico as $row): ?>
				<tr>
					<td class="center"><?php echo $count++; ?></td>
					<td class="center"><?php echo $row->cautelas_id; ?></td>
					<td class="center"><?php echo $row->almoxarifado; ?></td>
					<td class="center"><?php echo $row->sigla; ?></td>
					<td class="center"><?php echo (is_null($row->destino)) ? "-" : $row->destino; ?></td>
					<td class="center"><?php echo $row->dia; ?></td>
				</tr>
				<?php 
			endforeach; ?>
		</tbody>
	</table>
</div>
<div class="modal-footer">
	<?php $url = BASE_URL('index.php/clog/produtos/imprime_historico_produto?tombo='); ?>
	<button type="button" class="btn btn-default" data-dismiss="modal" id="imprime-historico">Imprimir</button>
	<!--<button type="button" class="btn btn-default" data-dismiss="modal" id="imprime-historico" onclick="window.open('<?php #echo $url; ?>'+$('#numero_tombo').text(), '_blank');">Imprimir</button>-->
</div>