<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>



<?php echo $respuesta; ?>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Informes Organización. <b><?php echo $dataCicloVal["nombre"]; ?></b></h2>
                    </td>
                    <td align="right"> 
                        <button type="button" class="btn btn-warning btn-sm" onclick="window.print();" style="background-color: #FFC107; border: 0; color: #ffffff; padding: 10px; ">
                            <i class="fa fa-print"></i> Imprimir / Descargar
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php include("comp_escala.php"); ?>

<ul class="nav nav-tabs">  
    
    <li class="nav-item">
        <a class="nav-link  " href="?pg=valoracion/informes/individuales">Individuales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/areas">Area / Procesos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/niveles">Niveles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="?pg=valoracion/informes/organizacion">Organización</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
</ul>



<style>
    .titulo{
        font-size: 18px; 
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>


<?php
$query = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' ORDER BY nombre DESC ");
while($data = mysqli_fetch_array($query)){
?>

<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                <div align="center" class="titulo" ><?php echo $data["nombre"]; ?></div>

                <div style="margin-bottom: 20px">
                    
                <?php
                    $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias 
                    WHERE id_tipo = '".$data["id"]."' ");
		          while($dataComp = mysqli_fetch_array($queryComp)){
                      
                      $promedio = 0;
                      $queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
                        WHERE id_competencia = '".$dataComp["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
		              while($dataRespuestas = mysqli_fetch_array($queryRespuestas)){
                          $promedio += $dataRespuestas["calificacion"];
                        }
                      
                      $promedio = $promedio/$queryRespuestas->num_rows;
                      
                      
                   
                      
                      $porcentj = $promedio*100/4;
                      $color_general = '';
                    if( $promedio >= 0 && $promedio < 1.7 ){ $color_general = "#FF7173" ; }
                    if( $promedio >= 1.7 && $promedio < 2.7 ){ $color_general = "#FFC03A" ; }
                    if( $promedio >= 2.7 && $promedio < 3.7 ){ $color_general = "#2ADAFF" ; }
                    if( $promedio >= 3.7 && $promedio <= 4 ){ $color_general = "#B5FF87" ; }
                      
                            $barra = '
                        <div style="width: 100%; background-color: #E9E9E9">
                            <div style="width: '.$porcentj.'%; background-color: '.$color_general.'; text-align: center;font-weight: bold; padding: 5px;">
                                '.round($promedio, 2).' - '.round($porcentj, 2).'%
                            </div>
                        </div>
                    ';
                      
                      if($queryRespuestas->num_rows == 0){
                          $barra = '
                          <div style="width: 100%; background-color: #E9E9E9">
                            <div style="text-align: center;font-weight: bold; padding: 5px;">
                                Sin Datos
                            </div>
                          </div>';
                      }
                      
                      
                      if($queryRespuestas->num_rows > 0){
                        echo $dataComp["nombre"]."<br>";
                        echo $barra;
                      }
                      
                      
                      }
                                                  
                ?>
                    	
                </div>
                
            </div>
        </div>
        
    </div>
</div>

<?php } ?>

<script>
    $("#bt_val_informes").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<script>
    function SelectCheck(elem, id){
        
        estado = $(elem).prop('checked') ;
        //if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $(".comp_"+id).prop('checked',false);
            $(elem).prop('checked',true);
            
            $(".comp_"+id).prop('required',false);
        //}
        /*
        else{
            $(".comp_"+id).prop('checked',false);
            $(".comp_"+id).prop('required',false);
        }*/
    }
    
    
    function Activar_Terminar_Eval(elem){
        estado = $(elem).prop('checked') ;
        
        if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $("#bt_terminar_evaluacion").prop('disabled',false);
            $(elem).prop('checked',true);
        }
        else{
            $("#bt_terminar_evaluacion").prop('disabled',true);
            $(".comp_"+id).prop('checked',false);
        }
        
        
    }
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
    margin-left: 8px;
}
    
    .pagina {
				padding: 0.3cm 1cm;
				background-color:#fff;
				page-break-after: always;
				border-bottom: 1px solid #ccc;
				width:100%;
				margin: 0.5cm auto;
				font-family: sans-serif;
				font-size: 14px;
			}
    
    
    
            @media screen {
			   body { font-size: 10pt }
			}
			@media screen, print {
			   body { line-height: 1.2 }
			}
			
			
			@media print{
				
				body {
					margin: 0;
					padding: 0;
					background-color: #ffffff;
					font-size: 10pt;
					
				}
				* {
					box-sizing: border-box;
					-moz-box-sizing: border-box;
				}
	
				.bt_print{
					display:none;
				}
				
				.pagina {
					border: initial;
					width: initial;
					min-height: initial;
					page-break-after: always;
					font-size:16px;
				}
                
                #sidebar{
                 display: none;
                }
                
                #content{
                    width: 100%;
                }
                #menu_header{
                    display: none;
                }
				
			}
    
    
    
    
    
</style>

