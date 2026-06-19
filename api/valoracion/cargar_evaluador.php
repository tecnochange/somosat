<?php
	$hoy = date("Y-m-d H:i:s");
	$tipo = $_POST["tipo"];
    $id_user = $_POST["id"];
    $id_empresa = $_POST["id_empresa"];
    $ciclo = $_POST["ciclo"];

	
	include("../../app/models/connect.php");

    $array_empleados = array();

    //TIPO AUTO
    if($tipo == 1){
        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id_user."' AND id_empresa = '".$id_empresa."' AND role > 1 ORDER BY nombre ASC "); 
        while($dataJer = mysqli_fetch_array($queryJer)){
            array_push($array_empleados, array("id"=>$dataJer["id"], "nombre"=>$dataJer["nombre"], "apellidos"=>$dataJer["apellidos"] ) );
        }  
    }

    else if($tipo == 5){
        
        $queryJefes = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$id_user."' ");  
        while($dataEval = mysqli_fetch_array( $queryJefes )){
            
            $queryEmpl = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
            WHERE id = '".$dataEval["id_jefe"]."' AND id_empresa = '".$id_empresa."' AND role > 1 ORDER BY nombre ASC "); 
            $dataEmpl = mysqli_fetch_array($queryEmpl);
            
            array_push($array_empleados, array("id"=>$dataEmpl["id"], "nombre"=>$dataEmpl["nombre"], "apellidos"=>$dataEmpl["apellidos"] ) );
        }
        //$queryJer = mysqli_query($connect_valentina,"SELECT * FROM Jefes WHERE id_empleado = '".$id_user."' AND id_empresa = '".$id_empresa."' ORDER BY id ASC ");
        
    }

    else{
        $queryJer = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id != '".$id_user."' AND id_empresa = '".$id_empresa."' AND role > 1 ORDER BY nombre ASC ");
        while($dataJer = mysqli_fetch_array($queryJer)){
            array_push($array_empleados, array("id"=>$dataJer["id"], "nombre"=>$dataJer["nombre"], "apellidos"=>$dataJer["apellidos"] ) );
        }
    }

    $array_evaluadores = array();
    $queryEval = mysqli_query($connect_valoracion,"SELECT * FROM Evaluadores WHERE id_empleado = '".$id_user."' AND id_ciclo = '".$ciclo."' ");  
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
            echo '<option value="'.$empl["id"].'" selected>'.$empl["nombre"].' '.$empl["apellidos"].'</option>';
        }
        else{
            echo '<option value="'.$empl["id"].'">'.$empl["nombre"].' '.$empl["apellidos"].'</option>';
        }  
    }
    
}



   
?>



