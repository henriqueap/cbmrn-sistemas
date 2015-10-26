<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th width="5%">#</th>
			<th>Nome</th>
			<th>Chefes</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$_count = 1;
			foreach ($lotacao->result() as $lotacao) : ?>
			<tr>
				<td><?php echo $_count++; #$lotacao->id ?></td>
				<td><?php echo $lotacao->nome; ?></td>
				<td>
					<?php if (!isset($lotacao->id)) : ?>
						<a type="button" class="btn btn-default btn-xs" href="<?php echo base_url('index.php/rh/chefias/cadastro').'/'.$lotacao->id; ?>">
							<span class="glyphicon glyphicon-pencil"></span> Cadastrar Chefe
						</a>
					<?php else: ?>
						<!-- Exibir nome do chefe já cadastrado. -->
						<label></label>
					<?php endif; ?>
				</td>
				<td>
					<a type="button" class="btn btn-default btn-xs" href="<?php echo base_url('index.php/rh/lotacao/editar/').'/'.$lotacao->id; ?>">
						<span class="glyphicon glyphicon-pencil"></span> Editar
					</a>
				</td>
			</tr> 
		<?php endforeach; ?>
	</tbody>
</table>