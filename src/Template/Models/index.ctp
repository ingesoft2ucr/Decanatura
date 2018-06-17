<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Model[]|\Cake\Collection\CollectionInterface $models
 */
?>
<div class="types index content">
    <h3><?= __('Modelos') ?></h3>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="models-grid"  class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" class="actions"><?= __('') ?></th>        
                        <th scope="col"><?= $this->Paginator->sort('Nombre') ?></th>        
                        <th scope="col"><?= $this->Paginator->sort('Marca') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Tipo') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($models as $model): ?>
                        <tr>
                            <td class="actions">
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $model->id], array('escape'=> false)) ?>
                                <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $model->id],  array('escape'=> false)) ?>
                                <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $model->id],  ['escape'=> false,'confirm' => __('¿Está seguro que desea eliminar este modelo? {0}?', $model->name)]) ?>
                            </td>
                            
                            <td><?= h($model->name) ?></td>
                            <td><?= h($model->brand->name) ?></td>
                            <td><?= h($model->type->name) ?></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Tipo</th>
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

<?= $this->Html->link(__('Insertar Modelo'), ['action' => 'add'] ,['class' => 'btn btn-primary']) ?>

<script type="text/javascript">

    $(document).ready(function() {
        $('#models-grid').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
        // Setup - add a text input to each footer cell
        $('#models-grid tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
        } );

        // DataTable
        var table = $('#models-grid').DataTable();

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

