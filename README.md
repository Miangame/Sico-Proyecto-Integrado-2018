Bienvenido a SICO
========================
Desarrollado por `Javier Ponferrada López y Miguel Ángel Gavilán Merino`

Para mas info: [aquí](https://github.com/Miangame/Sico-Proyecto-Integrado-2018/wiki)

# Instalación
Éstos son los pasos a seguir para poner la web en producción:
1. Tener instalado todos los requerimientos descritos en la sección ([REQUISITOS](https://github.com/Miangame/Sico-Proyecto-Integrado-2018/wiki/Requisitos))

2. SICO dispone de un gestor de dependencias llamado "Composer", por lo que primero tendremos que hacer será instalar composer de forma global en nuestro sistema:
    - Instalar paquetes necesarios `$ sudo apt-get install curl php-cli php-mbstring git unzip`
    - Aseguramos que estamos en nuestro directorio personal `$ cd ~`
    - Descargar instalador de composer `$ curl -sS https://getcomposer.org/installer -o composer-setup.php`
    - Comprobar que es la última versión de composer `$ php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"`
    - Instalar composer `$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer`

3. Instalamos todas las dependencias necesarias mediante éste comando:
    - `$ composer install`

4. Symfony requiere que borremos caché y demos permisos por lo que tendremos que ejecutar el siguiente script:
    - `$ sh scripts/deploy.sh`

5. SICO dispone de un ORM llamado "Doctrine" y el cual nos va a generar transformar todas las entidades(objetos) a tablas en la BBDD. Esto es posible mediante los siguientes comandos:
    - Aseguramos que las entidades están completas `$ php bin/console doctrine:g:entities AppBundle`
    - Generamos las tablas en la BBDD `$ php bin/console doctrine:schema:update --force`
