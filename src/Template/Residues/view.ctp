<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TechnicalReport $technicalReport
 */
   use Cake\Routing\Router;
?> 

<div class="residues form large-9 medium-8 columns content">
    <?= $this->Form->create($residue) ?>
    <fieldset>
        <legend><?= __('Consultar acta de desecho') ?></legend>
        <br> 
        <!-- Sección de entrada de datos --> 
        <div class="form-control sameLine" >    
            <div class='row'>
            <?php
            /*<label>Autorización Número: VRA-</label>
                <label><?php echo h($residue->residues_id); ?></label>*/
            echo '<label>Autorización Número: VRA-'.h($residue->residues_id).'</label>';
            ?>
        </div>
        <div class='row'>
            <label>Fecha:</label>
                <?php
                    $tmpDate= $residue->date->format('d-m-y');
                    echo $this->Form->imput('date', ['class'=>'form-control', 'value'=>$tmpDate, 'disabled']); 
                ?>
            </div>
        </div><br>

        <div class='row'>
            <label class='align'>Unidad Custodio:</label>
            <?php 
                echo $this->Form->imput('Unidad', ['class'=>'form-control col-sm-4', 'value'=>$Unidad, 'disabled']);
            ?>
        </div><br>

        <!-- Sección de cuadro para entrada de datos -->
        <label>En presencia de:</label>
        <table>
            <tr>
                <td><br>
                    <div class="row">
                            <label class='label-t'>Nombre:  </label>
                                <?php 
                                    echo $this->Form->imput('name1', ['class'=>'form-control col-sm-6', 'disabled']);
                                ?>
                    </div><br>
                    <div class="row">
                            <label class='label-t'>Cédula:  </label>
                                <?php 
                                    echo $this->Form->imput('identification1', ['class'=>'form-control col-sm-6','disabled']);
                                ?>
                    </div><br>
                </td>
            
                <td><br>
                    <div class="row">
                            <label class='label-t'>Nombre:</label>
                                <?php 
                                    echo $this->Form->imput('name2', ['class'=>'form-control col-sm-6', 'disabled']);
                                ?>
                    </div><br>
                    <div class="row">
                            <label class='label-t'>Cédula:  </label>
                                <?php 
                                    echo $this->Form->imput('identification2', ['class'=>'form-control col-sm-6', 'disabled']);
                                ?> 
                    </div><br>
                </td>
            </tr>
        </table><br>

        <div>
            <p>
                Se procede a levantar el Acta de Desecho de bienes muebles por haber cumplido su periodo de vida útil, de acuerdo con el Informe Técnico adjunto y la respectiva autorización por parte de la Vicerrectoría de Administración, de conformidad con el Reglamento para la Administración y Control de los Bienes Institucionales de la Universidad de Costa Rica.
            </p>
        </div><br>

    </fieldset>
    </div>

    <!-- Sección para grid con activos asignado al acta -->
    <div class="related">
        <legend><?= __('Listado de Bienes') ?></legend>

        <table cellpadding="0" cellspacing="0">
            <tr>
                <th class="transfer-h" scope="col"><?= __('Placa') ?></th>
                <th class="transfer-h" scope="col"><?= __('Recomendacion') ?></th>
                <th class="transfer-h" scope="col"><?= __('Informe Técnico') ?></th>
                
            </tr>
    
            <?php

            $size = count($resultRec);
            for ($i=0; $i< $size;$i++){
                echo '<tr>';
                    echo '<td>' .h($result[$i]->plaque). '</td>';

                    switch ($resultRec[$i]->recommendation) {
                        case 'C':
                            echo '<td>' .'Reubicar'. '</td>';
                        break;
                        case 'R':
                            echo '<td>' .'Reparar'. '</td>'; 
                         break;
                        case 'D':
                            echo '<td>' .'Desechar'. '</td>'; 
                        break;
                        case 'U':   
                            echo '<td>' .'Usar Piezas'. '</td>'; 
                        break;
                        case 'O':
                            echo '<td>' .'Otros'. '</td>'; 
                        break;
                    } 
                    echo '<td>' .h($resultRec[$i]->technical_report_id). '</td>';      
                echo '</tr>';
            }
            
            ?>
        </table>
    </div><br>

    <div>
        <p align="center">
            (Art. 26 del Reglamento para la Administración y Control de los Bienes Institucionales de la Universidad de Costa Rica)
        </p>
    </div><br>

    <!-- Sección para el estilo de la pantalla -->
    <style>
    .btn-primary {
      color: #FFF;
      background-color: #0099FF;
      border-color: #0099FF;
      float: right;
      margin-left: 10px;
    }

    label {
          text-align:left;
          margin-right: 10px;
          
    }

    label[class=label-t]{
        margin-left: 20px;
        width: 70px;
    }

    label[class=align]{
        margin-left: 14px;
    }

    input[name=date]{
          width:100px;
          margin-left: 10px;
        }

    table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }

    td {

        border: 1px solid #000000;
        border-bottom: 1px solid #000000;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    th[class=transfer-h] {
        border-bottom: 1px solid #000000;
        text-align: center;
        color:black;
        padding: 8px;
    }

    .sameLine{
    display: flex; 
    justify-content: space-between; 
    border-color: transparent;
    }

    </style> 

    <div >
      <?php echo $this->Form->input('file_solicitud',['type' => 'file','label' => 'Subir Acta de Desechos', 'class' => 'form-control-file']); ?>
    </div>

    </style>   
    </div> 
    <div>
    <!-- Sección de botones -->

     <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>

     <?php if($residue->file_name == null) : ?> 

        <?= $this->Html->link(__('Modificar'), ['action' => 'edit', $residue->residues_id], ['class' => 'btn btn-primary']) ?> 
    
    <?php endif; ?> 

    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $residue->residues_id], ['hidden'=> 'true','class' => 'btn btn-primary', 'confirm' => __
        ('¿Está seguro que deseaaaaaaa eliminar el desecho #'.$residue->residues_id.' ?', $residue->residues_id)]) ?>
    
    <?php if(($residue->descargado == null) && ($residue->file_name == null )) : ?> 

        <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $residue->residues_id], ['class' => 'btn btn-primary', 'confirm' => __
        ('¿Está seguro que desea eliminar el desecho #'.$residue->residues_id.' ?', $residue->residues_id)]) ?>

    <?php endif; ?> 
    <?= $this->Form->postLink(__('Descargar Acta'), ['action' => 'download', $residue->residues_id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea descargar el archivo?', $residue->residues_id)]) ?>
    
    </div>
<br>

