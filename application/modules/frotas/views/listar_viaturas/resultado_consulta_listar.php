<?php if ($listar_viaturas===FALSE) {
    echo "Não existem viaturas ativas neste setor.";
} else{?>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
   <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>Nº</th>
                <th>Placa</th>
                <th>Prefixo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <!--<th>Ano</th>
                <th>Óleo(Km)</th>
                <th>Revisão(Km)</th>-->
                <th>Setor</th>
                <th>Op.</th>
                <th>Alt</th>
                <th>Exc</th>
                <th>Serv</th>
                <th>Abst</th>
                <th>Odo</th>
            </tr>
            <?php $cont=1;
                foreach ($listar_viaturas->result() as $listar) :
                 
            ?>
            <tr>
                <td><?php  $listar->idviaturas; echo $cont++; ?></td>
                <td><?php echo $listar->placa; ?></td>
                <td><?php echo $listar->prefixo; ?></td>
                <td><?php echo $listar->nomeMarca; ?></td>
                <td><?php echo $listar->modelo; ?></td>
                <!--<td><?php //echo "2012"; ?> </td>
                <td><?php //echo "10000"; ?></td>
                <td><?php //echo "10000"; ?></td>-->
                <td><?php echo $listar->sigla; ?></td>
                
                <?php 
                if($listar->viaturasAtivo==1){
                    if($listar->operante==0){?>
                        <td>
                            <a title="Marcar como Operante" type="button" class="btn-xs btn-danger" href="<?php echo base_url('frotas/listar_viaturas/atualizarOperante').'/'.$listar->idviaturas;?>"><span  class="glyphicon glyphicon-remove-circle"></span>
                            </a>
                        </td> 
                    <?php 
                    }else{
                    ?>
                        <td>
                            <a title="Marcar como Inoperante" type="button" class="btn-xs btn-success"href="<?php echo base_url('frotas/listar_viaturas/atualizarOperante').'/'.$listar->idviaturas;?>"><span  class="glyphicon glyphicon-ok-circle"></span>
                            </a>
                        </td> 
                    <?php
                        }
                    ?>
                    <td>
                        <a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('frotas/listar_viaturas/editar').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>                                   
                    <td>
                    <!-- Tentar fazer modal funcionar aqui --> 
                        <a title="Excluir viatura" type="button" <?php /*?>type="button" data-toggle="modal" data-target="#myModal-excluir"<?php */?> class="btn-xs btn-success" <?php /*?>onclick="confirmarExcluir('<?php echo base_url('frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>')"<?php */?> href="<?php echo base_url('frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>">
                        <span class="glyphicon glyphicon-remove"></span>
                       </a>
                    </td>
                    <td>
                        <a title="Histórico de Abastecimento"  class="btn-xs btn-default"  href="<?php echo base_url('frotas/listar_viaturas/listarServicos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-usd"></span>
                        </a>
                    </td>
                    <td>
                        <a title="Histórico de Serviços"  class="btn-xs btn-default"  href="<?php echo base_url('frotas/listar_viaturas/listarAbastecimentos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-filter"></span>
                        </a><span title="Histórico de Abastecimentos" class="glyphicon glyphicon-"></span>
                    </td>
                    <td><a title="Listar odômetros da viatura" type="button" class=" btn-xs btn-default " href="<?php echo base_url('frotas/listar_viaturas/listarOdometros').'/'.$listar->idviaturas;?>"><span title="Histórico de Odômetro" class="glyphicon glyphicon-map-marker"></span></a></td>
                <?php } else {?>
                    <td title="Função desabilitada"></td>
                    <td title="Função desabilitada"></td>
                                                
                    <td>
                        <a title="Reativar viatura" <?php /*?>type="button" data-toggle="modal" data-target="#myModal-reativar"<?php */?> class="btn-xs btn-danger" <?php /*?>onclick="confirmarExcluir('<?php echo base_url('frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>')"<?php */?> href="<?php echo base_url('frotas/listar_viaturas/excluir').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-ok"></span>
                        </a>
                    </td>
                    <td>
                        <a title="Histórico de Serviços"  class="btn-xs btn-default"  href="<?php echo base_url('frotas/listar_viaturas/listarServicos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-usd"></span>
                        </a>
                    </td>
                    <td>
                        <a title="Histórico de Abastecimentos"  class="btn-xs btn-default"  href="<?php echo base_url('frotas/listar_viaturas/listarAbastecimentos').'/'.$listar->idviaturas;?>"><span class="glyphicon glyphicon-filter"></span>
                        </a><span title="Histórico de Abastecimento" class="glyphicon glyphicon-"></span>
                    </td>
                    <td><a title="Listar odômetros da viatura" type="button" class=" btn-xs btn-default " href="<?php echo base_url('frotas/listar_viaturas/listarOdometros').'/'.$listar->idviaturas;?>"><span title="Histórico de Odômetro" class="glyphicon glyphicon-map-marker"></span></a></td>
                <?php }?>
            </tr>
            <?php 
                endforeach ;
            ?>
        </table>
    </div>
</div> 
<?php } ?> 
