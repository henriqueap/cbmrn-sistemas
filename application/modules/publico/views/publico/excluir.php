<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/default.css">
<div id="modal">
    <div class="modal fade" id="myModal-excluir-boletim" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Atenção!</h3>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir o boletim?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <a type="button" class="btn btn-primary" id="bt-modal-confirmar-exclusao-boletim" href="#">Sim</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal --> 
</div>
<!-- HTML Modal -->
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Boletins Gerais</h1>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
	</div><!--.row-->
	<hr>
	<div class="form-group"> 
     	<div class="col-sm-2 ">
			<a class="btn btn-sm  btn btn-sm btn-danger" title="Cadastrar Novo Boletim" href="<?php  echo base_url('index.php/publico/publico/cadastro'); ?>">Cadastrar Novo Boletim</a>             	</div>
     	<?php echo form_open('index.php/publico/publico/viewExcluir', array('id' => 'template-add-form', 'class' => 'form-horizontal')); ?>
       	                 		
                <label  class="col-sm-2 control-label">Período entre</label>
                <div class=" col-sm-3 ">
                    <input name="dataInicial" class="form-control" type="date" id="dataInicial" value="<?php echo date('Y-m-d')?>" />
                </div>
                <label  class="col-sm-1 control-label">e </label>
                 <div class=" col-sm-3 ">
                    <input name="dataFinal" class="form-control" type="date" id="dataFinal"  value="<?php echo date('Y-m-d')?>" />
                </div>
                <button  type="submit" class="glyphicon glyphicon-ok btn btn-sm  btn btn-sm btn-danger" title="Aplicar Filtro" id="btn-buscar-boletim"><span></span></button>
                <a href="<?php echo base_url('index.php/publico/publico/viewExcluir')?>"  class="glyphicon glyphicon-remove btn btn-sm  btn btn-sm btn-danger" title="Remover Filtro"><span></span></a>        
	   
	    <?php echo form_close ();?>	
    </div>
	<div class="panel-body">
		<?php
			if($resultConsulta!=false){?>
			<div class="row" id="result-search">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	                <div class="table-responsive">
	                    <table class="table table-striped">
						<?php 			
						foreach ($resultConsulta->result() as $lista) :
						?>
							<tr>
			                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de janeiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>
								
			                    <td>
			                    	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
			                    	<span class="glyphicon glyphicon-remove"></span>
			                    </td>
			                   </a>
						 	</tr>
						<?php
						endforeach;

				?>
						</table>
	                </div>
	            </div>
			</div>
			
			<?php
			}else{?>
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
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==01){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>	
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de janeiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>
											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
					        
										
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
							}
						if($listaMeses->mes==2){
							?>
							<fieldset>
								<legend>Fevereiro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==02){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de fevereiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>							
							<?php	}								
								}
							endforeach;


							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==3){
							?>
							<fieldset>
								<legend>Março <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==03){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de março de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
	                                        <td>
	                                        	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
	                                        	<span class="glyphicon glyphicon-remove"></span>
	                                        </td>
	                                       </a>
									 	</tr>
							<?php
									}									
								}
							endforeach;

							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==4){
							?>
							<fieldset>
								<legend>Abril <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==04){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>	
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de abri de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}									
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==5){	
							?>
							<fieldset>
								<legend>Maio <?php echo $listaMeses->ano; ?> </legend>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				                        <div class="table-responsive">
				                            <table class="table table-striped">
				                                
							<?php				
							foreach ($consulta->result() as $lista) :									
								if(date('m',strtotime($lista->data_gerado))==05){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de maio de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>
											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
												 
									<?php										
									}
								}
								endforeach;
									?>
											</table>
				                        </div>
				                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==6){
							?>
							<fieldset>
								<legend>Junho <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==06){
									if(date('Y',strtotime($lista->data_gerado))==2014){
								?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de junho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==7){
							?>
							<fieldset>
								<legend>Julho <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==07){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de julho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==8){
							?>
							<fieldset>
								<legend>Agosto <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==08){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de agosto de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==9){	
							?>
							<fieldset>
								<legend>Setembro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php				
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==09){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de setembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}								
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==10){	
							?>
							<fieldset>
								<legend>Outubro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==10){
									if(date('Y',strtotime($lista->data_gerado))==2014){
								?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de outubro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
								<?php
									}
								}
							endforeach;
						}
						if($listaMeses->mes==11){	
							?>
							<fieldset>
									<legend>Novembro <?php echo $listaMeses->ano; ?> </legend>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				                        <div class="table-responsive">
				                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
									if(date('m',strtotime($lista->data_gerado))==11){
										if(date('Y',strtotime($lista->data_gerado))==2014){
								?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de novembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
								<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==12){	
							?>
							<fieldset>
								<legend>Dezembro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php							
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==12){
									if(date('Y',strtotime($lista->data_gerado))==2014){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de dezembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
					}
					elseif($listaMeses->ano==$i){
						if($listaMeses->mes==1){	
							?>
							<fieldset>
								<legend>Janeiro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==01){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de janeiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
							}
						if($listaMeses->mes==2){
							?>
							<fieldset>
								<legend>Fevereiro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==02){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de fevereiro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php	
									}								
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==3){
							?>
							<fieldset>
								<legend>Março <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==03){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de março de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php	
									}								
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==4){
							?>
							<fieldset>
								<legend>Abril <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :								
								if(date('m',strtotime($lista->data_gerado))==04){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
							
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de abri de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}									
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==5){	
							?>
							<fieldset>
								<legend>Maio <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php				
							foreach ($consulta->result() as $lista) :									
								if(date('m',strtotime($lista->data_gerado))==05){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de maio de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
									<?php
									}										
								}
								endforeach;
										?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==6){
							?>
							<fieldset>
								<legend>Junho <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==06){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
								?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de junho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
								<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==7){
							?>
							<fieldset>
								<legend>Julho <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==07){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
										<tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de julho de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==8){
							?>
							<fieldset>
								<legend>Agosto <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==08){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de agosto de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==9){	
							?>
							<fieldset>
								<legend>Setembro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php				
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==09){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
										<tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de setembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}								
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==10){	
							?>
							<fieldset>
								<legend>Outubro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==10){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
								?>
									
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de outubro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
								<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==11){	
							?>
							<fieldset>
									<legend>Novembro <?php echo $listaMeses->ano; ?> </legend>
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				                        <div class="table-responsive">
				                            <table class="table table-striped">
							<?php
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==11){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
								?>
									tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de novembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
								<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						}
						if($listaMeses->mes==12){	
							?>
							<fieldset>
								<legend>Dezembro <?php echo $listaMeses->ano; ?> </legend>
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			                        <div class="table-responsive">
			                            <table class="table table-striped">
							<?php							
							foreach ($consulta->result() as $lista) :
								if(date('m',strtotime($lista->data_gerado))==12){
									if(date('Y',strtotime($lista->data_gerado))==$listaMeses->ano){
							?>
								
		                                <tr>
		                                	<td>Boletim Geral nº <?php echo $lista->codigo?>, de <?php echo date('d',strtotime($lista->data_gerado))." de dezembro de ".date('Y',strtotime($lista->data_gerado))?>. Postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a></td>											
                                            <td>
                                            	<a title="Excluir boletim" type="button" data-toggle="modal" data-target="#myModal-excluir-boletim" class="btn-xs btn-danger" onclick="confirmarExcluirBoletim('<?php echo base_url('index.php/publico/publico/excluir/').'/'.$lista->id;?>')" >
                                            	<span class="glyphicon glyphicon-remove"></span>
                                            </td>
                                           </a>
									 	</tr>
							<?php
									}
								}
							endforeach;
							?>
										</table>
			                        </div>
			                    </div>
							</fieldset>
							<?php
						};
					}
				$i++;
				endforeach;				
				?>
			</ul>
			<?php
			}?>

	</div>
</div>