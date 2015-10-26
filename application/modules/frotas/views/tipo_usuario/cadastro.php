<div class="container">
	<div class="well well-cadastro" >       
    <div class="panel-body">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Cadastro Tipo de Usuário</h3>
          </div>
          <div class="panel-body">
            <form class="form-horizontal" role="form">
              <div class="form-group">
                  <label for="selMilitar" class="col-sm-2 control-label">Militar</label> <!--classe aplicada para alinhar em baixo.-->
                  <div class=" col-sm-4 ">
                      <select class="form-control input-sm" id="selMilitar" >
                        <option value="0" selected>Selecione</option>
                      </select>
                  </div>
                  <div class=" col-sm-1  ">
                      <span class="control-label glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span> <!--classe aplicada para alinhar em baixo.--> 
                  </div>
              </div> 
               <div class="form-group">
                  <label for="selTipo" class="col-sm-2 control-label">Tipo de Usuário</label>
                  <div class=" col-sm-4 ">
                      <select class="form-control input-sm" id="selTipo" >
                        <option value="0" selected>Selecione</option>
                      </select>
                  </div>
                  <div class=" col-sm-1  ">
                    <span class=" control-label glyphicon glyphicon-info-sign glyphicon-align-left" title="Campo Obrigatório"></span>  <!--classe aplicada para alinhar em baixo.-->
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputSenha" class="col-sm-2 control-label">Senha</label>
                  <div class=" col-sm-4 ">
                      <input type="password" class="form-control" id="inputSenha" placeholder="">  
                  </div> 
                  <div class=" col-sm-1  ">
                      <span class=" control-label glyphicon glyphicon-info-sign glyphicon-align-left g" title="Campo Obrigatório"></span>  <!--classe aplicada para alinhar em baixo.-->
                  </div> 	
              </div>
              <div class="form-group">
                  <label for="inputSenha2" class="col-sm-2 control-label">Confirme a Senha</label>
                  <div class=" col-sm-4 ">
                      <input type="password" class="form-control" id="inputSenha2" placeholder="">  
                  </div> 
                  <div class=" col-sm-1  ">
                      <span class=" control-label glyphicon glyphicon-info-sign glyphicon-align-left g" title="Campo Obrigatório"></span>  <!--classe aplicada para alinhar em baixo.-->
                  </div> 	
              </div> 
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
                <center>
                  <button type="button" class="btn btn-danger">Home</button>
                </center>
              </div> 
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <center>
                  <button type="submit" class="btn btn-danger">Salvar</button>
                </center>
              </div>                
            </form>             
        </div> <!-- class="panel panel-danger" -->
    </div><!-- class="panel-body"-->
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Listar Usuário Ativos</h3>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <tr>
                  <th scope="col">Nº</th>
                  <th scope="col">Matrícula</th>
                  <th scope="col">Usuário</th>
                  <th scope="col">Tipo</th>
                  <th scope="col" colspan="3"> </th>
                </tr> 
                <tr>
                  <th scope="col" class="simple-text control-label"><?php echo "1"?></th>
                  <th scope="col" class="simple-text control-label"><?php echo "169.610-6"?></th>
                  <th scope="col" class="simple-text control-label"><?php echo "Sd Pereira"?></th>
                  <th scope="col" class="simple-text control-label"><?php echo "1"?></th>
                  <th scope="col" colspan="3"><button type="submit" class="glyphicon glyphicon-edit btn btn-sm  btn btn-sm btn-danger" title="Editar"><span></span></button> <button type="submit" class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Excluir"><span></span></button> <a href="#" class="a-clean">Alterar Senha</a></th>
                </tr>
              </table>
            </div><!-- class="table-responsive"-->      
          </div><!-- class="panel-body"-->
        </div><!-- class="panel panel-danger" -->
  </div><!--class="well well-cadastro"-->
</div><!--class="container"-->