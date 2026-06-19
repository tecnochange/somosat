<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_licencias").addClass("active_item");
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//PARA CREAR O EDITAR UN NUEVO REGISTRO
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
		}
		else{
            
            $sentencia = "INSERT INTO Vacaciones (nombre, jerarquia, padre, codigo, estado, created_at ) 
			VALUES 
			( '".$_POST["nombre"]."', '".$_POST["jerarquia"]."', '".$_POST["padre"]."', '".$_POST["padre"]."', 1, '".$hoy."' ) ";
			mysqli_query($connect_valentina, $sentencia);  
            echo '<script> window.location = "?pg=administrar/areas";</script>';//para evitar reinsersion  
		}
	}

    
	//INFORMACION DEL REGISTRO
	$query = mysqli_query($connect_novedades,"SELECT * FROM Vacaciones WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>


 
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3>Licencias</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=novedades/permisos">Licencias</a></li> 
                    <li class="breadcrumb-item">Detalle</li> 
                </ol>
            </div>
        </div>
    </div>
</div>
    
<?php echo $respuesta; ?>

<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Registro de solicitud de licencias remuneradas y no remuneradas</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                    <input type="hidden" name="padre" value="<?php echo $data["padre"]; ?>">
                    
                    <div>
                        Fecha de solicitud: <b><?php echo date("Y-m-d"); ?></b><br>
                        De: <b><?php echo $user_log['nombre']." ".$user_log['nombre_2']." ".$user_log['apellidos']." ".$user_log['apellidos_2']; ?></b><br>
                        Cargo: <b><?php echo $user_log['cargo']; ?></b><br>
                    </div>
                    
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 25px">
                    Por medio del presente me permito solicitar sea aprobados <input type="text" width="100"> días de  
                    <select>
                        <option></option>
                    </select>
                    del <input type="date"> hasta <input type="date">
                    
                </div>

                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Observaciones</label>
                    <textarea class="form-control" name="motivos"><?php echo $data["motivos"]; ?></textarea>
                </div>
              
              
                <div class="col-md-12" style="margin-bottom: 10px" align="right">
                    <hr>
                    <button type="submit" class="btn btn-primary" >
                        <i class="fa fa-check"></i> Radicar
                    </button>
 
                </div>
            </div>
            </form>
        </div> 
        
</div>


<script>

    var api = '<?php echo $url; ?>/estilocontigo.app/api/administrar/';

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


<script>
    $("#bt_adm_areas").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>