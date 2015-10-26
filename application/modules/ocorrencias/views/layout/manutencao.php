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

    <body id="manutencao">
        <!-- Layout do Sistema! -->
        <div class="wrap">
		<div class="container">
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12" id="msg-manutencao">
		<h1>Estamos em manutenção momentaneamente!</h1>
        <a href="<?= base_url(''); ?>" class="btn btn-default">Voltar!</a>
		</div>
		</div>
		</div>
        </div>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskedinput.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.maskMoney.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('/assets/js/select2.min.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('/assets/js/select2_locale_pt-BR.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/gerenciamento.js'); ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/angular.min.js'); ?>"></script>
    </body>
</html>