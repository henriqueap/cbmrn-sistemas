
<div class="container">
	<div class="well well-cadastro">       
		<h3 class="form-signin-heading">Cadastro de Empresa</h3> 
		<div class="panel-body"> 
			<?php echo form_open('frotas/empresa/cadastro',array('class'=>'form-horizontal','role'=>'form')); ?>
				<div class="form-group">
					<label for="inputNome" class="col-sm-2 control-label">Nome Fantasia</label>
					<div class=" col-sm-9 ">
						<input type="text"  class="form-control" id="inputNome" name="inputNome" placeholder="" required autofocus>             
					</div>       	
				</div>
				<div class="form-group">
					<label for="inputRazao" class="col-sm-2  control-label">Razão Social</label>
					<div class=" col-sm-9 ">
						<input type="text" class="form-control" id="inputRazao" name="inputRazao" placeholder="" required>             
					</div> 	
				</div>
				<div class="form-group">
					<label for="inputCNPJ" class="col-sm-2 control-label">CNPJ</label>
					<div class=" col-sm-5 ">
						<input type="text" class="form-control" id="inputCNPJ" name="inputCNPJ" rel="cnpj" placeholder="Informe um CNPJ válido" required>             
					</div>
					<div id="loader2"><center><img src="../../assets/img/ajax-loader.gif" /></center></div>       	
					<label for="selAtivo" class="col-sm-2 control-label">Ativa</label>
					<div class=" col-sm-2 ">
						<select class="form-control input-sm" name="selAtivo" id="selAtivo" required>
							<option value>Selecione</option>
							  <option value="1">Sim</option>                                               	
							  <option value="0">Não</option>                            
						</select>         
					</div> 	
				</div>
				<div id="formComplete"> 
					<div class="form-group">
						<label for="Cep" class="col-sm-2 control-label">CEP</label>
						<div class=" col-sm-9 ">
							<input type="text" class="form-control" id="cep" name="cep" rel="cep" placeholder="" required>             
						</div>         	
					</div>
					<div id="loader"><center><img src="../../assets/img/ajax-loader.gif" /></center></div>

					<div id="dadosEndereco"> 
					
					<div class="form-group">
						<label for="inputBairro" class="col-sm-2  control-label">Bairro</label>
						<div class=" col-sm-9 ">
							<input type="text" class="form-control" id="inputBairro" name="inputBairro"placeholder=""required>             
						</div>          	
					</div>     
					<div class="form-group row">
						<label for="inputEnd" class="col-sm-2  control-label">Logradouro</label>
						<div class=" col-sm-6 ">
							<input type="text" class="form-control" id="inputEnd" name="inputEnd"placeholder=""required>             
						</div>        	
				   <!-- </div>               
					<div class="form-group">-->
						<label for="inputNum" class="col-sm-1  control-label ">Número</label>
						<div class=" col-sm-2 align-right ">
							<input type="text" class="form-control" id="inputNum" name="inputNum" placeholder="" required style="" >             
						</div>          	
					</div>
					<div class="form-group">
						<label for="inputCom" class="col-sm-2  control-label">Complemento</label>
						<div class=" col-sm-9 ">
							<input type="text" class="form-control" id="inputCom" name="inputCom"placeholder="">             
						</div>                         	
					</div>
					<div class="form-group">
						<label for="inputCidade" class="col-sm-2  control-label">Cidade</label>
						<div class=" col-sm-5 ">
							<input type="text" class="form-control" id="inputCidade" name="inputCidade"placeholder="" disabled >             
						</div>         	
					<!--</div>
					<div class="form-group">-->
						<label class="col-sm-1  control-label">Estado</label>
						<div class=" col-sm-3 ">
						<input type="text" class="form-control" id="inputEstado" name="inputEstado" placeholder="" disabled>  
						</div> 
					</div>
					</div>             
					<div class="form-group">
						<label for="inputNomeContato" class="col-sm-2  control-label"> Contato</label>
						<div class=" col-sm-9 ">
							<input type="text" class="form-control" id="inputNomeContato" name="inputNomeContato"placeholder=""required>  
						</div> 	
					</div>
					<div class="form-group">
						<label for="inputEmail" class="col-sm-2  control-label">Email</label>
						<div class=" col-sm-6 ">
							<input type="email" class="form-control" id="inputEmail" name="inputEmail"placeholder="Informe um Email válido"required>             
						</div>        	
					<!--</div>
					<div class="form-group">-->
						<label for="inputTel" class="col-sm-1  control-label">Telefone </label>
						<div class=" col-sm-2">
							<input type="text" class="form-control" id="inputTel" name="inputTel"placeholder="" rel="telefone" required>             
						</div>       	
					</div>
					<div class="form-group">
						<label for="inputEmail" class="col-sm-2  control-label">Login</label>
						<div class=" col-sm-4 ">
							<input type="text" class="form-control" id="inputLogin" name="inputLogin"placeholder="Informe um Login"required>             
						</div>          
					<!--</div>
					<div class="form-group">-->
						<label for="inputTel" class="col-sm-1  control-label">Senha </label>
						<div class=" col-sm-4">
							<input type="password" class="form-control" id="inputSenha" name="inputSenha"placeholder="" required>             
						</div>          
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" >
					<center>
						<button type="button" class="btn btn-danger">Home</button>
					</center>
				</div> 
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
					<center>
						<button type="submit" id="btnSalvar" class="btn btn-danger" >Salvar</button>
					</center>
				</div>
			<?php echo form_close ();?>
		</div> <!--panel-->
	</div> <!--well-->
</div><!--container-->