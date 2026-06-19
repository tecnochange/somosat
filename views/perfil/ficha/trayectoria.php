<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

<?php

	$hoy = date("Y-m-d H:i:s");

    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    if($_POST["guardar_adicional"] != ""){

        if($_POST["id_informacion"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Trayectoria SET 
                cargo = '".$_POST["cargo"]."', 
                fecha_inicia = '".$_POST["fecha_inicia"]."', 
                fecha_fin = '".$_POST["fecha_fin"]."', 
                vigente = '".$_POST["vigente"]."',
                resumen = '".$_POST["resumen"]."'  
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            mysqli_query($connect_valentina, $sentencia_adicional);
            
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Trayectoria (
                id_empleado, 
                documento, 
                cargo,
                fecha_inicia, 
                fecha_fin, 
                vigente,
                resumen, 
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_user"]."',  
                0,
                '".$_POST["cargo"]."',
                '".$_POST["fecha_inicia"]."', 
                '".$_POST["fecha_fin"]."', 
                '".$_POST["vigente"]."', 
                '".$_POST["resumen"]."', 
                '".$hoy."'
            );
            ";

            mysqli_query($connect_valentina, $sentencia_adicional); 
            print_r($sentencia_adicional);
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
	}
	
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_user"]."' ");
	$data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$_SESSION["id_user"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id = '".$_GET["tra"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);
?>



<div class="container"> 

    <?php echo $respuesta; ?>
    
	<!-- PESTAÑAS -->
    <!-- PESTAÑAS -->
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos" class="nav-link ">Básicos</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/adicionales" class="nav-link ">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/perfil" class="nav-link">Bienestar</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/preferencia" class="nav-link">RSE</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/academico" class="nav-link ">Académico</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/laboral" class="nav-link ">Experiencia Laboral</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/trayectoria" class="nav-link active">Trayectoria en AT</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/familiares" class="nav-link">Familiares</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/emergencia" class="nav-link">En Caso de Emergencia</a>
            </li>
    </ul>

    <!-- LISTADO -->
    <div class="card">
        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Cargo</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Vigente</th>
                    <th>Resumen</th>
                    
                </tr>
                <?php 
                $querytrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria 
                WHERE id_empleado = '".$_SESSION["id_user"]."' ORDER BY fecha_inicia DESC  ");
	            while($datatrayectoria = mysqli_fetch_array($querytrayectoria)){
                    echo '
                    <tr>
                        <td>'.$datatrayectoria["cargo"].'</td>
                        <td>'.$datatrayectoria["fecha_inicia"].'</td>
                        <td>'.$datatrayectoria["fecha_fin"].'</td>
                        <td>'.$datatrayectoria["vigente"].'</td>
                        <td>'.$datatrayectoria["resumen"].'</td>
                        
                    </tr>
                    ';   
                }	
                ?>
            </table>
            
        </div>
    </div>
    
    
</div>




<script>
	var api = '<?php echo $url; ?>/api/administrar/';

	function Eliminar_Trayectoria(id_registro){
		jQuery.ajax({
			url: api+"eliminar_trayectoria.php",
			type:'post',
			data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=perfil/ficha/trayectoria"},
			}).done(function (resp){
				$("#xscript").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
		);
	}

</script>



