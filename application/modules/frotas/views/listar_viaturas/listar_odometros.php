<div class="container">
    <div class="well well-cadastro" >
    	<h3 class="form-signin-heading">Lista de Odômetros da Viaturas</h3>        
        <div class="panel-body">
             <div class="form-group"> 
             	<div class="col-sm-1 ">
             		<a type="button" class="glyphicon glyphicon-chevron-left   btn btn-sm btn-danger" title="Voltar para lista de viaturas"  href="<?php echo base_url('frotas/listar_viaturas/listar')?>" > <span></span></a>
             	</div>
             
               <form action="#" method="post" class="form-horizontal" role="form">
                 		<input name="inputIdViaturas" id="inputIdViaturas" type="hidden" value="<?php  echo $idViatura; ?>"/>
                        <label  class="col-sm-2 control-label">Período entre</label>
                        <div class=" col-sm-3 ">
                            <input name="dataInicial" class="form-control" type="date" id="dataInicial" size="10" value="<?php echo date('Y-m-d')?>"/>
                        </div>
                        <label  class="col-sm-1 control-label">e </label>
                         <div class=" col-sm-3 ">
                            <input name="dataFinal" class="form-control" type="date" id="dataFinal" size="10" value="<?php echo date('Y-m-d')?>" />
                        </div>
                        <button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro"><span></span></button>
                        <a href="<?php echo base_url('frotas/listar_viaturas/listarOdometros').'/'.$idViatura?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a>        
			    </form>  
                </div>
             <br />
            <div class="row" id="result-search">
        		<!--Imprime o resultado da busca -->

        	</div>
            <div id="semFiltro">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <?php  $cont=1;
                            $vazioTeste=$listarOdometrosId->result();
                            if (count($vazioTeste)==0):
                               echo "A viatura não tem registro de odômetro."; 
                           else :?>
                        <div class="table-responsive">						
                            <table class="table table-striped">
                                <tr>
                                    <th>Nº</th>
                                    <th>Odômetro</th>
                                    <th>Data</th>
                                    <th>Alteração</th>
                                    <th>Destino</th>
                                    <th>Tipo</th>
                                    <th>Usuário</th>
                                    <th></th>
                                   
                                </tr>
                                <?php
                                    foreach ($vazioTeste as $listar) :
                                ?>
                                <tr>
                                    <td><?php $listar->idodometros; echo $cont++; ?></td>
                                    <td><?php echo $listar->odometro; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($listar->data)); ?></td>
                                    <td><?php echo $listar->alteracao; ?></td>
                                    <td><?php echo $listar->destino; ?> </td>
                                    <?php if($listar->tipo==1){?>
                                    <td><?php echo "Saída do quartel" ?> </td>
                                    <?php }if ($listar->tipo==2) {?>
                                    <td><?php echo "Retorno ao quartel" ?> </td>
                                    <?php }if ($listar->tipo==3){?>
                                    <td><?php echo "Início de Serviço Operacional." ?> </td>
                                    <?php }if ($listar->tipo==4){?>
                                    <td><?php echo "Término de Serviço Operacional." ?> </td>
                                    <?php }if ($listar->tipo==5){?>
                                    <td><?php echo "Início de Serviço na viatura."?> </td>
                                    <?php }if ($listar->tipo==6){?>
                                    <td><?php echo "Conclusão de Serviço na viatura."?> </td>
                                    <?php }if ($listar->tipo==7){?>
                                    <td><?php echo "Abastecimento"?> </td>
                                    <?php } ?>
                                    <td><?php echo $listar->sigla." ".$listar->nome_guerra; ?></td>
                                    <td>  
                                        <a title="Editar" type="button" class=" btn-xs btn-default " href=" <?php echo base_url('frotas/listar_viaturas/editarOdometros').'/'.$listar->idodometros;?>"><span class="glyphicon glyphicon-pencil"></span>
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
            </div> 
            </div>
        </div>
    </div>
</div>