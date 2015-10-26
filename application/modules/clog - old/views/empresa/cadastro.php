
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <?php echo (isset($dados_endereco->id)) ? "<h1>Editar de Empresas</h1>" : "<h1>Cadastro de Empresas</h1>" ;?>
    </div>
    <hr>

    <div class="col-lg-12 col-md-12 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Formulário para cadastro de empresas</h3>
        </div>
        <div class="panel-body">
            <?php
                if (isset($dados_empresa->id)) {
                    echo form_open ('clog/empresa/editar_salvar', array('class'=>'form-horizontal', 'role'=>'form')); 
                } else {
                    echo form_open ('clog/empresa/cadastro', array('class'=>'form-horizontal', 'role'=>'form'));
                }
            ?>
                <input type="hidden" name="inputIdEmpresa" value="<?php echo (isset($dados_empresa->id)) ? $dados_empresa->id : "" ; ?>">
                <input type="hidden" name="inputIdEnd" value="<?php echo (isset($dados_endereco->id)) ? $dados_endereco->id : "" ; ?>">
                <input type="hidden" name="inputIdContato" value="<?php echo (isset($dados_contato->id)) ? $dados_contato->id : "" ; ?>">
                <input type="hidden" name="inputIdTel" value="<?php echo (isset($dados_telefone->id)) ? $dados_telefone->id : "" ; ?>">

                <div class="form-group">
                    <label for="inputNome" class="col-sm-2 control-label">Nome Fantasia</label>
                    <div class=" col-sm-9 ">
                        <input type="text"  class="form-control" id="inputNome" name="inputNome" placeholder="Nome fantasia" value="<?php echo (isset($dados_empresa->nome_fantasia)) ? $dados_empresa->nome_fantasia : ""; ?>" required autofocus>             
                    </div>            
                </div>
                
                <div class="form-group">
                    <label for="inputRazao" class="col-sm-2  control-label">Razão Social</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputRazao" name="inputRazao" placeholder="Razão Social" value="<?php echo (isset($dados_empresa->razao_social)) ? $dados_empresa->razao_social : ""; ?>" required>             
                    </div>                
                </div>

                <div class="form-group">
                    <label for="inputCNPJ" class="col-sm-2 control-label">CNPJ</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputCNPJ" name="inputCNPJ" rel="cnpj" placeholder="Informe um CNPJ válido" value="<?php echo (isset($dados_empresa->cnpj)) ? $dados_empresa->cnpj : ""; ?>" required>             
                    </div>        
                </div>

                <div class="form-group">
                    <label for="Cep" class="col-sm-2 control-label">CEP</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="cep" name="cep" rel="cep" placeholder="Cep" value="<?php echo (isset($dados_endereco->cep)) ? $dados_endereco->cep : ""; ?>" required>             
                    </div>      
                </div>

                <div id="loader"><center><img src="../../assets/img/ajax-loader.gif" /></center></div>
                <div id="dadosEndereco"> 
                
                <div class="form-group">
                    <label for="inputBairro" class="col-sm-2  control-label">Bairro</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputBairro" name="inputBairro" placeholder="Bairro" value="<?php echo (isset($dados_endereco->bairro)) ? $dados_endereco->bairro : ""; ?>" required>             
                    </div>                
                </div>     
                
                <div class="form-group row">
                    <label for="inputEnd" class="col-sm-2  control-label">Logradouro</label>
                    <div class=" col-sm-6 ">
                        <input type="text" class="form-control" id="inputEnd" name="inputEnd" placeholder="Logradouro" value="<?php echo (isset($dados_endereco->logradouro)) ? $dados_endereco->logradouro : ""; ?>" required>             
                    </div>
                                
                    <label for="inputNum" class="col-sm-1  control-label ">Número</label>
                    <div class=" col-sm-2 align-right ">
                        <input type="text" class="form-control" id="inputNum" name="inputNum" placeholder="Número" value="<?php echo (isset($dados_endereco->numero)) ? $dados_endereco->numero : ""; ?>" required />             
                    </div>               
                </div>

                <div class="form-group">
                    <label for="inputCom" class="col-sm-2  control-label">Complemento</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputCom" name="inputCom" placeholder="Complemento" value="<?php echo (isset($dados_endereco->complemento)) ? $dados_endereco->complemento : ""; ?>">             
                    </div>                          
                </div>
                <div class="form-group">
                    <label for="inputCidade" class="col-sm-2  control-label">Cidade</label>
                    <div class=" col-sm-5 ">
                        <input type="text" class="form-control" id="inputCidade" name="inputCidade" placeholder="Cidade" value="<?php echo (isset($dados_endereco->cidade)) ? $dados_endereco->cidade : ""; ?>" required>             
                    </div>
                                
                    <label for="inputEstado" class="col-sm-1  control-label">Estado</label>
                    <div class=" col-sm-3 ">
                    <input type="text" class="form-control" id="inputEstado" name="inputEstado" placeholder="Estado" value="<?php echo (isset($dados_endereco->estado)) ? $dados_endereco->estado : ""; ?>" required>  
                    </div>                      
                </div>
               
                </div>             
                <div class="form-group">
                    <label for="inputNomeContato" class="col-sm-2  control-label">Contato</label>
                    <div class=" col-sm-9 ">
                        <input type="text" class="form-control" id="inputNomeContato" name="inputNomeContato"  value="<?php echo (isset($dados_contato->id)) ? $dados_contato->nome : ""; ?>"placeholder="Contato" required>  
                    </div>  
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2  control-label">Email</label>
                    <div class=" col-sm-5 ">
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" value="<?php echo (isset($dados_contato->id)) ? $dados_contato->email : ""; ?>" placeholder="Informe um Email válido" required>             
                    </div>
                                
                    <label for="inputTel" class="col-sm-1  control-label">Telefone </label>
                    <div class=" col-sm-3">
                        <input type="text" class="form-control" id="inputTel" name="inputTel" placeholder="Telefone" value="<?php echo (isset($dados_telefone->id)) ? $dados_telefone->telefone : ""; ?>" rel="telefone" required>             
                    </div>          
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
                    <center>
                        <button type="submit" class="btn btn-danger">Salvar</button>
                    </center>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
  </div>
</div>
<div>
