<script>  
$(document).ready(function(){
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
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
            UPDATE Empleados_Academico SET 
                titulo = '".$_POST["titulo"]."', 
                nivel = '".$_POST["nivel"]."', 
                area_conocimiento = '".$_POST["area_conocimiento"]."', 
                entidad = '".$_POST["entidad"]."', 
                fecha_titulo = '".$_POST["fecha_titulo"]."', 
                tarjeta_profesional  = '".$_POST["tarjeta_profesional"]."', 
                en_curso = '".$_POST["en_curso"]."',
                estudia_actualmente = '".$_POST["estudia_actualmente"]."'
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            mysqli_query($connect_valentina, $sentencia_adicional);
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Academico SET cargar_archivo = '".$archivo."' WHERE id = '".$_POST["id_informacion"]."' ");
            }

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Academico (
                id_empleado, 
                documento, 
                titulo,
                nivel, 
                area_conocimiento, 
                entidad, 
                fecha_titulo, 
                tarjeta_profesional, 
                en_curso,
                estudia_actualmente,
                cargar_archivo,
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                0, 
                '".$_POST["titulo"]."',
                '".$_POST["nivel"]."', 
                '".$_POST["area_conocimiento"]."', 
                '".$_POST["entidad"]."', 
                '".$_POST["fecha_titulo"]."', 
                '".$_POST["tarjeta_profesional"]."', 
                '".$_POST["en_curso"]."',
                '".$_POST["estudia_actualmente"]."',
                '', 
                '".$hoy."'
            );
            ";
            
            //print_r($sentencia_adicional);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados_Academico SET cargar_archivo = '".$archivo."' WHERE id = '".$id_tmp."' ");
            }
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
	}


	//idiomas
    //idiomas
	//idiomas
	//idiomas
    if($_POST["guardar_idiomas"] != ""){

        if($_POST["id_idiomas"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Academico_Idiomas SET 
                idioma = '".$_POST["idioma"]."', 
                oral_escrito = '".$_POST["oral_escrito"]."', 
                nivel_idiomas = '".$_POST["nivel_idiomas"]."'
                WHERE id = '".$_POST["id_idiomas"]."'
            ";
            mysqli_query($connect_valentina, $sentencia_adicional);
            $id_tmp = mysqli_insert_id($connect_valentina);

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Academico_Idiomas (
                id_empleado, 
                idioma, 
                oral_escrito,
                nivel_idiomas, 
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."', 
                '".$_POST["idioma"]."',
                '".$_POST["oral_escrito"]."', 
                '".$_POST["nivel_idiomas"]."', 
                '".$hoy."'
            );
            ";
            
            //print_r($sentencia_adicional);
            mysqli_query($connect_valentina, $sentencia_adicional); 
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
	}

    //conocimientos y habilidades
    //conocimientos y habilidades
	//conocimientos y habilidades
	//conocimientos y habilidades
    if($_POST["guardar_habilidades"] != ""){

        if($_POST["id_habilidades"] != ""){
            
            $sentencia_adicional = "
            UPDATE Empleados_Academico_Habilidades SET 
                habilidades = '".$_POST["habilidades"]."' 
                WHERE id = '".$_POST["id_habilidades"]."'
            ";
            mysqli_query($connect_valentina, $sentencia_adicional);
            $id_tmp = mysqli_insert_id($connect_valentina);

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia_adicional = "
            INSERT INTO Empleados_Academico_Habilidades (
                id_empleado, 
                habilidades, 
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."',
                '".$_POST["habilidades"]."',
                '".$hoy."'
            );
            ";
            
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

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id = '".$_GET["acd"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

	$queryInforma2 = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico_Idiomas WHERE id = '".$_GET["idm"]."' ");
	$dataInforma2 = mysqli_fetch_array($queryInforma2);

    $queryInforma3 = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico_Habilidades WHERE id = '".$_GET["hab"]."' ");
	$dataInforma3 = mysqli_fetch_array($queryInforma3);
?>



<div class="container"> 
	
    <?php echo $respuesta; ?>
	
	<!-- PESTAÑAS -->
    <!-- PESTAÑAS -->
    <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle" class="nav-link ">Básicos</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link ">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link">Bienestar</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/preferencia" class="nav-link">RSE</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico" class="nav-link active">Académico</a>
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
    </ul>

    <!-- LISTADO -->
    <div class="card" style="margin-bottom: 15px">
        <div class="card-header">
            <h2>Formación Académica</h2>
        </div>

        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Título</th>
                    <th>Nivel</th>
                    <th>Área</th>
                    <th>Entidad</th>
                    <th>Fecha</th>
                    <th>En Curso</th>
                    <th>Soporte</th>
                    <th width="90">
                        <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico">
                        <button type="button" class="btn btn-primary btn-sm">
                            Nuevo
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $queryAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($dataAcademico = mysqli_fetch_array($queryAcademico)){
                    echo '
                    <tr>
                        <td>'.$dataAcademico["titulo"].'</td>
                        <td>'.$dataAcademico["nivel"].'</td>
                        <td>'.$dataAcademico["area_conocimiento"].'</td>
                        <td>'.$dataAcademico["entidad"].'</td>
                        <td>'.$dataAcademico["fecha_titulo"].'</td>
                        <td>'.$dataAcademico["en_curso"].'</td>
                        <td>
                            <a href="https://somosat.hr-suite.app//recursos/'.$dataAcademico["cargar_archivo"].'" target="_blank">
                                '.$dataAcademico["cargar_archivo"].'
                            </a>
                        </td>
                        <td>
                           <a href="'.$url.'?pg=administrar/colaborador/academico&acd='.$dataAcademico["id"].'"> 
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-check"></i>
                            </button>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="Eliminar_Academico('.$dataAcademico["id"].')" >
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

    <div class="card mb-3" >

        <div class="card-body">   
    
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Título</lable>
                    <input type="text" class="form-control" name="titulo" value="<?php echo $dataInforma["titulo"]; ?>" required>
                </div>
                
                 <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Nivel de Formación</lable>
                    <select class="form-control" name="nivel" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Nivel_Formacion as $tipo){  
                            if($tipo[1] == $dataInforma["nivel"]){
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
                    <lable>Área Del Conocimiento</lable>
                    <input type="text" class="form-control" name="area_conocimiento" value="<?php echo $dataInforma["area_conocimiento"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Entidad Que Otorga</lable>
                    <input type="text" class="form-control" name="entidad" value="<?php echo $dataInforma["entidad"]; ?>" required>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Fecha Del Título</lable>
                    <input type="date" class="form-control" name="fecha_titulo" value="<?php echo $dataInforma["fecha_titulo"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Matricula o Tarjeta Profesional</lable>
                    <input type="text" class="form-control" name="tarjeta_profesional" value="<?php echo $dataInforma["tarjeta_profesional"]; ?>">
                </div>
                
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>En Curso</lable>
                    <select class="form-control" name="en_curso" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_En_Curso_Academico as $tipo){  
                            if($tipo[1] == $data["en_curso"]){
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
                    <lable>Estudia Actualmente</lable>
                    <select class="form-control" name="estudia_actualmente" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estudia_Actualmente as $tipo){  
                            if($tipo[1] == $data["estudia_actualmente"]){
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
                    <label><b>Adjuntar un Archivo</b></label>
                    <input type="file" id="archivo" name="archivo" class="form-control">
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


	
	
	<!-- LISTADO -->
    <div class="card" style="margin-bottom: 15px">
        <div class="card-header">
            <h2>Idiomas</h2>
        </div>

        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Idioma</th>
                    <th>Nivel</th>
                    <th>Oral / Escrito</th>
                    <th width="90">
                        <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico">
                        <button type="button" class="btn btn-primary btn-sm">
                            Nuevo
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $queryAcademicoIdm = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico_Idiomas 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($dataAcademicoIdm = mysqli_fetch_array($queryAcademicoIdm)){
                    echo '
                    <tr>
                        <td>'.$dataAcademicoIdm["idioma"].'</td>
                        <td>'.$dataAcademicoIdm["nivel_idiomas"].'</td>
                        <td>'.$dataAcademicoIdm["oral_escrito"].'</td>
                        <td>
                           <a href="'.$url.'?pg=administrar/colaborador/academico&idm='.$dataAcademicoIdm["id"].'"> 
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-check"></i>
                            </button>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="Eliminar_Idioma('.$dataAcademicoIdm["id"].')" >
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

    <!-- IDIOMAS -->
	<div class="card mb-3" >
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_idiomas" value="<?php echo $dataInforma2["id"]; ?>">
                    <input type="hidden" name="guardar_idiomas" value="true">
                </div>

                 <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Idioma</lable>
                    <select class="form-control" name="idioma" required>
                        <option value="">Selecciona...</option>
                        <?php
						$queryIdiomas = mysqli_query($connect_valentina,"SELECT * FROM Idiomas ORDER BY nombre ASC ");  
						while($dataIdioma = mysqli_fetch_array($queryIdiomas)){ 
							if($dataIdioma["nombre"] == $dataInforma2["idioma"]){
                                echo '<option value="'.$dataIdioma["nombre"].'" selected>'.$dataIdioma["nombre"].'</option>';  
                            }
                            else{
                                echo '<option value="'.$dataIdioma["nombre"].'">'.$dataIdioma["nombre"].'</option>';
                            }
						}
                        ?>
                    </select>
                </div>
                
				
				<div class="col-md-3" style="margin-bottom: 10px">
                    <lable>Nivel de Idiomas</lable>
                    <select class="form-control" name="nivel_idiomas" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Nivel_Ingles as $tipo){  
                            if($tipo[1] == $dataInforma2["nivel_idiomas"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
				
				
				<div class="col-md-3" style="margin-bottom: 10px">
                    <lable>Oral / Escrito</lable>
                    <select class="form-control" name="oral_escrito" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Idioma_Oral_Escrito as $tipo){  
                            if($tipo[1] == $dataInforma2["oral_escrito"]){
                                echo '<option value="'.$tipo[1].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[1].'">'.$tipo[1].'</option>';
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
    
    <!-- LISTADO -->
    <div class="card" style="margin-bottom: 15px">

        <div class="card-header">
            <h2>Conocimiento y Habilidades</h2>
        </div>
        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Conocimiento y Habilidades</th>
                    <th width="90">
                        <a href="<?php echo $url; ?>?pg=administrar/colaborador/academico">
                        <button type="button" class="btn btn-primary btn-sm">
                            Nuevo
                        </button>
                        </a>
                    </th>
                </tr>
                <?php 
                $queryAcademicoHab = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico_Habilidades 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($dataAcademicoHab = mysqli_fetch_array($queryAcademicoHab)){
                    echo '
                    <tr>
                        <td>'.$dataAcademicoHab["habilidades"].'</td>
                        <td>
                           <a href="'.$url.'?pg=administrar/colaborador/academico&hab='.$dataAcademicoHab["id"].'"> 
                            <button type="button" class="btn btn-success btn-sm" >
                                <i class="fa fa-check"></i>
                            </button>
                            </a>
                            
                            <button type="button" class="btn btn-danger btn-sm" onclick="Eliminar_Habilidades('.$dataAcademicoHab["id"].')" >
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

    
	
	
	
    
    <!-- Conocimiento y habilidades -->
	<div class="card" style="margin-bottom: 20px">
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <input type="hidden" name="id_habilidades" value="<?php echo $dataInforma3["id"]; ?>">
                    <input type="hidden" name="guardar_habilidades" value="true">
                </div>

                 <div class="col-md-12" style="margin-bottom: 10px">
                    <lable>Conocimiento y habilidades</lable>
                    <textarea type="text" class="form-control" name="habilidades" ><?php echo $dataInforma3["habilidades"]; ?></textarea>
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
    
    
function Eliminar_Academico(id_registro){
	
	
	jQuery.ajax({
		url: api+"eliminar_academico.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/academico"},
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
	
function Eliminar_Idioma(id_registro){
	jQuery.ajax({
		url: api+"eliminar_idioma.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/academico"},
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
    
function Eliminar_Habilidades(id_registro){
	jQuery.ajax({
		url: api+"eliminar_habilidades.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/academico"},
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
    
    var api = '<?php echo $url; ?>/api/administrar/';

	function Eliminar_Laboral(id_registro){
		jQuery.ajax({
			url: api+"eliminar_laboral.php",
			type:'post',
			data: {id_registro: id_registro, url:"<?php echo $url; ?>?pg=administrar/colaborador/academico"},
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



