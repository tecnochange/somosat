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
		
	var urls = 'https://smartv3.hr-suite.app/api/asistentes/'
	function EnviarPregunta(){
		
		pregunta = $("#pregunta").val();
		$("#chat").append( '<div class="pregunta"><div class="autor">Tu</div>'+pregunta+'</div>' );
		$("#pregunta").val("");
		
		$("#respuesta_ia").html('<div align="center"><img src="assets/img/preloader_sound.gif" width="100"></div>');
			
		jQuery.ajax({
			url: urls+"api_chat_gpt.php",
			type:'post',
			data: {pregunta:pregunta, id_bot: <?php echo $id; ?>},
			}).done(function (resp){
			
				procesado = resp.replace(/\n/g, "<br />");
				
				content_div = '<div class="respuesta"><div class="autor">Asistente</div> <i class="bx bx-volume-full parlante" onClick="ReproducirVoz(this)" class="parlante" data-text="'+resp+'"></i> '+procesado+' </div>';
				
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
				CancelarVoz();
					
				ReproducirVoz($("#bt_leer_nuevamente"));
				
			})
			.fail(function() {
			})
			.always(function(resp){
			}
		);	
		Detener();
	}
</script>