<?php echo form_open('frotas/servicos_pendentes/cadastrarJustificativa',array('class'=>'form-horizontal','role'=>'form')); ?>
    <div class="modal-body">
        <input type="hidden" id="idServico "name="idServico" value="<?php echo $idServico ?>">
            <table>
            <tbody>
            <tr>
            <td>
            Justificativa
            </td>
            <td>
            <textarea name="txtJustificativa" style="width:300px;height:100px"></textarea>
            </td>
            </tr>
            </tbody>
            </table>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Não</button>
        <input id="modal-form-submit" type="submit" name="submit" class="btn btn-primary" href"#" value="Sim"/>
        </div>
<?php echo form_close ();?>
