<script>  
$(document).ready(function(){
    $("#bt_adm_directorio").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
 
	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

?>

<style>
	.fotos_galeria{
		transition: 0.5s all;

	}
	
	.fotos_galeria:hover{
		transform: scale(1.1);
		opacity: 0.8;
	}
	.form-control:disabled, .form-control[readonly]{
		background-color: #ffffff;
	}
</style>

<div class="container">
	
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/directorio">Directorio</a></li>
        	<li class="breadcrumb-item active" aria-current="page"><a href="">Resumen</a></li>
		</ol>
	</nav>
	
	
	<div class="card" style="margin-bottom: 20px">
        
		<div class="card-body"> 
			<h2>Resumen Colaborador</h2>
			
			<form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <input type="hidden" name="id_registro" value="<?php echo $_SESSION["id_colaborador_edit"]; ?>" >
				<input type="hidden" name="informacion_basica" value="true">
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Documento *</label>
                    <input type="text"  class="form-control" readonly name="documento" value="<?php echo $data["documento"]; ?>" required>
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Primer Nombre *</label>
                    <input type="text"  class="form-control" readonly name="nombre" value="<?php echo $data["nombre"]; ?>" required >
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Segundo Nombre:</label>
                    <input type="text"  class="form-control" readonly name="nombre_2" value="<?php echo $data["nombre_2"]; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label> Primer Apellido *</label>
                    <input type="text"  class="form-control" readonly name="apellidos" value="<?php echo $data["apellidos"]; ?>" required >
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Segundo Apellido:</label>
                    <input type="text"  class="form-control" readonly name="apellidos_2" value="<?php echo $data["apellidos_2"]; ?>" >
                </div>
				

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Cargo *</label>
                    <select class="form-control" name="id_cargo" readonly required >
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_cargo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Nivel Cargo *</label>
                    <select class="form-control" name="id_nivel_cargo" readonly required >
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_nivel_cargo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Area *</label>
                    <select class="form-control" name="id_area" readonly required >
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Areas ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_area"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label>Departamento *</label>
                    <select class="form-control" name="id_departamento" required readonly >
                        <?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Gerencias ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_departamento"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
				
				<div class="col-md-4" style="margin-bottom: 10px">
                    <label> Correo eléctrónico *</label>
                    <input type="text"  class="form-control" name="correo" readonly value="<?php echo $data["correo"]; ?>" required>
                </div>
				
				<div class="col-md-12">
					<?php if($data["foto_formal"] > 0){ ?>
                    	<img src="<?php echo $url."/recursos/".$data["foto_formal"]; ?>" width="200" >
                    <?php } ?>
				</div>

				
            </div>
            </form>
			
		</div>
		
	</div>
	
	

	
</div>
