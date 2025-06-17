let express = require("express");
let socket = require("socket.io");
let amqp = require("amqplib");

let app = express();
let server = app.listen(4000, () => {
    console.log("Project is running on http://localhost:4000");
});

app.use(express.static("public"));

app.get("/", (req, res) => {
    res.sendFile(__dirname + "/public/index.html");
});

let io = socket(server);

io.on("connection", (socket) => {
    console.log("New client connected");
    socket.on("join", (userId) => {
        const room = `user_${userId}`;
        socket.join(room);
        console.log(`User ${userId} joined room: ${room}`);
    });
    socket.on("chat", (data) => {
        io.sockets.emit("chat", data); // broadcasts to all
    });
    socket.on("typing", (name) => {
        socket.broadcast.emit("typing", name);
    });
    socket.on("disconnect", () => {
        console.log("Client disconnected");
    });
});

async function connectRabbitMQWithRetry(retryInterval = 5000) {
    while (true) {
        try {
            // 
            const RABBITMQ_URL = "amqp://guest:guest@localhost:5672";
            const EXCHANGE_NAME = "data_bridge";

            const connection = await amqp.connect(RABBITMQ_URL);
            const channel = await connection.createChannel();

            await channel.assertExchange(EXCHANGE_NAME, "fanout", { durable: false });
            const q = await channel.assertQueue("", { exclusive: true });
            channel.bindQueue(q.queue, EXCHANGE_NAME, "");

            console.log(`[*] Waiting for messages in queue: ${q.queue}`);

            channel.consume(q.queue, (msg) => {
                if (msg?.content) {
                    const data = JSON.parse(msg.content.toString());
                    console.log("[x] Received from RabbitMQ:", data);

                    const userId = data.user_id;
                    if (userId) {
                        const room = `user_${userId}`;
                        io.to(room).emit("room_subscribed", data);
                        console.log(`Sent message to room: ${room}`);
                    } else {
                        console.warn("user_id not found in message", data);
                    }
                }
            }, { noAck: true });
            connection.on("close", () => {
                console.error("RabbitMQ connection closed, retrying...");
                setTimeout(() => connectRabbitMQWithRetry(retryInterval), retryInterval);
            });

            connection.on("error", (err) => {
                console.error("RabbitMQ connection error:", err.message);
            });

            break; 
        } catch (err) {
            console.error("RabbitMQ connection failed:", err.message);
            console.log(`Retrying in ${retryInterval / 1000} seconds...`);
            await new Promise(res => setTimeout(res, retryInterval));
        }
    }
}

connectRabbitMQWithRetry();


// // Connect to RabbitMQ and consume messages
// async function connectRabbitMQ() {
//     try {
//         const RABBITMQ_URL = "amqp://guest:guest@rabbitmq:5672";
//         const EXCHANGE_NAME = "data_bridge";

//         const connection = await amqp.connect(RABBITMQ_URL);
//         const channel = await connection.createChannel();

//         await channel.assertExchange(EXCHANGE_NAME, "fanout", { durable: false });

//         const q = await channel.assertQueue("", { exclusive: true });
//         channel.bindQueue(q.queue, EXCHANGE_NAME, "");

//         console.log(`[*] Waiting for messages in queue: ${q.queue}`);

//         channel.consume(q.queue, (msg) => {
//             if (msg.content) {
//                 const data = JSON.parse(msg.content.toString());
//                 console.log("[x] Received from RabbitMQ:", data);

//                 const userId = data.user_id;
//                 if (userId) {
//                     const room = `user_${userId}`;
//                     io.to(room).emit("room_subscribed", data); // send to specific user room
//                     console.log(`Sent message to room: ${room}`);
//                 } else {
//                     console.warn("user_id not found in message", data);
//                 }
//             }
//         }, { noAck: true });
//     } catch (error) {
//         console.error("RabbitMQ connection error:", error);
//     }
// }

// connectRabbitMQ();
