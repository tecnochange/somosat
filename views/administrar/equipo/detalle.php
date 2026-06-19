<script>  
$(document).ready(function(){
    $("#bt_adm_equipos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
			mysqli_query($connect_valentina,"UPDATE Equipos SET nombre = '".$_POST["nombre"]."', 
			estado = '".$_POST["estado"]."', ver_organigrama = '".$_POST["ver_organigrama"]."' 
			WHERE id = '".$_POST["id_registro"]."'  ");
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
			$sentencia = "
			INSERT INTO Equipos ( nombre,  estado,  ver_organigrama,  created_at ) 
			VALUES 
			( '".$_POST["nombre"]."', '".$_POST["estado"]."', '".$_POST["ver_organigrama"]."',  '".$hoy."' )
			";
			mysqli_query($connect_valentina,$sentencia);  
             
		}
		
		echo '<script> window.location = "?pg=administrar/equipos_lista";</script>';//para evitar reinsersion  
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Equipos WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>


 

    
<?php echo $respuesta; ?>

<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/equipos_lista">Equipos</a></li>
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
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Ver en organigrama</label>
                    <select class="form-control" name="ver_organigrama" required>
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Ver_organigrama as $nivel){
                            if($data["ver_organigrama"] == $nivel[0] ){
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
</script>

