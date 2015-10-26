
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php $cont=1;
    $vazioTeste=$listarAbastecimentosId->result();
    if (count($vazioTeste)==0):
         echo "A viatura não tem registro de Abastecimentos."; 
 else : ?>
<div class="table-responsive">						
    <table class="table table-striped">
        <tr>
            <th >Nº</th>
            <th >Placa</th>
            <th >Odômetro</th>
            <th >Data</th>
            <th >Litros</th>
        </tr>
        <?php
            foreach ($vazioTeste as $listar) :	
        ?>
        <tr>
            <td><?php  $listar->idabastecimentos; echo $cont++; ?></td>
            <td><?php echo $listar->placa; ?></td>
            <td><?php echo $listar->odometro; ?></td>
            <td><?php echo  date('d/m/Y', strtotime($listar->data)); ?></td>
            <td><?php echo $listar->litros ?></td>                                                            
        </tr>
        <?php 																
            endforeach ;
            endif;
        ?>
    </table>
</div>
