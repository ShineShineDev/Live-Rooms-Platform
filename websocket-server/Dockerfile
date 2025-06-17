# Use the official Node.js image
FROM node:18-alpine

# Set working directory inside the container
WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install

# Copy the rest of the application
COPY . .

# Expose the WebSocket port
EXPOSE 4000

# Start the server
CMD ["node", "server.js"]
