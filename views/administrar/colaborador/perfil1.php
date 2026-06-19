<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

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
            UPDATE Empleados_Perfiles SET 
                eps = '".$_POST["eps"]."',  
                afp = '".$_POST["afp"]."', 
                emergencia = '".$_POST["emergencia"]."', 
                car_salud = '".$_POST["car_salud"]."',
                apt_fisica = '".$_POST["apt_fisica"]."',
                patologias = '".implode(";", $_POST["patologias"])."',
                alergias = '".$_POST["alergias"]."', 
                formula_optica = '".$_POST["formula_optica"]."', 
                audifonos = '".$_POST["audifonos"]."', 
                otros = '".$_POST["otros"]."', 
                comensal = '".implode(";", $_POST["comensal"])."',
                restriccion = '".$_POST["restriccion"]."',
                fumas = '".$_POST["fumas"]."', 
                deportes = '".implode(";", $_POST["deportes"])."',
                frecuencia = '".$_POST["frecuencia"]."',
                hobbies = '".implode(";", $_POST["hobbies"])."',  
                comentario_tl = '".$_POST["comentario_tl"]."', 
                distancia = '".$_POST["distancia"]."',
                vehiculo_propio = '".$_POST["vehiculo_propio"]."',
                desplazamiento = '".$_POST["desplazamiento"]."',
                licencia_conduccion = '".$_POST["licencia_conduccion"]."',
                fecha_libreta = '".$_POST["fecha_libreta"]."',
                matricula = '".$_POST["matricula"]."',
                update_at = '".$hoy."'
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            
            
            //print_r($sentencia_adicional);
            
            mysqli_query($connect_valentina, $sentencia_adicional);
            

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Perfiles (
                id_empleado,
                eps, 
                afp, 
                emergencia, 
                car_salud, 
                apt_fisica,
                patologias, 
                alergias, 
                formula_optica, 
                audifonos, 
                otros, 
                comensal,
                restriccion,
                fumas,
                deportes,
                frecuencia,
                hobbies,
                comentario_tl,
                distancia,
                vehiculo_propio,
                desplazamiento,
                licencia_conduccion,
                fecha_libreta,
                matricula,
                created_at,
                update_at
            ) 
            VALUES
            (
               '".$_SESSION["id_colaborador_edit"]."',
               '".$_POST["eps"]."', 
               '".$_POST["afp"]."', 
               '".$_POST["emergencia"]."',
               '".$_POST["car_salud"]."',
               '".$_POST["apt_fisica"]."',
               '".implode(";", $_POST["patologias"])."',
               '".$_POST["alergias"]."', 
               '".$_POST["formula_optica"]."',
               '".$_POST["audifonos"]."', 
               '".$_POST["otros"]."', 
               '".implode(";", $_POST["comensal"])."', 
               '".$_POST["restriccion"]."', 
               '".$_POST["fumas"]."', 
               '".implode(";", $_POST["deportes"])."', 
               '".$_POST["frecuencia"]."',
               '".implode(";", $_POST["hobbies"])."', 
               '".$_POST["comentario_tl"]."',
               '".$_POST["distancia"]."',
               '".$_POST["vehiculo_propio"]."',
               '".$_POST["desplazamiento"]."',
               '".$_POST["licencia_conduccion"]."',
               '".$_POST["fecha_libreta"]."',
               '".$_POST["matricula"]."',
               '".$hoy."', 
               '".$hoy."'        
            )
            ";
            
          
            print_r($sentencia_adicional);
            
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

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $checked = "";
    if( $dataInforma["acepto"] == 'on'){ $checked = "checked"; }

    $fecha_actual = date("Y-m-d");
    $fecha_car = $dataInforma["car_salud"];
    $fecha_apt = $dataInforma["apt_fisica"];
    $fecha_lib = $dataInforma["fecha_libreta"];
    

        function dias_vencer($fecha_actual,$fecha_car,$fecha_apt,$fecha_lib){
        $dias_car = (strtotime($fecha_car)-strtotime($fecha_actual))/86400;
        $dias_car = abs($dias_car); 
        $dias_car = floor($dias_car);
            
        $dias_apt = (strtotime($fecha_apt)-strtotime($fecha_actual))/86400;
        $dias_apt = abs($dias_apt); 
        $dias_apt = floor($dias_apt);
            
        $dias_lib = (strtotime($fecha_lib)-strtotime($fecha_actual))/86400;
        $dias_lib = abs($dias_lib); 
        $dias_lib = floor($dias_lib);
        
            
        if($dias_car < 15){
            echo('<div class="alert alert-danger" role="alert">
                faltan '.$dias_car.' dias para vencer su carné de salud.
                </div>');
        };
        if($dias_apt < 15){
            echo('<div class="alert alert-danger" role="alert">
                    faltan '.$dias_apt.' dias para vencer su carné de aptitud física.
                </div>');
        };
        if($dias_lib < 15){
            echo('<div class="alert alert-danger" role="alert">
                    faltan '.$dias_lib.' dias para vencer su libreta de conducir.
                </div>');
        };
            
    };
    echo dias_vencer( $fecha_actual, $fecha_car,$fecha_apt,$fecha_lib );

  
    //$intervalo = $fecha_vencimiento->diff($fecha_vencimiento);
    //echo $intervalo->days . 'dias';
    //print_r($fecha_actual );
    //print_r($fecha_vencimiento);
    //print_r($intervalo);
//    print_r(dias_vencer());
    

?>



<div class="container-fluid"> 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Colaboradores</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
      </ol>
    </nav>
    
    <?php echo $respuesta; ?>

    <div class="card">
        
        <!-- PESTAÑAS -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/editar" class="nav-link ">Básicos</a>
            </li>
            <?php if($_SESSION["id_colaborador_edit"]){ ?>

            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link active">Bienestar</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link">RSE</a>
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
            <?php } ?>
        </ul>
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">
<!-- salud -->
                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 30px">
                    <h2>Salud:</h2>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label for="lastName"><b>Prestador de Salud:</b></label>
                    <select class="form-control" name="eps" >
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Mutualistas as $tipo){  
                            if($tipo[1] == $dataInforma["eps"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label for="lastName"><b>Emergencia Médica :</b></label>
                    <select class="form-control" name="afp">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Emergencia_medica as $tipo){  
                            if($tipo[1] == $dataInforma["afp"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label><b>Teléfono de Emergencia Móvil:</b></label>
                    <input type="text" class="form-control" name="emergencia" value="<?php echo $dataInforma["emergencia"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label><b>Fecha de Vencimiento Carné de Salud</b></label>
                    <input type="date" class="form-control" name="car_salud" value="<?php echo $dataInforma["car_salud"]; ?>">
                </div>
                
                            
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label><b>Fecha de Vencimiento Aptitud Física</b></label>
                    <input type="date" class="form-control" name="apt_fisica" value="<?php echo $dataInforma["apt_fisica"]; ?>">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>Patologías de Base</b></label>
                    <div class="row">
                        <?php
                        $datos_array = explode(";", $dataInforma["patologias"]);
                        foreach($Array_Patologia as $tipo){  
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
                                    <td>
                                        '.$tipo[1].'
                                    </td>
                                    <td align="center" width="50">
                                        <input type="checkbox" name="patologias[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
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
                    <label><b>Si Tu Respuesta Anterior Fue Alergias u Otros, Por Favor Especifica a Que Cosas</b></label><br>
                    <input type="text"  class="form-control" name="alergias" value="<?php echo $dataInforma["alergias"]; ?>">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿Usas Lentes?</b></label>
                    <select class="form-control" name="formula_optica">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Si_No as $role){  
                            if($role[1] == $dataInforma["formula_optica"]){
                                echo '<option value="'.$role[1].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[1].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿Usas Audífonos?</b></label>
                    <select class="form-control" name="audifonos">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Si_No as $role){  
                            if($role[1] == $dataInforma["audifonos"]){
                                echo '<option value="'.$role[1].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[1].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>Otros</b></label>
                    <textarea class="form-control" name="otros" value="<?php echo $dataInforma["otros"]; ?>"></textarea>
                </div>
                                                                                                            
<!-- alimentacion -->   
                                                                                                            
                <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px">
                    <h2>Alimentación:</h2>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; ">
                    <label><b>¿Qué Tipo de Alimentación Tiene?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["comensal"]);
                        foreach($Array_Tipo_Comensal as $tipo){  
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
                                        <input type="checkbox" name="comensal[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
                                    </td>
                                </tr>
                            </table>
                            </div>
                            ';
                        }
                    ?>
                    </div>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿Tenes Alguna Restricción Con La Comida?</b></label>
                    <input type="text" class="form-control" name="restriccion" value="<?php echo $dataInforma["restriccion"]; ?>">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿Fumas?</b></label>
                    <select class="form-control" name="fumas">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_fumas as $tipo){  
                            if($tipo[0] == $dataInforma["fumas"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
  <!-- deporte -->               
                <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px">
                    <h2>Deporte:</h2>
                </div> 
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Practicas Algún Deporte?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["deportes"]);
                        foreach($Array_Deporte_Hace as $tipo){  
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
                                        <input type="checkbox" name="deportes[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
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
                    <label><b>Si Practicas Algún Deporte ¿Con Qué Frecuencia Lo Realizas?</b></label>
                    <select class="form-control" name="frecuencia">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_frecuencia as $tipo){  
                            if($tipo[0] == $dataInforma["frecuencia"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
<!-- tiempo libre -->               
                <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px">
                    <h2>Tiempo Libre:</h2>
                </div> 
                
                <div class="col-md-12" style="margin-bottom: 10px; ">
                    <label><b>¿Qué Hobbies Tienes?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["hobbies"]);
                        foreach($Array_Hobiees as $tipo){  
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
                                        <input type="checkbox" name="hobbies[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
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
                    <label>Si Tu Respuesta Anterior Fue Otras Cosas, Por Favor Especifica a Que Cosas</label>
                    <input type="text" class="form-control" name="comentario_tl" value="<?php echo $dataInforma["comentario_tl"]; ?>">
                </div>
                
<!-- movilidad -->               
                <div class="col-md-12" style="margin-top: 30px; margin-bottom: 30px">
                    <h2>Movilidad:</h2>
                </div> 
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿A Qué Distancia Vives Del Trabajo?</b></label>
                    <select class="form-control" name="distancia">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Distancia as $role){  
                            if($role[1] == $dataInforma["distancia"]){
                                echo '<option value="'.$role[1].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[1].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿En Qué Soles Venir a Trabajar?</b></label>
                    <select class="form-control" name="vehiculo_propio">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Vehiculo_Propio as $role){  
                            if($role[1] == $dataInforma["vehiculo_propio"]){
                                echo '<option value="'.$role[1].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[1].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>¿Cuánto Demoras en Llegar al Trabajo?</b></label>
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
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>Libreta de Conducir:</b></label>
                    <input type="text" class="form-control" name="licencia_conduccion" value="<?php echo $dataInforma["licencia_conduccion"]; ?>">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label><b>Fecha de Vencimiento Libreta de Conducir:</b></label>
                    <input type="date" class="form-control" name="fecha_libreta" value="<?php echo $dataInforma["fecha_libreta"]; ?>">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 50px">
                    <label><b>Matricula de Vehículo:</b></label>
                    <input type="text" class="form-control" name="matricula" value="<?php echo $dataInforma["matricula"]; ?>">
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



