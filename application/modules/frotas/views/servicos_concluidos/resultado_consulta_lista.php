<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
        <table class="table table-striped">
            
           
            <tr>
                <th >Nº</th>
                <th >Placa</th>
                <th >Tipo</th>
                <th >Início</th>
                <th >Conclusão</th>
                <th >Entrega</th>
                <th >Descrição</th>
                <th >Valor</th>
            </tr>
            <tr> 
            <?php 
            $cont=1;
            $total = 0;
            foreach ($listar_concluidos as $lista) :
                if($lista['situacao_id']>=3 && $lista['situacao_id']<=4){
                    ?>     
                    <tr>            
                        <td><?php echo $cont++; ?></td>
                        <td> <?php echo $lista['placa']; ?> </a></b></td>
                        <td><?php echo $lista['nomeServico']; ?></td>
                        <td><?php echo date('d/m/Y',strtotime($lista['data_inicio'])); ?></td>
                        <td><?php echo date('d/m/Y',strtotime($lista['data_fim'])); ?></td>
                        <?php if($lista['data_entrega']==""){?>
                        <td><?php echo "Ainda não foi entregue." ?></td>
                        <?php } else { ?>
                        <td><?php echo date('d/m/Y',strtotime($lista['data_entrega'])); ?></td>
                        <?php  } if ($lista['alteracao'] == "") {?>
                        <td><?php echo "Não existem alteração neste servico." ?></td>
                        <?php } else { ?>
                        <td><?php echo $lista['alteracao']; ?></td>
                        <?php } ?>
                        <td><?php echo "R$ ".number_format($lista['valorNotas'],2,',','.');  ?></td>
                    </tr>
                    <?php 
            $total +=  $lista['valorNotas']; 
            }  
            endforeach;
            ?>  
        </table>
    </div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="title-alert text-right">
            <b>Total: <?php echo number_format($total,2,',','.')  ?></b>  
        </div>                      
    </div>
</div>
</div>    