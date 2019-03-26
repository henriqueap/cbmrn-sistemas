<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<div class="container">
    <div class="well well-cadastro" >       
    	<h3 class="form-signin-heading">Serviços Concluídos</h3> 
        <div class="panel-body">
            <div class="form-group">             
                <a type="button"  class="btn btn-danger" href="<?php echo base_url('index.php/frotas/index')?>"  >Home</a>              
            </div>
            <div class="row">
                <div class="form-group">
                    <form action="#" method="post" class="form-horizontal" role="form">
                        <b class="col-sm-1 control-label">Viaturas:</b> <!--classe aplicada para alinhar em baixo.-->
                        <div class=" col-sm-3 ">
                            <select class="form-control input-sm" id="idViatura" name="idViatura" required>
                                <option value="" >Selecione</option>
                                <?php foreach($listar_viaturas as $listar):?>
                                <option value="<?php   echo $listar->id; ?>" ><?php echo $listar->placa; ?></option>
                                <?php endforeach?>
                            </select>
                        </div> 
                        <b class="col-sm-1 control-label">Período:</b>
                        <div class=" col-sm-3 ">
                            <input name="dataInicial" class="form-control" type="date" id="dataInicial" value="<?php echo date('Y-m-d')?>" />
                        </div>
                        <div class=" col-sm-3 ">
                            <input name="dataFinal" class="form-control" type="date" id="dataFinal"  value="<?php echo date('Y-m-d')?>" />
                        </div>
                        <button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro-concluidos"><span></span></button>
                        <a href="<?php echo base_url('index.php/frotas/servicos_concluidos/listar')?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a> 
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
                                <?php
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
                                    <th >Conclusão</th>
                                    <th >Entrega</th>
                                    <th >Descrição</th>
                                    <th >Valor</th>
                                    <th ></th>
                                </tr>
                                <tr> 
                                <?php 
                                $cont=1;
                                $total = 0;
                                foreach ($listar_concluidos as $lista) :
                                    if($lista['situacao_id']>=4 && $lista['situacao_id']<=5){
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
                                            <td>
                                                <?php if ($lista['situacao_id'] == 4 && $lista['data_entrega'] == "" ) {?>
                                                <a id="autorizacao" role="button" class="btn btn-danger btn-xs" data-toggle="modal"   href="#myModal-Entregue<?php echo $lista['idServico']?>">
                                                <!--<a type="button" data-toggle="modal" data-target="#myModal-Autorizar" class="btn btn-danger btn-xs" onclick="#">-->
                                                    <span title="Autorizar Serviço" class="glyphicon glyphicon-ok"></span>
                                                </a>
                                                <?php } ?>   
                                                <div id="modal">
                                                <div class="modal fade" id="myModal-Entregue<?php echo $lista['idServico']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <h3 id="myModalLabel">Atenção!</h3>
                                                            </div>
                                                            <?php echo form_open('frotas/servicos_concluidos/atualizarStatusEntregue',array('class'=>'form-horizontal','role'=>'form')); ?>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-md-12 col-xs-12">
                                                                            <input type="hidden" id="idServico "name="idServico" value="<?php echo $lista['idServico']?>">
                                                                            <p>A viatura realmente já foi entregue?</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-4 col-md-4 col-xs-">
                                                                            <p>Data de Entrega:</p>
                                                                        </div>
                                                                        <div class="col-lg-5 col-md-5 col-xs-5">
                                                                            <input type="date" class="form-control" name="data" id="data" placeholder="" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                           

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                                                                <input title="Confirmar Entrega" id="modal-form-submit" type="submit" name="submit" class="btn btn-primary" href"#" value="Enviar"/>
                                                            </div>
                                                             <?php echo form_close ();?>
                                                        </div><!-- /.modal-content -->
                                                    </div><!-- /.modal-dialog -->
                                                </div><!-- /.modal --> 
                                            </div>     
                                            </td>
                                            
                                        </tr>
                                        <?php 
                                $total +=  $lista['valorNotas']; 
                                }  endforeach;
                            ?>  
                            </table>
                        </div>           
            		</div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="title-alert text-right">
                            <b>Total: <?php echo number_format($total,2,',','.')  ?></b>  
                        </div>                		
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>