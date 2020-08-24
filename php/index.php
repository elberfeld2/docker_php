<?php
    function consulta($cuerpo){

        $con = mysqli_connect("dmysql:3306", "user", "1234","base");
        $query = "select * from clientes";
        $suma = 0;

        if($con){
            $result = mysqli_query($con, $query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $cuerpo($row);
                    $suma += $row["edad"];
                }
            }
        }   
        
        return $suma;
    }    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>
<style>
   body{
       margin:40px;
   }
   td,h2{
       text-align:center;
   }
   .right{
       text-align:right;
   }
</style>
<body>
    <h2>Clientes</h2>
    <br>
    <table width="100%">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Edad</th>
    </tr>
    <?php
        $suma = consulta(function($row){
            ?>      
                    <tr>
                        <td><?=$row["nif"]?>°</td>
                        <td><?=$row["nombre"]?></td>
                        <td><?=$row["apellidos"]?></td>
                        <td><?=$row["telefono"]?></td>
                        <td><?=$row["edad"]?></td>
                    </tr>
            <?php
    
        })
    ?>
    <tr>
        <th colspan="5">&nbsp;</th>
    </tr>
    <tr>
        <th colspan="4" class="right">Suma de edades</th>
        <td><?=$suma?></td>
    </tr>    
    </table>    
</body>
</html>

