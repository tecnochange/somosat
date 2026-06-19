<style>
	.chat{
		height: 300px;
		max-height: 500px;
		overflow: auto;
		margin-bottom: 20px;
		border-radius: 6px;
		padding: 20px 10px;
		background-color: #f3f3f3;
	}
	.pregunta{
		padding: 10px 20px;
		border-radius: 10px;
		margin-bottom: 20px;
		text-align: left;
		background-color: #87b53f45;
		width: 90%;
	}
	
	.respuesta{
		padding: 10px 20px;
		border-radius: 10px;
		margin-bottom: 20px;
		text-align: left;
		background-color: #03a9f42b;
		width: 90%;
		margin-left: 10%;
	}
	.autor{
		width: fit-content;
		background-color: #ffffff;
		border-radius: 30px;
		padding: 2px 10px;
		font-size: 10px;
		margin-top: -24px;
	}
	.card_base{
		background-color: #424247;
    	color: #ffffff;
	}
	
	
	.parlante{
		float: right;
		width: 28px;
		background-color: #f3901d;
		border-radius: 20px;
		padding: 4px;
		padding-left: 7px;
		margin-top: -19px;
		color: #ffffff;
		cursor: pointer; 
	}
</style>

<?php 
	$id = $_GET["id"];
	$hoy = date("Y-m-d H:i:s");
?>

<div class="container" style="max-width: 700px">
	
	<div class="row">

		<!-- CHAT -->
		<div class="col-md-12">
			<div class="card" >
		
				<div class="card-header">
					<h3>Asistente IA</h3>
					<i class="bx bx-volume-mute parlante" onClick="CancelarVoz()" style="background-color: #F44336; display:none"></i>
					<input type="hidden" id="voz_sintetica" value="Microsoft Raul - Spanish (Mexico)">
				</div>

				<div class="card-body">

					<label>
						Nuestra inteligencia artificial responderá sus pregunta basado en la información que corresponda con nuestra plataforma.<br><br>
						<b>Ej: ¿Cual es el objetivo de esta plataforma?</b><br><br>
					</label>

					<div class="chat" id="chat"></div>
					
					<table width="100%" style="margin-bottom: 20px">
						<tr>
							<td>
								<input type="text" class="form-control" id="pregunta" placeholder="Por favor ingrese su pregunta...">
							</td>
							<td width="56">
								<button class="btn btn-success" onClick="EnviarPregunta()" >
									<i class="bx bx-send"></i>
								</button>
							</td>
							<td width="56">
								<button class="btn btn-warning" onClick="Iniciar()" id="boton_preguntar" title="Usar MIcrofono" >
									<i class="bx bx-microphone"></i>
								</button>
								<button class="btn btn-danger" onClick="Detener()" style="display: none" id="boton_detener" title="Apagar Micrófono" >
									<i class="bx bx-microphone-off"></i>
								</button>
							</td>
							
							
						</tr>
					</table>

					<div class="respuestas" id="respuesta_ia" align="left" style="display: none"></div>
					
					<button id="bt_leer_nuevamente" class="btn btn-warning w-100" onClick="ReproducirVoz(this)" data-text="Hi, I'm William." style="display: none">Leer respuesta nuevamente</button>
				</div>

			</div>

		</div>
	</div>
	
</div>

<script>
	///BLOQUE PARA RECONOCIMIENTO DE VOZ
	var string_conversacion = '';
	var recognition = new webkitSpeechRecognition();
	recognition.lang = 'es-ES'; // Puedes ajustar esto según el idioma que desees.
		
	function Detener(){
		$("#boton_preguntar").show();
		$("#boton_detener").hide();
			
		console.log("termina");
		recognition.stop();
	}
		
	function Iniciar(){
		$("#boton_preguntar").hide();
		$("#boton_detener").show();

		//recognition.continuous = true;	
		recognition.start();
		recognition.onresult = function (event) {
			const interimTranscript = event.results[event.results.length - 1][0].transcript;
			string_conversacion += interimTranscript;
			//transcriptionDiv.innerHTML = finalTranscript;
			//$("#chat").append( '<div class="pregunta"><div class="autor">Tu</div>'+interimTranscript+'</div>' );
			//$("#chat").append('<div class="pregunta">'+interimTranscript+"</div>");
			
			$("#pregunta").val(interimTranscript);
			
			/*
			$("#chat").animate({
				scrollTop:  $("#chat").height()
			});
			*/
				
			EnviarPregunta();
		};
		
		recognition.onerror = function (event) {
			console.error('Error en el reconocimiento de voz:', event.error);
		};
	}
		
	//CONVERSION DE LAS RESPUESTAS
	const synth = window.speechSynthesis;
	//var voiceSelect = 'Microsoft Sabina - Spanish (Mexico)';

	var pitch = 1;
	var pitchValue = 1;
	var rate = 1;
	var rateValue = 1;
	//var lenguaje = 'es-MX';
	var voz_sintetica = $("#voz_sintetica").val();
	//var lenguaje = 'en-US';
		
	function ReproducirVoz(elem){
		CancelarVoz();
		//var inputTxt = $("#respuesta_ia").text();
		var inputTxt = $(elem).data( "text" );
		console.log(inputTxt);
		
		if(inputTxt){
			
			var utterThis = new SpeechSynthesisUtterance(inputTxt);
			utterThis.pitch = pitch;
			utterThis.rate = rate;
			//utterThis.lang = lenguaje;

			var voices = synth.getVoices();
			//console.log(voices);

			for(i = 0; i < voices.length ; i++) {
				if(voices[i].name === voz_sintetica ) {
					utterThis.voice = voices[i];
					voiceSelect = voices[i];
				}
			}

			//console.log(utterThis);
			utterThis.onboundary = function(event) {
				if (event.name === 'word') {

				}
			};

			utterThis.onstart = function(event) {
				//$("#onda").fadeIn();
			};

			utterThis.onend = function(event) {
				//$("#onda").fadeOut();
			};


			synth.speak(utterThis);
		}
		else{
			alert("Debe ingresa una frase o una palabra");
		}
	}
	
	function CancelarVoz(){
		synth.cancel();
	}
		
	var urls = 'https://somosat.hr-suite.app/api/asistentes/'
	function EnviarPregunta(){
		
		pregunta = $("#pregunta").val();
		$("#chat").append( '<div class="pregunta"><div class="autor">Tu</div>'+pregunta+'</div>' );
		$("#pregunta").val("");
		
		$("#respuesta_ia").html('<div align="center"><img src="assets/img/preloader_sound.gif" width="100"></div>');
			
		jQuery.ajax({
			url: urls+"asistente_ia.php",
			type:'post',
			data: { pregunta:pregunta },
			}).done(function (resp){
			
				procesado = resp.replace(/\n/g, "<br />");
				
				//content_div = '<div class="respuesta"><div class="autor">Asistente</div> <i class="bx bx-volume-full parlante" onClick="ReproducirVoz(this)" class="parlante" data-text="'+resp+'"></i> '+procesado+' </div>';

				content_div = '<div class="respuesta"><div class="autor">Asistente</div>'+procesado+' </div>';
				
				//$("this").hide();	
				$("#bt_leer_nuevamente").data("text", resp);
				$("#chat").append( content_div );
				/*
				$("#chat").animate({
					scrollTop:  300
				});
				*/
		
				$("#chat").animate({
					scrollTop:  $("#chat").height()
				});
				//CancelarVoz();
					
				//ReproducirVoz($("#bt_leer_nuevamente"));
				
			})
			.fail(function() {
			})
			.always(function(resp){
			}
		);	
		Detener();
	}
</script>
	
