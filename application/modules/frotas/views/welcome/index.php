
<div class="container">
    <div class="jumbotron" id="jumbo-mens-ini">
    	<h2>Bem vindo ao Sistema de Gerenciamento de Frotas</h2>
        <p >Este sistema tem por finalidade aumentar o controle sobre as demandas do setor de transporte e garantir um gerenciamento mais eficaz das frotas. Deve ser uma ferramenta de trabalho dinâmica e fácil que auxilie a equipe, o setor e os prestadores de serviço.</p>
    </div> 
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        	<div class="panel panel-danger">
            	<div class="panel-heading">
            	   <h3 class="panel-title">Alertas</h3>
             	</div>      
                <div class="panel-body">         
                     <div class="title-alert" >
                        <p>Óleo</p>
                     </div>
                     <div>
                        <?php
                            foreach($lista_oleo as $lista){                                                    
                                if($lista['opcao_oleo'] == 4){
                                    echo "".$lista['placa']." - Revisão dos ". $lista['proxima']." km foi <b>ultrapassada</b>. Km atual: ". $lista['maior']." <br>";
                                } 
                                if($lista['opcao_oleo'] == 3){
                                    echo "".$lista['placa']." - Revisão dos ". $lista['proxima']." km está <b>próxima</b>.<br>";
                                } 
                               if($lista['opcao_oleo'] == 2){                                   
                                   echo "".$lista['placa']." - Primeira Revisão dos ". $lista['km_oleo']." km foi <b>ultrapassada</b>. Km atual: ". $lista['maior']."<br>";
                                }
                                if($lista['opcao_oleo']==1){
                                   echo "".$lista['placa']." - Primeira  Revisão dos ". $lista['km_oleo']." km está <b>próxima</b>. Km atual: ". $lista['maior']." <br>";
                                }                                                         
                            }
                        ?>
                     </div>
                     <div class="title-alert" >                 
                        <p>Revisão</p>
                     </div> 
                     <div>
                        <?php
                        foreach($lista_revisao as $lista){                                                    
                            if($lista['opcao_revisa'] == 4){
                                echo "".$lista['placa']." - Revisão dos ". $lista['proxima']." km foi <b>ultrapassada</b>. Km atual: ". $lista['maior']." <br>";
                            } 
                            if($lista['opcao_revisa'] == 3){
                                echo "".$lista['placa']." - Revisão dos ". $lista['proxima']." km está <b>próxima</b>.<br>";
                            } 
                           if($lista['opcao_revisa'] == 2){                                   
                               echo "".$lista['placa']." - Primeira Revisão dos ". $lista['km_revisa']." km foi <b>ultrapassada</b>. Km atual:". $lista['maior']." <br>";
                            }
                            if($lista['opcao_revisa']==1){
                               echo "".$lista['placa']." - Primeira  Revisão dos ". $lista['km_revisa']." km está <b>próxima</b>. Km atual:". $lista['maior']." <br>";
                            }                                                         
                        }
                        ?>
                     </div>                            
                </div>
            </div>
       </div>       
       <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="panel panel-danger">
     		    <div class="panel-heading">
                   <h3 class="panel-title">Viaturas aguardando retirada...</h3>
                </div>
                <div class="panel-body">
                    <div class="stat-col" id="prontas">
                        <?php
                        foreach ($lista_pendentes->result() as $lista ) {
                          if($lista->situacao_id==1){
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    
                                        <td> <?php echo $lista->placa; ?> </a></b></td>
                                        <td><a id="autorizacao" role="button" class="btn btn-danger btn-xs" data-toggle="modal"   href="#myModal-Autorizar<?php echo $lista->idServico?>">
                                            <!--<a type="button" data-toggle="modal" data-target="#myModal-Autorizar" class="btn btn-danger btn-xs" onclick="#">-->
                                                <span title="Autorizar Serviço" class="glyphicon glyphicon-ok"></span>
                                            </a>
                                        </td>
                                    
                                </table>
                            </div> 
                            <?php
                            }
                            ?>
                            <div id="autorizacaoModal">
                                 <div id="myModal-Autorizar<?php echo $lista->idServico?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
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
                        <?php
                        }
                        
                       
                        ?>
                    </div><!--prontas-->            
                </div>
            </div>
		</div>	
	</div>
</div>