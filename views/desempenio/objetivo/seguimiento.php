<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_seguimiento").addClass("active_item");

});
</script>

<?php
    $id = $_GET["id"];
    $hoy = date("Y-m-d H:i:s");
    
    if( $_POST["id_registro"] != "" ){
        
        $meses = array();
        for($i = 1; $i <= 12; $i++) {
            array_push( $meses, array("mes"=> $i, "meta"=> $_POST["mes_".$i]) );
        }

        mysqli_query($connect_desempenio,"UPDATE Objetivos_Colaborador SET 
        obj_meses_resultados = '".json_encode($meses)."', observaciones = '".$_POST["observaciones"]."'  WHERE id = '".$_POST["id_registro"]."' ");
        //echo '<script> window.location.href = "?pg=desempenio/objetivo/detalle&id='.$_POST["id_registro"].'";</script>';
        
	}

    //para guardar las observaciones
    if($_POST["mes_observacion"] != ""){
        mysqli_query($connect_desempenio,"INSERT INTO Observaciones_Mes (id_objetivo, anio, mes, observacion, created_at) 
        VALUES 
        ('".$id."', '".$_SESSION["anio"]."', '".$_POST["mes_observacion"]."', '".$_POST["observacion"]."', '".$hoy."' ) ");
        echo '<script> window.location.href = "?pg=desempenio/objetivo/seguimiento&id='.$id.'";</script>';
    }




    $queryVal = mysqli_query($connect_desempenio,"SELECT * FROM Aprobaciones_Objetivos WHERE id_empleado = '".$_SESSION['id_user_valentina']."' AND anio = '".$_SESSION['anio']."' ");
    $dataVal = mysqli_fetch_array($queryVal);

    $queryObjetivo = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador WHERE id = '".$id."' ");
    $dataObjetivos = mysqli_fetch_array($queryObjetivo);
    $obj_meses = json_decode($dataObjetivos["obj_meses"], true);
    $obj_resultados = json_decode($dataObjetivos["obj_meses_resultados"], true);

    $queryColaborador = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$dataObjetivos["id_empleado"]."' ");
    $dataColaborador = mysqli_fetch_array($queryColaborador);


?>

<?php include("views/desempenio/objetivo/ficha_observacion.php"); ?>

<div class="container-fluid"> 

    <div class="row">

        <div class="col-md-12">
            
            <div class="card">
                <div class="card-body">
                    
                    <h2>
                            Seguimiento Objetivo <?php echo $_SESSION["anio"]; ?><br>
                            <?php echo $dataColaborador["nombre"]; ?>
                        </h2>
                    
                    <div><b>Objetivo: <?php echo $dataObjetivos["objetivo"]; ?></b></div>
                    <div><b>Indicador:</b> <?php echo $dataObjetivos["indicador"]; ?></div>
                    <div><b>Fecha de Cumplimiento:</b> <?php echo $dataObjetivos["fecha_cumplimiento"]; ?></div>
                    <div><b>Fórmula:</b> <?php echo $dataObjetivos["formula"]; ?></div>
                    <div><b>Fuentes:</b> <?php echo $dataObjetivos["fuente"]; ?></div>
                    
                    
                    <table class="table table-bordered" width="100%" style="margin-top: 15px">
                        <!-- Cabecera -->
                        <tr>
                            <td></td>
                            <?php
                            foreach($Array_Meses as $mes){
                                $meta_mes = 0;
                                foreach($obj_meses as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $meta_mes = $meta["meta"];
                                    }
                                }
								if($meta_mes > 0){
									echo '
										<td align="center">
											<b>'.$mes[1].'</b>
										</td>
									';
								}
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Meta #:</td>
                            <?php
                            foreach($Array_Meses as $mes){
                                $meta_mes = 0;
                                foreach($obj_meses as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $meta_mes = $meta["meta"];
                                    }
                                }
								if($meta_mes > 0){
									echo '
										<td align="center">
											'.$meta_mes.'
										</td>
									';
								}
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Resultado:</td>
                            <?php
                            foreach($Array_Meses as $mes){
								
								$meta_mes = 0;
                                foreach($obj_meses as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $meta_mes = $meta["meta"];
                                    }
                                }
								
                                $resp_mes = 0;
                                foreach($obj_resultados as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $resp_mes = $meta["meta"];
                                    }
                                }
								if($meta_mes > 0){
									echo '
										<td align="center">
											'.$resp_mes.'
										</td>
									';
								}
                            }
                            ?>
                        </tr>
                        <tr>
                            <td>Avance:</td>
                            <?php
                            foreach($Array_Meses as $mes){
                                $meta_mes = 0;
                                foreach($obj_meses as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $meta_mes = $meta["meta"];
                                    }
                                }
                                
                                $resp_mes = 0;
                                foreach($obj_resultados as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $resp_mes = $meta["meta"];
                                    }
                                }
                                $avance = ($resp_mes/$meta_mes)*100;
                                
                                if( is_nan($avance) ){ $avance = 0; }
                                if( is_infinite($avance) ){ $avance = 100; }
                                
                                
                                if($meta_mes > 0){
									echo '
										<td align="center">
											<b>'.round($avance,1).'%</b>
										</td>
									';
								}
                            }
                            ?>
                        </tr>
                        

                    </table>
                    
            
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    
                    <form action="" method="post">
                    
                    <input type="hidden" value="<?php echo $id; ?>" name="id_registro">
                    
                    <h2>Actualizar</h2>
                    <table class="table table-bordered" width="100%" style="margin-top: 15px">
                        <tr>
                            <?php
                            foreach($Array_Meses as $mes){
								
								$meta_este_mes = 0;
								foreach($obj_meses as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $meta_este_mes = $meta["meta"];
                                    }
                                }

                                $res_mes = 0;

                                foreach($obj_resultados as $meta){
                                    if($meta["mes"] == $mes[0]){
                                        $res_mes = $meta["meta"];
                                    }
                                }

                                $desplegable = '<select class="form-control" name="mes_'.$mes[0].'"><option value="0">0%</option>';
                                for ($x = 5; $x <= 3000; $x += 5 ) {
                                     if($res_mes == $x ){
                                        $desplegable .= '
                                            <option value="'.$x.'" selected>'.$x.'%</option>
                                        ';
                                    }
                                    else{
                                        $desplegable .= '
                                            <option value="'.$x.'">'.$x .'%</option>
                                        ';
                                    }
                                }
                                $desplegable .= '</select>';
								
								if($meta_este_mes > 0){
									echo '
										<td align="center">
											'.$mes[1].'<br>
											<input type="text" class="form-control" name="mes_'.$mes[0].'" value="'.$res_mes.'" required>
											<div>
												<button type="button" class="btn btn-success btn-sm" title="Comentarios"  style="margin-top: 20px" onclick="Observaciones('.$mes[0].')">
													<i class="fa fa-comments"></i>
												</button>

												<button type="button" class="btn btn-primary btn-sm" title="Evidencias"  style="margin-top: 20px; display:none">
													<i class="fa fa-file"></i>
												</button>

											</div>
										</td>
									';
								}
                            }
                            ?>
                            </tr>

                    </table>
                           
                    <table class="table table-bordered" style="margin-top: 10px">
                        <tr>
                            <th>Mes</th>
                            <th>Observación</th>
							<th></th>
                        </tr>
                        <?php
                            $queryObservaciones = mysqli_query($connect_desempenio,"SELECT * FROM Observaciones_Mes WHERE id_objetivo = '".$id."' AND anio = '".$_SESSION['anio']."' ");
                            while($dataObservacion = mysqli_fetch_array($queryObservaciones)){
                                $txt_mes = "";
                                foreach($Array_Meses as $mes){
                                    if($mes[0] == $dataObservacion["mes"]){
                                        $txt_mes = $mes[1];
                                    }
                                }
								
								$bt_editar = "";
								if($user_log["role"] == 1 ){
									$bt_editar = '
									<a href="#" class="btn btn-danger" title="Editar" onclick="Eliminar_Comentario('.$dataObservacion["id"].')">
										Eliminar
									</a>
									';
								}
								
                                echo '
                                <tr>
                                    <td>'.$txt_mes.'</td>
                                    <td>'.$dataObservacion["observacion"].'</td>
									<td>'.$bt_editar.'</td>
                                </tr>
                                ';
                            }
                        ?>
                    </table>
                        
                    <textarea rows="5" placeholder="Ingresar observación general (opcional)..." class="form-control" name="observaciones" style="margin-top: 10px"><?php echo $dataObjetivos["observaciones"]; ?></textarea>
                    
                    <button type="submit" class="btn btn-primary btn-block" title="Editar"  style="margin-top: 20px">
                        Actualizar
                    </button>
                        
                    </form>
                    
                </div>
            </div>


            
            
        </div>
    </div>
</div>


<script>
	
function Observaciones(mes){
    $(".modal_observacion").modal("show");
    $("#mes_observacion").val(mes);
}

var api = '<?php echo $url; ?>/api/desempenio/';
function Eliminar_Comentario(id_registro){
	
	
	jQuery.ajax({
		url: api+"eliminar_comentarios.php",
		type:'post',
		data: {id_registro: id_registro, url:"<?php echo $url; ?>/?pg=desempenio/objetivo/seguimiento&id=<?php echo $id; ?>"},
		}).done(function (resp){
			$("#xscript").html(resp);
		})
		.fail(function(resp) {
			console.log(resp);
		})
		.always(function(resp){
		}
	);
	
}
</script>




