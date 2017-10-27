var isSalaCreada = false;
var localVideo = document.querySelector('#localVideo');
var remoteVideo = document.querySelector('#remoteVideo');
var localStream;
var pc;
var remoteStream;
var isStarted = false;
var sdpConstraints = {'mandatory': {
	'OfferToReceiveAudio':true,
	'OfferToReceiveVideo':true }};
var streamer = true;

//Conectamos con el servidor
var socket = io.connect();

//Creamos la sala
console.log('Creamos la sala a partir de la sesión');
socket.emit('create',{
	'usuario' : usuario,
	'info_sala' : info_sala
});

function printChatMessage(message) {
	var date = new Date();
	var time = date.toLocaleTimeString();
		
	var chat = document.getElementById('chat');
	var msg = document.createElement("div");
	msg.setAttribute('class', 'msg-usuario');

	var elem = document.createElement("span");		
	elem.setAttribute('class', 'time');
	elem.appendChild(document.createTextNode(time + ' '));
	
	msg.appendChild(elem);
	
	var elem = document.createElement("span");		
	elem.setAttribute('class', 'nombre');
	elem.appendChild(document.createTextNode(message.usuario.nombre + ' '));
	
	msg.appendChild(elem);

	var elem = document.createElement("span");		
	elem.setAttribute('class', 'msg');
	elem.appendChild(document.createTextNode(message.text + ' '));
	
	msg.appendChild(elem);
	
	chat.appendChild(msg);
}

//Gestionamos los mensajes recibidos por el servidor
//------------------------------------------------------------
socket.on('log', function (array){
	console.log.apply(console, array);
});

socket.on('message', function (message){
	console.log('Client received message:', message);
	if (message === 'video ok') {
		streamer = false;
	}
	else if (message.type === 'offer') {
		pc.setRemoteDescription(new RTCSessionDescription(message));
		doAnswer();
	} else if (message.type === 'answer') {
		pc.setRemoteDescription(new RTCSessionDescription(message));
	} else if (message.type === 'candidate') {
		var candidate = new RTCIceCandidate({
			sdpMLineIndex: message.label,
			candidate: message.candidate
		});
		pc.addIceCandidate(candidate);
	} 
});

socket.on('created', function (recurso){
	//TODO
});

socket.on('leave', function (recurso){
	alert('Se ha cerrado la sesión');
});

socket.on('empty', function (recurso){
	console.error('La sala no está creada: ' + recurso.nombre_recurso);
});

socket.on('join', function (recurso){
	if (streamer) {
		pc.addStream(localStream);
		pc.createOffer(setLocalAndSendMessage, handleCreateOfferError);
	}
});

socket.on('joined', function (recurso){

});

socket.on('full', function (recurso){
	alert('Se ha alcanzado el límite de usuarios');
});



socket.on('chat', function (message){
	
	console.log('Client received chat message:', message);
		
	printChatMessage(message);
	
});

//Funciones de comunicación en general
//------------------------------------------------------------
function sendChatMessage(){
	var chat = document.getElementById('chatMessage');
	var message = {};
	
	message.usuario = usuario;
	message.text = chat.value.trim();
	console.log('Client sending chat message: ', message);

	printChatMessage(message);
	chat.value = '';
	socket.emit('chat', message);
}

function sendMessage(message){
	message.usuario=usuario;
	message.info_sala=info_sala;
	console.log('Client sending message: ', message);
	socket.emit('message', message);
}

function createPeerConnection() {
	try {
        var ICE_config = {
    'iceServers': [
        {
            'url': 'stun:stun.l.google.com:19302'
    },
        {
            'url': 'turn:192.158.29.39:3478?transport=udp',
            'credential': 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
            'username': '28224511:1379330808'
    },
        {
            'url': 'turn:192.158.29.39:3478?transport=tcp',
            'credential': 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
            'username': '28224511:1379330808'
    }
  ]
}
		pc = new RTCPeerConnection(ICE_config);
		pc.onicecandidate = handleIceCandidate;
		pc.onaddstream = handleRemoteStreamAdded;
		pc.onremovestream = handleRemoteStreamRemoved;
		console.log('Creada RTCPeerConnnection');
	} catch (e) {
		console.log('No se puede crear el objeto PeerConnection, exception: ' + e.message);
		alert('No se puede crear el objeto RTCPeerConnection');
		return;
	}
}


function handleIceCandidate(event) {
	console.log('handleIceCandidate event: ', event);
	if (event.candidate) {
		sendMessage({
			type: 'candidate',
			label: event.candidate.sdpMLineIndex,
			id: event.candidate.sdpMid,
			candidate: event.candidate.candidate
		});
	} else {
		console.log('Fin de los candidatos');
	}
}

function handleRemoteStreamAdded(event) {
	console.log('Se ha añadido un stream remoto');
	
		remoteVideo.src = window.URL.createObjectURL(event.stream);
		remoteStream = event.stream;

		sendMessage('video ok');
	
	
}

function handleRemoteStreamRemoved(event) {
	console.log('Usuario desconectado. Event: ', event);
}

function setLocalAndSendMessage(sessionDescription) {
	pc.setLocalDescription(sessionDescription);
	console.log('setLocalAndSendMessage sending message' , sessionDescription);
	sendMessage(sessionDescription);
}

function handleCreateOfferError(event){
	console.log('createOffer() error: ', e);
}

function doAnswer() {
	console.log('Sending answer to peer.');
	pc.createAnswer(setLocalAndSendMessage, null, sdpConstraints);
}

//Recibimos el streaming
//------------------------------------------------------------

createPeerConnection();

function handleUserMedia(stream) {
	console.log('Añadiendo streaming local');
	localVideo.src = window.URL.createObjectURL(stream);
	localStream = stream;

	//Enviamos el streaming a remoto
	createPeerConnection();
	pc.addStream(localStream);
	isStarted = true;
}

function handleUserMediaError(error){
	console.log('getUserMedia error: ', error);
}

var constraints = {video: true, audio: true};
getUserMedia(constraints, handleUserMedia, handleUserMediaError);

console.log('Obteniendo media con constraints', constraints);
