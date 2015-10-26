<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Consultar Boletins</h1>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
	</div><!--.row-->
	<hr>
	<div class="panel-body">
		<div id="semFiltro">		
			<?php echo form_open('publico/publico/resultadoConsulta', array('id' => 'template-add-form', 'class' => 'form-horizontal')); ?>
			<div class="form-group">
				<div class="row">
			      	<label for="dataIni" class="col-sm-3  control-label">Período:</label>
			      	<div class=" col-sm-2 ">
			        	<input name="dataInicial" class="form-control" type="date" id="dataInicial" value="<?php echo date('Y-m-d')?>" />
			      	</div>
			      	<div class=" col-sm-1">
			        	<label for="dataIni" class="col-sm-1 control-label ">e</label>
			      	</div>
			      	<div class=" col-sm-2 ">
			        	<input name="dataFinal" class="form-control" type="date" id="dataFinal"  value="<?php echo date('Y-m-d')?>" />
			      	</div>
				</br></br></br>
		       	</div>
		       	<div align="right" class="col-lg-8 col-md-10 col-sm-8 col-xs-8"> 
		               <button type="submit" class=" btn btn-sm btn-danger" title="Consultar" id="btn-buscar-boletim">Consultar</button>
		        </div>
		    </div>		                
			
			<?php echo form_close ();?>	
		</div>
		<?php 
		if($resultConsulta!=false){?>
		<div class="row" id="result-search">
			<?php 			
			foreach ($resultConsulta->result() as $lista) :
			?>
				<ul>											
					<li class="list-button-item link-container">
						<a  target="_blank" href="../../../../<?php echo htmlentities($diretory.$lista->nome_boletim, ENT_QUOTES, "UTF-8")?>">Boletim Geral nº <?php echo $lista->codigo?>, gerado no dia <?php echo date('d/m/Y',strtotime($lista->data_gerado))?>, e postado <?php echo date('d/m/Y',strtotime($lista->data_publicado))?>.</a>
					</li>
				</ul>
			<?php
			endforeach;
			?>
		</div>
		<?php } ?>
	</div>
</div>