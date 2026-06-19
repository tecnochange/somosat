<?php
	$txt_col = "";
	$lista_col = explode(",", $data["titulo"]);
	foreach($lista_col as $col){
		
		$queryEMp = mysqli_query($connect_valentina,"SELECT * FROM Empleados 
		WHERE id = '".$col."' ");
		$dataEMp = mysqli_fetch_array($queryEMp);
		
		$txt_col .= $dataEMp["nombre"]." ".$dataEMp["nombre_2"]." ".$dataEMp["apellidos"]." ".$dataEMp["apellidos_2"]."<br>";
	}

	$queryEmple = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$data["titulo"]."' ");
	$dataEmple = mysqli_fetch_array($queryEmple);

    $foto_user = "";
	if($dataUser["foto"] != ""){
		$foto_user = $url.'resources/'.$dataUser["foto"];
	}
	else{
		$foto_user = $url.'resources/'."user_reto_new.png";
	}
?>

<!-- Ficha -->
<div class="card" style="margin-bottom: 15px">
    
    <div class="card-body" style="padding: 8px">
        <table class="w-100">
            <tr>
                <td width="70">
                    <div style="background-image: url(<?php echo $user_log["foto"]; ?>); width: 80px; height: 80px;" class="min_foto_perfil">
					</div>
                </td>
                <td>
                    <b>Comunicaciones Internas</b><br>
                    <div style="font-size: 12px; color: #515151"><?php echo $data["created_at"] ?></div>
                </td>
                <td width="60">
                    <?php
                    if ($data["id_user"] == $user_log['id'] || $user_log['role'] == 1 || $user_log['role'] == 4) {
                        echo '
                            <img src="img/ico_delete.png" width="20" class="ico_edit_opt" onclick="Borrar_Publicacion('.$data["id"].')"/>
                            <a href="?pg=endomarketing/publicar/generales&id='.$data["id"].'"><img src="img/ico_edit.png" width="20" class="ico_edit_opt"/></a>
                        ';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
    
	<!-- tipo -->
    <div style="color: #ffffff;text-align: center;font-size: 17px;margin-bottom: 15px;padding: 10px;background-color: #005693;">
		Reconocimiento  para: <b><?php echo $dataEmple["nombre"]." ".$dataEmple["apellidos"]; ?></b> 
	</div>
    
    <!-- contenido -->
    <div style="padding: 15px;">
        <table width="100%">
            <tr>
                <td>
                    <?php
                    if ($data["copa"] == 1) {
                        echo '<img src="img/copa_oro.jpg" width="100%">';
                    }
                    if ($data["copa"] == 2) {
                        echo '<img src="img/copa_plata.jpg" width="100%">';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($data["copa"] == 1) {
                        echo '<div align="center" style="color: #dd9308; font-weight: bold; padding-bottom: 15px;">RECONOCIMIENTO DORADO</div>';
                    }
                    if ($data["copa"] == 2) {
                        echo '<div align="center" style="color: #7a7a7a; font-weight: bold; padding-bottom: 15px;">RECONOCIMIENTO PLATEADO</div>';
                    }
                    ?>
                    <div style="text-align: justify">
                        El presente reconocimiento se otorga a <b style="color: #dd9308;">
                        <?php
                            echo $txt_col; 
                        ?>
                        </b>

                        <?php
                        if ($data["copa"] == 1) {
                            echo 'por sus logros y aportes al mejoramiento continuo de la organización.<br><br>';
                        }
                        if ($data["copa"] == 2) {
                            echo 'por su esfuerzo permanente en realizar aportes que permitan el mejoramiento continuo de la Organización.<br><br>';
                        }
                        ?>

                        Atentamente<br>
                        <b>
                            Comunicaciones Internas
                            
                        
                        </b>
                    </div>
                </td>
            </tr>
        </table>

        <div style="border: 1px solid #eceaea; padding: 10px;">
            <?php 
			$descr = ConvertirLink($data["descripcion"]);
			echo nl2br( utf8_decode($descr) ); 
		?>
        </div>
    </div>
    
   <!-- COMENTARIOS -->
    

    <div class="card-body" align="center">
        <?php
        $queryComent = mysqli_query($connect_endomarketing, "SELECT * FROM Comentarios WHERE id_publicacion = '".$data["id"]."' ORDER BY id DESC");
        while ($dataComent = mysqli_fetch_array($queryComent)) {
            echo '
            <div class="comentarios_item">
                <div class="comentario_fecha"><b>'.htmlspecialchars($dataComent["nombre_full"], ENT_QUOTES, 'UTF-8').'</b> - '.htmlspecialchars($dataComent["created_at"], ENT_QUOTES, 'UTF-8').'</div>
                <div class="comentario_coment">'.utf8_decode($dataComent["comentario"]).'</div>
            </div>';
        }
        ?>

        <table width="100%">
            <tr>
                <td width="50%">
                    <b><i class="bx bx-like"></i> <?php echo htmlspecialchars($queryMegusta->num_rows, ENT_QUOTES, 'UTF-8'); ?></b>
                </td>
                <td align="right">
                    <b><?php echo htmlspecialchars($queryComentarios->num_rows, ENT_QUOTES, 'UTF-8'); ?> Comentarios</b>
                </td>
            </tr>
        </table>
        <div align="right" style="margin-top: 15px">
            <button type="button" class="btn btn-dark btn-sm" onclick="Me_Gusta(<?php echo htmlspecialchars($data["id"], ENT_QUOTES, 'UTF-8'); ?>)">
                Me gusta
            </button>
            <button type="button" class="btn btn-success btn-sm" onclick="Comentar(<?php echo htmlspecialchars($data["id"], ENT_QUOTES, 'UTF-8'); ?>)">
                Comentar
            </button>
        </div>
    </div>
</div>


