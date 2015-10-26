<select name="numero" id="numero" class="form-control">
  <option selected>N° Turma</option>
  <?php
  foreach($options as $linhas=>$linha):
  	foreach ($linha as $chv=>$val){
      if ($chv=='id') $id=$val;
      if ($chv=='numero') $numero=$val;
    }
  ?>
  <option value="<?php echo $numero; ?>"><?php echo $numero; ?> ° Turma</option>
	<?php endforeach; ?>
</select>