<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h1>Gráfico de Ocorrências - Total</h1>
		</div>
		<hr>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<!--<canvas id="canvas" height="450" width="600"></canvas>-->
					<div id="canvas-holder">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<canvas id="canvas" height="450" width="600"></canvas>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<canvas id="chart-area" width="300" height="300"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- .row -->
</div> <!-- .container -->
<script type="text/javascript" charset="utf-8" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script type="text/javascript">
	function aleatorio(inferior,superior){ 
   numPossibilidades = superior - inferior 
   aleat = Math.random() * numPossibilidades 
   aleat = Math.floor(aleat) 
   return parseInt(inferior) + aleat 
	} 

	function dar_cor_aleatoria(){ 
   hexadecimal = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F") 
   cor_aleatoria = "#"; 
   for (i=0;i<6;i++){ 
      posarray = aleatorio(0,hexadecimal.length) 
      cor_aleatoria += hexadecimal[posarray] 
   } 
   return cor_aleatoria 
	}

	$(window).load(function() {
		var ocorrencias = new Array();
		var quantidades = new Array();
		var pieData = new Array();

		loadDataGraph = $.ajax({
			url: BASE_URL + 'index.php/ocorrencias/ocorrencias/dados_grafico',
			dataType: 'json'
		});
		loadDataGraph.done(function (result) {
			for (var i = result.ocorrencias.length - 1; i >= 0; i--) {
				ocorrencias.push(result.ocorrencias[i]['ocorrencia']);
				quantidades.push(result.ocorrencias[i]['quantidade']);
				pieData.push(
					{
						value: result.ocorrencias[i]['quantidade'],
						color: dar_cor_aleatoria(),
						highlight: dar_cor_aleatoria(),
						label: result.ocorrencias[i]['ocorrencia']
					}
				);
			};
			var ctx = document.getElementById("chart-area").getContext("2d");
			$("#chart-area").load(
				new Chart(ctx).Pie(pieData, {
					responsive : true
				})
			);
			var barChartData = {
				labels : ocorrencias,
				datasets : [
					{
						fillColor: "rgba(151,187,205,0.5)",
						strokeColor: "rgba(151,187,205,0.8)",
						highlightFill: "rgba(151,187,205,0.75)",
						highlightStroke: "rgba(151,187,205,1)",
						data : quantidades
					}
				]
			}
			var ctx = document.getElementById("canvas").getContext("2d");
			$("#canvas").load(
				new Chart(ctx).Bar(barChartData, {
					responsive : true
				})
			); 
		});
	});

</script>