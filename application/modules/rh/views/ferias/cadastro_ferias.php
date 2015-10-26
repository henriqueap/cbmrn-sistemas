
<?php $resultado = $ferias->result(); ?>
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-xs-12">
            <h1><?= (!isset($data->id)) ? 'Militares em Férias' : 'Militares em Férias'; ?></h1>
            <hr />
            <?php echo form_open('rh/ferias/cadastro_ferias', array('role' => 'form', 'class' => 'form-horizontal')); ?>
            <input type="hidden" name="id" value="<?php echo set_value('id', isset($data->id) ? $data->id : ""); ?>" />
            <input type="hidden" name="" id="" value="" />

            <div class="form-group">
                <label for="exercicio-ferias" class="col-sm-2 control-label">Exercício</label>
                <div class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                	<select name="exercicio" class="form-control" id="exercicio-ferias">
                        <option>Exercício</option>
                		<?php foreach($resultado as $ferias): ?>
                		<option value="<?php echo $ferias->exercicio; ?>"><?php echo $ferias->exercicio; ?></option>
                		<?php endforeach; ?>
                	</select>
                </div>
            </div>

            <div class="form-group">
                <label for="numero" class="col-sm-2 control-label">N° Turma</label>
                <div id="turmas" class="col-sm-12 col-md-4 col-lg-4 col-xs-12">
                	<!-- Exibir o select com as turmas o respectivo exercício. -->
                </div>
            </div>

            <div class="form-group">
                <label for="matriculas" class="col-sm-2 control-label">Matrículas</label>
                <div class="col-sm-4">
                  <textarea name="matriculas" id="matriculas" class="form-control" rows="10" placeholder="Entre com a matricula dos militares separadas por vírgula." required></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-12 col-md-6 col-lg-6 col-xs-12 col-sm-offset-2">
                    <input type="submit" value="Salvar" class="btn btn-primary" />
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
