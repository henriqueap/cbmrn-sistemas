<div class="container">
  <div class="well well-cadastro" >       
    <?php echo form_open('frotas/abastecimento/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
    <input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />
    <h3 class="form-signin-heading">Cadastro de Abastecimento</h3> 
    <div class="panel-body"> 
      <form class="form-horizontal" role="form">

        <div class="form-group">
          <label for="data" class="col-sm-2  control-label">Data:</label>
          <div class=" col-sm-3 ">
            <input type="date" class="form-control" name="data" id="data" placeholder="" required>
          </div>    
        </div>

        <div class="form-group">
          <label for="selSetor" class="col-sm-2 control-label">Setor</label>
          <div class="col-lg-2">
            <select class="form-control input-sm" id="selSetor" name="selSetor">
              <option value="0" selected>Sem Setor</option>
              <?php foreach ($setor_lotacao->result() as $setor): ?>
              <option value="<?php echo $setor->id; ?>"><?php echo $setor->sigla; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
       	  <label for="selViatura" class="col-sm-2 control-label">Viatura</label>
          <div class="col-lg-4">
            <select class="form-control input-sm" id="selViatura" name="selViatura">
              <option value="0" selected>Placa - Marca - Modelo</option>
              <?php foreach ($listar_viaturas->result() as $viaturas) : ?>
              <option value="<?php echo $viaturas->id; ?>"><?php echo $viaturas->placa." - ".$viaturas->nome." - ". $viaturas->modelo; ?></option>
            <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="txtOdometro" class="col-sm-2 control-label">Odômetro</label>
        	<div class="col-lg-2">
            <input type="placa" class="form-control" id="txtOdometro" name="txtOdometro" placeholder="Km">
        	</div>  	
    	  </div>
        
        <div class="form-group">
          <label for="txtCombustivel" class="col-sm-2 control-label">Quantidade de combustível</label>
        	<div class="col-lg-2">
            <input type="placa" class="form-control" id="txtCombustivel" name="txtCombustivel" placeholder="Litros">
        	</div>  	
    	  </div>
        <div class="col-lg-5 col-md-3 col-sm-3 col-xs-3" >
          <center>
            <a type="button" class="btn btn-danger" href="<?php echo base_url('index.php/frotas/index'); ?>" >Home</a>
          </center>
        </div>
        <div class="col-lg-1 "> 
          <center>
            <button type="submit" class="btn btn-danger">Enviar</button>
          </center>
        </div>
      </form>
    </div>
    <?php echo form_close(); ?>  
  </div> 
</div>