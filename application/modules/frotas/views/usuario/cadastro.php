<div class="container">
  <div class="well well-cadastro" > 
    <?php echo form_open('frotas/usuario/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
    <input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>"/>
    <h3 class="form-signin-heading">Cadastro de Usuário</h3>
    <form class="form-horizontal" role="form">
      <div class="form-group">
        <label for="selMilitar" class="col-sm-2 control-label">Militar</label> 
        <div class=" col-sm-4 ">
          <select class="form-control input-sm" name="selMilitar" id="selMilitar">
            <?php if(!isset($data->id ) == FALSE) : ?>
              <option value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>"> <?= (isset($data)) ? $data['nome_guerra'] : '' ; ?> </option>

            <?php else: ?>

            <option value="0" selected>Selecione o Militar</option>
            <?php foreach ($listar_militares as $militares) : ?>
              <option value="<?php echo $militares->id; ?>"><?php echo $militares->matricula. " - " . $militares->sigla. " - " . $militares->nome_guerra; ?></option>
            <?php endforeach; ?>
          <?php endif; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="selTipo" class="col-sm-2 control-label">Tipo de Usuário</label>
        <div class=" col-sm-4 ">
          <select class="form-control input-sm" id="selTipo" name="selTipo">
            <option value="0" selected>Selecione</option>
            <?php foreach ($tipos_usuarios as $tipos) : ?>
              <option value="<?php echo $tipos->id; ?>"><?php echo $tipos->tipo; ?></option> 
            <?php endforeach; ?>
          </select>
        </div>
      </div>
        
      <div class="form-group">
        <label for="senha1" class="col-sm-2 control-label">Senha</label>
        <div class=" col-sm-4 ">
          <input type="password" class="form-control" id="senha1" name="senha1" placeholder="Digite uma senha" required>  
        </div>
      </div>

      <div class="form-group">
        <label for="senha2" class="col-sm-2 control-label">Confirme a Senha</label>
        <div class=" col-sm-4 ">
          <input type="password" class="form-control" id="senha2" name="senha2" placeholder="Confirme a senha" >  
      </div>

        <div class="col-lg-1">
          <a class="btn-lg btn-success">
            <big><span title="As senhas conferem!" class="glyphicon glyphicon-thumbs-up"></span></big>
          </a>
        </div>

        <div class="col-lg-1">
          <a class="btn-lg btn-danger">
            <big><span title="As senhas não conferem!" class="glyphicon glyphicon-thumbs-down"></span></big>
          </a>
        </div>
      </div> 
        
      <div class="col-lg-5 col-md-4 col-sm-4 col-xs-4">
        <center>
          <a class="btn btn-danger" href="<?php echo base_url('frotas/index'); ?>" role="button">Home</a>
        </center>
      </div> 
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
        <button type="submit" class="btn btn-danger">Salvar</button>
      </div>                
    </form>
  <?php echo form_close(); ?>
  </div>
</div><!--class="container"-->