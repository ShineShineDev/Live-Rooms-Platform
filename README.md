#### Overview 

### Tech stack 

-  **Nuxt** :  For Frontend
- **Laravle **:  For API Gateway & Backend Services
- **Postgresql** :  For Database
- **Redis  ** :  For Caching
- **RabbitMQ** :  For Message broker
- **Websocket** :  For Real-time communication 





##### Pull Docker Image (Easiest way to Run App)

```
docker pull spideyshine/
```



##### Run

```
sudo docker run -d -p 7912:80 spideyshine/apache-webserver-with-bootstarp-template
```



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
> https://www.postgresql.org/download/



##### Rabbitmq Config

````
RABBITMQ_HOST=127.0.0.1    # Host  
RABBITMQ_PORT=5672 				 # Port 
RABBITMQ_USER=guest        # User
RABBITMQ_PASSWORD=guest    # password
````

> ⚙️ You can modify these values as needed to match your RabbitMQ environment.
>
> https://www.rabbitmq.com/tutorials



##### Redis Config

```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CLIENT=predis
```

> ⚙️ You can modify these values as needed to match your Redis environment.



##### Clone Project Repo

```cmd
git clone https://github.com/ShineShineDev/Live-Rooms-Platform.git
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

##### 





:warning: Please let me know if you have any questions or errors

 -	 09 7877 966 98
 -	 aungshine194@gmail.com

