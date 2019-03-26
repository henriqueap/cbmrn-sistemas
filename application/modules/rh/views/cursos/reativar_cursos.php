<?php 
/*echo "<pre>";
	var_dump($this->input->post('ativo'));
echo "</pre>";*/
?>

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<h1><?php echo (!isset($on_edit)) ? 'Reativar Cursos' : 'Editar Cursos'; ?></h1>
			<?php 
			echo form_open('rh/cursos/reativar_cursos', array('role' => 'form', 'class' => 'form-horizontal')); ?>
				<input type="hidden" name="id" value="<?php echo set_value('id', isset($on_edit->id) ? $on_edit->id : ""); ?>" />
				<table class="table table-hover table-bordered table-condensed">
					<thead>
						<tr>
							<th >ID</th>
							<th >Curso</th>
							<th >Área</th>
							<th >Instituição</th>
							<th >Natureza</th>
							<th >Ações</th>                            
						</tr>
					</thead>
					<tbody>
						<?php 
							if (! $listar_cursos) { ?>
								<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
								<?php 
							} 
							else{
								foreach ($listar_cursos->result() as $curso) : ?>
									<tr>
										<td><?php echo $curso->id; ?></td>
										<td><?php echo $curso->curso; ?></td>
										<td><?php echo $curso->area; ?></td>
										<td><?php echo $curso->instituicao; ?></td>
										<td><?php echo ($curso->operacional == 0)? "Administrativo" : "Operacional"; ?></td>
										<td>
											<div class="form-group">
												<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
														<div class="checkbox">
															<input type="checkbox" name="ativo[<?php echo $curso->id; ?>]"><label for="ativo"> Ativar</label>
														</div>
												</div>
											</div>
										</td>
									</tr> 
								<?php endforeach; 
							}?>        
					</tbody>
				</table>
				<div class="form-group">
					<div style="text-align: right;" class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-sm-offset-2">
						<input type="submit" value="Salvar" class="btn btn-primary" />
					</div>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>