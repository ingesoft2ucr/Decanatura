<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Residue $residue
 */
    use Cake\Routing\Router;


?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <?php echo $this->Html->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');?>
  <link rel="stylesheet" href="/resources/demos/style.css">

  <script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

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

    input[id=datepicker]{
          width:120px;
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

</head>

<?php
/*
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Residues'), ['action' => 'index']) ?></li>
    </ul>
</nav>
*/
?>

<div class="residues form large-9 medium-8 columns content">
    <!-- El segundo parametro es para utilizar los validadores de cakephp-->
    <?= $this->Form->create($residue,['novalidate','onsubmit'=>'return validateCheck()']) ?>
    <fieldset>
        <legend><?= __('Insertar acta de desecho') ?></legend>
           
      <div class="form-control sameLine">
        <div>
        <?php 
            echo $this->Form->control('residues_id', 
                [
                    'templates' => [
                    'inputContainer' => '<div class="row">{{content}}</div>',
                    'inputContainerError' => '<div class="row {{type}} error"> {{content}} {{error}}</div>'
                    ],
                'label'=>['text'=>'Número de autorización: VRA-', 'style'=>'margin-left= 10px;'],
                'class'=>'form-control col-sm-4',
                'type'=>'text',
                'id' =>'residues_id'
                ]);
        ?>
        </div>    
        <br>
        <div>
        <?php 
        echo $this->Form->control('date', 
          [
            'templates' => [
              'inputContainer' => '<div class="row">{{content}}</div>',
              'inputContainerError' => '<div class="row {{type}} error"> {{content}} {{error}}</div>'
            ],
            'label'=>['text'=>'Fecha:', 'style'=>'margin-left= 10px;'],
            'class'=>'form-control',
            'type'=>'text',
            'id'=>'datepicker'
          ]);
      ?>
        </div>
      </div>
      
      <label>En presencia de:</label>
        
      <table>
            <tr>
                <td><br>
                    
                    <!-- Se modificó la clase del div (a travez de la plantilla) y la del label
                                  Este mismo proceso se aplica en las demás geberaciones -->
                    <?php 
                        echo $this->Form->control('name1', 
                            [
                            'templates' => [
                                'inputContainer' => '<div class="row">{{content}}</div>',
                                'inputContainerError' => '<div class="row {{type}} error"> {{content}} {{error}}</div>'
                                ],

                            'label'=>['class'=>'label-t','text'=>'Nombre:', 'style'=>'margin-left= 10px;'],
                            'class'=>'form-control col-sm-6'
                            ]);
                    ?>
                    <br>
                    <?php 
                        echo $this->Form->control('identification1', 
                            [
                            'templates' => [
                                'inputContainer' => '<div class="row">{{content}}</div>',
                                'inputContainerError' => '<div class="row {{type}} error"> {{content}} {{error}}</div>'
                                ],

                            'label'=>['class'=>'label-t','text'=>'Cédula:', 'style'=>'margin-left= 10px;'],
                            'class'=>'form-control col-sm-6'
                            ]);
                    ?><br>
                </td>
            
                <td><br>
                    <?php 
                        echo $this->Form->control('name2', 
                            [
                            'templates' => [
                                'inputContainer' => '<div class="row">{{content}}</div>',
                                'inputContainerError' => '<div class="row {{type}} error"> {{content}} {{error}}</div>'
                                ],

                            'label'=>['class'=>'label-t','text'=>'Nombre:', 'style'=>'margin-left= 10px;'],
                            'class'=>'form-control col-sm-6'
                            ]);
                    ?><br>
                    <?php 
                        echo $this->Form->control('identification2', 
                            [
                            'templates' => [
                                'inputContainer' => '<div class="row">{{content}}</div>',
                                'inputContainerError' => '<div class="row {{type}} error"> {{content}} {{error}}</div>'
                                ],

                            'label'=>['class'=>'label-t','text'=>'Cédula:', 'style'=>'margin-left= 10px;'],
                            'class'=>'form-control col-sm-6'
                            ]);
                    ?><br>
                </td>
            </tr>
        </table>
         <div>
            <p>
                Se procede a levantar el Acta de Desecho de bienes muebles por haber cumplido su periodo de vida útil, de acuerdo con el Informe Técnico adjunto y la respectiva autorización por parte de la Vicerrectoría de Administración, de conformidad con el Reglamento para la Administración y Control de los Bienes Institucionales de la Universidad de Costa Rica.
            </p>
        </div><br>

    </fieldset>
</div>
<br>
        <!-- AQUI ESTA LO IMPORTANTE. RECUERDEN COPIAR LOS SCRIPTS -->
        <div class="related">
            <legend><?= __('Activos a desechar') ?></legend>

            <!--  Sirve para mostrar el mensaje que se debe seleccionar un activo -->
            <p id="errorMsg" style="color: red;"></p>

            <!-- tabla que contiene  datos básicos de activos-->
            <table id='assets-residues-grid' cellpadding="0" cellspacing="0">
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
                    <?php 
                      foreach ($result as $a): ?>

                      <tr>
                          <td><?= h($a->plaque) ?></td>
                          <td><?= h($a->brand) ?></td>
                          <td><?= h($a->model) ?></td>
                          <td><?= h($a->series) ?></td>
                          <td><?= h($a->state) ?></td>
                          <td data-order="0"><?php
                                echo $this->Form->checkbox('assets_id',
                                        ['value'=>htmlspecialchars($a->plaque),"class"=>"chk"]
                                );
                              ?>
                          </td>
                      </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>


        </div>

    <!-- input donde coloco la lista de placas checkeadas -->
    <input type="hidden" name="checkList" id="checkList">
    <div>
        <p align="center">
            (Art. 26 del Reglamento para la Administración y Control de los Bienes Institucionales de la Universidad de Costa Rica)
        </p>
    </div><br>

<br>
<br>
<div>
    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary', 'id'=>'acept']) ?>
    <?= $this->Form->postLink(__('Generar Pdf'), ['action' => 'download', $residue->residues_id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea descargar el archivo?', $residue->residues_id)]) ?>
</div>

<script type="text/javascript">

 $( function Picker() {
    $( "#datepicker" ).datepicker({ 
            dateFormat: 'dd-mm-yy',
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            dayNamesMin: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do']
     });
  } );


/** método extraido de https://stackoverflow.com/questions/46590217/jquery-datatable-order-table-based-on-checkbox
**/
$(document).ready(function() 
{
    var equipmentTable = $('#assets-residues-grid').DataTable( {
          dom: 'Bfrtip',
                buttons: [
                ],
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
                }
        } );

    // Listen to change event from checkbox to trigger re-sorting
    $('#assets-residues-grid input[type="checkbox"]').on('change', function() {
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


    function validateCheck() {
    var checks, error;

    // Get the value of the input field with id="numb"
    checks = getValueUsingClass();


    // If x is Not a Number or less than one or greater than 10
    if ( checks.length == 0 ) {
        error = "Seleccione al menos un activo";
        document.getElementById("errorMsg").innerHTML = error;
        return false;
    } else {
        return true;
    }
    
}

    $("document").ready(
    function() {
      $('#acept').click( function()
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
