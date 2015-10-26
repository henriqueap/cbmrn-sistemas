
<h4 class="center">Histórico de Produto Permanente</h4>	
<hr />
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable">
	<p>
		<b>Produto:</b> <?php echo $tombo_info->produto; ?><br />
		<b>Tombo:</b><span id="numero_tombo"><?php echo $tombo_info->tombo; ?></span><br />
	</p>
	<hr>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable"> 
	<table class="table table-hover table-bordered table-condensed">
		<thead>
			<tr>
				<th class="center">Ordem</th>
				<th class="center">Nº Distr.</th>
				<th class="center">Destino</th>
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
					<td class="center"><?php echo $row->sigla; ?></td>
					<td class="center"><?php echo $row->dia; ?></td>
				</tr>
				<?php 
			endforeach; ?>
		</tbody>
	</table>
</div><!-- .produto-historico -->