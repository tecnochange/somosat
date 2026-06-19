<li class="side-nav-item" id="desempenio_menu">
    
    <!-- ESTRUCTURA -->
    <a href="#desplegable_desempenio" data-bs-toggle="collapse"  aria-expanded="true" aria-controls="desplegable_desempenio" class="side-nav-link">
        <table width="100%">
            <tr>
                <td width="40"><i class="bx bx-trophy icoGroup icon_lateral" style=" margin-right: 7px;"></i></td>
                <td><span class="text_lateral" style="font-weight: bold; color: #ff8300;">Objetivos</span></td>
                <td width="30" align="right"><i class="bx bx-down-arrow-alt"></i></td>
            </tr>
        </table>
    </a>
	
	
	
    
    <!-- OPCIONES -->
    <ul class="collapse list-unstyled" id="desplegable_desempenio">
		
		
		<div style="padding: 10px;" > 
            <form action="" method="post">
				<input type="hidden" name="csrf" value="<?php echo $_SESSION['token']; ?>">
                <select class="form-control form-control-sm" name="anio_select" style="font-weight: bold;" >
                    <option value="">Selecciona Año...</option>
                    <?php 
                        $queryAnios = mysqli_query($connect_valentina,"SELECT * FROM Licencias_Empresas WHERE id_empresa = '".$_SESSION["id_empresa"]."' ");
                        while($dataAnios = mysqli_fetch_array($queryAnios)){
                            if($dataAnios["anio"] == $_SESSION['anio']){ 
                                echo '<option value="'.$dataAnios["anio"].'" selected>'.$dataAnios["anio"].'</option>';
                            }
                            else{
                                echo '<option value="'.$dataAnios["anio"].'">'.$dataAnios["anio"].'</option>';
                            }
                        }
                    ?>
                </select>

                <button type="submit" class="btn btn-success btn-sm btn-block" style=" margin-top: 10px;">
                    Seleccionar
                </button>
            </form>
        </div>
		
		 <?php if( $_SESSION['role_plataforma'] == 1 || $_SESSION['role_plataforma'] == 2 || $_SESSION['role_plataforma'] == 3  ){ ?>
			<li class="sub_items" id="bt_desempenio_mis_objetivos" style="display: none"> 
                <a href="<?php echo $url; ?>?pg=desempenio/mis_objetivos">Mis objetivos <?php echo $_SESSION['anio']; ?></a> 
            </li>
			<li class="sub_items" id="bt_desempenio_mi_seguimiento"> 
                <a href="<?php echo $url; ?>?pg=desempenio/mi_seguimiento">Mi Seguimiento</a> 
            </li>
		<?php } ?>
		
		<?php if( $_SESSION['role_plataforma'] == 1  ){ ?>
			<li class="sub_items" id="bt_desempenio_autorizaciones" style="display: none"> 
                <a href="<?php echo $url; ?>?pg=desempenio/autorizaciones">Autorizaciones</a> 
            </li>
		<?php } ?>
		<?php if( $_SESSION['role_plataforma'] == 2  ){ ?>
			<li class="sub_items" id="bt_desempenio_autorizaciones_equipo" style="display: none"> 
                <a href="<?php echo $url; ?>?pg=desempenio/autorizaciones_equipo">Autorizaciones Equipo</a> 
            </li>
		<?php } ?>
		<?php if( $_SESSION['role_plataforma'] == 1  ){ ?>
			<li class="sub_items" id="bt_desempenio_seguimiento"> 
                <a href="<?php echo $url; ?>?pg=desempenio/seguimiento">Seguimiento Individual</a> 
            </li>
			<li class="sub_items" id="bt_desempenio_seguimiento_avance"> 
                <a href="<?php echo $url; ?>?pg=desempenio/seguimiento_avance">Seguimiento Avance</a> 
            </li>
			<li class="sub_items" id="bt_desempenio_informes" style="display: none"> 
                <a href="<?php echo $url; ?>?pg=desempenio/informes">Informes</a> 
            </li>
		<?php } ?>
		<?php if( $_SESSION['role_plataforma'] == 2  ){ ?>
			<li class="sub_items" id="bt_desempenio_seguimiento"> 
                <a href="<?php echo $url; ?>?pg=desempenio/seguimiento_equipo">Seguimiento Equipo</a> 
            </li>
			<li class="sub_items" id="bt_desempenio_informes_equipo" style="display: none"> 
                <a href="<?php echo $url; ?>?pg=desempenio/informes_equipo">Informes Equipo</a> 
            </li>
		<?php } ?>
		
    </ul>
    
</li>

























