<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transfer $transfer
 */

use Cake\Routing\Router;
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>

<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js" type="text/javascript"></script>

<style>
    

    .btn-primary{
      color: #FFF;
      background-color: #0099FF;
      border-color: #0099FF;
      float: right;
      margin-left:10px;
      text-transform: capitalize;
    }
    .btn-primary:hover{
        color: #fff;
        background-color: #0099FF;

    }
    .btn[type="submit"]:not{
        text-transform: capitalize;
    }
    .btn[type="submit"]:hover{
        text-transform: capitalize;
        color: #fff;
        background-color: #0099FF;
    }

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
    label[class=label-h]{
        margin-right: 10px;
    }
    .sameLine{
    display: flex; 
    justify-content: space-between; 
    border-color: transparent;
    }
       
</style>


<div class="transfers form large-9 medium-8 columns content">
  <fieldset>
    <?= $this->Form->create($transfer) ?>
    <legend><?= __('Modificar traslado') ?></legend>
    <br>
        <div class= 'form-control sameLine' style="border-color: transparent;">
            <div class ="row">                
                <label class="label-h">Nº traslado:</label>
                <?php echo '<input type="text" class="form-control col-md-4 col-lg-4" readonly="readonly" value="' . htmlspecialchars($transfer->transfers_id). '">'; ?> 
            </div>

            <div  class="row" >
                <label class="label-h">Fecha:</label>
                <?php
                // para dar formato a la fecha
                $tmpDate= $transfer->date->format('d-m-Y');
                ?>  
                <?php echo '<input type="text" class="form-control col-xs-2 col-sm-2 col-md-6 col-lg-9" readonly="readonly" value="' . htmlspecialchars($tmpDate) . '">'; ?>
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
                   
                    <?php echo '<input type="text" readonly="readonly" class="form-control col-sm-6"  value="' . htmlspecialchars($Unidad) . '">'; ?>
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Funcionario: </label>
                    <?php 
                    echo $this->Form->select('functionary',
                      $users,
                      ['empty' => '(Escoja un usuario)','class'=>'form-control', 'style'=>'width:220px;']
                    );
                    ?>
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Cédula:</label>
                    <?php echo '<input type="text" name="identification" class="form-control col-sm-4"  value="' . htmlspecialchars($transfer->identification) . '">'; ?>
                </div>
            </td>


            <!-- Fila para la Unidad que recibe -->
            <td>
                <div class="row">
                    
                        <label class="label-t">Unidad académica: </label>
                    
                        <?php echo '<input type="text" name="Acade_Unit_recib" class="form-control col-sm-6"  value="' . htmlspecialchars($transfer->Acade_Unit_recib). '">'; ?>
                    
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Funcionario: </label>
                    <?php echo '<input type="text" name="functionary_recib" class="form-control col-sm-6"  value="' . htmlspecialchars($transfer->functionary_recib). '">'; ?>
                </div>
                <br>
                <div class="row">
                    <label class="label-t">Cédula:</label>
                    <?php echo '<input type="text" name="identification_recib" class="form-control col-sm-4"  value="' . htmlspecialchars($transfer->identification_recib) . '">'; ?>
                </div>               
            </td>
            
        </tr>
    </table>
    <br>


    <!-- AQUI ESTA LO IMPORTANTE. RECUERDEN COPIAR LOS SCRIPTS -->
    <div class="related">
        <legend><?= __('Activos a trasladar') ?></legend>


        <!-- tabla que contiene  datos básicos de activos-->
        <table id='assets-transfers-grid' cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th class="transfer-h"><?= __('Placa') ?></th>
                    <th class="transfer-h"><?= __('Marca') ?></th>
                    <th class="transfer-h"><?= __('Modelo') ?></th>
                    <th class="transfer-h"><?= __('Serie') ?></th>
                    <th class="transfer-h"><?= __('Estado') ?></th>
                    <th class="transfer-h"><?= __('Seleccionados') ?></th>
                </tr>
            <thead>
            <tbody> 
                <?php foreach ($asset as $a): ?>
                <tr>
                    <td><?= h($a->plaque) ?></td>
                    <td><?= h($a->brand) ?></td>
                    <td><?= h($a->model) ?></td>
                    <td><?= h($a->series) ?></td>
                    <td><?= h($a->state) ?></td>
                    <?php
                        // If que verifica si el checkbox debe ir activado o no
                        
                        if(in_array($a->plaque, array_column($result, 'plaque'),true) )
                            {
                                echo '<td data-order="1">';
                                echo $this->Form->checkbox('assets_id',
                                ['value'=>htmlspecialchars($a->plaque),'checked', "class"=>"chk" ]
                                );
                                echo '</td>';
                            }
                        else
                            {
                                echo '<td data-order="0">';
                                echo $this->Form->checkbox('assets_id',
                                ['value'=>htmlspecialchars($a->plaque),"class"=>"chk"]
                                );
                                echo '</td >';
                            }
                    ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div><br>

    <!-- input donde coloco la lista de placas checkeadas -->
    <input type="hidden" name="checkList" id="checkList">
    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary','id'=>'aceptar','style'=>'text-transform: capitalize;']) ?>
      <?= $this->Form->postLink(__('Generar Pdf'), ['action' => 'download', $transfer->transfers_id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea descargar el archivo?', $transfer->transfers_id)]) ?>
    <?= $this->Form->end() ?>

  </fieldset>
</div><br>



<script type="text/javascript">
    $(document).ready(function() 
    {
        $('#assets-transfers-grid').DataTable( {
              dom: 'Bfrtip',
                    buttons: [],
                   "iDisplayLength": 10,
                   "paging": true,
                   "pageLength": 10,
                    "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "decimal": ",",
                    "thousands": ".",
                    "sSelect": "1 fila seleccionada",
                    "select": {
                        rows: {
                            _: "Ha seleccionado %d filas",
                            0: "Dele click a una fila para seleccionarla",
                            1: "1 fila seleccionada"
                        }
                    },
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "order": [[ 5, "desc" ]]
        } );
        // Listen to change event from checkbox to trigger re-sorting
        $('#assets-transfers-grid input[type="checkbox"]').on('change', function() {
        // Update data-sort on closest <td>
        $(this).closest('td').attr('data-order', this.checked ? 1 : 0);
    
        // Store row reference so we can reset its data
        var $tr = $(this).closest('tr');
    
        // Force resorting
        equipmentTable
        .row($tr)
        .invalidate()
        .order([ 5, 'desc' ])
        .draw();
        } );
} );

    $("document").ready(
    function() {
      $('#aceptar').click( function()
      {
        var check = getValueUsingClass();
        $('#checkList').val(check);

        });
        }
    );

/** función optenida de http://bytutorial.com/blogs/jquery/jquery-get-selected-checkboxes */

    function getValueUsingClass(){
    /* declare an checkbox array */
    var chkArray = [];
    
    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".chk:checked").each(function() {
        chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(',') ;
    return selected;
}
</script>

