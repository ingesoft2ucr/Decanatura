<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Model $model
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
   </style>
</head>


<div class="locations form large-9 medium-8 columns content">
    <?= $this->Form->create($model) ?>

	<fieldset>
    <legend><?= __('Consultar modelo') ?></legend>
    <br>

		<div class='row'>
			<div class="col-md-4 col-xs-12 col-lg-5 col-sm-1 ">
				<label> Nombre: </label> <br>
				<?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($model->name) . '">'; ?> 
			</div>
			<div class="col-md-4 col-xs-12 col-lg-2 col-sm-12 ">   </div>
			<div class="col-md-4 col-xs-12 col-lg-5 col-sm-12">
				<label> Tipo: </label> <br>
				<?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($model->type->name) . '">'; ?>
			</div>
		</div>

		<br>

		<div class='row'>
			<div class="col-md-4 col-xs-12 col-lg-5 col-sm-12">
				<label> Marca: </label> <br>
				<?php echo '<input type="text" class="form-control col-sm-6" readonly="readonly" value="' . htmlspecialchars($model->brand->name) . '">'; ?>
			</div>
			<br>
		</div>

		<br>

	</fieldset>

</div>

<div class="col-12 text-right">

<?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-primary']) ?>

<div class="col-12 text-right" hidden>
	<?= $this->Form->postLink(__('Eliminar2'), ['action' => 'delete', $model->id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea eliminar el modelo "{0}" ?', $model->name)]) ?>
</div>
<?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $model->id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea eliminar el modelo "{0}" ?', $model->name)]) ?>
<?= $this->Html->link(__('Editar'), ['action' => 'edit', $model->id], ['class' => 'btn btn-primary']) ?>
    

</div>
