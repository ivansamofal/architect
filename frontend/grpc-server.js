const grpc = require('@grpc/grpc-js');
const protoLoader = require('@grpc/proto-loader');
const path = require('path');

const PROTO_PATH = path.resolve(__dirname, 'helloworld.proto');

const packageDefinition = protoLoader.loadSync(PROTO_PATH, {});
const helloProto = grpc.loadPackageDefinition(packageDefinition).helloworld;

function sayHello(call, callback) {
    const reply = { message: 'Hello ' + call.request.name };
    callback(null, reply);
}

function main() {
    const server = new grpc.Server();
    server.addService(helloProto.Greeter.service, { SayHello: sayHello });
    server.bindAsync('0.0.0.0:50051', grpc.ServerCredentials.createInsecure(), () => {
        console.log('gRPC сервер запущен на порту 50051');
        server.start();
    });
}

main();
