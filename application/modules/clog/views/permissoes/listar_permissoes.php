<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<hr>
	<h3><?php echo $titulo; ?></h3>
	<hr>
	<table class="table table-hover table-bordered table-condensed">
		<thead>
			<tr>
				<th># </th>
				<th>Grupo</th>
				<th>Permissão</th>
				<th>Módulo</th>
				<th>Página</th>
				<th>Ações</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if(count($grupos) > 0): 
				$count = 1;
				foreach ($grupos as $permissao): ?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo $permissao->grupo; ?></td>
						<td><?php echo $permissao->permissao; ?></td>
						<td><?php echo $permissao->modulo; ?></td>
						<td><?php echo $permissao->pagina; ?></td>
						<td>
							<button type="button" id="btn-excluir" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal-excluir" onclick="$('#bt-modal-confirmar-exclusao').attr('href','<?php echo base_url("index.php/clog/permissao/excluir_permissao/$permissao->permissoes_id/$permissao->grupos_permissoes_id"); ?>');">Excluir</button>
						</td>
					</tr>
					<?php 
				endforeach; 
			endif; ?>
		</tbody>
	</table>
</div><!--col-->