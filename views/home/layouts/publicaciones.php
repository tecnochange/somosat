<?php
function replaceLinks($s) {
    return preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.%-=#]*(\?\S+)?)?)?)@', '<a href="$1">$1</a>', $s);
}

function ConvertirLink($entrada){
	$url = '@(http(s)?)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
	$string = preg_replace($url, '<a href="http$2://$4" target="_blank" title="$0">$0</a>', $entrada);
	return $string;
}
?>

<style>
	.comentarios_item{
		font-size: 12px;
		padding: 5px 10px;
		background-color: #f3f3f3;
		margin-bottom: 10px;
		border-radius: 4px;
	}
</style>

<?php
	$ahora = date("Y-m-d");
	$tab_index = 1;
	$limit = 20;

	$filtro = "";
	if($_GET["p"]){
		$filtro .= " AND tipo = '".$_GET["p"]."' ";
	}

	//CONSULTAMOS LOS DATOS DE LA ASIGNACION
	//CONSULTAMOS LAS PUBLICACIONES
	$query = mysqli_query($connect_endomarketing,"SELECT * FROM Publicaciones WHERE estado = 1 AND fecha_publicacion <= '".$ahora."' ".$filtro." 
	ORDER BY id DESC LIMIT ".$limit." ");
	while($data = mysqli_fetch_array($query)){

		$listMegusta = '';
		//CONSULTAMOS EL EMPLEADO
		$queryUser = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
		WHERE id = '".$data["id_user"]."' ");
		$dataUser = mysqli_fetch_array($queryUser);

		//CONSULTAMOS LOS COMENTARIOS
		$queryComentarios = mysqli_query($connect_endomarketing,"SELECT * FROM Comentarios 
		WHERE id_publicacion = '".$data["id"]."' ");

		//CONSULTAMOS LOS MEGUSTA
		$queryMegusta = mysqli_query($connect_endomarketing,"SELECT * FROM Me_Gusta 
		WHERE id_publicacion = '".$data["id"]."' ");
		
		//CONSULTAMOS LA LISTA DE ME GUSTAN
		$queryMegustaList = mysqli_query($connect_endomarketing,"SELECT * FROM Me_Gusta 
		WHERE id_publicacion = '".$data["id"]."' ORDER BY id DESC LIMIT 10 ");

		while($dataMegustaList = mysqli_fetch_array($queryMegustaList)){
			$listMegusta .= $dataMegustaList["nombre_full"].' <br> ';
		}

		// $queryAcepto = mysqli_query($connect_endomarketing,"SELECT * FROM Aceptados WHERE id_publicacion = '".$data["id"]."' ");
		//RETO
		if($data["tipo"] == 1){ 
			if($data["visibilidad"] == 1){
				include("views/home/layouts/reto_ficha.php");
			}
			if($data["visibilidad"] == 2){
				if($data["id_proceso"] == $user_log['id_departamento'] ){
					include("views/home/layouts/layouts/reto_ficha.php");
				}
			}
		}
		
		//MOTIVADOR 
		if($data["tipo"] == 2){ 
			if($data["visibilidad"] == 1){
				include("views/home/layouts/motivador_ficha.php");
			}
			if($data["visibilidad"] == 2){
				if($data["id_proceso"] == $user_log['id_departamento'] ){
					include("views/home/layouts/motivador_ficha.php");
				}
			}
		}
                //RECONOCIMIENTO
		if($data["tipo"] == 3){ 
			if($data["visibilidad"] == 1){
				include("views/home/layouts/reconocimiento_ficha.php");
			}
			if($data["visibilidad"] == 2){
				if($data["id_proceso"] == $user_log['id_departamento'] ){
					include("views/home/layouts/reconocimiento_ficha.php");
				}
			}
			if($data["visibilidad"] == 3){
				if($data["titulo"] == $_SESSION['id_user'] ){
					include("views/home/layouts/reconocimiento_ficha.php");
				}
			}

		}

		//GENERALES
		if($data["tipo"] == 4){ 
			if($data["visibilidad"] == 1){
				include("views/home/layouts/clasificado_ficha.php");
			}
			if($data["visibilidad"] == 2){
				if($data["id_proceso"] == $user_log['id_departamento'] ){
					include("views/home/layouts/clasificado_ficha.php");
				}
			}
			if($data["visibilidad"] == 3){
				if($data["titulo"] == $_SESSION['id_user'] ){
					include("views/home/layouts/clasificado_ficha.php");
				}
			}

		}
                
                
		//GENERALES
		if($data["tipo"] >= 5){ 
			
			if($data["visibilidad"] == 1){
				include("views/home/layouts/generales_ficha.php");     
			}
			if($data["visibilidad"] == 2){
				if($data["id_area"] == $user_log['id_area'] ){
					include("views/home/layouts/generales_ficha.php");
				}
			}
			if($data["visibilidad"] == 3){
				if($data["titulo"] == $user_log['id'] ){
					include("views/home/layouts/generales_ficha.php");
				}
			}
		}
		
	}

	if($query->num_rows == 0){
		echo '
		<div class="card" style="margin-bottom: 15px">
			<div class="card-body" align="center">
				Sin publicaciones
			</div>
		</div>
		';
	}
?>



<script>
var urls = "<?php echo $url; ?>/api/muro/";
	
function Me_Gusta(val){	
	$("#preloader").show();	
	jQuery.ajax({
		url: urls+"me_gusta.php",
		type:'post',
		data: {id:val,u:<?php echo $_SESSION['id_user']; ?>,name:'<?php echo $dataEmploy["nombre"]." ".$dataEmploy["nombre_2"]." ".$dataEmploy["apellidos"]." ".$dataEmploy["apellidos_2"]; ?>'},
		}).done(function (resp){
			//$("this").hide();	
			$("#xscript").html(resp);
		})
		.fail(function() {
		})
		.always(function(resp){
			$("#preloader").hide();
		}
	);	
}
	
function Comentar(val){
	$("#modal_comentar").modal("show");
	$("#cont_modal_comentar").html('<textarea id="comentario" rows="5" style="width: 100%;" required></textarea>');
	$("#cont_modal_comentar").append('<input type="hidden" value="'+val+'" id="id_comentar" />');
	$("#cont_modal_comentar").append('<input type="button" value="Comentar" class="btn btn-md btn-primary" onclick="Registrar_Comentar()"/>');
	
}
	
function Registrar_Comentar(){
	
	if($("#comentario").val() != ""){	
	
		$("#preloader").show();
		
		jQuery.ajax({
			url: urls+"comentario.php",
			type:'post',
			data: {id: $("#id_comentar").val(),u:<?php echo $user_log['id']; ?>,name:'<?php echo $user_log["nombre"]." ".$user_log["apellidos"]; ?>', comentario: $("#comentario").val() },
			}).done(function (resp){
				//$("this").hide();	
				$("#xscript").html(resp);
			})
			.fail(function() {
			})
			.always(function(resp){
				$("#preloader").hide();
			}
		);
	}
	else{
		alert("Debes registrar un comentario");
	}
}
	
function Borrar_Publicacion(val){	
	jQuery.ajax({
		url: urls+"borrar_publicacion.php",
		type:'post',
		data: { id:val },
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function() {
		})
		.always(function(resp){
			$("#preloader").hide();
		}
	);	
}

function Borrar_Comentario(val){	
	jQuery.ajax({
		url: urls+"borrar_comentario.php",
		type:'post',
		data: { id:val },
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function() {
		})
		.always(function(resp){
			$("#preloader").hide();
		}
	);	
}
</script>

