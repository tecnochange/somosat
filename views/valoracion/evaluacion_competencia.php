<?php
    $queryCicloVal = mysqli_query($connect_valoracion,"SELECT * FROM Ciclos WHERE id = '".$_SESSION['ciclo']."' ");
    $dataCicloVal = mysqli_fetch_array($queryCicloVal);
?>

<?php

	$hoy = date("Y-m-d H:i:s");
    $evaluacion = $_GET["e"];

    //EN CASO DE QUE NO EXISTA NINGUNA EVALUACION SE CREA UNA
    //EN CASO DE QUE NO EXISTA NINGUNA EVALUACION SE CREA UNA
    if($_GET["eval"] != ""){
        $queryTempV = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id = '".$_GET["eval"]."' ");
        $dataTempV = mysqli_fetch_array($queryTempV);
        
        $qryValC = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones  
        WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_evaluado = '".$dataTempV["id_empleado"]."' 
        AND id_evaluador = '".$dataTempV["id_evaluador"]."' AND tipo = '".$dataTempV["tipo"]."' ");
        
        if($qryValC->num_rows == 0){
            mysqli_query($connect_valoracion,"INSERT INTO Competencias_Evaluaciones 
            (id_empresa, anio, id_ciclo, id_evaluado, id_evaluador, tipo, observaciones, estado, created_at, update_at) 
            VALUES 
            ( '".$_SESSION['id_empresa']."', '".$dtLic['anio']."', '".$_SESSION['ciclo']."', '".$dataTempV["id_empleado"]."', '".$dataTempV["id_evaluador"]."', '".$dataTempV["tipo"]."', '', 1, '".$hoy."', '".$hoy."' )");
            $id_tmp = mysqli_insert_id( $connect_valoracion );

            echo '<script> window.location = "?pg=valoracion/evaluacion_competencia&e='.$id_tmp.'" </script>';
        }
        else{
            echo '<script> window.location = "?pg=valoracion/realizar_valoracion" </script>';
        }
    }
    
    //PARA CREAR RESPUESTAS DEL EVALUADO
    //PARA CREAR RESPUESTAS DEL EVALUADO
    if($_POST["id_competencia"]  != "" || $_POST["id_evaluado"]  != "" ){
        
        $ndo = 0;
        foreach($_POST["id_competencia"] as $competencia){
        
            //CUANDO ES NUEVO
            if($_POST["id_registro"][$ndo] == ""){

                mysqli_query($connect_valoracion,"INSERT INTO Competencias_Respuestas 
                ( id_ciclo, id_empresa, id_evaluado, id_evaluador, id_evaluacion, tipo_evaluador, id_competencia, observaciones,  created_at) 
                VALUES 
                ( '".$_SESSION['ciclo']."', '".$_SESSION['id_empresa']."', '".$_POST["id_evaluado"]."', '".$_POST["id_evaluador"]."', '".$evaluacion."', '".$_POST["tipo_evaluador"]."', '".$competencia."', '".$_POST["observaciones"][$ndo]."', '".$hoy."' )");

                $id_tmp = mysqli_insert_id( $connect_valoracion ); 

                foreach( $_POST["comp_".$competencia] as $comportamiento ){
                   $partes = explode(",", $comportamiento); 

                    mysqli_query($connect_valoracion,"INSERT INTO Competencias_Respuestas_Comportamientos 
                    ( id_ciclo, id_empresa, id_respuesta, id_competencia, id_comportamientos, 
                    id_nivel_competencia, id_evaluado, id_evaluador, tipo_evaluador, anio, 
                    calificacion, created_at) VALUES 
                    ( '".$_SESSION['ciclo']."', '".$_SESSION['id_empresa']."', '".$id_tmp."', '".$competencia."',  '".$partes[0]."', 
                    '".$partes[2]."', '".$_POST["id_evaluado"]."', '".$_POST["id_evaluador"]."', '".$_POST["tipo_evaluador"]."', '".$partes[3]."', 
                    '".$partes[1]."', '".$hoy."' )");  

                }
            }

            //ACTUALIZACION
            else{

                //foreach($_POST["id_registro"] as $registro){
                
                    mysqli_query($connect_valoracion,"UPDATE Competencias_Respuestas SET observaciones = '".$_POST["observaciones"][$ndo]."'
                    WHERE id = '".$_POST["id_registro"][$ndo]."' ");

                    foreach( $_POST["comp_".$competencia] as $comportamiento ){
                       $partes = explode(",", $comportamiento); 

                        mysqli_query($connect_valoracion,"UPDATE Competencias_Respuestas_Comportamientos SET  
                        calificacion = '".$partes[1]."' WHERE id_comportamientos = '".$partes[0]."' AND id_respuesta = '".$_POST["id_registro"][$ndo]."' 
                        AND id_competencia =  '".$competencia."'  ");  

                    }
                    
                //}
                
            }
            $ndo++;
    
        }
        
        //AQUÍ OBTENEMOS EL PROMEDIO DE LA EVALUACIÓN
        //AQUÍ OBTENEMOS EL PROMEDIO DE LA EVALUACIÓN
        //AQUÍ OBTENEMOS EL PROMEDIO DE LA EVALUACIÓN
        //AQUÍ OBTENEMOS EL PROMEDIO DE LA EVALUACIÓN
        $count_comp = 0;
        $prom_com = 0;
        $promedio_evaluacion = 0;
        foreach($_POST["id_competencia"] as $competencia){
            foreach( $_POST["comp_".$competencia] as $comportamiento ){
                $partes = explode(",", $comportamiento); 
                $count_comp++;
                $prom_com += $partes[1];
            }
        }
        $promedio_evaluacion = round(($prom_com/$count_comp),2);


        mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones SET observaciones = '".$_POST["observaciones_finales"]."', 
        promedio = '".$promedio_evaluacion."' WHERE id = '".$evaluacion."' ");
        
    }

    //OBSERVACIONES FINALES
    if($_POST["observaciones_finales___"] != ""){
        mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones SET observaciones = '".$_POST["observaciones_finales"]."'
        WHERE id = '".$evaluacion."' ");
    }

    //FINALIZAR LA EVALUACION
    if($_POST["terminar_evaluacion_final"] != ""){
        mysqli_query($connect_valoracion,"UPDATE Competencias_Evaluaciones SET estado = '2', update_at = '".$hoy."' 
        WHERE id = '".$evaluacion."' ");
        
        echo '<script> window.location = "?pg=valoracion/realizar_valoracion" </script>';
    }






    
	//CARGAMOS LOS NIVELES
	$arrayTipos = array();
	$queryT = mysqli_query($connect_valoracion,"SELECT * FROM Tipos WHERE anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataT = mysqli_fetch_array($queryT)){
		array_push($arrayTipos, array( $dataT["id"], $dataT["nombre"] ) );
	}
	
	//CARGAMOS LOS NIVELES
	$arrayNiveles = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Niveles WHERE anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
		array_push($arrayNiveles, array( $dataN["id"], $dataN["nombre"] ) );
	}


    //CONSULTAMOS EL DATO DEL EVALUADOR
    $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id = '".$evaluacion."'");
    $dataEvaluacion = mysqli_fetch_array($queryEvaluacion);
    $tipo_evaluador = $dataEvaluacion["tipo"];

    //TIPOS PERMITIDOS
	$arrayTiposPermitidos = array();
	$queryN = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Tipo_Evaluador WHERE id_empresa = '".$_SESSION['id_empresa']."' 
    AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
	while($dataN = mysqli_fetch_array($queryN)){
        
        $permitir = false;
        if($tipo_evaluador == 1 ){
            if($dataN["auto"] == 'on'){
                $permitir = true;
            }
        }
        if($tipo_evaluador == 2 ){
            if($dataN["par"] == 'on'){
                $permitir = true;
            }
        }
        if($tipo_evaluador == 3 ){
            if($dataN["subalterno"] == 'on'){
                $permitir = true;
            }
        }
        if($tipo_evaluador == 4 ){
            if($dataN["cliente"] == 'on'){
                $permitir = true;
            }
        }
        if($tipo_evaluador == 5 ){
            if($dataN["jefe"] == 'on'){
                $permitir = true;
            }
        }
       
       if($permitir == true){
            array_push($arrayTiposPermitidos, array( 
                "id"=>$dataN["id"], "tipo"=>$dataN["id_tipo_competencia"],
                "auto"=>$dataN["auto"], 
                "jefe"=>$dataN["jefe"], 
                "par"=>$dataN["par"],
                "subalterno"=>$dataN["subalterno"],
                "cliente"=>$dataN["cliente"]
            ) );
       }
        
	}

    $queryEvaluador = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluacion["id_evaluador"]."'");
    $dataEvaluador = mysqli_fetch_array($queryEvaluador);

    $queryCargoE = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEvaluador["id_cargo"]."' ");  
    $dataCargoE = mysqli_fetch_array($queryCargoE);


    //data del evaluado
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluacion["id_evaluado"]."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);

    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);

    $perfiles = explode("," , $dataCargo["perfil"] );
            
    $tipo_list = '';
    $competencia_list = '';
    $nivel_list = '';
    foreach($perfiles as $prf){
                
        $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$prf."' ");
        $dataNivel = mysqli_fetch_array($queryNivel);
                
        $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
        $dataComp = mysqli_fetch_array($queryComp);
                    
        $text_nivel = '';
        foreach ($arrayNiveles as &$nivel) {
            if( $dataNivel["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
        }
       
        $text_tipo = '';
        foreach ($arrayTipos as &$tipo) {
            if( $dataComp["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
        }
       
        $nivel_list .= $text_nivel."<br>";
        $competencia_list .= $dataComp["nombre"]."<br>";
        $tipo_list .= $text_tipo."<br>";
    }

?>

<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>



<nav aria-label="breadcrumb" style="margin-top: 15px;">
  <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="?pg=home">Home</a></li>
        <li class="breadcrumb-item"><a href="?pg=valoracion/realizar_valoracion">Realizar Valoración</a></li>
        <li class="breadcrumb-item active" aria-current="page">Valoración</li>
  </ol>
</nav>

<div align="left" style="padding: 10px 0px;">
	<table width="100%">
    	<tr>
        	<td><h5 style="margin-top: 8px;"></i> Evaluación <b><?php echo $dataCicloVal["nombre"]; ?></b></h5></td>
            <td align="right">
            	
            </td>
        </tr>
    </table>
    
    
    
</div>

<!-- Resumen -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-4" align="left">
                Nombre del Evaluado: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
                Nombre del Evaluador: <b><?php echo $dataEvaluador["nombre"]." ".$dataEvaluador["apellidos"]; ?></b> <br>
            </div>
            <div class="col-md-4" align="left">
                Cargo Evaluado: <b><?php echo $dataCargo["nombre"]; ?></b> <br>
                Cargo Evaluador: <b><?php echo $dataCargoE["nombre"]; ?></b> <br>
            </div>
            <div class="col-md-4" align="left">
                Fecha:<br><b><?php echo $dataEvaluacion["created_at"]; ?></b>
            </div>
        </div>

        
    </div>
</div>

<!-- Escala -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div><b>ESCALA DE VALORACION A UTILIZAR</b></div>
        <div style="margin-bottom: 15px">Para valorar cada uno de los comportamientos de las competencias utilice la siguiente escala; léala detenidamente antes de comenzar la valoración.</div>

        <?php
            $queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = '".$dtEmpresa["id"]."' ");
	        $dataEscala = mysqli_fetch_array($queryEscala);
        ?>

        
        
        <table width="100%">
        
            <tr>
                <td width="25%" bgcolor="#FF7173" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    1
                </td>
                <td width="25%" bgcolor=" #FFC03A" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    2
                </td>
                <td width="25%" bgcolor=" #2ADAFF" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    3
                </td>
                <td width="25%" bgcolor=" #B5FF87" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    4
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" >
                    <b><?php echo $dataEscala["nombre_n_1"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_1"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_2"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_2"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_3"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_3"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_4"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_4"]; ?>
                </td>
            </tr>
        </table>
        
        
    </div>

</div>

<div align="center" id="preloader_img">
    <h2>Cargado el formulario. por favor espere...</h2>
</div>

<form action="" method="post" id="formulario" style="display: none">
<input type="hidden" name="id_evaluado" value="<?php echo $dataEvaluacion["id_evaluado"]; ?>">
<input type="hidden" name="id_evaluador" value="<?php echo $dataEvaluacion["id_evaluador"]; ?>">
<input type="hidden" name="tipo_evaluador" value="<?php echo $tipo_evaluador; ?>">
<?php 
$btn_terminar = false;
    
$count = 1;
foreach($perfiles as $prf){
    $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$prf."' ");
    $dataNivel = mysqli_fetch_array($queryNivel);
                
    $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
    $dataComp = mysqli_fetch_array($queryComp);
                    
    $text_nivel = '';
    foreach ($arrayNiveles as &$nivel) {
        if( $dataNivel["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
    }
       
    $text_tipo = '';
    foreach ($arrayTipos as &$tipo) {
        if( $dataComp["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
    }
    
    $mostrar = false;
    foreach ($arrayTiposPermitidos as &$tipoPermitidos) {
        if( $dataComp["id_tipo"] == $tipoPermitidos["tipo"] ){ $mostrar = true; }
    }
    
    $queryRespTemp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE 
    id_competencia = '".$dataComp["id"]."' AND id_evaluador = '".$dataEvaluacion["id_evaluador"]."' AND 
    id_evaluado = '".$dataEvaluacion["id_evaluado"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id DESC ");
    $dataRespTemp = mysqli_fetch_array($queryRespTemp);
    
    if($mostrar == true){
   
?>

<!-- Competencias -->
<!-- Competencias -->    
<input type="hidden" name="id_competencia[]" value="<?php echo $dataComp["id"]; ?>">
<input type="hidden" name="id_registro[]" value="<?php echo $dataRespTemp["id"]; ?>">

    
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        <p>Tipo Competencia: <?php echo $text_tipo; ?></p>
        <h3><?php echo $count.": ".$dataComp["nombre"]; ?></h3>
        <p><?php echo $dataComp["definicion"]; ?></p>
        
        

        <table width="100%">
            <?php
            
            $count++;
            $count_int = 1;
            $queryPreguntas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Preguntas 
            WHERE id_competencia = '".$dataComp["id"]."' AND id_nivel_competencia = '".$prf."' AND anio = '".$_SESSION['anio']."' ORDER BY id DESC ");
            while($dataPreguntas = mysqli_fetch_array($queryPreguntas)){
                
                $queryPregTemp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
                WHERE id_competencia = '".$dataComp["id"]."' AND id_comportamientos = '".$dataPreguntas["id"]."' AND 
                id_respuesta = '".$dataRespTemp["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ORDER BY id DESC ");
                $dataPregTemp = mysqli_fetch_array($queryPregTemp);

                $check_true_1 = "required ";
                $check_true_2 = "required ";
                $check_true_3 = "required ";
                $check_true_4 = "required ";
                if($dataPregTemp["calificacion"] == 1){ 
                    $check_true_1 = "required checked";
                    $check_true_2 = "";
                    $check_true_3 = "";
                    $check_true_4 = " ";
                }
                if($dataPregTemp["calificacion"] == 2){ 
                    $check_true_1 = ""; 
                    $check_true_2 = "required checked";
                    $check_true_3 = "";
                    $check_true_4 = "";
                }
                if($dataPregTemp["calificacion"] == 3){ 
                    $check_true_1 = ""; 
                    $check_true_2 = "";
                    $check_true_3 = "required checked";
                    $check_true_4 = "";
                }
                if($dataPregTemp["calificacion"] == 4){ 
                    $check_true_1 = ""; 
                    $check_true_2 = "";
                    $check_true_3 = "";
                    $check_true_4 = "required checked";
                }

                echo '
                        <tr tile="'.$dataPregTemp["id"].'">
                            <td style="padding-right: 15px;"><b>'.$count_int.'.</b> </td>
                            <td>'.$dataPreguntas["pregunta"].'</td>
                            <td width="50">1 <input type="checkbox" class="checkbox_list comp_'.$dataPreguntas["id"].'" name="comp_'.$dataComp["id"].'[]" value="'.$dataPreguntas["id"].', 1, '.$dataPreguntas["id_nivel_competencia"].', '.$dataPreguntas["anio"].'" '.$check_true_1.' onClick="SelectCheck(this, '.$dataPreguntas["id"].')" ></td>
                            <td width="50">2 <input type="checkbox" class="checkbox_list comp_'.$dataPreguntas["id"].'" name="comp_'.$dataComp["id"].'[]" value="'.$dataPreguntas["id"].', 2, '.$dataPreguntas["id_nivel_competencia"].', '.$dataPreguntas["anio"].'" '.$check_true_2.' onClick="SelectCheck(this, '.$dataPreguntas["id"].')" ></td>
                            <td width="50">3 <input type="checkbox" class="checkbox_list comp_'.$dataPreguntas["id"].'" name="comp_'.$dataComp["id"].'[]" value="'.$dataPreguntas["id"].', 3, '.$dataPreguntas["id_nivel_competencia"].', '.$dataPreguntas["anio"].'" '.$check_true_3.' onClick="SelectCheck(this, '.$dataPreguntas["id"].')" ></td>
                            <td width="50">4 <input type="checkbox" class="checkbox_list comp_'.$dataPreguntas["id"].'" name="comp_'.$dataComp["id"].'[]" value="'.$dataPreguntas["id"].', 4, '.$dataPreguntas["id_nivel_competencia"].', '.$dataPreguntas["anio"].'" '.$check_true_4.' onClick="SelectCheck(this, '.$dataPreguntas["id"].')" ></td>
                        </tr>
                ';
                $count_int++;
                
                if($queryPregTemp->num_rows > 0){ $btn_terminar = true; }

            }
            ?>
        </table>
        
        <div style="margin: 10px">OBSERVACIONES Y COMENTARIOS</div>
        <textarea class="form-control" name="observaciones[]"><?php echo $dataRespTemp["observaciones"]; ?></textarea>
        
        

    </div>
</div>

<?php } } ?>


<!-- Competencias -->
<!-- Competencias -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <h3>OBSERVACIONES Y COMENTARIOS FINALES</h3>
        <p>Escriba aquí sus sugerencias, recomendaciones o ejemplos concretos que le permitirán a la persona evaluada mejorar en sus comportamientos</p>

        
        <div style="margin: 10px">(Escribir en este campo es obligatorio para poder terminar la evaluación/valoración)</div>
        <textarea class="form-control" name="observaciones_finales" required><?php echo $dataEvaluacion["observaciones"]; ?></textarea>
        
        <div align="center" style="margin-top: 10px">
            <p style="color: #FF0004">
                Por favor no olvide guardar la información consignada para que el sistema mantenga la misma.
            </p>
            <button type="submit" class="btn btn-success btn-block" style="font-size: 30px">
                GUARDAR
            </button>
        </div>
        
    </div>
</div>
</form>


<?php if($btn_terminar == true){ ?>
<!-- Competencias -->
<!-- Competencias -->
<form action="" method="post">
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" style="text-align: justify">
        
        <input type="hidden" name="terminar_evaluacion_final" value="true">

        <div style="margin: 20px 0px">
        Recuerde que después de enviadas estas calificaciones no se podrán modificar ni borrar, por lo tanto es importante que usted haya realizado esta valoración de manera consciente y objetiva. Marque la casilla a continuación si está de acuerdo con la valoracion realizada y con las calificaciones que asigno a cada uno de los comportamientos de las competencias.<br><br>

Seleccione la siguiente casilla para poder terminar la evaluacion. <input type="checkbox" class="checkbox_list" onClick="Activar_Terminar_Eval(this)">
        </div>
        
        <div align="center" style="margin-top: 10px">
            <button type="submit" class="btn btn-info btn-block" id="bt_terminar_evaluacion" disabled >
                Terminar y Cerrar Valoración
            </button>
        </div>
        
    </div>
</div>
</form>
<?php } ?>





<script>
    $("#bt_val_realizar").addClass("active_item");
    
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
    
    $( document ).ready(function() {
        $("#formulario").show();
        $("#preloader_img").hide();
        
    });
    
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
    margin-left: 8px;
}
    
    
</style>

