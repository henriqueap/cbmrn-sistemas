<?php #foreach($produtos as $produto): var_dump($produto); endforeach; ?>
<div class="container">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h1>Listar Entradas Avulsas</h1>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th>Ordem</th>						
						<th>Produto</th>
						<th>Tipo</th>
						<th>Quantidade</th>
						<th>Incluído por</th>
						<th>Data</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if (! is_bool($entradas)) {
						$count = 1;
						foreach($entradas->result() as $entrada): ?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?php echo $entrada->produto; ?></td>
								<td><?php echo "Material ".(($entrada->consumo == 0) ? 'de Consumo' : ' Permanente'); ?></td>
								<td><?php echo $entrada->quantidade; ?></td>
								<td><?php echo $entrada->militar; ?></td>
								<td><?php echo $entrada->data_inclusao; ?></td>
								<td><a href="<?php echo base_url("index.php/clog/notas/excluir_avulsa?id=$entrada->id"); ?>" class="btn btn-default btn-sm" title="Excluir esta entrada avulsa">Excluir</a></td>
							</tr>
						<?php endforeach; 
					} ?>
				</tbody>
			</table>
		</div> <!-- .col-* -->
	</div> <!--/.row-->
</div> <!--/.container-->