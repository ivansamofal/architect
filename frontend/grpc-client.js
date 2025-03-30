const grpc = require('@grpc/grpc-js');
const protoLoader = require('@grpc/proto-loader');
const path = require('path');

const PROTO_PATH = path.resolve(__dirname, 'helloworld.proto');

const packageDefinition = protoLoader.loadSync(PROTO_PATH, {});
const helloProto = grpc.loadPackageDefinition(packageDefinition).helloworld;

function main() {
    const client = new helloProto.Greeter('localhost:50051', grpc.credentials.createInsecure());
    client.SayHello({ name: 'World' }, (error, response) => {
        if (error) {
            console.error('Ошибка вызова:', error);
        } else {
            console.log('Ответ сервера:', response.message);
        }
    });
}

main();
