var io = require('socket.io')(6000);

console.log('Connected to port 6000');

io.on('error',fuction(socket){
	console.log('error');
});

io.on('connectionn',fuction(socket){
	console.log('Co người vừa kết nối'+socket.id)
})

var Redis = require('ioredis');
var redis = new Redis(8000);
