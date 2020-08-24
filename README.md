# Docker 

Este es un ejemplo de docker con docker-compose para crear un entorno de trabajo con php y mysql ademas de agregar phpmyadmin para poder manejar la base de datos con facilidad.

## Antes de

Para correr esto necesitas instalar docker compose y docker.

## Correr el entorno

Para correr el ejemplo solo necesitas correr el yml con el siguiente comando.


docker-compose up -d


##  MySql

A qui vemos la configuracion para mysql agregamos las siguientes variables de entorno para la base de datos, usuario, contraseña y el password para root.

Tambien se cuenta con un volumen, esto para poder guardar la base de datos y no perderla en caso de borrar el contenedor.

```yml
  mysql:
    image: mysql:5.7
    container_name: dmysql
    environment:
      MYSQL_DATABASE: base
      MYSQL_USER: user
      MYSQL_PASSWORD: 1234
      MYSQL_ROOT_PASSWORD: 1234
    ports:
      - "3306:3306"
    volumes:
      - ./mysql:/var/lib/mysql
    restart: always
```

##  Phpmyadmin

A qui vemos la configuración para phpmyadmin donde solo se modifica la salida del puerto al 82, esta configuración es opcional. 


```yml
  myadmin:
    image: phpmyadmin
    container_name: phpmyadmin
    image: phpmyadmin/phpmyadmin
    depends_on: 
      - mysql
    ports: 
      - "82:80"
    links:
      - mysql:db
    restart: always
```

##  PHP

La configuración para php hace uso de un Dokerfile guardado en dockerfiles, el cual usamos para agregar la extension mysqli que no viene en la imagen de php. 

```docker
FROM php:7.0-apache

RUN a2enmod rewrite

RUN apt-get update \
    && docker-php-ext-install mysqli \
    && docker-php-ext-configure mysqli
    
```
Como se pude ver abajo ademas del uso del Dockerfile tambien contamos con un volumen para poder modificar los archivos.

```yml
  web:
    image: miphp
    container_name: dphp
    build: ./dockerfiles/
    ports:
      - "80:80"
    volumes:
      - ./php:/var/www/html
    links:
      - mysql
    restart: always
```

## Configuraciones alternativas

#### Bajar imagenes
```bash
docker pull mysql:5.7
docker pull php:7.0-apache
docker pull phpmyadmin/phpmyadmin
```
#### Generar la imagen antes

Acedemos a la carpeta dockerfiles y generamos la imagen

```bash
cd dockerfiles
docker build -t miphp .
```

Una vez generada podemos cambiar el archivo yml

```yml
  web:
    image: miphp
    container_name: dphp
    ports:
      - "80:80"
    volumes:
      - ./php:/var/www/html
    links:
      - mysql
    restart: always
```

#### Agregar la extensión manualmente


Para esto debemos modificar el yml

```yml
  web:
    image: php:7.0-apache
    container_name: dphp
    ports:
      - "80:80"
    volumes:
      - ./php:/var/www/html
    links:
      - mysql
    restart: always
```
Una ves hecho esto se debe modificar el contenedor desde adentro con el siguiente comando.

```bash
docker exec -i -t dphp /bin/bash
```

Ya adentro ejecutamos los siguientes comandos.

```bash
docker-php-ext-install mysqli
```

Instalamos nano opcional si no vim

```bash
apt-get update
apt-get install nano
```

Y modificamos los siguientes archivos.

```bash
cd /usr/local/etc/php/
nano php.ini-production 
nano php.ini-development 
```

Y agregamos el lo siguiente 

extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/mysqli.so

La dirección es octenida cuando agregamos la extensión.

#### Acceder a mysql desde vs code 

Agregamos la extensión MySql y podemos acceder con el usuario y contraseña ademas de poder hacer querys.

#### Acceder a mysql desde el contenedor

Podemos acceder al contenedor con el siguiente comando.

```bash
docker exec -i -t dmysql /bin/bash
```

Ya dentro podemos ejecutar los siguientes comandos.
```bash
mysql -uuser -p
```
Te pedira la contraseña una ves ejecutados tus comandos pudes salir con exit.

#### Comandos basicos 

```php
docker ps //Ver los contenedores activos
docker ps -a//Ver todos contenedores 
docker images //Ver la imagenes

docker rm id//Borramos un contenedor por id
docker rm $(docker ps -a -q)//Borramos todos los contenedores

docker stop //Igual solo que para el contenedor
docker start //Inicia el contenedor
docker restart //Reinicia el contenedor
```

## Urls

#### Info
[Basico docker](https://www.kodetop.com/tutorial-basico-de-docker/)
[Contenedores](https://www.kodetop.com/simplifica-el-uso-de-contenedores-con-docker-compose/)
[Laravel](https://www.youtube.com/watch?v=sR3Zp33fdPw)

#### Hubs
[phpmyadmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/)
[php](https://hub.docker.com/_/php)
[mysql](https://hub.docker.com/_/mysql)