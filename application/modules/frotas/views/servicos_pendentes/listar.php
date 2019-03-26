 <div id="modal">
    <div class="modal fade" id="myModal-Cancelado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Atenção!</h3>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente cancelar este serviço?</p>
                </div>
                <div class="modal-footer">
                    <button  type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <a type="button" class="btn btn-primary" id="bt-modal-confirmar-cancelar-servico" href="#">Sim</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 
</div>
<div class="container">
    <div class="well well-cadastro" >       
    	<h3 class="form-signin-heading">Serviços Pendentes</h3>        
        <div class="panel-body">
            <div class="row">  
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                     <a type="button"  class="btn btn-danger" href="<?php echo base_url('index.php/frotas/index')?>"  >Home</a>  
                </div>
                
                    <div class="form-group">
                      <form action="#" method="post" class="form-horizontal" role="form">
                        <b class="control-label col-sm-2" for="dataInicial">Período entre </b>
                        <div class="col-lg-3">
                            <input type="date" class="form-control" name="dataInicial" id="dataInicial" placeholder="" required>
                        </div> 
                        <div class="col-lg-3">
                            <input type="date" class="form-control" name="dataFinal" id="dataFinal"  placeholder="" required>
                        </div>
                            <button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro-pendentes"><span></span></button>
                            <a href="<?php echo base_url('index.php/frotas/servicos_pendentes/listar')?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a> 
                      </form>
                    </div>
                    </br>
            </div>
            <div class="row" id="result-search">
                <!--Imprime o resultado da busca -->

            </div>
            <div id="semFiltro">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Nº</th>
                                    <th>Placa</th>
                                    <th>Empresa</th>
                                    <th>Tipo de Serviço</th>
                                    <th>Descrição</th>
                                    <th>Situação</th>
                                    <th>Ações</th>
                                </tr>
                                
                                <?php 
    							$cont=1;
    							foreach ($listar_pendentes as $lista) : 
    									if($lista->situacao_id < 4){
    							?>
                                		
                                <tr>  
                                    <td><?php echo $cont++; ?></td>
                                    <td> <?php echo $lista->placa; ?> </a></b></td>
                                    <td><?php echo $lista->nome_fantasia; ?></td>
                                    <td><?php echo $lista->nome; ?></td>
                                    <?php  if ($lista->alteracao == "") {?>
                                        <td><?php echo "Não existem alteração neste servico." ?></td>
                                    <?php } else { ?>
                                        <td><?php echo $lista->alteracao; ?></td>
                                    <?php } ?>
                                    <td><?php echo $lista->statusDescricao; ?></td>
                                    <td>
                                    <?php  if ($lista->situacao_id != 6 && $lista->retroativo == 0) {?> 
                                        <a type="button" data-toggle="modal" data-target="#myModal-Cancelado" class="btn btn-default btn-xs" onclick="confirmarCancelarServico('<?php echo base_url('index.php/frotas/servicos_pendentes/atualizarStatusCancelado').'/'.$lista->idServico;?>')">
                                            <span title="Cancelar Serviço" class="glyphicon glyphicon-remove"></span>
                                        </a>
                                        <?php  if ($lista->situacao_id >= 2 ) {?>
                                        <a title="Detalhamento Serviço" class="btn btn-default btn-xs" href="<?php echo base_url('index.php/frotas/servicos_pendentes/detalhamento').'/'.$lista->idServico;?>" >
                                            <span  class="glyphicon glyphicon-plus"></span>
                                        </a>
                                        <?php }if ($lista->autorizado == 1 && $lista->situacao_id == 2) {?> 
                                            <a title="Executar Serviço" class="btn btn-default btn-xs" href="<?php echo base_url('index.php/frotas/servicos_pendentes/execucaoServico').'/'.$lista->idServico;?>" >
                                             <span  class="glyphicon glyphicon-play"></span>
                                            </a>
                                        <?php }?>

                                        <?php if($lista->justificado == "" && $lista->situacao_id == 1){ ?>
                                            <a id="autorizacao" role="button" class="btn btn-danger btn-xs" data-toggle="modal"   href="#myModal-Autorizar<?php echo $lista->idServico?>">
                                            <!--<a type="button" data-toggle="modal" data-target="#myModal-Autorizar" class="btn btn-danger btn-xs" onclick="#">-->
                                                <span title="Autorizar Serviço" class="glyphicon glyphicon-ok"></span>
                                            </a>
                                    <?php }
                                        }else{?>
                                            <a title="Detalhamento Serviço" class="btn btn-default btn-xs" href="<?php echo base_url('index.php/frotas/servicos_pendentes/detalhamento').'/'.$lista->idServico;?>" >
                                                <span  class="glyphicon glyphicon-plus"></span>
                                            </a>
                                      <?php  } ?>
                                        <div id="autorizacaoModal">
                                             <div id="myModal-Autorizar<?php echo $lista->idServico?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                          <h3 id="myModalLabel">Autorização</h3>
                                                        </div>
                                                        <?php echo form_open('frotas/servicos_pendentes/cadastrarJustificativa',array('class'=>'form-horizontal','role'=>'form')); ?>
                                                            <div class="modal-body">
                                                                <input type="hidden" id="idServico "name="idServico" value="<?php echo $lista->idServico?>">
                                                                <p>Justificativa</p>
                                                                <textarea class="form-control" name="txtJustificativa" style="width:400px;height:100px" placeholder="Digite alguma justificativa para autorizar ou não o serviço."></textarea>
                                                                <p>O serviço será autorizado?</p>
                                                                <input id="ckbAutorizado" name="ckbAutorizado" type="checkbox" value="1" onclick="">
                                                                <label for="ckbAutorizado"> Sim </label>
                                                                <input id="ckbAutorizado" name="ckbAutorizado" type="checkbox" value="0" onclick="">
                                                                <label for="ckbAutorizado"> Não </label>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button  type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                                                <input title="Autorizar" id="modal-form-submit" type="submit" name="submit" class="btn btn-primary" href"#" value="Enviar"/>
                                                                </div>
                                                        <?php echo form_close ();?>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </td>

                                </tr>
                                 

                                <?php 
                                } endforeach; ?>


                            </table>
                        </div>           
            		</div>
                </div>
            </div>
        </div>
    </div>
</div>
