<div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <h1>Consulta de Militares</h1>
        <hr />
        <form action="#" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label for="" class="col-sm-2 input-sm control-label">Nome</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control input-sm" id="nome" name="nome" placeholder="Nome do militar">
                </div>
            </div><!--/.form-group-->

            <div class="form-group">
                <label for="matricula" class="col-sm-2 input-sm control-label">Matricula</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control input-sm" rel="matricula" id="matricula" name="matricula" placeholder="Matrícula">
                    <div id="nome_militar"></div>
                </div>
            </div><!--/.form-group-->

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary btn-xs" id="bt-buscar-militar">Buscar</button>
                </div>
            </div><!--/.form-group-->
        </form><!--form-->
        <hr />
        <div id="result-search">
            <!-- Resultado de consulta dos militares -->
        </div>
    </div>
</div><!--/.container-->