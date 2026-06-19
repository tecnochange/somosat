<?php

//PROMEDIO GENERAL EVALUADO
//PROMEDIO GENERAL EVALUADO
function PromedioGeneralEvaluado($connect_valoracion, $connect_valentina, $id_evaluado, $id_competencia, $id_comportamiento){
    
    $filtro = "";
    if( $id_competencia > 0 ){ $filtro .= " AND Competencias_Respuestas.id_competencia = '".$id_competencia."' "; }
    if( $id_comportamiento > 0 ){ $filtro .= " AND Competencias_Respuestas_Comportamientos.id_comportamientos = '".$id_comportamiento."' "; }
    
    //ARRAY DE LAS EVALUACIONES RESUMIDAS
    $promedios_evaluaciones = array();
    $comentarios_competencias = ''; //COMENTARIOS SEGUN FILTRO
    $comentarios_evaluaciones = ''; //COMENTARIOS SEGUN FILTRO
    
    //1. PRIMERO CONSULTAMOS LAS EVALUACIONES
    //1. PRIMERO CONSULTAMOS LAS EVALUACIONES
    //CONSULTAMOS LAS EVALUACIONES DEL EVALUADO EN ESTE CICLO
    //CONSULTAMOS LAS EVALUACIONES DEL EVALUADO EN ESTE CICLO
    $qEvaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_evaluado = '".$id_evaluado."' AND estado = 2 ");
    while($dEvaluaciones = mysqli_fetch_array($qEvaluaciones)){
        
        if($dEvaluaciones["observaciones"]){
            $comentarios_evaluaciones .= "<b>↥</b> ".$dEvaluaciones["observaciones"]."<br>";
        }
        $total_promedio = 0;
        
        //OBTENEMOS LAS RESPUESTAS DE CADA COMPETENCIA Y LOS COMPORTAMIENTOS SUBYACENTES
        //OBTENEMOS LAS RESPUESTAS DE CADA COMPETENCIA Y LOS COMPORTAMIENTOS SUBYACENTES
        $qRespuestas = mysqli_query($connect_valoracion,"SELECT 
        Competencias_Respuestas.id as id_respuesta, 
        COUNT(Competencias_Respuestas_Comportamientos.id) AS cantidad_resp , 
        SUM(Competencias_Respuestas_Comportamientos.calificacion) AS suma_calificacion  
        FROM Competencias_Respuestas 
        INNER JOIN Competencias_Respuestas_Comportamientos 
        ON Competencias_Respuestas.id = Competencias_Respuestas_Comportamientos.id_respuesta 
        WHERE Competencias_Respuestas.id_evaluacion = '".$dEvaluaciones['id']."' ".$filtro." ");
        while($dRespuestas = mysqli_fetch_array($qRespuestas)){
            $promedio = $dRespuestas["suma_calificacion"]/$dRespuestas["cantidad_resp"];
            $total_promedio += $promedio;
            if($dRespuestas["observaciones"]){
                $comentarios_competencias .= "<b>↥</b> ".$dRespuestas["observaciones"]."<br>";
            }
        }
        
        if($total_promedio > 0){

            //CARGAMOS LOS DATOS EN UN ARRAY PARA PROCESAR LUEGO
            array_push($promedios_evaluaciones,  
                array(
                    "id"=>$dEvaluaciones["id"], 
                    "tipo"=>$dEvaluaciones["tipo"], 
                    "nombre"=>($dataEmpl["nombre"]." ".$dataEmpl["apellidos"]),
                    "promedio"=> ($total_promedio/$qRespuestas->num_rows)
                ) 
            );
            
        }
    }
    
    
    //print_r($promedios_evaluaciones);
    
    //2. SIMPLIFICAMOS LAS EVALUACIONES EN UN NUEVO ARRAY
    //2. SIMPLIFICAMOS LAS EVALUACIONES EN UN NUEVO ARRAY
    
    //VARIABLES PARA AGRUPAR A LOS EVALUADORES
    $auto = 0; 
    $auto_cant = 0;
    $par = 0; 
    $par_cant = 0;
    $colaborador = 0; 
    $colaborador_cant = 0;
    $cliente = 0; 
    $cliente_cant = 0;
    $jefe = 0; 
    $jefe_cant = 0;

    //RECORREMOS LOS PROMEDIOS DE LOS EVALUADORES
    foreach($promedios_evaluaciones as $grupo){
        if($grupo["tipo"] == 1){ //AUTO
            $auto += $grupo["promedio"];
            $auto_cant++ ;
        }
        if($grupo["tipo"] == 2){ //PAR
            $par += $grupo["promedio"];
            $par_cant++ ;
        }
        if($grupo["tipo"] == 3){ //COLABORADOR
            $colaborador += $grupo["promedio"];
            $colaborador_cant++ ;
        }
        if($grupo["tipo"] == 4){ //CLIENTE
            $cliente += $grupo["promedio"];
            $cliente_cant++ ;
        }
        if($grupo["tipo"] == 5){ //JEFE
            $jefe += $grupo["promedio"];
            $jefe_cant++ ;
        }
    }
    
    //PROMEDIO POR TIPO EVALUADOR
    $promedio_auto = $auto/$auto_cant;
    $promedio_par = $par/$par_cant;
    $promedio_colaborador = $colaborador/$colaborador_cant;
    $promedio_cliente = $cliente/$cliente_cant;
    $promedio_jefe = $jefe/$jefe_cant;
            
    if( is_nan($promedio_auto)) { $promedio_auto = 0;}
    if( is_nan($promedio_par)) { $promedio_par = 0;}
    if( is_nan($promedio_colaborador)) { $promedio_colaborador = 0;}
    if( is_nan($promedio_cliente)) { $promedio_cliente = 0;}
    if( is_nan($promedio_jefe)) { $promedio_jefe = 0;}
   
    //PROMEDIOS FINALES
    $promedios_evaluador_general = array(
        "auto" => $promedio_auto,
        "par" => $promedio_par,
        "colaborador" => $promedio_colaborador,
        "cliente" => $promedio_cliente,
        "jefe" => $promedio_jefe, 
        "comentarios_competencias"=> $comentarios_competencias, 
        "comentarios_evaluaciones"=> $comentarios_evaluaciones 
    );
    
    //print_r($promedios_evaluador_general);
    
    
    //3. ENVIAMOS LOS PROMEDIOS PARA OBTENER LAS PONDERACIONES
    $PROMEDIO_GENERAL = ObtenerPonderacion($connect_valoracion, $_SESSION['ciclo'], $_SESSION['id_empresa'], $promedios_evaluador_general);
    return $PROMEDIO_GENERAL;
}


//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
function ObtenerPonderacion($connect_valoracion, $anio, $id_empresa, $promedios){
    
    //CONSULTAMOS EL MODELO DE PONDERACION DE LA EMPRESA
    $fill = " AND id > 0 ";
    
    if($promedios["auto"] > 0){ $fill .= " AND auto != '' "; }
    else{ $fill .= " AND auto = '' "; }
    
    if($promedios["par"] > 0){ $fill .= " AND par != '' "; }
    else{ $fill .= " AND par = '' "; }
    
    if($promedios["colaborador"] > 0){ $fill .= " AND subalterno != '' "; }
    else{ $fill .= " AND subalterno = '' "; }
    
    if($promedios["cliente"] > 0){ $fill .= " AND cliente != '' "; }
    else{ $fill .= " AND cliente = '' "; }
    
    if($promedios["jefe"] > 0){ $fill .= " AND jefe != '' "; }
    else{ $fill .= " AND jefe = '' "; }
    
    $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones 
    WHERE id_empresa = '".$id_empresa."' ".$fill." ");
    $dataValidate = mysqli_fetch_array($queryValidate);
    
    $queryTipo = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Lista WHERE id = '".$dataValidate["id_tipo_competencia"]."' ");
    $dataTipo = mysqli_fetch_array($queryTipo);
    
   
    $autoP = ( $promedios["auto"]*$dataValidate["auto"] )/100; 
    $jefeP = ( $promedios["jefe"]*$dataValidate["jefe"] )/100; 
    $parP = ( $promedios["par"]*$dataValidate["par"] )/100; 
    $colaP = ( $promedios["colaborador"]*$dataValidate["subalterno"] )/100; 
    $clienteP = ( $promedios["cliente"]*$dataValidate["cliente"] )/100; 
    
    $total = $autoP+$jefeP+$parP+$colaP+$clienteP;
        
    $datos = array(
        "auto"=> $autoP,
        "jefe"=> $jefeP,
        "par"=> $parP,
        "colaborador"=> $colaP,
        "cliente"=> $clienteP,
        "tipo" => $tipo,
        "auto_completo"=> $promedios["auto"],
        "jefe_completo"=> $promedios["jefe"],
        "par_completo"=> $promedios["par"],
        "colaborador_completo"=> $promedios["colaborador"],
        "cliente_completo"=> $promedios["cliente"],
        "total"=>$total, 
        "nombre"=>$dataTipo["nombre"], 
        "comentarios_competencias"=> $promedios["comentarios_competencias"], 
        "comentarios_evaluaciones"=> $promedios["comentarios_evaluaciones"]
    );

    return $datos;

}

//PONDERACION NUMERICA EMPLEADO
//PONDERACION NUMERICA EMPLEADO
//PONDERACION NUMERICA EMPLEADO
function PonderacionPorEmpleado($arrayEvaluadores, $arrayCompetencias_Evaluaciones, $arrayEmpleados, $id_empleado, $arrayComRespuestas, $arrayRespuestas,  $connect_valoracion ){
        
        $completo = true;
        $grupos_tipos = array();

        foreach($arrayEvaluadores as $evaluador){
            //OBTENEMOS SOLO LOS EVALUADORES DE ESTE EMPLEADO
            if($evaluador["id_empleado"] == $id_empleado ){

                $nombre_evaluador = '';
                foreach($arrayEmpleados as $empleado){
                    if( $empleado["id"] == $evaluador["id_evaluador"] ){$nombre_evaluador = $empleado["nombre"]." ".$empleado["apellidos"] ;}
                }

                $total_cal = 0;
                $cant_resp = 0;
                //CARGAMOS LAS RESPUESTAS
                foreach($arrayComRespuestas as $competenciaResp){
                    if( $competenciaResp["id_evaluador"] == $evaluador["id_evaluador"] && $competenciaResp["tipo_evaluador"] == $evaluador["tipo"] ){
                        foreach($arrayRespuestas as $respuesta){
                            if( $respuesta["id_respuesta"] == $competenciaResp["id"] ){
                                $total_cal += $respuesta["calificacion"];
                                $cant_resp++;
                            }
                        }
                    }
                }

                $promedio = $total_cal/$cant_resp ;
                $promedio = round($promedio, 1);

                if( is_nan($promedio)) {
                    $promedio = "N.T.";
                    $completo = false;
                }

                array_push($grupos_tipos,  
                    array(
                        $evaluador["tipo"], 
                        $nombre_evaluador,
                        $promedio
                    ) 
                );  
            }
        }

        //VARIABLES PARA AGRUPAR A LOS EVALUADORES
        $auto = 0; 
        $auto_cant = 0;
        $par = 0; 
        $par_cant = 0;
        $colaborador = 0; 
        $colaborador_cant = 0;
        $cliente = 0; 
        $cliente_cant = 0;
        $jefe = 0; 
        $jefe_cant = 0;

        //RECORREMOS LOS PROMEDIOS DE LOS EVALUADORES
        foreach($grupos_tipos as $grupo){
            if($grupo[0] == 1){ //AUTO
                $auto += $grupo[2];
                $auto_cant++ ;
            }
            if($grupo[0] == 2){ //PAR
                $par += $grupo[2];
                $par_cant++ ;
            }
            if($grupo[0] == 3){ //COLABORADOR
                $colaborador += $grupo[2];
                $colaborador_cant++ ;
            }
            if($grupo[0] == 4){ //CLIENTE
                $cliente += $grupo[2];
                $cliente_cant++ ;
            }
            if($grupo[0] == 5){ //JEFE
                $jefe += $grupo[2];
                $jefe_cant++ ;
            }
        }

        //GUARDAMOS EL PROMEDIOS DE TODOS LOS EVALUADORES POR TIPO
        $promedio_auto = $auto/$auto_cant;
        $promedio_par = $par/$par_cant;
        $promedio_colaborador = $colaborador/$colaborador_cant;
        $promedio_cliente = $cliente/$cliente_cant;
        $promedio_jefe = $jefe/$jefe_cant;

        if( is_nan($promedio_auto)) { $promedio_auto = 0;}
        if( is_nan($promedio_par)) { $promedio_par = 0;}
        if( is_nan($promedio_colaborador)) { $promedio_colaborador = 0;}
        if( is_nan($promedio_cliente)) { $promedio_cliente = 0;}
        if( is_nan($promedio_jefe)) { $promedio_jefe = 0;}

        $promedios_array = array(
            "auto" => $promedio_auto,
            "par" => $promedio_par,
            "colaborador" => $promedio_colaborador,
            "cliente" => $promedio_cliente,
            "jefe" => $promedio_jefe, 
            "comentarios_competencias"=> "", 
            "comentarios_evaluaciones"=> "" 
        );

        $poderacion = 0;
        //$poderacion = ObtenerPonderacion($connect_valoracion, $_SESSION['id_empresa'], $promedios_array);
        $poderacion = ObtenerPonderacion($connect_valoracion, $_SESSION['ciclo'], $_SESSION['id_empresa'], $promedios_array);
    
        $resp = array(
            "datos"=>$poderacion,
            "tabla"=>$grupos_tipos,
            "completo"=>$completo
        );

        return $resp;

}


//VALIDAMOS SI UN EMPLEADO TIENE TODAS LAS EVALUACIONES DE SUS EVALUADORES
//VALIDAMOS SI UN EMPLEADO TIENE TODAS LAS EVALUACIONES DE SUS EVALUADORES
//VALIDAMOS SI UN EMPLEADO TIENE TODAS LAS EVALUACIONES DE SUS EVALUADORES
function ValidarEvaluacionesCompletas($arrayEvaluadores, $arrayCompetencias_Evaluaciones, $id_empleado){
    
    //VALIDAMOS QUE TODOS SUS EVALUADORES TENGAN SU EVALUACION EN ESTADO 2 = COMPLETA
    $no_evaluadores = 0;
    $permitir = true;
    
    foreach($arrayEvaluadores as $evaluador){
        //SOLO LOS EVALUADORES DE ESTE EMPLEADO
        if($evaluador["id_empleado"] == $id_empleado){
            $no_evaluadores++;
            
            //VALIDAMOS SI ESTE EVALUADOR TIENE LA EVALUACION COMPLETA
            $con_eval = 0;
            foreach($arrayCompetencias_Evaluaciones as $evaluacion){
                
                if( $evaluacion["id_evaluado"] == $id_empleado && $evaluacion["id_evaluador"] == $evaluador["id_evaluador"] && $evaluacion["tipo"] == $evaluador["tipo"] && $evaluacion["estado"] == 2 ){
                    $con_eval++;
                }
                
            }
            //SI POR LO MENOS UN EVALUADOR NO TIENE AVALUACION NO SE MUESTRA EL BOTÓN
            if($con_eval == 0){ $permitir = false;  }  
        }
    }

    if($no_evaluadores == 0){ $permitir = false;  }// EN CASO DE NO TENER EVALUADORES
  
    return array(
        "permitir" => $permitir, 
        "no_evaluadores" => $no_evaluadores, 
    );
}
?>