<div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <h1><?= (!isset($data->id)) ? 'Cadastro de Patente' : 'Editar Patente'; ?></h1>
        <hr />
        <?php echo form_open('rh/patentes/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
        <!--hidden-->
        <input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />

        <div class="form-group">
            <label for="nome" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Patente</label>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
                <input type="text" name="nome" class="form-control" id="nome" value="<?= set_value('nome', isset($data->nome) ? $data->nome : ""); ?>" placeholder="Patente"/>
            </div>
        </div><!--/.form-group-->

        <div class="form-group">
            <label for="sigla" class="col-sm-12 col-md-2 col-lg-2 col-xs-12 control-label">Sigla Patente</label>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xs-12">
                <input type="text" name="sigla" class="form-control" id="sigla" value="<?= set_value('Sigla', isset($data->sigla) ? $data->sigla : ""); ?>" placeholder="Sigla da Patente"/>
            </div>
        </div><!--/.form-group-->

        <div class="form-group">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
                <input type="submit" value="Salvar" class="btn btn-primary" />
            </div>
        </div><!--/.form-group-->
        <?php echo form_close(); ?>
    </div>
</div><!--/.container-->