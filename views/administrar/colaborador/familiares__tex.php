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
            UPDATE Empleados_Familiares SET 
                conyuge = '".$_POST["conyuge"]."',
                documento_conyuge = '".$_POST["documento_conyuge"]."',
                fecha_conyuge = '".$_POST["fecha_conyuge"]."',
                numero_hijos = '".$_POST["numero_hijos"]."',
                cantidad_hijo = '".$_POST["cantidad_hijo"]."',
                nombre_hijo = '".$_POST["nombre_hijo"]."', 
                documento_hijo = '".$_POST["documento_hijo"]."', 
                fecha_hijo = '".$_POST["fecha_hijo"]."',  
                parentesco = '".$_POST["parentesco"]."',  
                otros = '".$_POST["otros"]."',  
                nombre = '".$_POST["nombre"]."',  
                tipo_documento = '".$_POST["tipo_documento"]."',  
                fecha_nace = '".$_POST["fecha_nace"]."', 
                convives = '".implode(";", $_POST["convives"])."',
                mascotas = '".implode(";", $_POST["mascotas"])."',
                cuidado_especial = '".$_POST["cuidado_especial"]."',  
                gastos = '".$_POST["gastos"]."'
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            
            
            
            if($_FILES["foto_familiar"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Cargar_Foto_Familiar( $_FILES["foto_familiar"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Familiares SET foto2 = '".$archivo."' WHERE id = '".$_POST["id_informacion"]."' ");
            }
            
            mysqli_query($connect_valentina, $sentencia_adicional);  

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Familiares (
                id_empleado, 
                conyuge,
                documento_conyuge,
                fecha_conyuge,
                numero_hijos,
                cantidad_hijo,
                nombre_hijo,
                documento_hijo, 
                fecha_hijo, 
                foto2, 
                parentesco, 
                otros, 
                nombre, 
                tipo_documento, 
                fecha_nace,
                convives,
                mascotas, 
                cuidado_especial, 
                gastos,
                created_at
            ) 
            VALUES 
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                '".$_POST["conyuge"]."',
                '".$_POST["documento_conyuge"]."',
                '".$_POST["fecha_conyuge"]."',
                '".$_POST["numero_hijos"]."', 
                '".$_POST["cantidad_hijo"]."',
                '".$_POST["nombre_hijo"]."',  
                '".$_POST["documento_hijo"]."',   
                '".$_POST["fecha_hijo"]."', 
                '',
                '".$_POST["parentesco"]."',   
                '".$_POST["otros"]."', 
                '".$_POST["nombre"]."', 
                '".$_POST["tipo_documento"]."',  
                '".$_POST["fecha_nace"]."', 
                '".implode(";", $_POST["convives"])."', 
                '".implode(";", $_POST["mascotas"])."', 
                '".$_POST["cuidado_especial"]."',   
                '".$_POST["gastos"]."', 
                '".$hoy."'
            );
            ";
            //print_r($sentencia);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            
            if($_FILES["foto_familiar"]["name"]){
                    include("app/controllers/subir_documento.php");
                    $archivo = Cargar_Foto_Familiar( $_FILES["foto_familiar"] );
                    mysqli_query($connect_valentina,"UPDATE Empleados_Familiares SET foto2 = '".$archivo."' WHERE id = '".$id_temp."' ");
                }
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
	}
	
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);
    //print_r($dataInforma);
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
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Adicionales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link ">Bienestar</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link ">RSE</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico" class="nav-link  ">Académico</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/laboral" class="nav-link ">Experiencia laboral previa</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/trayectoria" class="nav-link ">Trayectoria en AT</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/familiares" class="nav-link active">Familiares</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/emergencia" class="nav-link">En Caso de Emergencia</a>
            </li>
            <?php } ?>
        </ul>
        
        <div class="card-body">
            
            
        </div> 
        
    </div>
  
    <!-- LISTADO -->
    <div class="card">
        <div class="card-body"> 
            
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12"style="margin-bottom: 30px">
                    <h1>Datos Familiares</h1>
                </div>
 <!-- conyuge -->               
                <div class="col-md-12"style="margin-bottom: 30px">
                    <h2>Conyuge/Concubino:</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="conyuge" value="<?php echo $dataInforma["conyuge"]; ?>" required>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Documento de Identidad:</label>
                    <select class="form-control" name="documento_conyuge">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Tipo_Doc as $tipo){  
                            if($tipo[0] == $dataInforma["documento_conyuge"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_conyuge" value="<?php echo $dataInforma["fecha_conyuge"]; ?>">
                </div>
                
<!-- hijos -->               
                <div class="col-md-12"style="margin-bottom: 30px; margin-top: 30px">
                    <h2>Hijos/as:</h2>
                </div>
                
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Tiene Hijos</label>
                    <select class="form-control" name="numero_hijos" required onChange="MostrarHijos(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Numero_Hijos as $tipo){  
                            if($tipo[0] == $dataInforma["numero_hijos"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                
                <script>
                    
                function MostrarHijos(valor){
                    if(valor == 1){
                        $(".cajas_hijos").show();
                    }
                    if(valor == 2){
                        $(".cajas_hijos").hide();
                    }
                }
                </script>
                
                <style>
                    .cajas_hijos{
                        display: none;
                    }
                </style>
                
                <div class="col-md-6 cajas_hijos" style="margin-bottom: 10px">
                    <label>Cantidad de hijos</label>
                    <input type="text" class="form-control" name="cantidad_hijo" value="<?php echo $dataInforma["cantidad_hijo"]; ?>" required>
                </div>

                <div class="col-md-6 cajas_hijos" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="nombre_hijo" value="<?php echo $dataInforma["nombre_hijo"]; ?>" required>
                </div>

                
                <div class="col-md-6 cajas_hijos" style="margin-bottom: 10px">
                    <label>Documento de Identidad:</label>
                    <select class="form-control" name="documento_hijo">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Tipo_Doc as $tipo){  
                            if($tipo[0] == $dataInforma["documento_hijo"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6 cajas_hijos" style="margin-bottom: 10px">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_hijo" value="<?php echo $dataInforma["fecha_hijo"]; ?>">
                </div>
                
                <div class="col-md-6 " style="margin-bottom: 10px">
                    <label>Foto Familiar (tamaño máximo 1 mega)</label>
                    <input class="form-control" type="file" name="foto_familiar" id="foto_familiar" accept="image/*" onChange="validarImagen()" size="1">
                    <?php if($dataInforma["foto2"]){ ?>
                    <img src="<?php echo $url."/recursos/".$dataInforma["foto2"]; ?>" width="200">
                    <?php } ?>
                </div>
                
                
<!-- otros -->               
                <div class="col-md-12"style="margin-bottom: 30px; margin-top: 30px">
                    <h2>Otros:</h2>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Parentesco</label>
                    <select class="form-control" name="parentesco" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Parentezco as $tipo){  
                            if($tipo[1] == $dataInforma["parentesco"]){
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
                    <label>Si tu respuesta anterior fue Otros, por favor especifica</label>
                    <input type="text" class="form-control" name="otros" value="<?php echo $dataInforma["otros"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nombre Completo</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $dataInforma["nombre"]; ?>" required>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Documento de Identidad:</label>
                    <select class="form-control" name="tipo_documento">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Tipo_Doc as $tipo){  
                            if($tipo[0] == $dataInforma["tipo_documento"]){
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
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_nace" value="<?php echo $dataInforma["fecha_nace"]; ?>">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label><b>¿Con quien convives?</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["convives"]);
                        foreach($Array_Convives as $tipo){  
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
                                        <input type="checkbox" name="convives[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
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
                    <label><b>Si tu respuesta anterior fue mascotas, por favor especifica el tipo :</b></label>
                    <div class="row">
                    <?php
                        $datos_array = explode(";", $dataInforma["mascotas"] ); 
                        foreach($Array_Mascotas as $tipo){  
                            $checked = "";
                            foreach( $datos_array as $nodo){
                                if($nodo == $tipo[1] ){
                                    $checked = "checked";
                                }
                            }
                                            
                            
                            echo '
                            <div class="col-md-6">
                            <table class="table table-bordered table-smd">
                                <tr>
                                    <td style="padding: 15px">
                                        '.$tipo[1].' 
                                    </td>
                                    <td align="center" width="60" style="padding: 15px">
                                        <input type="checkbox" name="mascotas[]" value="'.$tipo[1].'" class="checks cand_disp" '.$checked.' />
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
                    <label>Indica si alguno de los mienbros con los que convives requiere un cuidado especial que amerite tiempo adicional en tu jornada laboral</label>
                    <textarea type="text" class="form-control" name="cuidado_especial" style="margin-top: 3px"><?php echo $dataInforma["cuidado_especial"]; ?></textarea>
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>¿Los gastos del hogar son asumidos por?</label>
                    <select class="form-control" name="gastos">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_gastos as $tipo){  
                            if($tipo[0] == $dataInforma["gastos"]){
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
                    <button type="submit" class="btn btn-primary btn-block" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>                

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
function validarImagen() {
    var fileSize = $('#foto_familiar')[0].files[0].size;
    console.log(fileSize);
    
    var siezekiloByte = parseInt(fileSize / 1024);
    if (siezekiloByte > 1000 ) {
        alert("La fotografía es demasiado grande. por favor reduzca su tamaño a menos de 1 mega.");
        $('#foto_familiar').val("");
        return false;
    }
}
</script>

<script>
var api = '<?php echo $url; ?>/api/administrar/';
    
function Cargar_Posiciones(id_cargo){
	
	
	jQuery.ajax({
		url: api+"cargar_posiciones.php",
		type:'post',
		data: {id_cargo: id_cargo, id_posicion: 0, url:""},
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
   
    
function Eliminar_Familiares(id_registro){
	jQuery.ajax({
		url: api+"eliminar_familiares.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>/?pg=administrar/colaborador/familiares"},
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
    
    //PARA CAMBIAR A MAYUSCULAS
    $(document).ready( function () {
        $("input").on("keypress", function () {
           $input=$(this);
           setTimeout(function () {
            $input.val($input.val().toUpperCase());
           },50);
        });
        
        <?php
        if($dataInforma["numero_hijos"] == 1){
        ?>
        MostrarHijos(1)
        <?php
        }
        ?>
    });

</script>



