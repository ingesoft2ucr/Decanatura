<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Brand $brand
 */
?>

<style>
    .btn-primary {
          color: #fff;
          background-color: #0099FF;
          border-color: #0099FF;
          float: right;
          margin-left: 10px;
    }
	
	label {
          text-align:left;
          margin-right: 10px;
          
    }
	
	.sameLine{
          text-align:left;
          margin-right: 20px;
		  border-color: transparent;
    }
</style> 

<div class="locations form large-9 medium-8 columns content">
    <?= $this->Form->create($brand) ?>
	
    <fieldset>
		<legend><?= __('Editar marca') ?></legend>
		<br>
		
		<div class="form-control sameLine" >
			<div class="row">
				<label> <b>Nombre:</b><b style="color:red;">*</b> </label>
				<?php echo $this->Form->imput('name', array('class' => 'form-control col-md-3')); ?>   
			</div>
		</div>
		
	</fieldset>
</div>

<br>


<?= $this->Html->link(__('Cancelar'), ['controller' => 'Brands', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>

<?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary']) ?>
