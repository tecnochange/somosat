<?php
function Skin(){	
//$skinArray = json_decode($_SESSION['skin']);
	$queryLogoEmpr = mysqli_query($connect,"SELECT * FROM Empresas WHERE id = '".$_SESSION['id_empresa']."' ");
	$dataLogoEmpr = mysqli_fetch_array($queryLogoEmpr);
	$skinArray = json_decode($dataLogoEmpr['skin']);
	
	$cfondo = $skinArray->fondo;
	$cfuente = $skinArray->fuente;
	$cmenu = $skinArray->menu;
	$citem = $skinArray->item;
	$cseparador = $skinArray->separador;
	$ctitulos = $skinArray->titulo;
}

	
function Format_Number($number){
    $val = number_format($number,2,".",",");
    return $val;
}
	
function Unit_Id($text, $arrayUM){
    $symbol_id = 0;
    foreach ($arrayUM as &$unidad) {
        if( strtoupper($text) == strtoupper($unidad[1]) ){ $symbol_id = $unidad[0]; }
    }
    return $symbol_id;
}

function ObjetivosArea($id_area, $connect_valentina, $connect_desempenio, $id_select){
    
    $lista_objetivos = '';
    
    $query1 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$id_area."' ");
    $data1 = mysqli_fetch_array($query1);
    
    //objetivos 
    $queryObj = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Area WHERE id_area = '".$data1["id"]."' ");
    while($dataObj = mysqli_fetch_array($queryObj)){
        if($id_select == $dataObj["id"]){ $lista_objetivos .= '<option value="'.$dataObj["id"].'" selected>'.$dataObj["objetivo_area"].'</option>'; }
        else{ $lista_objetivos .= '<option value="'.$dataObj["id"].'">'.$dataObj["objetivo_area"].'</option>'; }  
    }
    
    $query2 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data1["padre"]."' ");
    while($data2 = mysqli_fetch_array($query2)){
        
        
        //objetivos 1
        $queryObj1 = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Area WHERE id_area = '".$data2["id"]."' ");
        while($dataObj1 = mysqli_fetch_array($queryObj1)){
            if($id_select == $dataObj1["id"]){ $lista_objetivos .= '<option value="'.$dataObj1["id"].'" selected>'.$dataObj1["objetivo_area"].'</option>'; }
            else{ $lista_objetivos .= '<option value="'.$dataObj1["id"].'">'.$dataObj1["objetivo_area"].'</option>'; }  
        }
        
        
        $query3 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data2["padre"]."' ");
        while($data3 = mysqli_fetch_array($query3)){
            
            //objetivos 2
            $queryObj2 = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Area WHERE id_area = '".$data3["id"]."' ");
            while($dataObj2 = mysqli_fetch_array($queryObj2)){
                if($id_select == $dataObj2["id"]){ $lista_objetivos .= '<option value="'.$dataObj2["id"].'" selected>'.$dataObj2["objetivo_area"].'</option>'; }
                else{ $lista_objetivos .= '<option value="'.$dataObj2["id"].'">'.$dataObj2["objetivo_area"].'</option>'; }  
            }
            
            $query4 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data3["padre"]."' ");
            while($data4 = mysqli_fetch_array($query4)){
                
                //objetivos 3
                $queryObj3 = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Area WHERE id_area = '".$data4["id"]."' ");
                while($dataObj3 = mysqli_fetch_array($queryObj3)){
                    if($id_select == $dataObj3["id"]){ $lista_objetivos .= '<option value="'.$dataObj3["id"].'" selected>'.$dataObj3["objetivo_area"].'</option>'; }
                    else{ $lista_objetivos .= '<option value="'.$dataObj3["id"].'">'.$dataObj3["objetivo_area"].'</option>'; } 
                }

                $query5 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data4["padre"]."' ");
                while($data5 = mysqli_fetch_array($query5)){
                    
                    //objetivos 4
                    $queryObj4 = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Area WHERE id_area = '".$data5["id"]."' ");
                    while($dataObj4 = mysqli_fetch_array($queryObj4)){
                        if($id_select == $dataObj4["id"]){ $lista_objetivos .= '<option value="'.$dataObj4["id"].'" selected>'.$dataObj4["objetivo_area"].'</option>'; }
                        else{ $lista_objetivos .= '<option value="'.$dataObj4["id"].'">'.$dataObj4["objetivo_area"].'</option>'; } 
                    }

                    $query6 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data6["padre"]."' ");
                    while($data6 = mysqli_fetch_array($query6)){
                        
                        //objetivos 5
                        $queryObj5 = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Area WHERE id_area = '".$data6["id"]."' ");
                        while($dataObj5 = mysqli_fetch_array($queryObj5)){
                            if($id_select == $dataObj5["id"]){ $lista_objetivos .= '<option value="'.$dataObj5["id"].'" selected>'.$dataObj5["objetivo_area"].'</option>'; }
                            else{ $lista_objetivos .= '<option value="'.$dataObj5["id"].'">'.$dataObj5["objetivo_area"].'</option>'; } 
                        }
                        

                    }
                    
                }
                
            }
            
        }
        
    }
    
    return $lista_objetivos;
}
	

function TrazaArea($id_area){
    
    $query1 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$id_area."' ");
    $data1 = mysqli_fetch_array($query1);
    
    $query2 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data1["padre"]."' ");
    while($data2 = mysqli_fetch_array($query2)){
        
        
        $query3 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data2["padre"]."' ");
        while($data3 = mysqli_fetch_array($query3)){
            
            $query4 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data3["padre"]."' ");
            while($data4 = mysqli_fetch_array($query4)){

                $query5 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data4["padre"]."' ");
                while($data5 = mysqli_fetch_array($query5)){

                    $query6 = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data6["padre"]."' ");
                    while($data6 = mysqli_fetch_array($query6)){
                        

                    }
                    
                }
                
            }
            
        }
        
    }

}
	
?>

