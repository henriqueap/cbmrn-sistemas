<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h1>Ordem de Serviço</h1></div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php echo form_open('clog/os/concluirOS', array('role'=>'form', 'class'=>'form-horizontal')); ?>
						<div class="form-group">
							<label for="solicitante" class="col-sm-2 control-label">Solicitante</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="solicitante" class="form-control" id="solicitante" value="<?php echo $os->solicitante; ?>" disabled/>
								<input type="hidden" name="os_id" class="form-control" id="os_id" value="<?php echo $os->id; ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="solicitacao" class="col-sm-2 control-label">Solicitação</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<textarea class="form-control" name="descricao" id="descricao" disabled><?php echo $os->descricao; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="data_solicitacao" class="col-sm-2 control-label">Data da Solicitação</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" name="data_solicitacao" rel="data" class="form-control" id="data_solicitacao" value="<?php echo implode('/',array_reverse(explode('-',$os->data_solicitacao))); ?>" disabled/>
							</div>
						</div>
						<div class="form-group">
							<label for="observacao" class="col-sm-2 control-label">Observação</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<?php 
								if ($status == "Serviço cancelado" || $status == "Serviço concluído")	{ ?>
									<textarea class="form-control" name="observacao" id="observacao" placeholder="Observação" disabled><?php if (! is_null($os->observacao)) echo $os->observacao; ?></textarea>
									<?php
								}
								else { ?>
									<textarea class="form-control" name="observacao" id="observacao" placeholder="Observação" required><?php if (! is_null($os->observacao)) echo $os->observacao; ?></textarea>
									<?php
								} ?>
							</div>
						</div>
						<div class="form-group">
							<label for="status" class="col-sm-2 control-label">Status</label>
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12">
								<input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" disabled/>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
								<?php 
								if ($status != "Serviço cancelado" && $status != "Serviço concluído")	{ ?>
									<button type="submit" class="btn btn-default">Concluir</button>
									<?php
								} ?>
								<button type="button" class="btn btn-default" onclick="location.href='<?php echo BASE_URL('clog/os/listar'); ?>';">Listar todas</button>
								<!--<input type="button" class="btn btn-default" value="Home" onclick="<?php #redirect('clog/os/index'); ?>"/>-->
							</div>
						</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->