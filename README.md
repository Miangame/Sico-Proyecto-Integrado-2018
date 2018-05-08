Symfony Standard Edition
========================
## Índice de contenido
1. Introducción
2. Objetivos del proyecto
* Facilitar el reparto de las FCTs y PIs de manera gráfica e intuitiva
* Implantación en un servidor del departamento.
* Documentación de la implantación.
* Configurar distintos aspectos del reparto
* Facilitar la importación de alumnos y empresas partiendo de hojas de cálculo
* Mantener el historial de años anteriores (empresas y proyectos)
* Ordenación de empresas por fecha de solicitud de la empresa
* Valorar la FCT ya realizada según la opinión del alumnado y del profesorado, también por contenidos tratados…
* Ordenación de la empresa por la valoración anterior.
* Gestión de horarios (Septiembre/Marzo, Marzo/Junio con reducción horaria)
* Gestión de fechas de exámenes de la última evaluación

### 1.- Introducción
Los módulos profesionales de "Proyecto de desarrollo de aplicaciones web" y "Proyecto de administración de sistemas informáticos en red" (más comúnmente denominados "Proyecto Integrado" ó PI) y de "Formación en centros de trabajo" (FCT) son dos módulos de los ciclos formativos de Grado Superior. Ambos se cursan una vez superados el resto de módulos profesionales que constituyen las enseñanzas del ciclo formativo.
Durante el curso académico, en el Departamento de Informática y Comunicaciones del IES Gran Capitán los alumnos de los ciclos comienzan dichos módulos en Septiembre (alumnos que aprobaron todos los módulos lectivos en Junio) y en Marzo (alumnos que aprobaron todos los módulos lectivos en la segunda evaluación de Marzo).
Tanto en Septiembre como en Marzo el profesorado del ciclo se reparte la tutoría/seguimiento de dichos módulos. Esto supone buscar un equilibrio del trabajo a repartir, en el que intervienen:



**WARNING**: This distribution does not support Symfony 4. See the
[Installing & Setting up the Symfony Framework][15] page to find a replacement
that fits you best.

Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev env) - Adds code generation
    capabilities

  * [**WebServerBundle**][14] (in dev env) - Adds commands for running applications
    using the PHP built-in web server

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.4/setup.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.4/doctrine.html
[8]:  https://symfony.com/doc/3.4/templating.html
[9]:  https://symfony.com/doc/3.4/security.html
[10]: https://symfony.com/doc/3.4/email.html
[11]: https://symfony.com/doc/3.4/logging.html
[13]: https://symfony.com/doc/current/bundles/SensioGeneratorBundle/index.html
[14]: https://symfony.com/doc/current/setup/built_in_web_server.html
[15]: https://symfony.com/doc/current/setup.html
