<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th>Nome Fantasia</th>
			<th>Número</th>
			<th>Valor Total</th>
			<th>Data</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($consulta as $consulta): 
			if($consulta->ativo == 0): 
				if($consulta->concluido == 1): ?>
					<tr>
						<td><?php echo $consulta->nome_fantasia; ?></td>
						<td><?php echo $consulta->numero; ?></td>
						<td><?php echo number_format($consulta->valor, 2, ',', '.'); ?></td>
						<td><?php echo date("d/m/Y", strtotime($consulta->data)); ?></td>
						<td>
							<a href="<?php echo base_url("index.php/clog/notas/itens_nota/$consulta->id_nota"); ?>" class="btn btn-primary btn-sm">Detalhes  Nota</a>
							<a href="<?php echo base_url("index.php/clog/notas/excluir_nota_concluida/$consulta->id_nota"); ?>" class="btn btn-danger btn-sm" title="Excluír nota ainda não concluída">Excluír Nota</a>
						</td>
					</tr>
					<?php else: ?>
					<tr>
						<td><?php echo $consulta->nome_fantasia; ?></td>
						<td><?php echo $consulta->numero; ?></td>
						<td><?php echo number_format($consulta->valor, 2, ',', '.'); ?></td>
						<td><?php echo date("d/m/Y", strtotime($consulta->data)); ?></td>
						<td>
							<a href="<?php echo base_url("index.php/clog/notas/itens_nota/$consulta->id_nota"); ?>" class="btn btn-warning btn-sm" title="">Continuar Nota</a>
							<a href="<?php echo base_url("index.php/clog/notas/excluir_nota/$consulta->id_nota"); ?>" class="btn btn-danger btn-sm" title="Excluír nota ainda não concluída">Excluír Nota</a>
						</td>
					</tr>
		<?php  endif;  endif; endforeach; ?>
	</tbody>
</table>