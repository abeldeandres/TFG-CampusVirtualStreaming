//Funciones middleware de librerias
var express = require('express');
var bodyParser = require('body-parser');
var cookieParser = require('cookie-parser');


var sesiones = require('../sesiones');


module.exports = function (app) {

	// this is good enough for now but you'll
	// want to use connect-mongo or similar
	// for persistant sessions
    //Rellena la variable req.cookies
	app.use(cookieParser());
	/*app.use(session({
	      secret  : 'CampusVirtual'
	    , key     : 'test'
	    , proxy   : 'true'
	    , store   : new MemcachedStore({
	        hosts: ['127.0.0.1:11211']
	    })
	}));*/
	
	
	//Rellena req.body
	app.use(bodyParser.urlencoded({
		extended: true
	}));
	app.use(bodyParser.json());
	
	//Obtener la sesion 
	app.use(sesiones.getSession);
	
	// expose session to views
	app.use(function (req, res, next) {
		res.locals.session = req.session;
		next();
	})
	
	
}