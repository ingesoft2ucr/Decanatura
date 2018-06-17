<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asset $asset
 */
?>

<div class="col-md-12 col-sm-12">
    <h3>Insertar activo</h3>
    <?= $this->Form->create($asset, ['type' => 'file']) ?>
</div>
<br>

<div class="row">
    
<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->input('plaque',array('type' => 'text','label'=>'Placa', 'class' => 'form-control')); ?>   
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('type_id', array('options' => $types,'label'=>'Tipo', 'class' => 'form-control')); ?>
</div>

<br>
    
<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('brand', array('id' => 'brandField', 'options' => $brands, 'label'=>'Marca', 'class' => 'form-control')); ?>
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php use App\Controller\AssetsController ?>

    <?php
        $filterMod = "Apple";
        $options = AssetsController::storeModel($assets, $filterMod);
        echo $this->Form->control('model' , array('options' => $options,'label'=>'Modelo', 'class' => 'form-control')); 
    ?>
</div>


<br>


<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('series', array('label'=>'Serie', 'class' => 'form-control')); ?>
</div>


</div>
<br>


<div class="row">
<div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
    <?php echo $this->Form->control('description', array('label'=>'Descripcion', 'class' => 'form-control', 'rows' => '3')); ?>
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('owner_id', array('options' => $users, 'label'=>'Dueño', 'class' => 'form-control')); ?>
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('responsable_id', array('options' => $users, 'label'=>'Responsable', 'class' => 'form-control')); ?>
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('location_id',  array('options' => $locations,'label'=>'Ubicacion', 'class' => 'form-control')); ?>
</div>

<br>


</div>

<div class="row">

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">    
    <?php echo $this->Form->control('sub_location', array('label'=>'Sub-ubicacion', 'class' => 'form-control')); ?>
</div>    

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">    
    <?php echo $this->Form->control('year',  array('label'=>'Año', 'class' => 'form-control')); ?>
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <div class="custom-control custom-checkbox">
        <?php echo $this->Form->checkbox('lendable',  array('id' => 'customCheck1', 'class' => 'custom-control-input', 'checked' => 'checked')); ?>
        <label class="custom-control-label" for="customCheck1">Prestable</label>
    </div>
</div>

<br>

<div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">                         
    <?php echo $this->Form->control('observations', array('label'=>'Observaciones', 'class' => 'form-control'));?>
</div>

<br>

<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->input('image',['label'=>'Imagen', 'type' => 'file', 'class' => 'form-control-file']); ?>
</div>

</div>

<br>

<div class="col-12 text-right">

<?= $this->Html->link(__('Cancelar'), ['controller' => 'Assets', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary']) ?>
    
    
</div>

   <style>
        .btn-primary {
            float: right;
            margin: 10px;
            margin-top: 15px;
            color: #fff
            background-color: #ffc107;
            border-color: #ffc107;
        }
        </style> 