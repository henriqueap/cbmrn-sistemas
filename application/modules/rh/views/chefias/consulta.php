
<div class="container">
  <div class="row">
  	<div class="col-lg-12 col-md-12 col-xs-12">
      <h1>Consulta de Chefias no Organograma</h1>
      <hr />
      <form action="#" method="post" class="form-horizontal" role="form">
        <input type="hidden" name="chefe_militares_id_hidden" id="chefe_militares_id_hidden" value="" />
        
        <div class="form-group">
          <label for="matricula" class="col-sm-2 control-label">Matrícula</label>
          <div class="col-sm-12 col-md-2 col-lg-2 col-xs-12">
            <input type="text" rel="matricula" class="form-control input-sm" id="search-militar-matricula" name="matricula" placeholder="Matrícula" required />
            <input type="hidden" class="form-control input-xs" id="chefe_militares_id" name="chefe_militares_id" />                
          </div>
          <div class="col-sm-6">
            <label class="control-label" id="nome_militar"></label>
          </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-primary btn-xs" id="bt-buscar-chefias">Buscar</button>
          </div>
        </div>
      </form>
      <hr />
      <div id="result-search">
          <!--Imprime o resultado da busca -->
      </div>
    </div>
  </div> <!-- .row -->
</div> <!-- /.container -->