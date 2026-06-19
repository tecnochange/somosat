<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

<?php
	//VALIDAMOS DE PERMISOS
	if($_SESSION['role_plataforma']  >= 3){
		echo ' <script> window.location = "?pg=home"; </script> ';
	}
?>

<?php
	$hoy = date("Y-m-d H:i:s");
	$ahora = date("Y-m-d");


    //CREAR EDITAR COLABORADOR DATOS ADICIONALES_NUE
    if($_POST["guardar_adicional"] != ""){

        if($_POST["id_informacion_adicional"] != ""){
            
            $sentencia_adicional = "
			UPDATE  Empleados_Remuneracion  SET  
			salario = '".$_POST["salario"]."', 
			tickets = '".$_POST["tickets"]."', 
			comision_out = '".$_POST["comision_out"]."', 
			comision_back = '".$_POST["comision_back"]."', 
			comision_ventas = '".$_POST["comision_ventas"]."', 
			comision_ventas_dls = '".$_POST["comision_ventas_dls"]."', 
			viaticos = '".$_POST["viaticos"]."', 
			prima_antiguedad = '".$_POST["prima_antiguedad"]."', 
			horas_extra = '".$_POST["horas_extra"]."', 
			guardia = '".$_POST["guardia"]."', 
			guardia_var = '".$_POST["guardia_var"]."', 
			canasta  = '".$_POST["canasta"]."', 
			bono = '".$_POST["bono"]."', 
			comision_otro = '".$_POST["comision_otro"]."', 
			otro  = '".$_POST["otro"]."'
			WHERE id = '".$_POST["id_informacion_adicional"]."' 
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
			INSERT INTO Empleados_Remuneracion ( id_empleado ,  salario ,  tickets ,  comision_out ,  comision_back ,  comision_ventas ,  comision_ventas_dls ,  viaticos ,  prima_antiguedad ,  horas_extra ,  guardia ,  guardia_var ,  canasta ,  bono ,  comision_otro ,  otro ,  created_at )
			VALUES 
			( '".$_SESSION["id_colaborador_edit"]."' ,  '".$_POST["salario"]."', '".$_POST["tickets"]."',  '".$_POST["comision_out"]."', '".$_POST["comision_back"]."', '".$_POST["comision_ventas"]."',  '".$_POST["comision_ventas_dls"]."' ,  '".$_POST["viaticos"]."' ,  '".$_POST["prima_antiguedad"]."' ,  '".$_POST["horas_extra"]."' , '".$_POST["guardia"]."' ,  '".$_POST["guardia_var"]."' ,  '".$_POST["canasta"]."' ,  '".$_POST["bono"]."' ,  '".$_POST["comision_otro"]."' ,  '".$_POST["otro"]."' ,  '".$hoy."' )
            ";

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

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Remuneracion WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

	
	

?>

<style>
    .form-control{
        text-transform: uppercase;
    }
</style>

<div class="container"> 
    
    <?php include("views/administrar/colaborador/navegacion.php"); ?>
    
    <?php echo $respuesta; ?>
	<?php echo $alertas; ?>
	
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/detalle" class="nav-link ">Básicos</a>
		</li>
		<?php if($_SESSION["id_colaborador_edit"]){ ?>

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
		<li class="nav-item">
			<a href="<?php echo $url; ?>?pg=administrar/colaborador/remuneracion" class="nav-link active"> Remuneración</a>
		</li>
		<?php } ?>
	</ul>

    <div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                
                <div class="col-md-12" style="margin-bottom: 30px">
                    <input type="hidden" name="id_informacion_adicional" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>
                
                <div class="col-md-12"style="margin-bottom: 15px">
                    <h2>Remuneración</h2>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Salario Nominal/Facturación: *</label>
                    <input type="text" class="form-control" name="salario" value="<?php echo $dataInforma["salario"]; ?>" required >
                </div>

				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Tickets</label>
                    <input type="text" class="form-control" name="tickets" value="<?php echo $dataInforma["tickets"]; ?>"  >
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Comisión por servicio Outsourcing</label>
                    <input type="text" class="form-control" name="comision_out" value="<?php echo $dataInforma["comision_out"]; ?>"  >
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Comisión por backup</label>
                    <input type="text" class="form-control" name="comision_back" value="<?php echo $dataInforma["comision_back"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Comisión por ventas pesos uruguayos</label>
                    <input type="text" class="form-control" name="comision_ventas" value="<?php echo $dataInforma["comision_ventas"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Comisión por ventas dólares</label>
                    <input type="text" class="form-control" name="comision_ventas_dls" value="<?php echo $dataInforma["comision_ventas_dls"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Viático</label>
                    <input type="text" class="form-control" name="viaticos" value="<?php echo $dataInforma["viaticos"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Prima antigüedad</label>
                    <input type="text" class="form-control" name="prima_antiguedad" value="<?php echo $dataInforma["prima_antiguedad"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Horas Extras</label>
                    <input type="text" class="form-control" name="horas_extra" value="<?php echo $dataInforma["horas_extra"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Guardia</label>
                    <input type="text" class="form-control" name="guardia" value="<?php echo $dataInforma["guardia"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Guardia Variable</label>
                    <input type="text" class="form-control" name="guardia_var" value="<?php echo $dataInforma["guardia_var"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Canasta</label>
                    <input type="text" class="form-control" name="canasta" value="<?php echo $dataInforma["canasta"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Bono</label>
                    <input type="text" class="form-control" name="bono" value="<?php echo $dataInforma["bono"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Comisión (por otros conceptos)</label>
                    <input type="text" class="form-control" name="comision_otro" value="<?php echo $dataInforma["comision_otro"]; ?>" >
                </div>
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Otros</label>
                    <input type="text" class="form-control" name="otro" value="<?php echo $dataInforma["otro"]; ?>" >
                </div>
				
				
				
                

                <div class="col-md-12" style="margin-bottom: 10px; margin-top: 30px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-primary btn-block" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>
				
				
				
				

            </div>
            </form>
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
var api = '<?php echo $url; ?>/api/administrar/';

function Cargar_Posiciones(id_cargo){
	
	
	jQuery.ajax({
		url: api+"cargar_posiciones.php",
		type:'post',
		data: {id_cargo: id_cargo, id_posicion: <?php echo $id_posicion; ?>, url:""},
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

</script>


<script>

var api = '<?php echo $url; ?>/api/administrar/';

function CargarDepartamento(id_pais){
	jQuery.ajax({
		url: api+"departamentos_admin.php",
		type:'post',
		data: {id_pais: id_pais},
		}).done(function (resp){
			$("#departamento_nacimiento").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
    
    function CargarCiudades(id_dep){
	jQuery.ajax({
		url: api+"lista_ciudades.php",
		type:'post',
		data: {id_dep: id_dep},
		}).done(function (resp){
			$("#ciudad_residencia").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
    
function CargarDepartamentoRes(id_pais){
	jQuery.ajax({
		url: api+"departamentos_admin.php",
		type:'post',
		data: {id_pais: id_pais},
		}).done(function (resp){
			$("#departamento_residencia").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
}
    
    
    function CargarCiudadesNacimiento(id_dep){
        jQuery.ajax({
            url: api+"lista_ciudades.php",
            type:'post',
            data: {id_dep: id_dep},
            }).done(function (resp){
                $("#ciudad_nacimiento").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
    }
    
var api = '<?php echo $url; ?>/api/administrar/';
    
function Eliminar(id_registro){
	jQuery.ajax({
		url: api+"eliminar_doc_adicional.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>/?pg=administrar/colaborador/adicionales"},
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
        
        
        <?php
        if($dataInforma["dotacion_aplica"] == 1){
        ?>
        MostrarDotacion(1)
        <?php
        }
        ?>
        
        <?php
        if($dataInforma["pais_residencia"] == 1){
        ?>
        MostrarPais(1)
        <?php
        }
        ?>
        
    });

    
  
</script>



