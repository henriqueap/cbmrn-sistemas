<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th width="5%">#</th>
			<th width="40%">Nome</th>
			<th width="20%">Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($salas->result() as $sala) : ?>
			<tr>
				<td><?= $sala->id ?></td>
				<td><?= $sala->nome ?></td>
				<td>
					<a type="button" href="<?= base_url() . 'index.php/rh/salas/editar/' . $sala->id; ?>" class="btn btn-default btn-xs">
						<span class="glyphicon glyphicon-pencil"></span> Editar
					</a>                    
					<a type="button" href="#" onclick="confirmarExcluir('<?= base_url() . 'index.php/rh/salas/excluir/' . $sala->id; ?>');" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal-excluir">
						<span class="glyphicon glyphicon-remove"></span> Excluir
					</a>
				</td>
			</tr> 
		<?php endforeach; ?>        
	</tbody>
</table>