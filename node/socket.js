var net = require('net');
var sockets =[];
var server = net.createServer(function(s){
	sockets.push(s);
	debugger;
	s.on('data',function(data){
		for (var i = 0; i < sockets.length; i++) {
			if(sockets[i]==s) continue;
			sockets[i].write(data);
		}
	});
	s.on('close',function(){
		var i = sockets.indexOf(s);
		sockets.splice(i,1);
	});
});

server.listen(8000);