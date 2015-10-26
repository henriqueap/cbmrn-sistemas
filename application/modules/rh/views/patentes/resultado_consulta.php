<div class="container">
    <h1>Consulta de Patentes</h1>
    <hr />
    <table class="table table-hover table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="75%">Patente</th>
                <th width="20%">Ações</th>                            
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patentes->result() as $patente) : ?>
                <tr>
                    <td><?php echo $patente->id; ?></td>
                    <td><?php echo $patente->nome; ?></td>
                    <td>
                        <a type="button" class="btn btn-default btn-xs" href="<?php echo base_url('index.php/rh/patentes/editar') . '/' . $patente->id; ?>">
                            <span class="glyphicon glyphicon-pencil"></span> Editar
                        </a>
                        <a type="button" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs" onclick="confirmarExcluir('<?php echo base_url('index.php/rh/patentes/excluir') . '/' . $patente->id; ?>')" href="#">
                            <span class="glyphicon glyphicon-remove"></span> Excluir
                        </a>
                    </td>
                </tr> 
            <?php endforeach; ?>        
        </tbody>
    </table>
</div><!--/.container-->