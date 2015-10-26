
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
			<h1>Consulta Empresa</h1>
			<hr>
		</div> <!-- .Cols -->
		
		<div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Consulta Empresas</h3>
				</div>

				<div class="panel-body">
					<form action="#" method="post" class="form-horizontal" role="form"> 
						<div class="form-group">
              <label for="nome_fantasia" class="col-sm-2 control-label">Nome Fantasia</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" placeholder="Nome Fantasia"/>
              </div>
            </div>

            <div class="form-group">
              <label for="razao_social" class="col-sm-2 control-label">Razão Social</label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="razao_social" name="razao_social" placeholder="Razão Social"/>
              </div> 
            </div>

            <div class="form-group">
              <label for="cnpj" class="col-sm-2 control-label">CNPJ</label>
              <div class="col-sm-7 ">
                <input type="text" class="form-control" rel="cnpj" id="cnpj" name="cnpj" placeholder="CNPJ"/>
              </div> 
            </div>
						
						<div class="form-group">
			        <div class="col-sm-12 col-md-3 col-lg-3 col-xs-12 col-sm-offset-2">
			        	<button type="button" class="btn btn-default btn-xs" id="consulta-empresa">Consulta</button>
			        </div>
		        </div>
					</form>
				</div>
			</div> <!-- .panel -->
		</div> <!-- .Cols -->
			<hr>
    <!--Imprime o resultado da busca -->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="result-search">
    	<!-- Resultado da consulta -->
		</div> <!-- .Cols -->
	</div>
</div>
