<?php

    //CARGAMOS LOS EVALUADORES
	$arrayEvaluadores = array();
	$queryEvaluadores = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores 
    WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataEvaluadores = mysqli_fetch_array($queryEvaluadores)){
		array_push($arrayEvaluadores, $dataEvaluadores );
	}

    //CARGAMOS COMPETENCIAS EVALUACIONES
	$arrayCompetencias_Evaluaciones = array();
	$queryCompetencias_Evaluaciones = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id_empresa = '".$_SESSION['id_empresa']."' AND id_ciclo = '".$_SESSION['ciclo']."' ");
	while($dataCompetencias_Evaluaciones = mysqli_fetch_array($queryCompetencias_Evaluaciones)){
		array_push($arrayCompetencias_Evaluaciones, $dataCompetencias_Evaluaciones );
	}

    //CARGAMOS LOS EMPLEADOS
	$arrayEmpleados = array();
	$queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id_empresa = '".$_SESSION['id_empresa']."' AND estado = 1 AND role > 1 ");
	while($dataEmpleados = mysqli_fetch_array($queryEmpleados)){
		array_push($arrayEmpleados, $dataEmpleados );
	}

    //CARGAMOS CARGOS
	$arrayCargos = array();
	$queryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
	while($dataCargos = mysqli_fetch_array($queryCargos)){
		array_push($arrayCargos, $dataCargos );
	}

    //CARGAMOS AREAS
	$arrayAreas = array();
	$queryAreas = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id_empresa = '".$_SESSION['id_empresa']."' ");
	while($dataAreas = mysqli_fetch_array($queryAreas)){
		array_push($arrayAreas, $dataAreas );
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
    //PONDERACIÓN GENERAL DEL EMPLEADO
    function ObtenerPonderacion($connect_valoracion, $id_empresa, $promedios){

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

            $queryValidate = mysqli_query($connect_valoracion,"SELECT * FROM Ponderar_Evaluaciones WHERE id_empresa = '".$id_empresa."' AND id_ciclo = '".$_SESSION['ciclo']."' AND id_tipo_competencia = '".$data["id"]."' ");
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
        $poderacion = ObtenerPonderacion($connect_valoracion, $_SESSION['id_empresa'], $promedios_array);
        $resp = array(
            "datos"=>$poderacion,
            "tabla"=>$grupos_tipos,
            "completo"=>$completo
        );

        return $resp;

    }

?>
