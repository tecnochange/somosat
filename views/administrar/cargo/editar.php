<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	//CONSULTA PARA NUEVO CLIENTE
	//CONSULTA PARA NUEVO CLIENTE
	if($_POST["nombre"] != ""){

		if($_POST["id_registro"] != ""){
			mysqli_query($connect_valentina,"UPDATE Cargos SET 
            nivel_cargo = '".$_POST["nivel_cargo"]."', 
            nivel_organizacion = '".$_POST["nivel_organizacion"]."', 
            nombre = '".$_POST["nombre"]."', 
            id_area = '".$_POST["id_area"]."', 
            id_direccion ='".$_POST["id_direccion"]."', 
            no_empleados ='".$_POST["no_empleados"]."', 
            
            
            padre = '".$_POST["padre"]."', 
            pais = '".$_POST["pais"]."', 
            ciudad = '".$_POST["ciudad"]."', 
            canal = '".$_POST["canal"]."', 
            centro_costo = '".$_POST["centro_costo"]."', 
            estado = '".$_POST["estado"]."'  
            WHERE id = '".$_POST["id_registro"]."'  ");
		}
		else{
			mysqli_query($connect_valentina,"INSERT INTO Cargos ( nivel_cargo, nivel_organizacion, nombre, id_area, 
            id_direccion, padre, no_empleados, pais, ciudad, canal, centro_costo, estado, created_at ) 
			VALUES 
			( '".$_POST["nivel_cargo"]."', '".$_POST["nivel_organizacion"]."', '".$_POST["nombre"]."', '".$_POST["id_area"]."', 
            '".$_POST["id_direccion"]."', '".$_POST["padre"]."', '".$_POST["no_empleados"]."', '".$_POST["pais"]."', '".$_POST["ciudad"]."', '".$_POST["canal"]."', 
            '".$_POST["centro_costo"]."', '".$_POST["estado"]."', '".$hoy."' ) ");  
		}

        echo '<script> window.location = "?pg=administrar/cargos";</script>';//para evitar reinsersion  
	}
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$id."'  ");
	$data = mysqli_fetch_array($query);	
?>
  
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/cargos">Administrar Cargos</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Cargo</a></li>
      </ol>
</nav>
    
<ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="<?php echo $url; ?>?pg=administrar/cargo&id<?php echo $id; ?>" class="nav-link active" >Configuración</a>
        </li>

        <li class="nav-item">
            <a href="<?php echo $url; ?>?pg=administrar/cargo/cargos_estructura" class="nav-link">Descriptivo</a>
        </li>
        
        <li class="nav-item">
            <a href="<?php echo $url; ?>?pg=administrar/cargo/cargos_estructura" class="nav-link">Perfil</a>
        </li>
        
        <li class="nav-item">
            <a href="<?php echo $url; ?>?pg=administrar/cargo/cargos_estructura" class="nav-link">Remuneración</a>
        </li>
        
        <li class="nav-item">
            <a href="<?php echo $url; ?>?pg=administrar/cargo/cargos_estructura" class="nav-link">Política</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $url; ?>?pg=administrar/cargo/cargos_estructura" class="nav-link">Valoración</a>
        </li>
        
</ul>
    

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
                    <input type="text" class="form-control" name="nombre" value="<?php echo $data["nombre"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nivel Jerárquico <i class="fas fa-info-circle info" onClick="Ver_Info(1)" ></i></label>
                    <select class="form-control" name="nivel_cargo">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Nivel_Cargo as $nivel){
                            if($data["nivel_cargo"] == $nivel[0] ){
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
                    <label>Nivel Organizacional </label>
                    <select class="form-control" name="nivel_organizacion">
                        <option value="">Selecciona..</option>
                        <?php
                        foreach($Array_Nivel_Organizacional as $nivel){
                            if($data["nivel_organizacion"] == $nivel[0] ){
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
                    <label>Cargo Reporte</label>
                    <select class="form-control" name="padre">
                        <option value="0">Sin reporte..</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryJer)){
                            if($data["padre"] == $dataJer["id"] ){
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
                    <label>Área</label>
                    <select class="form-control" name="id_area">
                        <option value="">Selecciona..</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Areas  ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryJer)){
                            if($data["id_area"] == $dataJer["id"] ){
                                echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].' - '.$dataJer["jerarquia"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].' - '.$dataJer["jerarquia"].'</option>';
                            }
                            
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Dirección</label>
                    <select class="form-control" name="id_direccion">
                        <option value="">Selecciona..</option>
                        <?php
                        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Direcciones ORDER BY nombre ASC ");  
                        while($dataJer = mysqli_fetch_array($queryJer)){
                            if($data["id_direccion"] == $dataJer["id"] ){
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
                    <label>No. personas atorizadas en el cargo</label>
                    <input type="number" max="1000" class="form-control" name="no_empleados" value="<?php echo $data["no_empleados"]; ?>">
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
                    <h2>Posición del cargo</h2>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>País</lable>
                    <input type="text" class="form-control" name="pais" value="<?php echo $data["pais"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Ciudad</lable>
                    <input type="text" class="form-control" name="ciudad" value="<?php echo $data["ciudad"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Canal </lable>
                    <input type="text" class="form-control" name="canal" value="<?php echo $data["canal"]; ?>">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <lable>Centro de Costos</lable>
                    <input type="text" class="form-control" name="centro_costo" value="<?php echo $data["centro_costo"]; ?>">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" id="sidebarCollapse" class="btn btn-success btn-block btn-sm" >
                        <i class="fas fa-check"></i> Guardar
                    </button>
                </div>
                
                <?php if($id){ ?>
                <div class="col-md-12" style="margin-tp: 30px; display: none">
                    <button type="button"  class="btn btn-danger btn-sm" onClick="Elimimar_Cargo(<?php echo $id; ?>)" >
                        <i class="fas fa-time"></i> Eliminar
                    </button>
                </div>
                <?php } ?>

            </div>
            </form>
        </div> 
        
</div>
    
    
<div class="card">
    <div class="card-body">
        
        <div class="row">
        
            <div class="col-md-12" align="center">
                <h2>Autorizaciones</h2>
            </div>

            <div class="col-md-3">
                        <label class="ti_label">* Autorización 1 (requerido)</label>
                        <select class="form-control" name="aut_1" required>
                            <option value="">Selecciona...</option>
                            <?php
                            $queryJf = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE role = 2 ORDER BY nombre ASC ");  
                            while($dataJf = mysqli_fetch_array($queryJf)){ 
                                if( $data['aut_1'] == $dataJf["id"]){
                                    echo '<option value="'.$dataJf["id"].'" selected>'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>';
                                }
                                else{
                                   echo '<option value="'.$dataJf["id"].'">'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>'; 
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="ti_label">Autorización 2</label>
                        <select class="form-control" name="aut_2">
                            <option value="">--</option>
                            <?php
                            $queryJf = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE role = 2 ORDER BY nombre ASC ");  
                            while($dataJf = mysqli_fetch_array($queryJf)){ 
                                if( $data['aut_2'] == $dataJf["id"]){
                                    echo '<option value="'.$dataJf["id"].'" selected>'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>';
                                }
                                else{
                                   echo '<option value="'.$dataJf["id"].'">'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>'; 
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <label class="ti_label">Autorización 3</label>
                        <select class="form-control" name="aut_3" >
                            <option value="">--</option>
                            <?php
                            $queryJf = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE role = 2 ORDER BY nombre ASC ");  
                            while($dataJf = mysqli_fetch_array($queryJf)){ 
                                if( $data['aut_3'] == $dataJf["id"]){
                                    echo '<option value="'.$dataJf["id"].'" selected>'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>';
                                }
                                else{
                                   echo '<option value="'.$dataJf["id"].'">'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>'; 
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    
                    <div class="col-md-3">
                        <label class="ti_label">Autorización 4</label>
                        <select class="form-control" name="aut_4" >
                            <option value="">--</option>
                            <?php
                            $queryJf = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE role = 2 ORDER BY nombre ASC ");  
                            while($dataJf = mysqli_fetch_array($queryJf)){ 
                                if( $data['aut_4'] == $dataJf["id"]){
                                    echo '<option value="'.$dataJf["id"].'" selected>'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>';
                                }
                                else{
                                   echo '<option value="'.$dataJf["id"].'">'.$dataJf["nombre"].' '.$dataJf["apellidos"].'</option>'; 
                                }
                            }
                            ?>
                        </select>
                    </div>
            
            
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

<script>
    $("#bt_adm_cargos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
</script>