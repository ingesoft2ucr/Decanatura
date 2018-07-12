<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rol $rol
 */
?>

<?php
    $dis = "";
    if($rol->nombre == 'Administrador'){
        $dis = "Disabled";
    }
?>

<div class="roles form large-9 medium-8 columns content">
    <?= $this->Form->create($rol); ?>
    <h3>Modificar Rol</h3>
    <fieldset>
        <?php
            echo $this->Form->control('nombre', array('type'=> 'text', 'label'=> 'Nombre', 'class' => 'form-control', $dis));
        ?>
    </fieldset>
        <style>
        .btn-primary {
            float: right;
            margin: 20px;
        }
    </style>
    </div>
    <?= $this->Html->link(__('Cancelar'), ['controller' => 'Roles', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
