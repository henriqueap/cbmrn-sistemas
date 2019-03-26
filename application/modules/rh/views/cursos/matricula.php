<!--?php #var_dump($this->session->userdata('idmilitar')); ?-->
<div class="container">
		<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
						<h1>Solicitação de Matrícula</h1>
						<hr />
						<?php echo form_open('rh/cursos/solicitar_matricula', array('role' => 'form', 'class' => 'form-horizontal', 'id'=>'frm_salvar_turma')); ?>
						<input type="hidden" name="id" value="<?php echo set_value('id', isset($on_edit->id) ? $on_edit->id : ""); ?>" />
						
						<!-- Matrícula funcional do militar-->

						<div class="form-group">
							<label for="matricula" class="col-sm-2">Matrícula</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
									<input type="text" rel="matricula" class="form-control" id="search-id-matricula" name="matricula" placeholder="Matrícula" required />
									 <!-- <input type="hidden" class="form-control input-xs input-sm" id="chefe_militares_id" name="chefe_militares_id" required /> -->
									<input type="hidden" name="militar_id_hidden" id="militar_id_hidden" value="" />
								</div>
							<div class="col-sm-6">
								<label class="control-label" id="nome_militar"></label>
							</div>
						</div>

						<!-- cursos-->

						<div class="form-group">
								<label for="idarea" id="blinklabel" class="col-sm-2 control-label">Curso</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
									<select name="curso" class="form-control" id="idcurso" >
										<option value="0">Selecione</option>
										<?php 
										if (!is_bool($turmas_cursos)) {
											foreach($turmas_cursos->result() as $curso): ?>
												<option value="<?php echo $curso->id; ?>" <?php echo (isset($on_edit->idcurso)&&$on_edit->idcurso==$curso->id)? "selected" : ""; ?>><?php echo $curso->curso.' - '.$curso->turma_ano; ?></option>
												<?php
											endforeach; 
										}	?>
									</select>
									
								</div>
						</div>
						
						<!--Botão Solicitar-->

						<div class="form-group">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
										<input type="submit" value="Solicitar" class="btn btn-primary" />
								</div>
						</div>
						<?php echo form_close(); ?>

				</div>
		</div>
</div>
<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12">
		<h1>Turmas Ativas</h1>
		<hr />
		<table class="table table-hover table-bordered table-condensed">
			<thead>
				<tr>
					<th >#</th>
					<th >Curso</th>
					<th >Período</th>		<!--Duas Informações-->
					<th >Instituição</th>
					<th >Turma/Ano</th>		<!--Duas Informações-->
					<th >Vagas</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if (! $turmas_cursos) { ?>
						<tr><td></td><td></td><td></td><td></td><td></td></tr></td></tr>
						<?php 
					} else{
				foreach ($turmas_cursos->result() as $turma) : ?>
					<tr>
						<td><?php echo $turma->id; ?></td>
						<td><?php echo $turma->curso; ?></td>
						<td><?php echo $turma->periodo; ?></td>
						<td><?php echo $turma->instituicao; ?></td>
						<td><?php echo $turma->turma_ano; ?></td>
						<td><?php echo $turma->vagas; ?></td>
					</tr> 
				<?php endforeach; 
				}?>        
			</tbody>
		</table>
</div>