<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h1><?php echo ($cautela->distribuicao > 0) ? "Distribuição de Material" : "Cautela de Material"; ?></h1>
    </div>
    <hr>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                  <th>Ordem</th>
                  <th>Produto</th>
                  <th>Quantidade</th>
                  <th><?php 
                      echo ($cautela->distribuicao > 0) ? "Distribuido  em" : "Cautelado em"; ?>
                  </th>
                  <th>Devolução prevista</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $count = 1; 
              if (isset($itens) && (! is_bool($itens))) {
                foreach($itens->result() as $item): ?>
                <tr>
                  <td><?php echo $count++; ?></td>
                  <td><?php echo $item->modelo; ?></td>
                  <td><?php echo $item->quantidade; ?></td>
                  <td><?php echo $item->data_cautela; ?></td>
                  <td><?php 
                    echo ($cautela->distribuicao == 0) ? $item->data_prevista : "-"; ?>
                  </td>
                  <!--<td>
                    <input type="button" name="btnOS" id="btnOS" value="Mostrar" onclick="location.href = '<?php //echo BASE_URL('clog/os/ordem_servico').'?id='.$os->id; ?>';">
                    <?php
                    /*
                    if ($cautela->concluida == 0) { ?>
                    <input type="button" name="btnCancela" id="btnCancela" value="Cancelar Item" onclick="location.href = '<?php echo BASE_URL('clog/cautelas/cancelar_item').'?id='.$item->id; ?>'">
                    <?php 
                    }
                    */ 
                    ?>
                  </td>-->
                </tr>
                <?php endforeach;
              }
              else {
              ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              <?php 
              }   
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
        <button type="button" class="btn btn-default" onclick="history.back();">Voltar</button>
        <!--<button type="button" class="btn btn-default" onclick="location.href = '<?php //echo BASE_URL('clog/cautelas'); ?>'">Lançar Cautela</button>-->
      </div>
    </div>
  </div> <!-- .row -->
</div> <!-- .container -->