
<table class="table table-hover table-bordered table-condensed">
    <thead>
        <tr>
            <th width="5%">#</th>
            <th>Nome</th>
            <th>Matricula</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($militares->result() as $militares) : ?>
            <tr>
                <td><?php echo $militares->id; ?></td>
                <td><?php echo $militares->nome; ?></td>
                <td><?php echo $militares->matricula; ?></td>
                <td>
                    <a href="<?php echo base_url('index.php/rh/militares/editar/').'/'.$militares->id; ?>" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-pencil"></span> Editar
                    </a>
                    <a href="#" onclick="confirmarExcluir('<?php echo base_url('index.php/rh/militares/excluir/').'/'.$militares->id; ?>')" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-remove"></span> Excluir
                    </a>
                </td>
            </tr> 
        <?php endforeach; ?> 
    </tbody>
</table>
