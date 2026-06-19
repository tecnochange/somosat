<?php
    $id = $_GET["id"];
    $respuesta = '';
    $hoy = date("Y-m-d H:i:s");

    //EDITAR O CREAR REGISTROS
    if( $_POST["tarea"] != "" ){
        
        if($_POST["id_registro"] != ""){
            mysqli_query($connect,"UPDATE Tareas SET 
                tarea = '".$_POST["tarea"]."',  
                descripcion = '".$_POST["descripcion"]."',  
                inicia = '".$_POST["inicia"]."',  	
                hora_inicia = '".$_POST["hora_inicia"]."',  
                termina = '".$_POST["termina"]."',  
                hora_termina = '".$_POST["hora_termina"]."',  
                porcentaje = '".$_POST["porcentaje"]."'
                WHERE id = '".$_POST["id_registro"]."' 
            ");
            
            $respuesta = '
            <div class="alert alert-success" role="alert">
              Los datos actualizados
            </div>
            ';
        
        }
        else{
            mysqli_query($connect,"INSERT INTO Tareas (
                id_empleado, 
                tarea, 
                descripcion, 
                inicia, 	
                hora_inicia, 
                termina, 
                hora_termina, 
                porcentaje, 
                created_at
            ) 
            VALUES (
                '".$_SESSION['id_user']."', 
                '".$_POST["tarea"]."', 
                '".$_POST["descripcion"]."', 
                '".$_POST["inicia"]."', 
                '".$_POST["hora_inicia"]."', 
                '".$_POST["termina"]."',  
                '".$_POST["hora_termina"]."', 
                '".$_POST["porcentaje"]."', 
                '".$hoy."' 
            )
            ");
            
            $id_tmp = mysqli_insert_id($connect);
            echo '<script> window.location = "?pg=perfil/tarea&id='.$id_tmp.'"; </script>';
        }
        
    }
    
    //CONSULTAMOS EL REGISTRO
    $query= mysqli_query($connect,"SELECT * FROM Tareas WHERE id = '".$id."' ");
    $data = mysqli_fetch_array($query);
?>

<div class="container-fluid">
    
    <div class="row view_page">
        
        <div class="col-md-12">
            <h2>Tareas</h2>
            <nav aria-label="breadcrumb" >
                <ol class="breadcrumb miga">
                    <li class="breadcrumb-item"><a href="?pg=home">Escritorio</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="?pg=perfil/detalle">Perfil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tareas</li>
                </ol>
            </nav>
        </div>
        
        <div class="col-md-12" style="margin-bottom: 15px">

            <!-- DATOS PERSONALES -->   
            <div class="card custom-card" style="margin-bottom: 30px">
                <div class="card-body">

                    <?php echo $respuesta; ?>

                    <form action="" method="post">    
                    <div class="row">

                            <div class="col-md-12 item_input">
                                <h2>TAREA</h2>
                                <input type="hidden" value="<?php echo $id; ?>" name="id_registro">
                            </div>

                            <div class="col-md-9 item_input">
                                <label>Título</label>
                                <input type="text" class="form-control form-control-sm" name="tarea" id="tarea" required placeholder="Tarea" value="<?php echo $data["tarea"]; ?>" >
                            </div>
                        
                            <div class="col-md-3 item_input">
                                <label>Porcentaje Avance</label>
                                <select class="form-control form-control-sm" name="porcentaje" id="porcentaje" required>
                                    <option>Selecciona...</option>
                                    <?php 
                                    for ($i = 0; $i <= 100; $i++) {
                                        if($i == $data["porcentaje"]){
                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$i.'" >'.$i.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                
                                
                            </div>

                            <div class="col-md-3 item_input">
                                <label>Fecha Inicia</label>
                                <input type="date" class="form-control form-control-sm" name="inicia" id="inicia" required placeholder="Inicia" value="<?php echo $data["inicia"]; ?>" >
                            </div>
                        
                            <div class="col-md-3 item_input">
                                <label>Hora Inicia</label>
                                <input type="time" class="form-control form-control-sm" name="hora_inicia" id="hora_inicia" required placeholder="Hora Inicia" value="<?php echo $data["hora_inicia"]; ?>" >
                            </div>
                        
                            <div class="col-md-3 item_input">
                                <label>Fecha Termina</label>
                                <input type="date" class="form-control form-control-sm" name="termina" id="termina" required placeholder="Termina" value="<?php echo $data["termina"]; ?>" >
                            </div>
                        
                            <div class="col-md-3 item_input">
                                <label>Hora Termina</label>
                                <input type="time" class="form-control form-control-sm" name="hora_termina" id="hora_termina" required placeholder="Hora Termina" value="<?php echo $data["hora_termina"]; ?>" >
                            </div>
                        
                            
                        
                            <div class="col-md-12 item_input">
                                <textarea class="form-control form-control-sm" name="descripcion" id="descripcion" placeholder="Descripcion" rows="5"><?php echo $data["descripcion"]; ?></textarea>
                            </div>





                            <div class="col-md-12" align="right">
                                <button type="submit" class="btn btn-lila">Guardar</button>    
                            </div>


                    </div>
                    </form>

                </div>
            </div>
            
        </div>
    

    </div>
</div>



<script>
$( document ).ready(function() {    
	$("#bt_colaboradores").prepend( '<span class="shape1"></span><span class="shape2"></span>' );
    $("#bt_colaboradores").addClass( "bt_select" );
    $("#ico_colaboradores").addClass( "base_icons_menu" );
});
</script>

