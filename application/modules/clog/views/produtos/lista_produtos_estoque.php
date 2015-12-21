<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta name="robots" content="no-cache" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lista de Produtos em Estoque</title>
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
            <h6><?php echo $cautela->estoque_origem; ?></h6>
          </div>
        </div> <!-- .row -->
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="center">
              <h4>
                Lista de Produtos
              </h4>
            </div>
          </div>
          <hr>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="result-search">
          <!-- Exibir consultas. -->
          </div> <!-- .Cols -->
        </div> <!-- .row -->
      </div> <!-- .container -->
    </header>
  </body>
</html>