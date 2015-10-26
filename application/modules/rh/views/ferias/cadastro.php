
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h1><?= (!isset($data->id)) ? 'Cadastro de Turma de Férias' : 'Editar Turma de Férias'; ?></h1>
            <hr />
            <?php echo form_open('rh/ferias/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
            <input type="hidden" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ""); ?>" />
            <input type="hidden" name="" id="" value="" />

            <div class="form-group">
                <label for="numero" class="col-sm-2 control-label">Número da Turma</label>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <input type="text" name="numero" class="form-control" id="numero" value="<?php echo set_value('id', isset($data->numero) ? $data->numero : ""); ?>" placeholder="Número da Turma"/>
                </div>
            </div>

            <div class="form-group">
                <label for="data_inicio" class="col-sm-2 control-label">Data de inicío</label>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <input type="date" name="data_inicio" class="form-control" id="data_inicio" value="<?php echo set_value('data_inicio', isset($data->data_inicio) ? $data->data_inicio : ""); ?>" />
                </div>
            </div>

            <div class="form-group">
                <label for="exercicio" class="col-sm-2 control-label">Exercicio</label>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
                    <input type="text" name="exercicio" class="form-control" id="exercicio" value="<?php echo date('Y'); ?>" placeholder=""/>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
                    <input type="submit" value="Salvar" class="btn btn-primary" />
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
