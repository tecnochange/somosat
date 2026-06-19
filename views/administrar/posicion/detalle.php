<script>  
$(document).ready(function(){
    $("#bt_adm_posiciones").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = "";

    if($id ){
        $readonly = " readonly ";
    }

    //EDICION CREACION
	if($_POST["id_cargo"] != ""){
        
		if($_POST["id_registro"] != ""){
        
            $sentencia = "UPDATE Posiciones SET id_cargo = '".$_POST["id_cargo"]."', 
            id_nivel_cargo = '".$_POST["id_nivel_cargo"]."',
            id_area = '".$_POST["id_area"]."', id_departamento = '".$_POST["id_departamento"]."', 
            estado = '".$_POST["estado"]."'  
            WHERE id = '".$_POST["id_registro"]."'  ";

			mysqli_query($connect_valentina, $sentencia);
            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
		}
		else{
            
            $sentencia = "INSERT INTO Posiciones 
            (id_cargo, id_nivel_cargo, id_area, id_departamento, estado, created_at ) 
			VALUES 
			( '".$_POST["id_cargo"]."', '".$_POST["id_nivel_cargo"]."', '".$_POST["id_area"]."', '".$_POST["id_departamento"]."', '".$_POST["estado"]."', '".$hoy."' ) ";
            
			mysqli_query($connect_valentina, $sentencia);  
            echo '<script> window.location = "?pg=administrar/posiciones";</script>';//para evitar reinsersion  
		} 
        
        
	}
	
	
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

?>




<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/posiciones">Posiciones</a></li>
        	<li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
		</ol>
	</nav>
	
	<?php echo $respuesta; ?>
	
	<div class="card">
        
		<div class="card-body"> 
			<h2>Detalle Posición</h2>
			
			<form action="" method="post">
            <div class="row">

                <input type="hidden" name="id_registro" value="<?php echo $id; ?>" >

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Cargo *</label>
                    <select class="form-control" name="id_cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Cargos_Copia ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_cargo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nivel Cargo *</label>
                    <select class="form-control" name="id_nivel_cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_nivel_cargo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Area *</label>
                    <select class="form-control" name="id_area" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Areas_Copia ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_area"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Departamento *</label>
                    <select class="form-control" name="id_departamento" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Areas_Copia ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_departamento"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Estado</label>
                    <select class="form-control" name="estado" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Estado as $estado){  
                            if($estado[0] == $data["estado"]){
                                echo '<option value="'.$estado[0].'" selected>'.$estado[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$estado[0].'">'.$estado[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-12" style="margin-bottom: 10px" align="right">

                    <button type="submit" id="sidebarCollapse" class="btn btn-primary btn-block" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>
            </div>
            </form>
			
		</div>
		
	</div>
		
	
</div>


