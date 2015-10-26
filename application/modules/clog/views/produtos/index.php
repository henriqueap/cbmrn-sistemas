<?php #echo "<pre>"; var_dump($data); var_dump($produtos); var_dump($marcas); echo "</pre>"; ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1><?php echo (!isset($data->id)) ? "Cadastro de Produtos" : "Editar Produtos"; ?></h1>
		</div>
			<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Formulário para cadastro de produtos</h3>
				</div>
				<div class="panel-body">
					<?php echo form_open_multipart('clog/produtos/salvar', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<input type="hidden" name="id" id="id" value="<?php echo (isset($data->id)) ? $data->id : ""; ?>">

						<div class="form-group">
							<label for="modelo" class="col-sm-2 control-label">Modelo do produto</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="modelo" class="form-control" id="modelo" value="<?php echo (isset($data->id)) ? $data->modelo : ""; ?>" placeholder="Modelo do produto" required/>
							</div>
						</div>

						<div class="form-group">
							<label for="quantidade_minima" class="col-sm-2 control-label">Quantidade mínima</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="quantidade_minima" class="form-control" id="quantidade_minima" value="<?php echo (isset($data->id)) ? $data->quantidade_minima : ""; ?>" placeholder="Quantidade minima" required/>
							</div>
						</div>

						<div class="form-group">
							<label for="tipo_produto" class="col-sm-2 control-label">Tipo Produto</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="tipo_produto" id="tipo_produto" class="form-control">
									<option value="1" <?php echo (isset($data->id) && $data->consumo == 1) ? "selected" : ""; ?>>Permanente</option>
									<option value="0" <?php echo ((isset($data->id) && $data->consumo == 0) || (! isset($data->id))) ? "selected" : ""; ?>>Consumo</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="grupo_produtos_id" class="col-sm-2 control-label">Grupo Produtos</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="grupo_produtos_id" id="grupo_produtos_id" class="form-control">
									<option>Grupo Produtos</option>
									<?php foreach($produtos as $row): 
										if (isset($data->id) && $row->id == $data->grupo_produtos_id) { ?>
											<option value="<?php echo $row->id; ?>" selected><?php echo $row->nome; ?></option>
											<?php 
										}
										else { ?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->nome; ?></option>
											<?php 
										}
									endforeach; ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="marcas_produtos_id" class="col-sm-2 control-label">Marcas Produtos</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="marcas_produtos_id" id="marcas_produtos_id" class="form-control" required>
									<option>Marcas Produtos</option>
									<?php foreach($marcas as $row): 
										if (isset($data->id) && $row->id == $data->marcas_produtos_id) { ?>
											<option value="<?php echo $row->id; ?>" selected><?php echo $row->marca; ?></option>
											<?php 
										}
										else { ?>
											<option value="<?php echo $row->id; ?>"><?php echo $row->marca; ?></option>
											<?php 
										} 
									endforeach; ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="imagem_ilustrativa" class="col-sm-2 control-label">Imagem ilustrativa</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="file" placeholder="Imagem ilustrativa" name="imagem_ilustrativa" class="form-control" id="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Salvar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div> <!--Panel-->
		</div>
	</div> <!--.row-->
</div> <!--.container-->
