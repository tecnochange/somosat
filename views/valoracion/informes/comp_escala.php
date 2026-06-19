<?php
	$queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = 1 ");
	$dataEscala = mysqli_fetch_array($queryEscala);
?>


<div style="background-color: #e0e0e0; border: 1px solid #d4d4d4; margin-bottom: 20px;">
    <table width="100%">
            <tr>
                <td width="25%" bgcolor="#FF7173" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                    0,1 a 1,69
                </td>
                <td width="25%" bgcolor=" #FFC03A" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                    1,7 a 2,69
                </td>
                <td width="25%" bgcolor=" #2ADAFF" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                    2,7 a 3,69
                </td>
                <td width="25%" bgcolor=" #B5FF87" align="center" style="font-size: 12px; padding: 5px; font-weight: bold">
                    3,7 a 4
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
		
		
		
            <tr style="display: none">
                <td align="center" valign="top" style=" padding: 10px; padding-top: 15px; border-right: 1px solid #bbbbbb;" >
                    <b>Insatisfactoria</b><br>
                    El colaborador muestra un nivel muy básico de desarrollo en la competencia/comportamiento y debe mejorar en el desarrollo de la misma de manera dedicada y constante
                </td>
                <td align="center" valign="top" style=" padding: 10px; padding-top: 15px; border-right: 1px solid #bbbbbb;">
                    <b>Marginal/Insuficiente</b><br>
                    El colaborador muestra un nivel medio en el nivel de desarrollo de la competencia/comportamiento y es importante que trabaje en llevar este nivel a uno superior para crecer personal y profesionalmente
                </td>
                <td align="center" valign="top" style=" padding: 10px; padding-top: 15px; border-right: 1px solid #bbbbbb;">
                    <b>Satisfactorio</b><br>
                    El colaborador muestra un nivel de desarrollo aceptable en la competencia/comportamiento; sin embargo debe trabajar un poco más en mejorar el desarrollo de las mismas para crecer personal y profesionalmente
                </td>
                <td align="center" valign="top" style=" padding: 10px; padding-top: 15px">
                    <b>Supera expectativas</b><br>
                    El colaborador muestra un nivel superior de desarrollo en la competencia/comportamiento, debe seguir manteniendo este nivel, lo que le permitirá ser un colaborador destacado para la Organización
                </td>
            </tr>
        </table> 
</div>
