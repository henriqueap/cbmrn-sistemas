<div class="wrap">
    <div class="container">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="row">
                <?php if($detalhamento->retroativo==1) {?>
                <h1>Concluir Serviço Retroativo</h1>

                <?php } else { ?>
                <h1>Concluir Serviço </h1>
                <?php } ?>
                <hr />
                </div> 
            <?php echo form_open ('frotas/servicos_pendentes/atualizarConclusaoServico',array('class'=>'form-horizontal','role'=>'form'));?>
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
                        </br>
                            <input id="ckbkm" name="ckbkm" type="checkbox" value="1" onclick="">
                            <label for="ckbkm">Com troca de óleo.</label>
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
                            <label><b>Data de Conclusão:</b></label> 
                        </div> 
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <?php if($detalhamento->retroativo==1) {?>
                                <input type="date"> <?php echo date('d/m/Y',strtotime($detalhamento->data_fim))?>
                            <?php } else { ?>
                                <input type="date" class="form-control" name="data" id="data" placeholder="" required>
                            <?php } ?> 
                        </div>     
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Quilometragem de Óleo:</b></label> 
                        </div> 
                        <div class="col-lg-3 col-md-3 col-xs-3">
                                <input type="text" class="form-control" name="txtOleo" id="txtOleo" placeholder="" disabled>
                        </div>     
                    </div>
                    </br>   
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-3">
                            <label><b>Alteração:</b></label>     
                        </div>  
                        <div class="col-lg-4 col-md-4 col-xs-4">
                            <textarea class="form-control" name="txtAlteracao" id="txtAlteracao" cols="50" rows="3" placeholder="" ></textarea>
                        </div>    
                    </div>
                    <?php  if ($detalhamento->situacao_id == 3) {?>
                    <div class="row ">
                        <div class="col-lg-4 col-md-4 col-xs-4">
                        </br></br>
                            <button type="submit" class="btn btn-danger ">Concluir Serviço</button>
                        </div>    
                    </div>   
                <?php }?>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>

