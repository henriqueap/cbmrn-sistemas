<div class="container">
	<div class="row">
	 <h1>Reaprazamento de Férias</h1>
	 <hr>
	<?php echo form_open('#', array('class'=>'form-horizontal', 'role'=>'form')); ?>
			<input type="hidden" name="id" value="<?= set_value('id', isset($data->id) ? $data->id : ""); ?>" />
			<!-- <input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" /> -->
			<input type="hidden" name="militar_id_hidden" id="militar_id_hidden" value="" />
			<div class="form-group">
				<label for="matricula" class="col-sm-2 control-label input-sm">Matrícula</label>
				<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
					<input type="text" rel="matricula" class="form-control input-xs input-sm" id="search-id-matricula" name="matricula" placeholder="Matrícula" required />
				 <!-- <input type="hidden" class="form-control input-xs input-sm" id="chefe_militares_id" name="chefe_militares_id" required /> -->
					<input type="hidden" class="form-control input-xs input-sm" id="militar_id" name="militar_id" required />
				</div>
				<div class="col-sm-6">
					<label class="control-label" id="nome_militar"></label>
				</div>
			</div><!--/.form-group-->

			<div class="form-group">
				<label for="exercicio" class="col-sm-2 control-label input-sm">Exercicio</label>
				<div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
					<!-- Lista de todos os exercicios cadastrados -->
					<select name="exercicio" id="exercicio" class="form-control input-sm" required>
						<option value="<?php echo date('Y'); ?>">Exercicio</option>
						<?php foreach ($turma_ferias as $row): ?>
							<option value="<?php echo $row->exercicio ?>"><?php echo $row->exercicio ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-primary btn-xs" id="buscar-info-reaprazamento">Buscar</button>
				</div>
			</div>
		<?php echo form_close(); ?>
		<hr>

		<div id="result-search" class="col-lg-12 col-md-12">
			<!--Resultado das consultas serão gerados nesta div-->
		</div>
	</div>
</div>

