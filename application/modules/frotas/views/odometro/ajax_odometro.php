				<?php
				/* var_dump($listar_tipos_odo); echo "<br />";
				var_dump($info_odo); die("entrou!"); */
				
				
				if (! $info_odo) { ?>
					<div class="form-group">
						<label for="selTipoOdo" class=" col-sm-1  control-label">Ação</label>
						<div class=" col-sm-3 ">
							<select class="form-control input-sm" name="selTipoOdo" id="selTipoOdo" required>
								<option value>Selecione</option>
								<?php foreach($listar_tipos_odo as $tipo) : ?> 
									<option value="<?php echo $tipo->tipos_odometros_id; ?>">
										<?php echo $tipo->tipo_odometro; ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div> 

					<div class="form-group">
						<label for="inputDestino" class=" col-sm-1  control-label">Destino</label>
						<div class=" col-sm-6 ">
							<textarea class="form-control" name="inputDestino" id="inputDestino" cols="30" rows="2" placeholder="Preeencha o destino"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputAlteracao" class=" col-sm-1  control-label">Alteração</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="inputAlteracao" id="inputAlteracao" cols="50" rows="3" placeholder="Preencha caso haja alguma alteração na viatura."></textarea>
						</div>
					</div>
					<?php
				} 
				else {
					// Cuidado! Está puxando a última e insernido sua contrapaarte quando existe
					switch ($info_odo->tipo) {
							case 1:
								$alteracao = (is_null($info_odo->alteracao) || $info_odo->alteracao=="")? 
									'Sem alteração': 
								$info_odo->alteracao;
								$destino = (is_null($info_odo->destino) || $info_odo->destino=="")? 
									'Sem destino cadastrado': 
								$info_odo->destino;
								$disabled = "disabled";
								$tipo_selected = 2;
							break;
							case 2:
								$alteracao = "";
								$destino = "";
								$disabled = "";
								$tipo_selected = 1;
							break;
							case 3:
								$alteracao = (is_null($info_odo->alteracao) || $info_odo->alteracao=="")? 
									'Sem alteração': 
								$info_odo->alteracao;
								$destino = "Término de serviço operacional (".date('d/m/Y', strtotime('+1 day')).")";
								$disabled = "disabled";
								$tipo_selected= 4;
							break;
							case 4:
								$alteracao = "";
								$destino = "Início de serviço operacional (".date('d/m/Y').")";
								$disabled = "";
								$tipo_selected= 3;
							break;
							/*case 5:
								$id_tipo_saida = 6;
								break;
							case 6:
								$id_tipo_saida = 5;
								break;
							case 7:
								$destino = "Abastecimento da viatura (".date('d/m/Y').")";
								$disabled = "disabled";
							break;*/
							default:
								$alteracao = "";
								$destino = "";
								$disabled = "";
								$tipo_selected= 1;
							break;
					} ?>
					<div class="form-group">
						<!--label for="selTipoOdo" class=" col-sm-1  control-label">Ação</label>
						<div class=" col-sm-3 ">
							<select class="form-control input-sm" name="selTipoOdo" id="selTipoOdo" required>
								<option value>Selecione</option>
									<?php /*foreach($listar_tipos_odo as $tipo) : 
										if ($tipo->tipos_odometros_id == $tipo_selected) { ?>
											<option value="<?php echo $tipo->tipos_odometros_id; ?>" selected>
												<?php echo $tipo->tipo_odometro; ?>
											</option><?php
										} 
										else { ?>
											<option value="<?php echo $tipo->tipos_odometros_id; ?>">
												<?php echo $tipo->tipo_odometro; ?>
											</option><?php
										}?>
									<?php endforeach; */?>
							</select>
						</div-->
						<input type="hidden" name="hiddenTipoOdo" id="hiddenTipoOdo" value="<?php echo $tipo_selected; ?>" />
					</div> 
					<div class="form-group">
						<label for="inputDestino" class=" col-sm-1  control-label">Destino</label>
						<div class=" col-sm-6 ">
							<textarea class="form-control" name="inputDestino" id="inputDestino" cols="30" rows="2" placeholder="Preeencha o destino" <?php echo $disabled; ?>><?php echo $destino; ?></textarea>
							<input type="hidden" name="hiddenDestino" id="hiddenDestino" value="<?php echo $destino; ?>" />
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputAlteracao" class=" col-sm-1  control-label">Alteração</label>
						<div class="col-sm-6">
							<textarea class="form-control" name="inputAlteracao" id="inputAlteracao" cols="50" rows="3" placeholder="Preencha caso haja alguma alteração na viatura." ><?php echo $alteracao; ?></textarea>
						</div>
					</div>
					<?php
				} ?>