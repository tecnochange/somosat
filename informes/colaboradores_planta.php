<?php
    session_start();
    //VALIDACION DE SESION
    if($_SESSION['id_user'] == ""){
        header('Location: log.php' );
    }

    include("../app/models/connect.php");
    include("../app/models/library.php");

    $hoy = date("Y-m-d H:i:s");

    include("../app/models/Collaborators.php");
    $ClassColaboradores = new Collaborators();

    $qryEmpleado = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION['id_user']."' ");
    $dtEmpleado = mysqli_fetch_array($qryEmpleado);

    $qryAdicionales = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION['id_colaborador_edit']."' ");
    $dtAdicionales = mysqli_fetch_array($qryAdicionales);

    $qryEditar = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Editar WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtEditar = mysqli_fetch_array($qryEditar);

    $qryPerfiles = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtPerfiles = mysqli_fetch_array($qryPerfiles);

    $qryPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtPreferencias = mysqli_fetch_array($qryPreferencias);

    $qryEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$_SESSION['id_user']."' ");
    $dtEmergencia = mysqli_fetch_array($qryEmergencia);
?>

<!DOCTYPE html>
<html>

<head>
    <!-- metas -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="HR Suite">

    <title>Somos AT - Innovando Juntos - Colaboradores Planta</title>
    
    <style>
        table{
            border-collapse: collapse;
            font-size: 10px;
            font-family: sans-serif;
        }
        .boton{
            background-color: #0364ba; 
            color: #ffffff;
            padding: 6px 20px;
            border: 0;
            border-radius: 7px;
        }
    </style>
    <script src="<?php echo $url; ?>/js/jquery-3.3.1.js"></script>
    
</head>

    
<!-- export-->
<form action="exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar"/>
</form>

<body>
    <div style="margin-bottom: 10px">
        <button type="button" class="boton" onclick="exportarReporte()">
            Exportar a Excel
        </button> 
    </div>

    <table border="1" id="tabla_reporte">
        <thead>
            <tr>
                <td colspan="49">
                    <h2>Somos AT - Informe de Planta: Colaboradores</h2>
                    <p>Fecha de generación: <?php echo date("Y-m-d H:i:s"); ?></p>
                </td>
            </tr>
            <tr>
                <th>#</th>
                <th>Documento</th>
                <th>Nombre Completo</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Nombre de Preferencia</th>
                <th>Apodo</th>
                <th>Fecha de Vencimiento Documento de Identidad</th>
                <th>Pasaporte</th>
                <th>Fecha de Vencimiento Pasaporte</th>
                <th>Credencial Cívica:</th>
                <th>Fecha de Nacimiento</th>
                <th>Edad</th>
                <th>Género</th>
                <th>Estado Civil</th>
                <th>Nacionalidad</th>
                <th>País Nacimiento</th>
                <th>Fecha Ingreso</th>
                <th>Código de Colaborador AT</th>
                <th>Mail Corporativo de AT</th>
                <th>Cargo</th>
                <th>Nivel Cargo</th>
                <th>Area</th>
                <th>Departamento</th>
                <th>Equipo</th>
                <th>Cliente</th>
                <th>Dirección de Cliente</th>
                <th>Correo de Outsourcing</th>
                <th>Horario del Servicio</th>
                <th>Independiente/Dependiente</th>
                <th>Razón Social</th>
                <th>Dirección Fiscal</th>
                <th>RUT</th>
                <th>Banco</th>
                <th>Tipo de Cuenta</th>
                <th>Número de Cuenta</th>
                <th>AFAP</th>
                <th>Caja Profesional</th>
                <th>Fecha de Vencimiento Caja Profesional</th>
                <th>Talle Remera</th>
                <th>Modelo</th>
                <th>Color</th>
                <th>Comentarios</th>
                <th>Pais Residencia</th>
                <th>Departamento Residencia</th>
                <th>Ciudad de Residencia</th>
                <th>Departamento Residencia</th>
                <th>Ciudad de Residencia</th>
                <th>Dirección de Residencia</th>
                <th>Código Postal</th>
                <th>Teléfono</th>
                <th>Celular</th>
                <th>E-mail Personal</th>
                
                <th>Prestador de Salud</th>
                <th>Emergencia Médica</th>
                <th>Teléfono de Emergencia Móvil</th>
                <th>Fecha de Vencimiento Carné de Salud</th>
                <th>Fecha de Vencimiento Aptitud Física</th>
                <th>Patologías de Base</th>
                <th>Si Tu Respuesta Anterior Fue Alergias u Otros, Por Favor Especifica a Que Cosas</th>
                <th>¿Usas Lentes?</th>
                <th>¿Usas Audífonos?</th>
                <th>Otros</th>
                <th>¿Qué Tipo de Alimentación Tiene?</th>
                <th>¿Tenes Alguna Restricción Con La Comida?</th>
                <th>¿Fumas?</th>
                <th>¿Practicas Algún Deporte?</th>
                <th>Si Practicas Algún Deporte ¿Con Qué Frecuencia Lo Realizas?</th>
                <th>¿Qué Hobbies Tienes?</th>
                <th>Si Tu Respuesta Anterior Fue Otras Cosas, Por Favor Especifica a Que Cosas</th>
                <th>¿A Qué Distancia Vives Del Trabajo?</th>
                <th>¿En Qué Soles Venir a Trabajar?</th>
                <th>¿Cuánto Demoras en Llegar al Trabajo?</th>
                <th>Libreta de Conducir</th>
                <th>Fecha de Vencimiento Libreta de Conducir</th>
                <th>Matricula de Vehículo</th>
                <th>Otros Comentarios</th>
                
                <th>¿Te gustaría participar en las actividades de RSE que se promueven a través de involucrATe?</th>
                <th>¿En cuál de las siguientes opciones de RSE te gustaría participar?</th>
                <th>¿Qué Tipo de Apoyo te Gustaría Prestar en las Actividades?</th>
                <th>¿Estarías Dispuesto a Brindar Tus Conocimientos Académicos a Otros que lo Requieran?</th>
                
                <th>Título</th>
                <th>Nivel de Formación</th>
                <th>Nivel de Idiomas</th>
                <th>Área Del Conocimiento</th>
                <th>Entidad Que Otorga</th>
                <th>Fecha Del Título</th>
                <th>Matricula o Tarjeta Profesional</th>
                <th>En Curso</th>
                <th>Estudia Actualmente</th>
                
                
                <th>Empresa </th>
                <th>Cargo</th>
                <th>Sector</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Pais</th>
                <th>Ciudad</th>
                <th>Principales Tareas</th>
                
                <th>Cargo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Vigente</th>
                <th>Resumen de Tareas</th>
                
                <th>Nombre Completo</th>
                <th>Documento de Identidad</th>
                <th>Número de Documento</th>
                <th>Fecha de Nacimiento</th>
                <th>Tiene Hijos</th>
                <th>Cantidad de Hijos</th>
                <th>Nombre Completo</th>
                <th>Documento de Identidad</th>
                <th>Número de Documento</th>
                <th>Fecha de Nacimiento</th>
                <th>Edad</th>
                <th>Parentesco</th>
                <th>Si Tu Respuesta Anterior Fue Otros, Por Favor Especifica</th>
                <th>Nombre Completo</th>
                <th>Documento de Identidad</th>
                <th>Fecha de Nacimiento</th>
                <th>¿Con Quien Convives?</th>
                <th>Si Tu Respuesta Anterior Fue Mascotas, Por Favor Especifica el Tipo</th>
                <th>Indica Si Alguno de los Mienbros con los que Convives Requiere un Cuidado Especial que Amerite Tiempo Adicional en tu Jornada Laboral</th>
                <th>¿Los Gastos Del Hogar Son Asumidos Por?</th>
                
                <th>Nombre Completo</th>
                <th>Parentesco</th>
                <th>Teléfono de Contacto</th>
                <th>Dirección</th>
                <th>Nombre Completo</th>
                <th>Parentesco</th>
                <th>Teléfono de Contacto</th>
                <th>Dirección</th>
                <th>Nombre Completo</th>
                <th>Parentesco</th>
                <th>Teléfono de Contacto</th>
                <th>Dirección</th>
                
                <th>Salario Nominal/Facturación</th>
                <th>Tickets</th>
                <th>Comisión por servicio Outsourcing</th>
                <th>Comisión por backup</th>
                <th>Comisión por ventas pesos uruguayos</th>
                <th>Comisión por ventas dólares</th>
                <th>Viático</th>
                <th>Prima antigüedad</th>
                <th>Horas Extras</th>
                <th>Guardia</th>
                <th>Guardia Variable</th>
                <th>Canasta</th>
                <th>Bono</th>
                <th>Comisión (por otros conceptos)</th>
                <th>Otros</th>
                
                <th>Estado</th>
                <th>Fecha de inactivación</th>
                <th>Observaciones</th>
                <th>Motivo del retiro</th>
            </tr>
        </thead>

        <tbody>
            
        <?php
            $count = 1;
            $array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 1 );
            foreach($array_colaboradores as $col){

                $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$col["id"]."' ");
                $data = mysqli_fetch_array($query);
            
                $permitir = true;
                if($ROLE == 2){
                    $permitir = false;
                    foreach($array_equipo as $id_pos){
                        if($id_pos == $data["id_posicion"]){
                            $permitir = true;
                        }
                    }
                }    
            	//INICIA LA IMPRESION DE LAS FILAS
                
                if($permitir == true){
                    
                    $qCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
                    $dCargo = mysqli_fetch_array($qCargo);
					
					$qNivel = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo WHERE id = '".$data["id_nivel_cargo"]."' ");
                    $dNivel = mysqli_fetch_array($qNivel);
					
					$qArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");
                    $dArea = mysqli_fetch_array($qArea);
					
					$qGerencias = mysqli_query($connect_valentina,"SELECT * FROM Gerencias WHERE id = '".$dCargo["id_gerencia"]."' ");
                    $dGerencias = mysqli_fetch_array($qGerencias);
					
					
					
                    
                    $queryList = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                    while($dataList = mysqli_fetch_array($queryList));
                
                    $qryAdicionales = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION['id_user']."' ");
                    $dtAdicionales = mysqli_fetch_array($qryAdicionales);
					
					

                    $qAdicional = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' ");
                    $dAdicional = mysqli_fetch_array($qAdicional);  
					
					$qEquipo = mysqli_query($connect_valentina,"SELECT * FROM Equipos WHERE id = '".$dAdicional["equipo"]."' ");
                    $dEquipo = mysqli_fetch_array($qEquipo);
                    
                    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	                $dataInforma = mysqli_fetch_array($queryInforma);
                    
                    
                    $qryPerfiles = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtPerfiles = mysqli_fetch_array($qryPerfiles);

                    $qPerfil = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$data["id"]."' ");
                    $dPerfil = mysqli_fetch_array($qPerfil);
					
					if($dPerfil["fumas"] == 1){
						$dPerfil["fumas"] = "Si";
					}
					else{
						$dPerfil["fumas"] = "No";
					}
					
					foreach($Array_frecuencia as $nodo){
						if( $dPerfil["frecuencia"] == $nodo[0]){
							$dPerfil["frecuencia"] = $nodo[1];
						}
					}
					
					
					
                    
                    $qryPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtPreferencias = mysqli_fetch_array($qryPreferencias);

                    $qPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$data["id"]."' ");
                    $dPreferencias = mysqli_fetch_array($qPreferencias);
                    
                    $qryAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtAcademico = mysqli_fetch_array($qryAcademico);

                    $qAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id_empleado = '".$data["id"]."' ");
                    $dAcademico = mysqli_fetch_array($qAcademico);
                    
                    $qryLaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtLaboral = mysqli_fetch_array($qryLaboral);

                    $qLaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales WHERE id_empleado = '".$data["id"]."' ");
                    $dLaboral = mysqli_fetch_array($qLaboral);
                    
                    $qryTrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtTrayectoria = mysqli_fetch_array($qryTrayectoria);

                    $qTrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$data["id"]."' ");
                    $dTrayectoria = mysqli_fetch_array($qTrayectoria);
                    
                    $qryFamiliares = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtFamiliares = mysqli_fetch_array($qryFamiliares);

                    $qFamiliares = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id_empleado = '".$data["id"]."' ");
                    $dFamiliares = mysqli_fetch_array($qFamiliares);
                    
                    $qryHijos = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Hijos WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtHijos = mysqli_fetch_array($qryHijos);

                    $qHijos = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Hijos WHERE id_empleado = '".$data["id"]."' ");
                    $dHijos = mysqli_fetch_array($qHijos);
                    
                    $qryEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtEmergencia = mysqli_fetch_array($qryEmergencia);

                    $qEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$data["id"]."' ");
                    $dEmergencia = mysqli_fetch_array($qEmergencia);
                    
                    $qryRemuneracion = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Remuneracion WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtRemuneracion = mysqli_fetch_array($qryRemuneracion);

                    $qRemuneracion = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Remuneracion WHERE id_empleado = '".$data["id"]."' ");
                    $dRemuneracion = mysqli_fetch_array($qRemuneracion);

                    $qCiudadNace = mysqli_query($connect_valentina,"SELECT * FROM Municipios 
                    WHERE id_municipio = '".$dAdicional["ciudad_nacimiento"]."' ");
                    $dCiudadNace = mysqli_fetch_array($qCiudadNace);

                    $qCiudadResidencia = mysqli_query($connect_valentina,"SELECT * FROM Municipios 
                    WHERE id_municipio = '".$dAdicional["ciudad_residencia"]."' ");
                    $dCiudadResidencia = mysqli_fetch_array($qCiudadResidencia);
                    
                    $qryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtCargos = mysqli_fetch_array($qryCargos);

                    $qCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empleado = '".$data["id"]."' ");
                    $dCargos = mysqli_fetch_array($qCargos);
                    
                    

                    $txt_Genero = "";
                    foreach($Array_Genero as $fila){
                        if($dAdicional["genero"] == $fila[0] ){
                            $txt_Genero = $fila[1]; 
                        }
                    }
                
                    $txt_Pais_Residencia = "";
                    foreach($Array_Pais_Residencia as $fila){
                        if($dAdicional["pais_residencia"] == $fila[0] ){
                            $txt_Pais_Residencia = $fila[1]; 
                        }
                    }
                
                    $txt_Pais_Nac = "";
                    foreach($Array_Pais_Nac as $fila){
                        if($dAdicional["pais_nacimiento"] == $fila[0] ){
                            $txt_Pais_Nac = $fila[1]; 
                        }
                    }
                
                    $txt_Grupo_Sanguineo = "";
                    foreach($Array_Grupo_Sanguineo as $fila){
                        if($dAdicional["grupo_sanguineo"] == $fila[0] ){
                            $txt_Grupo_Sanguineo = $fila[1]; 
                        }
                    }
                
                    $txt_Departamento_Nacimiento = "";
					$queryDepNace = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_departamento = '".$dAdicional["departamento_nacimiento"]."' ");
					$dataDepNace = mysqli_fetch_array($queryDepNace);
					$txt_Departamento_Nacimiento = $dataDepNace["departamento"]; 
					
					/*
                    foreach($Array_Departamento_Nacimiento as $fila){
                        if($dAdicional["departamento_nacimiento"] == $fila[0] ){
                            $txt_Departamento_Nacimiento = $fila[1]; 
                        }
                    }
					*/
                
                    $txt_Ciudad_Nacimiento = "";
                    foreach($Array_Ciudad_Nacimiento as $fila){
                        if($dAdicional["ciudad_nacimiento"] == $fila[0] ){
                            $txt_Ciudad_Nacimiento = $fila[1]; 
                        }
                    }
                
                    $txt_Departamento_Residencia = "";
					$queryDep = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_departamento = '".$dAdicional["departamento_residencia"]."' ");
					$dataDep = mysqli_fetch_array($queryDep);
					$txt_Departamento_Residencia = $dataDep["departamento"]; 
					
					/*
                    foreach($Array_Departamento_Residencia as $fila){
                        if($dAdicional["departamento_residencia"] == $fila[0] ){
                            $txt_Departamento_Residencia = $fila[1]; 
                        }
                    }
					*/
                
                    $txt_Ciudad_Residencia = "";
                    foreach($Array_Ciudad_Residencia as $fila){
                        if($dAdicional["ciudad_residencia"] == $fila[0] ){
                            $txt_Ciudad_Residencia = $fila[1]; 
                        }
                    }
                
                    $txt_Factor = "";
                    foreach($Array_Factor as $fila){
                        if($dAdicional["factor_rh"] == $fila[0] ){
                            $txt_Factor = $fila[1]; 
                        }
                    }
                
                    $txt_Estado_Civil = "";
                    foreach($Array_Estado_Civil as $fila){
                        if($dAdicional["estado_civil"] == $fila[0] ){
                            $txt_Estado_Civil = $fila[1]; 
                        }
                    }
                
                    $txt_Nacionalidad = "";
                    foreach($Array_Nacionalidad as $fila){
                        if($dAdicional["nacionalidad"] == $fila[0] ){
                            $txt_Nacionalidad = $fila[1]; 
                        }
                    }
                
                    $txt_Tipo_Contrato = "";
                    foreach($Array_Tipo_Contrato as $fila){
                        if($dAdicional["tipo_contrato"] == $fila[0] ){
                            $txt_Tipo_Contrato = $fila[1]; 
                        }
                    }
                    
                    $txt_Salario_flexibilizado = "";
                    foreach($Array_salario_flexibilizado as $fila){
                        if($dAdicional["salario_flexibilizado"] == $fila[0] ){
                            $txt_Salario_flexibilizado = $fila[1]; 
                        }
                    }
                    
                    $txt_Dotacion_aplica = "";
                    foreach($Array_Dotacion_Aplica as $fila){
                        if($dAdicional["dotacion_aplica"] == $fila[0] ){
                            $txt_Dotacion_aplica = $fila[1]; 
                        }
                    }
                    
                    $txt_Tipo_dotacion = "";
                    foreach($Array_Dotacion_Tipo as $fila){
                        if($dAdicional["dotacion_tipo"] == $fila[0] ){
                            $txt_Tipo_dotacion = $fila[1]; 
                        }
                    }
                    
                    $txt_Vivienda = "";
                    foreach($Array_vivienda as $fila){
                        if($dAdicional["vivienda"] == $fila[0] ){
                            $txt_Vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Tenencia = "";
                    foreach($Array_tenencia as $fila){
                        if($dAdicional["tenencia"] == $fila[0] ){
                            $txt_Tenencia = $fila[1]; 
                        }
                    }
                    
                    $txt_Condicion_vivienda = "";
                    foreach($Array_Condicion_Vivienda as $fila){
                        if($dAdicional["condicion_vivienda"] == $fila[0] ){
                            $txt_Condicion_vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Material_predominante = "";
                    foreach($Array_Material_Predominante as $fila){
                        if($dAdicional["material_predominante"] == $fila[0] ){
                            $txt_Material_predominante = $fila[1]; 
                        }
                    }
                    
                    $txt_Material_pisos = "";
                    foreach($Array_Material_Pisos as $fila){
                        if($dAdicional["material_pisos"] == $fila[0] ){
                            $txt_Material_pisos = $fila[1]; 
                        }
                    }
                    
                    $txt_Material_bano = "";
                    foreach($Array_Material_Bano as $fila){
                        if($dAdicional["material_baño"] == $fila[0] ){
                            $txt_Material_bano = $fila[1]; 
                        }
                    }
                    
                    $txt_Adquirir_vivienda = "";
                    foreach($Array_Adquirir_Vivienda as $fila){
                        if($dAdicional["adquirir_vivienda"] == $fila[0] ){
                            $txt_Adquirir_vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Credito_vivienda = "";
                    foreach($Array_Credito_Vivienda as $fila){
                        if($dAdicional["credito_vivienda"] == $fila[0] ){
                            $txt_Credito_vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Mejora_locativa = "";
                    foreach($Array_Mejora_Locativa as $fila){
                        if($dAdicional["mejora_locativa"] == $fila[0] ){
                            $txt_Mejora_locativa = $fila[1]; 
                        }
                    }
                    
                    $txt_Credito_vehiculos = "";
                    foreach($Array_Credito_Vehiculos as $fila){
                        if($dAdicional["credito_vehiculos"] == $fila[0] ){
                            $txt_Credito_vehiculos = $fila[1]; 
                        }
                    }
                    
                    $txt_Gastos = "";
                    foreach($Array_gastos as $fila){
                        if($dAdicional["gastos"] == $fila[0] ){
                            $txt_Gastos = $fila[1]; 
                        }
                    }
                    
                    $txt_Cabeza_familia = "";
                    foreach($Array_Cabeza_familia as $fila){
                        if($dAdicional["cabeza_familia"] == $fila[0] ){
                            $txt_Cabeza_familia = $fila[1]; 
                        }
                    }
                    
                    $txt_Frecuencia = "";
                    foreach($Array_frecuencia as $fila){
                        if($dPreferencias["frecuencia"] == $fila[0] ){
                            $txt_Frecuencia = $fila[1]; 
                        }
                    }
                    
                    $txt_Sustancias = "";
                    foreach($Array_sustancias as $fila){
                        if($dPreferencias["sustancias"] == $fila[0] ){
                            $txt_Sustancias = $fila[1]; 
                        }
                    }
                    
                    $txt_Bebidas = "";
                    foreach($Array_bebidas as $fila){
                        if($dPreferencias["bebidas"] == $fila[0] ){
                            $txt_Bebidas = $fila[1]; 
                        }
                    }
                    
                    $txt_Fumas = "";
                    foreach($Array_fumas as $fila){
                        if($dPreferencias["fumas"] == $fila[0] ){
                            $txt_Fumas = $fila[1]; 
                        }
                    }
                    
                    $txt_Enfermedad = "";
                    foreach($Array_enfermedad as $fila){
                        if($dPreferencias["enfermedad"] == $fila[0] ){
                            $txt_Enfermedad = $fila[1]; 
                        }
                    }
                    
                    $txt_Desplazamiento = "";
                    foreach($Array_desplazamiento as $fila){
                        if($dPreferencias["desplazamiento"] == $fila[0] ){
                            $txt_Desplazamiento = $fila[1]; 
                        }
                    }
                    
                    $txt_Actividades = "";
                    foreach($Array_actividades as $fila){
                        if($dPreferencias["actividades"] == $fila[0] ){
                            $txt_Actividades = $fila[1]; 
                        }
                    }
                    
                    $txt_Brigada = "";
                    foreach($Array_brigada as $fila){
                        if($dPreferencias["brigada"] == $fila[0] ){
                            $txt_Brigada = $fila[1]; 
                        }
                    }
                    
                    $txt_Pertenecer = "";
                    foreach($Array_pertenecer as $fila){
                        if($dPreferencias["pertenecer"] == $fila[0] ){
                            $txt_Pertenecer = $fila[1]; 
                        }
                    }
                    
                    $txt_Voluntariado = "";
                    foreach($Array_voluntariado as $fila){
                        if($dPreferencias["voluntariado"] == $fila[0] ){
                            $txt_Voluntariado = $fila[1]; 
                        }
                    }
                    
                    $txt_AFAP = "";
                    foreach($Array_AFAP as $fila){
                        if($dataInforma["afap"] == $fila[0] ){
                            $txt_AFAP = $fila[1]; 
                        }
                    }
                    
                    $txt_Familiares = "";
                    foreach($Array_gastos as $fila){
                        if($dFamiliares["gastos"] == $fila[0] ){
                            $txt_Familiares = $fila[1]; 
                        }
                    }
                    
                    $txt_Familiaresdoc = "";
                    foreach($Lista_Tipo_Doc as $tipo){
                        if($dFamiliares["tipo_documento"] == $tipo[0] ){
                            $txt_Familiaresdoc = $tipo[1]; 
                        }
                    }
                    
                    $txt_Familiaresconyugedoc = "";
                    foreach($Lista_Tipo_Doc as $tipo){
                        if($dFamiliares["documento_conyuge"] == $tipo[0] ){
                            $txt_Familiaresconyugedoc = $tipo[1]; 
                        }
                    }
                    
                
                
            ?>
            <tr>
                <th scope="row"><?php echo $count; ?></th>
                <td><?php echo $data["documento"]; ?></td>
                <td><?php echo $col["nombre_completo"]; ?></td>
                
                <td><?php echo $data["nombre"]." ".$data["nombre_2"]; ?></td>
                <td><?php echo $data["apellidos"]." ".$data["apellidos_2"]; ?></td>
                <td><?php echo $dAdicional["preferencia"]; ?></td>
                <td><?php echo $dAdicional["apodo"]; ?></td>
                <td><?php echo $dAdicional["fecha_vencimiento"]; ?></td>
                <td><?php echo $dAdicional["pasaporte"]; ?></td>
                <td><?php echo $dAdicional["fecha_vencimiento_p"]; ?></td>
                <td><?php echo $dAdicional["credencial_civica"]; ?></td>
                <td><?php echo $dAdicional["fecha_nacimiento"]; ?></td>
                <td><?php echo $dAdicional["edad"]; ?></td> 
                <td><?php echo $txt_Genero; ?></td>
                <td><?php echo $txt_Estado_Civil; ?></td>
                <td><?php echo $txt_Nacionalidad; ?></td>
                <td><?php echo $txt_Pais_Residencia; ?></td>
                <td><?php echo $dAdicional["fecha_ingreso"] ?></td>
                <td><?php echo $dAdicional["cod_colaborador"]; ?></td>
                <td><?php echo $data["correo"]; ?></td>
                <td><?php echo $dCargo["nombre"]; ?></td>
                <td><?php echo $dNivel["nombre"]; ?></td>
                <td><?php echo $dArea["nombre"]; ?></td>
                <td><?php echo $dGerencias["nombre"]; ?></td>
				
                <td><?php echo $dEquipo["nombre"]; ?></td>
				
                <td><?php echo $dAdicional["cliente"]; ?></td>
                <td><?php echo $dAdicional["dr_cliente"]; ?></td>
                <td><?php echo $dAdicional["correo_ou"]; ?></td>
                <td><?php echo $dAdicional["h_servicio"]; ?></td>
                <td><?php echo $txt_Dotacion_aplica; ?></td>
                <td><?php echo $dAdicional["r_social"]; ?></td>
                <td><?php echo $dAdicional["dr_fisica"]; ?></td>
                <td><?php echo $dAdicional["rut"]; ?></td>
                <td><?php echo $dAdicional["banco"]; ?></td>
                <td><?php echo $dAdicional["t_cuenta"]; ?></td>
                <td><?php echo $dAdicional["cuenta"]; ?></td>
                <td><?php echo $dAdicional["afap"]; ?></td>
                <td><?php echo $dAdicional["c_profesional"]; ?></td>
                <td><?php echo $dAdicional["fv_docu"]; ?></td>
                <td><?php echo $dAdicional["talla_remera"]; ?></td>
                <td><?php echo $dAdicional["modelo"]; ?></td>
                <td><?php echo $dAdicional["color"]; ?></td>
                <td><?php echo $dAdicional["comentario"]; ?></td>
                <td><?php echo $txt_Pais_Residencia; ?></td>
                <td><?php echo $dAdicional["departamento_otro"]; ?></td>
                <td><?php echo $dAdicional["ciudad_otro"]; ?></td>
                <td><?php echo $txt_Departamento_Residencia; ?></td>
                <td><?php echo $txt_Ciudad_Residencia; ?></td>
                <td><?php echo $dAdicional["direccion"]; ?></td>
                <td><?php echo $dAdicional["cd_postal"]; ?></td>
                <td><?php echo $dAdicional["telefono"]; ?></td>
                <td><?php echo $dAdicional["celular"]; ?></td>
                <td><?php echo $dAdicional["email_p"]; ?></td>
                
                <td><?php echo $dPerfil["eps"]; ?></td>
                <td><?php echo $dPerfil["afp"]; ?></td>
                <td><?php echo $dPerfil["emergencia"]; ?></td>
                <td><?php echo $dPerfil["car_salud"]; ?></td>
                <td><?php echo $dPerfil["apt_fisica"]; ?></td>
                <td><?php echo $dPerfil["patologias"]; ?></td>
                <td><?php echo $dPerfil["alergias"]; ?></td>
                <td><?php echo $dPerfil["formula_optica"]; ?></td>
                <td><?php echo $dPerfil["audifonos"]; ?></td>
                <td><?php echo $dPerfil["otros"]; ?></td>
                <td><?php echo $dPerfil["comensal"]; ?></td>
                <td><?php echo $dPerfil["restriccion"]; ?></td>
                <td><?php echo $dPerfil["fumas"]; ?></td>
                <td><?php echo $dPerfil["deportes"]; ?></td>
                <td><?php echo $dPerfil["frecuencia"]; ?></td>
                <td><?php echo $dPerfil["hobbies"]; ?></td>
                <td><?php echo $dPerfil["comentario_tl"]; ?></td>
                <td><?php echo $dPerfil["distancia"]; ?></td>
                <td><?php echo $dPerfil["vehiculo_propio"]; ?></td>
                <td><?php echo $txt_Desplazamiento; ?></td>
                <td><?php echo $dPerfil["licencia_conduccion"]; ?></td>
                <td><?php echo $dPerfil["fecha_libreta"]; ?></td>
                <td><?php echo $dPerfil["matricula"]; ?></td>
                <td><?php echo $dPerfil["otros_comentarios"]; ?></td>
                
                <td><?php echo $txt_Voluntariado; ?></td>
                <td><?php echo $dPreferencias["opciones_voluntariado"]; ?></td>
                <td><?php echo $dPreferencias["apoyo"]; ?></td>
                <td><?php echo $dPreferencias["conocimiento"]; ?></td>
                
                <td><?php echo $dAcademico["titulo"]; ?></td>
                <td><?php echo $dAcademico["nivel"]; ?></td>
                <td><?php echo $dAcademico["nivel_idiomas"]; ?></td>
                <td><?php echo $dAcademico["area_conocimiento"]; ?></td>
                <td><?php echo $dAcademico["entidad"]; ?></td>
                <td><?php echo $dAcademico["fecha_titulo"]; ?></td>
                <td><?php echo $dAcademico["tarjeta_profesional"]; ?></td>
                <td><?php echo $dAcademico["en_curso"]; ?></td>
                <td><?php echo $dAcademico["estudia_actualmente"]; ?></td>
                
                <td><?php echo $dLaboral["entidad"]; ?></td>
                <td><?php echo $dLaboral["cargo"]; ?></td>
                <td><?php echo $dLaboral["sector"]; ?></td>
                <td><?php echo $dLaboral["fecha_inicio"]; ?></td>
                <td><?php echo $dLaboral["fecha_fin"]; ?></td>
                <td><?php echo $dLaboral["pais"]; ?></td>
                <td><?php echo $dLaboral["ciudad"]; ?></td>
                <td><?php echo $dLaboral["experiencia"]; ?></td>
                
                <td><?php echo $dTrayectoria["cargo"]; ?></td>
                <td><?php echo $dTrayectoria["fecha_inicia"]; ?></td>
                <td><?php echo $dTrayectoria["fecha_fin"]; ?></td>
                <td><?php echo $dTrayectoria["vigente"]; ?></td>
                <td><?php echo $dTrayectoria["resumen"]; ?></td>
                
                <td><?php echo $dFamiliares["conyuge"]; ?></td>
                <td><?php echo $txt_Familiaresconyugedoc; ?></td>
                <td><?php echo $dFamiliares["numero_dcunyuge"]; ?></td>
                <td><?php echo $dFamiliares["fecha_conyuge"]; ?></td>
                <td><?php echo $dHijos["numero_hijos"]; ?></td>
                <td><?php echo $dHijos["cantidad_hijo"]; ?></td>
                <td><?php echo $dHijos["nombre_hijo"]; ?></td>
                <td><?php echo $dHijos["documento_hijo"]; ?></td>
                <td><?php echo $dHijos["numero_hijo"]; ?></td>
                <td><?php echo $dHijos["fecha_hijo"]; ?></td>
                <td><?php echo $dHijos["edadh"]; ?></td>
                <td><?php echo $dFamiliares["parentesco"]; ?></td>
                <td><?php echo $dFamiliares["otros"]; ?></td>
                <td><?php echo $dFamiliares["nombre"]; ?></td>
                <td><?php echo $txt_Familiaresdoc; ?></td>
                <td><?php echo $dFamiliares["fecha_nace"]; ?></td>
                <td><?php echo $dFamiliares["convives"]; ?></td>
                <td><?php echo $dFamiliares["mascotas"]; ?></td>
                <td><?php echo $dFamiliares["cuidado_especial"]; ?></td>
                <td><?php echo $txt_Familiares; ?></td>
                
                <td><?php echo $dEmergencia["nombres1"]; ?></td>
                <td><?php echo $dEmergencia["parentezco1"]; ?></td>
                <td><?php echo $dEmergencia["telefono1"]; ?></td>
                <td><?php echo $dEmergencia["direccion1"]; ?></td>
                <td><?php echo $dEmergencia["nombres2"]; ?></td>
                <td><?php echo $dEmergencia["parentezco2"]; ?></td>
                <td><?php echo $dEmergencia["telefono2"]; ?></td>
                <td><?php echo $dEmergencia["direccion2"]; ?></td>
                <td><?php echo $dEmergencia["nombres3"]; ?></td>
                <td><?php echo $dEmergencia["parentezco3"]; ?></td>
                <td><?php echo $dEmergencia["telefono3"]; ?></td>
                <td><?php echo $dEmergencia["direccion3"]; ?></td>
                
                <td><?php echo $dRemuneracion["salario"]; ?></td>
                <td><?php echo $dRemuneracion["tickets"]; ?></td>
                <td><?php echo $dRemuneracion["comision_out"]; ?></td>
                <td><?php echo $dRemuneracion["comision_back"]; ?></td>
                <td><?php echo $dRemuneracion["comision_ventas"]; ?></td>
                <td><?php echo $dRemuneracion["comision_ventas_dls"]; ?></td>
                <td><?php echo $dRemuneracion["viaticos"]; ?></td>
                <td><?php echo $dRemuneracion["prima_antiguedad"]; ?></td>
                <td><?php echo $dRemuneracion["horas_extra"]; ?></td>
                <td><?php echo $dRemuneracion["guardia"]; ?></td>
                <td><?php echo $dRemuneracion["guardia_var"]; ?></td>
                <td><?php echo $dRemuneracion["canasta"]; ?></td>
                <td><?php echo $dRemuneracion["bono"]; ?></td>
                <td><?php echo $dRemuneracion["comision_otro"]; ?></td>
                <td><?php echo $dRemuneracion["otro"]; ?></td>
				<td>Activo</td>
                <td><?php echo $data["fecha_inactivacion"]; ?></td>
                <td><?php echo $data["observaciones_inactivacion"]; ?></td>
                <td><?php echo $data["motivo_retiro"]; ?></td>
            </tr> 
            
        <?php 
                //TERMINA LA IMPRESION DE LAS FILAS
                    $count++; 
                }
            }
        ?>
			
			
			
			
		<!-- INACTIVOS -->	
		<?php
            $count = 1;
            $array_colaboradores = $ClassColaboradores->lista_colaboradores_nuevo( $connect_valentina, 2 );
            foreach($array_colaboradores as $col){

                $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$col["id"]."' ");
                $data = mysqli_fetch_array($query);

           
                
                $permitir = true;
                if($ROLE == 2){
                    $permitir = false;
                    foreach($array_equipo as $id_pos){
                        if($id_pos == $data["id_posicion"]){
                            $permitir = true;
                        }
                    }
                }    
            	//INICIA LA IMPRESION DE LAS FILAS
                
                if($permitir == true){
                    
                    $qCargo = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id = '".$data["id_cargo"]."' ");
                    $dCargo = mysqli_fetch_array($qCargo);
					
					$qNivel = mysqli_query($connect_valentina,"SELECT * FROM Niveles_Cargo WHERE id = '".$data["id_nivel_cargo"]."' ");
                    $dNivel = mysqli_fetch_array($qNivel);
					
					$qArea = mysqli_query($connect_valentina,"SELECT * FROM Areas WHERE id = '".$data["id_area"]."' ");
                    $dArea = mysqli_fetch_array($qArea);
					
					$qGerencias = mysqli_query($connect_valentina,"SELECT * FROM Gerencias WHERE id = '".$dCargo["id_gerencia"]."' ");
                    $dGerencias = mysqli_fetch_array($qGerencias);
					
					
					
                    
                    $queryList = mysqli_query($connect_valentina,"SELECT * FROM Cargos ORDER BY nombre ASC ");  
                    while($dataList = mysqli_fetch_array($queryList));
                
                    $qryAdicionales = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION['id_user']."' ");
                    $dtAdicionales = mysqli_fetch_array($qryAdicionales);
					
					

                    $qAdicional = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$data["id"]."' ");
                    $dAdicional = mysqli_fetch_array($qAdicional);  
					
					$qEquipo = mysqli_query($connect_valentina,"SELECT * FROM Equipos WHERE id = '".$dAdicional["equipo"]."' ");
                    $dEquipo = mysqli_fetch_array($qEquipo);
                    
                    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Adicionales WHERE id_empleado = '".$_SESSION["id_colaborador_edit"]."' ");
	                $dataInforma = mysqli_fetch_array($queryInforma);
                    
                    
                    $qryPerfiles = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtPerfiles = mysqli_fetch_array($qryPerfiles);

                    $qPerfil = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Perfiles WHERE id_empleado = '".$data["id"]."' ");
                    $dPerfil = mysqli_fetch_array($qPerfil);
					
					if($dPerfil["fumas"] == 1){
						$dPerfil["fumas"] = "Si";
					}
					else{
						$dPerfil["fumas"] = "No";
					}
					
					foreach($Array_frecuencia as $nodo){
						if( $dPerfil["frecuencia"] == $nodo[0]){
							$dPerfil["frecuencia"] = $nodo[1];
						}
					}
					
					
					
                    
                    $qryPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtPreferencias = mysqli_fetch_array($qryPreferencias);

                    $qPreferencias = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Preferencias WHERE id_empleado = '".$data["id"]."' ");
                    $dPreferencias = mysqli_fetch_array($qPreferencias);
                    
                    $qryAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtAcademico = mysqli_fetch_array($qryAcademico);

                    $qAcademico = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Academico WHERE id_empleado = '".$data["id"]."' ");
                    $dAcademico = mysqli_fetch_array($qAcademico);
                    
                    $qryLaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtLaboral = mysqli_fetch_array($qryLaboral);

                    $qLaboral = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Laborales WHERE id_empleado = '".$data["id"]."' ");
                    $dLaboral = mysqli_fetch_array($qLaboral);
                    
                    $qryTrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtTrayectoria = mysqli_fetch_array($qryTrayectoria);

                    $qTrayectoria = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Trayectoria WHERE id_empleado = '".$data["id"]."' ");
                    $dTrayectoria = mysqli_fetch_array($qTrayectoria);
                    
                    $qryFamiliares = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtFamiliares = mysqli_fetch_array($qryFamiliares);

                    $qFamiliares = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Familiares WHERE id_empleado = '".$data["id"]."' ");
                    $dFamiliares = mysqli_fetch_array($qFamiliares);
                    
                    $qryHijos = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Hijos WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtHijos = mysqli_fetch_array($qryHijos);

                    $qHijos = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Hijos WHERE id_empleado = '".$data["id"]."' ");
                    $dHijos = mysqli_fetch_array($qHijos);
                    
                    $qryEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtEmergencia = mysqli_fetch_array($qryEmergencia);

                    $qEmergencia = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Emergencia WHERE id_empleado = '".$data["id"]."' ");
                    $dEmergencia = mysqli_fetch_array($qEmergencia);
                    
                    $qryRemuneracion = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Remuneracion WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtRemuneracion = mysqli_fetch_array($qryRemuneracion);

                    $qRemuneracion = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Remuneracion WHERE id_empleado = '".$data["id"]."' ");
                    $dRemuneracion = mysqli_fetch_array($qRemuneracion);

                    $qCiudadNace = mysqli_query($connect_valentina,"SELECT * FROM Municipios 
                    WHERE id_municipio = '".$dAdicional["ciudad_nacimiento"]."' ");
                    $dCiudadNace = mysqli_fetch_array($qCiudadNace);

                    $qCiudadResidencia = mysqli_query($connect_valentina,"SELECT * FROM Municipios 
                    WHERE id_municipio = '".$dAdicional["ciudad_residencia"]."' ");
                    $dCiudadResidencia = mysqli_fetch_array($qCiudadResidencia);
                    
                    $qryCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empleado = '".$_SESSION['id_user_valentina']."' ");
                    $dtCargos = mysqli_fetch_array($qryCargos);

                    $qCargos = mysqli_query($connect_valentina,"SELECT * FROM Cargos WHERE id_empleado = '".$data["id"]."' ");
                    $dCargos = mysqli_fetch_array($qCargos);
                    
                    

                    $txt_Genero = "";
                    foreach($Array_Genero as $fila){
                        if($dAdicional["genero"] == $fila[0] ){
                            $txt_Genero = $fila[1]; 
                        }
                    }
                
                    $txt_Pais_Residencia = "";
                    foreach($Array_Pais_Residencia as $fila){
                        if($dAdicional["pais_residencia"] == $fila[0] ){
                            $txt_Pais_Residencia = $fila[1]; 
                        }
                    }
                
                    $txt_Pais_Nac = "";
                    foreach($Array_Pais_Nac as $fila){
                        if($dAdicional["pais_nacimiento"] == $fila[0] ){
                            $txt_Pais_Nac = $fila[1]; 
                        }
                    }
                
                    $txt_Grupo_Sanguineo = "";
                    foreach($Array_Grupo_Sanguineo as $fila){
                        if($dAdicional["grupo_sanguineo"] == $fila[0] ){
                            $txt_Grupo_Sanguineo = $fila[1]; 
                        }
                    }
                
                    $txt_Departamento_Nacimiento = "";
					$queryDepNace = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_departamento = '".$dAdicional["departamento_nacimiento"]."' ");
					$dataDepNace = mysqli_fetch_array($queryDepNace);
					$txt_Departamento_Nacimiento = $dataDepNace["departamento"]; 
					
					/*
                    foreach($Array_Departamento_Nacimiento as $fila){
                        if($dAdicional["departamento_nacimiento"] == $fila[0] ){
                            $txt_Departamento_Nacimiento = $fila[1]; 
                        }
                    }
					*/
                
                    $txt_Ciudad_Nacimiento = "";
                    foreach($Array_Ciudad_Nacimiento as $fila){
                        if($dAdicional["ciudad_nacimiento"] == $fila[0] ){
                            $txt_Ciudad_Nacimiento = $fila[1]; 
                        }
                    }
                
                    $txt_Departamento_Residencia = "";
					$queryDep = mysqli_query($connect_valentina,"SELECT * FROM Departamentos WHERE id_departamento = '".$dAdicional["departamento_residencia"]."' ");
					$dataDep = mysqli_fetch_array($queryDep);
					$txt_Departamento_Residencia = $dataDep["departamento"]; 
					
					/*
                    foreach($Array_Departamento_Residencia as $fila){
                        if($dAdicional["departamento_residencia"] == $fila[0] ){
                            $txt_Departamento_Residencia = $fila[1]; 
                        }
                    }
					*/
                
                    $txt_Ciudad_Residencia = "";
                    foreach($Array_Ciudad_Residencia as $fila){
                        if($dAdicional["ciudad_residencia"] == $fila[0] ){
                            $txt_Ciudad_Residencia = $fila[1]; 
                        }
                    }
                
                    $txt_Factor = "";
                    foreach($Array_Factor as $fila){
                        if($dAdicional["factor_rh"] == $fila[0] ){
                            $txt_Factor = $fila[1]; 
                        }
                    }
                
                    $txt_Estado_Civil = "";
                    foreach($Array_Estado_Civil as $fila){
                        if($dAdicional["estado_civil"] == $fila[0] ){
                            $txt_Estado_Civil = $fila[1]; 
                        }
                    }
                
                    $txt_Nacionalidad = "";
                    foreach($Array_Nacionalidad as $fila){
                        if($dAdicional["nacionalidad"] == $fila[0] ){
                            $txt_Nacionalidad = $fila[1]; 
                        }
                    }
                
                    $txt_Tipo_Contrato = "";
                    foreach($Array_Tipo_Contrato as $fila){
                        if($dAdicional["tipo_contrato"] == $fila[0] ){
                            $txt_Tipo_Contrato = $fila[1]; 
                        }
                    }
                    
                    $txt_Salario_flexibilizado = "";
                    foreach($Array_salario_flexibilizado as $fila){
                        if($dAdicional["salario_flexibilizado"] == $fila[0] ){
                            $txt_Salario_flexibilizado = $fila[1]; 
                        }
                    }
                    
                    $txt_Dotacion_aplica = "";
                    foreach($Array_Dotacion_Aplica as $fila){
                        if($dAdicional["dotacion_aplica"] == $fila[0] ){
                            $txt_Dotacion_aplica = $fila[1]; 
                        }
                    }
                    
                    $txt_Tipo_dotacion = "";
                    foreach($Array_Dotacion_Tipo as $fila){
                        if($dAdicional["dotacion_tipo"] == $fila[0] ){
                            $txt_Tipo_dotacion = $fila[1]; 
                        }
                    }
                    
                    $txt_Vivienda = "";
                    foreach($Array_vivienda as $fila){
                        if($dAdicional["vivienda"] == $fila[0] ){
                            $txt_Vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Tenencia = "";
                    foreach($Array_tenencia as $fila){
                        if($dAdicional["tenencia"] == $fila[0] ){
                            $txt_Tenencia = $fila[1]; 
                        }
                    }
                    
                    $txt_Condicion_vivienda = "";
                    foreach($Array_Condicion_Vivienda as $fila){
                        if($dAdicional["condicion_vivienda"] == $fila[0] ){
                            $txt_Condicion_vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Material_predominante = "";
                    foreach($Array_Material_Predominante as $fila){
                        if($dAdicional["material_predominante"] == $fila[0] ){
                            $txt_Material_predominante = $fila[1]; 
                        }
                    }
                    
                    $txt_Material_pisos = "";
                    foreach($Array_Material_Pisos as $fila){
                        if($dAdicional["material_pisos"] == $fila[0] ){
                            $txt_Material_pisos = $fila[1]; 
                        }
                    }
                    
                    $txt_Material_bano = "";
                    foreach($Array_Material_Bano as $fila){
                        if($dAdicional["material_baño"] == $fila[0] ){
                            $txt_Material_bano = $fila[1]; 
                        }
                    }
                    
                    $txt_Adquirir_vivienda = "";
                    foreach($Array_Adquirir_Vivienda as $fila){
                        if($dAdicional["adquirir_vivienda"] == $fila[0] ){
                            $txt_Adquirir_vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Credito_vivienda = "";
                    foreach($Array_Credito_Vivienda as $fila){
                        if($dAdicional["credito_vivienda"] == $fila[0] ){
                            $txt_Credito_vivienda = $fila[1]; 
                        }
                    }
                    
                    $txt_Mejora_locativa = "";
                    foreach($Array_Mejora_Locativa as $fila){
                        if($dAdicional["mejora_locativa"] == $fila[0] ){
                            $txt_Mejora_locativa = $fila[1]; 
                        }
                    }
                    
                    $txt_Credito_vehiculos = "";
                    foreach($Array_Credito_Vehiculos as $fila){
                        if($dAdicional["credito_vehiculos"] == $fila[0] ){
                            $txt_Credito_vehiculos = $fila[1]; 
                        }
                    }
                    
                    $txt_Gastos = "";
                    foreach($Array_gastos as $fila){
                        if($dAdicional["gastos"] == $fila[0] ){
                            $txt_Gastos = $fila[1]; 
                        }
                    }
                    
                    $txt_Cabeza_familia = "";
                    foreach($Array_Cabeza_familia as $fila){
                        if($dAdicional["cabeza_familia"] == $fila[0] ){
                            $txt_Cabeza_familia = $fila[1]; 
                        }
                    }
                    
                    $txt_Frecuencia = "";
                    foreach($Array_frecuencia as $fila){
                        if($dPreferencias["frecuencia"] == $fila[0] ){
                            $txt_Frecuencia = $fila[1]; 
                        }
                    }
                    
                    $txt_Sustancias = "";
                    foreach($Array_sustancias as $fila){
                        if($dPreferencias["sustancias"] == $fila[0] ){
                            $txt_Sustancias = $fila[1]; 
                        }
                    }
                    
                    $txt_Bebidas = "";
                    foreach($Array_bebidas as $fila){
                        if($dPreferencias["bebidas"] == $fila[0] ){
                            $txt_Bebidas = $fila[1]; 
                        }
                    }
                    
                    $txt_Fumas = "";
                    foreach($Array_fumas as $fila){
                        if($dPreferencias["fumas"] == $fila[0] ){
                            $txt_Fumas = $fila[1]; 
                        }
                    }
                    
                    $txt_Enfermedad = "";
                    foreach($Array_enfermedad as $fila){
                        if($dPreferencias["enfermedad"] == $fila[0] ){
                            $txt_Enfermedad = $fila[1]; 
                        }
                    }
                    
                    $txt_Desplazamiento = "";
                    foreach($Array_desplazamiento as $fila){
                        if($dPreferencias["desplazamiento"] == $fila[0] ){
                            $txt_Desplazamiento = $fila[1]; 
                        }
                    }
                    
                    $txt_Actividades = "";
                    foreach($Array_actividades as $fila){
                        if($dPreferencias["actividades"] == $fila[0] ){
                            $txt_Actividades = $fila[1]; 
                        }
                    }
                    
                    $txt_Brigada = "";
                    foreach($Array_brigada as $fila){
                        if($dPreferencias["brigada"] == $fila[0] ){
                            $txt_Brigada = $fila[1]; 
                        }
                    }
                    
                    $txt_Pertenecer = "";
                    foreach($Array_pertenecer as $fila){
                        if($dPreferencias["pertenecer"] == $fila[0] ){
                            $txt_Pertenecer = $fila[1]; 
                        }
                    }
                    
                    $txt_Voluntariado = "";
                    foreach($Array_voluntariado as $fila){
                        if($dPreferencias["voluntariado"] == $fila[0] ){
                            $txt_Voluntariado = $fila[1]; 
                        }
                    }
                    
                    $txt_AFAP = "";
                    foreach($Array_AFAP as $fila){
                        if($dataInforma["afap"] == $fila[0] ){
                            $txt_AFAP = $fila[1]; 
                        }
                    }
                    
                    $txt_Familiares = "";
                    foreach($Array_gastos as $fila){
                        if($dFamiliares["gastos"] == $fila[0] ){
                            $txt_Familiares = $fila[1]; 
                        }
                    }
                    
                    $txt_Familiaresdoc = "";
                    foreach($Lista_Tipo_Doc as $tipo){
                        if($dFamiliares["tipo_documento"] == $tipo[0] ){
                            $txt_Familiaresdoc = $tipo[1]; 
                        }
                    }
                    
                    $txt_Familiaresconyugedoc = "";
                    foreach($Lista_Tipo_Doc as $tipo){
                        if($dFamiliares["documento_conyuge"] == $tipo[0] ){
                            $txt_Familiaresconyugedoc = $tipo[1]; 
                        }
                    }
                    
                
                
            ?>
            <tr>
                <th scope="row"><?php echo $count; ?></th>
                <td><?php echo $data["documento"]; ?></td>
                <td><?php echo $col["nombre_completo"]; ?></td>
                <td><?php echo $data["nombre"]." ".$data["nombre_2"]; ?></td>
                <td><?php echo $data["apellidos"]." ".$data["apellidos_2"]; ?></td>
                <td><?php echo $dAdicional["preferencia"]; ?></td>
                <td><?php echo $dAdicional["apodo"]; ?></td>
                <td><?php echo $dAdicional["fecha_vencimiento"]; ?></td>
                <td><?php echo $dAdicional["pasaporte"]; ?></td>
                <td><?php echo $dAdicional["fecha_vencimiento_p"]; ?></td>
                <td><?php echo $dAdicional["credencial_civica"]; ?></td>
                <td><?php echo $dAdicional["fecha_nacimiento"]; ?></td>
                <td><?php echo $dAdicional["edad"]; ?></td> 
                <td><?php echo $txt_Genero; ?></td>
                <td><?php echo $txt_Estado_Civil; ?></td>
                <td><?php echo $txt_Nacionalidad; ?></td>
                <td><?php echo $txt_Pais_Residencia; ?></td>
                <td><?php echo $dAdicional["fecha_ingreso"] ?></td>
                <td><?php echo $dAdicional["cod_colaborador"]; ?></td>
                <td><?php echo $data["correo"]; ?></td>
                <td><?php echo $dCargo["nombre"]; ?></td>
                <td><?php echo $dNivel["nombre"]; ?></td>
                <td><?php echo $dArea["nombre"]; ?></td>
                <td><?php echo $dGerencias["nombre"]; ?></td>
				
                <td><?php echo $dEquipo["nombre"]; ?></td>
				
                <td><?php echo $dAdicional["cliente"]; ?></td>
                <td><?php echo $dAdicional["dr_cliente"]; ?></td>
                <td><?php echo $dAdicional["correo_ou"]; ?></td>
                <td><?php echo $dAdicional["h_servicio"]; ?></td>
                <td><?php echo $txt_Dotacion_aplica; ?></td>
                <td><?php echo $dAdicional["r_social"]; ?></td>
                <td><?php echo $dAdicional["dr_fisica"]; ?></td>
                <td><?php echo $dAdicional["rut"]; ?></td>
                <td><?php echo $dAdicional["banco"]; ?></td>
                <td><?php echo $dAdicional["t_cuenta"]; ?></td>
                <td><?php echo $dAdicional["cuenta"]; ?></td>
                <td><?php echo $dAdicional["afap"]; ?></td>
                <td><?php echo $dAdicional["c_profesional"]; ?></td>
                <td><?php echo $dAdicional["fv_docu"]; ?></td>
                <td><?php echo $dAdicional["talla_remera"]; ?></td>
                <td><?php echo $dAdicional["modelo"]; ?></td>
                <td><?php echo $dAdicional["color"]; ?></td>
                <td><?php echo $dAdicional["comentario"]; ?></td>
                <td><?php echo $txt_Pais_Residencia; ?></td>
                <td><?php echo $dAdicional["departamento_otro"]; ?></td>
                <td><?php echo $dAdicional["ciudad_otro"]; ?></td>
                <td><?php echo $txt_Departamento_Residencia; ?></td>
                <td><?php echo $txt_Ciudad_Residencia; ?></td>
                <td><?php echo $dAdicional["direccion"]; ?></td>
                <td><?php echo $dAdicional["cd_postal"]; ?></td>
                <td><?php echo $dAdicional["telefono"]; ?></td>
                <td><?php echo $dAdicional["celular"]; ?></td>
                <td><?php echo $dAdicional["email_p"]; ?></td>
                
                <td><?php echo $dPerfil["eps"]; ?></td>
                <td><?php echo $dPerfil["afp"]; ?></td>
                <td><?php echo $dPerfil["emergencia"]; ?></td>
                <td><?php echo $dPerfil["car_salud"]; ?></td>
                <td><?php echo $dPerfil["apt_fisica"]; ?></td>
                <td><?php echo $dPerfil["patologias"]; ?></td>
                <td><?php echo $dPerfil["alergias"]; ?></td>
                <td><?php echo $dPerfil["formula_optica"]; ?></td>
                <td><?php echo $dPerfil["audifonos"]; ?></td>
                <td><?php echo $dPerfil["otros"]; ?></td>
                <td><?php echo $dPerfil["comensal"]; ?></td>
                <td><?php echo $dPerfil["restriccion"]; ?></td>
                <td><?php echo $dPerfil["fumas"]; ?></td>
                <td><?php echo $dPerfil["deportes"]; ?></td>
                <td><?php echo $dPerfil["frecuencia"]; ?></td>
                <td><?php echo $dPerfil["hobbies"]; ?></td>
                <td><?php echo $dPerfil["comentario_tl"]; ?></td>
                <td><?php echo $dPerfil["distancia"]; ?></td>
                <td><?php echo $dPerfil["vehiculo_propio"]; ?></td>
                <td><?php echo $txt_Desplazamiento; ?></td>
                <td><?php echo $dPerfil["licencia_conduccion"]; ?></td>
                <td><?php echo $dPerfil["fecha_libreta"]; ?></td>
                <td><?php echo $dPerfil["matricula"]; ?></td>
                <td><?php echo $dPerfil["otros_comentarios"]; ?></td>
                
                <td><?php echo $txt_Voluntariado; ?></td>
                <td><?php echo $dPreferencias["opciones_voluntariado"]; ?></td>
                <td><?php echo $dPreferencias["apoyo"]; ?></td>
                <td><?php echo $dPreferencias["conocimiento"]; ?></td>
                
                <td><?php echo $dAcademico["titulo"]; ?></td>
                <td><?php echo $dAcademico["nivel"]; ?></td>
                <td><?php echo $dAcademico["nivel_idiomas"]; ?></td>
                <td><?php echo $dAcademico["area_conocimiento"]; ?></td>
                <td><?php echo $dAcademico["entidad"]; ?></td>
                <td><?php echo $dAcademico["fecha_titulo"]; ?></td>
                <td><?php echo $dAcademico["tarjeta_profesional"]; ?></td>
                <td><?php echo $dAcademico["en_curso"]; ?></td>
                <td><?php echo $dAcademico["estudia_actualmente"]; ?></td>
                
                <td><?php echo $dLaboral["entidad"]; ?></td>
                <td><?php echo $dLaboral["cargo"]; ?></td>
                <td><?php echo $dLaboral["sector"]; ?></td>
                <td><?php echo $dLaboral["fecha_inicio"]; ?></td>
                <td><?php echo $dLaboral["fecha_fin"]; ?></td>
                <td><?php echo $dLaboral["pais"]; ?></td>
                <td><?php echo $dLaboral["ciudad"]; ?></td>
                <td><?php echo $dLaboral["experiencia"]; ?></td>
                
                <td><?php echo $dTrayectoria["cargo"]; ?></td>
                <td><?php echo $dTrayectoria["fecha_inicia"]; ?></td>
                <td><?php echo $dTrayectoria["fecha_fin"]; ?></td>
                <td><?php echo $dTrayectoria["vigente"]; ?></td>
                <td><?php echo $dTrayectoria["resumen"]; ?></td>
                
                <td><?php echo $dFamiliares["conyuge"]; ?></td>
                <td><?php echo $txt_Familiaresconyugedoc; ?></td>
                <td><?php echo $dFamiliares["numero_dcunyuge"]; ?></td>
                <td><?php echo $dFamiliares["fecha_conyuge"]; ?></td>
                <td><?php echo $dHijos["numero_hijos"]; ?></td>
                <td><?php echo $dHijos["cantidad_hijo"]; ?></td>
                <td><?php echo $dHijos["nombre_hijo"]; ?></td>
                <td><?php echo $dHijos["documento_hijo"]; ?></td>
                <td><?php echo $dHijos["numero_hijo"]; ?></td>
                <td><?php echo $dHijos["fecha_hijo"]; ?></td>
                <td><?php echo $dHijos["edadh"]; ?></td>
                <td><?php echo $dFamiliares["parentesco"]; ?></td>
                <td><?php echo $dFamiliares["otros"]; ?></td>
                <td><?php echo $dFamiliares["nombre"]; ?></td>
                <td><?php echo $txt_Familiaresdoc; ?></td>
                <td><?php echo $dFamiliares["fecha_nace"]; ?></td>
                <td><?php echo $dFamiliares["convives"]; ?></td>
                <td><?php echo $dFamiliares["mascotas"]; ?></td>
                <td><?php echo $dFamiliares["cuidado_especial"]; ?></td>
                <td><?php echo $txt_Familiares; ?></td>
                
                <td><?php echo $dEmergencia["nombres1"]; ?></td>
                <td><?php echo $dEmergencia["parentezco1"]; ?></td>
                <td><?php echo $dEmergencia["telefono1"]; ?></td>
                <td><?php echo $dEmergencia["direccion1"]; ?></td>
                <td><?php echo $dEmergencia["nombres2"]; ?></td>
                <td><?php echo $dEmergencia["parentezco2"]; ?></td>
                <td><?php echo $dEmergencia["telefono2"]; ?></td>
                <td><?php echo $dEmergencia["direccion2"]; ?></td>
                <td><?php echo $dEmergencia["nombres3"]; ?></td>
                <td><?php echo $dEmergencia["parentezco3"]; ?></td>
                <td><?php echo $dEmergencia["telefono3"]; ?></td>
                <td><?php echo $dEmergencia["direccion3"]; ?></td>
                
                <td><?php echo $dRemuneracion["salario"]; ?></td>
                <td><?php echo $dRemuneracion["tickets"]; ?></td>
                <td><?php echo $dRemuneracion["comision_out"]; ?></td>
                <td><?php echo $dRemuneracion["comision_back"]; ?></td>
                <td><?php echo $dRemuneracion["comision_ventas"]; ?></td>
                <td><?php echo $dRemuneracion["comision_ventas_dls"]; ?></td>
                <td><?php echo $dRemuneracion["viaticos"]; ?></td>
                <td><?php echo $dRemuneracion["prima_antiguedad"]; ?></td>
                <td><?php echo $dRemuneracion["horas_extra"]; ?></td>
                <td><?php echo $dRemuneracion["guardia"]; ?></td>
                <td><?php echo $dRemuneracion["guardia_var"]; ?></td>
                <td><?php echo $dRemuneracion["canasta"]; ?></td>
                <td><?php echo $dRemuneracion["bono"]; ?></td>
                <td><?php echo $dRemuneracion["comision_otro"]; ?></td>
                <td><?php echo $dRemuneracion["otro"]; ?></td>
				<td>Inactivo</td>
                <td><?php echo $data["fecha_inactivacion"]; ?></td>
                <td><?php echo $data["observaciones_inactivacion"]; ?></td>
                <td><?php echo $data["motivo_retiro"]; ?></td>
            </tr> 
            
        <?php 
                //TERMINA LA IMPRESION DE LAS FILAS
                    $count++; 
                }
            }
        ?>
	
			
			
			
			
			
			
		
        </tbody>
    </table>    
    
</body>
</html>

<script>
function exportarReporte(){
	$("#datos_a_enviar").val( $("<div>").append( $("#tabla_reporte").eq(0).clone()).html());
	$("#FormularioExportacion").submit();
}
</script>




