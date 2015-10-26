<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th>Cidade</th>
			<th>Estado</th>
			<th>Localidade</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($consulta as $row): ?>
		<tr>
			<td><?php echo $row->cidade; ?></td>
			<td><?php echo $row->estado; ?></td>
			<td><?php echo $row->localidade; ?></td>
			<td>
				<?php echo ""; ?>
				<button onclick="confirmarExcluir('<?= base_url("index.php/ocorrencias/locais/excluir/$row->id"); ?>')"  data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs">Apagar</button>
				<a href="<?= base_url("index.php/ocorrencias/locais/editar/$row->id"); ?>" class="btn btn-default btn-xs">Editar</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>