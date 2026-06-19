<script>  
$(document).ready(function(){
    $("#bt_adm_puestos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = '';

    if($_GET["id"]){
        $_SESSION["id_cargo_edit"] = $_GET["id"];
    }

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
            $sentencia = "
            UPDATE Cargos SET 
            nombre = '".$_POST["nombre"]."', 
            id_area = '".$_POST["id_area"]."', 
			id_gerencia = '".$_POST["id_gerencia"]."', 
            tipo = '".$_POST["tipo"]."', 
            liderazgo = '".$_POST["liderazgo"]."', 
            estado = '".$_POST["estado"]."'  
            WHERE id = '".$_POST["id_registro"]."'
            ";

			mysqli_query($connect_valentina, $sentencia);
            
            $respuesta = '
            <div class="alert alert-success" role="alert">
                Los datos han sido actualizado
            </div>
            ';
		}
		else{
            
            $sentencia = "
            INSERT INTO Cargos ( nombre, id_area, id_gerencia, tipo, liderazgo, estado, created_at) 
            VALUES 
            ( '".$_POST["nombre"]."', '".$_POST["id_area"]."', '0', '".$_POST["tipo"]."', '".$_POST["liderazgo"]."','".$_POST["estado"]."', '".$hoy."'
            )
            ";
            
            
			mysqli_query($connect_valentina, $sentencia); 
            echo '<script> window.location = "?pg=administrar/cargos";</script>';//para evitar reinsersion 
		}

         
	}
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$_SESSION["id_cargo_edit"]."'  ");
	$data = mysqli_fetch_array($query);	
?>

<div class="container">
 	
	<?php echo $respuesta; ?>
	
	<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/cargos">Administrar Cargos</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Cargo</a></li>
		  </ol>
	</nav>
	
	<!-- NAVEGACION -->
    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" href="<?php echo $url; ?>?pg=administrar/cargo/detalle">
				<i class="icofont icofont-business-man"></i>Detalle
			</a>
		</li>
		<li class="nav-item ">
			<a class="nav-link "  href="<?php echo $url; ?>?pg=administrar/cargo/descriptivo">
				<i class="icofont icofont-list"></i>Descriptivo
			</a>
		</li>

		<li class="nav-item">
			<a class="nav-link " href="<?php echo $url; ?>?pg=administrar/cargo/perfil">
				<i class="icofont icofont-contact-add"></i>Perfil
			</a>
		</li>      
    </ul>
    <!-- FIN NAVEGACION -->

	<div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Cargo</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nombre del Cargo</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>" required>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Área</label>
                    <select class="form-control" name="id_area">
                        <option value="">Selecciona..</option>
                        <?php
                        $queryDep = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
                        while($dataDep = mysqli_fetch_array($queryDep)){
                            if($data["id_area"] == $dataDep["id"] ){
                                echo '<option value="'.$dataDep["id"].'" selected>'.$dataDep["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataDep["id"].'">'.$dataDep["nombre"].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Departamento</label>
                    <select class="form-control" name="id_gerencia">
                        <option value="0">Selecciona..</option>
                        <?php
                        $queryGerencia = mysqli_query($connect_valentina,"SELECT * FROM Gerencias ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryGerencia)){
                            if($data["id_gerencia"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].' </option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Tipo</label>
                    <select class="form-control" name="tipo">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Tipo as $nivel){
                            if($data["tipo"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Liderazgo</label>
                    <select class="form-control" name="liderazgo">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_liderazgo as $nivel){
                            if($data["liderazgo"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Estado</label>
                    <select class="form-control" name="estado">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Estado as $nivel){
                            if($data["estado"] == $nivel[0] ){
                                echo '<option value="'.$nivel[0].'" selected>'.$nivel[1].'</option>';
                            }
                            else{
                                echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>

            </div>
            </form>
        </div> 
        
	</div>
	
</div>      

<script>
    var api = '<?php echo $url; ?>api/administrar/';
    
    var activar = false;
    function Elimimar_Cargo(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un cargo, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Cargo('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_cargo.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/cargos"},
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
    }
    

    
</script>

