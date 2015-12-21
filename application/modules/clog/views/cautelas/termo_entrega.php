<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta name="robots" content="no-cache" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
      <?php
        switch ($cautela->distribuicao) {
          case 1:
            echo ($cautela->cancelada == 0) ? "Termo de Distribuição de Material" : "Termo de Cancelamento de Distribuição";
            break;
          case 2:
            echo ($cautela->cancelada == 0) ? "Termo de Transferência de Material" : "Termo de Cancelamento de Transferência";
            break;
          default:
             echo ($cautela->concluida == 1) ? "Termo de Devolução de Material" : "Termo de Cautela de Material";
            break;
        }
      ?>
    </title>
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
                <?php
                switch ($cautela->distribuicao) {
                  case 1:
                    echo "Termo de Distribuição de Material";
                    break;
                  case 2:
                    echo "Termo de Transferência de Material";
                    break;
                  default:
                    echo ($cautela->concluida == 1) ? "Termo de Devolução de Material" : "Termo de Cautela de Material";
                    break;
                } ?>
              </h4>
            </div>
          </div>
          <hr>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p>
              <b>Número:</b> <?php echo $cautela->id; ?><br />
              <b>Setor:</b> <?php echo ($cautela->distribuicao < 2 && is_null($cautela->setor_id)) ? "Uso do Militar ".$cautela->setor_id : $cautela->setor." - ".$cautela->sigla; ?><br />
            </p>
            <hr>
            <div class="panel panel-default">
              <div class="panel-body">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Ordem</th>
                      <th>Produto</th>
                      <th>Tombo</th>
                      <th>Quantidade</th>
                      <th>Data</th>
                      <?php
                      if ($cautela->distribuicao == 0) { ?>
                        <th>Devolução prevista</th>
                        <?php
                        if ($cautela->concluida == 1)
                          echo "<th>Devolvido em</th>";
                      } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $count = 1;
                    if (isset($itens) && (!is_bool($itens))) {
                      # Carregando o material de consumo
                      foreach ($itens->result() as $item):
                        if (is_null($item->tombo_id)) { ?>
                          <tr>
                            <td><?php echo $count++; ?></td>
                            <td><?php echo $item->produto; ?></td>
                            <td><?php echo "Produto de Consumo" ?></td>
                            <td><?php echo $item->quantidade; ?></td>
                            <td><?php echo $cautela->data_cautela; ?></td>
                            <?php
                            if ($cautela->distribuicao == 0) {
                              echo "<td>".$cautela->data_prevista."</td>";
                              if ($cautela->concluida == 1)
                                echo "<td>".$cautela->data_conclusao." ".$cautela->hora_conclusao."</td>";
                            } ?>
                          </tr>
                          <?php
                        }
                      endforeach;
                      # Carregando o material permanente
                      # 1º Criando um array que junta os tombos de um mesmo produto
                      $item_permanente = array();
                      if (isset($tombos)) {
                        foreach ($tombos->result() as $tombo):
                          if (!isset($item_permanente["$tombo->modelo"]))
                            $item_permanente["$tombo->modelo"] = $tombo->tombo.";";
                          else
                            $item_permanente["$tombo->modelo"].= " ".$tombo->tombo.";";
                        endforeach;
                      }
                      # 2º Lendo o array dos produtos permanentes e colocando na tabela
                      foreach ($item_permanente as $modelo => $numeros): ?>
                        <tr>
                          <td><?php echo $count++; ?></td>
                          <td><?php echo $modelo; ?></td>
                          <td><?php echo rtrim($numeros, ";"); ?></td>
                          <td><?php echo count(explode(";", $numeros)) - 1 ?></td>
                          <td><?php echo $cautela->data_cautela; ?></td>
                          <?php
                          if ($cautela->distribuicao == 0) {
                            echo "<td>".$cautela->data_prevista."</td>";
                            if ($cautela->concluida == 1)
                              echo "<td>".$cautela->data_conclusao." ".$cautela->hora_conclusao."</td>";
                          } ?>
                        </tr>
                        <?php
                      endforeach;
                    }
                    else { ?>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <?php
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <hr>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="center">
              <p>&nbsp;</p>
              <hr>
              <?php 
              if ($cautela->matricula == '000.000-0') {
                echo "Prestador de Serviço. CPF: "; 
              }
              else {
                echo $cautela->militar . " - " . $cautela->matricula; 
              } ?>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="center">
              <p>&nbsp;</p>
              <hr>
              <?php echo $this->session->userdata['militar']." - ".$this->session->userdata('matricula_militar'); ?>
            </div>
          </div>
        </div> <!-- .row -->
      </div> <!-- .container -->
    </header>
  </body>
</html>