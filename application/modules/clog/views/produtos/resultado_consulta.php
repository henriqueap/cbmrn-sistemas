<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th>Marca</th>
			<th>Grupo de Produto</th>
			<th>Modelo</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($consulta as $consulta): ?>
		<tr>
			<td><?php echo $consulta->marcas; ?></td>
			<td><?php echo $consulta->grupo_produtos; ?></td>
			<td><?php echo $consulta->nome_produtos; ?></td>
			<td>
			<a href="<?= base_url('index.php/clog/produtos/detalheProdutos').'/'.$consulta->id ?>" class="btn btn-default btn-xs" id="detalhe-produtos">
      			<span class="glyphicon glyphicon-search"></span> Detalhar
      		</a>
	      	<a href="<?php echo base_url("index.php/clog/produtos/editar/$consulta->id"); ?>" class="btn btn-default btn-xs" id="">
	      		<span class="glyphicon glyphicon-pencil"></span> Editar
	      	</a>
	      	<a href="#" class="btn btn-default btn-xs" id="" onclick="$('#bt-modal-confirmar-exclusao').attr('href', '<?php echo base_url("index.php/clog/produtos/excluir/$consulta->id"); ?>');" data-toggle="modal" data-target="#myModal-excluir">
	      		<span class="glyphicon glyphicon-remove"></span> Apagar
	      	</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>