<?php ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Informações importantes</h4>
	</div>
	<?php
	# Verificação se turma de férias existe.
	## Se não...
	if (! isset($turma_ferias_id)) { ?>
		<div class="panel-body">
			<div class="group">
				<label>Período de férias do militar não existe.</label>
			</div>
		</div>
		<?php 
	}
	## Existindo...
	else { 
		# Verificação se turma de férias existe.
		if (isset($turma_ferias_id)) {
			# Verifica se o exercício é anterior ao atual
			if ((date("Y") - 1) > $exercicio) { ?>
				<div class="panel-body">
					<div class="group">
						<label>Não se pode sustar férias de exercícios anteriores.</label>
					</div>
				</div>
				<?php
			}
			else { 
				# $data_atual = date("Y-m-d");
				$data_atual = date('Y-m-d', strtotime('2016-07-10'));
				$dias_restantes = date_diff(date_create($data_atual), date_create($data_fim)); 
				# Testa se o militar está em período que permite sustar férias
				## Se não...
				if ($dias_restantes->days > 35) { ?>
					<div class="panel-body">
						<div class="group">
							<label> As férias deste militar ainda não podem ser sustadas.</label>
						</div>
					</div>
					<?php
				}
				## Se sim...
				else { 
					if ($sustado == 1) {?>
						<div class="panel-body">
							<div class="group">
								<label> Este militar possui férias parciais cadastradas neste exercício.</label>
							</div>
						</div>
						<?php
					}
					else { ?>
						<div class="panel-body">
							<?php echo form_open('rh/ferias/salvar_sustar_ferias'); ?>
								<input type="hidden" name="data_inicio" value="<?php echo $data_inicio; ?>" />
								<input type="hidden" name="data_fim" value="<?php echo date('Y-m-d'); ?>" />
								<input type="hidden" name="turma_ferias_id" value="<?php echo $turma_ferias_id; ?>" />
								<input type="hidden" name="militares_ferias_id" value="<?php echo $militares_ferias_id; ?>" />
								<input type="hidden" name="militares_id" value="<?php echo $militares_id; ?>" />
								
								<div class="group">
									<label>Militar: <?php echo (isset($militar)) ? $militar : ""; ?></label>
								</div>

								<div class="group">
									<label>Nome do Militar: <?php echo (isset($nome)) ? $nome : ""; ?></label>
								</div>

								<div class="group">
									<label>Matricula: <?php echo (isset($matricula)) ? $matricula : ""; ?></label>
								</div>

								<div class="group">
									<label>Exercício: <?php echo (isset($exercicio)) ? $exercicio : ""; ?></label>
								</div>

								<div class="group">
									<label>Turma Férias: <?php echo (isset($numero)) ? $numero : ""; ?> ° Turma</label>
								</div>

								<div class="group">
									<label>Data início: <?php echo date('d/m/Y', strtotime($data_inicio)); ?></label>
								</div>

								<div class="group">
									<label>Data prevista de volta: <?php echo date('d/m/Y', strtotime($data_fim)); ?></label>
								</div>

								<div class="group">
									<label>Dias Restantes: <?php echo $dias_restantes->days; ?></label>
								</div>
								
								<div class="group">
									<label>Deseja sustar férias? <?php echo ($militares_ferias_id) ? "<button type='submit' class='btn btn-primary btn-xs'>Sim</button>" : "Militar não está em período de férias."; ?></label>
								</div>
							<?php echo form_close(); ?> <!-- Fim formulário. -->
						</div>
						<?php
					}
				}
			}
		} 
	} ?>
</div>