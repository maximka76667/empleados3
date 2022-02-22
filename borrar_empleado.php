<?php

    extract($_GET);
    
    $connection = mysqli_connect('localhost', 'root', 'root', 'empresa') or die("Error: " . mysqli_connect_error());
    
    $query = "DELETE FROM `empleados` WHERE `num_empleado` = $num";
    
    $result = mysqli_query($connection, $query) or die ("La inserción ha fallado, causa: " . mysqli_error($connection));
    
    header("location:index.php");
?>