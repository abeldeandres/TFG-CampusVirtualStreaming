var mysql      = require('mysql');
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'usuario',
	database : 'bd_abel'
});

/*
models.Sala.obtenerDatosSala
*/

module.exports.obtenerDatosSala = function (id_sala,callback) {
	var json = '';

	var query = 'SELECT * FROM recurso WHERE id_recurso = '  + connection.escape(id_sala);
	
	connection.query(query, function(err, results) {
	    if (err) return callback(err, null);
	
	    // wrap result-set as json
	    json = results[0];	
	    
	    callback(null, json);
	});
};