
<h4 class="center">Histórico de Produto Permanente</h4>
<hr />
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable">
  <p>
    <b>Produto:</b> <?php echo $tombo_info->produto; ?><br />
    <b>Tombo:</b><span id="numero_tombo"><?php echo $tombo_info->tombo; ?></span><br />
  </p>
  <hr>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 printable">
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
      foreach ($historico as $row):
        ?>
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
</div><!-- .produto-historico -->