
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<h1><?php echo (!isset($data->id)) ? "Cadastro Grupo de Produtos" : "Editar Grupo de Produtos" ; ?></h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Formulário para cadastro de grupos</h3>
			  </div>
			  <div class="panel-body">
			    <?php echo form_open('clog/grupos/salvar', array('role'=>'form', 'class'=>'form-horizontal')); ?>
					  <input type="hidden" name="id" id="id" class="" value="<?php echo (isset($data->id)) ? $data->id : ""; ?>">

					  <div class="form-group">
			        <label for="nome" class="col-sm-2 control-label">Nome do Grupo</label>
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
		          	<input type="text" name="nome" class="form-control" id="nome" value="<?php echo (isset($data->nome)) ? $data->nome : ""; ?>" placeholder="Nome do Grupo" required/>
			        </div>
		        </div>

		        <div class="form-group">
			        <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
			        	<button type="submit" class="btn btn-default">Salvar</button>
			        </div>
		        </div>
					<?php echo form_close(); ?>
			  </div>
			</div> <!--Panel-->
		</div> <!--Cols-->
	</div> <!--.row-->
</div> <!--.container-->

<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<table class="table table-hover table-bordered table-condensed">
			  <thead>
		      <tr>
	          <th># </th>
	          <th>Nome</th>
	          <th>Ações</th>
		      </tr>
			  </thead>
			  <tbody>
		      <?php foreach ($lista as $row) : ?>
	          <tr>
	            <td><?php echo $row->id; ?></td>
	            <td><?php echo $row->nome; ?></td>
	            <td>
	            	<a href="<?php echo base_url('index.php/clog/grupos/editar').'/'.$row->id; ?>" class="btn btn-default btn-xs" id="">
	            		<span class="glyphicon glyphicon-pencil"></span> Editar
	            	</a>
	            	<a href="#" class="btn btn-default btn-xs" id="" onclick="confirmarExcluir('<?php echo base_url('index.php/clog/grupos/excluir').'/'.$row->id; ?>')" data-toggle="modal" data-target="#myModal-excluir">
	            		<span class="glyphicon glyphicon-remove"></span> Excluir
	            	</a>
	            </td>
	          </tr> 
		      <?php endforeach; ?>
			  </tbody>
			</table>
		</div>
	</div> <!--.row-->
</div> <!--.container-->
