<?php
session_start();
session_destroy();
header("location:/asis_web2/vista/login/login.php");
?>