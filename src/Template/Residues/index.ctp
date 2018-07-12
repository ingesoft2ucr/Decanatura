<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Residue[]|\Cake\Collection\CollectionInterface $residues
 */
$mysqli = new mysqli('decanatura.mysql.database.azure.com','ecci@decanatura','Gaby1234','decanatura');
?>
<div class="roles x large-9 medium-8 columns content">
    <h3><?= __('Desechos') ?></h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="residues-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="actions">Acciones</th>
                        <th scope="col">Unidad Custodio</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Recomendación</th>
                        <th scope="col">N° Autorización</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($residues as $residuess): ?>
                        <tr>
                            <td class="actions">

                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $residuess->residues_id], array('escape' => false)) ?>

                                <?php if($residuess->file_name == null) : ?> 

                                    <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $residuess->residues_id], array('escape' => false)) ?>

                                <?php endif; ?>

                                 <?php if(($residuess->descargado == null) && ($residuess->file_name == null )) : ?>

                                    <?= $this->Form->postlink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $residuess->residues_id], ['escape' => false, 'confirm' => __('¿Seguro quiere borrar el reporte # '.$residuess->residues_id.' ?', $residuess->residues_id)]) ?>
                                <?php endif; ?>
                                
                            </td>
                            <td><?= h($Unidad) ?></td>  
                            <td><?= h($residuess->date ) ?></td>

                            <td><?php
                        //consulta para obtener la recomendación que proviene del informe técnico (no optimizada y hay que pasarla al controlador)
                            $query =  "select  technical_reports.recommendation from residues, assets, technical_reports
                            where residues.residues_id = '".$residuess->residues_id."' and residues.residues_id = assets.residues_id and technical_reports.assets_id = assets.plaque
                            order by technical_reports.date desc limit 1;";
                            $result = $mysqli->query($query);
                        //se muestra la recomendación, cada letra significa una recomendación diferente.
                            foreach ($result as $fila)
                            {
                                if("C"==$fila['recommendation']):
                                  echo 'Reubicar';
                              endif;
                              if("R"==$fila['recommendation']):
                                  echo 'Reparar';
                              endif;
                              if("D"==$fila['recommendation']):
                                  echo 'Desechar';
                              endif;
                              if("U"==$fila['recommendation']):
                                  echo 'Usar Piesas';
                              endif;
                              if("O"==$fila['recommendation']):
                                  echo 'Otros';
                              endif;
                          }
                          ?></td>
                          <td><?= h('VRA-'.$residuess->residues_id ) ?></td>    
                      </tr>
                  <?php endforeach; ?>
              </tbody>
              <tfoot>
                    <tr>
                        <td></td>
                        <th>Unidad</th>
                        <th>Fecha</th>
                        <th>Recomendación</th>
                        <th>Autorización</th>
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

<?= $this->Html->link(__('Insertar Acta'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>

<script type="text/javascript">

    $(document).ready(function() {
        var table= $('#residues-grid').DataTable( {
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
        $('#residues-grid tfoot th').each( function () {
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