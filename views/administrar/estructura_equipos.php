
<script>  
$(document).ready(function(){
    $("#bt_adm_organigrama").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
});
</script>

<script src="<?php echo $url; ?>/js/html2canvas.js"></script>

<script>
function GuardarImagen(){
    
    $("#modal_general").modal("show");
    $("#modal_body").html("Generando imágen. este proceso puede tardar unos segundos. Al finalizar puede buscar en su carpeta de descargas.");
    $("#modal_body").append("<br><br>Puede cerrar esta ventana en cualquier momento.");

    var filename = 'Reporte_Organigrama.png';
 
    html2canvas(document.querySelector("#organigrama")).then(canvas => {
        //document.body.appendChild(canvas);
        var link = document.createElement('a');
        link.href = canvas.toDataURL("image/png");
        link.download = filename;
 
            
        // Simulando clic para descargar
        link.click()    
    });   
}
</script>

<style>
	.foto{
		width: 60px;
		height: 60px;
		background-size: cover;
		background-position: center;
		border-radius: 100px;
		margin-top: 7px !important;
	}
</style>

<?php 
	$id_equipo = $_GET["e"];
	if(!$_GET["e"]){
		$id_equipo = 1;
	}

	$queryEquipo = mysqli_query($connect_valentina,"SELECT * FROM Equipos WHERE id = '".$id_equipo."'  ");
    $dataEquipo = mysqli_fetch_array($queryEquipo);

    function Nodo($nombre, $foto, $cargo, $id){

        global $connect_valentina;
		global $url;
		global $role_usuario;
		
		if(!$foto){ $foto = "1.png"; }
		
		$ancho = "";
		$tabla = '
			<table width="100%">
				<tr>
					<td align="center">
						<figure class="foto" style="background-image: url('.$url.'/recursos/'.$foto.')"></figure>
						'.$nombre.'<br>
						<span>'.$cargo.'</span>
					</td>
				</tr>
			</table>
		';

		if($nombre == "DAMIAN SALINAS" && ( $_GET["e"] == 12 || $_GET["e"] == 27 ) ){
			$ancho = "width: 300px;";
			$tabla = '
			<table width="100%">
				<tr>
					<td width="50%" align="center">
						<figure class="foto" style="background-image: url(https://somosat.hr-suite.app/recursos/1666101989DamianSalinas.jpg)"></figure>
						DAMIAN SALINAS<br>
						<span>Coordinador Soporte y Outsourcing</span>
					</td>
					<td align="center">
						<figure class="foto" style="background-image: url(https://somosat.hr-suite.app/recursos/1666098818NicoleFernndez.JPG)"></figure>
						NICOLE FERNANDEZ<br>
						<span>Coordinador Soporte y Outsourcing</span>
					</td>
					
				</tr>
			</table>
		';
		}
		
		
        
        $html = '
        <li>
            <div style="'.$ancho.'">
				'.$tabla.'
            </div>
        ';
        return $html;
    }

    //para obtener las posiciones agrupadas
	/*
    function NodoCargos($nombre, $id_posicion_jefe, $id_cargo){ 
        
        global $connect_valentina;
        
        $empleados_lista = "";
		$id_ult_pos = 0;
        $querPosiciones = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE id_dep_jerarquica = '".$id_posicion_jefe."' AND id_cargo = '".$id_cargo."' AND estado = 1 ");
        while($dataPosiciones = mysqli_fetch_array($querPosiciones)){
            
            $queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_posicion = '".$dataPosiciones["id"]."' AND estado = 1 ");
            $dataEmpleados = mysqli_fetch_array($queryEmpleados);
			$id_ult_pos = $dataPosiciones["id"];

            if($queryEmpleados->num_rows > 0){ 
                $empleados_lista .= '
                    <a href="'.$url.'?pg=administrar/estructura_posiciones&c='.$dataPosiciones["id"].'">
                    <span style="color: #4a4a4a;">'.$dataEmpleados["nombre"].' '.$dataEmpleados["nombre_2"]." ".$dataEmpleados["apellidos"].' </span>

                        <i class="fa fa-sitemap"></i>
                    </a>
                </br>';    
            }
        }
        //if($queryEmpleados->num_rows > 1){ $empleados_lista = $queryEmpleados->num_rows;  }
        if( $empleados_lista == "" ){ 
			$empleados_lista = '
				<a href="'.$url.'?pg=administrar/estructura_posiciones&c='.$id_ult_pos.'">
					<span style="color: #4a4a4a;">Vacante</span>
					<i class="fa fa-sitemap"></i>
				</a>
			';  
		}
 
        $html = "";
        global $role_usuario;
        $link = '';
        $link_sitemap = '';
        if( $role_usuario == 1 || $role_usuario['role'] == 5 ){
            $link = ' href="'.$url.'?pg=administrar/posicion/resumen&id='.$id.'" '; 
            $link_sitemap = ' href="'.$url.'?pg=administrar/estructura_posiciones&c='.$id.'" '; 
        }
        if($role_usuario == 2){
            $link_sitemap = ' href="'.$url.'?pg=administrar/estructura_posiciones&c='.$id.'" '; 
        }

        $html = '
        <li>
            <div>
                <a '.$link.'>
                    <i class="fa fa-eye bt_editar_nodo"></i>
                </a>
                '.$nombre.'
                <p class="empleados_lista">
                    '.$empleados_lista.'
                </p>
            </div>
            
        ';

        return $html;

    }
	*/

?>

<style>
    .ico_link{
        background-color: #f44336;
        color: #ffffff;
        padding: 3px;
        border-radius: 15px;
    }
    
    .btn_gerencias{
        margin-bottom: 12px;
    }
    
    .bt_editar_nodo{
        float: right;
        color: #ffffff;
    }
    .bt_siteman_nodo{
        float: left;
        color: #ffffff;
    }
    .empleados_lista{
        font-size: 9px;
        border: 1px solid #fa3f3f;
        padding: 3px;
        text-align: right;
        background-color: #ffffff;
        border-radius: 3px;
        margin-bottom: -10px !important;
        margin-right: -5px !important;
        margin-left: 10px !important;
        color: #424242;
        line-height: 11px;
        cursor: pointer;
        position: relative;
    }
</style>

<div align="center" style="margin-bottom: 20px">
	<h2>ORGANIGRAMA DE EQUIPO <?php echo $dataEquipo["nombre"] ?></h2>
	
	<div style="max-width: 500px; margin-top: 10px">
		<select class="form-control" name="id_equipo" onChange="Enviar(this.value)" required id="formulario_equipos"   >
			<option value="">Selecciona un equipo..</option>
			<?php
                            $queryList = mysqli_query($connect_valentina,"SELECT * FROM Equipos  WHERE ver_organigrama = 1 AND estado = 1 ORDER BY nombre ASC ");  
                            while($dataList = mysqli_fetch_array($queryList)){
                                if($data["id_equipo"] == $dataList["id"] ){
                                    echo '<option value="'.$dataList["id"].'" selected>'.$dataList["nombre"].'</option>';
                                }
                                else{
                                    echo '<option value="'.$dataList["id"].'">'.$dataList["nombre"].' </option>';
                                }
                            }
			?>
		</select>
	</div>
	
</div>

<script>
function Enviar(id_equipo){
	window.location = "<?php echo $url; ?>/?pg=administrar/estructura_equipos&e="+id_equipo;
}
</script>

<div align="left" class="cabecera_interna" style="display: none">
	<table width="100%">
    	<tr>
        	<td></td>
            <td align="right" width="200">
            	<button type="button" class="btn btn-primary btn-sm" onclick="GuardarImagen()"  >
                    <i class="fa fa-print"></i> Guardar Imágen
                </button>
            </td>
        </tr>
    </table>
</div>

<!-- CABECERA -->
<div class="container-fluid">

	<div align="center">
        <?php
        $queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Equipos WHERE ver_organigrama = 1 AND estado = 1 ORDER BY nombre ASC ");
        while($dataCargosLista = mysqli_fetch_array($queryCargos)){
            echo '
            <a href="'.$url.'?pg=administrar/estructura_equipos&e='.$dataCargosLista["id"].'">
                <button type="button" class="btn btn-success btn-sm btn_gerencias" >
                    '.$dataCargosLista["nombre"].'
                </button>
            </a>
            ';
        }
        ?>
    </div>
</div>

<div style="overflow: auto; width: 100%; padding-bottom: 20px" id="imagen_organigrama">
    <div class="organigrama" id="organigrama" style=" height: 400px;  width: 22000px; margin: auto;">
            <ul style=" width: fit-content;" id="ul_general">
            <?php
                //PADRE
				/*
				$sentencia = "
					SELECT Organigrama.id AS id, Empleados.nombre AS nombre, 
					Empleados.apellidos AS apellidos, Empleados.id_equipo AS id_equipo,  Empleados.id AS id_empleado,
					Organigrama.id_depende AS id_depende, Organigrama.estado AS estado, 
					Cargos.nombre AS nombre_cargo 
					FROM Organigrama 
					LEFT JOIN Empleados ON Empleados.id = Organigrama.id_empleado 
					LEFT JOIN Cargos ON Cargos.id = Empleados.id_cargo 
					
					WHERE id_equipo = '".$id_equipo."' AND jerarquia = 1 AND estado = 1
				";
				*/
				$query = mysqli_query($connect_valentina,"SELECT * FROM Organigrama_View 
                WHERE id_equipo = '".$id_equipo."' AND jerarquia = 1 AND estado = 1 ");  //NIVEL 1
                while($data = mysqli_fetch_array($query)){
					
					//PARA VALIDAR EL NOMBRE DE PREFERENCIA
					$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id_empleado"]."' " );  
					$dataAdd = mysqli_fetch_array($queryAdd);
					$nombre_completo = strtoupper($data["nombre"]." ".$data["apellidos"]);
					if($dataAdd["preferencia"]){
						$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
					}
					
					echo Nodo( $nombre_completo, $data["foto_formal"], $data["nombre_cargo"], $data["id"] );
					
					//NIVEL 2
					$queryL2 = mysqli_query($connect_valentina,"SELECT * FROM Organigrama_View 
					WHERE id_equipo = '".$id_equipo."' AND jerarquia = 2 AND estado = 1 AND id_depende = '".$data["id"]."' ");  
					if($queryL2->num_rows > 0){ echo '<ul>'; }
					while($dataL2 = mysqli_fetch_array($queryL2)){
						
						//PARA VALIDAR EL NOMBRE DE PREFERENCIA
						$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataL2["id_empleado"]."' " );  
						$dataAdd = mysqli_fetch_array($queryAdd);
						$nombre_completo = strtoupper($dataL2["nombre"]." ".$dataL2["apellidos"]);
						if($dataAdd["preferencia"]){
							$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataL2["apellidos"]." ".$dataL2["apellidos_2"]);
						}

						echo Nodo( $nombre_completo, $dataL2["foto_formal"], $dataL2["nombre_cargo"], $dataL2["id"] );
						
						//NIVEL 3
						$queryL3 = mysqli_query($connect_valentina,"SELECT * FROM Organigrama_View 
						WHERE id_equipo = '".$id_equipo."' AND jerarquia = 3 AND estado = 1 AND id_depende = '".$dataL2["id"]."' ");  
						if($queryL3->num_rows > 0){ echo '<ul>'; }
						while($dataL3 = mysqli_fetch_array($queryL3)){
							
							//PARA VALIDAR EL NOMBRE DE PREFERENCIA
							$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataL3["id_empleado"]."' " );  
							$dataAdd = mysqli_fetch_array($queryAdd);
							$nombre_completo = strtoupper($dataL3["nombre"]." ".$dataL3["apellidos"]);
							if($dataAdd["preferencia"]){
								$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataL3["apellidos"]." ".$dataL3["apellidos_2"]);
							}

							echo Nodo( $nombre_completo, $dataL3["foto_formal"], $dataL3["nombre_cargo"], $dataL3["id"] );
							
							//NIVEL 4
							$queryL4 = mysqli_query($connect_valentina,"SELECT * FROM Organigrama_View 
							WHERE id_equipo = '".$id_equipo."' AND jerarquia = 4 AND estado = 1 AND id_depende = '".$dataL3["id"]."' ");  
							if($queryL4->num_rows > 0){ echo '<ul>'; }
							while($dataL4 = mysqli_fetch_array($queryL4)){
								
								//PARA VALIDAR EL NOMBRE DE PREFERENCIA
								$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataL4["id_empleado"]."' " );  
								$dataAdd = mysqli_fetch_array($queryAdd);
								$nombre_completo = strtoupper($dataL4["nombre"]." ".$dataL4["apellidos"]);
								if($dataAdd["preferencia"]){
									$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataL4["apellidos"]." ".$dataL4["apellidos_2"]);
								}

								echo Nodo( $nombre_completo, $dataL4["foto_formal"], $dataL4["nombre_cargo"], $dataL4["id"] );

								//NIVEL 5
								$queryL5 = mysqli_query($connect_valentina,"SELECT * FROM Organigrama_View 
								WHERE id_equipo = '".$id_equipo."' AND jerarquia = 5 AND estado = 1 AND id_depende = '".$dataL4["id"]."' ");  
								if($queryL5->num_rows > 0){ echo '<ul>'; }
								while($dataL5 = mysqli_fetch_array($queryL5)){
									
									//PARA VALIDAR EL NOMBRE DE PREFERENCIA
									$queryAdd = mysqli_query($connect_valentina, "SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$dataL5["id_empleado"]."' " );  
									$dataAdd = mysqli_fetch_array($queryAdd);
									$nombre_completo = strtoupper($dataL5["nombre"]." ".$dataL5["apellidos"]);
									if($dataAdd["preferencia"]){
										$nombre_completo = strtoupper($dataAdd["preferencia"]." ".$dataL5["apellidos"]." ".$dataL5["apellidos_2"]);
									}

									echo Nodo( $nombre_completo, $dataL5["foto_formal"], $dataL5["nombre_cargo"], $dataL5["id"] );






									//if($queryL2->num_rows > 0){ echo '</ul>'; }
									echo '</li>';
								}

								if($queryL5->num_rows > 0){ echo '</ul>'; }
								echo '</li>';
							}

							
							if($queryL4->num_rows > 0){ echo '</ul>'; }
							echo '</li>';
						}
						
						
						if($queryL3->num_rows > 0){ echo '</ul>'; }
                		echo '</li>';
						
					}
					
					if($queryL2->num_rows > 0){ echo '</ul>'; }
                	echo '</li>';
					
					
					
				}
				
				
                
				
				
				
				
				
				
				
				
				
				
				
				
				
				
                $query = mysqli_query($connect_valentina,"SELECT * FROM Organigrama 
                WHERE id_equipo = '".$id_equipo."' AND jerarquia = 1 AND estado = 1 ");  //NIVEL 1
                $data = mysqli_fetch_array($query);
                    
                $queryCrg = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' "); 
                $dataCrg = mysqli_fetch_array($queryCrg);

                //echo Nodo($dataCrg["nombre"], $data["id"]);
                    
                //HIJOS
                //$qHijo_1 = mysqli_query($connect_valentina,"SELECT * FROM Posiciones
                //WHERE id_dep_jerarquica = '".$data["id"]."' AND estado = 1  "); //NIVEL 2
                    
                    
                $qHijo_1 = mysqli_query($connect_valentina,"SELECT * FROM Posiciones____
                WHERE id_dep_jerarquica = '".$data["id"]."' AND estado = 1 GROUP BY id_cargo  "); //NIVEL 2
                if($qHijo_1->num_rows > 0){ echo '<ul>'; }
                while($dHijo_1 = mysqli_fetch_array($qHijo_1)){
                        
                        $queryCrg1 = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dHijo_1["id_cargo"]."' "); 
                        $dataCrg1 = mysqli_fetch_array($queryCrg1);
                        
                        
                        echo NodoCargos( $dataCrg1["nombre"], $id_posiciones, $dHijo_1["id_cargo"] );
                        
                        /*
                        //NIETOS
                        $qHijo_2 = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
                        WHERE id_cargo_reporte = '".$dHijo_1["id"]."' ");  //NIVEL 3
                        if($qHijo_2->num_rows > 0){ echo '<ul>'; }
                        while($dHijo_2 = mysqli_fetch_array( $qHijo_2 )){
                            
                            echo Nodo($dHijo_2["nombre"], $dHijo_2["id"]);
                            
                            
                            //BIS NIETOS
                            $qHijo_3 = mysqli_query($connect_valentina,"SELECT * FROM Cargos___ 
                            WHERE id_cargo_reporte = '".$dHijo_2["id"]."' ");  //NIVEL 4
                            if($qHijo_3->num_rows > 0){ echo '<ul>'; }
                            while($dHijo_3 = mysqli_fetch_array( $qHijo_3 )){
                                
                                echo Nodo($dHijo_3["nombre"], $dHijo_3["id"]);
                                
                                //TATARA NIETOS
                                $qHijo_4 = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
                                WHERE id_cargo_reporte = '".$dHijo_3["id"]."' ");  //NIVEL 5
                                if($qHijo_4->num_rows > 0){ echo '<ul>'; }
                                while($dHijo_4 = mysqli_fetch_array( $qHijo_4 )){
                                    
                                    echo Nodo($dHijo_4["nombre"], $dHijo_4["id"]);
 
                                    //NIETOS 5
                                    $qHijo_5 = mysqli_query($connect_valentina,"SELECT * FROM Cargos 
                                    WHERE id_cargo_reporte = '".$dHijo_4["id"]."' ");  //NIVEL 6
                                    if($qHijo_5->num_rows > 0){ echo '<ul>'; }
                                    while($dHijo_5 = mysqli_fetch_array( $qHijo_5 )){
                                        
                                        echo Nodo($dHijo_5["nombre"], $dHijo_5["id"]);

                                    }
                                    if($qHijo_5->num_rows > 0){ echo '</ul>'; }
                                    echo '</li>';
                                    
                                }
                                if($qHijo_4->num_rows > 0){ echo '</ul>'; }
                                echo '</li>';

                            }
                            if($qHijo_3->num_rows > 0){ echo '</ul>'; }
                            
                            echo '</li>';
                            
                            
                        }
                        if($qHijo_2->num_rows > 0){ echo '</ul>'; }
                        echo '</li>';
                        */

                }
                //if($qHijo_1->num_rows > 0){ echo '</ul>'; }
                //echo '</li>';
                


            ?>
            </ul>
    </div>
</div>
   

<style>
    @media print{
        
        .page-main-header{
            display:none !important;
            margin-top: -150px;
        }
				
        .main-nav {
            display:none;
        }
        .footer{
            display: none;
        }
        
        .page-body{
            width: 100%;
            margin-left: 0px !important;
            margin-top: 0px !important;
        }
        .page-header{
            display: none;
        }
        
        
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }		
    }

</style>


<style>


.organigrama * {
    margin: 0px;
}

.organigrama ul {
    padding-top: 20px;
    position: relative;
	padding-left: 0;
}

.organigrama li {
    float: left;
    text-align: center;
    list-style-type: none;
    padding: 20px 2px 0px 2px;
    position: relative;
}

.organigrama li::before, .organigrama li::after {
	content: '';
	position: absolute;
    top: 0px;
    right: 50%;
	border-top: 1px solid #004b98;
	width: 50%;
    height: 20px;
}

.organigrama li::after{
	right: auto;
    left: 50%;
	border-left: 1px solid #004b98;
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
	border-right: 1px solid #004b98;
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
	border-left: 1px solid #004b98;
	width: 0;
    height: 20px;
}

.organigrama li div {
	background-color: #00295e;
    padding: 5px 2px;
    color: #ffffff !important;
    font-family: arial, verdana, tahoma;
    font-size: 10px;
    display: inline-block;
    -webkit-border-radius: 5px;
    transition: all 500ms;
    line-height: 12px;
    width: 150px;
	display: inline-flex;
    flex-direction: column;
    align-items: center;
	height: 130px;
}
.organigrama > ul > li > div
.organigrama li div:hover {
	border: 1px solid #fff;
	color: #ddd;
    background-color: rgba(255,128,0,0.7);
	display: inline-block;
}

.organigrama > ul > li > div {
  font-weight: bold;
}

.organigrama > ul > li > ul > li > div {
  width: 150px;
}

</style>

            
        
<script>  
$(document).ready(function(){
    ancho = $("#ul_general").width();
    console.log(ancho);
    
    $(".organigrama").width(ancho+50);
});
    
var api = '<?php echo $url; ?>/api/administrar/';   
    
function EmpleadosLista(id_cargo){
    jQuery.ajax({
			url: api+"empleados_lista_organigrama.php",
			type:'post',
			data: {id_cargo: id_cargo, },
			}).done(function (resp){
				$("#cont_empleados_lista").html(resp);
			})
			.fail(function(resp) {
				console.log(resp);
			})
			.always(function(resp){
			}
    );
}      
</script>



