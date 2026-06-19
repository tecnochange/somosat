<?php
	$queryPosiciones = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE id = '".$id."' ");
    $queryVacantes = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE id = '".$id."' ");

    $dependiencia = "";
    $queryDepencia = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE codigo = '".$data["codigo_jefe"]."' ");  
    $dataDependencia = mysqli_fetch_array($queryDepencia);
               
    $queryCar = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataDependencia["id_cargo"]."' ");  
    $dataCar = mysqli_fetch_array($queryCar);
            
    $dependiencia = $dataCar["nombre"]." - ".$data["codigo_jefe"];
       
	
?>

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
        
        
    </div>
</div>








<div class="card" style="display: none">
        
        <div class="card-body">   
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Detalle Posicion: </h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>" >
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Código</label>
                    <input type="text" class="form-control" name="codigo" value="<?php echo $data["codigo"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Cargo</label>
                    <select class="form-control" name="id_cargo" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataJer = mysqli_fetch_array($queryJer)){
                                if($data["id_cargo"] == $dataJer["id"] ){
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
                    <label>* Dependencia</label>
                    <select class="form-control" name="codigo_jefe" required >
                        <option value="">Selecciona..</option>
                        <?php
                            $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Posiciones ORDER BY id ASC ");  
                            while($dataJer = mysqli_fetch_array($queryJer)){
                                if($data["codigo_jefe"] == $dataJer["id"] ){
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
                    <label>Empresa</label>
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
                

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" value="<?php echo $data["ciudad"]; ?>">
                </div>
                
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>* Regional</label>
                    <input type="text" class="form-control" name="canal" value="<?php echo $data["canal"]; ?>">
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
    $("#bt_adm_posiciones").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>