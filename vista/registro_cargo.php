<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:login/login.php');
}

?>

<style>
  ul li:nth-child(3) .activo{
    background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

  <h4 class="text-center text-secondary">REGISTRO DE CARGOS</h4>

  <?php
  include '../modelo/conexion.php';
  include "../controlador/controlador_registrar_cargo.php"
  ?>

  <div class="row">
    <form action="" method="POST">
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Nombre" class="input input__text" name="txtnombre">
      </div>

      <div class="fl-flex-label mb-4 px-2 col-12 ">
        <select name="txtarea" class="input input__select">
          <option value="">Seleccionar Area...</option>
          <?php
              $sql = $conexion->query("SELECT * from area");
              while ($datos = $sql->fetch_object()){?>
              <option value="<?= $datos-> id_area ?>"><?= $datos-> nombre ?></option>
          <?php }
          ?>
        </select>
      </div>

      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Hora Entrada AM" class="input input__text" name="txtentrada_am">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Hora Salida AM" class="input input__text" name="txtsalida_am">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Habilitar AM" class="input input__text" name="txthabilitar">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Limite Salida AM" class="input input__text" name="txtlimiteam">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Habilitar PM" class="input input__text" name="txthabilitarpm">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Hora Entrada PM" class="input input__text" name="txtentrada_pm">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Hora Salida PM" class="input input__text" name="txtsalida_pm">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Limite Salida PM" class="input input__text" name="txtlimitepm">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Min Tolerancia" class="input input__text" name="txttolerancia">
      </div>

      <div class="text-right p-2">
        <a href="cargo.php" class="btn btn-secondary btn-rounded">Atras</a>
        <button type="submit" value="ok" name="btnregistrar" class="btn btn-primary btn-rounded">Registrar</button>
      </div>
    </form>
  </div>



</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>