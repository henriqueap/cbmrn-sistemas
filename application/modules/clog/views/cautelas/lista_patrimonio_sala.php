<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <h1>Patrimônio da Sala</h1>
    </div>
    <hr>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <p>
        <b>Sigla:</b> <?php echo $info_sala->sigla; ?><br />
        <b>Sala:</b> <?php echo $info_sala->nome; ?><br />
        <!--<b>Responsável:</b> <?php echo $info_sala->responsavel; ?><br />-->
      </p>
      <hr>
      <div class="panel panel-default">
        <div class="panel-body">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Ordem</th>
                <th>Produto</th>
                <th>Marca</th>
                <th>Tombo</th>
                <th>Data de Lançamento</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $count = 1;
              if (isset($produtos) && (!is_bool($produtos))) {
                foreach ($produtos->result() as $produto): ?>
                  <tr>
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $produto->modelo; ?></td>
                    <td><?php echo $produto->marca; ?></td>
                    <td><a href="" class="modal-hist-trigger"><?php echo $produto->tombo; ?></a></td>
                    <td><?php echo $produto->data_lancamento; ?></td>
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
    <!-- HTML Modal -->
        <div id="modal-hist-prod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content" id="modal-hist-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Histórico</h4>
              </div>
              <div class="modal-body" >
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
  </div> <!-- .row -->
</div> <!-- .container -->