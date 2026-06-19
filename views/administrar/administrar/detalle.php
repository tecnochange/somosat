<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["dependencia"] != ""){
        
               
        $querySubGerencias = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$_POST["dependencia"]."' ");  
        $dataSubGerencias = mysqli_fetch_array($querySubGerencias);

		if($_POST["id_registro"] != ""){
            
            //CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
            //CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES 
            
            $querySubGerenciasTmp = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$_POST["dependencia"]."' ");  
            $dataSubGerenciasTmp = mysqli_fetch_array($querySubGerenciasTmp);
            
            $resumen = 'Edición Areas:\n';
            if($dataSubGerenciasTmp["nombre"] != $_POST["nombre"] ){ $resumen .= 'Nombre: '.$_POST["nombre"].'\n'; }
            if($dataSubGerenciasTmp["jerarquia"] != $_POST["jerarquia"] ){ $resumen .= 'Jerarquia: '.$_POST["jerarquia"].'\n'; }
            if($dataSubGerenciasTmp["subgerencia"] != $_POST["subgerencia"] ){ $resumen .= 'Subgerencia: '.$_POST["subgerencia"].'\n'; }
            if($dataSubGerenciasTmp["padre"] != $_POST["padre"] ){ $resumen .= 'Padre: '.$_POST["padre"].'\n'; }
            if($dataSubGerenciasTmp["estado"] != $_POST["estado"] ){ $resumen .= 'Estado: '.$_POST["estado"].'\n'; }
            
            GuardarNovedad($connect_valentina, "Edición Areas", $_SESSION["id_user_valentina"], $resumen, $_POST["id_registro"] );
			//CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
			//CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
            
			mysqli_query($connect_valentina,"
            UPDATE Areas SET 
            nombre = '".$_POST["nombre"]."', 
            jerarquia = '".$_POST["jerarquia"]."', 
            subgerencia = '".$dataSubGerencias["nombre"]."', 
			padre = '".$_POST["dependencia"]."', 
            estado = '".$_POST["estado"]."'  
            WHERE id = '".$_POST["id_registro"]."'  ");
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
            
            //CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
			//CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
            $resumen = 'Creación Areas:\n';
            if($dataSubGerenciasTmp["nombre"] != $_POST["nombre"] ){ $resumen .= 'Nombre: '.$_POST["nombre"].'\n'; }
            if($dataSubGerenciasTmp["jerarquia"] != $_POST["jerarquia"] ){ $resumen .= 'Jerarquia: '.$_POST["jerarquia"].'\n'; }
            if($dataSubGerenciasTmp["subgerencia"] != $_POST["subgerencia"] ){ $resumen .= 'Subgerencia: '.$_POST["subgerencia"].'\n'; }
            if($dataSubGerenciasTmp["padre"] != $_POST["padre"] ){ $resumen .= 'Padre: '.$_POST["padre"].'\n'; }
            if($dataSubGerenciasTmp["estado"] != $_POST["estado"] ){ $resumen .= 'Estado: '.$_POST["estado"].'\n'; }
            
            GuardarNovedad($connect_valentina, "Creación Areas", $_SESSION["id_user_valentina"], $resumen, 0 );
			//CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
			//CODIGO PARA OBTENER LOS DATOS QUE SERÁN GUARDADOS EN LAS NOVEDADES
            
            mysqli_query($connect_valentina,"
            INSERT INTO Areas ( nombre, jerarquia, subgerencia, padre, estado, created_at) 
            VALUES 
            ( '".$_POST["nombre"]."', '".$_POST["jerarquia"]."', '".$dataSubGerencias["nombre"]."', '".$_POST["dependencia"]."', '".$_POST["estado"]."',  '".$hoy."'  )
            ");
            
            echo '
            <script>
                window.location = "?pg=administrar/areas";
            </script>
            ';
			
		}
	}
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>




 
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/areas">Áreas</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
    </ol>
</nav>
    
<?php echo $respuesta; ?>

<div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Departamento</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Jerarquia</label>
                    <input type="text" class="form-control" name="jerarquia" value="<?php echo $data["jerarquia"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Subgerencia</label>
                    <select class="form-control" name="dependencia" required>
                        <option value="0" selected>Inicial</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryJer)){
                            if($data["padre"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].'</option>';
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