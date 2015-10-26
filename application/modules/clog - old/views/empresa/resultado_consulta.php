	<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<th>Razão Social</th>
			<th>CNPJ</th>
			<th>Telefone</th>
			<th>Endereço</th>
			<th>Ações</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($consulta as $consulta): ?>
		<tr>
			<td><?php echo $consulta->razao_social; ?></td>
			<td><?php echo $consulta->cnpj; ?></td>
			<td><?php echo $consulta->telefone; ?></td>
			<td><?php echo $consulta->cidade.', '.$consulta->estado.', '.$consulta->logradouro.', '.$consulta->numero.', '.$consulta->bairro; ?></td>
			<td>
				<a href="<?php echo base_url("index.php/clog/empresa/editar/$consulta->empresas_id"); ?>" class="btn btn-default btn-sm" title="Editar Empresas">Editar Empresa</a>
				<?php if($consulta->ativo == 1){ ?>
					<a href="<?php echo base_url("index.php/clog/empresa/desativar/$consulta->empresas_id"); ?>" class="btn btn-default btn-sm" title="Desativar endereço">Desativar</a>
				<?php }else{?>
					<a href="<?php echo base_url("index.php/clog/empresa/desativar/$consulta->empresas_id"); ?>" class="btn btn-default btn-sm" title="Ativar endereço">Ativar</a>
				<?php }?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>