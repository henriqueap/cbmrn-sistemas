
<div class="container">
    <div class="well well-cadastro" >
    	<h3 class="form-signin-heading">Lista de Serviços da Viaturas</h3>        
        <div class="panel-body">
             <div class="form-group">            	
             		<a type="button" class="glyphicon glyphicon-chevron-left   btn btn-sm btn-danger" title="Voltar para lista de viaturas"  href="<?php echo base_url('index.php/frotas/listar_viaturas/listar')?>" > <span></span></a>            	
             </div>
             <div class="row">
                    <div class="form-group">
                        <form action="#" method="post" class="form-horizontal" role="form">
                            <b class="col-sm-1 control-label">Serviço:</b> <!--classe aplicada para alinhar em baixo.-->
                            <div class=" col-sm-3 ">
                                <select class="form-control input-sm" id="selTipo" name="selTipo" required>
                                    <option value="" >Selecione</option>
                                    <?php foreach($listarTipoServicos as $listar):?>
                                    <option value="<?php echo $listar->id; ?>" ><?php echo $listar->nome; ?></option>
                                    <?php endforeach?>
                                </select>
                            </div> 
                            <input name="inputIdViaturas" id="inputIdViaturas" type="hidden" value="<?php  echo $idViatura; ?>"/>
                            <b class="col-sm-1 control-label">Período:</b>
                            <div class=" col-sm-3 ">
                                <input name="dataInicial" class="form-control" type="date" id="dataInicial" value="<?php echo date('Y-m-d')?>" />
                            </div>
                            <div class=" col-sm-3 ">
                                <input name="dataFinal" class="form-control" type="date" id="dataFinal"  value="<?php echo date('Y-m-d')?>" />
                            </div>
                            <button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro-servicos"><span></span></button>
                            <a href="<?php echo base_url('index.php/frotas/listar_viaturas/listarServicos').'/'.$idViatura?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a> 
                        </form>
                 	</div>
             </div>
             <br/>
            <div class="row" id="result-search">
        		<!--Imprime o resultado da busca --> 
        	</div>
            <div id="semFiltro">
                 <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <?php $cont=1;
                            $vazioTeste=$listarServicosId->result();
                            if (count($vazioTeste)==0):
                                echo "A viatura não tem registro de serviços."; 
                            else :?>
                        <div class="table-responsive">						
                            <table class="table table-striped">
                                <tr>
                                    <th >Nº</th>
                                    <th >Placa</th>
                                    <th >Tipo</th>
                                    <th >Início</th>
                                    <th >Conclusão</th>
                                    <th >Descrição</th>
                                </tr>
                                <?php
                                    foreach ($vazioTeste as $listar) :
                                ?>
                                <tr>
                                    <td><?php  $listar->idservicos; echo $cont++; ?></td>
                                    <td><?php echo $listar->placa; ?></td>
                                    <td><?php echo $listar->nome; ?></td>
                                    <td><?php echo  date('d/m/Y', strtotime($listar->data_inicio)); ?></td>
                                    <td><?php echo  date('d/m/Y', strtotime($listar->data_fim)); ?></td>
                                    <td><?php echo $listar->alteracao ?></td>                                                            
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
