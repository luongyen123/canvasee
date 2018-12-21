var io = require('socket.io')(6001);
var Redis = require('ioredis');

var redis= new Redis(1000);


io.on("connection",function(socket){

	console.log("Connected");

	socket.on("senChatToServer",function(message){
		console.log(message);
	
		io.sockets.emit("serverChatToClient",message);
	})

	redis.psubscribe('*', function(err, count){

	})

	redis.on('pmessage',function(partner,chanel,message){
		console.log(chanel);
		// console.log(message);
		// console.log(partner);
		message = JSON.parse(message);
		io.emit(chanel,message);
		console.log('sent');
	});
	
});




