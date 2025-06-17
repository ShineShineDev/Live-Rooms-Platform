# Step 1: Build the Nuxt 3 app
FROM node:18-alpine AS builder

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# Step 2: Run with lightweight Node.js image
FROM node:18-alpine

WORKDIR /app

COPY --from=builder /app ./

# Install production dependencies only (optional)
# RUN npm ci --omit=dev

ENV NODE_ENV=production
EXPOSE 3000

# Nuxt 3 SSR output entrypoint
CMD ["node", ".output/server/index.mjs"]
