			<script>
				$("#pagination").twbsPagination({
					first:'<<',
					prev: '<',
					next: '>',
					last: '>>',
					startPage: <?php echo (isset($_GET['page'])) ? $_GET['page'] : 1; ?>, 
					totalPages: $("#pagination").attr("data-total-pages"),
					visiblePages: 10,
					//href: BASE_URL + 'index.php/clog/filtrar_auditoria?page={{number}}',
					onPageClick: function (event, page) {
					dtIniVal =  $("#data_inicial").val().split("/");
					dtIni = dtIniVal[2]+"-"+ dtIniVal[1]+"-"+dtIniVal[0];
					// Tratando data final
					if ($("#data_final").val() == "") {
						dataHj = new Date();
						dHj = (dataHj.getDate() > 9) ? dataHj.getDate() : "0"+dataHj.getDate();
						mHj = ((dataHj.getMonth()+1) > 9) ? (dataHj.getMonth()+1) : "0"+(dataHj.getMonth()+1);
						aHj = dataHj.getFullYear();
						$("#data_final").val(dHj+"/"+mHj+"/"+aHj);
						dtFim = aHj+"-"+mHj+"-"+dHj;
					}
					else {
						dtFimVal =  $("#data_final").val().split("/");
						dtFim = dtFimVal[2]+"-"+ dtFimVal[1]+"-"+dtFimVal[0];
					}
					event.preventDefault();
					audita = $.ajax({
								url: BASE_URL + 'index.php/clog/filtrar_auditoria?page='+page,
								type: 'POST',
								dataType: 'html',
								data: {
								data_inicial: dtIni, 
								data_final: dtFim,
								tipo_auditoria: $("#tipo_auditoria").val(), 
								militares_id: $("#militares_id").val()
							}
						});
							audita.done(function(result) {
								$("#resultado_consulta").empty();
								$("#resultado_consulta").html(result);
							});
					}
				});
			</script>
			<div class="panel panel-default">
				<div class="panel-body">
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
			<?php
			#var_dump($num_regs);
			if (isset($num_regs) && $num_regs > 0) {
				$quant_pg = ceil($num_regs/$linhas);
				#var_dump($quant_pg);
				?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<nav class="center">
						<ul id="pagination" class="pagination-sm" data-total-pages="<?php echo $quant_pg; ?>"></ul>
					</nav>
				</div>
				<?php
			} ?>