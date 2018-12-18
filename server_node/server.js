var io = require('socket.io')(6001);

io.on("connection",function(socket){

	console.log("Connected");

	socket.on("senChatToServer",function(message){
		console.log(message);
		io.sockets.emit("serverChatToClient",message);
	})
	
});

var Redis = require('ioredis');

var redis= new Redis(1000);

redis.on('pmessage',function(partner,chanel,message){
	console.log(chanel);
	console.log(message);
	console.log(partner);
});