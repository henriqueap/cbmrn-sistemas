<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Cadastro de Ordem de Serviço</h1></div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo form_open('clog/os/novaOS', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<div class="form-group">
							<label for="os_idmilitar" class="col-sm-2 control-label">Solicitante</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<select name="idsolicitante" class="form-control" id="idsolicitante">
									<option value="0">Selecione o Militar</option>
									<?php foreach($militares as $rowM): ?>
									<option value="<?php echo $rowM->idmilitar; ?>"><?php echo $rowM->militar; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="data" class="col-sm-2 control-label">Data da Solicitação</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="data_solicitacao" rel="data" class="form-control" id="data_solicitacao" value="<?php echo ""; ?>" placeholder="Data da Solicitação" required/>
							</div>
						</div>
						<div class="form-group">
							<label for="solicitacao" class="col-sm-2 control-label">Solicitação</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<textarea class="form-control" name="descricao" id="descricao" placeholder="Solicitação" required><?php echo ""; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<button type="submit" class="btn btn-default">Salvar</button>
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->