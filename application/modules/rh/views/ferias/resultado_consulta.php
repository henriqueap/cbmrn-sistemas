<table class="table table-hover table-bordered table-condensed">
    <thead>
        <tr>
            <th width="5%">#</th>
            <th>Número</th>
            <th>Data de Início</th>
            <th>Data de Termino</th>
            <th>Exercicio</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($turma->result() as $turma) : ?>
            <tr>
                <?php $data_fim = date('Y-m-d', strtotime("+30 days", strtotime($turma->data_inicio))); ?>
                <td><?php echo $turma->id; ?></td>
                <td><?php echo $turma->numero; ?> ° Turma</td>
                <td><?php echo $turma->data_inicio; ?></td>
                <td><?php echo $data_fim; ?></td>
                <td><?php echo $turma->exercicio; ?></td>  
                <td>
                    <a href="<?php echo base_url('index.php/rh/ferias/editar/').'/'.$turma->id; ?>" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-pencil"></span> Editar
                    </a>
                    <a href="#" onclick="confirmarExcluir('<?php echo base_url('index.php/rh/ferias/excluir/').'/'.$turma->id; ?>')" data-toggle="modal" data-target="#myModal-excluir" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-remove"></span> Excluir
                    </a>
                </td>
            </tr> 
        <?php endforeach; ?>        
    </tbody>
</table>