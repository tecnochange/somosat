<script>
	$(document).ready(function() {
		$("#bt_muro").addClass("active");
		$("#mod_home").addClass("active_qa");
	});
</script>
<meta charset="UTF-8">
<style>
	.iconos_dash {
    font-size: 27px;
    margin: 10px 6px;
    color: #ffffff !important;
    padding: 4px;
    border-radius: 10px;
    transition: 0.5s all;
}

.iconos_dash:hover {
    transform: rotate(360deg);
}

.alto_accesos {
    top: 80px;
    height: 85vh;
    overflow: auto;
}

@media (max-width: 768px) {
    .alto_accesos {
        height: auto;
        overflow: auto;
    }

    .iconos_dash {
        margin: 10px 2px;
    }
}

/* === Birthday Card === */
.birthday-card {
    border: 3px solid #00295e;
    border-radius: 20px;
    background: url('../../recursos/img/cumple.gif') no-repeat center center;
    background-size: cover;
    box-shadow: 0 6px 15px rgba(0, 41, 94, 0.5);
    padding: 10px;
    position: relative;
    overflow: hidden;
    color: white;
}


.birthday-title {
    color: #00295e;
    font-weight: bold;
    font-size: 1.8rem;
    text-shadow: 1px 1px #e77b09;
    margin-bottom: 20px;
}

.birthday-scroll {
    max-height: 300px;
    overflow-y: auto;
    padding: 5px 15px;
}

.birthday-card-item {
    display: flex;
    align-items: center;
    background-color: #f0f6fb;
    border: 2px dashed #00295e;
    border-radius: 15px;
    padding: 12px;
    margin-bottom: 15px;
    transition: transform 0.3s;
}

.birthday-card-item:hover {
    transform: scale(1.03);
    background-color: #e6eef7;
}

.birthday-photo {
    width: 70px;
    height: 70px;
    background-size: cover;
    background-position: center;
    border-radius: 50%;
    margin-right: 15px;
    border: 3px solid #00295e;
    box-shadow: 0 0 10px rgba(0, 41, 94, 0.4);
}

.birthday-name {
    font-size: 1.2rem;
    color: #00295e;
    font-weight: bold;
    text-align: left;
}

.birthday-none {
    text-align: center;
    font-size: 1.2rem;
    color: #00295e;
    background-color: #e6eef7;
    padding: 15px;
    border-radius: 15px;
    margin-top: 10px;
}

.cake-emoji {
    font-size: 1.5rem;
    display: block;
    margin-top: 5px;
}

/* 🎈 Animación de globos */
@keyframes floatBalloon {
    0% {
        transform: translateY(30px) rotate(0deg);
        opacity: 0.7;
    }
    50% {
        transform: translateY(-20px) rotate(5deg);
        opacity: 1;
    }
    100% {
        transform: translateY(30px) rotate(0deg);
        opacity: 0.7;
    }
}

.birthday-balloon {
    font-size: 2rem;
    animation: floatBalloon 3s ease-in-out infinite;
    display: inline-block;
    margin: 0 5px;
    color: #e77b09; /* globos naranjas */
}

/* 🎂 Animación de pastel */
@keyframes bounceCake {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.cake-emoji {
    display: inline-block;
    animation: bounceCake 1s infinite;
    font-size: 2rem;
    color: #00295e; /* pastel en azul */
}

/* 🎊 Fondo con confeti */
.birthday-card::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background-image: radial-gradient(circle, #e77b09 2px, transparent 2px),
                      radial-gradient(circle, #00295e 2px, transparent 2px),
                      radial-gradient(circle, #6ca6d9 2px, transparent 2px);
    background-size: 30px 30px;
    animation: confettiMove 10s linear infinite;
    z-index: 0;
    opacity: 0.3;
}

@keyframes confettiMove {
    0% { transform: translate(0, 0); }
    100% { transform: translate(100px, 100px); }
}

/* Contenido por encima */
.birthday-card .card-body {
    position: relative;
    z-index: 1;
}

/* Botón con brillo */
.btn-glow {
    box-shadow: 0 0 8px rgba(0, 41, 94, 0.6);
    transition: all 0.3s ease-in-out;
    background-color: #00295e;
    color: #fff;
    border: none;
}

.btn-glow:hover {
    box-shadow: 0 0 20px rgba(231, 123, 9, 1);
    transform: translateY(-2px);
    background-color: #e77b09;
}

    
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


<div class="container" style="max-width: 1000px">
	<div class="row">
		<div class="col-md-6">

			<!-- BANNER PRINCIPAL -->
			<div style="margin-bottom: 15px; border-radius: 10px; overflow: hidden">
				<div class="swiper-container" id="banner_general">
					<div class="swiper-wrapper">
						<?php
						$queryBan = mysqli_query($connect_endomarketing, "SELECT * FROM Banners WHERE estado = 1 AND id_empresa = 1 ORDER BY orden ASC ");
						while ($dataBan = mysqli_fetch_array($queryBan)) {
							echo '
							<div class="swiper-slide">
								<a href="' . $dataBan["link"] . '" target="_blank" title="' . $dataBan["titulo"] . '">
								<img src="resources/' . $dataBan["archivo"] . '" style="width:100%">
								</a>
							</div>';
						}
						?>
					</div>
					<div class="swiper-pagination"></div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
			<!--
			<div style="margin-bottom: 15px;">
				<div id="banner_general" class="carousel slide" data-bs-ride="carousel">
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img src="../../assets/img/banners-01 (1).jpg" class="d-block w-100" alt="BannerI 1">
						</div>
						<div class="carousel-item">
							<img src="../../assets/img/banners-03 (1).jpg" class="d-block w-100" alt="BannerI 2">
						</div>
						<div class="carousel-item">
							<img src="../../assets/img/Campan01.png" class="d-block w-100" alt="BannerI 3">
						</div>
						<div class="carousel-item">
							<img src="../../assets/img/Campan03.png" class="d-block w-100" alt="BannerI 4">
						</div>
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#banner_general" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Previous</span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#banner_general" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden">Next</span>
					</button>
				</div>
			</div>
            -->
			<div class="card" style="margin-bottom: 15px">
				<div class="card-body" align="center">

					<a href="<?php echo $url; ?>?pg=home/muro&p=3">
						<i class="bx bx-star iconos_dash" style="background-color: #5c349e;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reconocimientos"></i>
					</a>

					<a href="<?php echo $url; ?>?pg=home/muro&p=9">
						<i class="bx bx-news iconos_dash" style="background-color: #3f51b5;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Noticias"></i>
					</a>

					<a href="<?php echo $url; ?>?pg=home/muro&p=4">
						<i class="bx bx-book-bookmark iconos_dash" style="background-color: #e31890;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clasificados"></i>
					</a>

					<a href="<?php echo $url; ?>?pg=home/muro&p=5">
						<i class="bx bx-happy-beaming iconos_dash" style="background-color: #009688;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Nuestra Gente"></i>
					</a>

					<a href="<?php echo $url; ?>?pg=home/muro&p=7">
						<i class="bx bx-gift iconos_dash" style="background-color: #ffc107;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Celebraciones"></i>
					</a>

					<a href="<?php echo $url; ?>?pg=home/muro&p=8">
						<i class="bx bx-spa iconos_dash" style="background-color: #ff5722;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bienestar"></i>
					</a>
				</div>
			</div>
			<?php include("views/home/layouts/publicaciones.php"); ?>
		</div>

		<div class="col-md-6">

			<div class="sticky-md-top alto_accesos">

				<div class="card" style="margin-bottom: 15px">
					<div class="card-body">
						<div class="d-flex flex-row align-items-center">
							<div style="background-image: url(<?php echo $user_log["foto"]; ?>); width: 80px; height: 80px;" class="min_foto_perfil">
							</div>
							<div class="d-flex flex-column">
								Bienvenido<br>
								<h3 class="has__text__orange mb-0" style="font-size: 20px"><?php echo $user_log["nombre"] . " " . $user_log["nombre_2"] . " " . $user_log["apellidos"] . " " . $user_log["apellidos_2"]; ?></h3>
								<span class="has__text__gray__level__tree"><?php echo $user_log["cargo"]; ?></span>
								<span class="has__text__gray__level__tree"><?php echo $user_log["txt_role"]; ?></span>
							</div>
						</div>
						</table>
					</div>
				</div>

				<div class="card birthday-card" style="margin-bottom: 15px;" align="right">
                    <div class="card-body text-center">

                        <h4 class="birthday-title">
                            <span class="birthday-balloon">🎈</span>
                            ¡Feliz Cumpleaños!
                            <span class="birthday-balloon">🎈</span>
                        </h4>

                        <div class="cake-emoji">🎂</div>

                        <div class="birthday-scroll">
                            <?php
                            // Asegurar codificación UTF-8
                            header("Content-Type: text/html; charset=UTF-8");
                            mysqli_set_charset($connect_valentina, "utf8");

                            $mes_hoy = date("m");
                            $dia_hoy = date("d");

                            $queryCumple = mysqli_query($connect_valentina, "
                                SELECT c.nombre, c.nombre_2, c.apellidos, c.apellidos_2, c.foto_formal 
                                FROM Empleados c
                                INNER JOIN Empleados_Adicionales ea ON ea.id_empleado = c.id
                                WHERE MONTH(ea.fecha_nacimiento) = '$mes_hoy'
                                  AND DAY(ea.fecha_nacimiento) = '$dia_hoy'
                                  AND c.estado <> 2
                            ");

                            if ($queryCumple->num_rows > 0) {
                                while ($dataCumple = mysqli_fetch_array($queryCumple)) {
                                    $foto = $dataCumple["foto_formal"] ? $dataCumple["foto_formal"] : "default.jpg";

                                    echo '
                                    <div class="birthday-card-item animate__animated animate__bounceIn">
                                        <div class="birthday-photo" style="background-image: url(' . $url . '/recursos/' . $foto . ');"></div>
                                        <div class="birthday-name">
                                            🎉 <b>' . $dataCumple["nombre"] . ' ' . $dataCumple["nombre_2"] . ' ' . $dataCumple["apellidos"] . ' ' . $dataCumple["apellidos_2"] . '</b> 🎁<br>
                                            <span class="cake-emoji">🎊🎂🎉</span>
                                        </div>
                                    </div>';
                                }
                            } else {
                                echo '
                                <div class="birthday-none animate__animated animate__fadeIn">
                                    🎈 <b>No hay cumpleaños hoy, ¡pero sigue sonriendo! 😀</b>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            
                <div class="card" style="margin-bottom: 15px; ">
					<div class="card-body" align="center">

						<h4>Accesos directos</h4>
						
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?php echo $url; ?>?pg=perfil/ficha/mis_datos" class="flex-fill">
                                <button type="button" class="btn btn-primary w-100 btn-glow" style="margin-top: 10px">
                                    <i class="bx bx-user"></i> Actualizar mis datos
                                </button>
                            </a>
                            <a href="<?php echo $url; ?>?pg=valoracion/realizar_valoracion" class="flex-fill">
                                <button type="button" class="btn btn-primary w-100 btn-glow" style="margin-top: 10px">
                                    <i class="bx bx-equalizer"></i> Mis Evaluaciones
                                </button>
                            </a>
                            <?php if($user_log["role"] == 1){ ?>
                            <a href="<?php echo $url; ?>/?pg=seleccionar_perfil&t=1" class="flex-fill">
                                <button type="button" class="btn btn-primary w-100 btn-glow" style="margin-top: 10px">
                                    Administrador 
                                </button>
                            </a>
                            <a href="<?php echo $url; ?>?pg=seleccionar_perfil&t=2" class="flex-fill">
                                <button type="button" class="btn btn-primary w-100 btn-glow" style="margin-top: 10px">
                                    Referente
                                </button>
                            </a>
                            <?php } ?> 
                        </div>

					</div>
				</div>



				<div class="card" style="margin-bottom: 15px; display: none">

					<div class="card-body">

						<div class="row">
							<div class="col-6" align="center" style="display: none">
								<a href="https://www.linkedin.com/learning-login/" target="_blank">
									<button type="button" class="btn btn-primary mb-2" style="width: 100%">
										LinkedIn Learning
									</button>
								</a>
							</div>

							<div class="col-6" align="center">
								<a href="https://ath01.prd.mykronos.com/authn/XUI/?realm=/ricardoperezsa_prd_01#login&goto=https://ricardoperezsa.prd.mykronos.com:443/" target="_blank">
									<button type="button" class="btn btn-primary mb-2" style="width: 100%">
										Workforce Dimensions
									</button>
								</a>
							</div>

							<div class="col-6" align="center">
								<a href="https://www.netsuite.com/portal/home.shtml" target="_blank">
									<button type="button" class="btn btn-primary mb-2" style="width: 100%">
										NetSuite
									</button>
								</a>
							</div>

							<div class="col-6" align="center">
								<a href="https://www.infosrpsa.com/Autoservicio/f?p=103:101:9285237430338" target="_blank">
									<button type="button" class="btn btn-primary mb-2" style="width: 100%">
										InfoswebHR
									</button>
								</a>
							</div>

							<div class="col-6" align="center">
								<a href="https://ricardoperez.sharepoint.com/sites/SobreRuedasPortalInterno/SitePages/Galeria-de-Fotos.aspx?source=https%3A%2F%2Fricardoperez.sharepoint.com%2Fsites%2FTest2%2FSitePages%2FForms%2FByAuthor.aspx/" target="_blank">
									<button type="button" class="btn btn-primary mb-2" style="width: 100%">
										GalerÃ­a de Fotos
									</button>
								</a>
							</div>

							<div class="col-6" align="center">
								<a href="https://ricardoperez.sharepoint.com/sites/SobreRuedasPortalInterno/SitePages/Galer%C3%ADa-de-v%C3%ADdeos.aspx/" target="_blank">
									<button type="button" class="btn btn-primary mb-2" style="width: 100%">
										GalerÃ­a de VÃ­deo
									</button>
								</a>
							</div>
						</div>

					</div>
				</div>



			</div>
		</div>



	</div>


</div>

<script>
	$(document).ready(function() {

		var swiper = new Swiper('.swiper-container', {
			autoHeight: true, //enable auto height
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			autoplay: {
				delay: 3000,
			},
		});

	});
</script>