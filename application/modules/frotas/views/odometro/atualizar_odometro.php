<div class="container">
  	<div class="well well-cadastro"> 
    <a type="button" class="glyphicon glyphicon-chevron-left   btn btn-sm btn-danger" title="Voltar para lista de viaturas"  href="<?php echo base_url('frotas/listar_viaturas/listarOdometros'."/".$listarOdometrosId ->idviaturas)?>" > <span></span></a>      
      <h3 class="form-signin-heading">Cadastro de Odômetro</h3> 
      <div class="panel-body"> 
        
		  <?php echo form_open('frotas/listar_viaturas/atualizarOdometros',array('class'=>'form-horizontal','role'=>'form')); ?>
            <h4>Atualize o odômetro de sua viatura.</h4>             
            <div class="form-group">
              <label for="data" class="col-sm-1  control-label">Data:</label>
              <div class=" col-sm-3 ">
                <input type="hidden" name="inputIdOdometros" value="<?php echo $listarOdometrosId ->idodometros?>">
                <input type="hidden" name="inputIdmilitares" value="<?php echo $listarOdometrosId ->idmilitares?>">
                <input type="text" class="form-control" name="data" id="data" value="<?php echo $listarOdometrosId ->data?>" placeholder="" required>
              </div>  	
            </div>
            
            <div class="form-group">
                <label for="selViatura" class=" col-sm-1  control-label">Viatura</label>
                <div class=" col-sm-3 ">
                    <select class="form-control input-sm" name="selViatura" id="selViatura" required>
                        <option value="<?php echo $listarOdometrosId ->idviaturas?>"><?php echo $listarOdometrosId ->placa." - ".$listarOdometrosId->nome." - ".$listarOdometrosId->modelo;?></option>
                            <?php foreach($listar_viaturas->result() as $viaturas) : ?>                    	
                             <option value="<?php echo $viaturas->id; ?>"><?php echo $viaturas->placa." - ".$viaturas->nome." - ". $viaturas->modelo; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>  	
            </div>
            
            <div class="form-group">
                <label for="inputOdometro" class=" col-sm-1  control-label">Odômetro</label>
                <div class=" col-sm-3 ">
                  <input type="text" class="form-control" name="inputOdometro" id="inputOdometro" value="<?php echo $listarOdometrosId ->odometro?>" placeholder="Entre com o Odômetro" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="inputDestino" class=" col-sm-1  control-label">Destino</label>
                <div class=" col-sm-6 ">
                  <textarea class="form-control" name="inputDestino" id="inputDestino" cols="30" rows="2" value="" placeholder="" required><?php echo $listarOdometrosId ->destino?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                 <label for="inputAlteracao" class=" col-sm-1  control-label">Alteração</label>
                 <div class="col-sm-6">
                   <textarea class="form-control" name="inputAlteracao" id="inputAlteracao" cols="50" rows="3" value="" placeholder="Preencha caso haja alguma alteração na viatura." ><?php echo $listarOdometrosId ->alteracao?></textarea>
                 </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                <center>
                    <button type="submit" class="btn btn-danger">Enviar</button>
                </center>
            </div>
            <?php echo form_close();?>
    	</div> <!--panel-->
    </div> <!--well-->
</div><!--container-->