<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="types index content">
    <h3><?= __('Usuarios') ?></h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="users-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <!--<th scope="col"><?= $this->Paginator->sort('id') ?></th>-->
                        <th scope="col" class="actions">Acciones</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido 1</th>
                        <th scope="col">Apellido 2</th>
                        <!--<th scope="col"><?= $this->Paginator->sort('Correo') ?></th>-->
                        <th scope="col">Usuario</th>
                        <!--<th scope="col"><?= $this->Paginator->sort('password') ?></th>-->
                        <!--<th scope="col"><?= $this->Paginator->sort('id_rol') ?></th>-->
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $user->id], array('escape'=> false)) ?>
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $user->id],  array('escape'=> false)) ?>
                                <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $user->id],  ['escape'=> false,'confirm' => __('¿Está seguro que desea eliminar este usuario? # {0}?', $user->id)]) ?>
                            </td>
                            <!--<td><?= $this->Number->format($user->id) ?></td>-->
                            <td><?= h($user->nombre) ?></td>
                            <td><?= h($user->apellido1) ?></td>
                            <td><?= h($user->apellido2) ?></td>
                            <!--<td><?= h($user->correo) ?></td>-->
                            <td><?= h($user->username) ?></td>
                            <!--<td><?= h($user->password) ?></td>-->
                            <!--<td><?= $this->Number->format($user->id_rol) ?></td>-->
                            <td><?= h($user->account_status == 1 ? 'Activo' : 'Inoperante') ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <th>Nombre</th>
                        <th>Apellido1</th>
                        <th>Apellido2</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                    </tr>
                </tfoot>
            </table>
            
        </div>
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

<?= $this->Html->link(__('Nuevo Usuario'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>


<script type="text/javascript">

    $(document).ready(function() {
        var table = $('#users-grid').DataTable( {

            dom: 'Bfrtip',

            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
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
        $('#users-grid tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="&#xF002; '+title+'" style="font-family:Arial, FontAwesome" />' );
        } );

        // DataTable
        //var table = $('#users-grid').DataTable();

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