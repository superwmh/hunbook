# Installation #

```
// node.js stable
http://nodejs.org/dist/node-v0.4.11.tar.gz
tar zxvf node-v0.4.11.tar.gz
cd node-v0.4.11
./configure
make
make install
```

```
// npm
// ref: http://clonn.blogspot.com/2011/01/nodejs-npm.html
curl http://npmjs.org/install.sh | sh
```

```
wget ftp://ftp.gnu.org/gnu/tar/tar-1.26.tar.gz
tar zxvf tar-1.26.tar.gz
cd tar-1.26
export FORCE_UNSAFE_CONFIGURE=1
./configure
make
make install
```

```
# need latest tar
npm install socket.io
```

```
npm install mongodb
```

refs:
  * http://clonn.blogspot.com/2011/01/nodejs-npm.html
  * http://xfalcons.blogspot.com/2011/12/nodejs-npm-forever-nodejs.html

# Socket.io Examples #

Refs:
  * http://socketio-example.nodester.com/ (invalid now)
  * http://www.danielbaulig.de/socket-ioexpress/

## Simple Example ##

```
// server
var simple = io
  .sockets
  .on('connection', function(socket) {
    socket.on('message', function(data) {
      socket.broadcast.send(data);
    });
    socket.on('disconnect', function() {
      // handle disconnect
    });
  });
```

```
// client
var socket = io.connect();
var content = $('#simple-content');
socket.on('connect', function() {
  $('#simple-form').css('display', 'block');
  content.append($('<p>').text('Connected'));  
});
 
socket.on('message', function(msg) {
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from server')));
});
 
$('#simple-form').submit(function(e) {
  e.preventDefault();
  var textObj = $('#simple-text');   
  var msg = textObj.val();
  textObj.val('');
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from me')));
  socket.send(msg);
});
```

## Namespace Example ##

```
// server
var namespace = io
  .of('/namespace')
  .on('connection', function(socket) {
    socket.on('message', function(data) {
      socket.broadcast.send(data);
    }); 
  });
```

```
// client
var namespace = io.connect('/namespace');
var content = $('#namespace-content');
namespace.on('connect', function() {
  $('#namespace-form').css('display', 'block');
  content.append($('<p>').text('Connected'));
}); 
   
namespace.on('message', function(msg) {
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from server')));
});
   
$('#namespace-form').submit(function(e) {
  var textObj = $('#namespace-text');
  var msg = textObj.val();
  textObj.val('');
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from me')));
  namespace.send(msg);
});
```


## Custom Event Example ##

```
// server
var custom = io
  .of('/custom')
  .on('connection', function(socket) {
    socket.on('fromclient', function(data) {
      socket.broadcast.emit('fromserver', data);
    }); 
  });
```

```
// client
var custom = io.connect('/custom');
var content = $('#custom-content');
custom.on('connect', function() {
  $('#custom-form').css('display', 'block');
  content.append($('<p>').text('Connected'));
}); 
 
custom.on('fromserver', function(msg) {
 content.append($('<p>').text(msg)
        .append($('<em>').text(' from server')));
});
 
$('#custom-form').submit(function(e) {
  var textObj = $('#custom-text');
  var msg = textObj.val();
  textObj.val('');
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from me')));
  custom.emit('fromclient', msg);
});
```


## Volatile Event Example ##

```
// server
var volatile = io
  .of('/volatile')
  .on('connection', function(socket) {
    socket.on('fromclient', function(data) {
      socket.broadcast.emit('fromserver', data);
    }); 
   
    var vola = setInterval(function () {
      socket.volatile.emit('current time', 
                           'current time : ' + new Date());
    }, 1000);
 
    socket.on('disconnect', function () {
      clearInterval(vola);
    });
  });
```

```
// client
var volatile = io.connect('/volatile');
var content = $('#volatile-content');
volatile.on('connect', function() {
  content.append($('<p>').text('Connected'));
}); 
 
volatile.on('current time', function(msg) {
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from server')));
});
```


## Room Event Example ##

```
// server
var Room = io
  .of('/room')
  .on('connection', function(socket) {
    var joinedRoom = null;
    socket.on('join room', function(data) {
      socket.join(data);
      joinedRoom = data;
      socket.emit('joined', "you've joined " + data);
      socket.broadcast.to(joinedRoom)
                         .send('someone joined room');
    }); 
    socket.on('fromclient', function(data) {
      if (joinedRoom) {
        socket.broadcast.to(joinedRoom).send(data);
      } else {
        socket.send(
           "you're not joined a room." +
           "select a room and then push join."
        );
      }
    });
  });
```

```
// client
var joined = false;
var room = io.connect('/room');
var content = $('#room-content');
room.on('connect', function() {
  $('#room-form').css('display', 'block');
  content.append($('<p>').text('Connected'));
}); 
 
room.on('joined', function(msg) {
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from server')));
});
 
room.on('message', function(msg) {
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from server')));
});
 
$('#room-join').click(function(e) {
  joined = true;
  room.emit('join room', $('#room-select').val());
});
 
$('#room-form').submit(function(e) {
  var textObj = $('#room-text');
  var msg = textObj.val();
  textObj.val('');
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from me')));
  room.emit('fromclient', msg);
});
```


## JSON parse Example ##

```
// server
var json = io
  .of('/json')
  .on('connection', function(socket) {
    socket.on('message', function(data) {
      socket.json.broadcast.send({text:data});
    });
    socket.on('disconnect', function() {
      // handle disconnect
    });
  });
```

```
// client
var socket = io.connect('/json');
var content = $('#json-content');
socket.on('connect', function() {
  $('#json-form').css('display', 'block');
  content.append($('<p>').text('Connected'));  
});
|
socket.on('message', function(msg) {
  content.append($('<p>').text(msg.text)
         .append($('<em>').text(' from server')));
});
|
$('#json-form').submit(function(e) {
  var textObj = $('#json-text');   
  var msg = textObj.val();
  textObj.val('');
  content.append($('<p>').text(msg)
         .append($('<em>').text(' from me')));
  socket.send(msg);
}); 
```