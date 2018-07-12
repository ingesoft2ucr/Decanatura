<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Loan $loan
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
		
		.date{
          width:100px;
          margin-left: 10px;
        }
</style> 
  
<div class="residues form large-9 medium-8 columns content">

	<fieldset>
        <legend><?= __('Consultar préstamo') ?></legend>
    
		<br>

		<div class="form-control sameLine">
			<div class="row col-lg-5">
				<label> <b>Responsable:</b><b style="color:red;">*</b> </label>
				<?php echo '<input type="text" id="id_responsables" class="form-control col-sm-4 col-md-4 col-lg-4" readonly="readonly" value="' . htmlspecialchars($loan->user->nombre). '">'; ?>
			</div>

			<div class="row">
				<label> <b>Fecha inicio:</b><b style="color:red;">*</b> </label>
				<?php echo $this->Form->imput('fecha_inicio', ['class'=>'form-control date', 'value' => date("y-m-d"), 'id'=>'datepicker', 'disabled']); ?>
			</div>
			
			<div class="row">
				<label> Fecha de devolución: </label>
                <?php echo $this->Form->imput('fecha_devolucion', ['class'=>'form-control date', 'id'=>'datepicker2', 'disabled']); ?>
			</div>
			
		</div>
	
	</fieldset>
    <br> <br>
</div>

<div class="related">
    <legend><?= __('Activos prestados') ?></legend>

    <!-- tabla que contiene  datos básicos de activos-->
    <table id='assets-borrowed-grid' cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="transfer-h"><?= __('Placa') ?></th>
                <th class="transfer-h"><?= __('Modelo') ?></th>
                <th class="transfer-h"><?= __('Serie') ?></th>
            </tr>
        <thead>
        <tbody>
            <?php 
                foreach ($result as $a): ?>
                <tr>
                    <td><?= h($a->plaque) ?></td>
                    <td><?= h($a->models_id) ?></td>  
                    <td><?= h($a->series) ?></td>
                </tr>
            <?php endforeach; ?>
            
        </tbody>
    </table>

</div>

<div>
      <label> Observaciones: </label>
      <?php echo '<input type="text" id="observaciones" class="form-control col-sm-4 col-md-4 col-lg-4" readonly="readonly" value="' . htmlspecialchars($loan->observaciones). '">'; ?>
    </div> <br>

    <div >
      <?php echo $this->Form->input('file_solicitud',['type' => 'file','label' => 'Subir Formulario de Préstamo', 'class' => 'form-control-file']); ?>
    </div>

<div class="col-12 text-right">

 <?= $this->Html->link(__('Cancelar'), ['controller' => 'Loans', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>

 <?php 
        if($loan->estado != 'Terminado'){
			echo $this->Html->link(__('Finalizar Préstamo'), ['action' => 'terminar',$loan->id], ['class' => 'btn btn-primary']);
        }
    ?>
  

 <?= $this->Form->postLink(__('Generar Formulario'), ['controller'=> 'Loans', 'action' => 'download',$loan->id], ['class' => 'btn btn-primary', 'confirm' => __('Seguro que desea descargar el archivo?', $loan->id)]) ?>

  <?= $this->Form->postLink(__('Test'), ['controller'=> 'Loans', 'action' => 'terminar',$loan->id], ['class' => 'btn btn-primary']) ?>

</div>


