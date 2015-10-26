<div class="container">	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12">
			<table class="table table-hover table-bordered table-condensed" id="content">
			  <thead>
		      <tr>
	          <th>Militar</th>
	          <th>Matricula</th>
	          <th>Motivo</th>
	          <th>Justificativas</th>
	          <th>Período</th>
	          <th>Ações</th>
		      </tr>
			  </thead>
			  <tbody>
			  <tbody>
		      <?php foreach ($consulta as $consulta) : ?>
	          <tr>
	            <td width="25%"><?php echo $consulta->militares_nome; ?></td>
	            <td width="8%"><?php echo $consulta->matricula; ?></td>
	            <td><?php echo $consulta->tipo_afastamentos; ?></td>
	            <td width="25%"><?php echo $consulta->justificativas; ?></td>
	            <td width="18%"><?php echo $consulta->data_inicio." Até ".$consulta->data_fim; ?></td>
	            <td>
	            	<a href="#" class="btn btn-default btn-xs" id="" onclick="confirmarExcluir('<?php echo base_url('index.php/rh/afastamentos/cancelar_afastamentos/').'/'.$consulta->idafastamentos; ?>')" data-toggle="modal" data-target="#myModal-excluir">
	            		<span class="glyphicon glyphicon-remove"></span> Cancelar
	            	</a>
	            </td>
	          </tr> 
		      <?php endforeach; ?>
			  </tbody>
			</table>
		</div>
	</div><!-- /.row -->
</div><!-- /.container -->