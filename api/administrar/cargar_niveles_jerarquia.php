<?php
	$hoy = date("Y-m-d H:i:s");
	$id = $_POST["id"];

	
	include("../../app/models/connect.php");
    include("../../app/models/library.php");

    $queryArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$id."' "); 
    $dataArea = mysqli_fetch_array($queryArea);

    foreach($Array_Jerarquia as $nivel){
        if( $nivel[0] == ($dataArea["jerarquia"]+1) ){
             echo '<option value="'.$nivel[0].'">'.$nivel[1].'</option>';
        }
        
                            
    }




?>
