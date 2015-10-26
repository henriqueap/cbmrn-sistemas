
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <h1><?= (!isset($data->id)) ? 'Cadastro de Chefias no Organograma' : 'Editar Chefias no Organograma'; ?></h1>
        <hr />
        <?php echo form_open('rh/chefias/salvar', array('role' => 'form', 'class' => 'form-horizontal')); ?>
        <input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />
        <input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />

        <div class="form-group">
            <label for="" class="col-sm-2 control-label">Seção</label>
            <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                <select name="secao" class="form-control">
                    <option value="">Seções</option>
                    <?php foreach ($lista_lotacoes->result() as $lista_lotacoes) : ?>
                    <option value="<?php echo $lista_lotacoes->id; ?>"><?php echo $lista_lotacoes->nome; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="matricula" class="col-sm-2 control-label">Chefe</label>
            <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
                <input type="text" rel="matricula" class="form-control input-xs" id="search-militar-matricula" name="matricula" placeholder="Matrícula" />                
                <input type="hidden" class="form-control input-xs" id="chefe_militares_id" name="chefe_militares_id" />                
            </div>
            <div class="col-sm-6">
                <label class="control-label" id="nome_militar"></label>
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
