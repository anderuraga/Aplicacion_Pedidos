# Aplicación Gestión de Pedidos

Apliación para la gestión de pedidos internos del CIFP Elorrieta-Errekamari.

## Instalación del entorno de la App para Linux

1 - Actualiza repositorios y sistema
``` 
sudo apt update && sudo apt upgrade -y 
```

2 - Instalar Apache (o Nginx) y herramientas básicas
``` 
sudo apt install -y apache2 git unzip curl 
```

3 - Instalar PHP 8.4 y extensiones
```
 sudo apt install -y software-properties-common 
```

```
sudo apt update
sudo apt install -y php8.4 php8.4-cli php8.4-fpm \
    php8.4-mbstring php8.4-zip php8.4-gd php8.4-common \
    php8.4-curl php8.4-mysqli php8.4-intl

sudo a2enconf php8.4-fpm
sudo a2enmod rewrite
sudo systemctl restart apache2
```

## 🚀 Servidor de Aplicaciones Apache

Desplegar archivos de la aplicación en **/var/www/html/**

Permisos
```
sudo chown -R www-data:www-data /var/www/html
sudo find /var/www/html -type d -exec chmod 755 {} \;
sudo find /var/www/html -type f -exec chmod 644 {} \;
sudo chmod -R 775 /var/www/html/public/uploads
```


Está aplicación se ejecuta reemplazando el html de ejemplo que viene por defecto en la isntalación de Apache.<br>
La configuración de los ficheros de GitHub, se supone que la app se ejecuta en una aplicación virtual de una carpeta llamada 'elorrieta', por eso hay que sustituir el siguiente ficheros:


Cambiar el fichero **.htaccess**
```
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```


## 🛠️ Base de datos MySQL


### Diagrama bbdd
![diagrama](/config/EsquemaBBDD.png)


### instalación de MySql
Instalar servidor MySQL
```
sudo apt install -y mysql-server
```
Asegurar instalación
```
sudo mysql_secure_installation
```

Crear base de datos y usuario
```
sudo mysql -u root -p
CREATE DATABASE TU_NOMBRE_BBDD CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
CREATE USER 'TU_USUARIO'@'localhost' IDENTIFIED BY 'TU_PASSWORD';
GRANT ALL PRIVILEGES ON elorrieta.* TO 'pedidos'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Importar el esquema de la base de datos
```
mysql -u TU_USUARIO -p TU_NOMBRE_BBDD < config/script.sql
```

Crear primer usuario tipo administrador para poder entrar en la App. <br>
La contraseña está encriptada con **bcrypt** este caso es **emaginarte!**
```
mysql -u TU_USUARIO -p -e "INSERT INTO `usuarios` (`id`, `tipo`, `nombre`, `correo`, `contrasena`, `id_departamento`, `baja`) VALUES ('1', '1', 'Admin', 'TU_EMAIL@gmail.com', '$2y$10$yg3OieTkZKvVC3eLJGjtDuvk6RVEb1ZRDfx2FD2ma1rnAbStDkoaC', '2', NULL)"
```

### Configurar parámetros de conexión a la BD
config/Database.php
```
   return [
    'host'     => 'localhost',
    'dbname'   => 'elorrieta',
    'user'     => 'elorrieta',
    'password' => 'tu_password_segura',
    'charset'  => 'utf8mb4',
];

```


## 🔐 Configurar Google Cloud para usar OAuth2 con Gmail

Sigue estos pasos para habilitar el envío de correos mediante Gmail y OAuth2:

1. Accede a [Google Cloud Console](https://console.cloud.google.com/).

2. Crea un nuevo proyecto web.

3. Activa la **API de Gmail**:
   - Ve a **API y servicios** > **Biblioteca**.
   - Busca **Gmail API** y haz clic en **Habilitar**.

4. Crea credenciales OAuth2:
   - Ve a **API y servicios** > **Credenciales**.
   - Haz clic en **Crear credenciales** > `ID de cliente de OAuth 2.0`.
   - Selecciona el tipo de aplicación: **Aplicación web**.

5. Copia tu Client ID y Client Secret.

6. En la configuración del cliente OAuth, añade un URI de redirección autorizado: 
     [callback para obtener refresh_token](http://localhost/get_refresh_token.php)

7. Obten **Access Token** mediante la llamada del callback del paso 6.

### modifica las constantes de la aplicación

config/constantes.php

```
// Email
define('EMAIL_HOST', '');
define('EMAIL_CORREO', '');
//No se usan con Gmail Oauth2
//define('EMAIL_CONTRASENA', '');
define('EMAIL_PORT', '587');
define('EMAIL_FROM_NAME','Plataforma Elorrieta');
define('CLIENT_ID', '');
define('CLIENT_SECRET', '');
define('REFRESH_TOKEN', '');
```
