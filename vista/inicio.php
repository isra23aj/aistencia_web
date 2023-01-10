<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:login/login.php');
}

?>

<style>
  ul li:nth-child(5) .activo{
    background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

  <h4 class="text-center text-secondary">ASISTENCIA DE EMPLEADOS</h4>

  <?php
  include "../modelo/conexion.php";
  include "../controlador/controlador_eliminar_asistencia.php";


  $sql = $conexion->query("SELECT
    asistencia.id_asistencia,
    asistencia.id_empleado,
    asistencia.entrada,
    asistencia.salida,
    asistencia.entrada_pm,
    asistencia.salida_pm,
    empleado.id_empleado,
    empleado.nombre as 'nom_empleado',
    empleado.apellido,
    empleado.dni,
    empleado.cargo,
    cargo.id_cargo,
    cargo.nombre as 'nom_cargo'
    FROM
    asistencia
    INNER JOIN empleado ON asistencia.id_empleado = empleado.id_empleado
    INNER JOIN cargo ON empleado.cargo = cargo.id_cargo");
  ?>

<div class="text-right mb-2">
  <a href="fpdf/ReporteAsistencia.php" target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i>Generar Reportes</a>
</div>
<div class="text-right mb-2">
  <a href="reporte_asistencia.php" class="btn btn-primary"><i class="fas fa-plus"></i></i>Más Reportes</a>
</div>

  <table class="table table-bordered table-hover col-12" id="example">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">EMPLEADO</th>
        <!-- <th scope="col">DNI</th> -->
        <th scope="col">CARGO</th>
        <th scope="col">ENTRADA AM</th>
        <th scope="col">SALIDA AM</th>
        <th scope="col">ENTRADA PM</th>
        <th scope="col">SALIDA PM</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($datos = $sql->fetch_object()) { ?>
      <tr>
        <td><?= $datos->id_asistencia ?></td>
        <td><?= $datos->nom_empleado . " " . $datos->apellido ?></td>
        <!-- <td>  <?= $datos->dni ?></td> -->
        <td><?= $datos->nom_cargo ?></td>
        <td><?= $datos->entrada ?></td>
        <td><?= $datos->salida ?></td>
        <td><?= $datos->entrada_pm ?></td>
        <td><?= $datos->salida_pm ?></td>
        <td>
          <a href="inicio.php?id=<?= $datos->id_asistencia?>" onclick="advertencia(event)" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
        </td>
      </tr>

      <?php }
      ?>

    </tbody>
  </table>
</div>
</div>
<!-- fin del contenido principal -->


<!-- por ultimo se carga el footer -->
<?php require('./layout/footer.php'); ?>