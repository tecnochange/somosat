
<!-- Escala -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div><b>ESCALA DE VALORACION A UTILIZAR</b></div>
        <div style="margin-bottom: 15px">Para valorar cada uno de los comportamientos de las competencias utilice la siguiente escala; léala detenidamente antes de comenzar la valoración.</div>

        <?php
            $queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = 1 ");
	        $dataEscala = mysqli_fetch_array($queryEscala);
        ?>

        <table width="100%">
        
            <tr>
                <td width="25%" bgcolor="#FF7173" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    1
                </td>
                <td width="25%" bgcolor=" #FFC03A" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    2
                </td>
                <td width="25%" bgcolor=" #2ADAFF" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    3
                </td>
                <td width="25%" bgcolor=" #B5FF87" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    4
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" >
                    <b><?php echo $dataEscala["nombre_n_1"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_1"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_2"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_2"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_3"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_3"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_4"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_4"]; ?>
                </td>
            </tr>
        </table>
        
        
    </div>

</div>
