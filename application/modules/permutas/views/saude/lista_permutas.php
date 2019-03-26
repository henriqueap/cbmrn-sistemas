<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Listar Permutas</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?php echo form_open('permutas/listar_permutas', array('role' => 'form', 'class' => 'form-horizontal')); ?>
				<!-- Permutado -->
				<div class="form-group">
					<label for="permutados_id" class="col-sm-2 control-label">Militar Permutado</label>
					<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
					<select name="permutados_id" class="form-control" id="permutados_id">
						<option value="0">Todos os Militares</option>
						<?php 
						if (isset($militares)) {
							foreach($militares as $row): ?>
								<option value="<?php echo $row->id; ?>"><?php echo $row->militar; ?></option>
							<?php endforeach; 
						} ?>
					</select>
					<button type="submit" class="btn btn-default">Recarregar</button>
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
						<tr>
							<th>Ordem</th>
							<th>Data Permuta</th>
							<th>Permutado</th>
							<th>Permutante</th>
							<th>Autorizado por</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						$count = 1; 
						if (isset($permutas) && $permutas !== FALSE) {
							foreach($permutas as $permuta): ?>
								<tr>
									<td><?php echo $count++; ?></td>
									<td><?php echo $permuta->data_servico; ?></td>
									<td><?php echo $permuta->permutado; ?></td>
									<td><?php echo $permuta->permutante; ?></td>
									<td><?php echo $permuta->autorizante; ?></td>
								</tr>
							<?php endforeach; 
						}
						else {
						?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						<?php 
						}   
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->