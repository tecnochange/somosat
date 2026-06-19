<?php
//PARA OBTENER EL PROMEDIO GENERAL DEL EVALUADO PROMEDIANDO LOS EVALUADORES Y LA PONDERACIÓN.
function PromedioGeneralEvaluado($id_empleado, $connect_valoracion, $connect_valentina){

    $permitir = true;
    $no_evaluaciones = 0;
    $array_tipos = array();
    $id_cargo = 0;
    
    //CONSULTAMOS LOS EVALUADORES DE ESTE EMPLEADO
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' AND anio = '".$_SESSION['anio']."' AND id_empleado = '".$id_empleado."' ");
	while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
        
        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE 
        id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND
        id_evaluado = '".$id_empleado."' AND  id_evaluador = '".$dataEvaluadores['id_evaluador']."' AND 
        id_ciclo = '".$_SESSION['ciclo']."' AND tipo_evaluacion = '".$dataEvaluadores["tipo"]."' AND 
        estado = 2 ");
        $dataEval = mysqli_fetch_array($queryEval);
        if($dataEval["id_cargo"]){
            $id_cargo = $dataEval["id_cargo"];
        }
        
        array_push( $array_tipos , array( 
            "tipo"=> $dataEval["tipo_evaluacion"], 
            "promedio" => $dataEval["promedio"], 
            "id_evaluador" => $dataEvaluadores['id_evaluador'] 
        ));
        
        if($queryEval->num_rows == 0){
            $permitir = false;   
        }
        if($queryEval->num_rows > 0){
            $no_evaluaciones++;
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
    foreach($array_tipos as $tipo){
        if($tipo["tipo"] == 1){ //AUTO
            $auto += $tipo["promedio"];
            $auto_cant++ ;
        }
        if($tipo["tipo"] == 2){ //PAR
            $par += $tipo["promedio"];
            $par_cant++ ;
        }
        if($tipo["tipo"] == 3){ //COLABORADOR
            $colaborador += $tipo["promedio"];
            $colaborador_cant++ ;
        }
        if($tipo["tipo"] == 4){ //CLIENTE
            $cliente += $tipo["promedio"];
            $cliente_cant++ ;
        }
        if($tipo["tipo"] == 5){ //JEFE
            $jefe += $tipo["promedio"];
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
    
    //AQUI PREPARAMOS LA SENTENCIA PARA VALIDAR EL TIPO DE EVALUACION
    //AQUI PREPARAMOS LA SENTENCIA PARA VALIDAR EL TIPO DE EVALUACION
    //AQUI PREPARAMOS LA SENTENCIA PARA VALIDAR EL TIPO DE EVALUACION
    $fill = "";
    
    if( $promedio_auto > 0){ $fill .= " AND auto != '' "; }
    else{ $fill .= " AND auto = '' "; }
    
    if( $promedio_par > 0){ $fill .= " AND par != '' "; }
    else{ $fill .= " AND par = '' "; }
    
    if( $promedio_colaborador > 0){ $fill .= " AND subalterno != '' "; }
    else{ $fill .= " AND subalterno = '' "; }
    
    if( $promedio_cliente > 0){ $fill .= " AND cliente != '' "; }
    else{ $fill .= " AND cliente = '' "; }
    
    if( $promedio_jefe > 0){ $fill .= " AND jefe != '' "; }
    else{ $fill .= " AND jefe = '' "; }
    
    $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."'  ".$fill." ");
    $dataValidate = mysqli_fetch_array($queryValidate);
    
    $queryTipoPonderacion = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Lista WHERE id = '".$dataValidate["id_tipo_competencia"]."' ");
    $dataTipoPonderacion = mysqli_fetch_array($queryTipoPonderacion);
    
    $autoP = ( $promedio_auto*$dataValidate["auto"] )/100; 
    $jefeP = ( $promedio_jefe*$dataValidate["jefe"] )/100; 
    $parP = ( $promedio_par*$dataValidate["par"] )/100; 
    $colaP = ( $promedio_colaborador*$dataValidate["subalterno"] )/100; 
    $clienteP = ( $promedio_jefe*$dataValidate["cliente"] )/100; 
    
    $total_promedio = $autoP+$jefeP+$parP+$colaP+$clienteP;

    return array(
        "permitir"=> $permitir,
        "tipo_ponderacion" => $dataTipoPonderacion["nombre"], 
        "promedio" => $total_promedio, 
        "no_evaluadores" => $queryEvaluadores->num_rows, 
        "no_evaluadores_evaluacion" => $no_evaluaciones, 
        "id_cargo" => $id_cargo, 
        "arreglos" => $array_tipos
    );
    
}


//PARA OBTENER EL PROMEDIO GENERAL DEL EVALUADO PROMEDIANDO LOS EVALUADORES Y LA PONDERACIÓN.
function PromedioGeneralEvaluadoCiclo($id_empleado, $id_ciclo, $connect_valoracion, $connect_valentina){

    $permitir = true;
    $no_evaluaciones = 0;
    $array_tipos = array();
    $id_cargo = 0;
    
    //CONSULTAMOS LOS EVALUADORES DE ESTE EMPLEADO
    $queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$id_ciclo."' AND anio = '".$_SESSION['anio']."' AND id_empleado = '".$id_empleado."' ");
	while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
        
        $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones_New WHERE 
        id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND
        id_evaluado = '".$id_empleado."' AND  id_evaluador = '".$dataEvaluadores['id_evaluador']."' AND 
        id_ciclo = '".$id_ciclo."' AND tipo_evaluacion = '".$dataEvaluadores["tipo"]."' AND 
        estado = 2 ");
        $dataEval = mysqli_fetch_array($queryEval);
        $id_cargo = $dataEval["id_cargo"];
        
        array_push( $array_tipos , array( 
            "tipo"=> $dataEval["tipo_evaluacion"], 
            "promedio" => $dataEval["promedio"] ) 
        );
        
        if($queryEval->num_rows == 0){
            $permitir = false;   
        }
        if($queryEval->num_rows > 0){
            $no_evaluaciones++;
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
    foreach($array_tipos as $tipo){
        if($tipo["tipo"] == 1){ //AUTO
            $auto += $tipo["promedio"];
            $auto_cant++ ;
        }
        if($tipo["tipo"] == 2){ //PAR
            $par += $tipo["promedio"];
            $par_cant++ ;
        }
        if($tipo["tipo"] == 3){ //COLABORADOR
            $colaborador += $tipo["promedio"];
            $colaborador_cant++ ;
        }
        if($tipo["tipo"] == 4){ //CLIENTE
            $cliente += $tipo["promedio"];
            $cliente_cant++ ;
        }
        if($tipo["tipo"] == 5){ //JEFE
            $jefe += $tipo["promedio"];
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
    
    //AQUI PREPARAMOS LA SENTENCIA PARA VALIDAR EL TIPO DE EVALUACION
    //AQUI PREPARAMOS LA SENTENCIA PARA VALIDAR EL TIPO DE EVALUACION
    //AQUI PREPARAMOS LA SENTENCIA PARA VALIDAR EL TIPO DE EVALUACION
    $fill = "";
    
    if( $promedio_auto > 0){ $fill .= " AND auto != '' "; }
    else{ $fill .= " AND auto = '' "; }
    
    if( $promedio_par > 0){ $fill .= " AND par != '' "; }
    else{ $fill .= " AND par = '' "; }
    
    if( $promedio_colaborador > 0){ $fill .= " AND subalterno != '' "; }
    else{ $fill .= " AND subalterno = '' "; }
    
    if( $promedio_cliente > 0){ $fill .= " AND cliente != '' "; }
    else{ $fill .= " AND cliente = '' "; }
    
    if( $promedio_jefe > 0){ $fill .= " AND jefe != '' "; }
    else{ $fill .= " AND jefe = '' "; }
    
    $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND anio = '".$_SESSION['anio']."'  ".$fill." ");
    $dataValidate = mysqli_fetch_array($queryValidate);
    
    $queryTipoPonderacion = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Lista WHERE id = '".$dataValidate["id_tipo_competencia"]."' ");
    $dataTipoPonderacion = mysqli_fetch_array($queryTipoPonderacion);
    
    $autoP = ( $promedio_auto*$dataValidate["auto"] )/100; 
    $jefeP = ( $promedio_jefe*$dataValidate["jefe"] )/100; 
    $parP = ( $promedio_par*$dataValidate["par"] )/100; 
    $colaP = ( $promedio_colaborador*$dataValidate["subalterno"] )/100; 
    $clienteP = ( $promedio_jefe*$dataValidate["cliente"] )/100; 
    
    $total_promedio = $autoP+$jefeP+$parP+$colaP+$clienteP;

    return array(
        "permitir"=> $permitir,
        "tipo_ponderacion" => $dataTipoPonderacion["nombre"], 
        "promedio" => $total_promedio, 
        "no_evaluadores" => $queryEvaluadores->num_rows, 
        "no_evaluadores_evaluacion" => $no_evaluaciones, 
        "id_cargo" => $id_cargo
    );
    
}


























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
                "tipo"=>$dataEval["tipo_evaluacion"], 
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

    // EN CASO DE NO TENER EVALUADORES
    if($no_evaluadores == 0){ 
        $permitir = false;  
    }

    $PROMEDIO_GENERAL = PonderarEvaluaciones($connect_valoracion, $promedios_evaluador_general);
    
  
    return array(
        "permitir" => $permitir, 
        "no_evaluadores" => $no_evaluadores, 
        "promedio_general" => $PROMEDIO_GENERAL, 
        "dato_evaluadores" => $promedios_evaluaciones
    );
  
}




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
    return $total_promedio;
}

?>