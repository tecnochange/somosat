<script>  
$(document).ready(function(){
    $("#novedades_menu").addClass("active");
    $("#desplegable_novedades").show();
    $("#bt_novedades_documentos").addClass("active_item");
});
</script>

<?php

    $id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	if($_POST["id_recibe"] != ""){
 
        mysqli_query($connect_valentina,"INSERT INTO Mensajeria (id_empresa, id_envia, id_recibe, mensaje, created_at ) 
        VALUES 
        ( '".$_SESSION['id_empresa']."', '".$_SESSION['id_user_valentina']."', '".$_POST["id_recibe"]."', '".$_POST["mensaje"]."', '".$hoy."' ) ");
        
        $id_tmp = mysqli_insert_id($connect_valentina);
        
        //Como el elemento es un arreglos utilizamos foreach para extraer todos los valores
		//foreach($_FILES["archivo_m"]['tmp_name'] as $key ){
		foreach($_FILES["archivo_multiples"]['tmp_name'] as $key => $tmp_name ){
			
			//Validamos que el archivo exista
			if($_FILES["archivo_multiples"]["name"][$key]) {
				
				$sku = time();
				$dir_subida = '/var/www/html/creeser-seleccion.hr-suite.app/recursos/';
				$fichero_subido = $dir_subida . basename($sku.$_FILES["archivo_multiples"]["name"][$key]);
				
				if (move_uploaded_file($_FILES['archivo_multiples']['tmp_name'][$key], $fichero_subido)) {
					//echo "El fichero es válido y se subió con éxito.\n";
				} 
				else {
					//echo "¡Posible ataque de subida de ficheros!\n";
				}
			
				$archivo =  $sku.$_FILES['archivo_multiples']['name'][$key];
				
				mysqli_query($connect_valentina,"INSERT INTO Multimedia (id_tipo, id_mensaje, archivo, created_at) 
				VALUES ('1', '".$id_tmp."', '".$archivo."', '".$hoy."' ) ");
			}
		}

		echo '<script>window.location = "?pg=administrar/documentos";</script>';//para evitar reinsersion
	}
?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                  <h3>Documentos</h3>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item">Documentos</li> 
                  </ol>
            </div>
            <div class="col-sm-6" align="right">
                <a href="<?php echo $url; ?>?pg=novedades/documento/detalle" >
                    <button type="button" class="btn btn-outline-primary">Cargar Documento</button> 
                </a> 
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        
        <!-- Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                  
                <div class="card-body">
                    <div class="e_movil" style="text-align: right; line-height: 14px; color: #004b98;">
                        Deslice la tabla de izquierda a derecha para ver el contenido >>
                    </div>
                    
                    <div class="barra_superior">
                        <div class="div_content"></div>
                    </div>
                    
                    <div class="table-responsive">
                    <table id="tabla_maestra" class="display" width="100%" style="font-size: 12px">
                        <thead class="bg-secondary">
                            <tr>
                              <th>#</th>
                              <th>Documento</th>
                              <th>Fecha</th>
                              <th>Tipo</th>
                              <th>Estado</th>
                              <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $count = 1;
                        $query = mysqli_query($connect_novedades,"SELECT * FROM Vacaciones WHERE id_colaborador = '".$_SESSION['id_user_valentina']."' ");  
                        while($data = mysqli_fetch_array($query)){ 
                            
                            $bt_editar = '';
                            if($user_log["role"] == 1 ){
                                $bt_editar = '
                                <a href="'.$url.'?pg=administrar/area/detalle&id='.$area["id"].'" class="btn btn-outline-primary btn-sm" title="Editar">
                                    <i class="fa fa-edit"></i>
                                </a>
                                ';
                            }
                            
                            echo '
                                <tr>
                                    <td>'.$count.'</td>
                                    <td>'.$area["nombre"].'</td>
                                    <td>'.$area["nombre_padre"].'</td>
                                    <td>'.$area["codigo"].'</td>
                                    <td>'.$area["nivel"].'</td>
                                    <td>'.$queryCargos->num_rows.'</td>

                                    <td>'.$area["estado"].'</td>
                                    <td  align="center">
                                        '.$bt_editar.'
                                        <a href="'.$url.'?pg=administrar/area/resumen&id='.$area["id"].'" class="btn btn-secondary btn-sm" title="Resumen">
                                    <i class="fa fa-eye"></i>
                                </a>
                                    </td>
                                </tr>
                            ';
                            $count++;
                        }
   
                        ?>
                            
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Configuration  Ends-->
             
    </div>
</div>



<!-- PARA CREAR LA TABLA DINAMICA -->
<style>
    .barra_superior{
        overflow-x: scroll;
        overflow-y:hidden;
        width: 100%;
    }
    .div_content{
        height: 10px;
    }
</style>
                                       
<script>  
    $(document).ready(function() {
        $('#tabla_maestra').DataTable();
        $('.div_content').width( $('#tabla_maestra').width() );
    } );
    
    $(function(){
        $(".barra_superior").scroll(function(){
            $(".table-responsive").scrollLeft($(".barra_superior").scrollLeft());
        });
        $(".table-responsive").scroll(function(){
            $(".barra_superior").scrollLeft($(".table-responsive").scrollLeft());
        });
    }); 
</script>

