<?php

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
                        
                if( $evaluacion["id_evaluado"] == $id_empleado && $evaluacion["id_evaluador"] == $evaluador["id"] && $evaluacion["tipo"] == $evaluador["tipo"] && $evaluacion["estado"] == 2 ){
                    $con_eval++;
                }
            }
            //SI POR LO MENOS UN EVALUADOR NO TIENE AVALUACION NO SE MUESTRA EL BOTÓN
            if($con_eval > 0){ $permitir = false;  }  
        }
    }
            
    if($no_evaluadores == 0){ $permitir = false;  }// EN CASO DE NO TENER EVALUADORES
        
    $respuesta = array(
        "permitir" => $permitir, 
        "no_evaluadores" => $no_evaluadores
    );
        
    return $respuesta;
}

//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
function ObtenerPonderacion($connect_valoracion, $anio, $id_empresa, $promedios){
    
    $tipo = '';
    $ultimaFila;
    //consultamos la lista de tipo
    $query = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Lista ");
    while($data = mysqli_fetch_array($query)){

        $opciones = 0;
        $aciertos = 0;
        
        if($promedios["auto"] > 0 ){ 
            $aciertos++; 
            if( $data["auto"] == "on" ){ $opciones++; }
        }
        if($promedios["jefe"] > 0 ){ 
            $aciertos++; 
            if( $data["jefe"] == "on"){  $opciones++; }
        }
        if($promedios["par"] > 0 ){ 
            $aciertos++; 
             if( $data["par"] == "on" ){  $opciones++; }
        }
        if($promedios["colaborador"] > 0 ){ 
            $aciertos++;
            if( $data["subalterno"] == "on" ){  $opciones++; }
        }
        
       if($promedios["cliente"] > 0 ){ 
           $aciertos++;
           if( $data["cliente"] == "on" ){  $opciones++; }
       }        
        
        $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones WHERE id_empresa = '".$id_empresa."' AND anio = '".$anio."' AND id_tipo_competencia = '".$data["id"]."' ");
        $dataValidate = mysqli_fetch_array($queryValidate);
                
        if($opciones == $aciertos){
            $tipo = $data["nombre"];
            $ultimaFila = $dataValidate;
            break;
        }
    }
       
    $autoP = ( $promedios["auto"]*$ultimaFila["auto"] )/100; 
    $jefeP = ( $promedios["jefe"]*$ultimaFila["jefe"] )/100; 
    $parP = ( $promedios["par"]*$ultimaFila["par"] )/100; 
    $colaP = ( $promedios["colaborador"]*$ultimaFila["subalterno"] )/100; 
    $clienteP = ( $promedios["cliente"]*$ultimaFila["cliente"] )/100; 
    
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
        "total"=>$total
    );

    return $datos;
}


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
        "jefe" => $promedio_jefe
    );
    
    $poderacion = 0;
    $poderacion = ObtenerPonderacion($connect_valoracion, '2021', $_SESSION['id_empresa'], $promedios_array);
    $resp = array(
        "datos"=>$poderacion,
        "tabla"=>$grupos_tipos,
        "completo"=>$completo
    );
    
    return $resp;

}








































//TIPO DE PONDERACION
//TIPO DE PONDERACION
function PonderacionEmPleado( $id_empleado, $array_evaluadores, $array_empleados,  $connect_valoracion, $connect_valentina ){
    
    $array_datos_general = array();
    $evaluadores_lista = array();
    
    //TOMAMOS LOS EVALUADORES
    foreach($array_evaluadores as $evaluador){
        if($evaluador["id_empleado"] == $id_empleado){
            
            $datos_evaluador = array_search( $evaluador["id_evaluador"] , array_column($array_empleados, 'id' ));
            
            /*
            $nombre_eval = '';
            foreach($array_evaluadores as $evaluador){
                if(){
                   $nombre_eval 
                }
            }
            */
            
            array_push($evaluadores_lista,  
                array(
                    "id_evaluador"=>$evaluador["id_evaluador"], 
                    "id_empleado"=>$evaluador["id_empleado"], 
                    "tipo"=>$evaluador["tipo"],
                    "evaluador"=>$datos_evaluador
                    
                ) 
            );
            
            print_r($datos_evaluador);
            break;

        }
    }
    
    return $evaluadores_lista;
    
/*
    $grupos_tipos = array();
    //VALIDAMOS SI TIENE EVALUACION COMPLETA  Y EVALUADORES
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id_empleado."' ");  
    while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){

        //DATO DEL EVALUADOR
        $queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
        $dataEmpl = mysqli_fetch_array($queryEmpl); 
     
        //VALIDAMOS SI TIENE EVALUACION COMPLETA DE ESTE EVALUADOR
        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND  anio = '2021' AND id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  tipo = '".$dataEvaluadores["tipo"]."' ");
        $dataEval = mysqli_fetch_array($queryEval);
        
        
        
        //SI LA EVALUACIÓN ESTÁ COMPLETA
        if($dataEval["estado"] == 2){
                    
            $promedio = PromedioCompetencia($id_empleado, $dataEval["id_evaluador"], $dataEval["tipo"], $connect_valoracion, $id_competencia);
            $promedio = round($promedio, 1);
      
            if( is_nan($promedio)) {
                $promedio = "N.T.";
            }
      
            array_push($grupos_tipos,  
                array(
                    $dataEvaluadores["tipo"], 
                    ($dataEmpl["nombre"]." ".$dataEmpl["apellidos"]),
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
        "jefe" => $promedio_jefe
    );

    $poderacion = ObtenerPonderacion($connect_valoracion, '2021', $_SESSION['id_empresa'], $promedios_array);

    $resp = array(
        "datos"=>$poderacion,
        "tabla"=>$grupos_tipos
    );
    return($resp);
    */
}

















//PROMEDIO POR EVALUADOR
//PROMEDIO POR EVALUADOR
function Promedio($empleado, $evaluador, $tipo_eval, $connect_valoracion){
    $respuestas = '';
    $total_cal = 0;
    $cant_resp = 0;
    $queryRespTemp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_evaluado = '".$empleado."' 
    AND id_evaluador = '".$evaluador."' AND tipo_evaluador = '".$tipo_eval."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
    while($dataRespTemp = mysqli_fetch_array($queryRespTemp)){
                
            $queryCal = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos 
            WHERE id_respuesta = '".$dataRespTemp["id"]."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
            while($dataCalif = mysqli_fetch_array($queryCal)){
                $total_cal += $dataCalif["calificacion"];
                $cant_resp++;
            } 
                
    }
    $respuestas = $total_cal/$cant_resp ;
    return $respuestas;
}

//PONDERACION NUMERICA EMPLEADO
//PONDERACION NUMERICA EMPLEADO
function PonderacionNumericaEmpleado($connect_valoracion, $connect_valentina, $id_empleado ){

    $grupos_tipos = array();
    //VALIDAMOS SI TIENE EVALUACION COMPLETA  Y EVALUADORES
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empleado = '".$id_empleado."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
    while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){

        //DATO DEL EVALUADOR
        $queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
        $dataEmpl = mysqli_fetch_array($queryEmpl); 
     
        //VALIDAMOS SI TIENE EVALUACION COMPLETA DE ESTE EVALUADOR
        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones 
        WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND 
        id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  
        tipo = '".$dataEvaluadores["tipo"]."' ");
        $dataEval = mysqli_fetch_array($queryEval);

        //SI LA EVALUACIÓN ESTÁ COMPLETA
        if($dataEval["estado"] == 2){
                    
            $promedio = Promedio($id_empleado, $dataEval["id_evaluador"], $dataEval["tipo"], $connect_valoracion);
            $promedio = round($promedio, 1);
      
            if( is_nan($promedio)) {
                $promedio = "N.T.";
            }
      
            array_push($grupos_tipos,  
                array(
                    $dataEvaluadores["tipo"], 
                    ($dataEmpl["nombre"]." ".$dataEmpl["apellidos"]),
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
        "jefe" => $promedio_jefe
    );

    $poderacion = ObtenerPonderacion($connect_valoracion, '2021', $_SESSION['id_empresa'], $promedios_array);
    $resp = array(
        "datos"=>$poderacion,
        "tabla"=>$grupos_tipos
    );
    
    return($resp);
}




















































//PROMEDIO POR EVALUADOR
//PROMEDIO POR EVALUADOR
function PromedioCompetencia($empleado, $evaluador, $tipo_eval, $connect_valoracion, $id_competencia){
    $respuestas = '';
    $total_cal = 0;
    $cant_resp = 0;

    $queryRespTemp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas 
    WHERE id_evaluado = '".$empleado."' AND id_evaluador = '".$evaluador."' AND tipo_evaluador = '".$tipo_eval."' AND 
    id_competencia = '".$id_competencia."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
    while($dataRespTemp = mysqli_fetch_array($queryRespTemp)){
            $queryCal = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_respuesta = '".$dataRespTemp["id"]."' ");
            while($dataCalif = mysqli_fetch_array($queryCal)){
                $total_cal += $dataCalif["calificacion"];
                $cant_resp++;
            } 
    }
            
    $respuestas = $total_cal/$cant_resp ;
    return $respuestas;
}

//TIPO DE PONDERACION
//TIPO DE PONDERACION
function PonderacionNumericaEmpleadoCompetencia($connect_valoracion, $connect_valentina, $id_empleado, $id_competencia ){

    $grupos_tipos = array();
    //VALIDAMOS SI TIENE EVALUACION COMPLETA  Y EVALUADORES
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id_empleado."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
    while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){

        //DATO DEL EVALUADOR
        $queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
        $dataEmpl = mysqli_fetch_array($queryEmpl); 
     
        //VALIDAMOS SI TIENE EVALUACION COMPLETA DE ESTE EVALUADOR
        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  tipo = '".$dataEvaluadores["tipo"]."' ");
        $dataEval = mysqli_fetch_array($queryEval);
        
        //SI LA EVALUACIÓN ESTÁ COMPLETA
        if($dataEval["estado"] == 2){
                    
            $promedio = PromedioCompetencia($id_empleado, $dataEval["id_evaluador"], $dataEval["tipo"], $connect_valoracion, $id_competencia);
            $promedio = round($promedio, 1);
      
            if( is_nan($promedio)) {
                $promedio = "N.T.";
            }
        
            array_push($grupos_tipos,  
                array(
                    $dataEvaluadores["tipo"], 
                    ($dataEmpl["nombre"]." ".$dataEmpl["apellidos"]),
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
        "jefe" => $promedio_jefe
    );

    $poderacion = ObtenerPonderacion($connect_valoracion, '2021', $_SESSION['id_empresa'], $promedios_array);

    $resp = array(
        "datos"=>$poderacion,
        "tabla"=>$grupos_tipos
    );
    return($resp);
}


//print_r( PonderacionNumericaEmpleadoCompetencia($connect_valoracion, $connect_valentina, 301, 1 ) );














































//PROMEDIO POR EVALUADOR
//PROMEDIO POR EVALUADOR
function PromedioComportamientos( $empleado, $evaluador, $tipo_eval, $connect_valoracion, $id_competencia, $id_comportamiento ){
    $respuestas = '';
    $total_cal = 0;
    $cant_resp = 0;
    $observacion = '';

    $queryRespTemp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_evaluado = '".$empleado."' 
    AND id_evaluador = '".$evaluador."' AND tipo_evaluador = '".$tipo_eval."' AND id_competencia = '".$id_competencia."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
    while($dataRespTemp = mysqli_fetch_array($queryRespTemp)){
            $queryCal = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas_Comportamientos WHERE id_respuesta = '".$dataRespTemp["id"]."' AND id_comportamientos = '".$id_comportamiento."' AND id_ciclo = '".$_SESSION['ciclo']."'  ");
            while($dataCalif = mysqli_fetch_array($queryCal)){
                $total_cal += $dataCalif["calificacion"];
                $cant_resp++;
                if($dataRespTemp["observaciones"] != ""){
                    $observacion .= $dataRespTemp["observaciones"]."<br>";
                }
            } 
    }
            
    $respuestas = array( $total_cal/$cant_resp , $observacion );
    return $respuestas;
}

//TIPO DE PONDERACION
//TIPO DE PONDERACION
function PonderacionNumericaEmpleadoCompetenciaComportamientos($connect_valoracion, $connect_valentina, $id_empleado, $id_competencia, $id_comportamiento ){
    
    $observaciones_comportamientos = '';

    $grupos_tipos = array();
    //VALIDAMOS SI TIENE EVALUACION COMPLETA  Y EVALUADORES
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id_empleado."' AND id_ciclo = '".$_SESSION['ciclo']."' ");  
    while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){

        //DATO DEL EVALUADOR
        $queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataEvaluadores["id_evaluador"]."' ");  
        $dataEmpl = mysqli_fetch_array($queryEmpl); 
     
        //VALIDAMOS SI TIENE EVALUACION COMPLETA DE ESTE EVALUADOR
        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_evaluado = '".$dataEvaluadores["id_empleado"]."' AND  id_evaluador = '".$dataEvaluadores["id_evaluador"]."' AND  tipo = '".$dataEvaluadores["tipo"]."' ");
        $dataEval = mysqli_fetch_array($queryEval);
        
        
        
        //SI LA EVALUACIÓN ESTÁ COMPLETA
        if($dataEval["estado"] == 2){
                    
            $promedio_array = PromedioComportamientos($id_empleado, $dataEval["id_evaluador"], $dataEval["tipo"], $connect_valoracion, $id_competencia, $id_comportamiento);
            $promedio = round($promedio_array[0], 1);
            
            if($promedio_array[1] != "" ){$observaciones_comportamientos .= $promedio_array[1]; }
      
            if( is_nan($promedio)) {
                $promedio = "N.T.";
            }
      
            array_push($grupos_tipos,  
                array(
                    $dataEvaluadores["tipo"], 
                    ($dataEmpl["nombre"]." ".$dataEmpl["apellidos"]),
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
        "jefe" => $promedio_jefe
    );

    $poderacion = ObtenerPonderacion($connect_valoracion, '2021', $_SESSION['id_empresa'], $promedios_array);

    $resp = array(
        "datos"=>$poderacion,
        "tabla"=>$grupos_tipos, 
        "observaciones"=>$observaciones_comportamientos
    );
    return($resp);
}






?>
