<!--?php #var_dump($this->session->userdata('idmilitar')); ?-->
<div class="container">
		<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
						<h1><?php echo (!isset($on_edit)) ? 'Cadastro de Turmas' : 'Editar Turmas'; ?></h1>
						<hr />
						<?php echo form_open('rh/cursos/salvar_turma', array('role' => 'form', 'class' => 'form-horizontal', 'id'=>'frm_salvar_turma')); ?>
						<input type="hidden" name="id" value="<?php echo set_value('id', isset($on_edit->id) ? $on_edit->id : ""); ?>" />
						
						<!-- cursos-->

						<div class="form-group">
								<label for="idarea" id="blinklabel" class="col-sm-2 control-label">Curso</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
									<select name="curso" class="form-control" id="idcurso" 
										onblur="if ($('#idcurso').val()==0) {
															$('#idcurso').focus();
															$('#idcurso').addClass('piscar');
															$('.piscar').fadeOut();
															$('.piscar').fadeIn();
														} else $('#idcurso').removeClass('piscar');" 
										>
												<option value="0">Selecione</option>
										<?php 
										if (!is_bool($listar_cursos)) {
											foreach($listar_cursos->result() as $curso): ?>
												<option value="<?php echo $curso->id; ?>" <?php echo (isset($on_edit->idcurso)&&$on_edit->idcurso==$curso->id)? "selected" : ""; ?>><?php echo $curso->curso; ?></option>
												<?php
											endforeach; 
										}	?>
									</select>
									
								</div>
								
						</div>
						
						<!--Data de Início das matrículas-->
						
						<div class="form-group">
								<label for="Periodo" class="col-sm-2 control-label">Início de Matrícula</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="date" name="periodo" class="form-control" id="inicio_matricula" value="<?php echo (isset($on_edit->inicio_matricula)) ? $on_edit->inicio_matricula : ''; ?>"placeholder="Data de Início da Pre-matrícula" required/>
								</div>
						</div>
						
						<!--Período de Matrículas-->
						
						<div class="form-group">
								<label for="Data Fim" class="col-sm-2 control-label">Duração</label>
								<div class="col-sm-10 col-md-3 col-lg-3 col-xs-10">
										<input type="text" name="data_fim" class="form-control" id="dias" value="<?php echo (isset($on_edit->dias)) ? $on_edit->dias : ''; ?>"placeholder="Período em dias" required/>
								</div>
								<div class="col-sm-2 col-md-1 col-lg-1 col-xs-2">
									<label for="Cargahor" class="control-label">Dias</label>
								</div>
						</div>

						<!--Data de Início do Curso-->

						<div class="form-group">
								<label for="Inicio" class="col-sm-2 control-label">Início do Curso</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="date" name="inicio" class="form-control" id="inicio" value="<?php echo (isset($on_edit->inicio)) ? $on_edit->inicio : ''; ?>"placeholder="Data de Início do Curso" required/>
								</div>
						</div>

						<!--Data de Fim do Curso-->

						<div class="form-group">
								<label for="Fim" class="col-sm-2 control-label">Fim do Curso</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="date" name="fim" class="form-control" id="fim" value="<?php echo (isset($on_edit->fim)) ? $on_edit->fim : ''; ?>"placeholder="Data de Fim do Curso" required/>
								</div>
						</div>

						<!--Instituição de Ensino-->
						
						<div class="form-group">
								<label for="Instituicao" class="col-sm-2 control-label">Instituição</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="text" name="instituicao" class="form-control" id="instituicao" value="<?php echo (isset($on_edit->instituicao)) ? $on_edit->instituicao : ''; ?>"placeholder="Nome da Instituição de Ensino" required/>
								</div>
						</div>
						
						<!-- Carga Horária-->
						
						<div class="form-group">
								<label for="Cargahor" class="col-sm-2 control-label">Carga Horária</label>
								<div class="col-sm-10 col-md-3 col-lg-3 col-xs-10">
										<input type="text" name="carga_horaria" class="form-control" id="carga_horaria" value="<?php echo (isset($on_edit->carga_horaria)) ? $on_edit->carga_horaria : ''; ?>"placeholder="Carga Horária" required/>
								</div>
								<div class="col-sm-2 col-md-1 col-lg-1 col-xs-2">
									<label for="Cargahor" class="control-label">Horas</label>
								</div>
						</div>

						<!--Local do Curso-->
						
						<div class="form-group">
								<label for="Local" class="col-sm-2 control-label">Local</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="text" name="local" class="form-control" id="local" value="<?php echo (isset($on_edit->local)) ? $on_edit->local : ''; ?>"placeholder="Local de realização do curso" required/>
								</div>
						</div>

						<!--Valor do Curso-->
						
						<div class="form-group">
								<label for="Valor" class="col-sm-2 control-label">Valor</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="text" name="valor" class="form-control" id="valor" value="<?php echo (isset($on_edit->valor)) ? $on_edit->valor : ''; ?>"placeholder="Valor do curso" required/>
								</div>
						</div>

						<!--Turma-->
						
						<div class="form-group">
								<label for="Turma" class="col-sm-2 control-label">Turma</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="text" name="turma" class="form-control" id="turma" value="<?php echo (isset($on_edit->turma)) ? $on_edit->turma : ''; ?>"placeholder="Turma" required/>
								</div>
						</div>
																		
						<!--Exercício financeiro do curso-->
						
						<div class="form-group">
								<label for="Exercicio" class="col-sm-2 control-label">Exercício</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="text" name="exercicio" class="form-control" id="exercicio" value="<?php echo (isset($on_edit->exercicio)) ? $on_edit->exercicio : ''; ?>"placeholder="Ano de Exercício" required/>
								</div>
						</div>

						<!--Quantidade de vagas-->
						
						<div class="form-group">
								<label for="vagas" class="col-sm-2 control-label">Vagas</label>
								<div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
										<input type="text" name="vagas" class="form-control" id="vagas" value="<?php echo (isset($on_edit->vagas)) ? $on_edit->vagas : ''; ?>"placeholder="Vagas" required/>
								</div>
						</div>

						<!--Botão Salvar-->

						<div class="form-group">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
										<input type="button" onclick="if ($('#idcurso').val()==0) {
															$('#idcurso').focus();
															$('#idcurso').addClass('piscar');
															$('.piscar').fadeOut();
															$('.piscar').fadeIn();
														} else { $('#idcurso').removeClass('piscar'); $('#frm_salvar_turma').submit();}"
														value="Salvar" class="btn btn-primary" />
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
					<th >Período</th>			<!--Duas Informações-->
					<th >Instituição</th>
					<th >Turma/Ano</th>		<!--Duas Informações-->
					<th >Vagas</th>
					<th >Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if (! $turmas_cursos) { ?>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></td></tr>
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
						<td>
							<a type="button" class="btn btn-default btn-xs" id="editar_turma"
								href="<?php echo base_url('index.php/rh/cursos/editar_turma').'?id='.$turma->id; ?>">
								<span class="glyphicon glyphicon-pencil"></span> Editar
							</a>
							<a id="bt_lista_solicitacoes" type="button" class="btn btn-default btn-xs" data-turma="<?php echo $turma->id; ?>" href="<?php //echo base_url('index.php/rh/cursos/listar_solicitacoes').'?id='.$turma->id; ?>">
							<span class="glyphicon glyphicon-remove"></span> Solicitações
							</a>
						</td>
					</tr> 
				<?php endforeach; 
				}?>        
			</tbody>
		</table>
</div>
<div id="militares_turma"></div>