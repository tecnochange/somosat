<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  != 1){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<?php
	$hoy = date("Y-m-d H:i:s");
    $id = $_GET["id"];
	
    if( $_POST["anio"] != "" ){
        $_SESSION['anio'] = $_POST["anio"];
    }

    if($_POST["accion"] != ""){

	   if($_POST["id_registro"] != ""){
			mysqli_query($connect_valoracion,"UPDATE Competencias_Acciones SET accion = '".$_POST["accion"]."' WHERE id = '".$_POST["id_registro"]."' ");
		}
		else{
            foreach($_POST["accion"] as $action){
                if($action){
                    mysqli_query($connect_valoracion,"INSERT INTO Competencias_Acciones (id_empresa, anio, id_ciclo, id_tipo, id_nivel, id_competencia, accion, created_at) 
                    VALUES 
                    ( '".$dtEmpleado['id_empresa']."', '".$_SESSION['anio']."', '".$_SESSION['ciclo']."', '".$_POST["tipo"]."', '".$_POST["nivel"]."', '".$_POST["competencia"]."', '".$action."', '".$hoy."' ) ");
                }
            }
			
			
		}
        
        echo '
            <script> window.location = "'.$url.'/?pg=valoracion/competencias_acciones"; </script>
        ';
       
    }

    //TIPOS
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}

    $queryA = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Acciones WHERE id = '".$id."' ");
	$dataA = mysqli_fetch_array($queryA);

?>



<?php include("views/valoracion/layouts/ficha_informe_competencia.php"); ?>
<?php echo $respuesta; ?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Valoración de competencias</li>
      <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $url; ?>?pg=valoracion/competencias_acciones">Acciones desarrollo</a></li>
    <li class="breadcrumb-item active" aria-current="page"><b>DETALLE ACCIONES</b></li>
  </ol>
</nav>


<div class="card">
    
    <div class="card-body">

        <form action="" method="post">
        <input type="hidden" name="id_registro" value="<?php echo $id; ?>"/>
        <div class="row">
                        
            <?php if($id == ""){ ?>
            <div class="col-md-12">
                <label class="ti_label">Tipo de Competencia</label>
                <select class="form-control" name="tipo" id="tipo" onChange="CargarNivel(this.value)">
                    <option value="">Selecciona</option>
                    <?php
                        $queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos 
                        WHERE id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
                        while($dataT = mysqli_fetch_array($queryT)){
                            if($dataT["id"] == $dataA["id_tipo"]){
                                echo '<option value="'.$dataT["id"].'" selected >'.$dataT["nombre"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataT["id"].'">'.$dataT["nombre"].'</option>';
                            }
                        }
                    ?>
                </select> 
            </div>
                        
            <div class="col-md-12">
                          	<label class="ti_label">Nivel</label>
                            <div id="cont_nivel">
                                <select class="form-control">
                                </select>
                            </div>
            </div>
                        
            <div class="col-md-12">
                          	<label class="ti_label">Competencia</label>
                            <div id="cont_competencias">
                                <select class="form-control">
                                </select>
                            </div>
                            
            </div>
            <?php } ?>
                        
            <div class="col-md-12" >
                <div id="ref_accion">
                    <label class="ti_label">Acción</label>
                    <textarea class="form-control" name="accion[]" placeholder="Ingrese..." rows="3"><?php echo $dataA["accion"]; ?></textarea>
                </div>
                <div id="list_nuevos">
                </div>
            </div>
            
            <div class="col-md-12" >
                <button type="button" class="btn btn-primary"  onClick="AgregarNuevo()">Nueva Acción</button>
            </div>
            
            
                        
                        
                        
            <div class="col-md-12" style="margin-top:15px; text-align: right;">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
                        
					</div>
        </form>

    </div>
    
</div>



















<script>
    var api = '<?php echo $url; ?>api/valoracion/';

    function CargarNivel(id){
        $('#cont_nivel').html('');
        jQuery.ajax({
            url: api+"cargar_niveles.php",
            type:'post',
            data: {id: id, id_empresa: <?php echo $dtEmpleado['id_empresa']; ?>, anio: "<?php echo $_SESSION['anio']; ?>"  },
            }).done(function (resp){
                $("#cont_nivel").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
    }


    function CargarCompetencias(id){
        $('#cont_competencias').html('');
        jQuery.ajax({
            url: api+"cargar_competencias.php",
            type:'post',
            data: {id: $("#tipo").val(), nivel: id},
            }).done(function (resp){
                $("#cont_competencias").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
    }
    
var ref_accion = '';
$( document ).ready(function() {
     ref_accion = $("#ref_accion").html();
});

    
function AgregarNuevo(){
    $("#list_nuevos").append( ref_accion );
}
    
</script>

<script>
    $("#bt_val_competencias").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
}
</style>

<?php if($id != ""){ ?>

<?php } ?>

