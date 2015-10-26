<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta name="robots" content="no-cache" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Histórico - Tombo nº <?php echo $tombo_info->tombo . " (" . $tombo_info->produto . ")"; ?></title>
    <link href="/sistemas/assets/css/print.css" rel="stylesheet" type="text/css" />
    <link href="/sistemas/assets/css/default.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <header>
      <div class="container" >
        <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 pull-left" id="logo">
            <img src="/sistemas/assets/img/cbmrn_logo.png" />
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" id="secs">
            <h6>Estado do Rio Grande do Norte</h6>
            <h6>Secretaria de Estado da Segurança Pública e da Defesa Social</h6>
            <h6>Corpo de Bombeiros Militar do Rio Grande do Norte</h6>
            <h6>Centro de Logística</h6>
          </div>
        </div> <!-- .row -->
      </div> <!-- .container -->
    </header>
    <div class="container" >
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="center">
            <h4>Histórico de Produto</h4>
          </div>
        </div>
        <hr>
        <div id="produto-historico" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <p>
            <b>Produto:</b> <?php echo $tombo_info->produto; ?><br />
            <b>Tombo:</b><span id="numero_tombo"><?php echo $tombo_info->tombo; ?></span><br />
          </p>
          <hr>
          <div class="panel panel-default">
            <div class="panel-body">
              <table class="table table-hover table-bordered table-condensed">
                <thead>
                  <tr>
                    <th class="center">Ordem</th>
                    <th class="center">Nº Saída</th>
                    <th class="center">Almoxarifado</th>
                    <th class="center">Tipo de saída</th>
                    <th class="center">Destino</th>
                    <th class="center">Data</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $count = 1;
                  foreach ($historico as $row): ?>
                    <tr>
                      <td class="center"><?php echo $count++; ?></td>
                      <td class="center"><?php echo $row->cautelas_id; ?></td>
                      <td class="center"><?php echo $row->almoxarifado;; ?></td>
                      <td class="center">
                        <?php
                        switch ($row->distribuicao) {
                            case 1:
                              echo "Distribuição";
                              break;
                            case 2:
                              echo "Transferência";
                              break;
                            default:
                              echo "Cautela";
                              break;
                        }  ?>
                      </td>
                      <td class="center"><?php echo (is_null($row->sigla)) ? $row->militar : $row->destino; ?></td>
                      <td class="center"><?php echo $row->dia; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div><!-- .panel-body -->
          </div><!-- .panel -->
        </div><!-- .produto-hsitorico -->
      </div> <!-- .row -->
    </div> <!-- .container -->

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <script type="text/javascript">
      jQuery(function($) {
        self.print();
        history.back(); 
      });
    </script>
  </body>
</html>