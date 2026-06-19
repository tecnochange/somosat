//OBJETO DE CONFIGURACION PARA FIREBASE
var config = {
	apiKey: "AIzaSyDqgYVPqg-QgxaGIYHwHpOzxHGW7ini-BY",
    authDomain: "videochat-3d5f9.firebaseapp.com",
    databaseURL: "https://videochat-3d5f9.firebaseio.com",
    projectId: "videochat-3d5f9",
    storageBucket: "videochat-3d5f9.appspot.com",
    messagingSenderId: "764948836111",
    appId: "1:764948836111:web:014b1deadf9890e113587a"
};

firebase.initializeApp(config);


var database = firebase.database().ref('rooms/'+sala);
var yourVideo = document.getElementById("yourVideo");
var friendsVideo = document.getElementById("friendsVideo");
//var yourId = Math.floor(Math.random()*1000000000);
var yourId = id_usuario+"-"+sala; ///ESTA CODIGO HA SIDO MODIFICADO
//Create an account on Viagenie (http://numb.viagenie.ca/), and replace {'urls': 'turn:numb.viagenie.ca','credential': 'websitebeaver','username': 'websitebeaver@email.com'} with the information from your account
var servers = {'iceServers': [{'urls': 'stun:stun.services.mozilla.com'}, {'urls': 'stun:stun.l.google.com:19302'}, {'urls': 'turn:numb.viagenie.ca','credential': 'beaver','username': 'eniac321@gmail.com'}]};
var pc = new RTCPeerConnection(servers);
pc.onicecandidate = (event => event.candidate?sendMessage(yourId, JSON.stringify({'ice': event.candidate})):console.log("Sent All Ice") );
pc.onaddstream = (event => friendsVideo.srcObject = event.stream);


function sendMessage(senderId, data) {
    var msg = database.push({ sender: senderId, message: data });
  	msg.remove();
}

function readMessage(data) {
    var msg = JSON.parse(data.val().message);
    var sender = data.val().sender;
	
	var datosSala = sender.split("-");///ESTA CODIGO HA SIDO MODIFICADO
	
	console.log(sender);
	if(sala == datosSala[1]){
		if (datosSala[0] != id_usuario) { ///ESTA CODIGO HA SIDO MODIFICADO
			
			$("#alerta").hide();
			$("#en_linea").show();
			
			if (msg.ice != undefined)
				pc.addIceCandidate(new RTCIceCandidate(msg.ice));
			else if (msg.sdp.type == "offer")
				pc.setRemoteDescription(new RTCSessionDescription(msg.sdp))
				  .then(() => pc.createAnswer())
				  .then(answer => pc.setLocalDescription(answer))
				  .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})));
			else if (msg.sdp.type == "answer")
				pc.setRemoteDescription(new RTCSessionDescription(msg.sdp));
		
			
			
		}
	}
	
	
};

database.on('child_added', readMessage);

function showMyFace() {
	navigator.mediaDevices.getUserMedia({audio:true, video:true})
    	.then(stream => yourVideo.srcObject = stream)
    	.then(stream => pc.addStream(stream));
	
	setTimeout(showFriendsFace, 1500)
}

function showFriendsFace() {
  pc.createOffer()
    .then(offer => pc.setLocalDescription(offer) )
    .then(() => sendMessage(yourId, JSON.stringify({'sdp': pc.localDescription})) );
}

