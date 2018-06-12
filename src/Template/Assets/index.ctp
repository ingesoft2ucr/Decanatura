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
                        <th scope="col"><?= $this->Paginator->sort('Placa') ?></th>        
                        <th scope="col"><?= $this->Paginator->sort('Marca') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Modelo') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Serie') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Descripción') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Estado') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Responsable') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('Ubicación') ?></th>                
                        <th scope="col"><?= $this->Paginator->sort('Año') ?></th>
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
                            <td><?= h($asset->model) ?></td>
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
                    <td class="actions">
                        <?php if($allowC) : ?>
                        <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-eye')), ['action' => 'view', $asset->plaque], array('escape' => false)) ?>
                        <?php endif; ?>
                        <?php if($allowM) : ?>
                        <?= $this->Html->link($this->Html->tag('i', '', array('class' => 'fa fa-edit')), ['action' => 'edit', $asset->plaque], array('escape' => false)) ?>
                        <?php endif; ?>
                        <?php if($allowE) : ?>
                        <?= $this->Form->postlink($this->Html->tag('i', '', array('class' => 'fa fa-trash')), ['action' => 'delete', $asset->plaque], ['escape' => false, 'confirm' => __('Seguro que desea eliminar el tipo de activo # {0}?', $asset->plaque)]) ?>
                        <?php endif; ?>
                    </td>                       
                    <td><?= h($asset->plaque) ?></td>
                    <td><?= $asset->has('type') ? $this->Html->link($asset->type->name, ['controller' => 'Types', 'action' => 'view', $asset->type->type_id]) : '' ?></td>
                    <td><?= h($asset->brand) ?></td>
                
                
                    <td><?= h($asset->description) ?></td>
                
                    <td><?= $this->Number->format($asset->owner_id) ?></td>
                    
                    <td><?= $asset->has('location') ? $this->Html->link($asset->location->location_id, ['controller' => 'Locations', 'action' => 'view', $asset->location->location_id]) : '' ?></td>
                
                    <td><?= $this->Number->format($asset->year) ?></td>

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
        $('#assets-grid').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        } );
        // Setup - add a text input to each footer cell
        $('#assets-grid tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
        } );

        // DataTable
        var table = $('#assets-grid').DataTable();

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
