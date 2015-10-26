
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th >Nº</th>
                        <th >Placa</th>
                        <th >Tipo</th>
                        <th >Início</th>
                        <th >Justificativa para a não Autorização</th>
                        <th >Cancelado</th>
                    </tr>
                    <tr> 
                    <?php 
                    $cont=1;
                    foreach ($listar_cancelados_nao_autorizados->result() as $lista) :
                        if($lista->situacao_id==6){ ?>
                                 
                            <tr>            
                                <td><?php echo $cont++; ?></td>
                                <td> <?php echo $lista->placa ?> </a></b></td>
                                <td><?php echo $lista->nomeServico; ?></td>
                                <td><?php echo date('d/m/Y',strtotime($lista->data_inicio)); ?></td>
                                <?php if($lista->justificado!="" && $lista->autorizado==0){  ?>
                                    <td><?php echo $lista->justificado; ?></td><?php } else {?>
                                    <td><?php echo "O serviço foi autorizado." ?></td>
                                
                                <?php } ?>
                                <td><?php echo "Sim" ?></td>
                            </tr>
                            <?php 
                            
                        }else{ ?>
                            <?php if($lista->justificado!="" && $lista->autorizado==0){  ?>
                                <tr>            
                                    <td><?php echo $cont++; ?></td>
                                    <td> <?php echo $lista->placa; ?> </a></b></td>
                                    <td><?php echo $lista->nomeServico; ?></td>
                                    <td><?php echo date('d/m/Y',strtotime($lista->data_inicio)); ?></td>
                                    <td><?php echo $lista->justificado; ?></td>
                                    <td><?php echo "Não" ?></td>
                                </tr>
                            <?php }  ?>

                    <?php
                        }
                    endforeach ?>  
                </table>
            </div>           
    	</div>

