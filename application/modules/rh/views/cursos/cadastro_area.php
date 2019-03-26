
<div class="container">
		<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
						<h1><?php echo (!isset($on_edit)) ? 'Cadastro de Áreas de Cursos' : 'Editar Áreas de Cursos'; ?></h1>
						<hr />
						<?php echo form_open('rh/cursos/salvar_area', array('role' => 'form', 'class' => 'form-horizontal')); ?>
						<input type="hidden" name="id" value="<?php echo set_value('id', isset($on_edit->id) ? $on_edit->id : ""); ?>" />
						<div class="form-group">
								<label for="area" class="col-sm-2 control-label">Área do Curso</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<input type="text" name="area" class="form-control" id="area" value="<?php echo (isset($on_edit->area)) ? $on_edit->area : ''; ?>"placeholder="Área do Curso"/>
								</div>
						</div>

						<div class="form-group">
								<label for="data_inicio" class="col-sm-2 control-label">Natureza</label>
								<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
										<div class="checkbox">
											<input type="checkbox" name="operacional" value="1" <?php echo (isset($on_edit) && $on_edit->operacional==1)?'checked':''; ?> ><label for="operacional"> Operacional</label>
										</div>
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
    <h1>Áreas Cadastrados</h1>
    <hr />
    <table class="table table-hover table-bordered table-condensed">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th width="70%">Área</th>
          <th width="5%">Natureza</th>
          <th width="20%">Ações</th>                            
        </tr>
      </thead>
      <tbody>
        <?php 
        	if (! $listar_areas) { ?>
        		<tr><td></td><td></td><td></td><td></td></tr>
        		<?php 
        	} else{
        foreach ($listar_areas->result() as $area) : ?>
          <tr>
            <td><?php echo $area->id; ?></td>
            <td><?php echo $area->area; ?></td>
            <td><?php echo ($area->operacional == 0)? "Administrativo" : "Operacional"; ?></td>
            <td>
              <a type="button" class="btn btn-default btn-xs" 
              	href="<?php echo base_url('index.php/rh/cursos/editar_area').'?id='.$area->id; ?>">
        				<span class="glyphicon glyphicon-pencil"></span> Editar
              </a>
              <a type="button" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs" 
              	onclick="confirmarExcluir('<?php echo base_url('index.php/rh/cursos/excluir_area') . '/' . $area->id; ?>')" >
                <span class="glyphicon glyphicon-remove"></span> Excluir
              </a>
            </td>
         	</tr> 
        <?php endforeach; 
        }?>        
      </tbody>
    </table>
</div>