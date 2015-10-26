<div class="container">
    <div class="well well-cadastro">       
    	<h3 class="form-signin-heading">Atualizar Dados da Empresa</h3> 
        <div class="panel-body"> 
        	<?php echo form_open ('frotas/listar_empresa/atualizar',array('class'=>'form-horizontal','role'=>'form'));?>
                <div class="form-group">
                    <label for="inputNome" class="col-sm-2 control-label">Nome Fantasia</label>
                    <div class="col-sm-9 ">
                    	<input type="hidden" name="inputIdEnd" value="<?php echo $listarPeloId->idenderecos; ?>">
                        <input type="text"  class="form-control" id="inputNome" value="<?php  echo $listarPeloId->nome_fantasia; ?>" name="inputNome" placeholder="" required autofocus>             
                    </div>
                    <div class="col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>       	
                </div>
                <div class="form-group">
                    <label for="inputRazao" class="col-sm-2  control-label">Razão Social</label>
                    <div class="col-sm-9 ">
                        <input type="text" class="form-control" id="inputRazao" value="<?php echo $listarPeloId->razao_social; ?>"name="inputRazao" placeholder="" required>             
                    </div>
                    <div class="col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                </div>
                <div class="form-group">
                    <label for="inputCNPJ" class="col-sm-2 control-label">CNPJ</label>
                    <div class="col-sm-4 ">
                        <input type="text" class="form-control" id="inputCNPJ"  value="<?php echo $listarPeloId->cnpj; ?>"name="inputCNPJ" rel="cnpj" placeholder="Informe um CNPJ válido" required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                    <label for="selAtivo" class="col-sm-2 control-label">Ativa</label>
                    <div class="col-sm-2 ">
                        <select class="form-control input-sm" name="selAtivo" id="selAtivo" required>
                        	<?php if ($listarPeloId->ativo == 1) {?>
                        		<option value="<?php echo $listarPeloId->ativo; ?>">Sim</option>
                              	<option value="0">Não</option> 
                              <?php }else{ ?>                                                                            	
                              <option value="<?php echo $listarPeloId->ativo; ?>">Não</option>
                              <option value="1">Sim</option> 
                              <?php }?>                           
                    	</select>         
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                </div>
                <div class="form-group">
                    <label for="Cep" class="col-sm-2 control-label">CEP</label>
                    <div class="col-sm-9 ">
                    	<input type="hidden" name="inputIdEmpresa" value="<?php echo $listarPeloId->idempresa; ?>">
                        <input type="text" class="form-control" id="cep" value="<?php  echo $listarPeloId->cep; ?>" name="cep" rel="cep" placeholder="" required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                </div>      
                
                <div class="form-group">
                    <label for="inputBairro" class="col-sm-2  control-label">Bairro</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputBairro" value="<?php echo $listarPeloId->bairro; ?>"name="inputBairro"placeholder=""required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                </div>     
                <div class="form-group row">
                    <label for="inputEnd" class="col-sm-2  control-label">Logradouro</label>
                    <div class=" col-sm-5 ">
                        <input type="text" class="form-control" id="inputEnd" value="<?php echo $listarPeloId->logradouro; ?>"name="inputEnd"placeholder=""required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
               <!-- </div>               
                <div class="form-group">-->
                    <label for="inputNum" class="col-sm-1  control-label ">Número</label>
                    <div class=" col-sm-2 align-right ">
                        <input type="text" class="form-control" id="inputNum" value="<?php echo $listarPeloId->numero; ?>"name="inputNum" placeholder="" required style="" >             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                </div>
                <div class="form-group">
                    <label for="inputCom" class="col-sm-2  control-label">Complemento</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputCom" value="<?php echo $listarPeloId->complemento; ?>" name="inputCom"placeholder="">             
                    </div>                         	
                </div>
                <div class="form-group">
                    <label for="inputCidade" class="col-sm-2  control-label">Cidade</label>
                    <div class=" col-sm-4 ">
                        <input type="text" class="form-control" id="inputCidade" value="<?php echo $listarPeloId->cidade; ?>"name="inputCidade"placeholder=""required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
            	<!--</div>
                <div class="form-group">-->
                    <label for="inputEstado" class="col-sm-1  control-label">Estado</label>
                    <div class=" col-sm-3 ">
                    <input type="text" class="form-control" id="inputEstado" value="<?php echo $listarPeloId->estado; ?>"name="inputEstado"placeholder=""required>  
                       <!-- <select class="form-control input-sm" id="selEstado" name="selEstado"required>
                            <option value>Selecione</option>
                            <?php //foreach($listar_estados->result() as $estados) : ?>                    	
                             <option value="<?php //echo $estados->id; ?>"><?php //echo $estados->nome." - ".$estados->sigla; ?></option>
                            <?php //endforeach; ?>

                        </select>-->
                    </div> 
                    <div class=" col-sm-1  ">
                            <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div> 	
                </div>
               
                      
                <div class="form-group">
                    <label for="inputNomeContato" class="col-sm-2  control-label"> Contato</label>
                    <div class=" col-sm-9 ">
                    	<input type="hidden" name="inputIdContato" value="<?php echo $listarPeloId->idcontato; ?>">
                        <input type="text" class="form-control" id="inputNomeContato" value="<?php  echo $listarPeloId->nome; ?>"name="inputNomeContato"placeholder=""required>  
                    </div> 
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div> 	
                </div>
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2  control-label">Email</label>
                    <div class=" col-sm-5 ">
                        <input type="email" class="form-control" id="inputEmail" value="<?php echo $listarPeloId->email; ?>"name="inputEmail"placeholder="Informe um Email válido"required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                <!--</div>
                <div class="form-group">-->
                    <label for="inputTel" class="col-sm-1  control-label">Telefone </label>
                    <div class=" col-sm-2">
                    	<input type="hidden" name="inputIdTel" value="<?php echo $listarPeloId->idtelefone; ?>">
                        <input type="text" class="form-control" id="inputTel" value="<?php echo $listarPeloId->telefone; ?>"name="inputTel"placeholder="" rel="telefone" required>             
                    </div>
                    <div class=" col-sm-1  ">
                        <span class="glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> 
                    </div>          	
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
                    <center>
                        <button type="button" class="btn btn-danger">Home</button>
                    </center>
                </div> 
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                    <center>
                        <button type="submit" class="btn btn-danger">Atualizar</button>
                    </center>
                </div>
    	<?php echo form_close ();?>
    	</div> 
    </div> 
</div><!--container-->
