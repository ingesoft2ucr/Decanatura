<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asset[]|\Cake\Collection\CollectionInterface $loans
 */
?>

<style>

    .my_class {
        background-color: Red;
    }

</style>


<div class="types index content">
    <h3><?= __('Préstamos') ?></h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="loans-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="actions"><?= __('') ?></th>             
                        <th scope="col">Responsable</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Fecha de inicio</th>
                        <th scope="col">Fecha de devolución</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loans as $loan): ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $loan->id], array('escape'=> false)) ?>
                            </td>                            
                            <td><?= h($loan->user->nombre . " " . $loan->user->apellido1) ?></td>   
                            
                            <?php
                                if($loan->estado === 'Atrasado'){
                                    echo '<td> <i class="fa fa-calendar-times-o" aria-hidden="true"></i> '. $loan->estado . '</td>';
                                }
                                
                                else if($loan->estado === 'Activo'){
                                    echo '<td> <i class="fa fa-calendar-minus-o" aria-hidden="true"></i> '. $loan->estado . '</td>';
                                }
                                
                                else{
                                    echo '<td> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> '. $loan->estado . '</td>';
                                }

                            ?>                        
                            
                            <td><?= h(date("d-m-Y", strtotime($loan->fecha_inicio))) ?></td>
                            <td><?= $loan->has('fecha_devolucion') ? h(date("d-m-Y", strtotime($loan->fecha_devolucion))) : '' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de devolución</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<br>

<style>
.btn-primary {
    margin: 10px;
    margin-top: 15px;
    color: #fff;
    background-color: #FF9933;
    border-color: #FF9933;
}
</style>

<?= $this->Html->link(__('Insertar Préstamo'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>

<script type="text/javascript">

    $(document).ready(function() {
        var table= $('#loans-grid').DataTable( {
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
        $('#loans-grid tfoot th').each( function () {
            var title = $(this).text();
           $(this).html( '<input type="text" placeholder="&#xF002; '+title+'" style="font-family:Arial, FontAwesome" />' );
        } );

        // DataTable
        //var table = $('#roles-grid').DataTable();

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