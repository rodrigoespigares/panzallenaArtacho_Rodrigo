
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

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/b9f5de92-5d63-4078-b3ea-16b63a1cac1b)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/a2a9d668-8184-4072-abfe-f408a490efec)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/d29fd2a0-b8f7-49f9-8b02-5d26925014a9)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/9dad0de8-1a6e-475e-9197-2b983a6c4098)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/20c25cd3-9c3b-4f45-9686-86f19da90cc6)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/7743637b-9a43-47e4-a75d-4ce7d3da6b95)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/aea5eac2-a1bd-4b77-9bf8-1db98cb9d454)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/da068a49-0922-43ea-b18c-126c6ed57762)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/86ce961b-cec5-4b10-b7ec-42911612c813)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/a62e4c95-152b-4258-ab0c-85a4046a944d)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/305c5bbd-8fe7-482b-be31-cc831fd73002)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/b8162782-30f9-4ec6-be6f-0cad313acf8c)

![imagen](https://github.com/rodrigoespigares/restauranteSF/assets/94736646/dea148bb-b794-48e2-836c-deaba378b884)


## Autores

- [@rodrigoespigares](https://www.github.com/rodrigoespigares)
- [@josemiguelartachogutierrez](https://github.com/JoseMiguelArtachoGutierrez)
