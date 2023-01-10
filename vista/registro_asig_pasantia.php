<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:login/login.php');
}

?>

<style>
  ul li:nth-child(10) .activo{
    background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

  <h4 class="text-center text-secondary">REGISTRO DE HORARIO PASANTIAS  </h4>

  <?php
  include '../modelo/conexion.php';
  include "../controlador/controlador_registrar_asig_pasantia.php"
  ?>

  <div class="row">
    <form action="" method="POST">
    
    <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <select name="txtnombre" class="input input__select">
          <option value="">Seleccionar Empleado...</option>
          <?php
              $sql = $conexion->query("SELECT * from empleado where area=2 or cargo=14");
              while ($datos = $sql->fetch_object()){?>
              <option value="<?= $datos-> id_empleado ?>"><?= $datos-> nombre ?></option>
          <?php }
          ?>
        </select>
      </div>


      <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <select name="txtarea" class="input input__select">
          <option value="">Seleccionar Area...</option>
          <?php
              $sql1 = $conexion->query("SELECT * from area");
              while ($datos1 = $sql1->fetch_object()){?>
              <option value="<?= $datos1-> id_area ?>"><?= $datos1-> nombre ?></option>
          <?php }
          ?>
        </select>
      </div>
      
      <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <select name="txtcontinuo_adm" class="input input__select">
          <option value="">Seleccionar Horario...</option>
          <?php
              $sql2 = $conexion->query("SELECT * from continuo_adm");
              while ($datos2 = $sql2->fetch_object()){?>
              <option value="<?= $datos2-> id_continuo_adm ?>"><?= $datos2-> nombre ?></option>
          <?php }
          ?>
        </select>
      </div>
      
      <div class="text-right p-2">
        <a href="asig_pasantia.php" class="btn btn-secondary btn-rounded">Atras</a>
        <button type="submit" value="ok" name="btnregistrar" class="btn btn-primary btn-rounded">Registrar</button>
      </div>
    </form>
  </div>



</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>