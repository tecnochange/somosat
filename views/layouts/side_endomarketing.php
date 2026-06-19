<li class="menu_groups" data-bs-toggle="collapse" data-bs-target="#menuEndomarketing" aria-expanded="true" id="mod_endomarketing">
	<table width="100%">
		<tr>
			<td width="25">
				<i class="bx bx-star menu_icon"></i>
			</td>
			<td class="text_lateral">
				Endomarketing
			</td>
			<td width="30" align="right">
				<i class="bx bx-arrow-to-bottom" style="color: #9f9f9f;"></i>
			</td>
		</tr>
	</table>
</li>

<?php $mstrr_5 = false; ?>

<div class="collapse" id="menuEndomarketing">

	<?php if ($VALIDAR_MENU["endomarketing_dashboard"]) { $mstrr_5 = true; ?>

		<a href="<?php echo $url; ?>?pg=endomarketing/dashboard">
			<li class="menu_sub_items" id="bt_endo_publicar">
				Publicar
			</li>
		</a>

	<?php } ?>


	<?php if ($VALIDAR_MENU["endomarketing_banners"]) { $mstrr_5 = true; ?>
		<a href="<?php // echo $url; 
					?>?pg=endomarketing/banners">
			<li class="menu_sub_items" id="bt_endo_banners">
				Banners
			</li>
		</a>

	<?php } ?>

	<!-- <a href="<?php // echo $url; 
					?>?pg=endomarketing/herramientas">
		<li class="menu_sub_items" id="bt_endo_tools">
			Herramientas
		</li>
	</a>
	<a href="<?php // echo $url; 
				?>?pg=endomarketing/tutoriales">
		<li class="menu_sub_items" id="bt_endo_tutoriales">
			tutoriales
		</li>
	</a> -->

</div>

<?php 
if($mstrr_5 == false){ 
	echo '<script> $("#mod_endomarketing").hide(); </script>';
}
?>