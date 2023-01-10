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

  <h4 class="text-center text-secondary">LISTA DE CARGOS ADMINISTRATIVOS 2.0</h4>

  <?php
  include "../modelo/conexion.php";
  include "../controlador/controlador_modificar_cargo.php";
  include "../controlador/controlador_eliminar_cargo.php";


  $sql = $conexion->query("SELECT
  *
  FROM
  cargo
 ");
  ?>

    <a href="registro_cargo.php" class="btn btn-primary btn-rounded mb-2"><i class="fa-solid fa-plus"></i> &nbsp;Registrar</a>

  <table class="table table-bordered table-hover col-12" id="example">
    <thead>
      <tr>
        <!-- <th scope="col-5">ID</th> -->
        <th scope="col-5">NOMBRE</th>
        <th scope="col-5">ENTRADA AM</th>
        <th scope="col-5">SALIDA AM</th>
        <th scope="col-5">HAB. AM</th>
        <th scope="col-5">LIM. SAL. AM</th>
        <th scope="col-5">HAB. PM</th>
        <th scope="col-5">ENTRADA PM</th>
        <th scope="col-5">SALIDA PM</th>
        <th scope="col-5">LIM. SAL. PM</th>
        <th scope="col-5">MIN TOLERANCIA</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($datos = $sql->fetch_object()) { ?>
      <tr>
        <!-- <td>< ?= $datos->id_cargo ?></td> -->
        <td><?= $datos->nombre ?></td>
        <td><?= $datos->hora_entrada_am ?></td>
        <td><?= $datos->hora_salida_am ?></td>
        <td><?= $datos->habilitar_am ?></td>
        <td><?= $datos->limite_salam ?></td>
        <td><?= $datos->habilitar_pm ?></td>
        <td><?= $datos->hora_entrada_pm ?></td>
        <td><?= $datos->hora_salida_pm ?></td>
        <td><?= $datos->limite_salpm ?></td>
        <td><?= $datos->tolerancia ?></td>


        <td>
          <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->id_cargo ?>" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
          <a href="cargo.php?id=<?= $datos->id_cargo?>" onclick="advertencia(event)" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
        </td>
      </tr>

<!-- Modal -->
<div class="modal fade" id="exampleModal<?= $datos->id_cargo ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title w-100" id="exampleModalLabel">Modificar Cargo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="POST">
      <div hidden class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="ID" class="input input__text" name="txtid" value="<?= $datos->id_cargo ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Nombre" class="input input__text" name="txtnombre" value="<?= $datos->nombre ?>">
      </div>
      


      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Entrada AM" class="input input__text" name="txtentrada_am" value="<?= $datos-> hora_entrada_am ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Salida AM" class="input input__text" name="txtsalida_am" value="<?= $datos-> hora_salida_am ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Hora Habilitar" class="input input__text" name="txthabilitar" value="<?= $datos-> habilitar_am ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Limite Salida" class="input input__text" name="txtlimiteam" value="<?= $datos-> limite_salam ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Habilitar PM" class="input input__text" name="txthabilitarpm" value="<?= $datos-> habilitar_pm ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Entrada PM" class="input input__text" name="txtentrada_pm" value="<?= $datos-> hora_entrada_pm ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Salida PM" class="input input__text" name="txtsalida_pm" value="<?= $datos-> hora_salida_pm ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Limite Salida" class="input input__text" name="txtlimitepm" value="<?= $datos-> limite_salpm ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Min Tolerancia" class="input input__text" name="txttolerancia" value="<?= $datos-> tolerancia ?>">
      </div>

      
      <div class="text-right p-2">
        <a href="cargo.php" class="btn btn-secondary btn-rounded">Atras</a>
        <button type="submit" value="ok" name="btnmodificar" class="btn btn-primary btn-rounded">Modificar</button>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>
      <?php }
      ?>

    </tbody>
  </table>
</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>