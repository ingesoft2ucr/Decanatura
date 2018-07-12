<?php
/**
 * @var \App\View\AppView $this
 * 
 *@var \App\Model\Entity\Role $role
 */
?>

<?php
    $dis = "";
    if($rol->nombre == 'Administrador'){
        $dis = "Disabled";
    }
?>

<div class="roles x large-9 medium-8 columns content">
    <h3><?= __($rol->nombre) ?></h3>

    <?php echo $this->Form->create(false, array(
    'url' => array($rol['id'])
    ));
    ?>

    <?php if($rol->nombre == "Administrador")
    ?>
  

    <table class="table">
        <tr>
            <th><h5><?= __('Modulo') ?></h5></th>
            <td><h5><?= __('Insertar') ?></h5></td>
            <td><h5><?= __('Modificar') ?></h5></td>
            <td><h5><?= __('Eliminar') ?></h5></td>
            <td><h5><?= __('Consultar') ?></h5></td>
        </tr>
        
      <tr>
            <th><h5><?= __('Usuarios') ?></h5></th>

        <?php 
          for ($x = 1; $x < 5; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>

      </tr>
        
      <tr>
            <th><h5><?= __('Activos') ?></h5></th>
            

        <?php 
          for ($x = 5; $x < 9; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>


      </tr>

      <tr>
            <th><h5><?= __('Reporte Tecnico') ?></h5></th>
            
        <?php 
          for ($x = 9; $x < 13; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>



        </tr>
        
        <tr>
            <th><h5><?= __('Ubicaciones') ?></h5></th>
            
        <?php 
          for ($x = 13; $x < 17; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>

        </tr>
        
        <tr>
            <th><h5><?= __('Prestamos') ?></h5></th>
            
        <?php 
          for ($x = 17; $x < 21; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>


        </tr>
        
        <tr>
            <th><h5><?= __('Traslados') ?></h5></th>
            
        <?php 
          for ($x = 21; $x < 25; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>


        <tr>
            <th><h5><?= __('Desechos') ?></h5></th>
            
        <?php 
          for ($x = 25; $x < 29; $x++) {
            if ($permisos[$x] == 1) {
              echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'checked'=> true, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            } else {
             echo "<td>";
              echo $this->Form->input('', array( 'type'=>'checkbox', 'name' => $x, 'format' => array('before', 'input', 'between', 'label', 'after', 'error' ), $dis));
              echo "</td>";
            }
          } 
        ?>


        </tr>

        </tr>



    </table>


    <?= $this->Form->button(__('Guardar'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link(__('Cancelar'), ['controller' => 'Roles', 'action' => 'index'], ['class' => 'btn btn-primary']) ?>

    <?= $this->Form->end() ?>

</div>