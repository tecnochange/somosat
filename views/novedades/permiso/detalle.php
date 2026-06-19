<?php
include("../../modal.php");
include("../../../mail/permiso_notificacion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<script>
    $(document).ready(function() {
        $("#novedades_menu").addClass("active");
        $("#desplegable_novedades").show();
        $("#bt_novedades_permisos").addClass("active_item");
    });

    $("#exampleModalCenter").show;
    function cerrarmodal(){
        if(document.getElementById("boton_modal").click){
            window.location = "?pg=novedades/permisos";
        }
    }
</script>

<?php
$id = $_GET["id"];
$hoy = date("Y-m-d H:i:s");
$respuesta = "";
$fecha_inicio1 = date("Y-m-d", strtotime($_POST["fecha_inicio"]));
$fecha_fin = date("Y-m-d", strtotime($_POST["fecha_fin"]));

//OBTENER NOMBRE E ID RESPONSABLE (JEFE INMEDIATO)
$jefeInmediato = mysqli_query($connect_valentina,"SELECT id_dep_jerarquica FROM Posiciones WHERE id='".$user_log['id_posicion']."'");
while ($data = mysqli_fetch_array($jefeInmediato)) {
    $pos_jefeInmediato = $data['id_dep_jerarquica'];
    $idjefeInmediato = mysqli_query($connect_valentina,"SELECT documento FROM Posiciones WHERE id='".$pos_jefeInmediato."'");
    while ($data2 = mysqli_fetch_array($idjefeInmediato)) {
        $id_jefeInmediato = $data2['documento'];   
        $idjefeInmediato2 = mysqli_query($connect_valentina,"SELECT nombre, nombre_2, apellidos, apellidos_2 FROM Empleados WHERE documento='".$id_jefeInmediato."'");
        while ($data3 = mysqli_fetch_array($idjefeInmediato2)) {
             $nombre_jefeInmediato = $data3['nombre'].' '.$data3['nombre_2'].' '.$data3['apellidos'].' '.$data3['apellidos_2'];   
        }
    }
}

//PARA CREAR O EDITAR UN NUEVO REGISTRO


    if ($_POST["id"] != "") {
		$sentencia = "UPDATE Permisos SET id_empleado='". $_SESSION['id_user_valentina']." ',id_responsable=780',tipo='" . $_POST["tipo"] . "', fecha_inicia='" . $_POST["fecha_inicia"] . "',fecha_fin='" . $_POST["fecha_fin"] . "',hora_inicia='" . $_POST["hora_inicia"] . "',hora_fin='" . $_POST["hora_fin"] . "',motivos='" . $_POST["motivos"] . "',soporte='',observaciones='',estado=1,pariente_luto='" . $_POST["pariente_luto"] . "',created_at='$hoy'".  "' WHERE id =" . $_POST["id_registro"] . "";
        mysqli_query($connect_nomina, $sentencia);
        
		
		//mysqli_query($connect_nomina, );
		//include("app/controllers/subir_documento.php");
		//$archivo=Cargar_Archivos_Multiples_Permisos($_FILES["soporte"], $_POST["id_registro"], 1, $hoy, $connect_nomina);

    } 
	else {
        $sentencia ="INSERT INTO Permisos(id_empleado, id_responsable, tipo, fecha_inicia, fecha_fin, hora_inicia, hora_fin, motivos, soporte, observaciones, estado, pariente_luto, created_at) 
        VALUES ( '" . $user_log["id_posicion"] . "', '".$pos_jefeInmediato."',  '" . $_POST["tipo"] . "', '" . $fecha_inicio1 . "', '" . $fecha_fin. "', '" . $_POST["hora_inicia"] . "', '" . $_POST["hora_fin"] . "', '" . $_POST["motivos"] . "', '', '', 1, '" . $_POST["pariente_luto"] . "','" . $hoy . "')";        
        mysqli_query($connect_nomina, $sentencia);
       echo $registro=mysqli_insert_id($connect_nomina);
       if($registro){
        echo '<script> 
        $("#modal_permisos").modal("show");
        $("#cont_modal_permisos").html("<p>Su Solicitud ha sido creada con el <b>radicado 00'.$registro.'</b></p>");
        //window.location = "?pg=novedades/vacaciones";
        </script>'; //para evitar reinsersion  

        if ($_FILES["archivo"]["name"]) {
            include("../../../app/controllers/subir_documento.php");

            foreach($_FILES["archivo"]['tmp_name'] as $key => $tmp_name)
            {
                echo "si";
                //Validamos que el archivo exista
                if($_FILES["archivo"]["name"][$key]) {
                    $filename = $_FILES["archivo"]["name"][$key]; //Obtenemos el nombre original del archivo
                    $source = $_FILES["archivo"]["tmp_name"][$key]; //Obtenemos un nombre temporal del archivo
                    $tipo = $_FILES["archivo"]["type"][$key]; //Obtenemos un nombre temporal del archivo
                    $fecha = $hoy;
                    $directorio = '/var/www/html/estilocontigo-seleccion.hr-suite.app/recursos/';
                    
                    //Validamos si la ruta de destino existe, en caso de no existir la creamos
                    if(!file_exists($directorio)){
                        mkdir($directorio, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
                    }
                    
                    $dir=opendir($directorio); //Abrimos el directorio de destino
                    $target_path = $directorio.'/'.$filename; //Indicamos la ruta de destino, así como el nombre del archivo
                    
                    //Movemos y validamos que el archivo se haya cargado correctamente
                    //El primer campo es el origen y el segundo el destino
                    if(move_uploaded_file($source, $target_path)) {	
                        echo "El archivo $filename se ha almacenado en forma exitosa.<br>";
                        } else {	
                        echo "Ha ocurrido un error, por favor inténtelo de nuevo.<br>";
                    }
                    closedir($dir); //Cerramos el directorio de destino
                }

                mysqli_query($connect_nomina,"INSERT INTO Multimedia_Documentos (id_publicacion, file, type, created_at) 
                VALUES (".$registro.", '".$filename."', '".$tipo."','".$fecha."' ) ");
                //print_r("INSERT INTO Multimedia_Documentos (id_publicacion, file, type, created_at) 
               //VALUES (".$registro.", '".$filename."', '".$tipo."','".$fecha."' ) ");
            }
            //$archivo = Cargar_Archivos_Multiples_Permisos($_FILES["soporte"]["name"], $registro, $_FILES["soporte"]["type"], $hoy, $connect_nomina);
//            print_r($sentencia);
            //mysqli_query($connect_nomina, "UPDATE Permisos SET soporte = '" . $archivo . "' WHERE id = '" . $registro . "' ");
            //print_r("UPDATE Permisos SET soporte = '" . $archivo . "' WHERE id = '" . $registro . "' ");
        }        
    };

       // echo '<script> window.location = "?pg=novedades/permisos";</script>'; //para evitar reinsercion  
    }


//INFORMACION DEL REGISTRO
$query = mysqli_query($connect_nomina, "SELECT * FROM Permisos WHERE id = '" . $id . "' ");
$data = mysqli_fetch_array($query);
		
$queryPosicion = mysqli_query($connect_valentina, "SELECT * FROM Posiciones WHERE id = '" . $user_log["id_posicion"] . "' ");
$dataPosision = mysqli_fetch_array($queryPosicion);

$queryPosicionJefe = mysqli_query($connect_valentina, "SELECT * FROM Posiciones WHERE id = '" . $dataPosision["id_dep_jerarquica"] . "' ");
$dataPosisionJefe = mysqli_fetch_array($queryPosicionJefe);
	
$queryJefe = mysqli_query($connect_valentina, "SELECT * FROM Empleados WHERE id_posicion = '" . $dataPosisionJefe["id"] . "' ");
$dataJefe = mysqli_fetch_array($queryJefe);

?>

<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3>Permisos</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=novedades/permisos">Permisos</a></li>
                    <li class="breadcrumb-item">Detalle</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<?php echo $respuesta; ?>

<div class="card">

    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-12">
                    <h2>Registro de solicitud de permiso</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                    <input type="hidden" name="padre" value="<?php echo $data["padre"]; ?>">

                    <div>
                        Fecha de solicitud: <b><?php echo date("Y-m-d"); ?></b><br>
                        De: <b><?php echo $user_log['nombre'] . " " . $user_log['nombre_2'] . " " . $user_log['apellidos'] . " " . $user_log['apellidos_2']; ?></b><br>
                        Cargo: <b><?php echo $user_log['cargo']; ?></b><br>
                    </div>

                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>Tipo de permiso</label>
                    <select class="form-control" name="tipo" id="tipo" onClick="tipoPermiso()" required>
                        <option value="">Selecciona...</option>
                        <?php
                        $queryListaPermisos = mysqli_query($connect_nomina, "SELECT * FROM Lista_Permisos");
                        while($dataListaPermisos=mysqli_fetch_array($queryListaPermisos)){
                            echo '<option value='.$dataListaPermisos['id'].'>'.$dataListaPermisos['nombre'].' </option>';
                        };
                        ?>
                    </select>
                </div>               

                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Recomendaciones</label>
                    <input  type="text" class="form-control" id="recomendaciones" name="recomendaciones" disabled>
                </div>
                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Fecha Inicial</label>
                    <input  class="form-control date" id="fecha_inicia" name="fecha_inicia" min="2020-01-01" max="2050-12-31"  onChange="definirHoraDia(),calculoDias()" required>
                </div>

                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Fecha Final</label>
                    <input  class="form-control date" id="fecha_fin" name="fecha_fin" min='2020-01-01' max='2050-12-31' onChange="DíasTomados()" required disabled="">
                </div>

                <div class="col-md-3" style="margin-bottom: 10px" style="display:none">
                    <label>Hora Inicial</label>
                    <input type="time" class="form-control" name="hora_inicia" id="hora_inicia" disabled="" min="08:00:00" max="18:00:00" onChange="calculoHoras()">
                </div>

                <div class="col-md-3" style="margin-bottom: 10px" style="display:none">
                    <label>Hora Final</label>
                    <input type="time" class="form-control" name="hora_fin" id="hora_fin"   disabled="" min="08:00:00" max="18:00:00" onChange="calculoHoras()">
                </div>

                <div class="col-md-3" style="margin-bottom: 10px">
                    <label>Tiempo total en días</label>
                    <div id="cont_dias"></div>
                </div>

                <div id="horas_laborales" style="display:none" class="col-md-3" style="margin-bottom: 10px" >
                    <label>Horas laborales</label>
                    <div id="cont_horas"></div>
                </div>
                    
                <div id="dia_completo" style="display:none" class="col-md-3" style="margin-bottom: 10px">
                    <label>Dia completo</label>
                    </br>
                    <input class="form-check-input" type="checkbox" value="" id="check_dia" onChange="diacompleto()">
                </div>
                </br>
                <div class="col-md-3" style="margin-bottom: 10px; display:none" id="luto_container">
                    <label>Pariente</label>
                    <select class="form-control" name="pariente_luto" id="pariente_luto">
                        <option value="">Selecciona...</option>
                        <?php
                        $queryListaPermisos = mysqli_query($connect_nomina, "SELECT * FROM Permisos");
                        foreach ($Array_Parientes_Luto as $tipo) {
                            if ($tipo[0] == $data["tipo"]) {
                                echo '<option value="' . $tipo[0] . '" selected>' . $tipo[1] . '</option>';
                            } else {
                                echo '<option value="' . $tipo[0] . '">' . $tipo[1] . '</option>';
                            }
                        };
                        ?>
                    </select>
                </div>

                <div class="col-md-12" style="margin-bottom: 10px" id="motivo_container">
                    <label>Motivos</label>
                    <textarea class="form-control" name="motivos"><?php echo $data["motivos"]; ?></textarea>
                </div>


                
                            

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Soporte - Cargue uno o varios documentos</label>
                    <input type="file" class="form-control" id="archivo[]" name="archivo[]" multiple >
					
                    <div>
                        <a href="<?php echo $recursos_hv . "/" . $data["soporte"]; ?>" target="_blank"><?php echo $data["soporte"]; ?></a>
                    </div>
                </div>


                <div class="col-md-12" style="margin-bottom: 10px" align="right">
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Radicar
                    </button>

                </div>
            </div>
        </form>
    </div>

</div>
<!-- Script para limitar festivos, sabados y domingos -->
<script>
    var fp=flatpickr(".date",{
        "minDate": "today",
        "dateFormat": "d-m-Y",
        "theme":"material_red",
        "disable": ["22-09-2022","01-01-2022", "10-01-2022", "01-03-2022", "14-04-2022","17-04-2022","01-05-2022","30-05-2022","20-06-2022","27-06-2022","04-07-2022","20-07-2022","07-08-2022","15-08-2022","17-10-2022","07-11-2022","14-11-2022","08-12-2022","25-12-2022","01-01-2023","09-01-2022","20-03-2022","06-04-2022","07-04-2022","01-05-2023","22-05-2023","06-12-2023","19-06-2023","03-07-2023","20-09-2023","07-08-2023","21-08-2023","16-10-2023","06-11-2023","13-11-2023","08-12-2023","25-12-2023",
        // "disable": ["2022-09-22","2022-01-01", "2022-01-10", "2022-03-21", "2022-04-14","2022-04-17","2022-05-01","2022-05-30","20-06-2022","2022-06-27","2022-07-04","2022-07-20","2022-08-07","2022-08-15","2022-10-17","2022-11-07","2022-11-14","2022-12-08","2022-12-25",
        function(date) {
            return (date.getDay() === 0 || date.getDay() === 6);  // disable weekends
        }],
        "months": {
        "shorthand": ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
        "longhand": ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    },
    });
</script>
<script>
    function calculoDias(){
        var fechaInicio = document.getElementById("fecha_inicia").value;
        var anio = fechaInicio.substring(6,10);
        var mes = fechaInicio.substring(3,5);
        var dia = fechaInicio.substring(0,2);
        fechaInicio1 = anio+'-'+mes+'-'+dia;
        fechaInicio1= Date.parse(fechaInicio1);
        var fechaInicial = new Date(fechaInicio1);
        numeroDia = fechaInicial.getDay();

        tipoPermiso = document.getElementById("tipo").value;

        if(tipoPermiso==1 || tipoPermiso==3 || tipoPermiso==4 || tipoPermiso ==5 || tipoPermiso ==6 || tipoPermiso == 7 || tipoPermiso ==8 || tipoPermiso==9 || tipoPermiso==11 || tipoPermiso==12) {
            //Licencia Electoral -  Cita Médica -- Dia Estilo -- Dia jurado-- Dia de la familia -- Permiso no remunerado
            diasPermiso =1;
        }
        else if(tipoPermiso==2){//Matrimonio
            diasPermiso =3;
        }
        else if(tipoPermiso==10){//Luto -- Calamidad Doméstica
            diasPermiso = 5;
        }
        

        


        let disableDates = [];
        count = 0;
        diacomprobar = fechaInicio1+259200000;
                
        var disableDates2 = ["2022-09-22","2022-01-01", "2022-01-10", "2022-03-21", "2022-04-14","2022-04-17","2022-05-01","2022-05-30","20-06-2022","2022-06-27","2022-07-04","2022-07-20","2022-08-07","2022-08-15","2022-10-17","2022-11-07","2022-11-14","2022-12-08","2022-12-25"];
        
        for (i = 0; i <= disableDates2.length-1; i++) {
            disableDates[i] = (new Date(disableDates2[i])).getTime();
        }
        console.log("dias");
        for (i = 1; i <= diasPermiso; i++) {
            for (j = 0; j <= disableDates.length - 1; j++) {
                if (diacomprobar == disableDates[j]) {
                    count++;                    
                }                
            }               

            diacomprobar = diacomprobar+86400000;
            
        }
        var festivos=count;          

        if(numeroDia==4 && diasPermiso>1)//Viernes
        {
            fechaFinal = fechaInicio1 + (86400000)*5+(86400000)*festivos+18000;
        }
        else if(numeroDia==3 && diasPermiso>1)//Jueves
        {
            fechaFinal = fechaInicio1 + (86400000)*5+(86400000)*festivos+18000;
        }        
        else
        {
            fechaFinal = fechaInicio1 + (86400000)*diasPermiso+(86400000)*festivos+18000;
        }
        var fechaFinal1 = new Date(fechaFinal);
        anio2 = fechaFinal1.getFullYear();
        mes2 = fechaFinal1.getMonth()+1;
        dia2 = fechaFinal1.getDate();
        fechaFinal1 = dia2+'-'+mes2+'-'+anio2;
        document.getElementById("fecha_fin").value=fechaFinal1;


        console.log(fechaInicio1);        
        console.log(fechaFinal);
    }
</script>
<script>
    function calculoHoras(){ //17100 son 4 horas y 45 minutos (4.75 Horas)
        var horaInicial=document.getElementById("hora_inicia").value;             
        var horaInicial1=parseInt(horaInicial.substring(0,2));       
        var minutoInicial=parseFloat(horaInicial.substring(5,3));
        var seleccion = document.getElementById("tipo").value


        var diffHoras=0;
        if(horaInicial1<12 && horaInicial1>8 ){
            var horaFinal = horaInicial1+5;        
        }
        else{
            var horaFinal = horaInicial1+4;
        }
        if(seleccion=="1"){
        var minutosFinal = minutoInicial+45;
        $("#cont_horas").html("4.75 Horas");
        }
        else{
            minutosFinal=minutoInicial;
            $("#cont_horas").html("4 Horas");
        }
        if(minutosFinal>60){
            var minutosExtra = minutosFinal-60;
            horaFinal=horaFinal+1;
            minutosFinal=minutosExtra;           
        }
        if(minutosFinal<10){
            minutosFinal = "0"+minutosFinal;
        }

    var res1= String(horaFinal);
    var res2= String(minutosFinal);
       var result=String(res1+":"+res2);
       document.getElementById("hora_fin").value = horaFinal+":"+minutosFinal;
       console.log(horaFinal+":"+minutosFinal);       
       document.getElementById("horas_laborales").style.display="inline";
       
    }

    </script>
    <script>
        function definirHoraDia(){
            var seleccion = document.getElementById("tipo").value;
            if(seleccion==1 || seleccion==3 || seleccion==7 || seleccion==11){
                document.getElementById("fecha_fin").value = document.getElementById("fecha_inicia").value;
                document.getElementById("hora_inicia").style.display="inline";
                document.getElementById("hora_inicia").style.display="inline";
                document.getElementById("hora_inicia").disabled=false;
            }
        }
    </script>
    <script>
        function tipoPermiso(){
            document.getElementById("hora_fin").value="";
            document.getElementById("fecha_fin").value="";
            document.getElementById("hora_inicia").value="";
            document.getElementById("fecha_inicia").value="";
            $("#cont_horas").html("");
            $("#cont_dias").html("");

        //Condicionales segun seleccion de permiso
        if(document.getElementById("tipo").value=="1"){ //Permiso Electoral
            document.getElementById("recomendaciones").value="El máximo permitido para Licencia Electoral es 4.75 Horas";
            document.getElementById("hora_inicia").style.display="inline";
            document.getElementById("hora_fin").style.display="inline";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="none";
        }
        else if(document.getElementById("tipo").value=="2"){ //Permiso por Matrimonio
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso por Matrimonio es 3 días hábiles";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="none";

        }
        else if(document.getElementById("tipo").value=="3"){ //Permiso por Cita Médica
            document.getElementById("recomendaciones").value="El máximo permitido para Cita Médica es 4 Horas";
            document.getElementById("hora_inicia").style.display="inline";
            document.getElementById("hora_fin").style.display="inline";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="inline";

        }
        else if(document.getElementById("tipo").value=="4"){ //Permiso Día Estilo
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso Día Estilo es 1 día hábil";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="none";
        }
        else if(document.getElementById("tipo").value=="5"){ //Licencia por Jurado de Votación
            document.getElementById("recomendaciones").value="El máximo permitido para Licencia por Jurado de Votación es 1 día hábil";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="none";

        }
        else if(document.getElementById("tipo").value=="6"){ //Permiso Día de la Familia
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso por Día de la Familia es 1 día hábil";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";    
            document.getElementById("luto_container").style.display="none";        
            document.getElementById("motivo_container").style.display="none";
        }
        else if(document.getElementById("tipo").value=="7"){ //Permiso no remunerado(Horas)
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso no Remunerado es 4 Horas";
            document.getElementById("hora_inicia").style.display="inline";
            document.getElementById("hora_fin").style.display="inline";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="inline";

        }
        else if(document.getElementById("tipo").value=="8"){ //Licencia no remunerada(Días)
            document.getElementById("recomendaciones").value="El máximo permitido para Licencia no Remunerada es 1 día hábil";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";  
            document.getElementById("luto_container").style.display="none";          
            document.getElementById("motivo_container").style.display="inline";
        }
        else if(document.getElementById("tipo").value=="9"){ //Permiso por Grado
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso por Grado es 1 día hábil";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";  
            document.getElementById("luto_container").style.display="none";      
            document.getElementById("motivo_container").style.display="none";    
        }
        else if(document.getElementById("tipo").value=="10"){ //Permiso por Luto
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso por Luto es 5 días hábiles";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";
            document.getElementById("luto_container").style.display="inline";
            document.getElementById("motivo_container").style.display="none";

        }
        else if(document.getElementById("tipo").value=="11"){ //Calamidad Doméstica (H)
            document.getElementById("recomendaciones").value="Esta solicitud será aprobada por la Gerencia de Compensación y Nómina. Por favor adjuntar evidencia ";
            document.getElementById("hora_inicia").style.display="none";
            document.getElementById("hora_fin").style.display="none";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="inline";

        }
        else if(document.getElementById("tipo").value=="12"){ //Permiso por Cumpleaños
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso Cumpleaños es 1 día hábil";
            document.getElementById("hora_inicia").style.display="inline";
            document.getElementById("hora_fin").style.display="inline";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="none";
            document.getElementById("hora_inicia").disabled=false;
            document.getElementById("hora_fin").disabled=false;

        }
        else if(document.getElementById("tipo").value=="13"){ //Permiso Compensado
            document.getElementById("recomendaciones").value="El máximo permitido para Permiso Compensado es 4 Horas";
            document.getElementById("hora_inicia").style.display="inline";
            document.getElementById("hora_fin").style.display="inline";
            document.getElementById("luto_container").style.display="none";
            document.getElementById("motivo_container").style.display="inline";

        }
    };
    </script>
    <script>

    function diacompleto(){
        if(document.getElementById("tipo").value!="1" || document.getElementById("tipo").value=="3" || document.getElementById("tipo").value=="5" || document.getElementById("tipo").value=="7"){
            if(document.getElementById("check_dia").checked==true){
                document.getElementById("hora_inicia").disabled=false;
                document.getElementById("hora_fin").disabled=false;
                document.getElementById("hora_inicia").value="";
                document.getElementById("hora_fin").value="";
                document.getElementById("hora_inicia").style.display = "none";
                document.getElementById("hora_fin").style.display = "none";
                //DíasTomados();
                    $("#cont_dias").html("1");
            }
            else{
                document.getElementById("hora_inicia").disabled=false;
                document.getElementById("hora_fin").disabled=false;
                document.getElementById("hora_inicia").style.display = "inline";
                document.getElementById("hora_fin").style.display = "inline";    
                $("#cont_dias").html("0");
                calculoHoras();
            }
        }
        if(document.getElementById("check_day").value==true)
        {
            document.getElementById("hora_inicia").style.display = "none";
            document.getElementById("hora_fin").style.display = "none";
            document.getElementById("hora_inicia").value="";
            document.getElementById("hora_fin").value="";
        }
    }


    function DíasTomados() {
        if(document.getElementById("fecha_inicia").value==''){
            $("#cont_dias").html("Por favor ingrese una fecha de inicio");
            document.getElementById("fecha_fin").value="";
        }
        var fechaInicio = new Date($("#fecha_inicia").val()).getTime();
        var fechaFin = new Date($("#fecha_fin").val()).getTime();
        var nombreDia = new Date($("#fecha_inicia").val()).getDay();

        var diff = fechaFin - fechaInicio;
        dias_publicar = diff / (1000 * 60 * 60 * 24)+1;
        dias = diff / (1000 * 60 * 60 * 24);
        console.log(dias);

        //Sección para establecer días hábiles
        var count=0;
        nombreDia++; //Se añade para iniciar al siguiente día. Para el primer día se tienen en cuenta por diferencia de horas
        for(i=0;i<=dias-1;i++){
            if(nombreDia>6){
                nombreDia=0;
            }
            if(nombreDia>=0 && nombreDia<=4){
            count++;
            }
            nombreDia++;
        }
        horas_lab=count;
        dias_habiles=count+1; 
        console.log(dias_habiles);
      //  $("#cont_horas").html(horas_lab + " horas");
      if(dias_habiles==1){
            document.getElementById("check_dia").checked=true;
        }
      $("#cont_dias").html(dias_habiles + " día(s)");
        
      if(dias<0){
    $("#cont_dias").html("La fecha final no puede ser anterior a la fecha inicial");
    document.getElementById("fecha_inicia").value="";
    document.getElementById("fecha_fin").value="";}

        if(document.getElementById("tipo").value=="2"){ //Permiso por Matrimonio
            if(dias_habiles>3){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Permiso por Matrimonio");
            }
        }
            else if(document.getElementById("tipo").value=="4"){ //Dia Estilo
            if(dias_habiles>1){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Día Estilo");
            }
        }          
        else if(document.getElementById("tipo").value=="3"){ //Cita Médica
            $("#cont_dias").html("0");
            if(dias>0){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Cita Médica");

            }
        }        
        else if(document.getElementById("tipo").value=="1"){ //Electoral
            $("#cont_dias").html("0");
            document.getElementById("dia_completo").style.display = "none";
            if(dias>0){
                document.getElementById("dia_completo").style.display = "none";
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Licencia Electoral");
            }
        }               
        else if(document.getElementById("tipo").value=="5"){ //Jurado de Votación
            if(dias_habiles>1){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Jurado de Votación");
            }
        }    
        else if(document.getElementById("tipo").value=="6"){ //día de la familia
            if(dias_habiles>1){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Día de la Familia");
            }
        }                                
        else if(document.getElementById("tipo").value=="7"){ //Permiso Remunerado horas
            $("#cont_dias").html("0");
            document.getElementById("dia_completo").style.display = "none";
            if(dias>0){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Permiso No Remunerado (Horas)");
            }
        }          
        else if(document.getElementById("tipo").value=="8"){ //Licencia No Remunerada Días
            if(dias>1){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Licencia No Remunerada Días");
            }
        }          
        else if(document.getElementById("tipo").value=="9"){ //Permiso por Grado
            if(dias>1){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Permiso por Grado");
            }
        }          
        else if(document.getElementById("tipo").value=="10"){ //Licencia por Luto
            if(dias_habiles>5){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Licencia por Luto");
            }
        }          
        else if(document.getElementById("tipo").value=="11"){ //Calamidad Doméstica
            if(dias_habiles>5){
              /*  document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Calamidad Doméstica");*///---------------------Bajo Revisión---------------
            }
        }                                          
        else if(document.getElementById("tipo").value=="12"){ //Permiso por Cumpleaños
            $("#cont_dias").html("0");
            document.getElementById("dia_completo").style.display = "none";
            if(dias>0){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Permiso por Cumpleaños");
            }
        }          
        else if(document.getElementById("tipo").value=="13"){ //Permiso Compensado
            $("#cont_dias").html("0");
            document.getElementById("dia_completo").style.display = "none";
            if(dias>0){
                document.getElementById("fecha_fin").value="";
                document.getElementById("fecha_inicia").value="";
                $("#cont_dias").html("Rango no permitido en Permiso Compensado");
            }
        }                
        if(dias==0){
            document.getElementById("hora_inicia").disabled=false;
            document.getElementById("hora_fin").disabled=false;
            document.getElementById("hora_inicia").style.display = "inline";
            document.getElementById("hora_fin").style.display = "inline";
            document.getElementById("horas_laborales").style.display = "inline";
            if((document.getElementById("tipo").value =="1" || document.getElementById("tipo").value=="3")){
                document.getElementById("dia_completo").style.display = "none";}
            else{
                document.getElementById("dia_completo").style.display = "inline";
            }
        }
        else{
            document.getElementById("hora_inicia").disabled=false;
            document.getElementById("hora_fin").disabled=false;
            document.getElementById("hora_inicia").style.display = "none";
            document.getElementById("hora_fin").style.display = "none";
            document.getElementById("horas_laborales").style.display = "none";
            document.getElementById("dia_completo").style.display = "none";
        }                  

}



    



    var api = '<?php echo $url; ?>/estilocontigo.app/api/administrar/';

    function CargarNivelJerarquia(id) {
        /*
        $('#jerarquia').html('');
        jQuery.ajax({
            url: api+"cargar_niveles_jerarquia.php",
            type:'post',
            data: {id: id},
            }).done(function (resp){
                $("#jerarquia").html(resp);
            })
            .fail(function(resp) {
                console.log(resp);
            })
            .always(function(resp){
            }
        );
        */
    }

    var activar = false;

    function Elimimar_Area(id) {

        if (activar == false) {
            $("#modal_general").modal("show");
            $("#modal_body").html('Está a punto de eliminar un área, esta acción es irreversible ¿está seguro?<br><br>');
            $("#modal_body").append('<button type="button" class="btn btn-danger btn-sm" onclick="activar= true; Elimimar_Area(' + id + ')"> Confirmar </button>');
        } else {

            jQuery.ajax({
                    url: api + "eliminar_area.php",
                    type: 'post',
                    data: {
                        id: id,
                        url: "?pg=administrar/estructura"
                    },
                }).done(function(resp) {
                    $("#xscript").html(resp);
                })
                .fail(function(resp) {
                    console.log(resp);
                })
                .always(function(resp) {});

        }
    }
</script>
<script>
        function mostrarValidacion(e) {
            if (!e.target.reportValidity()) { //muestra validación
                e.target.value = '';
            }
        }

        //Asociar evento a todos los input dates
        var dateInputs = document.querySelectorAll('[type=date]');
        for (let inp of dateInputs) {
            inp.addEventListener('input', sinFeriados);
            inp.addEventListener('focusout', mostrarValidacion);
        }
    </script>
<script>
    $("#bt_adm_areas").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    $('#administrativo_menu').show();
</script>
