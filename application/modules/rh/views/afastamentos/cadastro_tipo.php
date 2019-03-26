<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12">
		<h1><?= (!isset($data->id)) ? 'Cadastro de Tipo de Afastamento' : 'Editar Tipo de Afastamento'; ?></h1>
		<hr />
		<?php echo form_open('rh/afastamentos/salvar_tipo', array('role' => 'form', 'class' => 'form-horizontal')); ?>
		<!--hidden-->
		<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />

		<div class="form-group">
			<label for="nome" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Tipo de Afastamento</label>
			<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
				<input type="text" name="nome" class="form-control" id="nome" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" placeholder="Tipo de Afastamento"/>
			</div>
		</div><!--/.form-group-->

		<div class="form-group">
			<label for="sigla" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Dias</label>
			<div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
				<input type="text" name="dias" class="form-control" id="dias" value="<?= set_value('Dias', isset($data->dias) ? $data->dias : ""); ?>" placeholder="Dias de Afastamento"/>
			</div>
		</div><!--/.form-group-->

		<div class="form-group">
			<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
				<input type="submit" value="Salvar" class="btn btn-primary" />
			</div>
		</div><!--/.form-group-->
		<?php echo form_close(); ?>
	</div>
</div><!--/.container-->
<div class="container">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <h1>Tipos de Afastamento Cadastrados</h1>
    <hr />
    <table class="table table-hover table-bordered table-condensed">
      <thead>
        <tr>
          <th width="5%">#</th>
          <th width="70%">Tipo de Afastamento</th>
          <th width="5%">Dias</th>
          <th width="20%">Ações</th>                            
        </tr>
      </thead>
      <tbody>
        <?php foreach ($listar_afastamentos->result() as $tipo_afastamento) : ?>
          <tr>
            <td><?php echo $tipo_afastamento->id; ?></td>
            <td><?php echo $tipo_afastamento->nome; ?></td>
            <td><?php echo ($tipo_afastamento->dias > 0)? "$tipo_afastamento->dias dias" : "Atestado"; ?></td>
            <td>
              <a type="button" class="btn btn-default btn-xs" 
              	href="<?php echo base_url('index.php/rh/afastamentos/editar_tipo').'/'.$tipo_afastamento->id; ?>">
        				<span class="glyphicon glyphicon-pencil"></span> Editar
              </a>
              <a type="button" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs" 
              	onclick="confirmarExcluir('<?php echo base_url('index.php/rh/afastamentos/excluir_tipo') . '/' . $tipo_afastamento->id; ?>')" href="#">
                <span class="glyphicon glyphicon-remove"></span> Excluir
              </a>
            </td>
         	</tr> 
        <?php endforeach; ?>        
      </tbody>
    </table>
</div>
