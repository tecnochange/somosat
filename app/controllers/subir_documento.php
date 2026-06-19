<?php

function Cargar_Foto_Perfil($file){

    $sku = time();
	$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos/'; 
    $name = preg_replace('([^A-Za-z0-9.])', '', $file['name']);
	$fichero_subido = $dir_subida . basename($sku.$name);

	if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
		//echo "El fichero es válido y se subió con éxito.\n";
	} 
	else {
		//echo "¡Posible ataque de subida de ficheros!\n";
	}
	return $sku.$name;
}

function Cargar_Foto_Hijos($file, $key){

    $sku = time();
	$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos/'; 
    $name = preg_replace('([^A-Za-z0-9.])', '', $file['name'][$key]);
	$fichero_subido = $dir_subida . basename($sku.$name);

	if (move_uploaded_file($file['tmp_name'][$key], $fichero_subido)) {
		//echo "El fichero es válido y se subió con éxito.\n";
	} 
	else {
		//echo "¡Posible ataque de subida de ficheros!\n";
	}
	return $sku.$name;
}



function Cargar_Foto_Informal($file){
    $sku = time();
	$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos/'; 
    $name = preg_replace('([^A-Za-z0-9.])', '', $file['name']);
	$fichero_subido = $dir_subida . basename($sku.$name);

	if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
		//echo "El fichero es válido y se subió con éxito.\n";
	} 
	else {
		//echo "¡Posible ataque de subida de ficheros!\n";
	}
	return $sku.$name;
}

function Cargar_Foto_Familiar($file){
    $sku = time();
	$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos/'; 
    $name = preg_replace('([^A-Za-z0-9.])', '', $file['name']);
	$fichero_subido = $dir_subida . basename($sku.$name);

	if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
		//echo "El fichero es válido y se subió con éxito.\n";
	} 
	else {
		//echo "¡Posible ataque de subida de ficheros!\n";
	}
	return $sku.$name;
}

function Subir_Documento($file){
	$sku = time();
	$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos/'; //carpeta de recursos
    $name = preg_replace('([^A-Za-z0-9.])', '', $file['name']);
	$fichero_subido = $dir_subida . basename($sku.$name);
	
	if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
		//echo "El fichero es válido y se subió con éxito.\n";
	} 
	else {
		//echo "¡Posible ataque de subida de ficheros!\n";
	}

	return $sku.$name;
}

//CARGAR ARCHIVO
function Cargar_Archivos_Actividad($files, $id_project, $id_activity, $fecha, $connect_virtual){
	
	foreach($files['tmp_name'] as $key => $tmp_name ){
	
		//Validamos que el archivo exista
		if($files["name"][$key]) {
			
			$name = preg_replace('([^A-Za-z0-9.])', '', $files["name"][$key]);
				
			$sku = time();
			$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos_virtual/';
			$fichero_subido = $dir_subida . basename($sku.$name);
				
			if (move_uploaded_file($files['tmp_name'][$key], $fichero_subido)) {
				//echo "El fichero es válido y se subió con éxito.\n";
			} 
			else {
				//echo "¡Posible ataque de subida de ficheros!\n";
			}
			$archivo =  $sku.$name;
	
			mysqli_query($connect_virtual,"INSERT INTO multimedia_activities (id_project, id_activity, archive, created_at) 
			VALUES (".$id_project.", ".$id_activity.", '".$archivo."','".$fecha."' ) ");
		}
	}
}

//CARGAR ARCHIVO
function Cargar_Archivos_Multiples($files, $id_publicacion, $fecha,$connect_desarrollo){
	
	foreach($files['tmp_name'] as $key => $tmp_name ){
		//Validamos que el archivo exista
		if($files["name"][$key]) {
			
			$name = preg_replace('([^A-Za-z0-9.])', '', $files["name"][$key]);
			$sku = time();
			$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos_desarrollo/';
			$fichero_subido = $dir_subida . basename($sku.$name);
				
			if (move_uploaded_file($files['tmp_name'][$key], $fichero_subido)) {
				//echo "El fichero es válido y se subió con éxito.\n";
			} 
			else {
				//echo "¡Posible ataque de subida de ficheros!\n";
			}
			$archivo =  $sku.$name;
	
			mysqli_query($connect_desarrollo,"INSERT INTO multimedia (id_publication, file, type, created_at) 
			VALUES (".$id_publicacion.", '".$archivo."', 1, '".$fecha."' ) ");
		}
	}
}

//CARGAR ARCHIVO
function Cargar_Archivos_Multiples_Documentos($files, $id_publicacion, $fecha,$connect_desarrollo){
	
	foreach($files['tmp_name'] as $key => $tmp_name ){
		//Validamos que el archivo exista
		if($files["name"][$key]) {
			
			$name = preg_replace('([^A-Za-z0-9.])', '', $name);
				
			$sku = time();
			$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos_desarrollo/';
			$fichero_subido = $dir_subida . basename($sku.$name);
				
			if (move_uploaded_file($files['tmp_name'][$key], $fichero_subido)) {
				//echo "El fichero es válido y se subió con éxito.\n";
			} 
			else {
				//echo "¡Posible ataque de subida de ficheros!\n";
			}
			$archivo =  $sku.$name;
	
			mysqli_query($connect_desarrollo,"INSERT INTO multimedia_documentos (id_publication, file, type, created_at) 
			VALUES (".$id_publicacion.", '".$archivo."', 1, '".$fecha."' ) ");
		}
	}
}





function Cargar_Archivos_Multiples_Muro( $files, $publicacion, $tipo, $fecha, $connect_endomarketing){
	
	foreach($files['tmp_name'] as $key => $tmp_name ){
	
		//Validamos que el archivo exista
		if($files["name"][$key]) {
			
			$name = preg_replace('([^A-Za-z0-9.])', '', $files["name"][$key] );
				
			$sku = time();
			$dir_subida = '/var/www/html/somosat.hr-suite.app/resources/muro/';
			$fichero_subido = $dir_subida . basename($sku.$name );
				
			if (move_uploaded_file($files['tmp_name'][$key], $fichero_subido)) {
				//echo "El fichero es válido y se subió con éxito.\n";
			} 
			else {
				return "Error al subir el archivo";
			}
			$archivo =  $sku.$name;
	
			mysqli_query($connect_endomarketing,"INSERT INTO Multimedia (imagen, id_publicacion, tipo, created_at) 
			VALUES ('".$archivo."', ".$publicacion.", ".$tipo.", '".$fecha."' ) ");
		}
	}
}



function Subir_Documentos($file) {
    $permitidos = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extension, $permitidos)) {
        return false; // Archivo no permitido
    }
    
    // Limpiar nombre de archivo, pero conservar el punto antes de la extensión
    $nombreLimpio = preg_replace('/[^A-Za-z0-9_.-]/', '', pathinfo($file['name'], PATHINFO_FILENAME));
    $sku = time();
    $nombreFinal = $sku . $nombreLimpio . '.' . $extension;
    
    $dir_subida = '/var/www/html/somosat.hr-suite.app/resources/';
    $fichero_subido = $dir_subida . $nombreFinal;

    if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
        return $nombreFinal;
    } else {
        return false; // Error al subir
    }
}














//CARGAR ARCHIVO
function Cargar_Archivos_Multiples_Clima($files,$publicacion,$tipo,$fecha,$connect){
	
	foreach($files['tmp_name'] as $key => $tmp_name ){
	
		//Validamos que el archivo exista
		if($files["name"][$key]) {
				
			$sku = time();
			$dir_subida = '/var/www/html/somosat.hr-suite.app/recursos_clima/';
			$fichero_subido = $dir_subida . basename($sku.$files["name"][$key]);
				
			if (move_uploaded_file($files['tmp_name'][$key], $fichero_subido)) {
				//echo "El fichero es válido y se subió con éxito.\n";
			} 
			else {
				//echo "¡Posible ataque de subida de ficheros!\n";
			}
			$archivo =  $sku.$files['name'][$key];
	
			mysqli_query($connect,"INSERT INTO Multimedia (imagen, id_publicacion, tipo, created_at) 
			VALUES ('".$archivo."', ".$publicacion.", ".$tipo.", '".$fecha."' ) ");
		}
	}
}


function Cargar_Base($arch,$cont){
    echo '
    <script>
    alert("ingreso");
</script>
    ';
    /*
	$sku = time();
	$base64 = explode(',', $arch);
	$data = base64_decode($base64[1]);// 
	$filepath = "/var/www/html/valentina/recursos_clima/".$sku.$cont.".jpg"; // or image.jpg
	file_put_contents($filepath, $data);
	
	return $sku.$cont.".jpg";
    */
}


?>

