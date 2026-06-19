<?php
	$hoy = date("Y-m-d H:i:s");
	$tipo = $_POST["tipo"];
    $id_user = $_POST["id"];
    $id_empresa = $_POST["id_empresa"];
    $anio = $_POST["anio"];
    $ciclo = $_POST["ciclo"];

	
	include("../../app/models/connect.php");
	include("../../app/models/Collaborators.php");
	$ClassCollaborators = new Collaborators();
	$colaboradores = $ClassCollaborators->lista_colaboradores($connect_valentina, 1);




    $array_empleados = array();

    //TIPO AUTO
    if($tipo == 1){
		foreach($colaboradores as $colaborador){
			if($id_user == $colaborador["id"] ){
				array_push($array_empleados, array("id"=>$colaborador["id"], "nombre"=>$colaborador["nombre_completo"] ) );
			}
		}
    }

    else if($tipo == 5){
        
        $queryJefes = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$id_user."' ");  
        while($dataEval = mysqli_fetch_array( $queryJefes )){
			
			foreach($colaboradores as $colaborador){
				if($dataEval["id_jefe"] == $colaborador["id"] ){
					$dataEmpl = $colaborador;
				}
			}
            array_push($array_empleados, array("id"=>$dataEmpl["id"], "nombre"=>$dataEmpl["nombre_completo"]   ) );
        }
        //$queryJer = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$id_user."' AND id_empresa = '".$id_empresa."' ORDER BY id ASC ");
        
    }

    else{
		foreach($colaboradores as $colaborador){
			if($id_user != $colaborador["id"] ){
				array_push($array_empleados, array("id"=>$colaborador["id"], "nombre"=>$colaborador["nombre_completo"] ) );
			}
		}
    }

    $array_evaluadores = array();
    $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id_user."' AND id_ciclo = '".$ciclo."' AND anio = '".$anio."' ");  
    while($dataEval = mysqli_fetch_array($queryEval)){
        array_push($array_evaluadores, $dataEval["id_evaluador"] );
    }


?>


<option value="">Selecciona</option>
<?php
foreach($array_empleados as $empl){
    
    $permitir = true;
    
    foreach($array_evaluadores as $eval){
        if($eval == $empl["id"]){
            $permitir = false;
        }
    }
    
    if(  $permitir == true ){
        if($data["id_jefe"] == $empl["id"] ){
            echo '<option value="'.$empl["id"].'" selected>'.$empl["nombre"].' '.$empl["nombre_2"].' '.$empl["apellidos"].' '.$empl["apellidos_2"].'</option>';
        }
        else{
            echo '<option value="'.$empl["id"].'">'.$empl["nombre"].' '.$empl["nombre_2"].' '.$empl["apellidos"].' '.$empl["apellidos_2"].'</option>';
        }  
    }
    
}



   
?>



