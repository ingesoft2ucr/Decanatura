<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TechnicalReport[]|\Cake\Collection\CollectionInterface $technicalReports
 */
?>
<div class="roles x large-9 medium-8 columns content">
    <h3><?= __('Informe técnico') ?></h3>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
       <table id="technicalReports-grid" class="table table-striped">
        <thead>
            <tr>
                <th scope="col" class="actions">Acciones</th>
                <th scope="col">Identificador</th>
                <th scope="col">Fecha</th>
                <th scope="col">Recomendación</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($technicalReports as $technicalReport): ?>
                <tr>
                    <td class="actions">
                        <?php if($allowC) : ?>
                            <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $technicalReport->technical_report_id], array('escape' => false)) ?>
                        <?php endif; ?> 
                        <?php if($allowM) : ?>
                            <?php if($technicalReport->file_name == null) : ?> 

                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $technicalReport->technical_report_id], array('escape' => false)) ?>
                            <?php endif; ?>         
                        <?php endif; ?> 
                        <?php if($allowE) : ?> 
                            <?php if(($technicalReport->descargado == null) && ($technicalReport->file_name == null )) : ?> 

                            <?= $this->Form->postlink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $technicalReport->technical_report_id], ['escape' => false, 'confirm' => __('¿Seguro quiere borrar el reporte # '.$technicalReport->technical_report_id.' ?', $technicalReport->technical_report_id)]) ?>
                            <?php endif; ?> 
                        <?php endif; ?> 
                    </td>

                    <td><?= h($technicalReport->facultyInitials."-".$technicalReport->internal_id."-".$technicalReport->year) ?></td>
                    <td><?= h($technicalReport->date ) ?></td>


                    <td>
                      <?php if ("C"==$technicalReport->recommendation): ?>
                          Reubicar
                      <?php endif; ?>

                      <?php if("R"==$technicalReport->recommendation): ?>
                          Reparar
                      <?php endif; ?>

                      <?php if("D"==$technicalReport->recommendation): ?>
                          Desechar
                      <?php endif; ?>

                      <?php if("U"==$technicalReport->recommendation): ?>
                          Usar piesas
                      <?php endif; ?>


                      <?php if("O"==$technicalReport->recommendation): ?>
                          Otros
                      <?php endif; ?>

                  </td>           

                  <td>
                      <?php if ((null == $technicalReport->file_name) && (null == $technicalReport->descargado)): ?>
                          Pendiente
                      <?php endif; ?>

                      <?php if ((null == $technicalReport->file_name) && (null != $technicalReport->descargado)): ?>
                          Pendiente Aprobación
                      <?php endif; ?>

                      <?php if ((null != $technicalReport->file_name) && (null != $technicalReport->descargado)): ?>
                          Completado
                      <?php endif; ?>
                  </td>

              </tr>
          <?php endforeach; ?>
      </tbody>
       <tfoot>
                    <tr>
                        <td></td>
                        <th>Identificador</th>
                        <th>Fecha</th>
                        <th>Recomendación</th>
                        <th>Estado</th>
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


<?= $this->Html->link(__('Insertar informe técnico'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>

<script type="text/javascript">

    $(document).ready(function() {
        var table= $('#technicalReports-grid').DataTable( {
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
        $('#technicalReports-grid tfoot th').each( function () {
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