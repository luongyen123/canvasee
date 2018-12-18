var io = require('socket.io')(6000);

console.log("Connected to port 6000");

io.on("error",function(socket){
	console.log("error");
});

io.on("connection",function(socket){

	console.log("Co nguoi vua ket noi");

	socket.emit("wellcome","Hello");
});

var Redis = require('ioredis');

var redis= new Redis(1000);

redis.on('pmessage',function(partner,chanel,message){
	console.log(chanel);
	console.log(message);
	console.log(partner);
});