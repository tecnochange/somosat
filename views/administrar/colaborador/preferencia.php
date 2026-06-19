<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  >= 3){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<style>
    .form-control{
        text-transform: uppercase;
    }
</style>

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
            UPDATE Empleados_Preferencias SET 
                en_casa = '".$_POST["en_casa"]."',  
                musica = '".implode(";", $_POST["musica"])."',  
                internet = '".implode(";", $_POST["internet"])."',  
                amigos = '".implode(";", $_POST["amigos"])."',   
                red_social = '".implode(";", $_POST["red_social"])."',   
                deportes = '".implode(";", $_POST["deportes"])."',    
                hobbies = '".implode(";", $_POST["hobbies"])."',  
                comensal = '".implode(";", $_POST["comensal"])."',
                frecuencia = '".$_POST["frecuencia"]."',
                sustancias = '".$_POST["sustancias"]."',
                bebidas = '".$_POST["bebidas"]."',
                fumas = '".$_POST["fumas"]."',
                enfermedad = '".$_POST["enfermedad"]."',
                cual = '".$_POST["cual"]."',
                transporte = '".implode(";", $_POST["transporte"])."',
                desplazamiento = '".$_POST["desplazamiento"]."',
                actividades = '".$_POST["actividades"]."',
                brigada = '".$_POST["brigada"]."',
                pertenecer = '".$_POST["pertenecer"]."',
                voluntariado = '".$_POST["voluntariado"]."',
                opciones_voluntariado = '".implode(";", $_POST["opciones_voluntariado"])."',
                apoyo = '".implode(";", $_POST["apoyo"])."',
                metas = '".$_POST["metas"]."',
                trabajar = '".$_POST["trabajar"]."',
                conocimiento = '".implode(";", $_POST["conocimiento"])."',
                destino = '".$_POST["destino"]."',
                tiempo_libre = '".implode(";", $_POST["tiempo_libre"])."',
                update_at = '".$hoy."'
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            
            //echo $sentencia;
            
            
            mysqli_query($connect_valentina, $sentencia_adicional);

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Preferencias (
                id_empleado,
                en_casa, 
                musica,
                internet,
                amigos,
                red_social,
                deportes,
                hobbies,
                comensal,
                frecuencia,
                sustancias,
                bebidas,
                fumas,
                enfermedad,
                cual,
                transporte,
                desplazamiento,
                actividades,
                brigada,
                pertenecer,
                voluntariado,
                opciones_voluntariado,
                apoyo,
                metas,
                trabajar,
                conocimiento,
                destino,
                tiempo_libre,
                created_at, 
                update_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                '".$_POST["en_casa"]."',  
                '".implode(";", $_POST["musica"])."', 
                '".implode(";", $_POST["internet"])."', 
                '".implode(";", $_POST["amigos"])."', 
                '".implode(";", $_POST["red_social"])."', 
                '".implode(";", $_POST["deportes"])."',  
                '".implode(";", $_POST["hobbies"])."', 
                '".implode(";", $_POST["comensal"])."',
                '".$_POST["frecuencia"]."',
                '".$_POST["sustancias"]."',
                '".$_POST["bebidas"]."',
                '".$_POST["fumas"]."',
                '".$_POST["enfermedad"]."',
                '".$_POST["cual"]."',
                '".implode(";", $_POST["transporte"])."',
                '".$_POST["desplazamiento"]."',
                '".$_POST["actividades"]."',
                '".$_POST["brigada"]."',
                '".$_POST["pertenecer"]."',
                '".$_POST["voluntariado"]."',
                '".implode(";", $_POST["opciones_voluntariado"])."',
                '".implode(";", $_POST["apoyo"])."',
                '".$_POST["metas"]."',
                '".$_POST["trabajar"]."',
                '".implode(";", $_POST["conocimiento"])."',
                '".$_POST["destino"]."',
                '".implode(";", $_POST["tiempo_libre"])."',
                '".$hoy."', 
                '".$hoy."'
            );
            ";
            
            //echo $sentencia;
            
            //print_r($sentencia_adicional);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
	}
	
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $checked = "";
    if( $dataInforma["acepto"] == 'on'){ $checked = "checked"; }

?>



<div class="container"> 
    
    <?php include("views/administrar/colaborador/navegacion.php"); ?>
    
    <?php echo $respuesta; ?>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle" class="nav-link ">Básicos</a>
		</li>
		<?php if($_SESSION["id_colaborador_edit"]){ ?>

		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link ">Datos Personales</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link">Bienestar</a>
		</li> 
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link active">RSE</a>
		</li> 
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/academico" class="nav-link ">Académico</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/laboral" class="nav-link ">Experiencia Laboral</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/trayectoria" class="nav-link">Trayectoria en AT</a>
		</li>
		<li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/familiares" class="nav-link">Familiares</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/emergencia" class="nav-link">En Caso de Emergencia</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/remuneracion" class="nav-link"> Remuneración</a>
		</li>
		<?php } ?>
	</ul>

    <div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Qué haces en tu tiempo libre?</b></label>
                    <input type="text"  class="form-control" name="en_casa" value="<?php echo $dataInforma["en_casa"]; ?>"></input>                    
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Qué género(s) de música te gustan más?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["musica"]);
                        foreach($Array_Generos_Musica as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd" >
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="musica[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Qué ves en internet?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["internet"]);
                        foreach($Array_Veo_Internet as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd" >
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="internet[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Qué hacen, cuando te reúnes con tus amigos?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["amigos"]);
                        foreach($Array_Reunion_Amigos as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd" >
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="amigos[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Qué red social usas con más frecuencia?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["red_social"]);
                        foreach($Array_Red_Social as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd" >
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="red_social[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                
                
                
                
        
<!-- esto se agrego nuevo -->     
                
                
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Que medio de transporte utilizas frecuentemente para desplazarte de tu casa al trabajo y viceversa? </b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["transporte"]);
                        foreach($Array_transporte as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd" >
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="transporte[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label><b>¿Cuánto tiempo (en minutos) demoras en el desplazamiento de tu casa al trabajo y viceversa? </b></label>
                    <select class="form-control" name="desplazamiento">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_desplazamiento as $tipo){  
                            if($tipo[0] == $dataInforma["desplazamiento"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px; display: none">
                    <label><b>¿Participas en las actividades que realiza seguridad y salud en el trabajo y bienestar? </b></label>
                    <select class="form-control" name="actividades">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_actividades as $tipo){  
                            if($tipo[0] == $dataInforma["actividades"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label><b>¿Hace parte de la brigada de emergencia? </b></label>
                    <select class="form-control" name="brigada">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_brigada as $tipo){  
                            if($tipo[0] == $dataInforma["brigada"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px; display: none">
                    <label><b>¿Te gustaría pertenecer a la brigada de emergencia? </b></label>
                    <select class="form-control" name="pertenecer">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_pertenecer as $tipo){  
                            if($tipo[0] == $dataInforma["pertenecer"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Te gustaría participar en las actividades de RSE que se promueven a través de involucrATe?</b></label>
                    <select class="form-control" name="voluntariado">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_voluntariado as $tipo){  
                            if($tipo[0] == $dataInforma["voluntariado"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b> ¿En cuál de las siguientes opciones de RSE te gustaría participar?
                    </b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["opciones_voluntariado"]);
                        foreach($Array_opciones_voluntariado as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="opciones_voluntariado[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Qué Tipo de Apoyo te Gustaría Prestar en las Actividades?</b></label>
                    <div class="row">                        
                        <?php
                        $datos_array = explode(";", $dataInforma["apoyo"]);
                        foreach($Array_apoyo as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="apoyo[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿"" cómo podría ayudarte para cumplir tus metas personales?</b></label><br>
                    <input type="text"  class="form-control" name="metas" value="<?php echo $dataInforma["metas"]; ?>"></input>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Cuál es el propósito que te conecta a trabajar con ""?</b></label><br>
                    <input type="text"  class="form-control" name="trabajar" value="<?php echo $dataInforma["trabajar"]; ?>"></input>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Estarías Dispuesto a Brindar Tus Conocimientos Académicos a Otros que lo Requieran?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["conocimiento"]);
                        foreach($Array_conocimiento as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="conocimiento[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Cuál es el destino internacional próximo a conocer?</b></label><br>
                    <input type="text"  class="form-control" name="destino" value="<?php echo $dataInforma["destino"]; ?>"></input>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; display: none">
                    <label><b>¿Qué actividades realiza en su tiempo libre?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["tiempo_libre"]);
                        foreach($Array_Tiempo_Libre as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                            echo '
                            <div class="col-md-4">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td >
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="tiempo_libre[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                

                <?php if($dtEmpleado["role"] == 1 || $_SESSION["id_colaborador_edit"] == $_SESSION['id_user_seleccion'] ){ ?>
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-primary btn-block " >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>
                <?php } ?>

            </div>
            </form>
        </div> 
        
    </div>
    
</div>

<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>

<script>
var api = '<?php echo $url; ?>/api/administrar/';

function Cargar_Posiciones(id_cargo){
	
	
	jQuery.ajax({
		url: api+"cargar_posiciones.php",
		type:'post',
		data: {id_cargo: id_cargo, id_posicion: <?php echo $id_posicion; ?>, url:""},
		}).done(function (resp){
			$("#id_posicion").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
	
}
//PARA CAMBIAR A MAYUSCULAS
    $(document).ready( function () {
        $("input").on("keypress", function () {
           $input=$(this);
           setTimeout(function () {
            $input.val($input.val().toUpperCase());
           },50);
        });
    });

</script>



