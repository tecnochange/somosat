<div align="left" class="cabecera_interna">
	<table width="100%">
    	<tr>
        	<td><h2>Administrar Estructura</h2></td>
            <td align="right" width="200">
            	<input class="form-control" type="text" placeholder="Búsqueda rápida..." id="buscador" />
                
            </td>
            <td align="right" width="40">   
                <?php if($user_log["role"] == 1){ ?>
                    <a href="<?php echo $url; ?>?pg=administrar/area/detalle">
                        <button type="button" id="sidebarCollapse" class="btn btn-success btn-sm" >
                            <i class="fas fa-plus"></i> Crear Área
                        </button>
                    </a>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>




<div class="container-fluid"> 

    <div class="row">
    
        <div class="col-md-12">
            
            
            
            
        </div>
        
        <div class="col-md-12">
            
            
            
            <div style="overflow: auto; width: 100%; padding-bottom: 20px">
            <div class="organigrama" style="width: 22000px">
            <ul>
            <?php
                $niveles = 2;

                $query = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE jerarquia = 1 ");  //NIVEL 1
                while($data = mysqli_fetch_array($query)){
                    
                    $link = '';
                    if($dtEmpleado["role"] == 1){
                        $link = ' href="'.$url.'?pg=administrar/area/detalle&id='.$data["id"].'" '; 
                    }
                    
                    echo '<li>
                        <a '.$link.'>
                            '.$data["nombre"].'
                        </a>
                    ';
                    $queryHijo = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$data["id"]."' "); //NIVEL 2
                    if($queryHijo->num_rows > 0){ echo '<ul>'; }
                    while($dataHijo = mysqli_fetch_array($queryHijo)){
                        
                        $link_1 = '';
                        if($dtEmpleado["role"] == 1){
                            $link_1 = ' href="'.$url.'?pg=administrar/area/detalle&id='.$dataHijo["id"].'" '; 
                        }
                        
                        echo '
                        <li>
                            <a '.$link_1.'>
                                '.$dataHijo["nombre"].'
                            </a>
                        ';
                        $queryHijo2 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataHijo["id"]."' ");  //NIVEL 3
                        if($queryHijo2->num_rows > 0){ echo '<ul>'; }
                        while($dataHijo2 = mysqli_fetch_array( $queryHijo2 )){
                            
                            $link_2 = '';
                            if($dtEmpleado["role"] == 1){
                                $link_2 = ' href="'.$url.'?pg=administrar/area/detalle&id='.$dataHijo2["id"].'" '; 
                            }
                            
                            echo '
                            <li>
                                <a '.$link_2.'>
                                    '.$dataHijo2["nombre"].'
                                </a>
                            ';
                            $queryHijo3 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataHijo2["id"]."' ");  //NIVEL 4
                            if($queryHijo3->num_rows > 0){ echo '<ul>'; }
                            while($dataHijo3 = mysqli_fetch_array( $queryHijo3 )){
                                
                                $link_3 = '';
                                if($dtEmpleado["role"] == 1){
                                    $link_3 = ' href="'.$url.'?pg=administrar/area/detalle&id='.$dataHijo3["id"].'" '; 
                                }
                                
                                echo '
                                <li>
                                    <a '.$link_3.'>
                                        '.$dataHijo3["nombre"].'
                                    </a>
                                ';
                                $queryHijo4 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataHijo3["id"]."' ");  //NIVEL 5
                                if($queryHijo4->num_rows > 0){ echo '<ul>'; }
                                while($dataHijo4 = mysqli_fetch_array( $queryHijo4 )){
                                    
                                    $link_4 = '';
                                    if($dtEmpleado["role"] == 1){
                                        $link_4 = ' href="'.$url.'?pg=administrar/area/detalle&id='.$dataHijo5["id"].'" '; 
                                    }
                                    
                                    echo '
                                    <li>
                                        <a '.$link_4.'>
                                            '.$dataHijo4["nombre"].'
                                        </a>
                                    ';
                                    //echo '<ul>';
                                    $queryHijo5 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE padre = '".$dataHijo4["id"]."' ");  //NIVEL 6
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
    $("#bt_adm_estructura").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>



