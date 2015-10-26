<div class="container">
    <div class="well well-cadastro" >       
        <h3 class="form-signin-heading">Cadastro de Serviço Retroativo</h3> 
        <div class="panel-body"> 
             <?php echo form_open ('frotas/servico/cadastroRetroativo',array('class'=>'form-horizontal','role'=>'form'));?>
                <div class="form-group">
                  <label for="dataIni" class="col-sm-2  control-label">Data Início:</label>
                  <div class=" col-sm-3 ">
                    <input type="date" class="form-control" name="dataIni" id="dataIni" placeholder="" required>
                  </div>  	
                </div>
                <div class="form-group">
                  <label for="dataFim" class="col-sm-2  control-label">Data Final:</label>
                  <div class=" col-sm-3 ">
                    <input type="date" class="form-control" name="dataFim" id="dataFim" placeholder="" required>
                  </div>  	
                </div>
                <div class="form-group">
                    <label for="selTipo" class="col-sm-2  control-label">Tipo de Serviço</label>
                    <div class=" col-sm-5 ">
                        <select class="form-control input-sm " name="selTipo" id="selTipo" required>
                            <option value>Selecione</option>
								<?php foreach($listar_servicos->result() as $tipo_servicos) : ?>                    	
                                 <option value="<?php echo $tipo_servicos->id; ?>"><?php echo $tipo_servicos->nome; ?></option>
                                <?php endforeach; ?>
                        </select>              
                    </div>
                </div>
                <div class="form-group">
                  <label for="selViatura" class=" col-sm-2 control-label">Viatura</label>
                  <div class=" col-sm-5 ">
                  
                    <select class="form-control input-sm" name="selViatura" id="selViatura" required>
                        <option value>Selecione</option>
                            <?php foreach($listar_viaturas->result() as $viaturas) : ?>                    	
                             <option value="<?php echo $viaturas->id; ?>"><?php echo $viaturas->placa." - ". $viaturas->modelo; ?></option>
                            <?php endforeach; ?>
                    </select>
                  </div>	
                </div>
                <div class="form-group">
                    <label for="selEmpresa" class="col-sm-2  control-label">Empresa</label>
                    <div class=" col-sm-5 ">
                    <select class="form-control input-sm" name="selEmpresa" id="selEmpresa" required>
                        <option value >Selecione</option>
                        	<?php foreach($listar_empresas->result() as $empresas) : ?>                    	
                             <option value="<?php echo $empresas->id; ?>"><?php echo $empresas->nome_fantasia; ?></option>
                            <?php endforeach; ?>
                    </select>
                    </div> 
                </div>
				<div class="form-group">
                     <label for="txtDescricao" class=" col-sm-2  control-label">Descrição de Serviço</label>
                     <div class=" col-sm-5 ">
                       <textarea class="form-control" name="txtDescricao" id="txtDescricao" cols="50" rows="3" placeholder="" ></textarea>
                     </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" >
                    <center>
                        <a class="btn btn-danger" href="<?php echo base_url('frotas/index'); ?>" role="button">Home</a>
                    </center>
                </div> 
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"> 
                    <center>
                        <button type="submit" class="btn btn-danger">Incluir</button>
                    </center>
				</div>
			<?php echo form_close();?>
		</div> 
	</div> 
</div>