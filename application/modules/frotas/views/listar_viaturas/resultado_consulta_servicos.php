﻿
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php $cont=1;
	$vazioTeste=$listarServicosId->result();
	if (count($vazioTeste)==0):
		echo "A viatura não tem registro de serviços."; 
	else :?>
    <div class="table-responsive">						
        <table class="table table-striped">
            <tr>
                <th >Nº</th>
                <th >Placa</th>
                <th >Tipo</th>
                <th >Início</th>
                <th >Conclusão</th>
                <th >Descrição</th>
               
            </tr>
            <?php foreach ($vazioTeste as $listar) : ?>
            <tr>
                <td><?php  $listar->idservicos; echo $cont++; ?></td>
                <td><?php echo $listar->placa; ?></td>
                <td><?php echo $listar->nome; ?></td>
                <td><?php echo  date('d/m/Y', strtotime($listar->data_inicio)); ?></td>
                <td><?php echo  date('d/m/Y', strtotime($listar->data_fim)); ?></td>
                <td><?php echo $listar->alteracao ?></td>                                                            
            </tr>
            <?php 																
                endforeach ;
                endif;
            ?>
        </table>
    </div>
</div>

