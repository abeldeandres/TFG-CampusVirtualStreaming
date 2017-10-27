//Funciones en caso de error
var errors = require('./errors');

//Libreria para generar rutas de fichero en el sevidor (relativas, aboslutas, etc.) 
var path = require('path');

var models = require('../../models');
var sesiones = require('../sesiones');

/*
Esta función se llama usando, por ejemplo en server.js a routes(app);
*/
module.exports = function (app) {

	// Página del profesor
    //GET a http://localhost/profesor
	/*app.get('/profesor', function (req, res, next) {
		console.log( + ' '+req.originalUrl)
		res.render('prof.jade',{
			'pageTitle' : 'Streaming profesor',
			'room' : 'sala1'
		});
	});

	//Página del alumno
	app.get('/alumno', function (req, res, next) {
		console.log( + ' '+req.originalUrl)
		res.render('alumno.jade',{
			'pageTitle' : 'Streaming alumno',
			'room' : 'sala1'
		});
	});*/

    /*
    LA tura postt y la ruta get de streaming hacen lo mismo
    */
	app.post('/streaming',function (req, res, next) {

        //req.body almacena las variables enviadas por un formulario post
		id_recurso = req.body.id_recurso;
		
		if (id_recurso === undefined) {
		    res.status(403).send('No tienes permisos');
		}		
		
		models.Sala.obtenerDatosSala(id_recurso,function (err,info_sala) {
			if (err) return next(err);
			
			usuario = req.session.usuario;	
			
			console.log(info_sala);
			
			console.log(usuario);
			
			if (usuario.rol === "Profesor" && info_sala.autor === usuario.id_usuario ) {
				res.render('prof.jade',{
					'usuario' : usuario,
					'info_sala' : info_sala
				});
			} 
			else if (usuario.rol === "Alumno" && info_sala.id_alumno === usuario.id_usuario )  {
				res.render('alumno.jade',{
					'usuario' : usuario,
					'info_sala' : info_sala
				});
			} 
			else {
			    res.status(403).send('No tienes permisos');
			}
		});
		
	});
	
    //:id_recurso es un parámetro de la llamada get (que puede valer cualquier cosa)
    //Todas las variables precedias con : en la dirección se introducen automáticamente en req.params
	app.get('/streaming/:id_recurso',function (req, res, next) {

		id_recurso = req.params.id_recurso;
		
		if (id_recurso === undefined) {
		    return res.status(403).send('No tienes permisos');
		}		
		
		models.Sala.obtenerDatosSala(id_recurso,function (err,info_sala) {
			if (err) return next(err);
			
			usuario = req.session.usuario;	
			
            //DEBUG por consola
			console.log(info_sala);			
			console.log(usuario);
			
			if (usuario.rol === "Profesor" && info_sala.autor === usuario.id_usuario ) {
				res.render('prof.jade',{
					'usuario' : usuario,
					'info_sala' : info_sala
				});
			} 
			else if (usuario.rol === "Alumno" && info_sala.id_alumno === usuario.id_usuario )  {
				res.render('alumno.jade',{
					'usuario' : usuario,
					'info_sala' : info_sala
				});
			} 
			else {
			    return res.status(403).send('No tienes permisos');
			}
		});
		
	});

	//Librerias javascript
    //GET de  http://localhost/js/lib/:file
	app.get('/js/lib/:file', function (req, res, next) {
		res.sendFile(path.resolve(__dirname+'../../../js/lib/'+req.params.file));
	});

	//Librerias javascript para el profesor
	app.get('/js/prof.js', function (req, res, next) {
		//TODO Comprobar que el usuario de la sesión es un profesor
		res.sendFile(path.resolve(__dirname+'../../../js/prof.js'));
	});

	//Librerias javascript para el alumno
	app.get('/js/alumno.js', function (req, res, next) {
		//TODO Comprobar que el usuario de la sesión es un alumno
		res.sendFile(path.resolve(__dirname+'../../../js/alumno.js'));
	});

	//Ficheros css
	app.get('/css/:file', function (req, res, next) {
		res.sendFile(path.resolve(__dirname+'../../../css/'+req.params.file));
	});
    
    app.get('/img/:file', function (req, res, next) {
		res.sendFile(path.resolve(__dirname+'../../../img/'+req.params.file));
	});

	// error handlers
	errors(app);
}
