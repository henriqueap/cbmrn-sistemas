<label for="selModelo" class="col-sm-2 control-label">Modelo</label>
<div class="col-sm-4">
    <select class="form-control input-sm" id="selModelo" name="selModelo" >
        <option value="0" selected>Selecione os modelos</option>
        <?php foreach($modelos as $modelos) : ?>
        <option value="<?php echo $modelos->id; ?>"><?php echo $modelos->modelo; ?></option>
        <?php endforeach; ?>
    </select>
</div>
 