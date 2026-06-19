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
    
    if($_GET["id"]){
        $_SESSION["id_colaborador_edit"] = $_GET["id"];
    }

    //CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
    if($_POST["informacion_basica"] != ""){
        
        if($_POST["id_registro"] != ""){ 
            
            $sentencia_adicional = 
            "UPDATE Empleados SET 
                documento = '".$_POST["documento"]."',
                nombre = '".$_POST["nombre"]."',
                apellidos = '".$_POST["apellidos"]."',
                cargo = '".$_POST["cargo"]."',
                area = '".$_POST["area"]."',
                nivel = '".$_POST["nivel"]."',
                correo = '".$_POST["correo"]."',
                role = '".$_POST["role"]."', 
                estado = '".$_POST["estado"]."', 
                documentos = '".$_POST["documentos"]."'
                WHERE id = '".$_POST["id_registro"]."'
            ";
            
            //print_r($sentencia_adicional);
            
            if($_FILES["foto_perfil"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Cargar_Foto_Perfil( $_FILES["foto_perfil"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', 1, '".$hoy."'  )";

                mysqli_query($connect_valentina, $sent_foto);
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
			
			if($_POST["foto_formal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto = '".$_POST["foto_formal_historico"]."' WHERE id = '".$_POST["id_registro"]."' ");
			}
            
            if($_FILES["foto_informal"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Cargar_Foto_Informal( $_FILES["foto_informal"] );
				
				$sent_foto = "INSERT INTO Multimedia_Foto_Perfil ( id_empleado ,  archivo , origen,  created_at ) 
				VALUES ( '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', 2, '".$hoy."'  )";
				
                mysqli_query($connect_valentina, $sent_foto);
                mysqli_query($connect_valentina,"UPDATE Empleados SET foto1 = '".$archivo."' WHERE id = '".$_POST["id_registro"]."' ");
            }
            
			
			if($_POST["foto_informal_historico"]){
				mysqli_query($connect_valentina, "UPDATE Empleados SET foto1 = '".$_POST["foto_informal_historico"]."' WHERE id = '".$_POST["id_registro"]."' ");
			}
            
            mysqli_query($connect_valentina, $sentencia_adicional); 
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
				
				
				$sent_multi = "
				INSERT INTO Multimedia_Documentos ( id_empresa , id_tipo_doc , id_colaborador ,  archivo , created_at ) 
				VALUES 
				( 1, '".$_POST["documentos"]."', '".$_SESSION["id_colaborador_edit"]."', '".$archivo."', '".$hoy."' )
				";
				
                mysqli_query( $connect_valentina, $sent_multi );
            }

                           


            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';

        }
        else{

            $sentencia_adicional = "
            INSERT INTO Empleados (
                id_empleado,
                documento,
                nombre,
                apellidos,
                cargo, 
                area, 
                nivel,
                correo,
                role,
                estado,
                foto,
                foto1,
                documentos,
                cargar_archivo,
                created_at
            ) 
            VALUES
            (
                '".$_SESSION["id_colaborador_edit"]."',   
                '".$_POST["documento"]."',  
                '".$_POST["nombre"]."',
                '".$_POST["apellidos"]."', 
                '".$_POST["cargo"]."',
                '".$_POST["area"]."',  
                '".$_POST["nivel"]."',
                '".$_POST["correo"]."', 
                '".$_POST["role"]."',
                '".$_POST["estado"]."',
                '',
                '',
                '".$_POST["documentos"]."', 
                '',
                '".$hoy."' 
            );
            ";
            //print_r($sentencia);
            mysqli_query($connect_valentina, $sentencia_adicional);
            
            $id_tmp = mysqli_insert_id($connect_valentina);
            
            if($_FILES["foto_perfil"]["name"]){
                    include("app/controllers/subir_documento.php");
                    $archivo = Cargar_Foto_Perfil( $_FILES["foto_perfil"] );
                    mysqli_query($connect_valentina,"UPDATE Empleados SET foto = '".$archivo."' WHERE id = '".$id_temp."' ");
                }
            
            if($_FILES["foto_informal"]["name"]){
                    include("app/controllers/subir_documento.php");
                    $archivo = Cargar_Foto_Informal( $_FILES["foto_informal"] );
                    mysqli_query($connect_valentina,"UPDATE Empleados SET foto1 = '".$archivo."' WHERE id = '".$id_temp."' ");
                }
        
                
            if($_FILES["archivo"]["name"]){
                include("app/controllers/subir_documento.php");
                $archivo = Subir_Documento( $_FILES["archivo"] );
                mysqli_query($connect_valentina,"UPDATE Empleados SET cargar_archivo = '".$archivo."' WHERE id = '".$id_tmp."' ");
            }

            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
        
    }

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE nombre = '".$_POST["cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);
                            
    $queryNivel = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo WHERE id = '".$_POST["id_nivel"]."' ");  
    $dataNivel = mysqli_fetch_array($queryNivel);
        
    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$_POST["id_area"]."' ");  
    $dataArea = mysqli_fetch_array($queryArea);

	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_colaborador_edit"]."' ");
	$data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_GET["edi"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);

    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_area"]."'  ");
    $dataArea = mysqli_fetch_array($queryArea);
    
    $queryGerencia = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$dataCargo["id_gerencia"]."'  ");
    $dataGerencia = mysqli_fetch_array($queryGerencia);

    $txt_role = '';
    foreach($Array_Role as $role){
        if($role[0] == $data["role"]){  $txt_role = $role[1]; }
    }
                        
    $txt_estado = '';
    foreach($Array_Estado  as $estado){
        if($estado[0] == $data["estado"]){  $txt_estado = $estado[1]; }
    }

?>


 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/colaboradores">Colaboradores</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
      </ol>
    </nav>
    
<?php echo $respuesta; ?>

<!-- PESTAÑAS -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/editar" class="nav-link active">Básicos</a>
            </li>
            <?php if($_SESSION["id_colaborador_edit"]){ ?>

            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/adicionales" class="nav-link">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=administrar/colaborador/perfil" class="nav-link">Bienestar</a>
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

<div class="card" style="margin-top: 12px">

    <div class="card-body">   

        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12">
                    <h2>Datos Básicos</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_colaborador_edit"]; ?>">
                    <input type="hidden" name="informacion_basica" value="true">
                </div>
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Documento:</label>
                    <input type="text"  class="form-control" name="documento" value="<?php echo $data["documento"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Nombre:</label>
                    <input type="text"  class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Apellido:</label>
                    <input type="text"  class="form-control" name="apellidos" value="<?php echo $data["apellidos"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Cargo:</label>
                    <select class="form-control" name="cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataCargo = mysqli_fetch_array($queryCargo)){
                                if($data["cargo"] == $dataCargo["nombre"] ){
                                    echo '<option value="'.$dataCargo["nombre"].'" selected>'.$dataCargo["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataCargo["nombre"].'">'.$dataCargo["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Area:</label>
                    <select class="form-control" name="area" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Empleados GROUP BY area ORDER BY area ASC;");  
                            while($dataCargo = mysqli_fetch_array($queryCargo)){
                                if($data["area"] == $dataCargo["area"] ){
                                    echo '<option value="'.$dataCargo["area"].'" selected>'.$dataCargo["area"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataCargo["area"].'">'.$dataCargo["area"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Nivel:</label>
                    <select class="form-control" name="nivel" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Empleados GROUP BY area ORDER BY area ASC;");  
                            while($dataCargo = mysqli_fetch_array($queryCargo)){
                                if($data["nivel"] == $dataCargo["nivel"] ){
                                    echo '<option value="'.$dataCargo["nivel"].'" selected>'.$dataCargo["area"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataCargo["nivel"].'">'.$dataCargo["nivel"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>                
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Correo:</label>
                    <input type="text"  class="form-control" name="correo" value="<?php echo $data["correo"]; ?>" >
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Role</label>
                    <select class="form-control" name="role" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Role as $role){  
                            if($role[0] == $data["role"]){
                                echo '<option value="'.$role[0].'" selected>'.$role[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$role[0].'">'.$role[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Estado</label>
                    <select class="form-control" name="estado" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estado as $estado){  
                            if($estado[0] == $data["estado"]){
                                echo '<option value="'.$estado[0].'" selected>'.$estado[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$estado[0].'">'.$estado[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-12" style="margin-top: 20px">
                    <h2>Adjuntar Fotos</h2>
                </div>
				
				<?php 
				$queryFotoFormal = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Foto_Perfil 
                WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ORDER BY id DESC  ");
                $dataFotoFormal = mysqli_fetch_array($queryFotoFormal);
				?>
                
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Foto Formal (tamaño máximo 1 mega)</label>
                    <input class="form-control" type="file" name="foto_perfil" id="foto_perfil" accept="image/*" onChange="validarImagen()" size="1">
                    <?php if($data["foto"] > 0){ ?>
                    <img src="<?php echo $url."/recursos/".$data["foto"]; ?>" width="200">
                    <?php } ?>
					
					<select class="form-control" name="foto_formal_historico">
						<option value="">Fotos Cargadas...</option>
						<?php
							$queryFotos = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Foto_Perfil 
                            WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
                            while($dataFoto = mysqli_fetch_array($queryFotos)){
								echo '<option value="'.$dataFoto["archivo"].'">'.$dataFoto["archivo"].' '.$dataFoto["fecha"].'</option>';
							}
						?>
					</select>
					
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Foto Informal (tamaño máximo 1 mega)</label>
                    <input class="form-control" type="file" name="foto_informal" id="foto_informal" accept="image/*" onChange="validarImagen()" size="1">
                    <?php if($data["foto1"]){ ?>
                    <img src="<?php echo $url."/recursos/".$data["foto1"]; ?>" width="200">
                    <?php } ?>
					
					<select class="form-control" name="foto_informal_historico">
						<option value="">Fotos Cargadas...</option>
						<?php
							$queryFotos = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Foto_Perfil 
                            WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."'  ");
                            while($dataFoto = mysqli_fetch_array($queryFotos)){
								echo '<option value="'.$dataFoto["archivo"].'">'.$dataFoto["archivo"].' '.$dataFoto["fecha"].'</option>';
							}
						?>
					</select>
					
                </div>
   
                <div class="col-md-12" style="margin-top: 20px">
                    <h2>Adjuntar Documentos</h2>
                </div>
                    
                <div class="col-md-6" style="margin-top: 14px">
                    <lable>Documento a Cargar</lable>
                    <select class="form-control" name="documentos" >
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Documentos_cargar as $tipo){  
                            if($tipo[1] == $dataInforma["documentos"]){
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
                                    

                <?php if($user_log["role"] == 1){ ?>
                <div class="col-md-12" style=" margin-top: 15px; margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>
                <?php } ?>

            </div>
        </form>
    </div>
</div>

    <!-- LISTADO -->
    <div class="card">
        <div class="card-body"> 
            
            <table class="table table-bordered">
                <tr>
                    <th>Documento</th>
                    <th>Soporte</th>
                    <th width="30">
                        <a href="<?php echo $url; ?>/?pg=administrar/colaborador/editar">
                        <button type="button" class="btn btn-primary btn-sm">
                            +
                        </button>
                        </a>
                    </th>
                </tr>
                     
                <?php 
                $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Multimedia_Documentos 
                WHERE id_colaborador = '".$_SESSION["id_colaborador_edit"]."'  ");
	            while($dataEmpleados = mysqli_fetch_array($queryEmpleados)){
                    echo '
                    <tr>
                        <td>'.$dataEmpleados["id_tipo_doc"].'</td>
                        <td>
                            <a href="https://somosat.hr-suite.app//recursos/'.$dataEmpleados["archivo"].'" target="_blank">
                                '.$dataEmpleados["archivo"].'
                            </a>
                        </td>
                        <td>
                    
                            
                            <button type="button" class="btn btn-primary btn-sm"  >
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
</div>




<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>

<script>
function validarImagen() {
    var fileSize = $('#foto_perfil')[0].files[0].size;
    console.log(fileSize);
    
    var siezekiloByte = parseInt(fileSize / 1024);
    if (siezekiloByte > 1000 ) {
        alert("La fotografía es demasiado grande. por favor reduzca su tamaño a menos de 1 mega.");
        $('#foto_perfil').val("");
        return false;
    }
}
    
function validarImagen() {
    var fileSize = $('#foto_informal')[0].files[0].size;
    console.log(fileSize);
    
    var siezekiloByte = parseInt(fileSize / 1024);
    if (siezekiloByte > 1000 ) {
        alert("La fotografía es demasiado grande. por favor reduzca su tamaño a menos de 1 mega.");
        $('#foto_informal').val("");
        return false;
    }
}
</script>

<script>
var api = '<?php echo $url; ?>/api/administrar/';
    
function Eliminar_Empleados(id_registro){
	jQuery.ajax({
		url: api+"eliminar_editar.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>/?pg=administrar/colaborador/editar"},
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
         