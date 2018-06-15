<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roles
 */
?>

<div class="roles x large-9 medium-8 columns content">
    <h3><?= __('Roles') ?></h3>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="roles-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"><?= 'Acciones' ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($roles as $rol): ?>
                    <tr>
                        <td class="actions">
                            <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $rol->id], array('escape'=> false));?>
                            <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $rol->id],  array('escape'=> false));?>
                            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $rol->id],  ['escape'=> false,'confirm' => __('¿Está seguro que desea eliminar el rol: {0}?', $rol->nombre)]);?>
                        </td>
                        <td><?= h($rol->nombre) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?= $this->Html->link(__('Nuevo Rol'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>


<script type="text/javascript">

    $(document).ready(function() {
        $('#roles-grid').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );

        // Setup - add a text input to each footer cell
        $('#roles-grid tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
        } );

        // DataTable
        var table = $('#roles-grid').DataTable();

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