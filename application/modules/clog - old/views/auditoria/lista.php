<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Filtros</h1></div>
		<hr>
		<?php echo form_open("clog/filtrar_auditoria", array('role'=>'form', 'class'=>'form-inline', 'id'=>'frm-audita')); ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<input type="hidden" name="pg_atual" id="pg_atual" value="1"/>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 form-group">
					<!--<input type="date" name="data_inicial" class="control-inline" id="data_inicial" title="Data Inicial" value="<?php //echo (isset($filters['data_inicial'])) ? $filters['data_inicial'] : ''; ?>"/>-->
					<div class="input-group">
						<label for="data_inicial" class="control-label">Período&nbsp;</label>
						<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
						<input name="data_inicial" class="control-inline data" type="text" aria-describedby="calendar-add-on" rel="data" id="data_inicial" title="Data Inicial" value="<?php echo (isset($filters['data_inicial'])) ? $filters['data_inicial'] : ''; ?>"/>
					</div>
				</div>
				&nbsp;
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-2 form-group">	
					<!--<input type="date" name="data_final" class="control-inline" id="data_final" title="Data Final" value="<?php //echo (isset($filters['data_final'])) ? $filters['data_final'] : ''; ?>"/>-->
					<div class="input-group">
						<label for="data_final" class="control-label">&nbsp;&nbsp;à&nbsp;</label>
						<span id="calendar-add-on" class="glyphicon glyphicon-calendar input-group-addon" aria-hidden="true"></span>
						<input name="data_final" class="control-inline data" type="text" aria-describedby="calendar-add-on" rel="data" id="data_final" title="Data Final" value="<?php echo (isset($filters['data_final'])) ? $filters['data_final'] : ''; ?>"/>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 form-group">
					<label for="tipo_auditoria" class="control-label">Ação</label>
					<select name="tipo_auditoria" class="control-inline" id="tipo_auditoria">
						<option value="0">Selecione a ação</option>
						<?php 
						foreach($acoes as $acao): 
							if (isset($filters['idtipo']) && $filters['idtipo'] == $acao->id) { ?>
								<option value="<?php echo $acao->id; ?>" selected><?php echo ucfirst($acao->tipo); ?></option>
								<?php
							}
							else { ?>
								<option value="<?php echo $acao->id; ?>"><?php echo ucfirst($acao->tipo); ?></option>
								<?php
							}
						endforeach; ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 form-group">
					<label for="militares_id" class="control-label">Militar</label>
					<select name="militares_id" class="control-inline" id="militares_id">
						<option value="0">Selecione o Militar</option>
						<?php foreach($militares as $militar): 
							if (isset($filters['idmilitar']) && $filters['idmilitar'] == $militar->idmilitar) { ?>
								<option value="<?php echo $militar->idmilitar; ?>" selected><?php echo $militar->militar; ?></option>
								<?php
							}
							else { ?>
								<option value="<?php echo $militar->idmilitar; ?>"><?php echo $militar->militar; ?></option>
								<?php
							}
						endforeach; ?>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-1 form-group">
					<!--<button class="btn btn-default" id="btn-consulta-auditoria">Aplicar</button>-->
					<input type="submit" class="btn btn-default" id="btn-consulta-auditoria" value="Aplicar"/>
				</div>
			</div>
		<?php echo form_close(); ?><br />
		<hr>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Auditoria</h1></div>
		<hr>
		<div id="resultado_consulta" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Ordem</th>
									<th>ID</th>
									<th>Data</th>
									<th>Tipo</th>
									<th>Ação</th>
									<th>Militar</th>
									<th>Sistema</th>
									<th>IP</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (isset($lista) && (! is_bool($lista))) {
									/*echo "<pre>";
									var_dump($lista);
									echo "</pre>";*/
									$count = (isset($_GET['page'])) ? (($_GET['page'] - 1) * $linhas) + 1 : 1;
									foreach($lista as $acao):  ?>
										<tr>
											<td><?php echo $count++; ?></td>
											<td><?php echo $acao->id; ?></td>
											<td><?php echo $acao->dia." às ".$acao->hora; ?></td>
											<td><?php echo ucfirst($acao->tipo); ?></td>
											<td><?php echo $acao->auditoria; ?></td>
											<td><?php echo $acao->militar; ?></td>
											<td><?php echo $acao->modulo; ?></td>
											<td><?php echo $acao->ip; ?></td>
										</tr>
										<?php 
									endforeach;
								}
								else { ?>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
									<?php 
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php
			if (isset($num_regs) && $num_regs > 0) {
				$quant_pg = ceil($num_regs/$linhas);
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<nav class="center">
						<ul id="pagination" class="pagination-sm" data-total-pages="<?php echo $quant_pg; ?>"></ul>
					</nav>
				</div>
				<?php
			} ?>
		</div>
		<!--<div class="form-group">
			<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
				<button type="button" class="btn btn-default" onclick="history.back();" value="Voltar">Voltar</button>
			</div>
		</div>-->
	</div> <!-- .row -->
</div> <!-- .container -->