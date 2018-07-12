<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityLog[]|\Cake\Collection\CollectionInterface $activityLogs
 */
?>
<div class="types index content">
    <h3><?= __('Registro de actividad') ?></h3>
</div>

<p id="date_filter">
    <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="text"
                                                                      id="datepicker_from"/>
    <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" type="text"
                                                          id="datepicker_to"/>
</p>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="activity-grid" class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Fecha/Hora</th>
                    <th scope="col">Modulo</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Acción</th>
                    <th scope="col">Mensaje</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($activityLogs as $activityLog): ?>
                    <tr>
                        <td><?= h($activityLog->DateAndTime) ?></td>
                        <td><?= h($activityLog->currentModule) ?></td>
                        <td>
                            <?= $activityLog->user->nombre ?>
                        </td>
                        <!--td><?= $activityLog->has('user') ? $this->Html->link($activityLog->user->username, ['controller' => 'Users', 'action' => 'view', $activityLog->user->id]) : '' ?></td-->
                        <td><?= h($activityLog->userAction) ?></td>
                        <td><?= h($activityLog->message) ?></td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>Fecha/Hora</th>
                    <th>Modulo</th>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Mensaje</th>
                </tr>

                </tfoot>
            </table>
        </div>
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


<script type="text/javascript">

    $(document).ready(function () {
            var table = $('#activity-grid').DataTable({
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
            });
            // Setup - add a text input to each footer cell
            $('#activity-grid tfoot th').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="&#xF002; ' + title + '" style="font-family:Arial, FontAwesome" />');
            });

            // DataTable
            // var table = $('#assets-grid').DataTable();

            // Apply the search
            table.columns().every(function () {
                var that = this;

                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });


            $("#datepicker_from").datepicker({
                showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: false,
                "onSelect": function (date) {
                    minDateFilter = new Date(date).getTime();
                    table.fnDraw();
                }
            }).keyup(function () {
                minDateFilter = new Date(this.value).getTime();
                table.fnDraw();
            });

            $("#datepicker_to").datepicker({
                showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: false,
                "onSelect": function (date) {
                    maxDateFilter = new Date(date).getTime();
                    table.fnDraw();
                }
            }).keyup(function () {
                maxDateFilter = new Date(this.value).getTime();
                table.fnDraw();
            });

        }
    );


    // Date range filter
    minDateFilter = "";
    maxDateFilter = "";

    $.fn.dataTableExt.afnFiltering.push(
        function (oSettings, aData, iDataIndex) {
            if (typeof aData._date == 'undefined') {
                aData._date = new Date(aData[0]).getTime();
            }

            if (minDateFilter && !isNaN(minDateFilter)) {
                if (aData._date < minDateFilter) {
                    return false;
                }
            }

            if (maxDateFilter && !isNaN(maxDateFilter)) {
                if (aData._date > maxDateFilter) {
                    return false;
                }
            }

            return true;
        }
    );
</script>





