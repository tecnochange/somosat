<script>  
$(document).ready(function(){
    $("#bt_adm_gerencias").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = '';

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
            $sentencia = "
            UPDATE Gerencias SET 
            nombre = '".$_POST["nombre"]."', 
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
            INSERT INTO Gerencias ( nombre, estado, created_at) 
            VALUES 
            ( '".$_POST["nombre"]."', '".$_POST["estado"]."', '".$hoy."'
            )
            ";
            
            //print_r($sentencia);
            
			mysqli_query($connect_valentina, $sentencia); 
            echo '<script> window.location = "?pg=administrar/gerencias";</script>';//para evitar reinsersion 
		}

         
	}

	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Gerencias WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);	
?>

<div class="container">
  
	<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/gerencias">Administrar Gerencias</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Puesto</a></li>
      </ol>
	</nav>

	<?php echo $respuesta; ?>


	<div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Puesto</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
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
	
	<?php if($id){ ?>
	<div align="right">
		<button type="submit" class="btn btn-danger btn-sm" onClick="Elimimar_Registro(<?php echo $id; ?>)" >
			<i class="fas fa-check"></i> Eliminar
		</button>
	</div>
	<?php } ?>
	
</div>   

<script>
    var api = '<?php echo $url; ?>/api/administrar/';
    
    var activar = false;
    function Elimimar_Registro(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un departamento, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Registro('+id+')"> Eliminar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_departamento.php",
                type:'post',
                data: {id: id, url:"?pg=administrar/gerencias"},
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
    

    function Ver_Info(tipo){
        if(tipo == 1){
            $("#modal_tooltips").modal("show");
            $("#body_tooltips").html("<h2>Nivel y Cargos Relacionados</h2>");
            $("#body_tooltips").append("1. Estratégicos: Presidente, Director, Gerente, Vicepresidente.<br> ");
            $("#body_tooltips").append("2. Táctico Administrativo: Subdirector, Subgerente, Jefe, Coordinador, Supervisor.<br> ");
            $("#body_tooltips").append("3. Táctico Comercial: Subdirector Comercial, Subgerente Comercial, Jefe Comercial, Coordinador Comercial, Supervisor Comercial, K.A.M. <br> ");
            $("#body_tooltips").append("4. Comercial: Vendedor, Representante, Visitador, Promotor. <br> ");
            $("#body_tooltips").append("5. Profesional sin personal a cargo: Profesionales sin colaboradores a cargo. <br> ");
            $("#body_tooltips").append("6. Operativo: Operarios, Auxiliares, Técnicos, Técnologos. <br> ");
            $("#body_tooltips").append("7. Apoyo Administrativo: Asistente administrativo, Auxiliar adminsitrativo, Soporte Administrativo. <br> ");
            $("#body_tooltips").append("8. Soporte Comercial: Auxiliar comercial, Asistente comercial, Call Center, Telemercadeo, Impulso. <br> ");
        }
    }
</script>

