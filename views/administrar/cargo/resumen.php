<?php
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
    $respuesta = '';

    if($_GET["id"]){
        $_SESSION["id_cargo_edit"] = $_GET["id"];
    }

	//INFORMACION DE LA BATERIA
	$query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$_SESSION["id_cargo_edit"]."'  ");
	$data = mysqli_fetch_array($query);	
    
    $txt_estado = "";
    foreach($Array_Estado as $nivel){
        if($data["estado"] == $nivel[0] ){
            $txt_estado = $nivel[1];
        }
                           
    }

?>
  
<nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=administrar/cargos">Administrar Cargos</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Resumen</a></li>
      </ol>
</nav>

<?php echo $respuesta; ?>

    <!-- NAVEGACION -->
    <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                        
    <li class="nav-item">
        <a class="nav-link active" href="<?php echo $url; ?>?pg=administrar/cargo/resumen">
            <i class="icofont icofont-business-man"></i>Detalle
        </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link "  href="<?php echo $url; ?>?pg=administrar/cargo/descriptivo">
            <i class="icofont icofont-list"></i>Descriptivo
        </a>
    </li>
                        
    <li class="nav-item">
        <a class="nav-link " href="<?php echo $url; ?>?pg=administrar/cargo/perfil">
            <i class="icofont icofont-contact-add"></i>Perfil
        </a>
    </li>

               
    </ul>
    <!-- FIN NAVEGACION -->

<div class="card">
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Cargo</h2>

                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                </div>
                
                <div class="col-md-12" style="margin-bottom: 10px">
                    Nombre Cargo: <b><?php echo $data["nombre"]; ?></b><br>
                    Áreas: <b><?php echo $data["area"]; ?></b><br>
                    Nivel: <b><?php echo $data["nivel"]; ?></b><br>
                    Departamento: <b><?php echo $data["gerencia"]; ?></b><br>
                    Estado: <b><?php echo $txt_estado; ?></b><br>
                </div>
                
               

            </div>
            </form>
        </div> 
        
</div>
    

<script>
    $("#bt_adm_cargos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
</script>

 

