<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/default.css">
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Boletins Gerais</h1>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
	</div><!--.row-->
	<hr>
	<div>
		  <a class="btn btn-sm  btn btn-sm btn-danger" title="Consultar Boletim" href="<?php  echo base_url('index.php/publico/publico/consultar'); ?>">Consultar</a>
	</div>
	<div class="panel-body">
			<ul>
				<?php
				
				$i=2012;
				foreach ($meses->result() as $listaMeses) :
					//echo $listaMeses->ano." ".$i;
					if($listaMeses->ano==2014){
						if($listaMeses->mes==1){	
							?>
							<fieldset>
								<legend>Janeiro<?php echo $listaMeses->ano; ?></legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==01){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
									<ul>											
										<li class="list-button-item link-container">
											<a  target="_blank" href="../../../../<?php echo htmlentities(htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8"), ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de janeiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>
										</li>
									</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
							}
						if($listaMeses->mes==2){
							?>
							<fieldset>
								<legend>Fevereiro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==02){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de fevereiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
							</fieldset>
							<?php	}								
								}
							endforeach;
						}
						if($listaMeses->mes==3){
							?>
							<fieldset>
								<legend>Março <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==03){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de março de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}									
								}
							endforeach;
						}
						if($listaMeses->mes==4){
							?>
							<fieldset>
								<legend>Abril <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==04){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>							
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de abril de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>
									</li>
								</ul>
							</fieldset>
							<?php
									}									
								}
							endforeach;
						}
						if($listaMeses->mes==5){	
							?>
							<fieldset>
								<legend>Maio <?php echo $listaMeses->ano; ?> </legend>
							<?php				
							foreach ($consulta->result() as $lista) :									
								if(date('m',strtotime($lista->data_gerado))==05){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de maio de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
									<?php										
									}
								}
								endforeach;
										?>
							</fieldset>
							<?php
						}

						if($listaMeses->mes==6){
							?>
							<fieldset>
								<legend>Junho <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==06){
									if(date('Y',strtotime($lista->data_gerado))==2014){
								?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de junho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
								</fieldset>
							<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==7){
							?>
							<fieldset>
								<legend>Julho <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==07){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de julho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==8){
							?>
							<fieldset>
								<legend>Agosto <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==08){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de agosto de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==9){	
							?>
							<fieldset>
								<legend>Setembro <?php echo $listaMeses->ano; ?> </legend>
							<?php				
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==09){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de setembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}								
								}
							endforeach;
						}
						if($listaMeses->mes==10){	
							?>
							<fieldset>
								<legend>Outubro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==10){
									if(date('Y',strtotime($lista->data_gerado))==2014){
								?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de outubro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
							</fieldset>
								<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==11){	
							?>
							<fieldset>
									<legend>Novembro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
									if(date('m',strtotime($lista->data_gerado))==11){
										if(date('Y',strtotime($lista->data_gerado))==2014){
								?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de novembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
								</fieldset>
								<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==12){	
							?>
							<fieldset>
								<legend>Dezembro <?php echo $listaMeses->ano; ?> </legend>
							<?php							
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==12){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de dezembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
						}
					}

					elseif($listaMeses->ano==$i){
						if($listaMeses->mes==1){	
							?>
							<fieldset>
								<legend>Janeiro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==01){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
									<ul>											
										<li class="list-button-item link-container">
											<a  target="_blank" href="../../../../<?php echo htmlentities(htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8"), ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de janeiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>
										</li>
									</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
							}
						if($listaMeses->mes==2){
							?>
							<fieldset>
								<legend>Fevereiro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==02){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de fevereiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
							</fieldset>
							<?php	
									}								
								}
							endforeach;
						}
						if($listaMeses->mes==3){
							?>
							<fieldset>
								<legend>Março <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==03){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de março de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php	
									}								
								}
							endforeach;
						}
						if($listaMeses->mes==4){
							?>
							<fieldset>
								<legend>Abril <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==04){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
							
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de abril de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>
									</li>
								</ul>
							</fieldset>
							<?php
									}									
								}
							endforeach;
						}
						if($listaMeses->mes==5){	
							?>
							<fieldset>
								<legend>Maio <?php echo $listaMeses->ano; ?> </legend>
							<?php				
							foreach ($consulta->result() as $lista) :									
								if(date('m',strtotime($lista->data_gerado))==05){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de maio de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
									<?php
									}										
								}
								endforeach;
										?>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==6){
							?>
							<fieldset>
								<legend>Junho <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==06){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
								?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de junho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
								</fieldset>
								<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==7){
							?>
							<fieldset>
								<legend>Julho <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==07){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de julho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==8){
							?>
							<fieldset>
								<legend>Agosto <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==08){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de agosto de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==9){	
							?>
							<fieldset>
								<legend>Setembro <?php echo $listaMeses->ano; ?> </legend>
							<?php				
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==09){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de setembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}								
								}
							endforeach;
						}
						if($listaMeses->mes==10){	
							?>
							<fieldset>
								<legend>Outubro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==10){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
								?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de outubro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
							</fieldset>
								<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==11){	
							?>
							<fieldset>
									<legend>Novembro <?php echo $listaMeses->ano; ?> </legend>
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==11){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
								?>
									<ul>
										<li>
											<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de novembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
										</li>
									</ul>
								</fieldset>
								<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==12){	
							?>
							<fieldset>
								<legend>Dezembro <?php echo $listaMeses->ano; ?> </legend>
							<?php							
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==12){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								<ul>
									<li>
										<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de dezembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>	
									</li>
								</ul>
							</fieldset>
							<?php
									}
								}
							endforeach;
						};
					}
				$i++;
				endforeach;
			
					
										
				?>
			</ul>

	</div>

</div>