
<div class="container">
		<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
						<h1><?php echo (!isset($on_edit)) ? 'Cadastro de Cursos' : 'Editar Cursos'; ?></h1>
						<hr />
						<?php echo form_open('rh/cursos/salvar_curso', array('role' => 'form', 'class' => 'form-horizontal')); ?>
						<input type="hidden" name="id" value="<?php echo set_value('id', isset($on_edit->id) ? $on_edit->id : ""); ?>" />
						<!-- cursos-->
						<div class="form-group">
								<label for="curso" class="col-sm-2 control-label">Curso</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<input type="text" name="curso" class="form-control" id="curso" value="<?php echo (isset($on_edit->curso)) ? $on_edit->curso : ''; ?>"placeholder="Nome do Curso por extenso" required/>
								</div>
						</div>
						
						<!-- Sigla-->
						<div class="form-group">
								<label for="sigla" class="col-sm-2 control-label">Sigla</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<input type="text" name="sigla" class="form-control" id="sigla" value="<?php echo (isset($on_edit->sigla)) ? $on_edit->sigla : ''; ?>"placeholder="Sigla do Curso" required/>
								</div>
						</div>
						<!-- area-->
						<div class="form-group">
                <label for="idarea" class="col-sm-2 control-label">Área</label>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                	<select name="area" class="form-control" id="idarea">
                        <option value="0">Selecione</option>
                		<?php foreach($listar_areas->result() as $area): ?>
                			<option value="<?php echo $area->id; ?>" <?php echo (isset($on_edit->idarea)&&$on_edit->idarea==$area->id)? "selected" : ""; ?>><?php echo $area->area; ?></option>
                		<?php endforeach; ?>
                	</select>
                </div>
            </div>
						<div class="form-group">
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
										<input type="submit" value="Salvar" class="btn btn-primary" />
								</div>
						</div>
						<?php echo form_close(); ?>
				</div>
		</div>
</div>
<div class="container">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <h1>Cursos Cadastrados</h1>
    <hr />
    <table class="table table-hover table-bordered table-condensed">
      <thead>
        <tr>
          <th >#</th>
          <th >Curso</th>
          <th >Sigla</th>
          <th >Área</th>
          <th >Natureza</th>
          <th >Ações</th>                            
        </tr>
      </thead>
      <tbody>
        <?php 
        	if (! $listar_cursos) { ?>
        		<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
        		<?php 
        	} else{
        foreach ($listar_cursos->result() as $curso) : ?>
          <tr>
            <td><?php echo $curso->id; ?></td>
            <td><?php echo $curso->curso; ?></td>
            <td><?php echo $curso->sigla; ?></td>
            <td><?php echo $curso->area; ?></td>
            <td><?php echo ($curso->operacional == 0)? "Administrativo" : "Operacional"; ?></td>
            <td>
              <a type="button" class="btn btn-default btn-xs" 
              	href="<?php echo base_url('index.php/rh/cursos/editar_curso').'?id='.$curso->id; ?>">
        				<span class="glyphicon glyphicon-pencil"></span> Editar
              </a>
              <a type="button" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs" 
              	onclick="confirmarExcluir('<?php echo base_url('index.php/rh/cursos/excluir_curso') . '/' . $curso->id; ?>')" href="#">
                <span class="glyphicon glyphicon-remove"></span> Excluir
              </a>
            </td>
         	</tr> 
        <?php endforeach; 
        }?>        
      </tbody>
    </table>
</div>