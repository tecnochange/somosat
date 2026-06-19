<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["id_empleado"] != ""){

        mysqli_query($connect_valoracion,"INSERT INTO Evaluadores (id_empresa, anio, id_ciclo, id_empleado, id_evaluador, tipo, created_at ) 
        VALUES 
        ( '".$_SESSION['id_empresa']."', '".$_SESSION["anio"]."', '".$_SESSION['ciclo']."', '".$_POST["id_empleado"]."', '".$_POST["id_evaluador"]."', '".$_POST["tipo"]."', '".$hoy."' ) ");  
		
        echo '<script> window.location = "?pg=valoracion/arbol/agregar&id='.$id.'";</script>';//para evitar reinsersion  
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT emp.id, emp.nombre, emp.nombre_2, emp.apellidos, emp.apellidos_2, ad.preferencia FROM Empleados as emp 
    INNER JOIN Empleados_Adicionales as ad 
    on ad.id_empleado = emp.id 
    WHERE emp.id = '".$id."' ");
	$data = mysqli_fetch_array($query);

    if($data["preferencia"]){
        $nombreCompleto = $data["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"];
    }else{
        $nombreCompleto = $data["nombre"]." ".$data["nombre_2"]."".$data["apellidos"]." ".$data["apellidos_2"];
    }
	
?>



<div class="container-fluid"> 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=valoracion/arbol">Arbol Valoración</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Agregar Jefe</a></li>
      </ol>
    </nav>

    <div class="card">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Evaluador</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <lable>Empleado</lable>
                    <input type="text" class="form-control" value="<?php echo $nombreCompleto; ?>" disabled >
                    <input type="hidden" value="<?php echo $id; ?>" name="id_empleado">
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Tipo evaluador</lable>
                    <select class="form-control" name="tipo" onChange="CargarEvaluador(this.value)">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($array_Tipo_Colaborador as $tipo){
                            echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <lable>Evaluador</lable>
                    <select class="form-control" name="id_evaluador" id="id_evaluador" required>
                        <option value="">Selecciona..</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT emp.id, emp.nombre, emp.nombre_2, emp.apellidos, emp.apellidos_2, ad.preferencia FROM Empleados as emp 
                        INNER JOIN Empleados_Adicionales as ad 
                        on ad.id_empleado = emp.id
                        WHERE emp.id != '".$id."' AND emp.id_empresa = '".$_SESSION["id_empresa"]."' AND emp.role > 1 
                        ORDER BY nombre ASC ");  

                        while($dataJer = mysqli_fetch_array($queryJer)){

                            if($dataJer["preferencia"]){
                                $nombreCompletoJ = $dataJer["preferencia"]." ".$dataJer["apellidos"]." ".$dataJer["apellidos_2"];
                            }else{
                                $nombreCompletoJ = $dataJer["nombre"]." ".$dataJer["nombre_2"]."".$dataJer["apellidos"]." ".$dataJer["apellidos_2"];
                            }

                            if($data["id_jefe"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$nombreCompletoJ.'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$nombreCompletoJ.'</option>';
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
   
    
    
    
    
    
    
    
    <table class="table table-bordered" style="margin-top: 15px">
        <thead class="thead-success">
                <tr>
                    <th scope="col">Evaluador</th>
                    <th scope="col">Tipo</th>
                    <th scope="col" width="30"></th>
                </tr>
        </thead>

        <tbody id="tabla_lista">
            
             <?php
            $queryJefes = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id."' AND id_ciclo = '".$_SESSION["ciclo"]."' AND anio = '".$_SESSION["anio"]."' ");  
            while($dataJefes = mysqli_fetch_array($queryJefes)){
                
                $queryEm = mysqli_query($connect_valentina,"SELECT emp.id, emp.nombre, emp.nombre_2, emp.apellidos, emp.apellidos_2, ad.preferencia FROM Empleados as emp 
                INNER JOIN Empleados_Adicionales as ad 
                on ad.id_empleado = emp.id
                WHERE emp.id = '".$dataJefes["id_evaluador"]."' ");  
                $dataEm = mysqli_fetch_array($queryEm);
                
                if($dataEm["preferencia"]){
                    $nombreCompletoEmp = $dataEm["preferencia"]." ".$dataEm["apellidos"]." ".$dataEm["apellidos_2"];
                }else{
                    $nombreCompletoEmp = $dataEm["nombre"]." ".$dataEm["nombre_2"]."".$dataEm["apellidos"]." ".$dataEm["apellidos_2"];
                }

                $tipo_txt = '';
                foreach($array_Tipo_Colaborador as $tipo){
                    if($tipo[0] == $dataJefes["tipo"]){
                        $tipo_txt =  '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                    }
                }
                
                
                echo '
                <tr>
                    <td>'.$nombreCompletoEmp.'</td>
                    <td>'.$tipo_txt.'</td>
                    <td>
                        <button type="button" id="sidebarCollapse" class="btn btn-danger btn-sm" title="Quitar jefe" onclick="Elimimar_Evaluador('.$dataJefes["id"].')">
                                <i class="fas fa-times"></i> 
                        </button>
                    </td>
                </tr>
                ';
            }
            ?>
            
        </tbody>
    </table>
    
    
    
    
    
    
    
    
    
    
    
    
    
</div>

<script>
    var api = '<?php echo $url; ?>/api/valoracion/';

    function CargarEvaluador(tipo){
        $('#id_evaluador').html('');
        jQuery.ajax({
            url: api+"cargar_evaluador_new.php",
            type:'post',
            data: {tipo: tipo, id: <?php echo $id; ?>, id_empresa: <?php echo $_SESSION["id_empresa"]; ?>, ciclo: <?php echo $_SESSION["ciclo"]; ?>, anio: <?php echo $_SESSION["anio"]; ?> },
            }).done(function (resp){
                $("#id_evaluador").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
    }
    
    var activar = false;
    function Elimimar_Evaluador(id){
        
        if(activar == false){
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un evaluador, <b>ESTO ELIMINARÁ LAS EVALUACIONES QUE REALIZÓ EL EVALUADOR</b>, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Evaluador('+id+')"> Confirmar </button>');  
        }
        else{
            
            jQuery.ajax({
                url: api+"eliminar_evaluador.php",
                type:'post',
                data: {id: id, url:"?pg=valoracion/arbol/agregar&id=<?php echo $id; ?>"},
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
    $("#bt_val_arbol").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>