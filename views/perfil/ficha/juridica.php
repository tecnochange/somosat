<script>  
$(document).ready(function(){
    $("#administrativo_menu").addClass("active");
    $("#desplegable_administrativo").show();
    $("#bt_adm_colaboradores").addClass("active_item");
});
</script>

<style>
    .form-control{
        text-transform: uppercase;
		color: #fa3f3f;
    }
	label{
		color: #242934;
	}
</style>

<?php

    $hoy = date("Y-m-d H:i:s");

    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    //CREAR EDITAR COLABORADOR DATOS ADICIONALES
    if($_POST["guardar_adicional"] != ""){

        if($_POST["id_informacion"] != ""){
            
            $sentencia = "
            UPDATE Empleados_Legales SET 
                vinculacion_personal = '".$_POST["vinculacion_personal"]."',  
                vinculo_estilo = '".$_POST["vinculo_estilo"]."',  
                vinculo_persona = '".$_POST["vinculo_persona"]."',  
                nombre_cargo = '".$_POST["nombre_cargo"]."',  
                manejo_recursos = '".$_POST["manejo_recursos"]."',  
                cargo_publico = '".$_POST["cargo_publico"]."',  
                reconocimiento_publico = '".$_POST["reconocimiento_publico"]."',  
                familiares_publico = '".$_POST["familiares_publico"]."',
                familiares_poder = '".$_POST["familiares_poder"]."',
                reconocimiento = '".$_POST["reconocimiento"]."',
                expuesta_politicamente = '".$_POST["expuesta_politicamente"]."',
                moneda = '".$_POST["moneda"]."',
                operaciones = '".$_POST["operaciones"]."',
                tipo = '".$_POST["tipo"]."',
                declaro = '".$_POST["declaro"]."'  
                WHERE id = '".$_POST["id_informacion"]."'
            ";
            //print_r($sentencia);
            
            mysqli_query($connect_valentina, $sentencia);

            $respuesta = '
                <div class="alert alert-success" role="alert">
                    La información ha sido guardada con éxito.
                </div>
            ';
        }
        else{
            
            $sentencia = "
            INSERT INTO Empleados_Legales (
                id_empleado,
                vinculacion_personal, 
                vinculo_estilo,
                vinculo_persona,
                nombre_cargo,
                manejo_recursos,
                cargo_publico,
                reconocimiento_publico,
                familiares_publico,
                familiares_poder,
                reconocimiento,
                expuesta_politicamente,
                moneda,
                operaciones,
                tipo,
                declaro                
            ) 
            VALUES
            (
                '".$_SESSION["id_user_valentina"]."', 
                '".$_POST["vinculacion_personal"]."', 
                '".$_POST["vinculo_estilo"]."', 
                '".$_POST["vinculo_persona"]."', 
                '".$_POST["nombre_cargo"]."', 
                '".$_POST["manejo_recursos"]."', 
                '".$_POST["cargo_publico"]."', 
                '".$_POST["reconocimiento_publico"]."', 
                '".$_POST["familiares_publico"]."',
                '".$_POST["familiares_poder"]."',
                '".$_POST["reconocimiento"]."',
                '".$_POST["expuesta_politicamente"]."',
                '".$_POST["moneda"]."',
                '".$_POST["operaciones"]."',
                '".$_POST["tipo"]."',
                '".$_POST["declaro"]."' 
            );
            ";
            
            //print_r($sentencia);
            mysqli_query($connect_valentina, $sentencia); 
            
            $respuesta = '
                <div class="alert alert-success" role="alert">
                  Informacion Guardada.
                </div>
            ';

        }
 
        
    }
    
    
    $query = mysqli_query($connect_valentina,"SELECT * FROM Empleados WHERE id = '".$_SESSION["id_user_valentina"]."' ");
    $data = mysqli_fetch_array($query);

    $queryInforma = mysqli_query($connect_valentina,"SELECT * FROM Empleados_Legales WHERE id_empleado = '".$_SESSION["id_user_valentina"]."' ");
    $dataInforma = mysqli_fetch_array($queryInforma);
?>



<div class="container-fluid"> 
    
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="">Detalle</a></li>
      </ol>
    </nav>
    
    <?php echo $respuesta; ?>

    <div class="card">
        
        <!-- PESTAÑAS -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos" class="nav-link ">Básicos</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/adicionales" class="nav-link">Adicionales</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/preferencia" class="nav-link ">Preferencias</a>
            </li> 
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/academico" class="nav-link ">Académico</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/laboral" class="nav-link ">Laboral</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/trayectoria" class="nav-link ">Trayectoria</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/familiares" class="nav-link ">Familiares</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $url; ?>?pg=perfil/ficha/juridica" class="nav-link active" >Jurídica</a>
            </li>
        </ul>
        
        <div class="card-body">   
    
            <form action="" method="post">
            <div class="row">

                <div class="col-md-12">
                    <h4>Declaración Posibles Conflictos de Interés</h4>
                    <input type="hidden" name="id_informacion" value="<?php echo $dataInforma["id"]; ?>">
                    <input type="hidden" name="guardar_adicional" value="true">
                </div>


                <div class="col-md-6 " style="margin-bottom: 10px">
                    <label>¿Tiene relación con personal vínculado a ESTILO INGENIERIA S.A.?</label>
                    <select class="form-control" name="vinculacion_personal" required onChange="OcultarConflictos(this.value)">
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["vinculacion_personal"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6 cont_conflicto" style="margin-bottom: 10px">
                    <label>¿Qué tipo de vínculo tiene la persona con ESTILO INGENIERIA S.A?</label>
                    <select class="form-control" name="vinculo_estilo" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Vinculo_Estilo as $tipo){  
                            if($tipo[0] == $dataInforma["vinculo_estilo"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6 cont_conflicto" style="margin-bottom: 10px">
                    <label>¿Qué tipo de vínculo tiene usted con la persona?</label>
                    <select class="form-control" name="vinculo_persona" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Vinculo_Personal as $tipo){  
                            if($tipo[0] == $dataInforma["vinculo_persona"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6 cont_conflicto" style="margin-bottom: 10px">
                    <label>Nombre y cargo de la persona con la que tiene el vínculo:</label>
                    <input type="text" class="form-control" name="nombre_cargo" value="<?php echo $dataInforma["nombre_cargo"]; ?>">
                </div>
				
				<script>
					function OcultarConflictos(opt){
						if(opt == 2){
							$(".cont_conflicto").hide();
						}
						else{
							$(".cont_conflicto").show();
						}
					}
				</script>

                <div class="col-md-12">
                    <h4>Declaración Persona Expuesta Públicamente (PEP)</h4>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Usted maneja o ha manejado recursos públicos? (entiéndase por recursos públicos los ingresos que percibe el estado de cualquier naturaleza)</label>
                    <select class="form-control" name="manejo_recursos" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["manejo_recursos"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                            
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Usted goza de reconocimiento público? Ejm: Es reconocido en medios de comunicación por alguna cualidad propia.</label>
                    <select class="form-control" name="reconocimiento_publico" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["reconocimiento_publico"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Por el cargo o actividad alguno de sus familiares relacionados maneja recursos públicos?</label>
                    <select class="form-control" name="familiares_publico" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["familiares_publico"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Por el cargo o actividad alguno de sus familiares relacionados ejerce algún grado de poder público?</label>
                    <select class="form-control" name="familiares_poder" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["familiares_poder"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Por la actividad u oficio, goza de reconocimiento público general?</label>
                    <select class="form-control" name="reconocimiento" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["reconocimiento"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Usted ejerce o ha ejercido algún cargo con una entidad pública?</label>
                    <select class="form-control" name="cargo_publico" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["cargo_publico"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Existe algún vínculo entre usted y una persona considerada expuesta políticamente?</label>
                    <select class="form-control" name="expuesta_politicamente" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales as $tipo){  
                            if($tipo[0] == $dataInforma["expuesta_politicamente"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <h4>Actividades en Operaciones Internacionales</h4>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿Realiza operaciones en moneda extranjera o criptomonedas?</label>
                    <select class="form-control" name="moneda" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_legales_Moneda as $tipo){  
                            if($tipo[0] == $dataInforma["moneda"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6" style="margin-bottom: 10px">
                    <label>¿De que tipo?</label>
                    <select class="form-control" name="operaciones" required>
                        <option value="">Selecciona...</option>
                        <?php
                        foreach($Array_Operaciones as $tipo){  
                            if($tipo[0] == $dataInforma["operaciones"]){
                                echo '<option value="'.$tipo[0].'" selected>'.$tipo[1].'</option>';  
                            }
                            else{
                                echo '<option value="'.$tipo[0].'">'.$tipo[1].'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <h4>Declaración de Origen de Los Recursos</h4>
                </div>

                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Con el propósito de dar cumplimiento a lo señalado por las normas legales en materia de prevención de Lavado de Activos, Financiación del Terrorismo y Financiación de la Proliferación de Armas de Destrucción Masiva, Circular Básica Jurídica Capítulo X y la Circular 100-16 expedida por la Superintendencia de Sociedades, y demás normas legales concordantes, de manera voluntaria y bajo la gravedad de juramento, realizo la siguiente declaración de origen de recursos:<br><br>
                    1. Declaro que los bienes y recursos que poseo y he conseguido en la presente solicitud no proviene de ninguna actividad ilícita de las contempladas en el Código Penal Colombiano o en cualquier norma que lo modifique o adicione.<br><br>
                    2. Declaro que mis recursos provienen de</label>
                    <input type="text" class="form-control" name="declaro" value="<?php echo $dataInforma["declaro"]; ?>">
                </div>

                <div class="col-md-12">
                    <h2>Compromiso Con el Código de Ética y Demás Políticas de Cumplimiento</h2>
                </div>
                <div class="col-md-12" style="margin-bottom: 10px">
                    <label>Manifiesto que he leído íntegramente el Código de Ética y Conducta de ESTILO INGENIERIA S.A. y que comprendo plenamente el contenido del mismo.<br>
                    Entiendo que el´Código de Ética y Conducta establece un marco ético y es guía de conducta que estoy obligado a seguir y acatar en el desarrollo de mis actividades de trabajo dentro de la empresa, sede de trabajo y demás lugares en donde ejecute labores en nombre de ESTILO INGENIERIA S.A.<br>
                    Manifiesto mi compromiso de que elmismo sea un instrumento de trabajo que utilizaré para guiar mi conducta dentro y fuera de la compañia.<br>
                    Me comprometo a denunciar cualquier situación de conflicto de interés y actos en los que se observe un incumplimiento al Código de Ética y Conducta, haciéndolo con responsabilidad y respeto a través del correo electrónico canaltransparente@estiloingenieria.com igualmete manifiesto que conozco y me comprometo a cumplir las demás políticas de Cumplimeto que establesca la compañía.<br>
                    Soy consciente y estoy de acuerdo con las sanciones que laboralmente pueda aplicar la Compañía en caso de incumplimiento de estas políticas.<br>
                    Puede conocer el Código de Ética y demás políticas de Cumplimiento en <a href="https://www.estiloingenieria.com/politicas-de-cumplimiento/" target="_blank">https://www.estiloingenieria.com/politicas-de-cumplimiento/ </a> y diligenciar el compromiso con el Código de Ética y Conducta ingresando a: 
                    <a href="https://forms.gle/X3M7WJsAcPYK94yq9" target="_blank"> https://forms.gle/X3M7WJsAcPYK94yq9</a>
                    </label>

                </div>
                
                <div class="col-md-12" style="margin-bottom: 20px">	
                    <label>* Tratamiento de datos</label>
                    <table >
                        <tr>
                            <td width="50">
                                <input type="checkbox" style=" width: 20px; height: 20px;" name="acepto" checked >
                            </td>
                            <td style="font-size: 12px;">
                                Con el diligenciamiento de este formulario autorizo expresamente a ESTILO INGENIERÍA para que trate mis datos personales conforme a la Política de Tratamiento de Datos que dispone, cumpliendo en todo caso las disposiciones de la Ley 1581 de 2012 y demás normas aplicables. Manifiesto que he leído y aceptado la Política de Tratamiento de Datos de ESTILO INGENIERÍA, a la cual he accedido a través del siguiente enlace:<br>
                            </td>
                        </tr>
                    </table>
                    <a href="https://www.estiloingenieria.com/wp-content/uploads/2021/10/politica-de-tratamiento.pdf" target="_blank" style="color: #005CFF">
                        https://www.estiloingenieria.com/wp-content/uploads/2021/10/politica-de-tratamiento.pdf
                    </a>
                </div>
                      


                <div class="col-md-12" style="margin-bottom: 10px">
                    <button type="submit" class="btn btn-primary btn-block btn-sm" >
                        <i class="fa fa-check"></i> Guardar
                    </button>
                </div>

            </div>
            </form>
        </div> 
        
    </div>
    
</div>




<script>
    $("#bt_adm_colaboradores").addClass("active_item");
    $("#administrativo_menu").addClass("active");
    $('#administrativo_menu .collapse').collapse();
    
    $('#administrativo_menu').show();
</script>

<script>
var api = '<?php echo $url; ?>/api/administrar/';

function Cargar_Posiciones(id_cargo){
    
    
    jQuery.ajax({
        url: api+"cargar_posiciones.php",
        type:'post',
        data: {id_cargo: id_cargo, id_posicion: <?php echo $id_posicion; ?>, url:""},
        }).done(function (resp){
            $("#id_posicion").html(resp);
        })
        .fail(function(resp) {
            console.log(resp);
        })
        .always(function(resp){
        }
    );
    
}
    
    //PARA CAMBIAR A MAYUSCULAS
    $(document).ready( function () {
        $("input").on("keypress", function () {
           $input=$(this);
           setTimeout(function () {
            $input.val($input.val().toUpperCase());
           },50);
        });
    });

</script>

<?php
if($_SESSION["id_colaborador_edit"]){
	echo '
	<script>
		$( document ).ready(function() {
 			OcultarConflictos('.$dataInforma["vinculacion_personal"].');
		});
	</script>
	';
}
?>



