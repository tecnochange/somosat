<script>  
$(document).ready(function(){
    $("#bt_adm_equipos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"]; 
	$id_equipo = $_GET["e"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	include("app/models/Collaborators.php");
	$ClassCollaborators = new Collaborators();

	$colaboradores = $ClassCollaborators->lista_colaboradores($connect_valentina, 1);

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_empleado"] != ""){

		if($_POST["id_registro"] != ""){
			mysqli_query($connect_valentina,"UPDATE Organigrama SET id_empleado = '".$_POST["id_empleado"]."', 
			jerarquia = '".$_POST["jerarquia"]."', id_equipo = '".$_POST["id_equipo"]."', id_depende = '".$_POST["id_depende"]."', 
			estado = '".$_POST["estado"]."'  WHERE id = '".$_POST["id_registro"]."'  ");
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
			$sentencia = "
			INSERT INTO Organigrama ( id_empleado ,  jerarquia ,  id_equipo ,  id_depende ,  estado ,  created_at ) 
			VALUES 
			( '".$_POST["id_empleado"]."', '".$_POST["jerarquia"]."', '".$_POST["id_equipo"]."', '".$_POST["id_depende"]."', 
			'".$_POST["estado"]."','".$hoy."' )
			";
			mysqli_query($connect_valentina,$sentencia);  
             
		}
		
		echo '<script> window.location = "?pg=administrar/equipos&e='.$id_equipo.'";</script>';//para evitar reinsersion  
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Organigrama WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>


 

    
<?php echo $respuesta; ?>

<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/equipos_lista">Equipos</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/equipos&e=<?php echo $id_equipo; ?>">Equipo</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
		</ol>
	</nav>

	<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Equipo</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Equipo *</label>
                    <select class="form-control" name="id_equipo" onChange="Cargar_Dependientes(this.value)" required   >
                        <option value="0">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Equipos ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($id_equipo == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
<script>
	function Cargar_Dependientes(id_equipo){
					jQuery.ajax({
			url: api+"cargar_depende.php",
			type:'post',
			data: {id_equipo: id_equipo },
			}).done(function (resp){
				$("#id_depende").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
		);
				}
</script>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Jerarquía</label>
                    <input type="text" class="form-control" name="jerarquia" value="<?php echo $data["jerarquia"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Colaborador *</label>
                    <select class="form-control" name="id_empleado" required >
                        <option value="">Selecciona..</option>
                        <?php
						foreach($colaboradores as $colaborador){
							if($data["id_empleado"] == $colaborador["id"] ){
								echo '<option value="'.$colaborador["id"].'" selected>'.$colaborador["nombre_completo"].'</option>';
							}
							else{
								echo '<option value="'.$colaborador["id"].'" >'.$colaborador["nombre_completo"].'</option>';
							}
						}
                        ?>
                    </select>
                </div>
				
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Depende de: *</label>
                    <select class="form-control" name="id_depende" id="id_depende" required >
                        
                        <?php
							$sentencia = "
								SELECT Organigrama.id AS id, Empleados.nombre AS nombre, Empleados.nombre_2 AS nombre_2, 
								Empleados.apellidos AS apellidos, Empleados.apellidos_2 AS apellidos_2, Empleados.id AS id_empleado  
								FROM Organigrama 
								LEFT JOIN Empleados ON Empleados.id = Organigrama.id_empleado
								WHERE Organigrama.id_equipo = '".$data["id_equipo"]."' 
                                AND Empleados.estado = 1 GROUP BY Empleados.id 
								ORDER BY Empleados.nombre ASC 
							";
                            $queryList = mysqli_query($connect_valentina, $sentencia);  
                            while($dataList = mysqli_fetch_array($queryList)){

                                $colaborador = $ClassCollaborators->colaborador( $connect_valentina, $dataList["id_empleado"] );

                                if($data["id_depende"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$colaborador[0]["nombre_completo"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$colaborador[0]["nombre_completo"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
                
                

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Estado</label>
                    <select class="form-control" name="estado" id="estado" required>
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

    var api = '<?php echo $url; ?>/api/administrar/';

    function CargarNivelJerarquia(id){
        /*
        $('#jerarquia').html('');
        jQuery.ajax({
            url: api+"cargar_niveles_jerarquia.php",
            type:'post',
            data: {id: id},
            }).done(function (resp){
                $("#jerarquia").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
        */
    }
    
    var activar = false;
    function Elimimar_Area(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un área, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Area('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_area.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/estructura"},
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
	<?php
	if($id_equipo && !$id){
		echo 'Cargar_Dependientes('.$id_equipo.')';
		
	}
	?>
</script>

