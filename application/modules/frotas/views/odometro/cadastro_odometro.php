<div class="container">
  	<div class="well well-cadastro">       
      <h3 class="form-signin-heading">Cadastro de Odômetro</h3> 
      <div class="panel-body"> 
		  <?php echo form_open('frotas/odometro/cadastrar',array('class'=>'form-horizontal','role'=>'form')); ?>
            <h4>Registre o odômetro de sua viatura.</h4>
            <div class="form-group">
              <label for="data" class="col-sm-1  control-label">Data:</label>
              <div class=" col-sm-3 ">
                <input type="date" class="form-control" name="data" id="data" placeholder="" required>
              </div>  	
            </div>
            
            <div class="form-group">
                <label for="selViatura" class=" col-sm-1  control-label">Viatura</label>
                <div class=" col-sm-3 ">
                    <select class="form-control input-sm" name="selViatura" id="selViatura" required>
                        <option value>Selecione</option>
                            <?php foreach($listar_viaturas->result() as $viaturas) : ?>                    	
                             <option value="<?php echo $viaturas->id."-".$viaturas->tipo_viaturas_id; ?>"><?php echo $viaturas->placa." - ".$viaturas->nome." - ". $viaturas->modelo; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>  	
            </div>            
            <div class="form-group">
                <label for="inputOdometro" class=" col-sm-1  control-label">Odômetro</label>
                <div class=" col-sm-3 ">
                  <input type="text" class="form-control" name="inputOdometro" id="inputOdometro" placeholder="Entre com o Odômetro" required>
                </div>
            </div>

            <div id="semViatura">
              <div class="form-group">
                  <label for="inputDestino" class=" col-sm-1  control-label">Destino</label>
                  <div class=" col-sm-6 ">
                    <textarea class="form-control" name="inputDestino" id="inputDestino" cols="30" rows="2" placeholder="" ></textarea>
                  </div>
              </div>
              
              <div class="form-group">
                   <label for="inputAlteracao" class=" col-sm-1  control-label">Alteração</label>
                   <div class="col-sm-6">
                     <textarea class="form-control" name="inputAlteracao" id="inputAlteracao" cols="50" rows="3" placeholder="Preencha caso haja alguma alteração na viatura." ></textarea>
                   </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >
                <center>
                    <a type="button" class="btn btn-danger" href="<?php echo base_url('index.php/frotas/index'); ?>" >Home</a>
                </center>
            </div> 
            
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <center>
                    <button type="submit" class="btn btn-danger" id="btnSalvarOdom">Enviar</button>
                </center>
            </div>
            <?php echo form_close();?>
    	</div> <!--panel-->
    </div> <!--well-->
</div><!--container-->