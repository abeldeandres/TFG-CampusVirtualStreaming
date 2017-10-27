var Memcached = require('memcached');
var PHPUnserialize = require('php-unserialize');

function memcachedSession(clave,cb) {
	var mem = new Memcached('127.0.0.1:11211'); // connect to local memcached
	
	mem.get(clave,(function(err,data) { 
        if ( err ) return cb(err); 
        if ( data === false ) return cb(new Error("Sin datos de sessión para la clave "+clave)); 
        
        cb(null,PHPUnserialize.unserializeSession(data));
	})(cb));
}

//No se usa, pero si es necesario está definido
module.exports.isLoggedIn = function (req, res, next) {
	if (!(req.session && req.session.usuario)) {
		return res.redirect(req.hostname + ':80/');
	}
};

/*
Obtiene la información de sesiones de PHP
*/
module.exports.getSession = function (req, res, next) {	
	if (req.cookies !== undefined && req.cookies.PHPSESSID !== undefined) {
		
		var mem = new Memcached('127.0.0.1:11211'); // connect to local memcached
		
		mem.get(req.cookies.PHPSESSID,function(err,data) { 
	        if ( err ) return next(err); 
	        if ( data === false || data === undefined) return next(new Error("Sin datos de sessión para la clave "+req.cookies.PHPSESSID)); 
	        
	        req.session = PHPUnserialize.unserializeSession(data);
			next();
		});
	}
};