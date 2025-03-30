// server.js
const path = require('path');
const express = require('express');
const app = express();
const port = 3000;

// Раздача статических файлов из папки public
// app.use('/', express.static('public'));

// Раздача статических файлов из папки public
app.use(express.static('public', {
    setHeaders: (res, filePath) => {
        if (filePath.endsWith('.js')) {
            res.setHeader('Content-Type', 'application/javascript');
        }
    }
}));

// Отдаём index.html для всех остальных запросов
app.get('*', (req, res) => {
    res.sendFile(path.resolve(__dirname, 'public', 'index.html'));
});

// app.get('*', (req, res) => {
//     res.sendFile(path.resolve(__dirname, 'public', 'index.html'));
// });

// app.use('/', express.static('public', {
//     setHeaders: (res, filePath) => {
//         if (filePath.endsWith('.js')) {
//             res.setHeader('Content-Type', 'application/javascript');
//         }
//     }
// }));

// Чтобы сервер был доступен извне, слушаем 0.0.0.0
app.listen(port, '0.0.0.0', () => {
    console.log(`Server is listening on port ${port}`);
});
