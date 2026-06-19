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
	array("2","Enviado al colaborador", "#ff9800"), 
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

$Array_Visibilidad = array(
    array("1", "Para la organización / institución"),
    array("2", "Para el área o proceso"),
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

$Array_Rangos_Edad = array(
	array(2,"Menor 26 años","0,26"),
 	array(3,"Entre 26 y 35 años ","26,35"), 
	array(3,"Entre 35 y 45 años ","35,45"), 
	array(3,"Mayor o igual a 45","45,200"),
);

$Array_Rangos_Antiguedad = array(
	array(1,"Menos de 1 año","0,1"),
 	array(2,"Entre 1 y 6 años ","1,6"), 
	array(3,"Entre 6 y 10 años ","6,10"), 
	array(4,"Más de 10 años","10,100"), 
);

$Array_Rangos_Edad = array(
	array(2,"Menor 26 años","0,26"),
 	array(3,"Entre 26 y 35 años ","26,35"), 
	array(3,"Entre 35 y 45 años ","35,45"), 
	array(3,"Mayor o igual a 45","45,200"),
);

$Array_Rangos_Antiguedad = array(
	array(1,"Menos de 1 año","0,1"),
 	array(2,"Entre 1 y 6 años ","1,6"), 
	array(3,"Entre 6 y 10 años ","6,10"), 
	array(4,"Más de 10 años","10,100"), 
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
	array("1","Financiera"),
	array("2","Mercadeo y Posicionamiento"),
	array("3","Ventas y Comercial"),
	array("4","Logística y Distribución"),
	array("5","Tecnología y Sistematización"), 
    array("6","Producción"), 
    array("7","Calidad y Métodos"), 
    array("8","Gestión del Talento Humano"), 
    array("9","Responsabilidad Social y Medio Ambiente"), 
    array("10","Investigación y Desarrollo Producto / Servicio"), 
    array("11","Gestión estratégica / Administrativa"), 
    array("12","Jurídica / Regulatoria")
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

$Array_Documentos_cargar = array(
	array("0","Documento Identificación"),
	array("1","Carné de Salud"),
    array("2","CV Personal"),
    array("3","CV en Formato de la Empresa"),
    array("4","Alta del Colaborador"),
    array("5","Formulario SNIS"),
    array("6","Formulario 3100"),
    array("7","Constancia de Votación"),
    array("8","Politica de Calidad"),
    array("9","Otros"), 
	array("10","Contrato de trabajo"),
	array("11","Extensión"),
	array("12","Confidencialidad"),

	
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
	array("2","Mujer"),
    array("3","Otro")
);

$Array_Emergencia_medica = array(
	array("1","UCM "),
	array("2","SEMM"),
    array("3","UCAR"),
    array("4","SUAT "),
    array("5","1727 "),
    array("6","EMERGENCIA UNO"),
    array("7","CARDIO MÓVIL "),
    array("8","EMMI ")
    
);

$Array_AFAP = array(
	array("1","AFAP SURA "),
	array("2","INTEGRACIÓN AFAP"),
    array("3","REPÚBLICA AFAP "),
    array("4","UNIÓN CAPITAL AFAP ")
    
    
);

$Array_Mutualistas = array(
	array("1","AMECOM"),
	array("2","AMEDRIN"),
    array("3","AMSJ"),
    array("4","ASOCIACIÓN ESPAÑOLA"),
    array("5","CAAMEPA"),
    array("6","CAMCEL"),
    array("7","CAMDEL"),
    array("8","CAMDUR"),
    array("9","CAMOC"),
    array("10","CAMS"),
    array("11","CAMY"),
    array("12","CASA DE GALICIA"),
    array("13","CASMER"),
    array("14","CASMU"),
    array("15","CIRCULO CATÓLICO"),
    array("16","COMECA"),
    array("17","COMECEL"),
    array("18","COMEF"),
    array("19","COMEFLO"),
    array("20","COMEPA"),
    array("21","COMERI"),
    array("22","COMERO"),
    array("23","COMETT"),
    array("24","COMTA"),
    array("25","COSEM"),
    array("26","CRAME"),
    array("27","CUDAM"),
    array("28","GREMCA"),
    array("29","HOSPITAL EVANGÉLICO "),
    array("30","IAC"),
    array("31","MÉDICA URUGUAYA"),
    array("32","ORAMECO"),
    array("33","SMI"),
    array("34","SMQS"),
    array("35","UNIVERSAL"),
    array("36","BLUE CROSS & BLUE SHIELD"),
    array("37","HOSPITAL BRITÁNICO "),
    array("38","MEDICARE"),
    array("39","MP"),
    array("40","SEGURO AMERICANO"),
    array("41","SUMMUM"),
    array("42","ASSE")
);

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
	array("2","Enviado al Colaborador", "#ff9800"), 
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
	array("1","Administrador"),
	array("2","Referente – Jefe de áreas"),
    array("3","Usuario final"),
	array("4","Directorio"),
    array("5","Comercial")
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
	array("4","Cédula Extranjería"),
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

$Array_Tipo = array(
    array("1","BASE"), 
    array("2","TÁCTICO DIRECTIVO"),
);

$Array_liderazgo = array(
    array("1","SI"), 
    array("2","NO"),
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
	array("1","Ene"),
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
    array("2","FEMENINO"),
    array("3","NO BINARIO")
);

$Array_Compania = array(
	array("1","AT"),
    array("2","Otros")
);


$Array_Tipo_Contratos = array(
	array("1","Dependiente"),
    array("2","Independiente")
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
    array("1","XS"),
	array("2","S"),
    array("3","M"),
    array("4","L"),
    array("5","XL"),
    array("6","XXL"),
    array("7","XXXL")
);

$Array_Modelo = array(
	array("1","Femenino"),
    array("2","Masculino")
);

$Array_Color = array(
	array("1","Azul"),
    array("2","Blanco")
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
    array("3","En familia"), 
	array("4","Padres"), 
);

$Array_Mascotas = array(
	array("1","Perro"),
    array("2","Ave"),
    array("3","Otros"),
    array("4","Gato"),
    array("5","Pez"),
    array("6","No Aplica")
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
    array("14","Espos@"),
    array("15","Otros")
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
    array("3","Material firme tejados en plástico"),
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
	array("1","Caminando"),
    array("2","Ómnibus"),
    array("3","Auto propio"),
    array("4","Moto"),
    array("5","Bicicleta"),
    array("6","Taxi"),
    array("7","Otros")
);

$Array_Distancia = array(
	array("1","menos de 1 km"),
    array("2","entre 1 km y 5 km"),
    array("3","Auto propio"),
    array("4","entre 5 km y 10 km"),
    array("5","más de 10 km"),
    array("6","más de 25 km")
);


$Array_Estratos = array(
	array("1","1"),
    array("2","2"),
    array("3","3"),
    array("4","4"),
    array("5","5"),
    array("6","6")
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

$Array_Departamento_Nacimiento = array(
	array("1","Artigas"),
    array("2","Canelones"),
    array("3","Cerro Largo"),
    array("4","Colonia"),
    array("5","Durazno"),
    array("6","Flores"),
    array("7","Florida"),
    array("8","Lavalleja"),
    array("9","Maldonado"),
    array("10","Montevideo"),
    array("11","Paysandú"),
    array("12","Río Negro"),
    array("13","Rivera"),
    array("14","Rocha"),
    array("15","Salto"),
    array("16","San José"),
    array("17","Soriano"),
    array("18","Tacuarembó"),
    array("19","Treinta y Tres")
);

$Array_Pais_Nac = array(
	array("1","Uruguay"),
    array("2","Chile"),
    array("3","Colombia"),
    array("4","México"),
    array("5","Alemania"),
    array("6","Argentina"),
	array("7","Otro")
);

$Array_Nacionalidad = array(
	array("1","URUGUAYO"),
    array("2","CHILENO"),
    array("3","COLOMBIANO"),
    array("4","MÉXICANO"),
    array("5","ARGENTINO"),
    array("6","ALEMÁN"),
    array("7","OTROS")
);


$Array_Ciudad_Nacimiento = array(
	array("1","18 DE JULIO"),
    array("2","18 DE JULIO PUEBLO NUEVO"),
    array("3","18 DE MAYO"),
    array("4","19 DE ABRIL"),
    array("5","19 DE JUNIO"),
    array("6","25 DE AGOSTO"),
    array("7","25 DE MAYO"),
    array("8","ACEGUÁ"),
    array("9","ACHAR"),
    array("10","AGRACIADA"),
    array("11","AGUAS BUENAS"),
    array("12","AGUAS CORRIENTES"),
    array("13","AIGUÁ"),
    array("14","ALEJANDRO GALLINAL"),
    array("15","ALGORTA"),
    array("16","ALONSO"),
    array("17","AMARILLO"),
    array("18","ANDRESITO"),
    array("19","ANSINA"),
    array("20","ARACHANIA"),
    array("21","ARAMENDÍA"),
    array("22","ARBOLITO"),
    array("23","ARENITAS BLANCAS"),
    array("24","ARERUNGUÁ"),
    array("25","ARÉVALO"),
    array("26","ARRIVILLAGA"),
    array("27","ARROCERA BONOMO"),
    array("28","ARROCERA EL TIGRE"),
    array("29","ARROCERA LA CATUMBERA"),
    array("30","ARROCERA LA QUERENCIA"),
    array("31","ARROCERA LAS PALMAS"),
    array("32","ARROCERA LOS CEIBOS"),
    array("33","ARROCERA LOS TEROS"),
    array("34","ARROCERA MINI"),
    array("35","ARROCERA PROCIPA"),
    array("36","ARROCERA RINCÓN"),
    array("37","ARROCERA SAN FERNANDO"),
    array("38","ARROCERA SANTA FÉ"),
    array("39","ARROCERA ZAPATA"),
    array("40","ARROYO BLANCO"),
    array("41","ARROZAL TREINTA Y TRES"),
    array("42","ARTIGAS"),
    array("43","ARTILLEROS"),
    array("44","ATLÁNTIDA"),
    array("45","BALNEARIO IPORÁ"),
    array("46","BALTASAR BRUM"),
    array("1","BAÑADO DE MEDINA"),
    array("2","BARKER"),
    array("3","BARRA DE VALIZAS"),
    array("4","BARRA DEL CHUY"),
    array("5","BARRANCAS"),
    array("6","BARRIO ANGLO"),
    array("7","BARRIO HIPÓDROMO"),
    array("8","BARRIO LA VINCHUCA"),
    array("9","BARRIO LÓPEZ BENÍTEZ"),
    array("10","BARRIO PEREIRA"),
    array("11","BARRIO TORRES"),
    array("12","BARROS BLANCOS"),
    array("13","BAYGORRIA"),
    array("14","BELÉN"),
    array("15","BELLA UNIÓN"),
    array("16","BELLACO"),
    array("17","BERNABÉ RIVERA"),
    array("18","BERRONDO"),
    array("19","BLANCARENA"),
    array("20","BLANES VIALE"),
    array("21","BLANQUILLO"),
    array("22","BOCA DEL ROSARIO"),
    array("23","BOCAS DEL CUFRÉ"),
    array("24","BRISAS DEL PLATA"),
    array("25","CABO POLONIO"),
    array("26","CAMPANA"),
    array("27","CAMPO DE TODOS"),
    array("28","CANELONES"),
    array("29","CAÑADA DEL PUEBLO"),
    array("30","CAÑADA GRANDE - FABRE"),
    array("31","CAÑADA NIETO"),
    array("32","CAPACHO"),
    array("33","CAPILLA DEL SAUCE"),
    array("34","CAPURRO"),
    array("35","CARDAL"),
    array("36","CARDONA"),
    array("37","CARDOZO"),
    array("38","CARLOS REYLES"),
    array("39","CARMELO"),
    array("40","CARRETA QUEMADA"),
    array("41","CASA BLANCA"),
    array("42","CASERÍO LA FUNDACIÓN"),
    array("43","CASTILLOS"),
    array("44","CASUPÁ"),
    array("45","CEBOLLATÍ"),
    array("46","CENTENARIO"),
    array("1","CENTURIÓN"),
    array("2","CERÁMICAS DEL SUR"),
    array("3","CERRILLADA"),
    array("4","CERRO CHATO"),
    array("5","CERRO COLORADO"),
    array("6","CERRO DE LAS CUENTAS"),
    array("7","CERRO PELADO"),
    array("100","CERROS DE LA CALERA")
);

$Array_Nivel_Formacion = array(
	array("1","Primaria"),
    array("2","Secundaria"),
    array("3","Técnico Profesional"),
    array("4","Grado Terciario"),
    array("5","Posgrado"), 
    array("6","Master-Doctorado")
);

$Array_Situacion = array(
	array("1","Completo"),
    array("2","Incompleto")
);


$Array_Pais_Residencia = array(
	array("1","Uruguay"),
    array("2","Otro")
);


$Array_Solo_Casa = array(
    array("1","Veo la Televisión"),
    array("2","Escucho música"),
    array("3","Estoy en internet"),
    array("4","Leo un libro"),
    array("5","Jugar Videojuegos"),
    array("6","Otras cosas")
);

$Array_Patologia = array(
    array("1","Asma"),
    array("2","Diabetes"),
    array("3","Hipertensión"),
    array("4","Celiaquía"),
    array("5","Alergias"),
    array("6","Epilepsia"),
    array("6","Vértigo"),
    array("6","Otros"),
    array("6","No aplica")
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
    array("3","Básquet"),
    array("4","Ciclismo"),
    array("5","Volley"),
    array("6","Atletismo"),
    array("7","Futból"),
    array("8","Tennis"),
    array("9","Gym"),
    array("10","Deportes Extremos"),
    array("11","Handball"),
    array("12","Hockey")
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
    array("1","Apoyo Económico"),
    array("2","Participación Dedicando Tiempo"),
    array("3","Otros")
);

$Array_conocimiento = array(
    array("1","Informática"),
    array("2","Tributarios"),
    array("3","Jurídico"),
    array("4","Apoyo Emocional"),
    array("5","Fiscales"),
    array("6","Otros")
);

$Array_desplazamiento = array(
    array("1","Entre 15 - 30 minutos"),
    array("2","Entre 31 - 45 minutos"),
    array("3","Entre 46 - 60 minutos"),
    array("4","Entre 61 - 90 minutos"),
    array("5","Entre 91 - 120 minutos"),
    array("6","Entre 121 - 180 minutos")
);
    
$Array_Hobiees = array(
    array("1","Caminar"),
    array("2","Relacionados Con la Musica"),
    array("3","Cantar"),
    array("4","Dibujar"),
    array("5","Hacer Deporte"),
    array("6","Estudiar"),
    array("7","Cocinar"),
    array("8","Leer"),
    array("9","Ver Peliculas y Series"),
    array("10","Viajar"),
    array("11","Pintar"),
    array("12","Tejer"),
    array("13","Bailar"),
    array("14","Otras Cosas"), 
	array("15","Tocar un Instrumento"),
);

$Array_opciones_voluntariado = array(
    array("1","Con Niños"),
    array("2","Con Adolescentes"),
    array("3","Con Adultos"),
    array("4","Con Animales"),
    array("5","Medio Ambiente"),
    array("6","Temática de Equidad y Género"),
    array("7","Otros")
);
    
    
$Array_Tipo_Comensal = array(
    array("1","Omnívoro (consumen de todo tipo de carne, vegetales, frutas, legumbres)"),
    array("2","Vegetariano (consumen solo vegetales y frutas)"),
    array("3","Veganos (consumen solo vegetales y frutas que no tengan origen animal)")

);

$Array_Parentezco = array(
    array("1","Padre"), 
	array("17","Madre"),
    array("2","Bisabuelos"),
    array("3","Bisnietos"),
    array("4","Tíos"),
    array("5","Sobrinos"),
    array("6","Primos"),
    array("7","Hijo"),
    array("8","Hijo/a político"),
    array("9","Conyuge"),
    array("10","Hermanos"),
    array("11","Abuelos"),
    array("12","Nietos"),
    array("13","yernos - nueras"),
    array("14","Suegros"),
    array("15","Cuñados"),
    array("16","Otros")

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
	
	array("2"," Dependiente"), 
	array("1"," Independiente- servicios profesionales"),
	array("3"," Independiente – servicios personales"),
);


$Array_Numero_Hijos = array(
	array("1"," si"),
    array("2"," no")
);

$Array_Estudia_Actualmente = array(
	array("1","Si"),
	array("2"," No")
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
	array("1","Cedula de Identidad"),
	array("2","Pasaporte"),
	array("3","Otro")
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
	array("1","Página WEB de Viva"),
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

$Array_Estado_Civil = array(
	array("1","Soltero/a"),
	array("2","Casado/a"),
	array("3","Unión Libre"),
    array("4","Divorciado/a"),
	array("5","Separado/a"),
	array("6","Viudo/a")
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

//COLABORADORES
$Array_Sexo_Biologico = array(
	array("1","MASCULINO"),
    array("2","FEMENINO"),
    array("3","NO BINARIO")
);



$Array_Meses = array(
	array("1","Ene"), 
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

$Array_Nivel_Ingles = array(
	array("BÁSICO","BÁSICO"),
    array("INTERMEDIO","INTERMEDIO"),
    array("AVANZADO","AVANZADO"),
);

$Array_Idiomas = array(
	array("INGLES","INGLES"),
    array("ESPAÑOL","ESPAÑOL"),
    array("PORTUGUES","PORTUGUES"),
);

$Array_Idioma_Oral_Escrito = array(
	array("ORAL","ORAL"),
    array("ESCRITO","ESCRITO"),
);

$Array_Estado_Procesos = array(
	array("1","Asignado"),
    array("2","En Proceso"),
    array("3","Finalizado"), 
	array("4","Cancelado"),
);

$Array_Idioma = array(
	array("Ingles","Ingles"),
    array("Frances","Frances"),
    array("Español","Español"), 
);

$Array_Academico_Status = array(
	array("En Curso","En Curso"),
    array("Finalizado","Finalizado"),
    array("Pausado","Pausado"), 
);

$Array_Interno_Externo = array(
	array("1","Interno"),
    array("2","Externo"),
);

$Array_Motivo_Formacion = array(
	array("1","MANDATORIA PARA EL NEGOCIO (MEMBRESIA)"),
    array("2","NO ES MANDATORIA, PERO SE PROYECTA COMO UNA OPORTUNIDAD DE NEGOCIO"),
	array("3","REQUERIDA PARA EL DESARROLLO DE COMPETENCIAS TÉCNICAS (VENTAS, INFORMÁTICA) "),
	array("4","REQUERIDA PARA EL DESARROLLO DE COMPETENCIAS SOFT Y ADN DE AT "),
	array("5","INVITACIÓN DEL CLIENTE, PERO NO MANDATORIA"), 
	array("6","SUGERIDA POR LOS PROPIOS TECNICOS"),
	 
	
);

$Array_Moneda_Formacion = array(
	array("1","Moneda peso"),
    array("2","Dólares "), 
	array("3","Euros "),
	
);

$Array_Certificado_Insignia = array(
	array("1","Certificado"),
    array("2","Insignia "), 
	array("3","Nada "),
	
);

$Array_Estado_Formacion = array(
	array("1","Programado"),
    array("2","En Curso"),
    array("3","Finalizado"), 
	array("4","Cancelado"), 
);

$Array_Ver_organigrama = array(
	array("1","Si"),
    array("0","No"),
);

$Array_Tipo_Capacitacion = array(
	array("1","Curso"),
    array("2","Examen"), 
	array("3","Congreso"),
	array("4","Certificación"),
	array("5","Capacitación interna"),
	array("6","Taller")
);



?>