<div class="container">
    <div class="well well-cadastro" >       
    	<h3 class="form-signin-heading">Serviços Cancelado e Não Autorizados</h3> 
        <div class="panel-body">
            <div class="form-group">             
                <a type="button"  class="btn btn-danger" href="<?php echo base_url('index.php/frotas/index')?>"  >Home</a>              
            </div>
            <div class="row">
                <div class="form-group">
                    <form action="#" method="post" class="form-horizontal" role="form">
                        <b class="col-sm-1 control-label">Serviço:</b> <!--classe aplicada para alinhar em baixo.-->
                        <div class=" col-sm-3 ">
                            <select class="form-control input-sm" id="intTipo" name="intTipo" required>
                                <option value="" >Selecione</option>
                                <option value="1" ><?php echo "Cancelados" ?></option>
                                <option value="2" ><?php echo "Não Autorizados" ?></option>
                            </select>
                        </div> 
                        <b class="col-sm-1 control-label">Período:</b>
                        <div class=" col-sm-3 ">
                            <input name="dataInicial" class="form-control" type="date" id="dataInicial" value="<?php echo date('Y-m-d')?>" />
                        </div>
                        <div class=" col-sm-3 ">
                            <input name="dataFinal" class="form-control" type="date" id="dataFinal"  value="<?php echo date('Y-m-d')?>" />
                        </div>
                        <button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro-cancelados-nao-autorizados"><span></span></button>
                        <a href="<?php echo base_url('index.php/frotas/servicos_cancelados_autorizados/listar')?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a> 
                    </form>
                </div>
             </div>
            </br>
            <div class="row" id="result-search">
                <!--Imprime o resultado da busca --> 
            </div>
            <div id="semFiltro">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <?php $cont=1;
                                if($listar_nenhum_servico == false){
                                ?>
                                <div class="well alert-danger">Não existe nenhum serviço cadastrado.</div>
                               <?php
                                }else{?>
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
                                foreach ($listar_cancelados_nao_autorizados as $lista) :
                                    if($lista['situacao_id']==6){ ?>
                                             
                                        <tr>            
                                            <td><?php echo $cont++; ?></td>
                                            <td> <?php echo $lista['placa']; ?> </a></b></td>
                                            <td><?php echo $lista['nomeServico']; ?></td>
                                            <td><?php echo date('d/m/Y',strtotime($lista['data_inicio'])); ?></td>
                                            <?php if($lista['justificado']!="" && $lista['autorizado']==0){  ?>
                                                <td><?php echo $lista['justificado']; ?></td><?php } else {?>
                                                <td><?php echo "O serviço foi autorizado." ?></td>                                            
                                            <?php }  ?> 
                                                <td><?php echo "Sim" ?></td>                                           
                                        </tr>
                                        <?php 
                                        
                                    }else{ ?>
                                        <?php if($lista['justificado']!="" && $lista['autorizado']==0){  ?>
                                            <tr>            
                                                <td><?php echo $cont++; ?></td>
                                                <td> <?php echo $lista['placa']; ?> </a></b></td>
                                                <td><?php echo $lista['nomeServico']; ?></td>
                                                <td><?php echo date('d/m/Y',strtotime($lista['data_inicio'])); ?></td>
                                                <td><?php echo $lista['justificado']; ?></td>
                                                <td><?php echo "Não" ?></td>
                                            </tr>
                                        <?php }  ?>

                                <?php
                                    }
                                endforeach;
                                } ?>  
                            </table>
                        </div>           
            		</div>
                </div>
                
            </div>
        </div>
    </div>
</div>