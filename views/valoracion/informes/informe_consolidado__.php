<?php
	$hoy = date("Y-m-d H:i:s");
    $evaludo = $_GET["e"];

    //EVALUADO
    $queryEvaluado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$evaludo."'");
    $dataEva = mysqli_fetch_array($queryEvaluado);
    
    //CARGO
    $queryCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$dataEva["id_cargo"]."' ");  
    $dataCargo = mysqli_fetch_array($queryCargo);

    //CONSULTAMOS EL DATO DEL EVALUADOR
    $queryEvaluacion = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Evaluaciones WHERE id = '".$evaludo."'");
    $dataEvaluacion = mysqli_fetch_array($queryEvaluacion);
    $tipo_evaluador = $dataEvaluacion["tipo"];

    $perfiles = explode("," , $dataCargo["perfil"] );
            
    $tipo_list = '';
    $competencia_list = '';
    $nivel_list = '';
    foreach($perfiles as $prf){
                
        $queryNivel = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Niveles WHERE id = '".$prf."' ");
        $dataNivel = mysqli_fetch_array($queryNivel);
                
        $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataNivel["id_competencia"]."' ");
        $dataComp = mysqli_fetch_array($queryComp);
                    
        $text_nivel = '';
        foreach ($arrayNiveles as &$nivel) {
            if( $dataNivel["id_nivel"] == $nivel["0"] ){ $text_nivel = $nivel["1"]; }
        }
       
        $text_tipo = '';
        foreach ($arrayTipos as &$tipo) {
            if( $dataComp["id_tipo"] == $tipo["0"] ){ $text_tipo = $tipo["1"]; }
        }
                
                
        $nivel_list .= $text_nivel."<br>";
        $competencia_list .= $dataComp["nombre"]."<br>";
        $tipo_list .= $text_tipo."<br>";
    }
?>

<?php include("views/layouts/ficha_competencia.php"); ?>
<?php echo $respuesta; ?>

<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <table width="100%">
                <tr>
                    <td>
                        <h2>Reporte Consolidado</h2>
                    </td>
                    <td align="right"> 
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<ul class="nav nav-tabs">  
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/estadisticas">Estadísticas</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active " href="?pg=valoracion/informes/individuales">Individuales</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/areas">Area / Procesos</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/niveles">Niveles</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?pg=valoracion/informes/organizacion">Organización</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="?pg=valoracion/informes/numericos">Numéricos</a>
    </li>
</ul>

<!-- FICHA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div class="row">
            <div class="col-md-12" align="left">
                Colaborador Evaluado: <b><?php echo $dataEva["nombre"]." ".$dataEva["apellidos"]; ?></b> <br>
                Ciclo: <b><?php echo $dataEvaluador["nombre"]." ".$dataEvaluador["apellidos"]; ?></b> <br>
                Cargo: <b><?php echo $dataCargo["nombre"]; ?></b> <br>
            </div>
        </div>
        
    </div>
</div>

<!-- ESCALA -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <div><b>ESCALA DE VALORACION A UTILIZAR</b></div>
        <div style="margin-bottom: 15px">
            Para valorar cada uno de los comportamientos de las competencias utilice la siguiente escala; léala detenidamente antes de comenzar la valoración.
        </div>
        <?php
            $queryEscala = mysqli_query($connect_valoracion,"SELECT * FROM Escalas WHERE id_empresa = '".$dtEmpresa["id"]."' ");
	        $dataEscala = mysqli_fetch_array($queryEscala);
        ?>
        <table width="100%">
            <tr>
                <td width="25%" bgcolor="#FF7173" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    1
                </td>
                <td width="25%" bgcolor=" #FFC03A" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    2
                </td>
                <td width="25%" bgcolor=" #2ADAFF" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    3
                </td>
                <td width="25%" bgcolor=" #B5FF87" align="center" style="font-size: 20px; padding: 5px; font-weight: bold">
                    4
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" >
                    <b><?php echo $dataEscala["nombre_n_1"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_1"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_2"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_2"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_3"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_3"]; ?>
                </td>
                <td align="center" valign="top">
                    <b><?php echo $dataEscala["nombre_n_4"]; ?></b><br>
                    <?php echo $dataEscala["descripcion_n_4"]; ?>
                </td>
            </tr>
        </table> 
    </div>
</div>
















<?php
    include("views/valoracion/informes/metodo_ponderacion.php");

    //VARIABLES
    $lista_competencias = '';
            
    //OBTENEMOS LOS COMPETENCIAS
    //OBTENEMOS LOS COMPETENCIAS
    //OBTENEMOS LOS COMPETENCIAS
    $queryCompetencias = mysqli_query($connect_valoracion,"SELECT * FROM Competencias_Respuestas WHERE id_evaluado = '".$evaludo."' GROUP BY id_competencia ");
    while($dataCompetencias = mysqli_fetch_array($queryCompetencias)){

        //NOMBRE DE LA COMPETENCIA
        $queryComp = mysqli_query($connect_valoracion,"SELECT * FROM Competencias WHERE id = '".$dataCompetencias["id_competencia"]."' ");
        $dataComp = mysqli_fetch_array($queryComp);
                
        $total_cal = 0;
        $cant_resp = 0;

        $ponderacion_empleado = PonderacionNumericaEmpleadoCompetencia( $connect_valoracion, $connect_valentina, $evaludo, $dataCompetencias["id_competencia"]  );
        $promedio = $ponderacion_empleado["datos"]["total"];
        
        $color = '';
        if( $promedio >= 0 && $promedio < 1.7 ){ $color = "#FF7173" ; }
        if( $promedio >= 1.7 && $promedio < 2.7 ){ $color = "#FFC03A" ; }
        if( $promedio >= 2.7 && $promedio < 3.6 ){ $color = "#2ADAFF" ; }
        if( $promedio >= 3.6 && $promedio < 4 ){ $color = "#B5FF87" ; }
 
        $porcentaje = ($promedio * 100) / 4;
        
?>
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="left">
        <div>Competencia: <b><?php echo $dataComp["nombre"]; ?></b></div>
        <div>Promedio: <?php echo round($ponderacion_empleado["datos"]["total"] , 2); ?></div>
        <div style="width: 100%; background-color: #E9E9E9">
            <div style="height: 20px; width: <?php echo $porcentaje; ?>%; background-color: <?php echo $color; ?>"></div>
        </div>
    </div>
</div>

<?php
    }
?>



<!-- Competencias -->
<!-- Competencias -->
<div class="card" style="margin-bottom: 15px">
    <div class="card-body" align="center">
        
        <h3>OBSERVACIONES Y COMENTARIOS FINALES</h3>
        <p>Escriba aquí sus sugerencias, recomendaciones o ejemplos concretos que le permitirán a la persona evaluada mejorar en sus comportamientos</p>

        
        <div style="margin: 10px">(Escribir en este campo es obligatorio para poder terminar la evaluación/valoración)</div>
        <textarea class="form-control" name="observaciones_finales" rows="8" required><?php echo $dataEvaluacion["observaciones"]; ?></textarea>
        
        
        
    </div>
</div>
</form>









<script>
    $("#bt_val_seguimiento").addClass("active_item");
    
    $("#valoracion_menu").addClass("active");
    $('#valoracion_menu .collapse').collapse();
</script>

<script>
    function SelectCheck(elem, id){
        
        estado = $(elem).prop('checked') ;
        //if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $(".comp_"+id).prop('checked',false);
            $(elem).prop('checked',true);
            
            $(".comp_"+id).prop('required',false);
        //}
        /*
        else{
            $(".comp_"+id).prop('checked',false);
            $(".comp_"+id).prop('required',false);
        }*/
    }
    
    
    function Activar_Terminar_Eval(elem){
        estado = $(elem).prop('checked') ;
        
        if(estado == true){
            //$(".comp_"+id).removeAttr('checked');
            //$(".comp_"+id).prop('disabled', !this.checked);
            //event.preventDefault();
            $("#bt_terminar_evaluacion").prop('disabled',false);
            $(elem).prop('checked',true);
        }
        else{
            $("#bt_terminar_evaluacion").prop('disabled',true);
            $(".comp_"+id).prop('checked',false);
        }
        
        
    }
</script>

<style>
.checkbox_list{
	width: 18px;
    height: 18px;
    margin-left: 8px;
}
    
    
</style>

