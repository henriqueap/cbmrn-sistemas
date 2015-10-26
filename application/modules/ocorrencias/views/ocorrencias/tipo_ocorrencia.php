<div class="container">
	<div class="row">
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?= (!isset($data[0])) ? "<h1>Cadastro Tipo de Ocorrências</h1>" : "<h1>Editar Tipo de Ocorrências</h1>" ;?>
			<hr>
			<?= form_open('ocorrencias/ocorrencias/salvar_tipo_ocorrencias', array('form'=>'role', 'class'=>'form-horizontal')); ?>
				<input type="hidden" name="id" value="<?= (!isset($data[0]->id)) ? "" : $data[0]->id; ?>">
				<div class="form-group">
					<label for="ocorrencia" class="col-sm-2 control-label">Tipo</label>
					<div class="col-sm-4">
						<input type="text" name="ocorrencia" class="form-control input-sm" id="ocorrencia" placeholder="Nomenclatura do tipo de ocorrência" value="<?= (!isset($data[0]->ocorrencia)) ? "" : $data[0]->ocorrencia ; ?>" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="codigo" class="col-sm-2 control-label">Código</label>
					<div class="col-sm-4">
						<input type="text" name="codigo" class="form-control input-sm" id="codigo" placeholder="Código da ocorrência" value="<?= (!isset($data[0]->codigo)) ? "" : $data[0]->codigo ; ?>" title="" required>
					</div><!--.col-->
				</div><!--.gorm-group-->

				<div class="form-group">
					<label for="" class="col-sm-2 control-label"></label>
					<div class="col-sm-4">
						<button type="submit" class="btn btn-default btn-sm">Salvar</button>
					</div><!--.col-->
				</div><!--.gorm-group-->
			<?= form_close(); ?>
		</div><!--.col-->
		
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
		
		<!-- Listagem de todos os tipos de ocorrências. -->
		<div clas="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<hr>
			<table class="table table-hover table-bordered table-condensed">
				<thead>
					<tr>
						<th>Ocorrência</th>
						<th>Código</th>
						<th>Ações</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($tipo_ocorrencia as $row): ?>
					<tr>
						<td><?php echo $row->ocorrencia; ?></td>
						<td><?php echo $row->codigo; ?></td>
						<td>
							<a href="<?= base_url("index.php/ocorrencias/editar_tipo_ocorrencias/$row->id"); ?>" class="btn btn-default btn-xs">Editar</a>
							<button onclick="confirmarExcluir('<?= base_url("index.php/ocorrencias/delete_tipo_ocorrencias/$row->id"); ?>')" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs">Apagar</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div><!--.col-->
	</div><!--.row-->
</div><!--.container-->
