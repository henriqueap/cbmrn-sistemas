<div class="container">
  <div class="col-lg-12 col-md-12 col-xs-12">
    <h1>Consulta de Turma de Férias</h1>
    <hr />
    <form action="#" method="post" class="form-horizontal" role="form">        
      <div class="form-group">
        <label for="nome" class="col-sm-2 input-sm control-label">Turma de Férias</label>
        <div class="col-sm-3">
          <input type="text" class="form-control input-sm" id="numero" name="numero" placeholder="Número da Turma">
        </div>
      </div>

      <div class="form-group">
          <label for="nome" class="col-sm-2 input-sm control-label">Exercicio</label>
          <div class="col-sm-3">
            <input type="text" class="form-control input-sm" id="exercicio" name="exercicio" value="<?= date('Y') - 1; ?>" placeholder="Exercicio">
          </div>
      </div>
      
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="button" class="btn btn-primary btn-xs" id="bt-buscar-turma">Buscar</button>
        </div>
      </div>
    </form>
    <hr />
    <div id="result-search">
      <!-- Imprime o resultado da busca -->
    </div>
  </div>
</div>