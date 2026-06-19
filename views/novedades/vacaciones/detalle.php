<?php
include("../../modal.php");
include("../../../mail/vacaciones_notificacion.php");
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
        $("#bt_novedades_vacaciones").addClass("active_item");
    });

    $("#exampleModalCenter").show;
    function cerrarmodal(){
        if(document.getElementById("boton_modal").click){
            window.location = "?pg=novedades/vacaciones";
        }
    }
</script>

<?php
$user_log["role"];
$user_log["id_posicion"];
$id = $_GET["id"];
$hoy = date("Y-m-d H:i:s");
$fecha_inicio1 = date("Y-m-d", strtotime($_POST["fecha_inicio"]));
$fecha_fin = date("Y-m-d", strtotime($_POST["fecha_fin"]));
$fecha_regreso = date("Y-m-d", strtotime($_POST["fecha_regreso"]));

$respuesta = "";
//DEFINIR ID_ RESPONSABLE

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
if ($_POST["fecha_inicio"] != "") {
    if ($_POST["id_registro"] == "") {
        $sentencia = "INSERT INTO Vacaciones ( id_empleado , id_responsable ,  fecha_inicio ,  dias_disfrutados ,  dias_dinero ,  total_dias , fecha_fin, fecha_regreso ,   estado, observaciones ,  created_at ) 
        VALUES ( '" . $user_log["id_posicion"] . "', '$pos_jefeInmediato' , '" . $fecha_inicio1 . "', '" . $_POST["dias_disfrutados"] . "', '" . $_POST["dias_dinero"] . "', '" . $_POST["total_dias"] . "', 
        '".$fecha_fin. "','" . $fecha_regreso . "', 1, '' ,'" . $hoy . "')";
        mysqli_query($connect_nomina, $sentencia);        
        echo $registro=mysqli_insert_id($connect_nomina);
        echo '<script> 
        $("#modal_vacaciones").modal("show");
        $("#cont_modal_vacaciones").html("<p>La solicitud de sus vacaciones No. <b> 00'.$registro.'</b> ha sido enviada a su jefe inmediato para su aprobación</p>");
        </script>'; 
    }
}


//INFORMACION DEL REGISTRO
$query = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id = '" . $id . "' ");
$data = mysqli_fetch_array($query);


$query1 = mysqli_query($connect_nomina, "SELECT * FROM Vacaciones WHERE id = '" . $id . "' ");
while($data1 = mysqli_fetch_array($query1))
{
     $Empleado=$data1["id_empleado"];
     $Responsable=$data1["id_responsable"];
};
?>


<body onLoad="festivos1()">
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3>Vacaciones</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Estructura</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo $url; ?>?pg=novedades/vacaciones">Vacaciones</a></li>
                    <li class="breadcrumb-item">Detalles</li>
                </ol>
            </div>
        </div>
    </div>
</div>



<div class="card">

    <div class="card-body">
        <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h2>Registro solicitud de vacaciones</h2>
                    <input type="hidden" name="id_registro" value="<?php echo $id; ?>">

                    <div>
                        Fecha de solicitud: <b><?php echo date("Y-m-d"); ?></b><br>
                        De: <b><?php echo $user_log['nombre'] . " " . $user_log['nombre_2'] . " " . $user_log['apellidos'] . " " . $user_log['apellidos_2']; ?></b><br>
                        Cargo: <b><?php echo $user_log['cargo']; ?></b><br>
                    </div>

                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha Inicio</label>
                    <input   class="form-control date" name="fecha_inicio" id="fecha_inicio" min='2020-01-01' max='2050-12-31' value="<?php echo $data["fecha_inicio"]; ?>" onBlur="festivos1()" onChange="DíasTomados()"required>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha Fin</label>
                    <input   class="form-control date" name="fecha_fin" id="fecha_fin" min='2020-01-01' max='2050-12-31' value="<?php echo $data["fecha_fin"]; ?>" onBlur="festivos1()" onChange="DíasTomados(), Validar_Dias()"required>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Fecha Regreso de Vacaciones</label>
                    <input   class="form-control" name="fecha_regreso" id="fecha_regreso" min='2020-01-01' max='2050-12-31' value="<?php echo $data["fecha_regreso"]; ?>" onBlur="festivos1()" onChange="DíasTomados(),comprobarDiaRegreso()"required readonly pattern="\d{4}-\d{2}-\d{2}">
                </div>

                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Días disfrutados</label>
                    <input type="tel" maxlength="2"  max="45" class="form-control" name="dias_disfrutados" id="dias_disfrutados" value="<?php echo $data["dias_disfrutados"]; ?>"  required readonly>
                </div>

                <?php if($id_responsable!=$user_log["id"]){
                ?>
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Días en dinero</label>
                    <input type="tel" maxlength="2" max="45" class="form-control" name="dias_dinero" id="dias_dinero" value="<?php echo $data["dias_dinero"]; ?>" onChange="Validar_Dias()"   >
                </div>
                <?php
                }
                if($id_responsable==$user_log["id"]){
                ?>
                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Días en dinero</label>
                    <input type="tel" maxlength="2" max="45" class="form-control" name="dias_dinero" id="dias_dinero1" value="<?php echo $data["dias_dinero"]; ?>" onChange="Validar_Dias()"  >
                </div>
                <?php
                }
                ?>


                <div class="col-md-4" style="margin-bottom: 10px">
                    <label>Total de Días</label>
                    <input type="tel" maxlength="2" max="45" class="form-control" name="total_dias" id="total_dias" value="<?php echo $data["total_dias"]; ?>" readonly>
                </div>

                <div class="col-md-4" style="margin-bottom: 10px; display:none;">
                    <label>Dependencia de cruces con ausentismos y festivos</label>
                    <input type="number" class="form-control" name="festivos" id="festivos" readonly></input>
                </div>


                <div class="col-md-4" style="margin-bottom: 10px;display:none">
                    <label>Observaciones</label>
                    <input type="text"  class="form-control" name="observaciones" id="observaciones" value="<?php echo $data["observaciones"]; ?>"  required readonly>
                </div>
                <?php if($id_empleado!=$user_log["id"]){
                ?>
                <div class="col-md-12" style="margin-bottom: 10px" align="right">
                    <hr>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Radicar
                    </button>

                </div>
                <?php
                }
                ?>
                
            </div>
        </form>
    </div>

</div>
<!-- Script para limitar festivos, sabados y domingos -->
<script>
    var fp=flatpickr(".date",{
        "minDate": "today",
        "dateFormat": "d-m-Y",
        "enableTime":false,
        "theme":"material_red",
        "disable": ["22-09-2022","01-01-2022", "10-01-2022", "01-03-2022", "14-04-2022","17-04-2022","01-05-2022","30-05-2022","20-06-2022","27-06-2022","04-07-2022","20-07-2022","07-08-2022","15-08-2022","17-10-2022","07-11-2022","14-11-2022","08-12-2022","25-12-2022","01-01-2023","09-01-2022","20-03-2022","06-04-2022","07-04-2022","01-05-2023","22-05-2023","06-12-2023","19-06-2023","03-07-2023","20-09-2023","07-08-2023","21-08-2023","16-10-2023","06-11-2023","13-11-2023","08-12-2023","25-12-2023",
        //"disable": ["22-09-2022","01-01-2022", "2022-01-10", "2022-03-21", "2022-04-14","2022-04-17","2022-05-01","2022-05-30","20-06-2022","2022-06-27","2022-07-04","2022-07-20","2022-08-07","2022-08-15","2022-10-17","2022-11-07","2022-11-14","2022-12-08","2022-12-25","2023-01-01","2023-01-09","2023-03-20","2023-04-06","2022-04-07","2023-05-01","2023-05-22","2023-06-12","2023-06-19","2023-07-03","2023-07-20","2023-08-07","2023-08-21","2023-10-16","2023-11-06","2023-11-13","2023-12-08","2023-12-25",
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
    function festivos1() {
        
        var fechaFin = (new Date(document.getElementById("fecha_regreso").value)).getTime();
        let disableDates = [];
        count = 0;
        var diff = fechaFin - fechaInicio;
        dias = diff / (1000 * 60 * 60 * 24);
        var disableDates2 = ["22-09-2022","01-01-2022", "10-01-2022", "01-03-2022", "14-04-2022","17-04-2022","01-05-2022","30-05-2022","20-06-2022","27-06-2022","04-07-2022","20-07-2022","07-08-2022","15-08-2022","17-10-2022","07-11-2022","14-11-2022","08-12-2022","25-12-2022","01-01-2023","09-01-2022","20-03-2022","06-04-2022","07-04-2022","01-05-2023","22-05-2023","06-12-2023","19-06-2023","03-07-2023","20-09-2023","07-08-2023","21-08-2023","16-10-2023","06-11-2023","13-11-2023","08-12-2023","25-12-2023"];
        for (i = 0; i <= disableDates2.length - 1; i++) {
            disableDates[i] = (new Date(disableDates2[i])).getTime();
        }
        for (i = 1; i <= dias; i++) {
            for (j = 0; j <= disableDates.length - 1; j++) {
                if (fechaInicio == disableDates[j]) {
                    count++;
                }
            }
            fechaInicio = fechaInicio + 86400000;
        }
        $("#festivos").val(count);

        var festivos=count;
        return festivos;
        
    }
</script>
<script>
    function Validar_Dias() {
        if(document.getElementById("dias_dinero").value!=""){
            var resultados=parseInt(document.getElementById("dias_disfrutados").value) + parseInt(document.getElementById("dias_dinero").value);
        }
        else{
            var resultados=parseInt(document.getElementById("dias_disfrutados").value) ;
        }
        document.getElementById("total_dias").value=resultados;
        

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
    
    
        function DíasTomados() {
        var fi = document.getElementById("fecha_inicio").value;
        const [day, month, year] = fi.split('-');
        const result = [year, month, day].join('-');

        var fechaInicio = new Date(result).getTime();
        console.log(fechaInicio);

        var ff = document.getElementById("fecha_fin").value;
        const [day2, month2, year2] = ff.split('-');
        const result2 = [year2, month2, day2].join('-');

        var fechaFin = new Date(result2).getTime();
        console.log(fechaFin);        

        var nombreDia = new Date($("#fecha_inicio").val()).getDay();
        var nombreDiaf = new Date($("#fecha_fin").val()).getDay();

        if(nombreDiaf==4){
            var fechaRegreso = (fechaFin + ((1000 * 60 * 60 * 24)*3))+18000000; //18000000 es un offset para ajustar todas las horas a 00:00
        }
        else{
            var fechaRegreso = fechaFin + ((1000 * 60 * 60 * 24)*1+18000000);      
        }
        for(i=0;i<=feriados.length-1;i++){
            if(fechaRegreso==feriados[i]){
                var fechaRegreso = fechaRegreso + ((1000 * 60 * 60 * 24)*1);
            }            
            else{
            }
        }
        


        document.getElementById("fecha_regreso").value=(new Date(fechaRegreso)).toISOString().split('T')[0];


        var diff = fechaFin - fechaInicio;
        dias_publicar = diff / (1000 * 60 * 60 * 24)+1;
        dias = diff / (1000 * 60 * 60 * 24);

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

        document.getElementById("dias_disfrutados").value = count+1-festivos1(); 
        
        return dias;
        }
</script>
<script>
    var disableDates = ['01-01-2022', '10-01-2022', '21-03-2022', '14-04-2022', '17-04-2022', '01-05-2022', '30-05-2022', '20-06-2022', '27-06-2022', '04-07-2022', '20-07-2022', '07-08-2022', '15-08-2022', '17-10-2022', '07-11-2022', '14-11-2022', '08-12-2022', '25-12-2022', '01-01-2023','09-01-2023','20-03-2023','06-04-2023','07-04-2023','01-05-2023','22-05-2023','12-06-2023','19-06-2023','03-07-2023','20-07-2023','07-08-2023','16-10-2023','06-11-2023','13-11-2023','08-12-2023','25-12-2023'];
    const feriados = disableDates.map(f => new Date(+(f = f.split('-'))[2], +f[1] - 1, +f[0]).getTime());

    function sinFeriados(e) {
        let f = e.target.value.split('-'),
            elegido = new Date(+f[0], +f[1] - 1, +f[2]).getTime();

        if (feriados.includes(elegido)) {
            e.target.setCustomValidity('No se puede elegir un día festivo');
        } else {
            e.target.setCustomValidity('');
        }
    }

    function mostrarValidacion(e) {
        if (!e.target.reportValidity()) { 
            e.target.value = '';
        }
    }
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