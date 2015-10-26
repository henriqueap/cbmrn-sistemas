<div class="container">
<div class="row">
<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
<?php echo form_open_multipart("clog/cautelas/criar_cautela/$cautela->id", array('role'=>'form', 'class'=>'form-horizontal'));?>
<input type="hidden" name="id_cautela" id="id_cautela" value="<?= $cautela->id; ?>">

<div class="form-group">
  <label for="" class="col-sm-2 control-label">Quantidade Itens</label>
  <div class="col-sm-12 col-md-3 col-lg-3 col-xs-12"> 
    <input type="text" name="quantidade_itens" class="form-control" id="quantidade_itens" placeholder="Quantidade de Itens">
  </div>
</div>

<div class="form-group">
  <label for="produtos" class="col-sm-2 control-label">Produtos</label>
  <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
    <select multiple name="produtos[]" class="form-control produtos" id="produtos">
    <?php foreach ($produtos->result() as $produtos): ?>
    <option value="<?php echo $produtos->id; ?>"><?php echo $produtos->modelo; ?></option>
    <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="form-group">
<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
  <button type="submit" class="btn btn-default">Salvar Cautela</button>
</div>
</div>
<?php echo form_close(); ?>
</div>
</div><!--.row-->

<div class="row">
   <div class=""></div>
</div>
</div><!--.container-->