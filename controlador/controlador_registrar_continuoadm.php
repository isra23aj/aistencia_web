<?php

if (!empty($_POST["btnregistrar"])){
    if (!empty($_POST["txtentrada"]) and !empty($_POST["txtsalida"])
    and !empty($_POST["txttolerancia"]) and !empty($_POST["txthabilitar"]) and !empty($_POST["txtarea"])
    ) {
        //$nombre=$_POST["txtnombre"];
        $nombre=$_POST["txtnombre"];
        $entrada=$_POST["txtentrada"];
        $salida=$_POST["txtsalida"];
        $habilitar=$_POST["txthabilitar"];
        $limite=$_POST["txtlimite"];
        $tolerancia=$_POST["txttolerancia"]; 
        $area=$_POST["txtarea"];
        //$id=$_POST["txtid"];
        
        //$empleado=$_POST["txtempleado"];
        
        
        $verificarNombre=$conexion->query("select count(*) as 'total' from continuo_adm where nombre='$nombre'");
        if ($verificarNombre->fetch_object()->total > 0) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Error",
                    type: "error",
                    text: "El horario ya existe",
                    styling: "bootstrap3"
                })
            })
        </script>
        <?php } else {
        $sql = $conexion->query(" insert into continuo_adm(nombre,entrada,salida,habilitar,limite,tolerancia,area) 
                                values('$nombre','$entrada','$salida','$habilitar','$limite',$tolerancia,$area) ");
            if ($sql==true) {?>
            <script>
            $(function notificacion() {
                new PNotify({
                    title: "Correcto",
                    type: "success",
                    text: "El horario se registró correctamente",
                    styling: "bootstrap3"
                })
            })
        </script>
                <?php } else {?>
                    <script>
                    $(function notificacion() {
                        new PNotify({
                            title: "Incorrecto",
                            type: "error",
                            text: "Error al registrar parametro",
                            styling: "bootstrap3"
                        })
                    })
                </script>
                
            <?php }
    }
        
} else {?>
        <script>
    $(function notificacion() {
        new PNotify({
            title: "Error",
            type: "error",
            text: "El campo está vacío",
            styling: "bootstrap3"
        })
    })
</script>
    <?php }?>
    
    <script>
    //Esto es para que ya no mande alerta de volver a ingresar (duplicado) cuando se recarga la pagina
    setTimeout(() => {
        window.history.replaceState(null,null,window.location.pathname);
    }, 0);
</script>

<?php }
