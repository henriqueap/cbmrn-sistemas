<div class="container">
  	<div class="well well-cadastro" >       
      <h3 class="form-signin-heading">Relatório Geral de Viaturas</h3>
         <div class="panel-body">
              <form class="form-horizontal" role="form">
                 <div class="form-group">
                 
                    <b class="col-sm-2 control-label">Selecione os Filtros</b>
                    <div class=" text-right">
                	<label for="selFiltro" class="simple-text col-sm-1 control-label ">Setor:</label> <!--classe aplicada para alinhar em baixo.-->
                </div>
          		<div class=" col-sm-3 ">
    				<select class="form-control input-sm" id="selLotacao" >
           				<option value="" >Selecione</option>
                        <?php foreach($listar_lotacoes->result() as $lotacoes):?>
                        <option value="<?php echo $lotacoes->id?>" ><?php echo $lotacoes->nome?></option>
                        <?php endforeach?>
            		</select>
          		</div> 
                <div class=" text-right">
                	<label for="selFiltro2" class="simple-text col-sm-2 control-label ">Tipo de Viatura:</label> <!--classe aplicada para alinhar em baixo.-->
                </div>
          		<div class=" col-sm-3 ">
    				<select class="form-control input-sm" id="selTipoViatura" >
                    	 <option value="" >Selecione</option>
           				 <option value="2">Administrativa</option>
                         <option value="1" >Operacional</option>
            		</select>
          		</div> 
             		<button type="button" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-filtro-relatorio"><span></span></button>
                    <a href="<?php echo base_url('index.php/frotas/relatorio_geral/relatorio')?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a>		
                 </div>
                
               </form>
          <div class="row" id="result-search">
        		<!--Imprime o resultado da busca -->

          </div>
              <div id="semFiltro">
                  <div class="panel panel-success">
                    <div class="panel-heading">            
                         <h4>Viaturas Operantes</h4>                
                     </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table">
                    
                        <tr >
                           <th >Nº</th>
                            <th >Placa</th>
                            <th >Prefixo</th>
                            <th >Marca</th>
                            <th>Modelo</th>
                            <th >Ano</th>
                            <th >Óleo(Km)</th>
                            <th >Revisão(Km)</th>
                            <th>Setor</th>
                        </tr>
                         <?php $cont=1;
                              foreach ($listar_relatorios->result() as $listar) :
                              if ($listar->viaturasOperante==1){            
                         ?>
                        <tr>
                            <td ><?php echo  $cont++; ?></td>
                            <td ><?php echo $listar->placa; ?></td>
                            <td ><?php echo $listar->prefixo; ?></td>
                            <td><?php echo $listar->nomeMarca; ?></td>
                            <td ><?php echo $listar->modelo; ?></td>
                            <td ><?php echo  $listar->ano_fabricacao;  ?></td>
                            <td ><?php echo  $listar->km_oleo  ?></td>
                            <td ><?php echo  $listar->km_revisa;  ?></td>
                            <td><?php echo $listar->sigla; ?></td>
                        </tr>
                        <?php } endforeach;
                               ?> 
                    </table>
                    </div> 
                    <div class="panel panel-danger">
                    <div class="panel-heading">            
                         <h4>Viaturas Inoperantes</h4>                
                     </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table">
                        <tr >
                           <th >Nº</th>
                            <th >Placa</th>
                            <th >Prefixo</th>
                            <th >Marca</th>
                            <th>Modelo</th>
                            <th >Ano</th>
                            <th >Óleo(Km)</th>
                            <th >Revisão(Km)</th>
                            <th>Setor</th>
                        </tr>
                        <?php $cont=1;
                              foreach ($listar_relatorios->result() as $listar) :
                              if ($listar->viaturasOperante==0){            
                         ?>
                        <tr>
                            <td ><?php echo  $cont++; ?></td>
                            <td ><?php echo $listar->placa; ?></td>
                            <td ><?php echo $listar->prefixo; ?></td>
                            <td><?php echo $listar->nomeMarca; ?></td>
                            <td ><?php echo $listar->modelo; ?></td>
                            <td ><?php echo  $listar->ano_fabricacao;  ?></td>
                            <td ><?php echo  $listar->km_oleo  ?></td>
                            <td ><?php echo  $listar->km_revisa;  ?></td>
                            <td><?php echo $listar->sigla; ?></td>
                        </tr> 
                        <?php } 			endforeach;
                        
                               ?> 
                    </table>
                    </div> 
              </div>
          </div>                    
    </div>
</div>