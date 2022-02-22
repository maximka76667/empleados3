<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link rel="stylesheet" href="style.css">
    <script language="JavaScript">
        function confirmar_borrado(num_empleado){
            if (confirm(`¿Está seguro que desea borrar el empleado: ${num_empleado}?`)){
                window.location = `borrar_empleado.php?num=${num_empleado}`;
            }
        }
    </script>
</head>
<body>
    <form>
        <input type="text" name="nombre" placeholder="Nombre" />
        <select name="puesto">
            <option value=""></option>
            <option value="administrativo">Administrativo</option>
            <option value="comercial">Comercial</option>
            <option value="manager">Manager</option>
            <option value="analista">Analista</option>
        </select>
        <button type="submit">Buscar</button>
        <button type="reset">Limpiar</button>
    </form>

    <table>
         <tr>
            <td></td>
            <td>Número empleado</td>
            <td>Nombre empleado</td>
            <td>Puesto</td>
            <td>Salario</td>
            <td>Nombre departamento</td>
        </tr>
    <?php
        extract($_GET);

        // Name's condition
        if(!isset($nombre) || strlen($nombre) === 0) {
            $condition_nombre = '';
            $nombre = '';
        } else {
            $condition_nombre = "empleados.nombre_empleado = '$nombre'";
        }

        // Position's condition
        if(!isset($puesto) || strlen($puesto) === 0) {
            $condition_puesto = '';
            $puesto = '';
        } else {
            $condition_puesto = "empleados.puesto = '$puesto'";
        }

        // Final condition
        if(strlen($condition_nombre) === 0 && strlen($condition_puesto) === 0) {
            $condition_final = '';
        } else if(strlen($condition_nombre) !== 0 && strlen($condition_puesto) !== 0) {
            $condition_final = "AND $condition_nombre AND $condition_puesto";
        } else if(strlen($condition_nombre) !== 0 && strlen($condition_puesto) === 0) {
            $condition_final = "AND $condition_nombre";
        } else {
            $condition_final = "AND $condition_puesto";
        }

        $connection = mysqli_connect('localhost', 'root', 'root', 'empresa') or die("Error: " . mysqli_connect_error());
            $select = "SELECT `num_empleado`, `nombre_empleado`, `puesto`, `salario`, `nombre`
            FROM `empleados`, `departamentos`
            WHERE `nombre` IN(
                SELECT `nombre`
                FROM `departamentos`
                WHERE `departamentos`.`num_departamento` = `empleados`.`num_departamento`
            ) $condition_final";

            $result = mysqli_query($connection, $select) or die ("La inserción ha fallado, causa: " . mysqli_error($connection));

            if($result) {
                $total = mysqli_num_rows($result);
                
            while($row = mysqli_fetch_array($result)) {
                echo "<tr>
                <td>" . "<a href='#' title='Borrar Empleado'
                onclick='confirmar_borrado(" . $row['num_empleado'] . ");return false;'>
                <img class='table__delete-button' src='delete.png' alt='Borrar' >
               </a>" . "</td>
                <td>" . $row['num_empleado'] . "</td>
                <td>" . $row['nombre_empleado'] . "</td>
                <td>" . $row['puesto'] . "</td>
                <td>" . $row['salario'] . "</td>
                <td>" . $row['nombre'] . "</td>
                </tr>";
            }
            echo "</table>";
                if(strlen($nombre) !== 0 || strlen($puesto) !== 0) {
                    echo '<p>Total: ' . $total . '</p>';
                }
            } else {
                $total = 0;
              echo "Error al lanzar la consulta: $select : " . mysqli_error($connection);
            }
    ?>
</body>
</html>