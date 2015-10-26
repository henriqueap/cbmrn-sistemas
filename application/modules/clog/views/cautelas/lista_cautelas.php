<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Listar Cautelas</h1></div>
    <hr>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Ordem</th>
                <th>Número</th>
                <th>Data Cautela</th>
                <th>Militar</th>
                <th>Devolução</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (isset($cautelas) && (!is_bool($cautelas))) {
                /* echo "<pre>";
                  var_dump($lista);
                  echo "</pre>"; */
                foreach ($cautelas->result() as $cautela):
                  if ($cautela->distribuicao == 0 && $cautela->ativa == 1 /* && is_null($cautela->data_conclusao) === TRUE */) { ?>
                    <tr>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $cautela->id; ?></td>
                      <td><?php echo $cautela->data_cautela; ?></td>
                      <td><?php echo $cautela->militar; ?></td>
                      <td><?php
                        if (is_null($cautela->data_conclusao)) { # Checar se é o melhor caminho
                          if ($cautela->data_prevista > date("Y-m-d", strtotime("now")))
                            echo "<font color='green'><b>" . $cautela->data_prevista_fmt . "</b></font>";
                          else if ($cautela->data_prevista == date("Y-m-d", strtotime("now")))
                            echo "<font color='orange'><b>" . $cautela->data_prevista_fmt . "</b></font>";
                          else
                            echo "<font color='red'><b>" . $cautela->data_prevista_fmt . "</b></font>";
                        } else
                          echo "$cautela->data_conclusao";
                        ?>
                      </td>
                      <td>
                        <?php
                        $itens = $this->cautelas_model->getCautelas($cautela->id);
                        if ($itens === FALSE || $cautela->finalizada == 0) {
                          $btnVal = "Continuar";
                          $btnHint = "Incluir itens ou concluir a cautela";
                        }
                        else {
                          $btnVal = "Visualizar";
                          $btnHint = "Mostrar os itens na cautela"; ?>
                          <input type="button" name="btnImprimir" id="btnImprimir" value="Imprimir" title="Imprimir o termo de saída de material" onclick="window.open('<?php echo BASE_URL('index.php/clog/cautelas/imprimir', '_blank').'?id='.$cautela->id; ?>'); window.close();">
                          <?php
                        } ?>
                        <input type="button" name="btnMostrar" id="btnMostrar" value="<?php echo $btnVal; ?>" title="<?php echo $btnHint; ?>" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/mostrar').'?id='.$cautela->id; ?>';">
                        <?php
                        if ($cautela->concluida != 1) { ?>
                          <input type="button" name="btnDevolve" id="btnDevolve" value="Devolver" title="Devolver o material cautelado" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/concluir_cautela') . '?id=' . $cautela->id; ?>'">
                          <?php
                        } ?>
                        <input type="button" name="btnCancela" id="btnCancela" value="Cancelar" title="Cancelar a cautela" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/cancelar_cautela') . '?id=' . $cautela->id; ?>'">
                      </td>
                    </tr>
                    <?php
                  }
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
    <div class="form-group">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
        <button type="button" class="btn btn-default" onclick="history.back();">Voltar</button>
        <!--<button type="button" class="btn btn-default" onclick="location.href = '<?php //echo BASE_URL('index.php/clog/cautelas'); ?>'">Novo Registro</button>-->
      </div>
    </div>
  </div> <!-- .row -->
</div> <!-- .container -->