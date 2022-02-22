<?php
 ob_start(); // Almacenamiento en memoria. Para poder hacer una llamada a la función header donde querramos.
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Empleado</title>
    <style>
        div {
            box-sizing: border-box;
        }
        #contenido {
            width:30rem;
            margin:0px auto;
            border:1px solid black;
        }
        h1 {
            text-align:center;
        }

        .col_izq {
            float:left;
            clear:both;
            width:40%;
            text-align:right;
            padding:0.5rem;
        }
        .col_der {
            float:left;
            width:50%;
            text-align:left;
            padding:0.5rem;
        }
        #botones {
            clear: both;
            text-align:center;
            padding:1rem;
        }
        input[name="numero_frm"] {
            background-color: #CDCDCD;
        }
    </style>
</head>

<body>
    <div id="contenido">
        <h1>Actualizar Empleado</h1>

        <form method="POST" action="">
            <div class="col_izq">Número:</div>  <div class="col_der"><input type="text" value="3344" name="numero_frm" readonly> </div>
            <div class="col_izq">Nombre:</div>  <div class="col_der"><input type="text" name="nombre_frm" > </div>
            <div class="col_izq">Puesto:</div>  <div class="col_der"><input type="text" name="puesto_frm" > </div>
            <div class="col_izq">Salario:</div> <div class="col_der"><input type="number" name="salario_frm" > </div>
            <div id="botones">
            <input type="submit" value="Actualizar" name="actualizar">
            <input type="submit" value="Cancelar" name="cancelar">
            </div>
        </form>

        <?php
            extract($_POST);

            if (isset($actualizar) && $actualizar!=null) {
                $connection = mysqli_connect('localhost', 'root', 'root', 'empresa') or die("Error: " . mysqli_connect_error());
                $query = "UPDATE FROM `empleados` WHERE `num_empleado` = $num";
                $result = mysqli_query($connection, $query) or die ("La inserción ha fallado, causa: " . mysqli_error($connection));
                header("location:index.php");
            } elseif (isset($cancelar) && $cancelar!=null) {
                header("location:index.php");
            }
        ?>
</div>
</body>

</html>

<?php
 ob_flush();
?>