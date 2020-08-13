# Practica 2 - Software Avanzado

Esta aplicación es un cliente que consume el web service: https://api.softwareavanzado.world/index.php?webserviceClient=administrator&webserviceVersion=1.0.0&option=contact&api=hal&format=doc.

###### La parte 1 consiste en:
Continuación de la pratica 1, agregando credenciales tipo client_credentials y un token Bearer para poder volver a desarrollar el mismo ejercicio.

En donde el flujo consiste, en solicitar al servidor un bearer token utilizando credenciales tipo client_credentials, para luego con el bearer token realizar los request corresopndientes para la creación de contactos y listar los mismos.

Realizando las siguientes operaciones para este caso:
  - Crear contacto
  - Crear multiples contactos
  - Listar los contactos por medio de un filtro de tipo texto
  - Imprimir la lista de contactos
  - Obtener bearer token 

###### La parte 2 consiste en:
Continuación de la pratica 1, ahora utilizando SOAP y autenticación básica.

El flujo consiste en realizar el request al servidor utilizando autentificación basica y por medio del cuerpo del request enviar el xml con los parametros encargado para realizar el metodo correspondiente del lado del servidor.

Realizando las siguientes operaciones para este caso:
  - Crear contacto
  - Crear multiples contactos
  - Listar los contactos por medio de un filtro de tipo texto
  - Imprimir la lista de contactos

# Requisitos
  - PHP 5.6 o superior (puede funcionar con algunas versiones inferiores).

### Instalación
```sh
$ apt-get install php
```
### Ejecutar
```sh
$ php SATarea1.php
```
###### NOTA:
También puede ser ejecutado desde un navegador.