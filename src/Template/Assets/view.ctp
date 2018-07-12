<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asset $asset
 */

?>

<head>
 
  <style>
        .btn-primary {
          color: #fff;
          background-color: #0099FF;
          border-color: #0099FF;
          float: right;
          margin-left: 10px;
        }
		
		.btn-default {
          color: #000;
          background-color: #7DC7EF;
          border-top-right-radius: 5px;
          border-bottom-right-radius: 5px;
        }
		
        label {
          text-align:left;
          margin-right: 10px;
          
        }

        .sameLine{
          display: flex; 
          justify-content: space-between; 
          border-color: transparent;
        }
   
  </style>

</head>

<body>
<div class="locations form large-9 medium-8 columns content">
  <?= $this->Form->create($asset) ?>
  <fieldset>
    <legend><?= __('Consultar activo') ?></legend>
    <br>

    <div class="form-control sameLine" >
	
      <div class="row">
          <label> Placa: </label>
		  <?php echo '<input type="text" class="form-control col-sm-9" readonly="readonly" value="' . htmlspecialchars($asset->plaque) . '">'; ?> 
      </div>
      
	  <div class="row">
        <label> Tipo: </label>
        <?php echo '<input type="text" class="form-control col-sm-9" readonly="readonly" value="' . htmlspecialchars($asset->type->name) . '">'; ?>            
      </div>
        
		
	  <div class="col-lg-3">   </div>
        
    </div> <br>
	
	<div class="form-control sameLine" >

      <div class="row">
        <label>Marca:</label>
        <?php echo '<input type="text" class="form-control col-sm-9" readonly="readonly" value="' . htmlspecialchars($asset->brand) . '">'; ?>       
      </div>
      
      <div class="row">
        <label>Modelo:</label>
        <?php echo '<input type="text" class="form-control col-sm-8" readonly="readonly" value="' . htmlspecialchars($asset->model->name) . '">'; ?>      
      </div>
	  
	  <div class="row">
        <label>Serie:</label>
        <?php echo '<input type="text" class="form-control col-sm-9" readonly="readonly" value="' . htmlspecialchars($asset->series) . '">'; ?>         
      </div>

    </div> <br>
	
	<div>
      <label> Descripción: </label>
      <?php echo $this->Form->textarea('description', ['class'=>'form-control col-md-8', 'disabled']); ?>
    </div> <br>
	
	<div class="form-control sameLine" >

      <div class="row">
        <label> Responsable: </label>
        <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($asset->user->nombre) . '">'; ?>        
      </div>
      
      <div class="row">
        <label> Asignado a: </label>
        <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($asset->user->nombre) . '">'; ?>       
      </div>
	  
	  <div class="row">
        <label> Ubicación: </label>
        <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($asset->location->nombre) . '">'; ?>        
      </div>

    </div> <br>
	
	<div class="form-control sameLine" >

      <div class="row">
        <label> Sub-ubicación: </label>
        <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($asset->sub_location) . '">'; ?>       
      </div>
	  
      
      <div class="row">
        <label class="col-lg-2"> Año: </label>
        <?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($asset->year) . '">'; ?>        
      </div>
	  
	  <div class="row col-lg-1">
        <div class="custom-control custom-checkbox">
			<?php echo $this->Form->checkbox('lendable',  array('id' => 'customCheck1', 'class' => 'custom-control-input', 'checked' => 'checked', 'disabled')); ?>
			<label class="custom-control-label" for="customCheck1">Prestable</label>
		</div>       
      </div>
	  
	  <div class="col-lg-1">   </div>

    </div> <br>
	
	<div>
      <label> Observaciones: </label>
      <?php echo $this->Form->textarea('observations', ['class'=>'form-control col-md-8', 'disabled']); ?>
    </div> <br>
	
  <?php
    if($asset->image != NULL){
      echo "<div><label> Imagen: </label> <br><td>";
      echo $this->Html->link( 
        $this->Html->image('/webroot/files/Assets/image/' . $asset->unique_id . '/' . 'thumbnail-' . $asset->image, array('class' => 'img-thumbnail')),
        '/webroot/files/Assets/image/' . $asset->unique_id . '/' . $asset->image,
        array('escape' => false, 'target' => '_blank'));
      
      echo "</td></div>";
    }
  ?>

  <?php
    if($asset->file != NULL){
      echo "<div><br><td>";
      echo $this->Html->link( 
        "Ver archivo adjunto",
        '/webroot/files/Assets/file/' . $asset->unique_id . '/' . $asset->file,
        array('escape' => false, 'target' => '_blank'));
      
      echo "</td></div>";
    }
  ?>

	<br> 
  <br>
	<div class="col-12 text-right">

    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
	
  <div class="col-12 text-right" hidden>
    <?= $this->Form->postLink(__('Eliminar2'), ['action' => 'delete', $asset->plaque], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea eliminar el activo "{0}" ?', $asset->plaque)]) ?>
  </div>
    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'softDelete', $asset->plaque], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea eliminar el activo # {0}?', $asset->plaque)]) ?>
    
    <?php 
        if($asset->deleted == true){
            echo $this->Form->postLink(__('Activar'), ['action' => 'restore', $asset->plaque], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea restaurar el activo # {0}?', $asset->plaque)]);
        }
    ?>
	
    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $asset->plaque], ['class' => 'btn btn-primary']) ?>
    

	</div> <br>

 </fieldset>
