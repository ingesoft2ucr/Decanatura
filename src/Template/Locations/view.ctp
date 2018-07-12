<div class="locations view large-9 medium-8 columns content">
    <?= $this->Form->create($location) ?>
    <fieldset>
        <legend><?= __('Consultar Ubicación') ?></legend><br>
            <div class = 'row'>
                <label class='align'>Ubicación:</label><br>
                <?php 
                echo $this->Form->imput('nombre', ['label' => 'Nombre:', 'class'=>'form-control col-sm-2', 'disabled']);
                ?>
            </div><br>
            <div class = 'row'>
                <label class='align'>Descripción:</label><br>
                <?php 
                echo $this->Form->textarea('description', ['label' => 'Descripción:', 'class'=>'form-control col-sm-4', 'disabled']);
                ?>
            </div><br>
    </fieldset>

<style>
    .btn-primary {
      color: #FFF;
      background-color: #0099FF;
      border-color: #0099FF;
      float: right;
      margin-left:10px;
    }

    label {
        width: 100px;
    }

    label[class=align] {
        margin-left: 15px;
    }
</style> 

    
</div>

<?= $this->Html->link(__('Cancelar'), ['controller'=> 'Locations', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
<?= $this->Html->link(__('Modificar'), ['controller'=> 'Locations', 'action' => 'edit', $location->location_id], ['class' => 'btn btn-primary']) ?>


<?= $this->Form->postLink(__('Eliminar'), ['controller'=> 'Locations', 'action' => 'delete', $location->location_id], ['hidden' => 'true','class' => 'btn btn-primary', 'confirm' => __('Seguro que desea eliminar la Ubicación: "{0}"?', $location->nombre)]) ?>

<?= $this->Form->postlink(('Eliminar'), ['action' => 'delete', $location->location_id], ['class' => 'btn btn-primary','escape' => false, 'confirm' => __('Seguro que desea eliminar la Ubicación: "{0}"?', $location->nombre)]) ?>
