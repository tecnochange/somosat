<?php
$Array_estado_Periodo = array(
	array("1","En creación", "#2196f3"),
	array("2","Creación En Aprobación ", "#ff9800"),
	array("3","En seguimiento", "#cddc39" ),
	array("4","En creacion - No aprobado por Jefe", "#b53ab7"),
    array("5","En Seguimiento Por Aprobación", "#9e9e9e"), 
    array("6","Seguimiento Aprobados", "#009688" ),
    array("7","Seguimiento No Aprobado", "#673ab7")
);
$Array_estado_seguimiento_retro = array(
	array("1","En creación", "#2196f3"),
	array("2","Terminado", "#ff9800"), 
    array("3","Terminado - Seguimiento", "#ff9800"),
	
);
$lista_estado_objetivos = array(
	array("3","Aprobar"),
	array("4","No Aprobado") 
);
$lista_estado_objetivos_Final = array(
	array("6","Aprobar Final"),
	array("7","No Aprobado Final") 
);
$Escala_objetivos_periodo = array(
	array("30","Inaceptable"),
	array("4","Rechazar") 
);

$lista_escolaridad = array(
	"ninguno",
	"primaria incompleta",
	"primaria completa",
	"bachillerato incompleto",
	"bachillerato completo",
	"estudiante universitario",
	"profesional universitario",
	"técnico",
	"tecnológo",
	"estudiante de carrera técnica",
	"estudiante de carrera tecnológica",
	"postgrado",
	"segundo postgrado",
	"estudiante de postgrado",
	"maestría",
	"estudiante maestría",
	"Doctorado",
	"estudiante doctorado"
);

$lista_dependen = array(
		"ninguna",
		"1",
		"2",
		"3",
		"4",
		"5",
		"6",
		"7",
		"8",
		"9",
		"10",
		"más de 10"
);

$lista_tiempo_laborado = array(
		"menos de 6 meses",
		"6 meses",
		"1 año",
		"1 y medio años",
		"2 años",
		"2 y medio años",
		"tres años",
		"3 y medio años",
		"4 años",
		"4 y medio años",
		"5 años",
		"6 años",
		"6 y medio años",
		"7 años",
		"7 años y medio",
		"8 años",
		"8 años y medio",
		"9 años",
		"9 años y medio",
		"10 años",
		"más de 10 años."
);

$lista_cargo = array(
		"Gerencia alta",
		"Gerencia media",
		"Jefatura",
		"Coordinación",
		"Supervisión",
		"Profesional",
		"Tecnologo",
		"Técnico",
		"Administrativo",
		"Auxilliar",
		"Operario"
); 

$lista_contrato = array(
		"Contrato directo a termino indefinido",
		"contrato directo a termino fijo",
		"contrato temporal",
		"contrato por servicios",
		"contrato por mano de obra",
		"contrato por maquila",
		"Rotativo en turnos",
		"contrato por horas"
);

$lista_horario = array(
    "7 a.m. a 5 p.m.",
    "7 a.m. a 6 p.m.",
    "8 a.m. a 5 p.m.",	
    "8 a.m. a 6 p.m.",
    "otro..."
);

$Array_Dimesiones_Desempenio = array(
	array("1","Cumplimiento de metas"),
	array("2","Excelencia Operativa"),
	array("3","Fidelización del Asociado"),
	array("4","Transformación Digital"),
	array("5","Desarrollo del Personal"), 
    array("6","Balance Social y Sostenibilidad"),
);

$Array_Nivel_Academico = array(
	array("1","Primaria"),
	array("2","Bachillerato"),
	array("3","Técnico"),
	array("4","Tecnólogo"),
	array("5","Profesional"), 
    array("6","Profesional con Posgrado"), 
    array("7","Maestria"), 
    array("8","Doctorado"), 
    array("9","PosDoctorado"), 
    array("10","Pregrado"), 
);

$Array_Estado = array(
	array("1","Activo"),
	array("2","Inactivo"),
);

$Array_Anio = array(
	array("2020","2020"),
	array("2021","2021"),
);

$Array_Jerarquia = array(
	array("0","Generla"),
    array("1","Nivel 1"),
	array("2","Nivel 2"),
    array("3","Nivel 3"),
    array("4","Nivel 4"),
    array("5","Nivel 5"),
    array("6","Nivel 6"),
    array("7","Nivel 7")
);

$Array_Nivel_Cargo = array(  // nivel jerarquico
	array("1","Alta Gerencia"),
	array("2","Auxiliares / Operativos /Asesores"),
    array("3","Dirección"), 
    array("4","Gerencia General"), 
    array("5","Gerencia Media"), 
    array("6","Jefes / Coordinadores / supervisores"),
    array("7","Profesionales / Analistas / Asesores"),  
);

$Array_Nivel_Organizacional = array(
	array("1","Apoyo"),
	array("2","Contribuidor Individual"),
    array("3","Contribuidor Operativo"), 
    array("4","Depende"), 
    array("5","Líder Estratégico"), 
    array("6","Líder Táctico")  
);

$Array_Genero = array(
	array("1","Hombre"),
	array("2","Mujer")
);

$Array_Tipo_Contrato = array(
	array("1","Termino Indefinido"),
    array("2","Termino Fijo"),
	array("3","Prestacion de Servicios"),
    array("4","Contratado por Tercero"), 
    array("5","Makila"),
    array("6","Temporal"),
    array("7","Otros")
);

$Array_Role = array(
	array("1","Administrador Empresa"),
    array("2","Jefe"),
	array("3","Usuario"),
	array("4","Cliente Externo")
);

$Array_Role_Seleccion = array(
	array("0","Sin Role"),
    array("1","Administrador"),
    array("3","Seleccionador"),
	array("2","Cliente interno"),
    array("4","Cliente interno Aprobaciones"),
	
	/*array("5","Usuario Baterías")*/
);

$Array_Solicitudes = array(
	array("1","Permiso de ausencia"),
    array("2","Solicitud vacaciones"),
    array("3","Legalización de incapacidad"),
    array("4","Certificacion laboral"),
    array("5","Certificacion de Seguridad social"),
    array("6","Carta o Acta de renuncia"),
    array("7","Envío de desprendible de nómina"),
    
);

$Array_Estado_Solicitudes = array(
	array("1","Recibido"),
	array("2","Verificada"),
    array("3","Respondida"),
    array("4","Cerrada")
);

$Array_Tipo_Documento_Carga = array(
	array("1","Legal"),
	array("2","Administrativo"),
    array("3","Contratación"),
    array("4","Soporte"),
    array("5","Historial Laboral"),
    array("6","Hoja de Vida"),
    array("7","Otros")
);

$Array_Tipo_Documento_Consulta = array(
	array("1","Normativo"),
	array("2","Política"),
    array("3","Proceso"),
    array("4","Procedimiento"),
    array("5","Estandar"),
    array("6","Guías"),
    array("7","Protocolo"), 
    array("8","Otros"), 
);













$Lista_Si_No = array(
	array("1","Si"),
	array("2","No"),
);



$Lista_Rol_Empleados = array(
	array("1","Administrador"),
	array("2","Cliente interno")
);


$Lista_Letra = array(
	array("C","C"),
	array("D","D"),
	array("I","I"),
	array("S","S")
);

$Lista_Estilos = array(
	array("1","DINÁMICO - ACTIVO"),
	array("2","EMOTIVO - RELACIONAL"),
	array("3","ANALÍTICO - RACIONAL"),
	array("4","CREATIVO - INTUITIVO")
);

$Lista_Posicion = array(
	array("a","a"),
	array("b","b"),
	array("c","c"),
	array("d","d")
);

$Lista_Letra_Nego = array(
	array("a","a"),
	array("b","b")
);

$Lista_Interes = array(
	array("1","Interes 1"),
	array("2","Interes 2"),
	array("3","Interes 3"),
	array("4","Interes 4")
);



$Lista_Perfil_Ideal = array(
	array("","Selecciona.."),
	array("1","Básico"),
	array("2","Inicial"),
	array("3","Intermedio"),
	array("4","Avanzado")
);

$Lista_Tipo_Doc = array(
	array("1","Cédula de ciudadanía"),
	array("2","Cédula Extrajeria"),
	array("3","Nit")
);

$Lista_Tipo_Docu = array(
    array("1","Registro Civil"),
	array("2","Tarjeta Identidad"),
	array("3","Cédula de ciudadanía"),
	array("4","Cédula Extrajeria"),
	array("5","Nit")
);

$Lista_Nivel_Competencia = array(
	array("1","Gestión"),
	array("2","Soporte/Operativo"),
	array("3","Táctico")
);

//ESTILOS TÁCTICOS
$Estilos_Tacticos = array(
	array("1","DINÁMICO - ACTIVO"),
	array("2","EMOTIVO - RELACIONAL"),
	array("3","ANALÍTICO - RACIONAL"), 
	array("4","CREATIVO - INTUITIVO")
);

//ESTILOS TÁCTICOS
$Estilos_Gestion = array(
	array("I","Relacional - Influyete"),
	array("C","Analítico - Cautelozo"),
	array("D","Impulsor - Director"), 
	array("S","Seguridad - Estabilidad")
);

//ESTILOS NEGOCIACION
$Estilos_Negociacion = array(
	array("1","COMPROMETIDO"),
	array("2","COLABORADOR  - COOPERADOR"),
	array("3","CESIÓN"), 
	array("4","EVASIVO - AMBIGUO"),
	array("5","COMPETIDOR")
);

//ESTILOS TÁCTICOS
$Estilos_Motivacional = array(
	array("1","TÉCNICO - CIENTÍFICO"),
	array("2","GERENCIA GENERAL - DIRECCIÓN"),
	array("3","AUTONOMÍA - INDEPENDENCIA"), 
	array("4","SEGURIDAD - ESTABILIDAD"),
	array("5","CREATIVIDAD EMPRESARIAL"),
	array("6","SERVICIO DEDICACIÓN A UNA CAUSA"),
	array("7","EXCLUSIVAMENTE RETO"), 
	array("8","EQUILIBRIO DE VIDA")
);

$Lista_Activo_Estado = array(
	array("1","Activar"),
	array("0","Inactivo")
);

$Lista_Calificacion = array(
	array("0","0"),
	array("1","1"),
	array("2","2"),
	array("3","3"),
	array("3.5","3.5"),
	array("4","4"),
	array("5","5"),
	array("5.5","5.5"),
	array("6","6"),
	array("6.5","6.5"),
	array("7","7"),
	array("7.5","7.5"),
	array("8","8"),
	array("8.5","8.5"),
	array("9","9"),
	array("9.5","9.5"),
	array("10","10")
); 

$Como_se_entero = array(
	array("1","Página WEB de Estilo"),
	array("2","Computrabajo"),
	array("3","El empleo"),
	array("4","Linkedin"),
	array("5","Referido por trabajador de Estilo"),
    array("6","Otro")
);

$Rol_Familia = array(
	array("1","Padre"),
	array("2","Madre"),
	array("3","Padre cabeza de familia"),
	array("4","Madre cabeza de familia"),
	array("5","Padre Soltero"),
	array("6","Madre Soltera"),
	array("7","Hijo"),
	array("8","Hija"),
	array("9","Otro")
);

$Estado_Civil = array(
	array("1","Soltero"),
	array("2","Casado(a)"),
	array("6","Union Libre"),
	array("3","Separado(a)"),
	array("4","Viudo"),
	array("5","Pareja estable")
);

$lista_vivienda = array(
		"Propia",
		"arrendada",
		"de los padres",
		"de un familiar",
		"de un amigo",
		"otra"
);

$Comportamentales = array(
	array("1","Comportamenta Gestión"),
	array("2","Comportamenta Comercial"),
	array("3","Comportamenta Tácticos")
);

$Array_Recomienda = array(
	array("1","Se recomienda"),
	array("2","Segunda opción"),
	array("3","Se recomienda con observaciones"), 
	array("4","No se recomienda") 
	
);


$Array_estado_preentrevista = array(
	array("3","Aprobar Candidato"),
	array("4","Rechazar Candidato")
);

$Array_estado_solicitud = array(
	array("2","Aprobado"),
	array("3","Rechazado")
);

$array_no_colaboradores= array(
	array("100","100"),
	array("200","200"), 
    array("300","300"), 
    array("400","400"), 
    array("500","500"), 
    array("600","600"), 
    array("700","700"), 
    array("800","800"), 
    array("900","900"), 
    array("1000","1000"), 
    array("1001","Ilimitado"), 
);


$array_Tipo_Colaborador = array(
	array("1","Auto"),
	array("2","Par"), 
    array("3","Colaborador"), 
    array("4","Cliente"),
    array("5","Jefe")
);

$Porciento_Actividad = array(
	array(0,"0%"),
	array(5,"5%"),
	array(10,"10%"),
	array(15,"15%"),
	array(20,"20%"),
	array(25,"25%"),
	array(30,"30%"),
	array(35,"35%"),
	array(40,"40%"), 
	array(45,"45%"),
	array(50,"50%"),
	array(55,"55%"),
	array(60,"60%"),
	array(65,"65%"),
	array(70,"70%"),
	array(75,"75%"),
	array(80,"80%"),
	array(85,"85%"),
	array(90,"90%"),
	array(95,"95%"), 
	array(100,"100%")
);

/*TRABAJO REMOTO*/
$Lista_Role = array(
	array("1","Lider Directivo",'#4CAF50'),
	array("2","Lider Táctico",'#007bff'),
	array("3","Colaborador",'#f44336'), 
	array("4","Invitado Cliente",'#f44336')		
);


/*TRABAJO REMOTO*/
$Lista_Role_Virtual = array(
	array("1","Lider de proyecto",'#4CAF50'),
	array("2","Participante de proyecto",'#007bff'),	
);


$Array_Aspiracion_Salarial = array(
    array("1","Salario mínimo"), 
    array("2","Entre 1 y 1.5 millones"), 
    array("3","Entre 1.5 y 2 millones"),
    array("4","Entre 2 y 2.5 millones"), 
    array("5","Entre 2.5 y 3 millones"), 
    array("6","Entre 3 y 3.5 millones"), 
    array("7","Entre 3.5 y 4 millones"), 
    array("8","Entre 4 y 4.5 millones"), 
    array("9","Entre 4.5 y 5 millones"), 
    array("10","Entre 5 y 5.5 millones"), 
    array("11","Entre 5.5 y 6 millones"), 
    array("12","Entre 6 y 6.5 millones"), 
    array("13","Entre 6.5 y 7 millones"), 
    array("14","Entre 7 y 7.5 millones"), 
    array("15","Entre 7.5 y 8 millones"), 
    array("16","Entre 8 y 8.5 millones"), 
    array("17","Entre 8.5 y 9 millones"), 
    array("18","Entre 9 y 9.5 millones"), 
    array("19","Entre 9.5 y 10 millones"), 
    array("20","Entre 10 y 11 millones"), 
    array("21","Entre 11 y 12 millones"), 
    array("22","Entre 12 y 14 millones"), 
    array("23","Entre 14 y 16 millones"), 
     array("24","Entre 16 y 18 millones"), 
    array("25","Entre 18 y 20 millones"), 
    array("26","Entre 20 y 23 millones"), 
    array("27","Entre 23 y 26 millones"), 
    array("28","Entre 26 y 30 millones"), 
    array("29","Más de 30 millones")
);

$Array_Nivel_Educativo = array(
    array("1","Primaria"),
    array("2","Secundaria"),
    array("5","Técnico o Tecnólogo "),
    array("7","Universitario"),
    array("9","Especialización"),
    array("10","Maestría"), 
    array("11","Doctorado / Posdoct") 
);

$Array_Experiencia_laboral = array(
    array("1","Menos de 1 años"),
    array("2","de 1 a 3 años"),
    array("3","de 3 a 5 años"),
    array("4","de 5 a 7 años"),
    array("5","7 a 10 años"),
    array("6","10 a 13 años"),
    array("7","13 a 16 años"),
    array("8","16 a 20 años"),
    array("9","Más de 20 años")
);


$Array_Estado_Vacante = array(
    array("1","Registrada, Sin Publicar", "#f44336"),
    array("2","Publicada sin candidatos", "#607d8b"),
    array("3","Publicada con candidato", "#607d8b"),
    array("4","Candidatos preseleccionados", "#607d8b"),
    array("5","Candidatos en evaluación", "#607d8b")
);


$Array_Tipo_Proceso = array(
    array("1","Interna"), 
    array("2","Externa"),
    array("3","Interna / Externa"), 
);

$Array_Estado_Prescanig = array(
	array("1","Aprobar Candidato"),
	array("2","Rechazar Candidato")
);

$Array_calificacion_Situacional = array(
	array("1","1"),
	array("2","2"),
	array("3","3"),
    array("3.5","3.5"),
    
    array("4","4"),
    array("4.5","4.5"),
    array("5","5"),
    array("5.5","5.5"),
    array("6","6"),
    array("6.5","6.5"),
    array("7","7"),
    array("7.5","7.5"),
    array("8","8"),
    array("8.5","8.5"),
    array("9","9"),
    array("9.5","9.5"),
    array("10","10") 
);

$Array_estado_entrevista_aprobacion = array(
	array("3","Aprobar Candidato"),
	array("4","Rechazar Candidato")
);

$Array_Estado_Baterias = array(
    array("1","Sin Iniciar", '#FF5722' ),
	array("2","En proceso", '#ff9800'),
    array("3","Terminada", '#28a745'),
    array("4","Aprobado", '#03A9F4'), 
    array("5","Rechazado", '#9E9E9E'), 
);

$Array_Estado_P_Tecnias = array(
    array("1","Sin Iniciar", '#FF5722' ),
	array("2","En proceso", '#ff9800'),
    array("3","Aprobado", '#03A9F4'), 
    array("4","Rechazado", '#9E9E9E'), 
);

$Array_Estado_P_Situacional = array(
    array("1","Sin Iniciar", '#FF5722' ),
	array("2","En proceso", '#ff9800'),
    array("3","Aprobado", '#03A9F4'), 
    array("4","Rechazado", '#9E9E9E'), 
);

$Array_Estado_Entrevista = array(
    array("1","Sin Iniciar", '#FF5722' ),
	array("2","En proceso", '#ff9800'),
    array("3","Aprobado", '#03A9F4'), 
    array("4","Rechazado", '#9E9E9E'), 
);

$Array_Estado_Seguridad = array(
    array("1","Sin Iniciar", '#FF5722' ),
	array("2","En proceso", '#ff9800'),
    array("3","Aprobado", '#03A9F4'), 
    array("4","Rechazado", '#9E9E9E'), 
);

$Array_Contratar = array(
    array("1","Contratar Candidato", '#FF5722' ),
	array("2","Rechazar y Agradecer", '#ff9800'), 
);

$Array_Origen_Vacante = array(
    array("","- Ninguno -" ),
    array("1","Posición nueva" ),	 
    array("2","Cargo nuevo" ),
    array("3","Renuncia" ),
    array("4","Mutuo acuerdo" ), 
    array("5","Retiro con justa causa" ), 
    array("6","Retiro sin justa causa " ),
    array("7","Ascenso" ), 
    array("8","Traslado" ), 
    array("9","Doble posición" ), 
    array("10","Destemporalización" ), 


);

$Array_Tipo_Contrato_Requisicion = array(
    array("","- Ninguno -" ),
    array("1","Aprendizaje" ),
    array("2","Obra o labor" ),
    array("3","Ocasional de trabajo" ),
    array("4","Prestación de servicios" ),
    array("5","Término Fijo" ),
    array("6","Término indefinido" ),
);

$Array_Nesecidad = array(
    array("","- Ninguno -" ),
    array("1","Reemplazo" ),
    array("2","Proyecto" )
);

$Array_Autorizar = array(
    array("1", "Pendiente"),
	array("2","Autorizada"),
	array("3","Rechazada"),
);

$Array_Estado_Requisiciones = array(
	array("1","Pendiente Aprobaciones"),
    array("2","Autorizada"),
	array("3","Rechazada por autorizador"),
);

//--------------------
$Array_Tipo_Doc_Empleado = array(
	array("C","Cedula de Ciudadania"),
    array("E","Cedula de Extrangeria"),
	array("P","Pasaporte"),
);

$Array_Sexo_Empleado = array(
	array("F","Femenino"),
    array("M","Masculino")
);

$Array_Meses = array(
	array("2","Feb"), 
    array("3","Mar"), 
    array("4","Abr"), 
    array("5","May"), 
    array("6","Jun"), 
    array("7","Jul"), 
    array("8","Ago"), 
    array("9","Sep"), 
    array("10","Oct"), 
    array("11","Nov"), 
    array("12","Dic"), 
    array("1","Ene"),
);

$Array_Empresas_Lista = array(
	array("1","ALTIPAL"),
    array("2","TEMPORAL EFICACIA"),
    array("3","TEMPORAL MANPOWER DE COLOMBIA LTDA"),
    array("4","TEMPORAL NASES EST S.A.S"),
    array("5","TEMPORAL OSYA"),
    array("6","VACANTE"),
);

$Array_Valoracion_Excelencia = array(
	array("0,5","0.5"),
    array("1","1"),
    array("1,5","1.5"),
    array("2","2"),
    array("2,5","2.5"),
    array("3","3"),
    array("3,5","3.5"),
    array("4","4")
);


//COLABORADORES
$Array_Sexo_Biologico = array(
	array("1","MASCULINO"),
    array("2","FEMENINO")
);


$Array_Tipo_Contratos = array(
	array("1","Temporal"),
    array("2","Proyecto"),
    array("3","Termino Fijo < 1 año"),
    array("4","Término indefinido"),
    array("5","Aprendiz Etapa Lectiva"),
    array("6","Aprendiz Etapa Productiva"),
    array("7","Pasante Universitario")
);

$Array_Tipo_Salario = array(
	array("1","Integral"),
    array("2","No aplica"),
    array("3","Normal")
);

$Array_salario_flexibilizado = array(
	array("1","Si"),
    array("2","No")
);

$Array_Talla_Camisa = array(
	array("1","S"),
    array("2","M"),
    array("3","L"),
    array("4","XL"),
    array("5","XXL"),
    array("6","XXXL")
);

$Array_Talla_Zapatos = array(
	array("1","34"),
    array("2","35"),
    array("3","36"),
    array("4","37"),
    array("5","38"),
    array("6","39"),
    array("7","40"),
    array("8","41"),
    array("9","42"),
    array("10","43"),
    array("11","44"),
    array("12","45"),
    array("13","46")
);

$Array_Talla_Pantalon = array(
	array("1","4"),
    array("2","6"),
    array("3","8"),
    array("4","10"),
    array("5","12"),
    array("6","14"),
    array("7","16")
);

$Array_Talla_Overol = array(
	array("1","36"),
    array("2","38"),
    array("3","40"),
    array("4","42"),
    array("5","44"),
    array("6","46"),
    array("7","48")
);

$Array_Talla_Chaqueta = array(
	array("1","S"),
    array("2","M"),
    array("3","L"),
    array("4","XL"),
    array("5","XXL"),
    array("6","XXXL")
);

$Array_Talla_Jean = array(
	array("1","28"),
    array("2","30"),
    array("3","32"),
    array("4","34"),
    array("5","36"),
    array("6","38"),
    array("7","40"),
    array("8","42")
);

$Array_Talla_Guantes = array(
	array("1","S"),
    array("2","M"),
    array("3","L"),
    array("4","XL")
);

$Array_Grupo_Sanguineo = array(
	array("1","A"),
    array("2","B"),
    array("3","AB"),
    array("4","O")
);

$Array_Factor = array(
	array("1","+"),
    array("2","-")
);

$Array_Tipo_vivienda_1 = array(
	array("1","PROPIA"),
    array("2","ARRENDADA"),
    array("3","FAMILIAR")
);

$Array_Tipo_vivienda_2 = array(
	array("1","RURAL"),
    array("2","URBANA")
);

$Array_vivienda = array(
	array("1","Casa"),
    array("2","Apartamento"),
    array("3","Casalote"),
    array("4","Habitación"),
    array("5","Finca"),
    array("6","Inquilinato")
);

$Array_servicios = array(
	array("1","Acueducto"),
    array("2","Teléfono"),
    array("3","Gas"),
    array("4","Energía"),
    array("5","Alcantarillado"),
    array("6","Internet")
);

$Array_gastos = array(
	array("1","Solo"),
    array("2","En pareja"),
    array("3","En familia")
);

$Array_Mascotas = array(
	array("1","Perro"),
    array("2","Ave"),
    array("3","Otros"),
    array("4","Gato"),
    array("5","Pez"),
    array("6","No aplica")
);

$Array_Convives = array(
	array("1","Madre"),
    array("2","Nietos"),
    array("3","Novi@"),
    array("4","Padre"),
    array("5","Abuelos"),
    array("6","Primos"),
    array("7","Solo"),
    array("8","Hijos"),
    array("9","Mascotas"),
    array("10","Sobrinos"),
    array("11","Hermanos"),
    array("12","Tíos"),
    array("13","Amigos"),
    array("14","Espos@")
);

$Array_tenencia = array(
	array("1","Propia"),
    array("2","Arrendada"),
    array("3","Cedida"),
    array("4","Alquilada"),
    array("5","Familiar")
);

$Array_Condiciones_Vivienda = array(
	array("1","OBRA GRIS"),
    array("2","TERMINADA")
);

$Array_Condicion_Vivienda = array(
	array("1","Terminada"),
    array("2","Obra Gris"),
    array("3","En construcción"),
    array("4","En remodelación")
);

$Array_Material_Predominante = array(
	array("1","Material Firme"),
    array("2","Material firme tejados en zinc"),
    array("3","Material firme tejados en plastico"),
    array("4","Pre fabricada")
);

$Array_Material_Pisos = array(
	array("1","Baldosa"),
    array("2","Laminado"),
    array("3","Cemento"),
    array("4","Tierra"),
    array("5","Madera"),
    array("6","Porcelanato")
);

$Array_Tiempo_Libre = array(
	array("1","Ninguno"),
    array("2","Compartir con amigos"),
    array("3","Otro"),
    array("4","Baile"),
    array("5","Canto"),
    array("6","Lectura"),
    array("7","Viajar"),
    array("8","Deportes"),
    array("9","Interpretar un instrumento artístico"),
    array("10","Artes"),
    array("11","Cine"),
    array("12","Tiempo en familia"),
    array("13","Video juegos")
);

$Array_Elementos = array(
	array("1","Lavamanos"),
    array("2","Sanitario"),
    array("3","Ducha")
);

$Array_Material_Baño = array(
	array("1","Enchapado"),
    array("2","Sin enchapar")
);

$Array_Adquirir_Vivienda = array(
	array("1","Si"),
    array("2","No")
);

$Array_Cabeza_familia = array(
	array("1","Si"),
    array("2","No")
);

$Array_Credito_Vivienda = array(
	array("1","Si"),
    array("2","No")
);

$Array_Mejora_Locativa = array(
	array("1","Si"),
    array("2","No")
);

$Array_Credito_Vehiculos = array(
	array("1","Si"),
    array("2","No")
);

$Array_Internet = array(
	array("1","Si"),
    array("2","No")
);

$Array_Computadora = array(
	array("1","Si"),
    array("2","No")
);

$Array_Vehiculo_Propio = array(
	array("1","Carro"),
    array("2","Moto"),
    array("3","Bicicleta"),
    array("4","Ninguno")
);


$Array_Estratos = array(
	array("1","1"),
    array("2","2"),
    array("3","3"),
    array("4","4"),
    array("5","5"),
    array("6","6")
);

$Array_Departamento_Nacimiento = array(
	array("1","ALAJUELA"),
    array("2","ANTIOQUIA"),
    array("3","ARAUCA"),
    array("4","ATLÁNTICO"),
    array("5","BOCAS DEL TORO"),
    array("6","BOLÍVAR"),
    array("7","BOYACÁ"),
    array("8","CALDAS"),
    array("9","CAQUETÁ"),
    array("10","CARTAGO"),
    array("11","CASANARE"),
    array("12","CAUCA"),
    array("13","CESAR"),
    array("14","CHINANDEGA"),
    array("15","CHIRIQUI"),
    array("16","CHOCÓ"),
    array("17","COCLE"),
    array("18","COLOMBIA"),
    array("19","COLON"),
    array("20","CÓRDOBA"),
    array("21","CUNDINAMARCA"),
    array("22","DARIEN"),
    array("23","DESAMPARADOS"),
    array("24","GUANACASTE"),
    array("25","HERRERA"),
    array("26","HUILA"),
    array("27","LA GUAJIRA"),
    array("28","LIMÓN"),
    array("29","LOS SANTOS"),
    array("30","MAGDALENA"),
    array("31","MARACAIBO"),
    array("32","META"),
    array("33","NARIÑO"),
    array("34","NICARAGUA"),
    array("35","NORTE DE SANTANDER"),
    array("36","PANAMA"),
    array("37","PUNTARENAS"),
    array("38","PUTUMAYO"),
    array("39","QUINDÍO"),
    array("40","RISARALDA"),
    array("41","SAN JOSE"),
    array("42","SANTANDER"),
    array("43","SUCRE"),
    array("44","TOLIMA"),
    array("45","VALLE DEL CAUCA"),
    array("46","VERAGUAS")
);

$Array_Pais_Nac = array(
	array("1","COLOMBIA"),
    array("2","COSTA RICA"),
	array("3","PANAMÁ"), 
    array("4","NICARAGUA"),
    array("5","VENEZUELA")
);

$Array_Nacionalidad = array(
	array("1","COLOMBIANO"),
    array("2","COSTARICENSE"),
    array("3","NICARAGUENSE"),
    array("4","PANAMEÑO"),
    array("5","VENEZOLANO")
);


$Array_Ciudad_Nacimiento = array(
	array("1","AGUACHICA"),
    array("2","ALAJUELA"),
    array("3","ALBANIA"),
    array("4","ALEJANDRIA"),
    array("5","ALGECIRAS"),
    array("6","ANDES"),
    array("7","ANOLAIMA"),
    array("8","ANSERMA"),
    array("9","ARAUCA"),
    array("10","ARBELAEZ"),
    array("11","ARBOLETES"),
    array("12","ARGELIA"),
    array("13","ARMENIA"),
    array("14","ARMERO"),
    array("15","BARRANCABERMEJA"),
    array("16","BARRANCO DE LOBA"),
    array("17","BARRANQUILLA"),
    array("18","BELALCAZAR"),
    array("19","BELEN"),
    array("20","BELLO"),
    array("21","BETULIA"),
    array("22","BOCAS DEL TORO"),
    array("23","BOGOTA D.C."),
    array("24","BUCARAMANGA"),
    array("25","BUENAVENTURA"),
    array("26","CAJICA"),
    array("27","CALAMAR"),
    array("28","CALARCA"),
    array("29","CALDAS"),
    array("30","CALI"),
    array("31","CAÑASGORDAS"),
    array("32","CAQUEZA"),
    array("33","CARMEN DE CARUPA"),
    array("34","CARTAGENA"),
    array("35","CARTAGO"),
    array("36","CASTILLA LA NUEVA"),
    array("37","CAUCASIA"),
    array("38","CHIGORODO"),
    array("39","CHINANDEGA"),
    array("40","CHIQUINQUIRA"),
    array("41","CHIRIQUI"),
    array("42","CHIVOLO"),
    array("43","CHOCONTA"),
    array("44","CIENAGA"),
    array("45","CIENAGA DE ORO"),
    array("46","CISNEROS")
);

$Array_Nivel_Formacion = array(
	array("9","Preescolar"),
	array("1","Primaria"),
    array("2","Secundaria (CR O PN) // Bachillerato (COL)"),
    array("3","Profecional"),
    array("4","Tecnólogo / Técnico Universitario o Diplomado (CR, PN)"),
    array("5","Especialización"), 
    array("6","Maestría"), 
    array("7","Doctorado"), 
    array("8","Postdoctorado"), 
	array("10","No Aplica"),
);

$Array_Pais_Residencia = array(
	array("1","COLOMBIA"),
    array("2","COSTA RICA"),
	array("3","PANAMÁ"), 
    array("4","NICARAGUA"),
    array("5","VENEZUELA")
);


$Array_Solo_Casa = array(
    array("1","Veo la Televisión"),
    array("2","Escucho música"),
    array("3","Estoy en internet"),
    array("4","Leo un libro"),
    array("5","Jugar Videojuegos"),
    array("6","Otras cosas"),
);


$Array_Generos_Musica = array(
    array("1","Pop"),
    array("2","Punk"),
    array("3","Jazz"),
    array("4","Heavy metal (Heavy, Speed Thrash"),
    array("5","Hip-Hop (Rap, Break dance, etc.)"),
    array("6","Salsa"),
    array("7","Cumbia"),
    array("8","Reggaetón"),
    array("9","Electrónica"),
    array("10","Sinfónica"),
    array("11","Musica Popular"),
    array("12","Vallenatos"),
    array("13","Otros géneros"),
);

    
$Array_Veo_Internet = array(
    array("1","Nada"),
    array("2","Videos Chistosos"),
    array("3","Redes Sociales"),
    array("4","No Tengo"),
    array("5","Otras Cosas"),

);
    
$Array_Reunion_Amigos = array(
    array("1","Platicar"),
    array("2","Caminar"),
    array("3","Ir al cine"),
    array("4","Pasear"),
    array("5","Ir de compras"),
    array("6","Ir de fiesta"),
    array("7","Otras cosas"),
);
    
        
$p = array(
    array("1","Facebook"),
    array("2","Twitter"),
    array("3","Google+"),
    array("4","Instagram"),
    array("5","Tik Tok"),
    array("6","Snapchat"),
    array("7","Otras redes"),
);


$Array_Deporte_Hace = array(
    array("1","Ninguno"),
    array("2","Natación"),
    array("3","Baloncesto"),
    array("4","Ciclismo"),
    array("5","Béisbol"),
    array("6","Atletismo"),
    array("7","Futból"),
    array("8","Tennis"),
    array("9","Gym"),
    array("10","Deportes extremos"),
    array("11","Squash")
);

$Array_frecuencia = array(
    array("1","Muy esporádicamente"),
    array("2","1 a 2 veces por semana"),
    array("3","3 o más veces por semana"),
    array("4","nunca")
);


$Array_sustancias = array(
    array("1","Nunca"),
    array("2","Eventualmente"),
    array("3","Diariamente")
);

$Array_bebidas = array(
    array("1","Si"),
    array("2","No"),
    array("3","Ocasionalmente")
);

$Array_fumas = array(
    array("1","Si"),
    array("2","No"),
    array("3","Ocasionalmente")
);

$Array_enfermedad = array(
    array("1","Si"),
    array("2","No")
);

$Array_actividades = array(
    array("1","Si"),
    array("2","No")
);

$Array_brigada = array(
    array("1","Si"),
    array("2","No")
);

$Array_En_Curso_Academico = array(
    array("1","Si"),
    array("2","No")
);

$Array_pertenecer = array(
    array("1","Si"),
    array("2","No")
);

$Array_voluntariado = array(
    array("1","Si"),
    array("2","No")
);

$Array_transporte = array(
    array("1","Transporte público"),
    array("2","Moto"),
    array("3","Bicicleta"),
    array("4","Automóvil propio"),
    array("5","Taxi"),
    array("6","Vehículos de plataformas"),
    array("7","Caminando"),
    array("8","Patineta eléctrica")
);

$Array_apoyo = array(
    array("1","NO APLICA"),
    array("2","Asistencial (asistencia presencial a las fundaciones)"),
    array("3","Aporte Económico"),
    array("4","Presencial y Económica")
);

$Array_conocimiento = array(
    array("1","Juridico"),
    array("2","Tributarios"),
    array("3","Apoyo emocional"),
    array("4","Fiscales"),
    array("5","Emprendimiento"),
    array("6","No aplica"),
    array("7","Otros"),
);

$Array_desplazamiento = array(
    array("1","Entre 15 - 30"),
    array("2","Entre 31 - 45"),
    array("3","Entre 46 - 60"),
    array("4","Entre 61 - 90"),
    array("5","Entre 91 - 120"),
    array("6","Entre 121 - 180")
);
    
$Array_Hobiees = array(
    array("1","Caminar"),
    array("2","Relacionados con la Musica (Tocar un instrumento"),
    array("3","Cantar)"),
    array("4","Dibujar"),
    array("5","Hacer deporte"),
    array("6","Estudiar"),
    array("7","Comer"),
    array("8","Leer"),
    array("9","Ver Peliculas"),
    array("10","Viajar"),
    array("11","Pintar"),
    array("12","Tejer"),
    array("13","Bailar"),
    array("14","Otras cosas"),
);

$Array_opciones_voluntariado = array(
    array("1","Apoyo a fundación de animales"),
    array("2","Fundación niños y adolecentes (niños en condiciones de abandono y vulnerabilidad)"),
    array("3","Ninguno")

);
    
    
$Array_Tipo_Comensal = array(
    array("1","Omnívoro (consumen de todo tipo de carne, vegetales, frutas, legumbres)"),
    array("2","Vegetariano (consumen solo vegetales y frutas)"),
    array("3","Veganos (consumen solo vegetales y frutas que no tengan origen animal)")

);

$Array_Parentezco = array(
    array("1","Padre"),
    array("1","Bisabuelos"),
    array("1","Biznietos"),
    array("1","Tíos"),
    array("1","Sobrinos"),
    array("1","Primos"),
    array("1","Hijo"),
    array("1","Conyuge"),
    array("1","Hermanos"),
    array("1","Abuelos"),
    array("1","Nietos"),
    array("1","yernos - nueras"),
    array("1","Suegros"),
    array("1","Cuñados")

);


$Array_Estado_Civil = array(
	array("1","Soltero(a)"),
	array("2","Casado(a)"),
	array("6","Union Libre"),
	array("3","Separado(a)"),
	array("4","Viudo(a)"),
	array("5","Otro")
);

$Array_Identidad_Genero = array(
    array("1","Antrosexualidad"),
    array("2","Asexualidad"),
    array("3","Bisexualidad"),
    array("4","Demisexualidad"),
    array("5","Graysexual"),
    array("6","Heterosexualidad"),
    array("7","Homosexualidad"),
    array("8","Lumbersexual"),
    array("9","Metrosexual"),
    array("10","Pansexualidad"),
    array("11","Sapiosexual"),
    array("12","Spornosexual"),
    array("13","Transexualidad")
);

$Array_Dotacion_Tipo = array(
	array("1","Uniforme"),
	array("2","People Pass")
);

$Array_People_Pass = array(
	array("1","Vestuario"),
	array("2"," Calzado")
);

$Array_Embarazada = array(
	array("1","Si"),
	array("2"," No")
);

$Array_Fuero_Paternidad = array(
	array("1","Si"),
	array("2"," No")
);

$Array_Incapacidad_Permanente = array(
	array("1","Si"),
	array("2"," No")
);

$Array_Pre_Pensionado = array(
	array("1","Si"),
	array("2"," No")
);

$Array_Convive = array(
	array("1","Si"),
	array("2"," No")
);

$Array_Dotacion_Aplica = array(
	array("1","Si"),
	array("2"," No")
);

$Array_Estudia_Actualmente = array(
	array("1","Si"),
	array("2"," No")
);


?>