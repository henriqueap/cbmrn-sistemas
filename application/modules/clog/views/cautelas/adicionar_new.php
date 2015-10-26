<div class="container">
  <div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
      <h1>Incluir Ítens</h1>
      <hr>
    </div>
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Cautela de Material</h3>
        </div>
        <div class="panel-body">
          <?php 
          var_dump($produtos);
          echo form_open_multipart("clog/cautelas/criar_cautela/$cautela->id", array('role'=>'form', 'class'=>'form-horizontal'));?>

            <div class="form-group">
              <label for="quantidade_itens" class="col-sm-2 control-label">Quantidade</label>
              <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <input type="text" name="quantidade_itens" class="form-control" id="quantidade_itens" placeholder="Quantidade de Itens">
              </div>
            </div>

            <div class="form-group">
              <label for="produtos" class="col-sm-2 control-label">Produtos</label>
              <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <select multiple name="produtos[]" class="form-control produtos" id="produtos">
                <?php foreach ($produtos->result() as $produto): ?>
                  <option value="<?php echo $produto->id; ?>"><?php echo $produto->modelo; ?></option>
                <?php endforeach; ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
                <button type="submit" class="btn btn-default">Incluir</button>
                <button type="button" class="btn btn-default" onclick="location.href = '<?php echo BASE_URL('clog/cautelas/cautelar').'?id='.$cautela->id; ?>';">Gerar Cautela</button>
              </div>
            </div>
          <?php echo form_close(); ?>
        </div> <!-- .-->
      </div>
    </div>
    
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12"></div>
  </div>
</div>