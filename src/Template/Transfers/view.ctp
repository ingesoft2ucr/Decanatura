<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transfer $transfer
 */
?>
<style>
    table {

    border-collapse: collapse;
    width: 100%;
    }
    td{
        border: 1px solid #000000;
        border-bottom: 1px solid #000000;
        padding: 8px;
    }
    th[class=transfer-h]{
        border-bottom: 1px solid #000000;
        text-align: center;
        color:black;
        padding: 8px;
    }
    label[class=label-t]{
        margin-left: 20px;
        width: 150px;
    }
    label {
        text-align:left;
        margin-right: 10px;
          
    }
    .btn-primary {
      color: #FFF;
      background-color: #0099FF;
      border-color: #0099FF;
      float: right;
      margin-left:10px;
    }

    .sameLine{
    display: flex; 
    justify-content: space-between; 
    border-color: transparent;
    }

</style>
<div class="transfers form large-9 medium-8 columns content">
  <fieldset>
    <legend><?=__(' Consultar traslado')?></legend>
    <br>
        <div class= 'form-control sameLine' style="border-color: transparent;">

            <div class =" row">                
                    <label  for="transfer_id">Nº traslado:</label>
                    <?php echo '<input type="text" id="transfer_id" class="form-control col-sm-4 col-md-4 col-lg-4" readonly="readonly" value="' . htmlspecialchars($transfer->transfers_id). '">'; ?>
                   
            </div>

            <div class="row" >
                <label for="transfer_date">Fecha:</label>
                <?php
                // para dar formato a la fecha
                $tmpDate= $transfer->date->format('d-m-Y');
                ?>
                <?php echo '<input type="text" id="transfer_date" style="margin-left:2px;" class="form-control  col-xs-2 col-sm-6    col-md-6 col-lg-9" readonly="readonly" value="' . htmlspecialchars($tmpDate) . '">'; ?>

            </div> 

        </div>
    <br>
    <table>
        <!-- Tabla para rellenar los datos de las unidades académicas -->
        <tr>
            <th class="transfer-h"><h5>Unidad que entrega<h5></th>
            <th class="transfer-h"><h5>Unidad que recibe<h5></th>
        </tr>
        <tr>
            <!-- Fila para la Unidad que entrega -->
            <td>
                <div class="row" >
                    <label class="label-t">Unidad académica: </label>
                   
                    <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($Unidad) . '">'; ?>
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Funcionario: </label>
                    <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($transfer->functionary) . '">'; ?>
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Cédula:</label>
                    <?php echo '<input type="text" class="form-control col-sm-4" readonly="readonly" value="' . htmlspecialchars($transfer->identification) . '">'; ?>
                </div>
            </td>


            <!-- Fila para la Unidad que recibe -->
            <td>
                <div class="row">
                    
                        <label class="label-t">Unidad académica: </label>
                    
                        <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($transfer->Acade_Unit_recib). '">'; ?>
                    
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Funcionario: </label>
                    <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($transfer->functionary_recib). '">'; ?>
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Cédula:</label>
                    <?php echo '<input type="text" class="form-control col-sm-4" readonly="readonly" value="' . htmlspecialchars($transfer->identification_recib) . '">'; ?>
                </div>               
            </td>
            
        </tr>
    </table>
    <br>
    
    <div class="related">
        <legend><?= __('Activos trasladados') ?></legend>

        <table cellpadding="0" cellspacing="0">
            <tr>
                <th class="transfer-h" scope="col"><?= __('Placa') ?></th>

                <th class="transfer-h" scope="col"><?= __('Marca') ?></th>
                <th class="transfer-h" scope="col"><?= __('Modelo') ?></th>
                <th class="transfer-h" scope="col"><?= __('Serie') ?></th>
                <th class="transfer-h" scope="col"><?= __('Estado') ?></th>
                
            </tr>
            <?php foreach ($result as $asset): ?>
            <tr>
                <?php
                    //$a= (object)$asset->assets;
                ?>
                <td><?= h($asset->plaque) ?></td>
                <td><?= h($asset->brand) ?></td>
                <td><?= h($asset->model) ?></td>
                <td><?= h($asset->series) ?></td>
                <td><?= h($asset->state) ?></td>

            </tr>
            <?php endforeach; ?>
        </table>

    </div>
  </fieldset>
    <div >
      <?php echo $this->Form->input('file_solicitud',['type' => 'file','label' => 'Subir Acta de Traslados', 'class' => 'form-control-file']); ?>
    </div>

    <div>
    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>


    <?php if($transfer->file_name == null) : ?>

        <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $transfer->transfers_id], ['class' => 'btn btn-primary']) ?>
    
    <?php endif; ?> 

    <?php if(($transfer->descargado == null) && ($transfer->file_name == null )) : ?> 

        <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $transfer->transfers_id], ['class' => 'btn btn-primary', 'confirm' => __('¿Está seguro que desea eliminar el traslado #'.$transfer->transfers_id.' ?', $transfer->transfers_id)]) ?>

    <?php endif; ?> 

      <?= $this->Form->postLink(__('Descargar Acta'), ['action' => 'download', $transfer->transfers_id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea descargar el archivo?', $transfer->transfers_id)]) ?>

  </div>
      <br><br> 

</div>
