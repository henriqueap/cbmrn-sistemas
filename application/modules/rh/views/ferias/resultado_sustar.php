<div class="panel panel-default">
  <div class="panel-heading">
    <h4>Informações importantes</h4>
  </div>
  <?php if (isset($turma_ferias_id)) : ?>
  <?php
    # Pegar data atual.
    $data_atual = date('Y-m-d');
    # Pegar data de fim.
    $data_fim = date('Y-m-d', strtotime("+30 days", strtotime($data_inicio))); 
    # Pegar quantidade de dias final.
    $dias_data_final = substr($data_fim, -2);
    $dias_restantes = abs(($dias_data_final - $data_atual));
    
    # Verificação da data atual se está no mesmo mês e ano das férias que serão sustadas.
    $ano_data_inicio = date('Y', strtotime($data_inicio));
    $mes_atual = date('m', strtotime($data_inicio));
    
    if (date('Y') == $ano_data_inicio): 
  ?>

  <?php if(calc_date($data_atual, $data_fim) < 0): ?>
    <div class="panel-body">
      <div class="group">
        <label>Período de férias não está hábilitado para alterações.</label>
      </div>
    </div>
  <?php else: # Else ainda referente a condição do valor abs de dias restantes da turma. ?>
  <div class="panel-body">
    <?php echo form_open('rh/ferias/salvar_sustar_ferias'); ?>
      <input type="hidden" name="data_fim" value="<?php echo calc_date($data_atual, $data_fim); ?>" />
      <input type="hidden" name="militares_ferias_id" value="<?php echo $militares_ferias_id; ?>" />

      <div class="group">
        <label>Nome do Militar: <?php echo (isset($nome)) ? $nome : ""; ?></label>
      </div>

      <div class="group">
      	<label>Matricula: <?php echo (isset($matricula)) ? $matricula : ""; ?></label>
      </div>

      <div class="group">
      	<label>Turma Férias: <?php echo (isset($numero)) ? $numero : ""; ?> ° Turma</label>
      </div>

      <div class="group">
      	<label>Data início: <?php echo date('d/m/Y', strtotime($data_inicio)); ?></label>
      </div>

      <div class="group">
      	<label>Data prevista de volta: <?php echo date('d/m/Y', strtotime("+30 days", strtotime($data_inicio))); ?></label>
      </div>

      <div class="group">
        <label>Dias Restantes: <?php echo abs(calc_date($data_atual, $data_fim)); # Calc_date() é um função de uma biblioteca para o CodeIgniter. ?></label>
      </div>
      
      <div class="group">
        <label>Deseja sustar férias? <?php echo ($militares_ferias_id) ? "<button type='submit' class='btn btn-primary btn-xs'>Sim</button>" : "Militar não está em período de férias."; ?></label>
      </div>
    <?php echo form_close(); ?> <!-- Fim formulário. -->
    
    <?php endif; # Fim da condição referente ao número de dias restantes. ?>

    <?php else: # Else ainda da condição referente ao ano atual. ?>
      <div class="panel-body">
        <div class="group">
          <label>Período de férias não está hábilitado para alterações.</label>
        </div>
      </div>
    <?php endif; # Verificação do ano atual. ?>
  </div><!--/.panel-body-->
  <?php else: # Else.?>
  <div class="panel-body">
    <div class="group">
      <label>Período de férias do militar não existe.</label>
    </div>
  </div>
  <?php endif; # Verificação se turma de férias existe. ?>
</div>