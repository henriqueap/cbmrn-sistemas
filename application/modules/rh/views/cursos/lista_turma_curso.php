<!--div class="container">
		<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
						<h1><?php #echo (!isset($on_edit)) ? 'Solicitações da Turma' : 'Editar Turmas'; ?></h1>
						<hr />
						<?php #echo form_open('rh/cursos/lista_turma_curso', array('role' => 'form', 'class' => 'form-horizontal', 'id'=>'frm_salvar_turma')); ?>
						<input type="hidden" name="id" value="<?php #echo set_value('id', isset($on_edit->id) ? $on_edit->id : ""); ?>" />

				</div>
		</div>
</div-->
<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12">
		<h1>Turmas Ativas</h1>
		<hr />
		<table class="table table-hover table-bordered table-condensed">
			<thead>
				<tr>
					<th >#</th>
					<th >Nome</th>
					<th >Status da Matrícula</th>
					<th >Cursado</th>
					<th >Motivo do Indeferimento</th>
					<th >Nota</th>
					<th >Prioridade</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					if (! $militares_turma) { ?>
						<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></td></tr>
						<?php 
					} else{
				foreach ($militares_turma->result() as $aluno) : ?>
					<tr>
						<td><?php echo $aluno->id; ?></td>
						<td><?php echo $aluno->nome; ?></td>
						<td><?php echo $aluno->matriculado; ?></td>
						<td><?php echo $aluno->cursado; ?></td>
						<td><?php echo $aluno->motivos; ?></td>
						<td><?php echo $aluno->nota; ?></td>
						<td><?php echo $aluno->prioridade; ?></td>
					</tr> 
				<?php endforeach; 
				}?>        
			</tbody>
		</table>
</div>