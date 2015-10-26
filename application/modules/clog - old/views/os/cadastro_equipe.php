<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Cadastro de Equipe</h1>
        </div>
        <hr>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <?php echo form_open('clog/os/novaEquipe', array('role'=>'form', 'class'=>'form-horizontal')); ?>
                <div class="form-group">
                    <label for="os_idmilitar" class="col-sm-2 control-label">Militar</label>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <select name="militares_id" class="form-control" id="os_idmilitar">
                        <option value="0">Selecione o Militar</option>
                        <?php foreach($militares as $rowM): ?>
                        <option value="<?php echo $rowM->idmilitar; ?>"><?php echo $rowM->militar; ?></option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="os_idlotacao" class="col-sm-2 control-label">Setor</label>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <select name="lotacoes_id" class="form-control" id="os_idlotacao">
                        <option value="0">Selecione o Setor</option>
                        <?php foreach($setores as $rowS): ?>
                        <option value="<?php echo $rowS->id; ?>"><?php echo $rowS->sigla; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div id="arvore"></div>
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