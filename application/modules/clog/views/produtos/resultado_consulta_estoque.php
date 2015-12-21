<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th>#</th>
			<th>Nome do Produto</th>
			<th>Marca</th>
			<th>Estoque Atual</th>
			<th>Almoxarifado</th>
		</tr>
	</thead>
	<tbody>
		<?php $count=1; foreach($consulta as $consulta): ?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo strtoupper($consulta->nome_produtos); ?></td>
			<td><?php echo $consulta->marcas; ?></td>
			<td><?php echo $consulta->quantidade_estoque; ?></td>
			<td><?php echo $consulta->almoxarifado; ?></td>
		</tr>
		<?php $count++;  endforeach; ?>
	</tbody>
</table>
