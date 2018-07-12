<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <h3>Insertar Usuario</h3>
    <fieldset>
        <?php
            echo $this->Form->control('nombre', array('type'=> 'text', 'label'=> 'Nombre', 'class' => 'form-control'));
            echo $this->Form->control('apellido1', array('type'=> 'text', 'label'=> 'Apellido 1', 'class' => 'form-control'));
            echo $this->Form->control('apellido2', array('type'=> 'text', 'label'=> 'Apellido 2', 'class' => 'form-control'));
            echo $this->Form->control('id', array('type'=> 'text', 'label'=> 'Cédula', 'class' => 'form-control'));
            echo $this->Form->control('correo', array('type'=> 'text', 'label'=> 'Correo', 'class' => 'form-control'));
            echo $this->Form->control('username', array('type'=> 'text', 'label'=> 'Usuario', 'class' => 'form-control'));
            echo $this->Form->control('password', array('type'=> 'password', 'label'=> 'Contraseña', 'class' => 'form-control'));
            echo $this->Form->input('id_rol', array('type' => 'select', 'label'=> 'Rol', 'class' => 'form-control','options' => $roles , 'selected' => 'private'));
            echo $this->Form->control('account_status', array('type' => 'select', 'label'=> 'Estado', 'class' => 'form-control','options' => array('1' => 'Activo', '0' => 'Inoperante'), 'selected' => 'private'));
        ?>
    </fieldset>
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