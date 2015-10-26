<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta name="robots" content="no-cache" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo (isset($title)) ? $title : 'CBM-RN'; ?></title>
        <link href="<?php echo base_url('assets/css/default.css'); ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            // Constante importante para o código FRONT-END!!!
            BASE_URL = "<?php echo base_url(); ?>";
        </script>
    </head>

    <body>
        <header id="top">
            <div class="container" >
                <div class="row">
                    <div class="col-lg-9  col-md-9 col-sm-9 col-xs-9">
                        <div id="logo" class="pull-left">
                            <h4><img src="<?php echo base_url('/assets/img/cbmrn_logo.png'); ?>" width="80" height="80" /></h4>
                        </div>
                        <div>
                            <h3>Centro de Logística - CB FROTAS</h3> 
                            <h5>Corpo de Bombeiros Militar do Rio Grande do Norte - CBM-RN</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">                      
                        <div class="pull-right">
                            <ul class="ulUser">
                                <li><span class="glyphicon glyphicon-user"></span></li>
                                <li>Sd Pereira</li>
                                <li>|</li>
                                <li><a href="#">Sair</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="navbar navbar-default navbar-static-top" role="navigation">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown"><?php echo anchor('frotas/home', 'Home'); ?></li>
                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastro<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><?php echo anchor('frotas/odometro/cadastrar', 'Odômetro'); ?></li> 
                                    <li><?php echo anchor('frotas/abastecimento/cadastro', 'Abastecimento'); ?></li>
                                    <li><?php echo anchor('frotas/viaturas/cadastro', 'Viatura'); ?></li> 
                                    <li><?php echo anchor('frotas/servico/cadastro', 'Serviço'); ?></li>
                                    <li><?php echo anchor('frotas/servico/cadastroRetroativo', 'Serviço Retroativo'); ?></li>
                                    <li><?php echo anchor('frotas/empresa/cadastro', 'Empresa'); ?></li>
                                    <li><?php echo anchor('frotas/tipo_servico/cadastro', 'Tipo de Serviço'); ?></li>
                                    <li><?php echo anchor('frotas/tipo_viatura/cadastro', 'Tipo de Viatura'); ?></li>
                                    <li><?php echo anchor('frotas/marcas_veiculos/cadastro', 'Marca'); ?></li>
                                    <li><?php echo anchor('frotas/modelos_marcas/cadastro', 'Modelo'); ?></li>
                                </ul>
                            </li> <!--/.dropdown-->

                            
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatórios<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><?php echo anchor('frotas/listar_viaturas/listar', 'Listar Viaturas'); ?></li>
                                    <li><?php echo anchor('frotas/listar_empresa/listar', 'Listar Empresas'); ?></li>
                                    <li><?php echo anchor('frotas/servicos_concluidos/listar', 'Serviços concluídos'); ?></li>
                                    <li><?php echo anchor('frotas/servicos_pendentes/listar', 'Serviços em andamento'); ?></li>
                                    <li><?php echo anchor('frotas/servicos_cancelados_autorizados/listar', 'Serviços cancelados ou não autorizados'); ?></li>
                                    <li><?php echo anchor('frotas/relatorio_geral/relatorio', 'Relatório Geral'); ?></li>
                                </ul>
                            </li> <!--/.dropdown-->

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sobre<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><?php echo anchor('frotas/contato', 'Contato'); ?></li>
                                </ul>
                            </li> <!--/.dropdown-->
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>     
            </div>
        </header>

        <!-- Exibição dos Erros no Sistema! -->
        <div class="container">
            <?php
            $msg = $this->session->flashdata('mensagem');
            echo validation_errors('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>', '</div>');
            if (!empty($msg)):
                ?>            
                <div class="alert <?= $msg['type']; ?> alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?= $msg['msg']; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Layout do Sistema! -->
        <?php echo $layout; ?>

        <!-- HTML Modal -->
        <div class="modal fade" id="myModal-excluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Atenção!</h3>
                    </div>
                    <div class="modal-body">
                        <p>Deseja realmente excluir?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        <a type="button" class="btn btn-primary" id="bt-modal-confirmar-exclusao" href="#">Sim</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal --> 

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <p>&copy; <?php # echo date('Y'); ?> <?php echo anchor('http://www.cbm.rn.gov.br/', 'CBM-RN', array('target' => '_blank')); ?></p>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8"></div>
                </div> <!--.row-->
            </div> <!--.container-->
        </footer>

        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.twbsPagination.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskMoney.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('/assets/js/select2.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('/assets/js/select2_locale_pt-BR.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/gerenciamento.js'); ?>"></script>
    </body>
</html>