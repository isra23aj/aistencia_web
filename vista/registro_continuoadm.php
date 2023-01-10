<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:login/login.php');
}

?>

<style>
  ul li:nth-child(6) .activo{
    background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

  <h4 class="text-center text-secondary">REGISTRO DE PARAMETROS H.C. ADM.</h4>

  <?php
  include '../modelo/conexion.php';
  include "../controlador/controlador_registrar_continuoadm.php"
  ?>

  <div class="row">
    <form action="" method="POST">
      
      <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <input type="text" placeholder="Nombre" class="input input__text" name="txtnombre">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <input type="text" placeholder="Hora Entrada" class="input input__text" name="txtentrada">
      </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <input type="text" placeholder="Hora Salida" class="input input__text" name="txtsalida">
      </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <input type="text" placeholder="Habilitar" class="input input__text" name="txthabilitar">
      </div>
            <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <input type="text" placeholder="Limite Salida" class="input input__text" name="txtlimite">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <input type="text" placeholder="Min Tolerancia" class="input input__text" name="txttolerancia">
      </div>

      <div class="fl-flex-label mb-4 px-2 col-12 col-md-6">
        <select name="txtarea" class="input input__select">
          <option value="">Seleccionar Area...</option>
          <?php
              $sql = $conexion->query("SELECT * FROM area where nombre != 'turnos' ");
              while ($datos = $sql->fetch_object()){?>
              <option value="<?= $datos-> id_area ?>"><?= $datos-> nombre ?></option>
          <?php }
          ?>
        </select>
      </div> 

     
      <div class="text-right p-2">
        <a href="continuoadm.php" class="btn btn-secondary btn-rounded">Atras</a>
        <button type="submit" value="ok" name="btnregistrar" class="btn btn-primary btn-rounded">Registrar</button>
      </div>
    </form>
  </div>



</div>

<!-- fin del contenido principal -->





<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>