<?php

	//VALIDACION DE SESION
	session_start();
	if($_SESSION['id_user'] == ""){
		header('Location: https://somosat.hr-suite.app/log.php' );
	}

	include("../../app/models/connect.php");
	include("../../app/models/library.php");

    $id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");

	$query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id."' ");
	$data = mysqli_fetch_array($query);

	$data["nombre_completo"] = strtoupper($data["nombre"].' '.$data["nombre_2"]." ".$data["apellidos"]." ".$data["apellidos_2"]);

    $foto = $data["foto_formal"];
    if(!$data["foto_formal"]){
        $foto = "1.png";
    }

	

	$queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);
	
	if($dataInforma["preferencia"]){
		$data["nombre_completo"] = strtoupper($dataInforma["preferencia"]." ".$data["apellidos"]." ".$data["apellidos_2"]);
	}


    $queryPosicion = mysqli_query($connect_valentina,"SELECT * FROM Posiciones WHERE id = '".$data["id_posicion"]."' ");
	$dataPosicion = mysqli_fetch_array($queryPosicion);

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataPosicion["id_cargo"]."' ");
	$dataCargo = mysqli_fetch_array($queryCargo);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_GET["edi"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);

    

    $queryPerfil = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$id."' ");
	$dataPerfil = mysqli_fetch_array($queryPerfil);

    $queryPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$id."' ");
	$dataPreferencias = mysqli_fetch_array($queryPreferencias);

    $queryLaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales WHERE id_empleado = '".$id."' ");
	$dataLaboral = mysqli_fetch_array($queryLaboral);

    $queryTrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$id."' ");
	$dataTrayectoria = mysqli_fetch_array($queryTrayectoria);
    
    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id = '".$_GET["acd"]."' ");
	$dataInforma = mysqli_fetch_array($queryInforma);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte Colaborador</title>
    
<style>
    body{
        font-family: sans-serif;
        background-color: #ececec;
        font-size: 14px;
    }
    .contenedor{
        max-width: 930px;
        margin-right: auto;
        margin-left: auto;
        background-color: #ffffff;
        border-top: 10px solid #00407b;
    }
    
    .bloques{
        padding: 10px 20px;
    }

    .min_foto_perfil{
        width: 90px;
        height: 90px;
        background-image: url('<?php echo $url."/recursos/".$foto; ?>');
        background-size: cover;
        border-radius: 50%;
        display: inline-table;
        background-repeat: no-repeat;
    }
    
    .titulos_info{
        color: #838383;
        font-size: 11px;
    }
    
    .titulos_modulos{
        padding: 10px 0px;
        color: #00407b;
        background-color: #1199d454;
    }
    
    .table-bordered {
        border: 1px solid #dee2e6;
    }	
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }
    table {
        border-collapse: collapse;
    }
			
    .table th, .table td {
        padding: 6px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    @media print{
        body{
            background-color: #ffffff;
        }
        
        .page-body{
            width: 100%;
            margin-left: 0px !important;
            margin-top: 0px !important;
        }
        .page-header{
            display: none;
        }
        
        .no-print {
            display: none !important;
          }
        
        
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }		
    }
</style>
</head>
    
<div align="right" class="bt_print no-print">
    <button type="button" class="btn btn-warning btn-sm" onclick="window.print();" style="background-color: #004b98 ; border: 0; color: #ffffff; padding: 10px; position: fixed;right: 10px; top: 10px;">
        <i class="fa fa-print"></i> Imprimir / Descargar
    </button>
</div>  

<body>



    
    
<div class="contenedor">

    <div align="center" style="border-top: 10px solid #00407b; background-color: #00407b;">
        <img src="<?php echo $url; ?>/img/logo_at_blanco.png" width="160" style="margin-bottom: 10px;">
    </div>
     
    <!-- CABECERA -->
    <div class="bloques" align="center">
        <div class="min_foto_perfil" style="width: 120px; height: 120px"></div>
        <h3 style="margin-bottom: 2px; text-transform: uppercase;"><?php echo $data["nombre_completo"]; ?></h3>
        
    </div>
	
	
	
	
	
	
	
	
	
	
	
  
    
    <!-- BLOQUE -->
    <div class="bloques">
        <div align="center" class="titulos_modulos" style="display: none">
            <b>DATOS ADICIONALES</b>
        </div>
        
        <?php
        $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' ");
	    $dataInforma = mysqli_fetch_array($queryInforma);
        ?>
        
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px; display: none">
            
            
            <tr>
                <td colspan="3">
                    <div class="titulos_info">Fecha de Ingreso</div>
                    <?php echo $dataInforma["fecha_ingreso"]; ?>
                </td>
                
            </tr>
            
           
        </table>
	

		<div align="center" class="titulos_modulos">
            <b>TRAYECTORIA EN AT</b>
        </div>
                
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Cargo</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th>Resumen</th>
                </tr>
                <?php 
                $queryTrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria 
                WHERE id_empleado = '".$data["id"]."' ORDER BY fecha_inicia DESC ");
	            while($dataTrayectoria = mysqli_fetch_array($queryTrayectoria)){

                    $fecha_fin = $dataTrayectoria["fecha_fin"];
                    if(!$dataTrayectoria["fecha_fin"]){
                       $fecha_fin = "a la actualidad";
                    }

                    echo '
                    <tr>
                        <td>'.$dataTrayectoria["cargo"].'</td>
                        <td>'.$dataTrayectoria["fecha_inicia"].'</td>
                        <td>'.$fecha_fin.'</td>
                        <td>'.$dataTrayectoria["resumen"].'</td>
                    </tr>
                    ';   
                }	
                ?>
        </table>

        <?php
        $array_experiencias = array();
        $querylaboralVal = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales 
        WHERE id_empleado = '".$data["id"]."' ORDER BY  fecha_inicio DESC ");
	    
        ?>
		

        <?php if($querylaboralVal->num_rows > 0){ ?>
		<div align="center" class="titulos_modulos">
            <b>EXPERIENCIA LABORAL</b>
        </div>
        
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Entidad</th>
                    <th>Cargo</th>
                    <th>Sector</th>
                    <th>Fecha inicia</th>
                    <th>Fecha termina</th>
                    <th>País</th>
                    <th>Ciudad</th>
                    <th>Experiencia - Resumen funciones y responsabilidades</th>
                </tr>
                <?php 
                $querylaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales 
                WHERE id_empleado = '".$data["id"]."' ORDER BY  fecha_inicio DESC ");
	            while($datalaboral = mysqli_fetch_array($querylaboral)){
                    echo '
                    <tr>
                        <td>'.$datalaboral["entidad"].'</td>
                        <td>'.$datalaboral["cargo"].'</td>
                        <td>'.$datalaboral["sector"].'</td>
                        <td>'.$datalaboral["fecha_inicio"].'</td>
                        <td>'.$datalaboral["fecha_fin"].'</td>
                        <td>'.$datalaboral["pais"].'</td>
                        <td>'.$datalaboral["ciudad"].'</td>
                        <td>'.$datalaboral["experiencia"].'</td>
                    </tr>
                    ';   
                }	
                ?>
        </table>

        <?php } ?>
        
        <div align="center" class="titulos_modulos">
            <b>ACADÉMICO</b>
        </div>
        
        
 
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Titulo</th>
                    <th>Nivel</th>
                    <th>Área</th>
                    <th>Entidad</th>
                    <th>Fecha</th>
                    <th>En curso</th>
                </tr>
                <?php 
                
                    
                $queryAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico 
                WHERE id_empleado = '".$id."'  ");
	            while($dataAcademico = mysqli_fetch_array($queryAcademico)){
                    
                    echo '
                    <tr>
                        <td>'.$dataAcademico["titulo"].'</td>
                        <td>'.$dataAcademico["nivel"].'</td>
                        <td>'.$dataAcademico["area_conocimiento"].'</td>
                        <td>'.$dataAcademico["entidad"].'</td>
                        <td>'.$dataAcademico["fecha_titulo"].'</td>
                        <td>'.$dataAcademico["en_curso"].'</td>
                    </tr>
                    '; 
                    
                }	
                ?>
        </table>
		
		<table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Idioma</th>
                    <th>Nivel</th>
                    <th>Oral / Escrito</th>
                </tr>
                <?php 
                $queryAcademicoIdm = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico_Idiomas 
                WHERE id_empleado = '".$data["id"]."'  ");
	            while($dataAcademicoIdm = mysqli_fetch_array($queryAcademicoIdm)){
                    echo '
                    <tr>
                        <td>'.$dataAcademicoIdm["idioma"].'</td>
                        <td>'.$dataAcademicoIdm["nivel_idiomas"].'</td>
                        <td>'.$dataAcademicoIdm["oral_escrito"].'</td>
                    </tr>
                    ';   
                }	
                ?>
        </table>
        
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Conocimiento y Habilidades</th>
                </tr>
                <?php 
                $queryAcademicoHab = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico_Habilidades 
                WHERE id_empleado = '".$id."'  ");
	            while($dataAcademicoHab = mysqli_fetch_array($queryAcademicoHab)){
                    echo '
                    <tr>
                        <td>'.$dataAcademicoHab["habilidades"].'</td>
                    </tr>
                    ';   
                }	
                ?>
        </table>
        
        
        
        
		
		<div align="center" class="titulos_modulos">
            <b>CERTIFICACIONES / EXAMENES</b>
        </div>
                
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Certificación</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                </tr>
                <?php 
                $sentencia_examen = "
                SELECT
                    *
                FROM
                    Cohortes
                LEFT JOIN Procesos ON Procesos.id = Cohortes.id_proceso
                WHERE
                    Cohortes.id_empleado = '".$data["id"]."' AND Cohortes.estado = 3 AND  Procesos.tipo_capacitacion IN (2,4)
                    
                    
                ORDER BY
                    Cohortes.fecha_evaluacion
                DESC;
                ";
				$queryCohortes = mysqli_query($connect_formacion, $sentencia_examen);  
				while($dataCohortes = mysqli_fetch_array($queryCohortes)){
					
					$queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohortes["id_proceso"]."' "); 
					$dataProc = mysqli_fetch_array($queryProc);
					
					$queryProveedor = mysqli_query($connect_formacion,"SELECT * FROM Proveedores WHERE id = '".$dataProc["proveedor"]."' "); 
					$dataProveedor = mysqli_fetch_array($queryProveedor);
					
					echo '
					<tr>
						<td>'.$dataProc["nombre"].'</td>
						<td>
							'.$dataProveedor["nombre"].'
						</td>
						<td>'.$dataCohortes["fecha_evaluacion"].'</td>
					</tr>
					';
				}
                ?>
        </table>


        <div align="center" class="titulos_modulos">
            <b>OTROS</b>
        </div>
                
        <table class="table table-bordered" width="100%" style="margin-bottom: 15px">
                <tr>
                    <th>Certificación</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                </tr>
                <?php 
                $sentencia_examen = "
                SELECT
                    *
                FROM
                    Cohortes
                LEFT JOIN Procesos ON Procesos.id = Cohortes.id_proceso
                WHERE
                    Cohortes.id_empleado = '".$data["id"]."' AND Cohortes.estado = 3 AND Procesos.tipo_capacitacion IN (1,3,5,6)
                    
                    
                ORDER BY
                    Cohortes.fecha_evaluacion
                DESC;
                ";

				$queryCohortes = mysqli_query($connect_formacion, $sentencia_examen);  
				while($dataCohortes = mysqli_fetch_array($queryCohortes)){
					
					$queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCohortes["id_proceso"]."' "); 
					$dataProc = mysqli_fetch_array($queryProc);
					
					$queryProveedor = mysqli_query($connect_formacion,"SELECT * FROM Proveedores WHERE id = '".$dataProc["proveedor"]."' "); 
					$dataProveedor = mysqli_fetch_array($queryProveedor);
					
					echo '
					<tr>
						<td>'.$dataProc["nombre"].' '.$dataProc["tipo_capacitacion"].' </td>
						<td>
							'.$dataProveedor["nombre"].'
						</td>
						<td>'.$dataCohortes["fecha_evaluacion"].'</td>
					</tr>
					';
				}
			
                /*
				$queryCertificados = mysqli_query($connect_formacion,"SELECT * FROM Certificados__ WHERE id_empleado = '".$data["id"]."' ");  
				while($dataCertificados = mysqli_fetch_array($queryCertificados)){
					
					$queryProc = mysqli_query($connect_formacion,"SELECT * FROM Procesos WHERE id = '".$dataCertificados["id_proceso"]."' "); 
					$dataProc = mysqli_fetch_array($queryProc);
					
					echo '
					<tr>
						<td>'.$dataProc["nombre"].'</td>
						<td>
							<a href="'.$url.'/recursos/'.$dataCertificados["archivo"].'"  target="_blank">'.$dataCertificados["archivo"].'</a>
						</td>
						<td>'.$dataCohortes["fecha_evaluacion"].'</td>
						<td>'.$dataProc["validez_meses"].'</td>
					</tr>
					';

				}
                    */

                ?>
        </table>
    
        


    </div>
    
    <div align="center" style="padding:15px">
        CV generado el <?php echo date("Y-m-d"); ?><br>a las <?php echo date("H:i:s"); ?>
    </div>
    
   
    
</div>    


</body>
</html>
