<?php
function Empleados($connect_valentina, $id_cargo){
    
    $list_empleados = '';
    
    $queryList = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_cargo = '".$id_cargo."' ");  //NIVEL 1
    while($dataList = mysqli_fetch_array($queryList)){
        $list_empleados .= '<br>'.$dataList["nombre"];
    }
    return $list_empleados;
}
?>

<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Estructura Cargos</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
            <td align="right" width="40">   
                <button type="button" class="btn btn-info btn-sm" title="Descargar Excel" >
                    <i class="fas fa-download"></i>
                </button>
            </td>
        </tr>
    </table>
</div>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="<?php echo $url; ?>?pg=administrar/cargos" class="nav-link " >Inventario Cargos</a>
    </li>
              
    <li class="nav-item">
        <a href="<?php echo $url; ?>?pg=administrar/cargo/cargos_estructura" class="nav-link active">Estructura Cargos</a>
    </li>
</ul>


<div class="container-fluid"> 

    <div class="row">

        <div class="col-md-12" align="center" style=" border-top: 1px solid #cccccc; padding-top: 20px margin-bottom: 10px">
            
            <form action="" method="post">       
                <div align="center" style="margin-top: 20px;">
                    <h4>Seleccione el cargo que desea visualizar</h4>
                </div>
                <select class="form-control" name="id_padre" style=" width: 330px; display: inline-table;">
                            <option value="">Selecciona..</option>
                            <?php
                            $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                            while($dataJer = mysqli_fetch_array($queryJer)){
                                if($data["padre"] == $dataJer["id"] ){
                                    echo '<option value="'.$dataJer["id"].'" selected>'.$dataJer["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataJer["id"].'">'.$dataJer["nombre"].'</option>';
                                }

                            }
                            ?>
                </select>
                <button type="submit" class="btn btn-success btn-sm"  >
                            Filtrar
                </button>
            </form> 
            
        </div>
        
        <div class="col-md-12">
            
    
            
            
            
            
            <div class="organigrama" style="width: 9000px;">
            <ul>
            <?php
                $niveles = 2;

                $query = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$_POST["id_padre"]."' ");  //NIVEL 1
                while($data = mysqli_fetch_array($query)){
                    
                    echo '<li>
                        <a onclick="Ver_Info('.$data["id"].')">
                            '.$data["nombre"].'
                        </a>
                    ';
                    $queryHijo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$data["id"]."' "); //NIVEL 2
                    if($queryHijo->num_rows > 0){ echo '<ul>'; }
                    while($dataHijo = mysqli_fetch_array($queryHijo)){
                        
                        echo '
                        <li>
                            <a onclick="Ver_Info('.$dataHijo["id"].')">
                                <b>'.$dataHijo["nombre"].'</b>
                            </a>
                        ';
                        $queryHijo2 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataHijo["id"]."' ");  //NIVEL 3
                        if($queryHijo2->num_rows > 0){ echo '<ul>'; }
                        while($dataHijo2 = mysqli_fetch_array( $queryHijo2 )){
                            
                            echo '
                            <li>
                                <a onclick="Ver_Info('.$dataHijo2["id"].')">
                                    '.$dataHijo2["nombre"].'
                                </a>
                            ';
                            $queryHijo3 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataHijo2["id"]."' ");  //NIVEL 4
                            if($queryHijo3->num_rows > 0){ echo '<ul>'; }
                            while($dataHijo3 = mysqli_fetch_array( $queryHijo3 )){
                                
                                echo '
                                <li>
                                    <a onclick="Ver_Info('.$dataHijo3["id"].')">
                                        '.$dataHijo3["nombre"].'
                                    </a>
                                ';
                                $queryHijo4 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataHijo3["id"]."' ");  //NIVEL 5
                                if($queryHijo4->num_rows > 0){ echo '<ul>'; }
                                while($dataHijo4 = mysqli_fetch_array( $queryHijo4 )){
                                    
                                    echo '
                                    <li>
                                        <a onclick="Ver_Info('.$dataHijo4["id"].')">
                                            '.$dataHijo4["nombre"].'
                                        </a>
                                    ';
                                    //echo '<ul>';
                                    $queryHijo5 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE padre = '".$dataHijo4["id"]."' ");  //NIVEL 6
                                    while($dataHijo5 = mysqli_fetch_array( $queryHijo5 )){
                                    }
                                    //echo '</ul>';
                                    echo '</li>';
                                    
                                    
                                }
                                if($queryHijo4->num_rows > 0){ echo '</ul>'; }
                                echo '</li>';
                                
                                
                                
                            }
                            if($queryHijo3->num_rows > 0){ echo '</ul>'; }
                            echo '</li>';
                        }
                        if($queryHijo2->num_rows > 0){ echo '</ul>'; }
                        echo '</li>';

                    }
                    if($queryHijo->num_rows > 0){ echo '</ul>'; }
                    echo '</li>';
                }


            ?>
            </ul>
            </div>
            
   
            
            
        </div>
        
    
    </div>
</div>



<style>


.organigrama * {
  margin: 0px;
}

.organigrama ul {
	padding-top: 20px;
  position: relative;
}

.organigrama li {
	float: left;
  text-align: center;
	list-style-type: none;
	padding: 20px 5px 0px 5px;
  position: relative;
}

.organigrama li::before, .organigrama li::after {
	content: '';
	position: absolute;
  top: 0px;
  right: 50%;
	border-top: 1px solid #f80;
	width: 50%;
  height: 20px;
}

.organigrama li::after{
	right: auto;
  left: 50%;
	border-left: 1px solid #f80;
}

.organigrama li:only-child::before, .organigrama li:only-child::after {
	display: none;
}

.organigrama li:only-child {
  padding-top: 0;
}

.organigrama li:first-child::before, .organigrama li:last-child::after{
	border: 0 none;
}

.organigrama li:last-child::before{
	border-right: 1px solid #f80;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
	border-radius: 0 5px 0 0;
}

.organigrama li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

.organigrama ul ul::before {
	content: '';
	position: absolute;
  top: 0;
  left: 50%;
	border-left: 1px solid #f80;
	width: 0;
  height: 20px;
}

.organigrama li a {
	border: 1px solid #f80;
	padding: 1em 0.75em;
	text-decoration: none;
	color: #333;
  background-color: rgba(255,255,255,0.5);
	font-family: arial, verdana, tahoma;
	font-size: 0.85em;
	display: inline-block;
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
  -webkit-transition: all 500ms;
  -moz-transition: all 500ms;
  transition: all 500ms;
}

.organigrama li a:hover {
	border: 1px solid #fff;
	color: #ddd;
  background-color: rgba(255,128,0,0.7);
	display: inline-block;
}

.organigrama > ul > li > a {
  font-size: 1em;
  font-weight: bold;
}

.organigrama > ul > li > ul > li > a {
  width: 8em;
}

</style>

<script> 
    var api = '<?php echo $url; ?>api/administrar/';
    function Ver_Info(id){
        $("#modal_equipo").modal("show");
        
        jQuery.ajax({
                url: api+"empleados_cargo.php",
                type:'post',
                data: {id: id},
                }).done(function (resp){
                    $("#body_equipos").html(resp);
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
    $("#bt_adm_cargos").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



