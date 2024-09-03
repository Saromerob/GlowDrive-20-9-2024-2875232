const express = require('express');
const http = require('http');
const socketIo = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Servir archivos estáticos desde la carpeta 'public'
app.use(express.static('public'));

// Manejo de conexiones de Socket.io
io.on('connection', (socket) => {
  console.log('A user connected');

  socket.on('sendNotification', (data) => {
    io.emit('receiveNotification', data);
  });

  socket.on('disconnect', () => {
    console.log('User disconnected');
  });
});

// Escuchar en el puerto 3000
server.listen(3000, () => {
  console.log('Server is running on port 3000');
});
