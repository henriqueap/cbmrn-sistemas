
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
      <h1>Consulta de Afastamentos</h1>
      <hr />
      <form action="#" method="post" class="form-horizontal" role="form"> 
        <input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />
        <input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />

        <div class="form-group">
          <label for="matricula" class="col-sm-2 control-label">Matrícula</label>
          <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
            <input type="text" rel="matricula" class="form-control input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required />
            <input type="hidden" class="form-control input-xs" id="chefe_militares_id" name="chefe_militares_id" />                
          </div>
          <div class="col-sm-6">
            <label class="control-label" id="nome_militar"></label>
          </div>
        </div>

        <div class="form-group">
          <label for="numero_processo" class="col-sm-2 control-label">N° Processo</label>
          <div class="col-sm-2">
              <input type="text" class="form-control input-sm" rel="" id="numero_processo" name="numero_processo" placeholder="Número do Processo">
          </div>
        </div>

        <div class="form-group">
          <label for="numero_processo" class="col-sm-2 control-label">Tipo de Afastamento</label>
          <div class="col-sm-2">
            <select name="tipo_afastamentos_id" id="tipo_afastamentos_id" class="form-control input-sm">
              <option value="">Tipo de Afastamento</option>
              <?php foreach($tipo_afastamentos->result() as $tipo_afastamentos): ?>
              <option value="<?php echo $tipo_afastamentos->id; ?>"><?php echo $tipo_afastamentos->nome; ?></option>
             <?php endforeach;?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label for="data_inicio" class="control-label col-sm-2">Período Inicial</label>
          <div class="col-sm-2">
            <input type="date" name="data_inicio" id="data_inicio" class="form-control input-sm" />
          </div>
        </div>

        <div class="form-group">
          <label for="data_fim" class="control-label col-sm-2">Período Final</label>
          <div class="col-sm-2">
            <input type="date" name="data_fim" id="data_fim" class="form-control input-sm" />
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-primary btn-xs" id="btn-buscar-afastamentos">Buscar</button>
          </div>
        </div>
      </form> <!-- formulário -->
      <hr />
      <div id="result-search">
        <!--Imprime o resultado da busca -->
      </div>
    </div>
  </div> <!-- .row -->
</div> <!-- /.container -->
