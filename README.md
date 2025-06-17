#### Overview Diagram

![](https://raw.githubusercontent.com/ShineShineDev/Live-Rooms-Platform/refs/heads/main/img/system%20architecture%20diagram.png)

- Browse a list of live-stream rooms (sports, gaming, entertainment)
- Subscribe to events/matches
- Receive real-time and email notifications when a match goes live



### Tech stack 

- **Nuxt** :  For Frontend
- **Laravel**:  For API Gateway & Backend Services
- **Postgresql** :  For Database
- **Redis ** :  For Caching
- **RabbitMQ** :  For Message broker
- **Websocket** :  For Real-time communication 





#### Run Apps With Docker ( Easiest way to Run App )

> Important: Port Usage  
>
> This project uses ports **8000, 8001, 8002, 4000, 3000, 5432 ,6379, 5672, 3000**. Ensure these ports are free on your system to avoid conflicts and allow the application to run correctly.

- Clone Project Repo

  ```bash
  $ git clone https://github.com/ShineShineDev/Live-Rooms-Platform.git
  $ cd Live-Rooms-Platform
  ```

- Checkout `docker_ready` Branch.

  >  `docker_ready` branch is configured with all the necessary files to run the application using Docker)

  ```bash
   $ git checkout docker_ready 
  ```

- Build Docker images

  > Run `docker-compose up --build` to build your Docker images and start all defined services for the Live Rooms Platform application.

  ```bash
  $ docker-compose up --build
  ```

- Browse => http://localhost:3000/ 

  

---



### Manual setup

##### Prerequisite

- Node (v20.18 prefer )

- PHP  (8.3 prefer)

- Composer (Dependency Manager for PHP )

- Postgresql

- Redis

- Rabbitmq



#####  Postgresql Database Config

> To run this project locally, you need to set up a PostgreSQL database with the following configuration:

```
DB_HOST=127.0.0.1             		# Host
DB_PORT=5432       								# Port 
DB_DATABASE=live-rooms-platform   # database 
DB_USERNAME=spidey                # Username
DB_PASSWORD=postgres							# credentials
```

> 💡 Adjust these values as needed to match your PostgreSQL setup.
>



##### Rabbitmq Config

````
RABBITMQ_HOST=127.0.0.1    # Host  
RABBITMQ_PORT=5672 				 # Port 
RABBITMQ_USER=guest        # User
RABBITMQ_PASSWORD=guest    # password
````

> ⚙️ You can modify these values as needed to match your RabbitMQ environment.
>



##### Redis Config

```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
```

> ⚙️ You can modify these values as needed to match your Redis environment.





- Clone Project Repo

  ```bash
  $ git clone https://github.com/ShineShineDev/Live-Rooms-Platform.git
  $ cd Live-Rooms-Platform
  ```

- Checkout `main` Branch.

  >  To manually run the application, switch to the `main` branch. This branch contains all the necessary configurations and files for a direct, non-Docker setup.

  ```bash
  $ git checkout main
  ```





##### 1 Setup API api-gateway

- Install Dependencies

  ```
  $ cd api-gateway #navigate to api-gateway project
  
  $ composer install --no-interaction --prefer-dist --ignore-platform-req=ext-gd --ignore-platform-req=ext-socketsS
  ```

- Migrate

  ```
  php artisan migrate --force
  ```

- Install Passport

  ```
  php artisan passport:install --force
  ```

- Run 

  ```
  php artisan serve --port=8000
  ```



##### 2 Setup live-room-service

- Install Dependencies

  ```
  $ cd live-room-service #navigate to live-room-servicey project
  
  $ composer install --no-interaction --prefer-dist --ignore-platform-req=ext-gd --ignore-platform-req=ext-socketsS
  ```

- Migrate

  ```
  php artisan migrate --force
  ```

- Run Seeder

  ```
  php artisan db:seed --class=RoomSeeder --force
  ```

- Run 

  ```
  php artisan serve --port=8001
  ```



##### 3 Setup subscription-service

- Install Dependencies

  ```
  $ cd subscription-service #navigate to  subscription-service project
  
  $ composer install --no-interaction --prefer-dist --ignore-platform-req=ext-gd --ignore-platform-req=ext-socketsS
  ```

- Migrate

  ```
  php artisan migrate --force
  ```

- Run 

  ```
  php artisan serve --port=8002
  ```



##### 4 Setup websocket-server

- Install Dependencies

  ```
  $ cd websocket-server #navigate to  websocket-server project
  $ npm install
  ```

- Run 

  ```
  node server.js 
  ```





##### 5 Setup frontend

- Install Dependencies

  ```
  $ cd frontend #navigate to  frontend project
  $ npm install
  ```

- Run 

  ```
  node server.js 
  ```



Browse on => http://localhost:3000/





:warning: Please let me know if you have any questions or errors

 -	 +959 7877 966 98
 -	 https://portfolio-omega-plum-62.vercel.app/
 -	 aungshine194@gmail.com

