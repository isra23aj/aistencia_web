<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:login/login.php');
}

?>

<style>
  ul li:nth-child(7) .activo{
    background: rgb(11, 150, 214) !important;
    }
</style>

<!-- primero se carga el topbar -->
<?php require('./layout/topbar.php'); ?>
<!-- luego se carga el sidebar -->
<?php require('./layout/sidebar.php'); ?>

<!-- inicio del contenido principal -->
<div class="page-content">

  <h4 class="text-center text-secondary">LISTA DE PARAMETROS</h4>

  <?php
  include "../modelo/conexion.php";
  include "../controlador/controlador_modificar_parametroc.php";
  include "../controlador/controlador_eliminar_parametroc.php";


  $sql = $conexion->query("SELECT
parametroc.id_parametroc,
parametroc.nombre,
parametroc.entrada,
parametroc.salida,
parametroc.habilitar,
parametroc.limite,
parametroc.tolerancia,
parametroc.area,
parametroc.empleado,
area.nombre AS 'nom_area',
empleado.id_empleado,
empleado.nombre AS 'nom_empleado',
empleado.apellido
FROM
parametroc
INNER JOIN empleado ON parametroc.empleado = empleado.id_empleado
INNER JOIN area ON parametroc.area = area.id_area ");

  //$sqll = $conexion->query("SELECT * from parametroc");
    

  ?>

    <a href="registro_parametroc.php" class="btn btn-primary btn-rounded mb-2"><i class="fa-solid fa-plus"></i> &nbsp;Registrar</a>

  <table class="table table-bordered table-hover col-12" id="example">
    <thead>
      <tr>
        <th scope="col">NOMBRE</th>
        <th scope="col">ENTRADA</th>
        <th scope="col">SALIDA</th>
        <th scope="col">HABILITAR</th>
        <th scope="col">LIMITE</th>
        <th scope="col">TOLERANCIA</th>
        <th scope="col">AREA</th>
        <th scope="col">EMPLEADO</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      //while ($datos = $sql->fetch_object() and $datoss = $sqll->fetch_object()) { ? >
      while ($datos = $sql->fetch_object()) { ?>
      <tr>
        <td><?= $datos->nombre ?></td>
        <td><?= $datos->entrada ?></td>
        <td><?= $datos->salida ?></td>
        <td><?= $datos->habilitar ?></td>
        <td><?= $datos->limite ?></td>
        <td><?= $datos->tolerancia ?></td>
        <td><?= $datos->nom_area ?></td>
        <td><?= $datos->nom_empleado . " " . $datos->apellido ?></td>
        <td>
          <a href="" data-toggle="modal" data-target="#exampleModal<?= $datos->id_parametroc ?>" class="btn btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>
          <a href="parametroc.php?id=<?= $datos->id_parametroc?>" onclick="advertencia(event)" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i></a>
        </td>
      </tr>

<!-- Modal -->
<div class="modal fade" id="exampleModal<?= $datos->id_parametroc ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title w-100" id="exampleModalLabel">Modificar Parametro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="POST">
      <div hidden class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="ID" class="input input__text" name="txtid" value="<?= $datos->id_parametroc ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Nombre" class="input input__text" name="txtnombre" value="<?= $datos->nombre ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Entrada" class="input input__text" name="txtentrada" value="<?= $datos->entrada ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Salida" class="input input__text" name="txtsalida" value="<?= $datos->salida ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Habilitar" class="input input__text" name="txthabilitar" value="<?= $datos->habilitar ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Limite" class="input input__text" name="txtlimite" value="<?= $datos->limite ?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
        <input type="text" placeholder="Tolerancia" class="input input__text" name="txttolerancia" value="<?= $datos-> tolerancia?>">
      </div>
      <div class="fl-flex-label mb-4 px-2 col-12">
      <select name="txtarea" class="input input__select">
            <?php
              $sql2 = $conexion->query("SELECT * FROM area WHERE id_area <> 1");
              while ($datos2 = $sql2->fetch_object()){?>
                <option <?= $datos->nom_area == $datos2-> id_area ? 'selected':'' ?> value="<?= $datos2->id_area ?>"><?= $datos2-> nombre ?></option>
            <?php }
            ?>
        </select>
      </div>
      
       <div class="fl-flex-label mb-4 px-2 col-12">
        <select name="txtempleado" class="input input__select">
          <?php
              $sql3 = $conexion->query("SELECT
              empleado.id_empleado,
              empleado.nombre,
              empleado.apellido,
              cargo.nombre,
              area.nombre as 'nom_area',
              area.continuo
              FROM
              empleado
              INNER JOIN cargo ON empleado.cargo = cargo.id_cargo
              INNER JOIN area ON cargo.area = area.id_area
              
              where area.continuo= 'si' and area.nombre != 'administrativo'");
              while ($datos3 = $sql3->fetch_object()){?>
                <option <?= $datos->nom_empleado == $datos3-> id_empleado ? 'selected':'' ?> value="<?= $datos3->id_empleado ?>"><?= $datos3-> nombre." ".$datos3-> apellido  ?></option>
                <?php }
            ?>
        </select> 
      </div>
      


      <div class="text-right p-2">
        <a href="parametroc.php" class="btn btn-secondary btn-rounded">Atras</a>
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