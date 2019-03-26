<div class="wrap">
    <div class="container">
         <div class="col-lg-12 col-md-12 col-xs-12">
            <div class="row">
                <h1>Detalhamento Serviço</h1>
                <hr />
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <label><b>Viatura:</b></label> 
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4">
                     <label class="simple-text"><?php echo $detalhamento->placa." - ".$detalhamento->nomeMarca." - ". $detalhamento->modelo; ?></label> 
                </div>
            </div> 
            </br> 
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <label><b>Tipo de Serviço:</b></label>     
                </div>  
                <div class="col-lg-4 col-md-4 col-xs-4">
                     <label class="simple-text"><?php echo $detalhamento->nomeServicos; ?></label> 
                </div>    
            </div>
            </br>  
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <label><b>Empresa:</b></label>     
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4">
                     <label class="simple-text"><?php echo $detalhamento->nome_fantasia?></label> 
                </div>      
            </div>
            </br>  
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <label><b>Contato:</b></label>     
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4">
                     <label class="simple-text"><?php echo $detalhamento->nomeContato ?></label> 
                </div>      
            </div> 
            </br> 
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-2">
                    <label><b>Data Início:</b></label>   

                </div> 
                <div class="col-lg-4 col-md-4 col-xs-4">
                     <label class="simple-text"><?php echo date('d/m/Y',strtotime($detalhamento->data_inicio))?></label> 
                </div>     
            </div>
            </br>  
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-2">
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
            <?php foreach ($carregarNota->result() as $carregar ) :?>
               <div class="row ">
                    <div class="col-lg-4 col-md-4 col-xs-4">
                        </br></br>
                         <label class="simple-text">Nota Fiscal do Serviço - <?php echo $carregar->numero ?> - 
                            <a class="a_pointer" onclick="#">Carregar</a> | <a href="#">Incluir ítem</a>
 </label> 
                    </div>    
                </div>  
            <?php endforeach ?>
            <?php  if ($detalhamento->situacao_id == 3) {?>

            <div class="row ">
                <div class="col-lg-4 col-md-4 col-xs-4">
                </br></br>
                    <a href="<?php echo base_url('index.php/frotas/servicos_pendentes/concluirServico').'/'.$detalhamento->idServico?>" class="btn btn-danger ">Concluir Serviço</a>
                </div>    
            </div>   
        <?php }?>
        </div>
    </div>
</div>

