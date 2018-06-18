# Configuración del servidor
1. Update y upgrade del servidor: 
    - `apt-get update`
    - `apt-get upgrade`

2. Instalar Apache2: 
    - `apt-get install apache2`

3. Instalar MySql:
    - `apt-get install mysql-server`
    - `mysql_secure_installation`
        - Delete anonymous users -> 'Yes'
        - Disallow root login remotely -> 'No'
        - Remove test database -> 'Yes'
        - Reload privileges -> 'Yes'

4. Instalar phpmyadmin:
    - `apt-get install phpmyadmin`
        - Seleccionar apache2
        - ¿Desea configurar la base de datos para phpmyadmin con «dbconfig-common»? -> 'Yes'
        - Entrar en phpmyadmin y crear base de datos llamada "SICO"

5. Instalar PHP7.2:
    - `wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg`
    - `echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list`
    - `apt-get update`
    - `apt-get install php7.2`
    - `apt-get install php7.2-cli php7.2-common php7.2-curl php7.2-gd php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache php7.2-readline php7.2-xml`

6. Instalar composer de manera global:
    - `curl -sS https://getcomposer.org/installer | php`
    - `mv composer.phar /usr/local/bin/composer`
    
7. Configurar apache:
    - `nano /etc/apache2/sites-available/000-default.conf` (<span style="color:red">Comentar TODO lo que hay y crear nuevo virtual host</span>)
    ```
    <VirtualHost *:80>
            ServerName domain.tld
            ServerAlias www.domain.tld
    
            DocumentRoot /var/www/html/web
            <Directory /var/www/html/web>
                # enable the .htaccess rewrites
                AllowOverride All
                Order allow,deny
                Allow from All
            </Directory>
    
            ErrorLog /var/log/apache2/sico_error.log
            CustomLog /var/log/apache2/sico_access.log combined
        </VirtualHost>
    ```
    - `a2enmod rewrite`
    - `service apache2 restart`

# Poner la web en producción

1. Ir a la carpeta /var/www/html/. Si es la primera instalación, borrar todo el contenido de dicha carpeta.

2. Inicializar git:
    - `git init`

3. Añadir la url del repositorio remoto:
    - `git remote add origin https://github.com/iesgrancapitan-proyectos/201718daw-junio-reparto-sico-reparto-sico.git`

4. Descargarse el proyecto:
    - `git pull origin master`

5. Instalar las dependencias con composer
    - `composer install` (pulsar INTRO cuando llegue a los parametros) (<span style="color:red">Saltará un error</span>)

6. Configurar el archivo parameters.yml
    - `nano app/config/parameters.yml` (Configurar las siguientes líneas)
    ```yaml
     database_name: SICO
     database_user: #{usuario bbdd}
     database_password: #{password bbdd}
     mailer_transport: gmail #{cambiar en caso de ser otro}
     mailer_host: smtp.gmail.com #{cambiar en caso de ser otro}
     mailer_user: #{correo que se vaya a usar}
     mailer_password: #{contraseña del correo}
     session_max_idle_time: 1800

7. Ejecutar lo siguiente para borrar la caché almacenada, dar permisos y actualizar la base de datos
    - `php bin/console d:g:entities AppBundle`
    - `sh scripts/deploy.sh`
    - `php bin/console doctrine:fixtures:load`
    - `chmod 777 -R var/logs` 
    - `chmod 777 -R var/sessions`

# Actualizar cambios

1. Descargar ultimos cambios del repositorio
    - `git pull origin master`
    - `php bin/console d:g:entities AppBundle`
    - `sh scripts/deploy.sh`
