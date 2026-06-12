# tp_RegistroPerfil
TP CLASE 18 de programación UTN

# Clase #18: Integración de PHP y MySQL con Docker

Este proyecto consiste en el desarrollo del backend, enfocado en la creación de usuarios (registro) y la validación de credenciales (inicio de sesión). La aplicación conecta un frontend desarrollado en HTML y Tailwind CSS con una base de datos relacional MySQL, utilizando Docker para la contenedorización y portabilidad de todo el entorno.

---

## 🚀 Arquitectura y Componentes del Proyecto

Para garantizar un entorno limpio, reproducible y aislado, implementé una arquitectura basada en contenedores dividida en dos servicios principales:

1. **Servidor Web (`web`)**: Utiliza una imagen oficial de `php:8.2-apache`. Se configuró un volumen para sincronizar los archivos locales del proyecto con el directorio `/var/www/html` del contenedor y se habilitó la extensión `mysqli` para permitir la comunicación con el motor de base de datos.
2. **Base de Datos (`db`)**: Corre sobre `mysql:8.0`. Cuenta con persistencia de datos local mediante volúmenes de Docker y automatiza la creación de la estructura de las tablas al iniciar el contenedor por primera vez.

---

## 🛠️ Flujo de Trabajo Implementado

### 1. Persistencia y Modelado de Datos (`mi_banco_db.sql`)
Se diseñó la tabla `usuarios` definiendo restricciones de integridad estrictas (`NOT NULL`, `UNIQUE`) para campos críticos como el documento, el correo electrónico y el nombre de usuario, asegurando la consistencia de los datos desde el motor de la base de datos.

### 2. Capa de Conexión Centralizada (`conexion.php`)
Desarrollé un script único de conexión utilizando la extensión **MySQLi**. Al estar dentro del entorno de Docker, la conexión se establece apuntando al hostname del servicio de la base de datos (`db`), configurando además el juego de caracteres en `utf8mb4` para evitar conflictos con tildes y eñes.

### 3. Procesamiento de Altas (`altas.php`)
Este script recibe las peticiones `POST` enviadas desde el formulario de registro. Su lógica incluye:
* Validación en el lado del servidor para asegurar que las contraseñas ingresadas coincidan.
* Implementación de **Sentencias Preparadas (*Prepared Statements*)** mediante `$conn->prepare()`. Esto precompila la estructura SQL en el motor y mapea los parámetros de forma aislada, anulando cualquier riesgo de ataques por **Inyección SQL**.

### 4. Autenticación de Usuarios (`ingreso.php`)
Encargado de procesar el inicio de sesión. Utiliza sentencias preparadas para buscar al usuario por su tipo de documento, número y nombre de usuario en una sola consulta. Si el registro existe, el script realiza la verificación de la contraseña para otorgar o denegar el acceso al sistema.

---

## 📦 Comandos Clave del Entorno

Durante el desarrollo y testeo del proyecto, utilicé los siguientes comandos de Docker para gestionar el ciclo de vida de la aplicación:

* **Levantar el entorno completo (en segundo plano):**
  ```bash
  docker compose up -d
* **Instalar la extensión MySQLi en el contenedor de PHP (necesario solo en la inicialización):**
  ```bash
  docker exec -it mi_banco_web docker-php-ext-install mysqli && docker restart mi_banco_web

* **Apagar los contenedores preservando los datos de la base de datos:**
  ```bash
  docker compose down

* **Limpieza total (apagar contenedores y remover volúmenes de datos):**
  ```bash
  docker compose down -v
  

  
