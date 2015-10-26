<div class="panel panel-success">
    <div class="panel-heading">            
         <h4>Viaturas Operantes</h4>                
     </div>
</div>
<div class="table-responsive">
    <table class="table">
    
        <tr >
           <th >Nº</th>
            <th >Placa</th>
            <th >Prefixo</th>
            <th >Marca</th>
            <th>Modelo</th>
            <th >Ano</th>
            <th >Óleo(Km)</th>
            <th >Revisão(Km)</th>
            <th>Setor</th>
        </tr>
         <?php $cont=1;
              foreach ($listar_relatorios->result() as $listar) :
              if ($listar->viaturasOperante==1){            
         ?>
        <tr>
            <td ><?php echo  $cont++; ?></td>
            <td ><?php echo $listar->placa; ?></td>
            <td ><?php echo $listar->prefixo; ?></td>
            <td><?php echo $listar->nomeMarca; ?></td>
            <td ><?php echo $listar->modelo; ?></td>
            <td ><?php echo  $listar->ano_fabricacao;  ?></td>
            <td ><?php echo  $listar->km_oleo  ?></td>
            <td ><?php echo  $listar->km_revisa;  ?></td>
            <td><?php echo $listar->sigla; ?></td>
        </tr>
        <?php } endforeach;
               ?> 
    </table>
</div> 
<div class="panel panel-danger">
    <div class="panel-heading">            
             <h4>Viaturas Inoperantes</h4>                
    </div>
</div>
<div class="table-responsive">
    <table class="table">
        <tr >
           <th >Nº</th>
            <th >Placa</th>
            <th >Prefixo</th>
            <th >Marca</th>
            <th>Modelo</th>
            <th >Ano</th>
            <th >Óleo(Km)</th>
            <th >Revisão(Km)</th>
            <th>Setor</th>
        </tr>
        <?php $cont=1;
              foreach ($listar_relatorios->result() as $listar) :
              if ($listar->viaturasOperante==0){            
         ?>
        <tr>
            <td ><?php echo  $cont++; ?></td>
            <td ><?php echo $listar->placa; ?></td>
            <td ><?php echo $listar->prefixo; ?></td>
            <td><?php echo $listar->nomeMarca; ?></td>
            <td ><?php echo $listar->modelo; ?></td>
            <td ><?php echo  $listar->ano_fabricacao;  ?></td>
            <td ><?php echo  $listar->km_oleo  ?></td>
            <td ><?php echo  $listar->km_revisa;  ?></td>
            <td><?php echo $listar->sigla; ?></td>
        </tr> 
        <?php } 			endforeach;
        
               ?> 
    </table>
</div> 