<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transfer[]|\Cake\Collection\CollectionInterface $transfers
 */
?>

<style>
.btn-primary {
  color: #fff;
  background-color: #FF9933;
  border-color: #FF9933;
}
</style>

<div class="transfers index large-9 medium-8 columns content">
    <h3><?= __('Traslados') ?></h3>
    <table id='transfers-grid' class="table table-striped" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="actions">Acciones</th>
                <th scope="col">Nº traslado</th>
                <th scope="col">Fecha</th>
                <th scope="col">Recibe</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transfers as $transfer): ?>
            <tr>
                <td class="actions">

                    <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $transfer->transfers_id], array('escape' => false)) ?>
                    
                    <?php if($transfer->file_name == null) : ?> 

                        <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $transfer->transfers_id], array('escape' => false)) ?>
                    <?php endif; ?>  

                    <?php if(($transfer->descargado == null) && ($transfer->file_name == null )) : ?> 

                    <?= $this->Form->postlink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $transfer->transfers_id], ['escape' => false, 'confirm' => __('¿Está seguro que quiere borrar el traslado # '.$transfer->transfers_id.' ?', $transfer->transfers_id)]) ?>
                    
                    <?php endif; ?>  

                </td>
                <td><?= h($transfer->transfers_id) ?></td> 
                <td>
                    <?php 
                    //para darle formato a la fecha
                    $tmpdate= $transfer->date->format('d-m-Y');
                    ?>

                    <?= h($tmpdate) ?>
                    
                </td> 
                <td><?= h($transfer->Acade_Unit_recib) ?></td>              
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <th>Nº Traslado</th>
                <th>Fecha</th>
                <th>Recibe</th>
            </tr>
        </tfoot>
    </table>
    
</div>


<style>
.btn-primary {
    margin: 10px;
    margin-top: 15px;
    color: #fff;
    background-color: #FF9933;
    border-color: #FF9933;
}
</style>


<?= $this->Html->link(__('Insertar traslado'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>

<script type="text/javascript">

    $(document).ready(function() {
        var table = $('#transfers-grid').DataTable( {
           dom: 'Bfrtip',
                buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
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
        // Setup - add a text input to each footer cell
        $('#transfers-grid tfoot th').each( function () {
            var title = $(this).text();
     $(this).html( '<input type="text" placeholder="&#xF002; '+title+'" style="font-family:Arial, FontAwesome" />' );
        } );

        // DataTable
        //var table = $('#transfers-grid').DataTable();

        // Apply the search
        table.columns().every( function () {
            var that = this;

            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    } );


</script>

