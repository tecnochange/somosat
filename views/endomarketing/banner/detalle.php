<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["titulo"] != ""){
		
		include("app/controllers/subir_documento.php");

		if($_POST["id_registro"] != ""){
			mysqli_query($connect_endomarketing,"UPDATE Banners SET titulo = '".$_POST["titulo"]."', link = '".$_POST["link"]."', orden = '".$_POST["orden"]."', estado = '".$_POST["estado"]."' WHERE id = '".$_POST["id_registro"]."'  ");
			
			if( $_FILES['archivo']["name"] ){
				$archivo = Subir_Documento($_FILES['archivo']);
				mysqli_query($connect_endomarketing,"UPDATE Banners SET archivo = '".$archivo."'  WHERE id = '".$_POST["id_registro"]."'  ");
			}
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
			
			$archivo = Subir_Documentos($_FILES['archivo']);
			
			mysqli_query($connect_endomarketing,"INSERT INTO Banners (id_empresa, titulo, archivo, link, orden, estado, created_at ) 
			VALUES 
			( '1', '".$_POST["titulo"]."', '".$archivo."', '".$_POST["link"]."', '".$_POST["orden"]."', '".$_POST["estado"]."', '".$hoy."' ) "); 

            echo '<script> window.location = "?pg=endomarketing/banners";</script>';
		}
        
        
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_endomarketing,"SELECT * FROM Banners WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);
	
?>


 
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=endomarketing/banners">Banners</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
    </ol>
</nav>
    
<?php echo $respuesta; ?>

<div class="card">
        
        <div class="card-body">   
            <form action="" method="post" enctype="multipart/form-data" >
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Banner</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Titulo</label>
                    <input type="text" class="form-control" name="titulo" value="<?php echo $data["titulo"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Link</label>
                    <input type="text" class="form-control" name="link" value="<?php echo $data["link"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Orden</label>
                    <input type="text" class="form-control" name="orden" value="<?php echo $data["orden"]; ?>">
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Imágen (El archivo no debe pasar los 1.9 megas)</label>
                    <input type="file" name="archivo" class="form-control"  accept="image/*" >
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
$( document ).ready(function() {
	$('#menuEndomarketing').collapse();
    $("#bt_endo_banners").addClass("active");
});
</script>
