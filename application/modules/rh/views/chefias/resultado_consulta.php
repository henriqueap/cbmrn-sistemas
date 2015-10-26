<div class="container">
	<div class="row">
		<table class="table table-hover table-bordered table-condensed">
		  <thead>
	      <tr>
          <th># </th>
          <th>Nome</th>
          <th>Lotação</th>
          <th>Ações</th>
	      </tr>
		  </thead>
		  <tbody>
		  <tbody>
	      <?php foreach ($consulta->result() as $consulta) : ?>
          <tr>
            <td></td>
            <td><?php echo $consulta->militar_nome; ?></td>
            <td><?php echo $consulta->lotacoes_nome; ?></td>
            <td>
            	<a href="#" class="btn btn-default btn-xs" id="" onclick="confirmarExcluir('<?php echo base_url('index.php/rh/chefias/excluir/').'/'.$consulta->idchefias; ?>')" data-toggle="modal" data-target="#myModal-excluir">
            		<span class="glyphicon glyphicon-remove"></span> Excluir
            	</a>
            </td>
          </tr> 
	      <?php endforeach; ?>
		  </tbody>
		</table>
	</div><!-- /.row -->
</div><!-- /.container -->