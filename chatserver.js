// server.js
var app = require('http').createServer(handler);
var io = require('socket.io')(app);

var Redis = require('ioredis');
var redis = new Redis();

app.listen(9527, function () {
  console.log('Server is running!') ;
});

function handler(req, res) {
  res.writeHead(200);
  res.end('');
}

io.on('connection', function (socket) {
  var timeStr = (new Date()).toLocaleString();
  console.log(timeStr + ' : user connect')

  socket.on('message', function (message) {
    var timeStr = (new Date()).toLocaleString();
    console.log(timeStr + ' ' + message)
  })
  socket.on('disconnect', function () {
    var timeStr = (new Date()).toLocaleString();
    console.log(timeStr + ' : user disconnect')

    io.emit('disconnect')
  })
});

redis.psubscribe('*', function (err, count) {

});

redis.on('pmessage', function (subscrbed, channel, message) {
  message = JSON.parse(message);
  io.emit(channel + ':' + message.event, message.data);
});