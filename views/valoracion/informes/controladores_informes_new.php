<?php
//VALIDAMOS SI UN EMPLEADO TIENE TODAS LAS EVALUACIONES DE SUS EVALUADORES
//VALIDAMOS SI UN EMPLEADO TIENE TODAS LAS EVALUACIONES DE SUS EVALUADORES
//VALIDAMOS SI UN EMPLEADO TIENE TODAS LAS EVALUACIONES DE SUS EVALUADORES
function ValidarEvaluacionesCompletas($id_empleado, $connect_valoracion, $connect_valentina){
    
    //1. CARGAMOS LO PROMEDIOS DE LA EVALUACIONES DE LOS EVALUADORES
    //1. CARGAMOS LO PROMEDIOS DE LA EVALUACIONES DE LOS EVALUADORES
    $promedios_evaluaciones = array();
    $no_evaluadores = 0;
    $permitir = true;
    
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND anio = '".$_SESSION['anio']."' AND id_empleado = '".$id_empleado."' ");
	while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
        
        $queryEvalDor = mysqli_query($connect_valentina,"SELECT nombre, apellidos FROM Empleados 
        WHERE id = '".$dataEvaluadores['id_evaluador']."' ");  
        $dataEvalDor = mysqli_fetch_array($queryEvalDor); 
        
        $no_evaluadores++;

        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE 
        id_empresa = '".$_SESSION['id_empresa']."' AND 
        anio = '".$_SESSION['anio']."' AND
        id_evaluado = '".$id_empleado."' AND  
        id_evaluador = '".$dataEvaluadores['id_evaluador']."' AND 
        id_ciclo = '".$_SESSION['ciclo']."' AND
        tipo_evaluacion = '".$dataEvaluadores["tipo"]."' AND 
        estado = 2  ");
        $dataEval = mysqli_fetch_array($queryEval);
        
        
        
        array_push($promedios_evaluaciones,  
            array(
                "id"=>$dataEval["id"], 
                "tipo"=>$dataEval["tipo"], 
                "nombre"=> ($dataEvalDor["nombre"]." ".$dataEvalDor["apellidos"]),
                "promedio"=> $dataEval["promedio"]
            ) 
        );
	}
     
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
        "comentarios_competencias"=> "", 
        "comentarios_evaluaciones"=> "" 
    );

    $general_sin_ponderar = $promedio_auto+$promedio_par+$promedio_colaborador+$promedio_cliente+$promedio_jefe;
    
    
    
    

    if($no_evaluadores == 0){ $permitir = false;  }// EN CASO DE NO TENER EVALUADORES
    
    
    $PROMEDIO_GENERAL = PonderarEvaluaciones($connect_valoracion, $promedios_evaluador_general);
    
  
    return array(
        "permitir" => $permitir, 
        "no_evaluadores" => $no_evaluadores, 
        "promedio_general" => $PROMEDIO_GENERAL, 
        "dato_evaluadores" => $promedios_evaluaciones
    );
  
}

//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
//PONDERACIÓN GENERAL DEL EMPLEADO
function PonderarEvaluaciones($connect_valoracion, $promedios){
    
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
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."'  ".$fill." ");
    $dataValidate = mysqli_fetch_array($queryValidate);
    
    $queryTipo = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Lista WHERE id = '".$dataValidate["id_tipo_competencia"]."' ");
    $dataTipo = mysqli_fetch_array($queryTipo);
    
   
    $autoP = ( $promedios["auto"]*$dataValidate["auto"] )/100; 
    $jefeP = ( $promedios["jefe"]*$dataValidate["jefe"] )/100; 
    $parP = ( $promedios["par"]*$dataValidate["par"] )/100; 
    $colaP = ( $promedios["colaborador"]*$dataValidate["subalterno"] )/100; 
    $clienteP = ( $promedios["cliente"]*$dataValidate["cliente"] )/100; 
    
    $total_promedio = $autoP+$jefeP+$parP+$colaP+$clienteP;
     /*  
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
        "total_"=>$total_promedio, 
        "nombre"=>$dataTipo["nombre"], 
        "comentarios_competencias"=> $promedios["comentarios_competencias"], 
        "comentarios_evaluaciones"=> $promedios["comentarios_evaluaciones"]
    );
    */


    return $total_promedio;

}












?>