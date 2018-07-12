<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asset[]|\Cake\Collection\CollectionInterface $assets
 */
?>

<div class="types index content">
    <h3><?= __('Activos') ?></h3>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="assets-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="actions"><?= __('') ?></th>        
                        <th scope="col">Placa</th>        
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Serie</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Asignado</th>
                        <th scope="col">Ubicación</th>                
                        <th scope="col">Año</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($assets as $asset): ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $asset->plaque], array('escape'=> false)) ?>
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $asset->plaque],  array('escape'=> false)) ?>
                                <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'softDelete', $asset->plaque],  ['escape'=> false,'confirm' => __('¿Está seguro que desea eliminar este activo? # {0}?', $asset->id)]) ?>
                            </td>
                            
                            <td><?= h($asset->plaque) ?></td>
                            <td><?= h($asset->brand) ?></td>
                            <td><?= $asset->has('model') ? h($asset->model->name) : '' ?></td>
                            <td><?= h($asset->series) ?></td>
                            <td><?= h($asset->description) ?></td>
                            <td><?= h($asset->state) ?></td>
                            <td><?= h($asset->user->nombre . " " . $asset->user->apellido1) ?></td>
                            <td><?= $asset->has('location') ? $this->Html->link($asset->location->nombre, ['controller' => 'Locations', 'action' => 'view', $asset->location->location_id]) : '' ?></td>
                            <td><?= h($asset->year) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Serie</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Asignado a</th>
                        <th>Ubicación</th>
                        <th>Año</th>
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

<?= $this->Html->link(__('Insertar Activo'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>

<?= $this->Html->link(__('Insertar Activos por Lote'), ['action' => 'batch'] ,['class' => 'btn btn-primary']) ?>

<script type="text/javascript">

    $(document).ready(function() {
        var table = $('#assets-grid').DataTable( {
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
        $('#assets-grid tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="&#xF002; '+title+'" style="font-family:Arial, FontAwesome" />' );
        } );

        // DataTable
       // var table = $('#assets-grid').DataTable();

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
    }
    );


</script>
