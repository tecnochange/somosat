<script>  
$(document).ready(function(){
    $("#desempenio_menu").addClass("active");
    $("#desplegable_desempenio").show();
    $("#bt_desempenio_seguimiento").addClass("active_item");
	$("#bt_desempenio_seguimiento").addClass("active_item");

});
</script>

<?php
    $id = $_GET["id"];
    $hoy = date("Y-m-d H:i:s");

	//$id_user_tmp = $_SESSION['id_user'];
	if( $_GET["e"] != "" ){
		$id_user_tmp = $_GET["e"];
	}

	if( $_GET["id"] != "" ){
		$queryFirst = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
		WHERE id = '".$id."' ");
		$dataFirst = mysqli_fetch_array($queryFirst);
		$id_user_tmp = $dataFirst["id_empleado"];
	}

	

    if( $_POST["objetivo"] != "" ){
        
        $meses = array();
        for($i = 1; $i <= 12; $i++) {
            array_push( $meses, array("mes"=> $i, "meta"=> $_POST["mes_".$i]) );
        }

        if( $_POST["id_registro"] != "" ){
            mysqli_query($connect_desempenio,"UPDATE Objetivos_Colaborador SET 
            objetivo = '".$_POST["objetivo"]."', indicador = '".$_POST["indicador"]."', formula = '".$_POST["formula"]."', fuente = '".$_POST["fuente"]."', 
            meta = '".$_POST["meta"]."', ponderado = '".$_POST["ponderado"]."',  obj_meses = '".json_encode($meses)."', fecha_cumplimiento = '".$_POST["fecha_cumplimiento"]."' WHERE id = '".$_POST["id_registro"]."' ");

            //echo '<script> window.location.href = "?pg=desempenio/objetivo/detalle&id='.$_POST["id_registro"].'";</script>';
        }
        else{
            mysqli_query($connect_desempenio,"INSERT INTO Objetivos_Colaborador (id_empleado, anio, objetivo, indicador, formula, fuente, meta, ponderado, obj_meses, fecha_cumplimiento, created_at) 
            VALUES ( '".$id_user_tmp."', '".$_SESSION['anio']."', '".$_POST['objetivo']."', '".$_POST['indicador']."', '".$_POST['formula']."',   '".$_POST["fuente"]."', '".$_POST["meta"]."', '".$_POST["ponderado"]."', '".json_encode($meses)."', '".$_POST["fecha_cumplimiento"]."', '".$hoy."' )");

            $id_temp = mysqli_insert_id($connect_desempenio);
			
			if($_SESSION['role_plataforma']  == 1){
				echo '<script> window.location.href = "?pg=desempenio/seguimiento";</script>';	
			}
			
			if($_SESSION['role_plataforma']  == 2){
				echo '<script> window.location.href = "?pg=desempenio/seguimiento_equipo";</script>';	
			}
            
        }

	}

    $query = mysqli_query($connect_desempenio,"SELECT * FROM Objetivos_Colaborador 
	WHERE id = '".$id."' ");
    $data = mysqli_fetch_array($query);
    $obj_meses = json_decode($data["obj_meses"], true);

	$queryEmpleados = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$id_user_tmp."' "); 
	$dataEmpleados = mysqli_fetch_array($queryEmpleados);

    include("app/models/Collaborators.php");
	$ClassColaboradores = new Collaborators();

    $colaborador = $ClassColaboradores->colaborador( $connect_valentina, $id_user_tmp );

?>

<style>
    label{
        margin-top: 15px;
    }

</style>

<?php echo $respuesta; ?>



<div class="card" style="margin-bottom: 15px">

    <div class="card-body">
        
        <form action="" method="post">
        <div class="row">
        
            <div class="col-md-12">
                
                <input type="hidden" name="id_registro" value="<?php echo $id; ?>">
                
                <h3>Crear Objetivos Individuales <?php echo $_SESSION["anio"]; ?><br>
					<?php echo $colaborador[0]["nombre_completo"]; ?>
				</h3>
                
                <label>Objetivo Individual *</label>
                <textarea class="form-control" name="objetivo" required><?php echo $data["objetivo"]; ?></textarea>
            </div>
            
            <div class="col-md-4">
                <label>Descripción del Indicador *</label>
                <textarea class="form-control" name="indicador" required><?php echo $data["indicador"]; ?></textarea>
            </div>
            
            <div class="col-md-4">
                <label>Formula</label>
                <textarea class="form-control" name="formula"><?php echo $data["formula"]; ?></textarea>
            </div>
            
            <div class="col-md-4">
                <label>Fuente(s)</label>
                <textarea class="form-control" name="fuente"><?php echo $data["fuente"]; ?></textarea>
            </div>
            
            <div class="col-md-4">
                <label>Meta *</label>
                <input type="text" class="form-control" name="meta" value="<?php echo $data["meta"]; ?>" required>
            </div>
			
			<div class="col-md-4">
                <label>Ponderado *</label>
                <input type="text" class="form-control" name="ponderado" value="<?php echo $data["ponderado"]; ?>" required>
            </div>
            
            <div class="col-md-4">
                <label>Fecha Cumplimiento *</label>
                <input type="date" class="form-control" name="fecha_cumplimiento" value="<?php echo $data["fecha_cumplimiento"]; ?>" required>
            </div>

            <div class="col-md-12">
                <label>Metas</label>
                
                <table class="table table-bordered" width="100%">
                <tr>
                    <?php
                    foreach($Array_Meses as $mes){
                        
                        $meta_mes = 0;
                   
                        foreach($obj_meses as $meta){
                            if($meta["mes"] == $mes[0]){
                                $meta_mes = $meta["meta"];
                            }
                        }
                      
                        
                        $desplegable = '<select class="form-control" name="mes_'.$mes[0].'" required><option value="">...</option>';
                        for ($x = 5; $x <= 3000; $x += 5 ) {
                             if($meta_mes == $x ){
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

                        echo '
                            <td align="center">
                                '.$mes[1].'<br>
                                <input type="text" class="form-control" name="mes_'.$mes[0].'" value="'.$meta_mes.'" required>
                                
                            </td>
                        ';
                    }
                    ?>
                    </tr>
                    
                </table>

                
            </div>
            
            
            <div class="col-md-12" style="margin-top: 20px">
                <p>
                    Recuerde que las metas y objetivos que plantea deben cumplir con los siguientes requerimientos:<br><br>
                    
                    <b>Específicos:</b> Concreto y lo entienden con claridad todos los involucrados.<br>
                    <b>Medibles:</b> Es posible cuantificar los avances periódicos y total del objetivo.<br>
                    <b>Alcanzables:</b> Es ambicioso pero realista.<br>
                    <b>Relevantes:</b> Esta alineado con los Objetivos de la Organización.<br>
                    <b>Basados en el Tiempo:</b> Se puede lograr durante el periodo de evaluación.<br>
                </p>
            </div>
            
            
            <div class="col-md-12" style="margin-top: 15px ">
                <button type="submit" class="btn btn-success btn-sm" >
                    Guardar
                </button>
            </div>
			
			<?php if($_SESSION['role_plataforma']  == 1 || $_SESSION['role_plataforma']  == 2 ){ ?>
			<div class="col-md-12" style="margin-top: 15px " align="right">
                <button type="button" class="btn btn-danger btn-sm" onClick="Eliminar(<?php echo $id; ?>)" >
                    Eliminar
                </button>
            </div>
			<?php } ?>
            
            
            
            
            
        
            
            <!-- ITEM -->
            <div class="col-md-12" style="margin-top: 15px; display: none" align="left">
            
            
                <label><b>Principales metas/actividades de cargo a cumplir para lograr el objetivo</b><br>
                (Escriba de manera clara y completa las metas o actividades que lo van a llevar a cumplir el objetivo propuesto anteriormente.)</label><br>

                <div align="left">
                    <button type="button" class="btn btn-warning btn-sm" onclick="Nuevo_Grupo(this)" style="margin:10px 0px">	
                    <i class="fa fa-plus"></i> Agregar nueva meta/actividad
                    </button>
                </div>
                <?php
                $queryAct = mysqli_query($connect_desempenio,"SELECT * FROM Actividades_Propias WHERE id_objetivo_propio  = '".$id."' AND id_empresa = '".$dtEmpleado['id_empresa']."' AND anio = '".$_SESSION['anio']."' AND id_empleado = '".$data["id_empleado"]."'  ");
                while($dataAct = mysqli_fetch_array($queryAct)){	
                    echo '
                        <div style="margin-bottom:8px">
                            <input type="hidden" name="id_actividad[]" value="'.$dataAct["id"].'"> 
                            <button type="button" class="btn btn-danger btn-sm" onclick="Borrar_Pregunta('.$dataAct["id"].')" style="position: absolute; right: 10px; margin-top: 14px;">	
                                <i class="fa fa-times"></i>
                            </button>
                            <textarea class="form-control" name="actividad[]" required="" placeholder="Ingrese Indicador..." style=" width:47%; display:inline-table;">'.$dataAct["actividad"].'</textarea>
                            <textarea class="form-control" name="indicador[]" required="" placeholder="Ingrese Pregunta..." style=" width:47%; display:inline-table;">'.$dataAct["indicador"].'</textarea>
                        </div>
                    ';
                }
                ?>
            </div>
            
        </div>
        </form>
            
    </div>
    
</div>


<script>


var api = '<?php echo $url; ?>/api/desempenio/';
	
var activar = false;
function Eliminar(val){
    if(activar == false){
        $("#modal_body").html('Estas a punto de eliminar este objetivo. Esta acción es irreversible ¿Estás seguro?<br><br>');
        $("#modal_body").append('<button type="button" class="btn btn-danger" style="margin-right: 10px;" onclick="activar = true; Eliminar('+val+')">Eliminar</button>');
        $("#modal_body").append('<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>');
        $("#modal_general").modal('show');
    }
    else{
        jQuery.ajax({
            url: api+"eliminar_objetivo.php",
            type:'post',
            data: {id: val, url:"?pg=desempenio/seguimiento_equipo"},
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


}

function Nuevo_Grupo(elem,nivel){
    grupo = MatrizGrupo();
    $( elem ).after( grupo);
}


function MatrizGrupo(id_nivel){
    itemg = '';
    itemg += '<div style="margin-bottom:8px">';
    itemg += '<button type="button" class="btn btn-danger btn-sm" onclick="Borrar_Item(this)" style="position: absolute; right: 10px; margin-top: 14px;">	<i class="fa fa-times"></i></button>';
            
    itemg += 	'<input type="hidden" name="id_actividad[]" value="">'; 
    itemg +=	'<textarea class="form-control" name="actividad[]" required placeholder="Descripción del Indicador..." style=" width:47%; display:inline-table;"></textarea>';
    itemg +=	'<textarea class="form-control" name="indicador[]" required placeholder="Fuente(s)" style=" width:47%; display:inline-table;"></textarea>';
    itemg += '</div> ';		
    return itemg;
}
    
var activar = false;
function Borrar_Pregunta(val){
	if(activar == false){
		$("#modal_body").html('Estas a punto de eliminar esta actividad, esta acción es irreversible ¿Estás seguro?<br><br>');
		$("#modal_body").append('<button type="button" class="btn btn-success" style="margin-right: 10px;" onclick="activar = true; Borrar_Pregunta('+val+')">Aprobar</button>');
		$("#modal_body").append('<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>');
		$("#modal_general").modal('show');
	}
	else{
		jQuery.ajax({
			url: api+"borrar_pregunta.php",
			type:'post',
			data: {id: val, url:"?pg=desempenio/objetivos_propios_lista&p=<?php echo $id_periodo; ?>&id=<?php echo $id; ?>"},
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


}

var activar_objetivo = false;
function Borrar_Objetivo_Propio(val){
    if(activar_objetivo == false){
        $("#modal_body").html('Estas a punto de eliminar este objetivo propio y sus actividades relacionadas, esta acción es irreversible ¿Estás seguro?<br><br>');
        $("#modal_body").append('<button type="button" class="btn btn-danger" style="margin-right: 10px;" onclick="activar_objetivo = true; Borrar_Objetivo_Propio('+val+')">Eliminar</button>');
        $("#modal_body").append('<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>');
        $("#modal_general").modal('show');
    }
    else{
        jQuery.ajax({
            url: api+"borrar_objetivo_propio.php",
            type:'post',
            data: {id: val, url:"?pg=desempenio/objetivos_propios_lista&p=<?php echo $id_periodo; ?>"},
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


}
	

function Borrar_Item(elem){
    $(elem).parent().remove();
}
	
</script>









<script>
    
    function ValidarPorcentajes(){
        permirit_enviar = true;
        
        form = $("#form_objetivos_lista :input");
        
        form.each(function() {
            
            if( $(this)[0].type == 'select-one' ){
                if( $(this)[0].value == "" ){
                    permirit_enviar = false;
                    console.log( $(this)[0].value );
                    console.log("Sin datos");
                }
            }

        });
        
        if(permirit_enviar == true){
            $("#form_emviar_aprobacion").submit();       
        }
        else{
            alert("Recuerde que debe seleccionar todos los desplegables para poder enviar la aprobación.");
        }

    }
</script>




