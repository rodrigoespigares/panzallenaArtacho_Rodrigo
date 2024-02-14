
# PanzaLlena

En este proyecto hemos buscando la gestión de una cadena de restaurantes, donde podrán hacer sus pedidos de productos y llevar acabo operaciones entre los empleados de estas sucursales y la central.




## Contenido aprendido
Gracias a este proyecto hemos podido aprender:

- A trabajar en equipo
- Gestionar Symfony 6.4.3
- Modificar Symfony 6.4.3
- Usar el ORM de Symfony 6.4.3
- Gestión de rutas en Symfony 6.4.3



## Instalación del proyecto

Para instalar el proyecto deberemos clonar el repositorio.

Una vez completado esto deberemos configurar el .ENV.

![Captura de pantalla 2024-02-14 190823](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/b4cbbbf7-98e3-435c-a4d9-bb20564fbf80)

Colocando la direccion del email y nuestros datos de la base de datos, nombre de usuario y contraseña.

Tras esto realizar los siguientes comandos en la consola:

```bash
  composer update
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
```

Ahora vas a desproteger la ruta register y asi dejar la misma disponible para el registro del primer usuario dentro de security.yaml.

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/2631fe69-0efc-4a0f-896e-7701848e9100)

Tras esto coloca el comando:

```bash
  symfony server:start
```
Y ya podremos entrar en el servidor. En la ruta https://127.0.0.1:8000/register

Una vez completado el registro deberás confirmar el correo y ya podrás iniciar sesión.

Deberás darte permisos en la base de datos de entre los disponibles:

>[!IMPORTANT]
> Roles disponibles: ROLE_RESTAURANTE (default), ROLE_PEDIDOS (departamento de pedidos), ROLE_ADMIN (con acceso a todo lo demás).


## Galería




## Autores

- [@rodrigoespigares](https://www.github.com/rodrigoespigares)
- [@josemiguelartachogutierrez](https://github.com/JoseMiguelArtachoGutierrez)
