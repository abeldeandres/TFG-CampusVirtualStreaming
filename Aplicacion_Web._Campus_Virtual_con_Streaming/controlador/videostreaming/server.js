//var https = require('https'),
//Libreria para montar un servidor http
var http = require('http'),
//Libreria file system (leer ficheros y otras cosas)
fs = require('fs'), 
//Librería que genera una capa superior sobre los servidortes http (buscar info)
express = require('express'), 
    
//APP es el servidor express (es el principal) contiene toda la informaciópn sobre las rutas get y post, el middleware, las conexiones,
//toda la configuración general de la aplicación
app = express();
//Módulo para generar rutas
//router = express.Router();

/*
Incluimos los index de nuestras carpetas para incluir las funciones que hemos definido para cada 
tarea
*/
//var models = require('./models');
var routes = require('./controllers/routes');
var middleware = require('./controllers/middleware');

var port = 3030;

/*var sslOptions = {
		key: fs.readFileSync('./ssl/server.key'),
		cert: fs.readFileSync('./ssl/server.crt'),
		ca: fs.readFileSync('./ssl/ca.crt'),
		requestCert: true,
		rejectUnauthorized: false
};*/

/*
Llamamos a los contructores específicos definidos en los ficheros de librerias
que hemos incluido previamente
*/
middleware(app);
routes(app);

/*server = https.createServer(sslOptions, app).listen(port, function() {
	console.log('Servidor express iniciado en el puerto ' + port);
});*/

/*
Arrancamos el servidor http para recibir las peticiones de página web y generar lña página del streaming
*/
server = http.createServer(app).listen(port, function() {
	console.log('Servidor express iniciado en el puerto ' + port);
});

//WEBSOCKETS
//----------------------------------------------------------------------------------------------------
//socket.io te genera una dirección para los websockets en el cliente en el puerto indicado en el servidor 
//http pasado como parámetro
var io = require('socket.io')(server);

/*
Definimos el comportamiento de los sockets de socket.io (websocket) al recibir los diferentes mensajes

 - on escucha mensajes del socket
 - emit envía mensajes
*/
io.sockets.on('connection', function (socket) {
	/**
	 * Función para obtener los clientes conectados a una sala
	 * */
	function findClientsSocket(roomId, namespace) {
		var res = []
		, ns = io.of(namespace ||"/");    // the default namespace is "/"

		if (ns) {
			for (var id in ns.connected) {
				if(roomId) {
					var index = ns.connected[id].rooms.indexOf(roomId) ;
					if(index !== -1) {
						res.push(ns.connected[id]);
					}
				} else {
					res.push(ns.connected[id]);
				}
			}
		}
		return res;
	}	
	
	// convenience function to log server messages on the client
	function log(){
		var array = [">>> Message from server: "];
		for (var i = 0; i < arguments.length; i++) {
			array.push(arguments[i]);
		}
		socket.emit('log', array);
	}

	socket.on('message', function (message) {
		
		//var recurso = message.info_sala;
		recurso = {};
		//var user = message.usuario;
        //PARCHE para obtener el nombre del recurso (se encuentra en el objeto indicado)
        //SÓLO FUNCIONA EN GET
		recurso.id_recurso = socket.handshake.headers.referer.substring(socket.handshake.headers.referer.lastIndexOf("/")+1);
		
		log('Got message:', message);
		// Según se vayan conectando hay que clasificar los sockets abiertos según su sala y enviar el mensaje a
		//  cada usuario según corresponda
        // to -> expecifica una sala
		socket.to(recurso.id_recurso).broadcast.emit('message', message);
	});

	socket.on('chat', function (message) {
		console.log('>>>> Chat',message);
		//var recurso = message.info_sala;
		recurso = {};
		//var user = message.usuario;
		recurso.id_recurso = socket.handshake.headers.referer.substring(socket.handshake.headers.referer.lastIndexOf("/")+1);
		
		log('chat message:', message);
		// Según se vayan conectando hay que clasificar los sockets abiertos según su sala y enviar el mensaje a
		//  cada usuario según corresponda		
		socket.to(recurso.id_recurso).broadcast.emit('chat', message);
	});

	socket.on('create', function (message) {
		var recurso = message.info_sala;
		var user = message.usuario;
		
		//Hay que coger la sala de la sesión, 
		//y el usuario actual para guardarlo en la conexión abierta		
		var numClients = findClientsSocket(recurso.id_recurso).length;
		
		//Si el usuario no es el propietario de la sala, mandamos error
		
		log('Petición para crear la sala ' + recurso.id_recurso);

		if (numClients === 0) {
            //join es otro método de socket, que incluye a un suarui en una sala
			socket.join(recurso.id_recurso);
			socket.emit('created',recurso);
		} 
		//Si hay alguien ya les echamos y nos unimos nosotros
		else if (numClients >= 1) {
			findClientsSocket(recurso.id_recurso).forEach(function(s){
				socket.emit('leave', recurso);
			    s.leave(recurso.id_recurso);
			}); 	
			socket.join(recurso.id_recurso);
			socket.emit('created', recurso);
		} 
		//socket.to(recurso.id_recurso).broadcast.emit('client ' + socket.id + ' joined room ' + recurso.id_recurso);

	});
	
	socket.on('join', function (message) {
		var recurso = message.info_sala;
		var user = message.usuario;
		
		//Hay que coger la sala de la sesión, así como el usuario actual para guardarlo en la conexión abierta
		var numClients = findClientsSocket(recurso.id_recurso).length;

		log('Room ' + recurso.id_recurso + ' has ' + numClients + ' client(s)');
		log('Request to join room ' + recurso.id_recurso);

		if (numClients === 0) {
			//Si no hay nadie, salimos
			socket.emit('empty', recurso);
		} else if (numClients == 1) {
			//Enviamos a todos la información de que el usuario se ha unido al canal
			io.sockets.to(recurso.id_recurso).emit('join', recurso);
			socket.join(recurso.id_recurso);
			//Enviamos la información al usuario para indicarle que se ha unido con éxito
			socket.emit('joined', recurso);
		} else { // max  clients
			socket.emit('full', recurso);
		}
		
		socket.to(recurso.id_recurso).broadcast.emit('client ' + socket.id + ' joined room ' + recurso.id_recurso);

	});

});
