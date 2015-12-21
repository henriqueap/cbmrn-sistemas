<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Material Distribuído <?php echo isset($tp_uso)? $tp_uso : ''; ?></h1></div>
    <hr>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th class="center">Ordem</th>
                <th class="center">Número</th>
                <th class="center">Data Saída</th>
                <th class="center">Devolvido em</th>
                <th class="center">Responsável</th>
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
                  if ($cautela->distribuicao > 0 && $cautela->ativa == 1 /* && is_null($cautela->data_conclusao) === TRUE */) {
                    ?>
                    <tr>
                      <td class="center"><?php echo $count++; ?></td>
                      <td class="center"><?php echo $cautela->id; ?></td>
                      <td class="center"><?php echo $cautela->data_cautela; ?></td>
                      <?php
                      if (! is_null($cautela->data_conclusao)) { ?>
                        <td class="center"><?php echo $cautela->data_conclusao; ?></td>
                        <?php
                      }
                      else { ?>
                        <td class="center"> - </td>
                        <?php
                      } ?>
                      <td class="center"><?php echo $cautela->militar; ?></td>
                      <td>
                        <?php
                        $itens = $this->cautelas_model->getItens($cautela->id);
                        if ($itens === FALSE || $cautela->finalizada == 0) {
                          $btnVal = "Continuar";
                          $btnHint = "Incluir itens ou concluir a distribuição";
                        }
                        else {
                          $btnVal = "Visualizar";
                          $btnHint = "Mostrar os itens da distribuição";
                          ?>
                          <input type="button" name="btnImprimir" id="btnImprimir" value="Imprimir" title="Imprimir o termo de saída de material" onclick="window.open('<?php echo BASE_URL('index.php/clog/cautelas/imprimir', '_blank') . '?id=' . $cautela->id; ?>');">
                          <?php
                        } ?>
                        <input type="button" name="btnMostrar" id="btnMostrar" value="<?php echo $btnVal; ?>" title="<?php echo $btnHint; ?>" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/mostrar') . '?id=' . $cautela->id; ?>';">
                        <?php
                        if (is_null($cautela->data_conclusao)) { ?>
                          <input type="button" name="btnDevolve" id="btnDevolve" value="Devolver" title="Devolver o material" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/concluir_cautela') . '?id=' . $cautela->id; ?>'">
                          <input type="button" name="btnCancela" id="btnCancela" value="Cancelar" title="Cancelar a Distribuição" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas/cancelar_cautela') . '?id=' . $cautela->id; ?>'">
                          <?php
                        } ?>
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
        <button type="button" class="btn btn-default" onclick="location.href = '<?php echo BASE_URL('index.php/clog/cautelas'); ?>'">Novo Registro</button>
      </div>
    </div>
  </div> <!-- .row -->
</div> <!-- .container -->