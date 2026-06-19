<?php
    include("views/valoracion/informes/metodo_ponderacion.php");	
    $hoy = date("Y-m-d H:i:s");
?>

<style>
    .base_porcentajes{
        width: 100%; 
        background-color: #E9E9E9;    
    } 
    .barra_porcien{
        width: 86.5%; 
        background-color: #2ADAFF;     
        text-align: center;
        font-weight: bold; 
        padding: 5px;
    }
    .titulo_comp{
        font-size: 20px;
        font-weight: bold;
        text-align: left;
        margin-top: 30px;
    }
</style>


<table class="table">
    
    <tr>
        <td>#</td>
        <td>Evaluado</td>
        <td>Evaluador</td>
        <td>Ciclo</td>
        <td>Tipo</td>
        <td>Competencia</td>
        <td>id_evaluacion</td>
    </tr>

    <?php
    $count = 1;
    $queryRespuestas = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_empresa != 55 ");
    while($dRespuestas = mysqli_fetch_array($queryRespuestas)){
        
        $list_evaluaciones = '';
        $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE 
        id_ciclo = '".$dRespuestas["id_ciclo"]."'  AND
        id_empresa = '".$dRespuestas["id_empresa"]."' AND 
        id_evaluado = '".$dRespuestas["id_evaluado"]."' AND 
        id_evaluador = '".$dRespuestas["id_evaluador"]."' ");
        while($dataEvaluacion = mysqli_fetch_array($queryEvaluacion)){
            $list_evaluaciones .= $dataEvaluacion["id"].'<br>';
            //mysqli_query($connect_valoracion,"UPDATE Competencias_Respuestas SET id_evaluacion = '".$dataEvaluacion["id"]."'  WHERE id = '".$dRespuestas["id"]."' ");  
        }
        
        /*
        echo '
        <tr>
            <td>'.$count.'</td>
            <td>'.$dRespuestas["id_evaluado"].'</td>
            <td>'.$dRespuestas["id_evaluador"].'</td>
            <td>'.$dRespuestas["id_ciclo"].'</td>
            <td>'.$dRespuestas["id_competencia"].'</td>
            <td>'.$dRespuestas["tipo_evaluador"].'</td>
            <td>'.$list_evaluaciones.'</td>
        </tr>
        ';
        */
        $count++;
    }
    ?>
    
    <tr>
    
    </tr>
</table>




<script>
    $("#bt_val_seguimiento").addClass("active_item"); 
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

