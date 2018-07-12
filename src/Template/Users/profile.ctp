<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <h3>Mi Perfil</h3>
    <fieldset>
        <?php
            echo $this->Form->input('nombre', array('type'=> 'text', 'label'=> 'Nombre', 'class' => 'form-control', 'disabled'));
            echo $this->Form->input('apellido1', array('type'=> 'text', 'label'=> 'Apellido 1', 'class' => 'form-control', 'disabled'));
            echo $this->Form->input('apellido2', array('type'=> 'text', 'label'=> 'Apellido 2', 'class' => 'form-control', 'disabled'));
            echo $this->Form->input('correo', array('type'=> 'text', 'label'=> 'Correo', 'class' => 'form-control'));
            echo $this->Form->input('username', array('type'=> 'text', 'label'=> 'Usuario', 'class' => 'form-control', 'disabled'));
            echo $this->Form->input('password', array('type'=> 'password', 'label'=> 'Contraseña', 'class' => 'form-control', 'value' => ''));
            //echo $this->Form->input('id_rol', array('type' => 'select', 'label'=> 'Rol', 'class' => 'form-control','options' => $roles , 'selected' => 'private', 'value' => $rol ));
            //echo $this->Form->control('account_status', array('type' => 'select', 'label'=> 'Estado', 'class' => 'form-control','options' => array('0' => 'Activo', '1' => 'Inoperante'), 'selected' => 'private'));
        ?>
    <style>
        .btn-primary {
            float: right;
            margin: 20px;
        }
    </style> 
    </div>
    <?= $this->Html->link(__('Cancelar'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->button(__('Aceptar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>