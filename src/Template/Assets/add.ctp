<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\Asset $asset
     */
    use Cake\Routing\Router;
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
  <?= $this->Form->create($asset, ['type' => 'file']) ?>
  <fieldset>
    <legend><?= __('Insertar activo') ?></legend>
    <br>

    <div class="form-control sameLine" >
	
    <div class="row">
        <label> <b>Placa:</b><b style="color:red;">*</b> </label>
    <?php echo $this->Form->imput('plaque', ['class'=>'form-control col-md-9']); ?> 
    </div>
	  	  
	  <div class="row">
        <label> <b>Tipo:</b><b style="color:red;">*</b> </label>
        <?php echo $this->Form->select('type_id', $types, array('empty' => '-- Seleccione Tipo --', 'class' => 'form-control col-md-9')); ?>            
      </div>
        
		
	  <div class="col-lg-3">   </div>
    </div> <br>
	
	<div class="form-control sameLine" >

      <div class="row">
        <label>Marca:</label>
        <?php echo $this->Form->select('brand', $brands, ['id' => 'brand-list', 'onChange' => 'getBrand(this.value);', 'empty' => '-- Seleccione Marca --',  'class'=>'form-control col-md-9']); ?>        
      </div>
      
      <div class="row">
        <label>Modelo:</label>
        <?php echo $this->Form->select('models_id', '', ['id' => 'model-list', 'empty' => '-- Seleccione Modelo --', 'class'=>'form-control col-md-8']); ?>        
      </div>
	  
	  <div class="row">
        <label>Serie:</label>
        <?php echo $this->Form->imput('series', ['label' => 'Serie:', 'class'=>'form-control col-md-9']); ?>        
    </div>

  </div> 
  <br>
	
	<div>
    <label> <b>Descripción:</b><b style="color:red;">*</b> </label>
    <?php echo $this->Form->textarea('description', ['class'=>'form-control col-md-8']); ?>
  </div> <br>
	
	<div class="form-control sameLine" >

      <div class="row">
        <label> <b>Responsable:</b><b style="color:red;">*</b> </label>
        <?php echo $this->Form->select('responsable_id', $users, array('empty' => '-- Seleccione Responsable --', 'class' => 'form-control col-md-7')); ?>            
      </div>
      
      <div class="row">
        <label><b>Asignado a:</b><b style="color:red;">*</b> </label>
        <?php echo $this->Form->select('assigned_to', $users, ['empty' => '-- Seleccione Asignado --', 'class'=>'form-control col-md-7']); ?>        
      </div>
	  
	  <div class="row">
        <label> <b>Ubicación:</b><b style="color:red;">*</b></label>
        <?php echo $this->Form->select('location_id', $locations, ['empty' => '-- Seleccione Ubicación --', 'label' => 'Serie:', 'class'=>'form-control col-md-7']); ?>        
      </div>

  </div> 
  <br>
	

	<div class="form-control sameLine" >

      <div class="row">
        <label> Sub-ubicación: </label>
        <?php echo $this->Form->imput('sub_location', ['class'=>'form-control col-md-7']); ?>       
      </div>
	  
      
      <div class="row">
        <label class="col-lg-3"> <b>Año:</b><b style="color:red;">*</b> </label>
        <?php echo $this->Form->imput('year',['class'=>'form-control col-md-7']); ?>        
      </div>
	  
	  <div class="row col-lg-1">
        <div class="custom-control custom-checkbox">
			    <?php echo $this->Form->checkbox('lendable',  array('id' => 'customCheck1', 'class' => 'custom-control-input', 'checked' => 'checked')); ?>
			    <label class="custom-control-label" for="customCheck1">Prestable</label>
		    </div>       
    </div>
	  
	  <div class="col-lg-1">   
    </div>

  </div> 
  <br>
	
	<div>
      <label> Observaciones: </label>
      <?php echo $this->Form->textarea('observations', ['class'=>'form-control col-md-8']); ?>
  </div> <br>
	
	<div class = "row">
    <div class = "col-md-4">
      <label> Imagen: </label>
      <?php echo $this->Form->imput('image',['type' => 'file', 'class' => 'form-control-file']); ?>
    </div>

    <div class = "offset-md-1 col-md-4">
      <label> Archivo adjunto: </label>
      <?php echo $this->Form->imput('file',['type' => 'file', 'class' => 'form-control-file']); ?>
    </div>
  </div>

  </fieldset>

</div>
<br>

  <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>
  <?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary']) ?>

<?= $this->Form->end(); ?>

</body>

<script>
    function getBrand(val) {
        console.log(val);
        $.ajax({
            type: "GET",
            url: '<?php echo Router::url(['controller' => 'Assets', 'action' => 'dependentList' ]); ?>',
            data:{brand_id:val},
            
            success: function(data){
                $("#model-list").html(data);
            },

            error: function(e) {
                    alert("Ocurrió un error: artículo no encontrado.");
                    console.log(e);
                    $("#model-list").html('Introduzca otro número de placa.');
                    }
        
        });
    }
</script>
