<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Informações importantes</h4>
			</div>
				<?php 
					# Condição para verificar se existe o id da turma.
					if (isset($turma_ferias_id)) : 
					
					# Exibir formulário para salvar reaprazamento. 
					echo form_open('rh/ferias/salvar_reaprazamento', array('class'=>'form-horizontal')); 
				?>
				<div class="panel-body">
					<input type="hidden" name="militares_id" value="<?php echo $militares_id; ?>" />
					<input type="hidden" name="turma_ferias_id" value="<?php echo $turma_ferias_id; ?>" />

					<div class="group">
					<label>Nome do Militar: <?php echo (isset($nome)) ? $nome : ""; ?></label>
					</div>

					<div class="group">
					<label>Matricula: <?php echo (isset($matricula)) ? $matricula : ""; ?></label>
					</div>

					<div class="group">
					<label>Turma Férias: <?php echo (isset($numero)) ? $numero : ""; ?> ° Turma</label>
					</div>

					<div class="group">
					<label>Data início: <input type="text" name="data_inicio" rel="data" class="form-control input-xs input-sm" value="<?php echo date('d/m/Y', strtotime($data_inicio)); ?>"></label>
					</div>

					<div class="group">
					<label>Quantidade de dias: <input type="text" name="data_fim" rel="data" class="form-control input-xs input-sm" value="30" placeholder=""></label>
				</div>
			  	<div class="group">
	            <label for="justificativas" class="">Justificativas: 
	              <textarea name="justificativas" class="form-control" id="justificativas" rows="7" cols="45" placeholder="Justificativas para o afastamento" required></textarea>
              	</label>
		        </div>
				  <div class="group">
				  	<button type="submit" class="btn btn-primary btn-xs" id="">Salvar</button>
				  </div>
				</div>
			<?php echo form_close(); ?>
			<?php else: # Caso contrário o período de férias não existe. ?>
				<div class="panel-body">
				  <div class="group">
				    <label>Período de férias do militar não existe.</label>
				  </div>
				</div>
			<?php endif; ?>
		</div>
	</div> <!--.row-->
</div> <!--.container-->