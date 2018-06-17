<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Model $model
 */
?>


<head>
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
   
	<script type="text/javascript">
		function mostrarReferencia(){
		if (document.agregarModelo.nuevaMarca.checked == true) {
			document.getElementById('new_Brand').value='';
			document.getElementById('newBrandField').style.display='block';
			document.getElementById('id_brand').disabled=true;
		} else {
			document.getElementById('newBrandField').style.display='none';
			document.getElementById('id_brand').disabled=false;
			document.getElementById('new_Brand').value='';
		}
	}
	-->
	</script>
</head>

<div class="col-md-12 col-sm-12">
    <h3>Editar modelo</h3>
    <?= $this->Form->create($model, ['type' => 'file', 'name' => 'agregarModelo']) ?>
</div>
<br>

   
<div class='row'>
	<div class="col-md-4 col-xs-12 col-lg-4 col-sm-1 ">
		<?php echo $this->Form->control('name', array('label'=>'Nombre', 'class' => 'form-control')); ?>
	</div>
	<div class="col-md-4 col-xs-12 col-lg-3 col-sm-12 ">   </div>
	<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
    <?php echo $this->Form->control('id_type', array('options' => $types,'label'=>'Tipo', 'empty' => '-- Seleccione tipo --', 'class' => 'form-control')); ?>
	</div>
</div>

<br>

<div class='row'>
	<div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
		<?php echo $this->Form->control('id_brand', array('options' => $brands,'label'=>'Marca', 'id' => 'id_brand', 'empty' => '-- Seleccione marca --', 'class' => 'form-control')); ?>
	</div>
	
	<div class="col-md-4 col-xs-12 col-lg-3 col-sm-12">
		<br> <br>
		<input type="checkbox" name="nuevaMarca" id="newBrand" value="nueva_marca" onclick="mostrarReferencia();" /> Agregar nueva marca
	</div>
	
	<div id="newBrandField" style="display:none;" class="col-md-4 col-xs-12 col-lg-4 col-sm-1 ">
		<?php echo $this->Form->control('new_Brand', array('label'=>'Nueva marca', 'id' => 'new_Brand', 'class' => 'form-control')); ?>
	</div>
	<br>
</div>

<br>

<div class="col-12 text-right">

<?= $this->Html->link(__('Cancelar'), ['controller' => 'Models', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
<?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary']) ?>
    
</div>
