<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12" id="salas">
	<select name="salas" class="form-control" id="sel_salas" title="Nome da Sala" required>
		<option value="0">Selecione</option>
		<?php 
		if (!is_bool($salas)) {
			foreach ($salas->result() as $sala): ?>
				<option value="<?php echo $sala->id; ?>"><?php echo $sala->nome; ?></option>
				<?php 
			endforeach; 
		}	?>
	</select>
</div>