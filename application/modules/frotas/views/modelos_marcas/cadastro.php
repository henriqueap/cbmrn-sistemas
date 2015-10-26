<!-- HTML Modal -->
<div id="modal">
    <div class="modal fade" id="myModal-desativar-tipo-modelo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Atenção!</h3>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente desativar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <a type="button" class="btn btn-primary" id="bt-modal-confirmar-desativar" href="#">Sim</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 
</div>

<!-- HTML Modal -->
<div id="modal">
    <div class="modal fade" id="myModal-reativar-tipo-modelo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Atenção!</h3>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente reativar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <a type="button" class="btn btn-primary" id="bt-modal-confirmar-reativar" href="#">Sim</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 
</div>

<div class="container">
  <div>
    <?php echo form_open('frotas/modelos_marcas/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
    <input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />       
    <h3 class="form-signin-heading">Modelos</h3> 
    <div class="panel-body"> 
      <form class="form-horizontal" role="form">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Cadastrar ou Editar</h3>
              </div>      
              <div class="panel-body">
                
                  <div class="form-group  ">
                    <label for="selMarca" class="col-sm-5 col-xs-12 control-label"><?= (!isset($data->id)) ? 'Marca' : 'Marca Selecionada'; ?></label>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                        <select class="form-control" id="selMarca" name="selMarca" <?php //(!isset($data->id)) ?  ?>>                          
                          <?php //if(!isset($data->marca_veiculos_id) == FALSE): ?>
                             <!-- <option value="<?php //set_value('marca_veiculos_id', isset($data->marca_veiculos_id) ? $data->marca_veiculos_id : ""); ?>"> <?php // (isset($data2)) ? $data2['nome'] : '' ; ?>  </option>
                            <?php //else: ?>  --> 
                              <option value="0" selected>Selecione a marca</option>
                              <?php foreach($listar_marcas as $marcas) : 
                                  if($data->marca_veiculos_id!=""){?>
                                     <option value="<?php echo $marcas->id; ?>" <?php if($marcas->id==$data->marca_veiculos_id){  echo 'selected';  } ?>><?php echo $marcas->nome; ?></option>
                                 <?php }else{ ?>
                                 <option value="<?php echo $marcas->id; ?>" ><?php echo $marcas->nome; ?></option>
                             
                              <?php } endforeach; ?>
                          <?php/// endif; ?>
                        </select>
                    </div>
                  </div>
                  <div class="form-group  ">
                  <label for="txtModelo" class="col-sm-5 control-label"><?= (!isset($data->id)) ? 'Inserir novo modelo' : 'Modelo a ser modificado'; ?></label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtModelo" value="<?= set_value('modelo', isset($data->modelo) ? $data->modelo : ""); ?>" name="txtModelo" placeholder="Digite um novo modelo" required>
                  </div> 
                </div>
                  
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                  <center>
                    <button type="submit" class="btn btn-danger" id="btnSalvarModelo">Salvar</button>
                  </center>
                </div>
              </div>                        
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Todos os modelos cadastrados</h3>
            </div>
                 
            <div class="panel-body">
              <table class="table table-striped table-responsive">
					      <tr>
                  <th>Marcas</th>
                  <th>Modelos</th>
                  <th colspan=2>&nbsp;</th>
                </tr>
                <?php foreach ($modelos as $modelo) : ?> 
                <tr>
     						  <td><?php echo $modelo->nome; ?></td>
                  <td><?php echo $modelo->modelo; ?></td>
     						  <td>
                    <a type="button" class="btn btn-info btn-xs" title="Editar" href="<?php echo base_url('frotas/modelos_marcas/editar').'/'.$modelo->id . '/' ; ?>">
                      <span class="glyphicon glyphicon-pencil"></span>
                    </a>
                  </td>

                  <?php if ($modelo->ativo==1) { ?>
                  <td>
                    <a type="button" data-toggle="modal" data-target="#myModal-desativar-tipo-modelo" class="btn btn-danger btn-xs" onclick="confirmarDesativarTipoModelo('<?php echo base_url('frotas/modelos_marcas/testes').'/'.$modelo->id; ?>')">
                      <span title="Desativar modelo" class="glyphicon glyphicon-remove"></span>
                    </a>
                  </td>
                  <?php } else { ?>
                    <td>
                      <a type="button" data-toggle="modal" data-target="#myModal-reativar-tipo-modelo" class="btn btn-success btn-xs" onclick="confirmarReativarTipoModelo('<?php echo base_url('frotas/modelos_marcas/testes').'/'.$modelo->id; ?>')">
                        <span title="Reativar modelo" class="glyphicon glyphicon-ok"></span>
                      </a>
                    </td>  
                  <?php } ?>
                </tr>
                <?php endforeach; ?> 
              </table>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php echo form_close(); ?> 
  </div>
</div>