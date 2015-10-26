<div class="container">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <h1>Consulta Férias de Militares</h1>
        <hr />
        <form action="#" method="post" class="form-horizontal" role="form">
            <input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />

            <div class="form-group">
              <label for="nome" class="col-sm-2 input-sm control-label">Exercicio</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control input-sm" id="exercicio" name="exercicio" value="<?= date('Y'); ?>" placeholder="Exercicio">
                </div>
            </div>

            <div class="form-group">
                <label for="nome" class="col-sm-2 input-sm control-label">Turma de Férias</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control input-sm" id="numero" name="numero" placeholder="Número da Turma">
                </div>
            </div>

            <div class="form-group">
                <label for="matricula" class="col-sm-2 input-sm control-label">Matricula</label>
                <div class="col-sm-2">
                    <input type="text" rel="matricula" class="form-control input-xs input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required="">
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 input-sm control-label">Período de Férias</label>
                <div class="col-sm-2">
                    <input type="date" name="" id="" class="form-control input-sm" />
                </div>              
                <div class="col-sm-2">
                    <input type="date" name="" id="" class="form-control input-sm" />
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-2 input-sm control-label">Pesquisar Férias</label>
                <div class="col-sm-2">
                    <input type="checkbox" name="" value=""> Já gozadas<br>
                    <input type="checkbox" name="" value=""> Ainda não gozadas
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-primary btn-xs" id="btn-consulta-militares-ferias">Buscar</button>
                </div>
            </div>
        </form>
        <hr />
        <div id="result-search">
        <!--Imprime o resultado da busca -->
        </div>
    </div>
</div>