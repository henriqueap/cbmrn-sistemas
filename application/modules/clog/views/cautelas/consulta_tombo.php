<div class="container">
  <div class="row">
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
      <h1>Consulta de Material Permanente</h1>
      <hr>
    </div>
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Consulta de Tombo</h3>
        </div>
        <div class="panel-body">
          <?php //echo form_open('clog/cautelas/salvar_cautela', array('role' => 'form', 'class' => 'form-horizontal')); ?>
            <!-- Solicitante -->
            <!--<div class="form-group">
              <label for="search-militar-matricula" class="col-sm-2 control-label">Matrícula</label>
              <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <input type="text" rel="matricula" class="form-control input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required="required">
                <input type="hidden" class="form-control input-xs" id="chefe_militares_id_hidden" name="chefe_militares_id" value="<?php ?>">
              </div>
              <div class="col-sm-6">
                <label class="control-label" id="nome_militar"></label>
              </div>
            </div>-->
            <!-- Setor -->
            <!--<div class="form-group">
              <label for="setor_id" class="col-sm-2 control-label">Setor</label>
              <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <select name="setor_id" class="form-control" id="setor_id" title="Selecione o setor para onde o tombo será transferido">
                  <option value="0">Selecione o setor</option>
                  <?php foreach ($setores as $setor): ?>
                    <option value="<?php echo $setor->id; ?>"><?php echo $setor->sigla; ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>-->
            <!-- Números de tombo -->
            <div class="form-group">
              <label for="" class="col-sm-2 control-label">Tombo</label>
              <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <input type="text" name="tombo" id="tombo" class="form-control input-sm" placeholder="Nº Tombo" required="required" title="Colocar o número de tombo"/>
                <input type="hidden" class="form-control input-xs" id="distro_id" name="distro_id" value="<?php ?>">
              </div>
              <div class="col-sm-6">
                <label class="control-label" id="tombo_info"></label>
              </div>
            </div>
            <!-- Submeter -->
            <!--<div class="form-group">
              <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
                <button type="submit" class="btn btn-default">Iniciar</button>
              </div>
            </div>-->
          <?php echo form_close(); ?>
        </div> <!-- .panel-->
      </div>
    </div>
    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
    </div><!---->
  </div>
</div>