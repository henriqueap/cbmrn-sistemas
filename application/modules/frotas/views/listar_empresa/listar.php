
<div class="container">
    <div class="well well-cadastro" >
    	<h3 class="form-signin-heading">Lista das Empresas Ativas</h3> 
    	<div class="panel-body">
            <div class="row" >
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a class="btn btn-sm  btn btn-sm btn-danger" title="Home" href="<?php echo base_url('index.php/frotas/index'); ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                    <a class="btn btn-sm  btn btn-sm btn-danger" title="Cadastrar Novo" href="<?php  echo base_url('index.php/frotas/empresa/cadastro'); ?>"><span class="glyphicon glyphicon-plus"></span></a>
                    
                </div>
            </div>
            <br>
            <div class="row">
            	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <?php $cont=1;
                            if($listar_contatos_empresa_ativos==false){
                            ?>
                            <div class="well alert-danger">Nao existem empresas ativas.</div>
                           <?php
                            }else{?>
                            <tr>
                                <th>Nº</th>
                                <th>Nome Fantasia</th>
                                <th>CNPJ</th>
                                <th>Contato</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th colspan="2">&nbsp;</th>
                            </tr>
                            
                            <?php
							foreach ($listar_contatos_empresa_ativos as $contatos_empresa) :
							?>
                            <tr>
                                <td><?php $contatos_empresa->idempresa; echo $cont++; ?></td>
                                <td><?php echo $contatos_empresa->nome_fantasia; ?></td>
                                <td><?php echo $contatos_empresa->cnpj; ?></td>
                                <td><?php echo $contatos_empresa->nome; ?></td>
                                <td><?php echo $contatos_empresa->telefone; ?></td>
                                <td><?php echo $contatos_empresa->email; ?></td>
                                <td><a title="Editar" class="btn btn-sm  btn btn-sm btn-default" href=" <?php echo base_url('index.php/frotas/listar_empresa/editar').'/'.$contatos_empresa->idempresa;?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                <?php if($contatos_empresa->ativo==0){?>
                                <td><a class="btn btn-sm  btn btn-sm btn-danger" title="Clique para ativar" href="<?php echo base_url('index.php/frotas/listar_empresa/atualizarAtivo').'/'.$contatos_empresa->idempresa;?>"><span  class="glyphicon glyphicon-ban-circle"></span></a> </td>
								<?php } else{?> 
                                <td><a class="btn btn-sm  btn btn-sm btn-success" title="Clique para desativar" href="<?php echo base_url('index.php/frotas/listar_empresa/atualizarAtivo').'/'.$contatos_empresa->idempresa;?>"><span  class="glyphicon glyphicon-ok-circle"></span></a> </td>
                                <?php } ?> 
                            </tr>
                            <?php endforeach;
                            } ?>
                        </table>
                    </div>
				</div>
            </div>
        </div>
    </div>
</div>
<?php if($listar_contatos_empresa_inativos != FALSE) { ?>
    <div class="container">
        <div class="well well-cadastro" >
            <h3 class="form-signin-heading">Lista das Empresas Inativas</h3> 
            <div class="panel-body">
                <div class="row" >
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <a class="btn btn-sm  btn btn-sm btn-danger" title="Home" href="<?php echo base_url('index.php/frotas/index'); ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                        <a class="btn btn-sm  btn btn-sm btn-danger" title="Cadastrar Novo" href="<?php  echo base_url('index.php/frotas/empresa/cadastro'); ?>"><span class="glyphicon glyphicon-plus"></span></a>
                        
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Nº</th>
                                    <th>Nome Fantasia</th>
                                    <th>CNPJ</th>
                                    <th>Contato</th>
                                    <th>Telefone</th>
                                    <th>E-mail</th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                                
                                <?php $cont=1;
                                foreach ($listar_contatos_empresa_inativos as $contatos_empresa) :
                                        
                                ?>
                                <tr>
                                    <td><?php $contatos_empresa->idempresa; echo $cont++; ?></td>
                                    <td><?php echo $contatos_empresa->nome_fantasia; ?></td>
                                    <td><?php echo $contatos_empresa->cnpj; ?></td>
                                    <td><?php echo $contatos_empresa->nome; ?></td>
                                    <td><?php echo $contatos_empresa->telefone; ?></td>
                                    <td><?php echo $contatos_empresa->email; ?></td>
                                    <td><a title="Editar" class="btn btn-sm  btn btn-sm btn-default" href=" <?php echo base_url('index.php/frotas/listar_empresa/editar').'/'.$contatos_empresa->idempresa;?>"><span class="glyphicon glyphicon-edit"></span></a></td>
                                    <?php if($contatos_empresa->ativo==0){?>
                                    <td><a class="btn btn-sm  btn btn-sm btn-danger" title="Clique para ativar" href="<?php echo base_url('index.php/frotas/listar_empresa/atualizarAtivo').'/'.$contatos_empresa->idempresa;?>"><span  class="glyphicon glyphicon-ban-circle"></span></a> </td>
                                    <?php } else{?> 
                                    <td><a class="btn btn-sm  btn btn-sm btn-success" title="Clique para desativar" href="<?php echo base_url('index.php/frotas/listar_empresa/atualizarAtivo').'/'.$contatos_empresa->idempresa;?>"><span  class="glyphicon glyphicon-ok-circle"></span></a> </td>
                                    <?php } ?> 
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

