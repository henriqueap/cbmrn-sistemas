<div class="wrap">
    <div class="container">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="row">
                <h1>Iniciar Serviço </h1>
                <hr />
                </div> 
            <?php echo form_open ('frotas/servicos_pendentes/atualizarExecucaoServico',array('class'=>'form-horizontal','role'=>'form'));?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Placa:</b></label> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <input type="hidden" name="idViatura" value="<?php echo $detalhamento->idViatura?>">
                            <input type="hidden" name="idServico" value="<?php echo $detalhamento->idServico?>">
                           
                             <label class="simple-text"><?php echo $detalhamento->placa; ?></label> 
                        </div>
                    </div> 
                    </br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Modelo:</b></label> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-4">
                             <label class="simple-text"><?php echo $detalhamento->modelo; ?></label> 
                        </div>
                    </div> 
                    </br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Serviço:</b></label> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <label class="simple-text"><?php echo $detalhamento->nomeServicos; ?></label>
                        </div>
                    </div> 
                    </br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Descrição:</b></label>     
                        </div>  
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <?php if ($detalhamento->alteracao == "") {?>
                                <label class="simple-text">Este serviço não tem detalhamento.</label> 
                            <?php } else{ ?>
                                <label class="simple-text"><?php echo $detalhamento->alteracao ?></label> 
                            <?php }?>
                        </div>    
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Odômetro:</b></label> 
                        </div> 
                        <div class="col-lg-3 col-md-3 col-xs-3">
                                <input type="text" class="form-control" name="txtOdom" id="txtOdom" placeholder="" required>
                        </div>     
                    </div>
                    </br> 
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Data de Início:</b></label> 
                        </div> 
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <input type="date" class="form-control" name="data" id="data" placeholder="" required>
                        </div>     
                    </div>
                    </br>
                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-xs-4">
                        </br></br>
                            <button type="submit" class="btn btn-danger ">Iniciar Serviço</button>
                        </div>    
                    </div>   
                
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
