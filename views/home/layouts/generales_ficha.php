<?php
	$titulo_ficha = "";
	$bg_color = "";
	if($data["tipo"] == 5){ $titulo_ficha = "Nuestra Gente"; $bg_color = "#5b349e";  }
	if($data["tipo"] == 6){ $titulo_ficha = "SyST"; $bg_color = "#e31890";  }
	if($data["tipo"] == 7){ $titulo_ficha = "Celebraciones"; $bg_color = "#ffc107";  }
	if($data["tipo"] == 8){ $titulo_ficha = "Calidad de vida"; $bg_color = "#ff5722";  }
	if($data["tipo"] == 9){ $titulo_ficha = "Noticias"; $bg_color = "#5b349e";  }
	if($data["tipo"] == 10){ $titulo_ficha = "Beneficios"; $bg_color = "#e31890";  }

	$foto_user = "";
	if($dataUser["foto"] != ""){
		$foto_user = $url.'recursos/'.$dataUser["foto_formal"];
	}
	else{
		$foto_user = $url.'resources/'."user_reto_new.png";
	}
?>

<div class="card" style="margin-bottom: 15px">
	
	<div class="card-body" style="padding: 8px">
		<table class="w-100">
			<tr>
				<td width="70">
                    <div style="background-image: url(<?php echo $user_log["foto"]; ?>); width: 80px; height: 80px;" class="min_foto_perfil">
					</div>
				</td>
				<td>
					<b><?php echo $dataUser["nombre"]." ".$dataUser["apellidos"]; ?></b><br>
					<div style="font-size: 12px; color: #515151"><?php echo $data["created_at"] ?></div>
				</td>
				<td width="60">
					<?php
					if($data["id_user"] == $user_log['id'] || $user_log['role'] == 1 ){
						echo '
							<img src="img/ico_delete.png" width="20" class="ico_edit_opt" onclick="Borrar_Publicacion('.$data["id"].')"/>
							<a href="?pg=endomarketing/publicar/generales&tp='.$data["tipo"].'&id='.$data["id"].'"><img src="img/ico_edit.png" width="20" class="ico_edit_opt"/></a>
						';
					}
					?>
				</td>
			</tr>
		</table>
	</div>
	
	<?php
	//VIDEO DE YOUTUBE
	if($data["tipo_multimedia"] == 2){
		echo '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'.$data["script"].'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	}
    	
	//GALERIA DE IMAGENES
	if($data["tipo_multimedia"] == 1){
		$queryArchivos = mysqli_query($connect_endomarketing,"SELECT * FROM Multimedia WHERE id_publicacion = '".$data["id"]."' AND tipo = 1 ");
		if($queryArchivos->num_rows > 1){
			
			echo '<div class="swiper-container">';
			echo '	<div class="swiper-wrapper">';
				
			while($dataArchivos = mysqli_fetch_array($queryArchivos)){
				echo '<div class="swiper-slide"><img src="'. $url.'/resources/muro/'.$dataArchivos["imagen"].'" style=" width:100%" ></div>';
			}
			echo '	</div>';
			echo '	<div class="swiper-pagination"></div>';
			echo '	<div class="swiper-button-next"></div>';
			echo '	<div class="swiper-button-prev"></div>';
			echo '</div>';
		}
		if($queryArchivos->num_rows == 1){
			$dataArchivos = mysqli_fetch_array($queryArchivos);
			echo '<div class="swiper-slide"><img src="'. $url.'/resources/muro/'.$dataArchivos["imagen"].'" style=" width:100%" ></div>';
		}
	}
     
	$lista_archivos = "";
	//ARCHIVOS ADICIONALES
	$queryArchivos = mysqli_query($connect_endomarketing,"SELECT * FROM Multimedia WHERE id_publicacion = '".$data["id"]."' AND tipo = 2 ");
	while($dataArchivos = mysqli_fetch_array($queryArchivos)){
		$lista_archivos = '
			<tr>
				<td>
					<a href="'.$url.'/resources/muro/'.$dataArchivos["imagen"].'" target="_blank">
                        '.$dataArchivos["imagen"].'
					</a>
				</td>
				<td width="22"> 
					<a href="'.$url.'/resources/muro/'.$dataArchivos["imagen"].'" target="_blank">
                        <img src="img/download.png" width="20"> 
					</a>
				</td>
			</tr>
		';
	}
	?>
	
	<?php if($queryArchivos->num_rows > 0){ ?>
	<table class="table">
		<?php echo $lista_archivos; ?>
	</table>
	<?php } ?>

	<div class="card-body" align="center">
		<?php 
			$descr = ConvertirLink($data["descripcion"]);
			echo nl2br( utf8_decode($descr) ); 
		?>
		
		
		<?php
		$queryComent = mysqli_query($connect_endomarketing,"SELECT * FROM Comentarios WHERE id_publicacion = '".$data["id"]."' ORDER BY id DESC ");
		while($dataComent = mysqli_fetch_array($queryComent)){
			echo '
			<div class="comentarios_item">
				<div class="comentario_fecha"><b>'.$dataComent["nombre_full"].'</b> - '.$dataComent["created_at"].'</div>
				<div class="comentario_coment">'.utf8_decode($dataComent["comentario"]).'</div>
			</div>';
		}
		?>
		
		
		<table width="100%">
			<tr>
				<td width="50%">
					<b><i class="bx bx-like" ></i> <?php echo $queryMegusta->num_rows; ?></b>
				</td>
				<td align="right">
					<b><?php echo $queryComentarios->num_rows; ?> Comentarios</b>
				</td>
			</tr>
		</table>
		<div align="right" style="margin-top: 15px">
			
			<button type="button" class="btn btn-dark btn-sm" onclick="Me_Gusta(<?php echo $data["id"]; ?>)">
				Me gusta
			</button>
			<button type="button" class="btn btn-success btn-sm" onclick="Comentar(<?php echo $data["id"]; ?>)">
				Comentar
			</button>
			
		</div>
	</div>
	
	<div class="card-footer" align="right" style="background-color: <?php echo $bg_color; ?>; color:#ffffff" >
		<?php echo $titulo_ficha; ?> 
	</div>
	
</div>