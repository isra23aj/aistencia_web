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

  <h4 class="text-center text-secondary">LISTA DE ASIGNACIÓN HORARIO PASANTIAS</h4>

  <?php
  include "../modelo/conexion.php";
  include "../controlador/controlador_modificar_asig_pasantia.php";
  include "../controlador/controlador_eliminar_asig_pasantia.php";


  $sql = $conexion->query("SELECT
  asig_pasantia.id_asig_pasantia,
  asig_pasantia.empleado ,
  asig_pasantia.area,
  asig_pasantia.continuo_adm,
  empleado.nombre 'nom_empleado',
  empleado.apellido,
  area.nombre as 'nom_area',
  continuo_adm.nombre as 'nom_continuo_adm'
  FROM
  asig_pasantia
  INNER JOIN empleado ON asig_pasantia.empleado = empleado.id_empleado
  INNER JOIN area ON asig_pasantia.area = area.id_area AND empleado.area = area.id_area
  INNER JOIN continuo_adm ON continuo_adm.area = area.id_area AND asig_pasantia.continuo_adm = continuo_adm.id_continuo_adm");
  ?>

    <a href="registro_asig_pasantia.php" class="btn btn-primary btn-rounded mb-2"><i class="fa-solid fa-plus"></i> &nbsp;Registrar</a>

  <table class="table table-bordered table-hover col-12" id="example">
    <thead>
      <tr>
        <th scope="col">NOMBRE</th>
        <th scope="col">AREA</th>
        <th scope="col">HORARIO</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($datos = $sql->fetch_object()) { ?>
      <tr>
      <td><?= $datos->nom_empleado . " " . $datos->apellido ?></td>
        <td><?= $datos->nom_area ?></td>
        <td><?= $datos->nom_continuo_adm ?></td>
        <td>
          <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->id_asig_pasantia ?>" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
          <a href="asig_pasantia.php?id=<?= $datos->id_asig_pasantia?>" onclick="advertencia(event)" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
        </td>
      </tr>

<!-- Modal -->
<div class="modal fade" id="exampleModal<?= $datos->id_asig_pasantia ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title w-100" id="exampleModalLabel">Asignar Horarios Pasantias</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="POST">
      <div hidden class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="ID" class="input input__text" name="txtid" value="<?= $datos->id_asig_pasantia ?>">
      </div>
      
      <div class="fl-flex-label mb-4 px-2 col-12">
        <select name="txtnombre" class="input input__select">
            <?php
              $sql2 = $conexion->query("SELECT * from empleado where area=2 or cargo=14");
              while ($datos2 = $sql2->fetch_object()){?>
                <option <?= $datos->nom_empleado == $datos2-> id_empleado  ? 'selected':'' ?> value="<?= $datos2->id_empleado ?>"><?= $datos2-> nombre ?></option>
            <?php }
            ?>
        </select>
      </div>
      
     
      <div class="fl-flex-label mb-4 px-2 col-12">
        <select name="txtarea" class="input input__select">
            <?php
              $sql3 = $conexion->query("SELECT * from area");
              while ($datos3 = $sql3->fetch_object()){?>
                <option <?= $datos->area == $datos3-> id_area ? 'selected':'' ?> value="<?= $datos3->id_area ?>"><?= $datos3-> nombre ?></option>
            <?php }
            ?>
        </select>
      </div>
      
      <div class="fl-flex-label mb-4 px-2 col-12">
        <select name="txtcontinuo_adm" class="input input__select">
            <?php
              $sql3 = $conexion->query("SELECT * from continuo_adm");
              while ($datos3 = $sql3->fetch_object()){?>
                <option <?= $datos->continuo_adm == $datos3-> id_continuo_adm ? 'selected':'' ?> value="<?= $datos3->id_continuo_adm ?>"><?= $datos3-> nombre ?></option>
            <?php }
            ?>
        </select>
      </div>

      <div class="text-right p-2">
        <a href="asig_pasantia.php" class="btn btn-secondary btn-rounded">Atras</a>
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