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

        if($_POST["id_registro"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Familiares SET 
                parentezco = '".$_POST["parentezco"]."',
                otros = '".$_POST["otros"]."',
                nombre = '".$_POST["nombre"]."', 
                apellidos = '".$_POST["apellidos"]."', 
                apellidos_2 = '".$_POST["apellidos_2"]."',  
                tipo_documento = '".$_POST["tipo_documento"]."',  
                documento = '".$_POST["documento"]."',  
                telefono = '".$_POST["telefono"]."',  
                fecha_nace = '".$_POST["fecha_nace"]."',  
                genero = '".$_POST["genero"]."',  
                nivel_educativo = '".$_POST["nivel_educativo"]."',  
                completo_academico = '".$_POST["completo_academico"]."',  
                discapacidad = '".$_POST["discapacidad"]."', 
                avisar_a = '".$_POST["avisar_a"]."',
                convive = '".$_POST["convive"]."'
                WHERE id = '".$_POST["id_registro"]."'
            ";
            
            print_r($sentencia_adicional);
            
            if($_FILES["foto_familiar"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Cargar_Foto_Familiar( $_FILES["foto_familiar"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Familiares SET foto3 = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
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
                parentezco,
                otros,
                nombre,
                apellidos, 
                apellidos_2, 
                tipo_documento, 
                documento, 
                telefono, 
                fecha_nace, 
                genero, 
                nivel_educativo, 
                completo_academico, 
                discapacidad, 
                avisar_a,
                convive,
                foto3,
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                '".$_POST["parentezco"]."', 
                '".$_POST["otros"]."', 
                '".$_POST["nombre"]."',  
                '".$_POST["apellidos"]."',   
                '".$_POST["apellidos_2"]."',   
                '".$_POST["tipo_documento"]."',   
                '".$_POST["documento"]."', 
                '".$_POST["telefono"]."', 
                '".$_POST["fecha_nace"]."',  
                '".$_POST["genero"]."',   
                '".$_POST["nivel_educativo"]."',   
                '".$_POST["completo_academico"]."',  
                '".$_POST["discapacidad"]."', 
                '".$_POST["avisar_a"]."',
                '".$_POST["convive"]."',
                '',
                '".$hoy."'
            );
            ";
            //print_r($sentencia);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["foto_familiar"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Cargar_Foto_Familiar( $_FILES["foto_familiar"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_familiares SET foto3 = '".$archivo."' WHERE id = '".$id_temp."' ");
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

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id = '".$_GET["acd"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);

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
            
            <table class="table table-bordered">
                <tr>
                    <th>Parentesco</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>telefono</th>
                    <th>foto</th>
                    <th width="120">
                        <a href="<?php echo $url; ?>/?pg=administrar/colaborador/familiares">
                        <button type="button" class="btn btn-primary btn-sm">
                            +
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $datafamiliar = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($datafamiliar = mysqli_fetch_array($datafamiliar)){
                    echo '
                    <tr>
                        <td>'.$datafamiliar["parentezco"].'</td>
                        <td>'.$datafamiliar["nombre"].' '.$datafamiliar["apellidos"].' '.$datafamiliar["apellidos_2"].'</td>
                        <td>'.$datafamiliar["documento"].'</td>
                        <td>'.$datafamiliar["telefono"].'</td>
                        <td>
                            <a href="https://somosat.hr-suite.app/recursos/'.$datafamiliar["cargar_archivo"].'" target="_blank">
                                '.$datafamiliar["cargar_archivo"].'
                            </a>
                        </td>
                        <td>
                            <a href="'.$url.'/?pg=administrar/colaborador/familiares&fam='.$datafamiliar["id"].'">
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-edit"></i>
                            </button>
                            </a>
                            
                            <button type="button" class="btn btn-primary btn-sm" onclick="Eliminar_Familiares('.$datafamiliar["id"].')" >
                                <i class="fa fa-times"></i>
                            </button>
                        </td>
                    </tr>
                    ';   
                }	
                ?>
            </table>
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

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Parentesco</label>
                    <select class="form-control" name="parentezco" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Parentezco as $tipo){  
                            if($tipo[1] == $dataInforma["parentezco"]){
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
                    <label>Si tu respuesta anterior fue Otros, por favor especifica</label>
                    <input type="text" class="form-control" name="otros" value="<?php echo $dataInforma["otros"]; ?>" >
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Nombres</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $dataInforma["nombre"]; ?>" required>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Primer Apellido</label>
                    <input type="text" class="form-control" name="apellidos" value="<?php echo $dataInforma["apellidos"]; ?>" >
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Segundo Apellido</label>
                    <input type="text" class="form-control" name="apellidos_2" value="<?php echo $dataInforma["apellidos_2"]; ?>" >
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
                    <label>Número de Documento:</label>
                    <input type="text" class="form-control" name="documento" value="<?php echo $dataInforma["documento"]; ?>" required>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Teléfono de contacto:</label>
                    <input type="text" class="form-control" name="telefono" value="<?php echo $dataInforma["telefono"]; ?>" required>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Fecha Nacimiento:</label>
                    <input type="date" class="form-control" name="fecha_nace" value="<?php echo $dataInforma["fecha_nace"]; ?>">
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Género:</label>
                    <select class="form-control" name="genero">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Sexo_Biologico as $tipo){  
                            if($tipo[1] == $dataInforma["genero"]){
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
                    <label>Nivel Académico:</label>
                    <select class="form-control" name="nivel_educativo" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Nivel_Formacion as $tipo){  
                            if($tipo[1] == $dataInforma["nivel_educativo"]){
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
                    <label>Completo el nivel académico:</label>
                    <select class="form-control" name="completo_academico" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Si_No as $tipo){  
                            if($tipo[1] == $dataInforma["completo_academico"]){
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
                    <label>Tiene alguna condición de discapacidad:</label>
                    <select class="form-control" name="discapacidad" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Lista_Si_No as $tipo){  
                            if($tipo[1] == $dataInforma["discapacidad"]){
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
                    <label>En caso de Emergencia avisar a:</label>
                    <input type="text" class="form-control" name="avisar_a" value="<?php echo $dataInforma["avisar_a"]; ?>" required>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Convive o no convive:</label>
                    <select class="form-control" name="convive" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Convive as $tipo){  
                            if($tipo[1] == $dataInforma["convive"]){
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
                    <label>Foto Familiar (tamaño máximo 1 mega)</label>
                    <input class="form-control" type="file" name="foto_familiar" id="foto_familiar" accept="image/*" onChange="validarImagen()" size="1">
                    <?php if($data["foto3"]){ ?>
                    <img src="<?php echo $url."/recursos/".$data["foto3"]; ?>" width="200">
                    <?php } ?>
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
    });

</script>



