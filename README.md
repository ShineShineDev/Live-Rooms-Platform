

### Manual setup

##### Prerequisite

- Node (v20.18 prefer )

- PHP  (8.3)

- Composer (Dependency Manager for PHP )

- Postgresql

- Redis

- Rabbitmq

  

###### Clone Repo

```cmd
git clone https://github.com/ShineShineDev/ticket.git
```









### Run Front End App

```js
$ cd ticket/
$ cd front-end/

$ npm i    
$ npm run serve
```

Browse on => http://localhost:8080/ 

> ##### Config For Back-End Connections
>
> ```js
> //front-end/src/config.js
> 
> // export const BASE_URL = 'http://localhost:3000';
> export const BASE_URL = 'http://ec2-3-27-191-151.ap-southeast-2.compute.amazonaws.com';
> ```



### Run Back End App

```js
$ cd back-end/
$ npm i    
$ npm run dev
```

Browse on => http://localhost:3000

> #### Config For Database Connections
>
> ```js
> //back-end/ormconfig.json
> 
> {
> "type": "mongodb",
> "url": "mongodb+srv://ticket:cLAMFYAbDyYw5zzU@cluster0.xawwpks.mongodb.net/ticket?retryWrites=true&w=majority",
> "useNewUrlParser": true,
> "synchronize": true,
> "logging": true,
> "entities": ["src/models/**/*.ts"],
> "migrations": ["src/migrations/**/*.ts"],
> "subscribers": ["src/subscribers/**/*.ts"],
> "cli": {
> "entitiesDir": "src/models",
> "migrationsDir": "src/migrations",
> "subscribersDir": "src/subscribers"
> }
> }
> ```
>
> 



:warning: Please let me know if you have any questions or errors

 -	 09 7877 966 98
 -	 aungshine194@gmail.com


