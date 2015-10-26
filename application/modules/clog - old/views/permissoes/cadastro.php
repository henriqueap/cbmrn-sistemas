<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Cadastro de Permissões</h1>
        </div>
        <hr>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <?php echo form_open('clog/permissao/novaPermissao', array('role'=>'form', 'class'=>'form-horizontal')); ?>
                <div class="form-group">
                    <label for="modulos_id" class="col-sm-2 control-label">Módulo</label>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <select name="modulos_id" class="form-control" id="modulos_id">
                        <option value="0">Selecione o Módulo</option>
                        <?php foreach($modulos as $row): ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="permissoes_nome" class="col-sm-2 control-label">Permissão</label>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <input type="text" name="permissoes_nome" class="form-control" id="permissoes_nome" value="<?php echo ""; ?>" placeholder="Permissão" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="permissoes_pagina" class="col-sm-2 control-label">Página</label>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <input type="text" name="permissoes_pagina" class="form-control" id="permissoes_pagina" value="<?php echo ""; ?>" placeholder="Página" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
                        <button type="submit" class="btn btn-default">Salvar</button>
                    </div>
                </div>
              <?php echo form_close(); ?>
              </div>
            </div>
        </div>
    </div> <!-- .row -->
</div> <!-- .container -->