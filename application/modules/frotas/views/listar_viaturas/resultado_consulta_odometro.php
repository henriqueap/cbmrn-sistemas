
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	 <?php $cont=1;
            $vazioTeste=$listarOdometrosId->result();
            if (count($vazioTeste)==0):
                 echo "A viatura não tem registro de odômetro."; 
            else : ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Nº</th>
                    <th>Odômetro</th>
                    <th>Data</th>
                    <th>Alteração</th>
                    <th>Destino</th>
                    <th>Usuário</th>
                    <th></th>
                   
                </tr>
                <?php
                    foreach ($vazioTeste as $listar) :
                ?>
                <tr>
                    <td><?php  $listar->idodometros; echo $cont++; ?></td>
                    <td><?php echo $listar->odometro; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($listar->data)); ?></td>
                    <td><?php echo $listar->alteracao; ?></td>
                    <td><?php echo $listar->destino; ?> </td>
                    <td><?php echo $listar->sigla." ".$listar->nome_guerra; ?></td>
                    <td>  
                        <a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('index.php/frotas/listar_viaturas/editarOdometros').'/'.$listar->idodometros;?>"><span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>                                
                </tr>
                <?php 																
                    endforeach ;
                    endif;
                ?>
            </table>
        </div>
</div>
      
