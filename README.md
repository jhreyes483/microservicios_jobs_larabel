# Prueba 

## Microservicios

### order_service: 
Este servicio se encarga de recibir las ordenes y enviarlas al microservicio de warehouse_service.

### warehouse_ingredients_service: 
Este servicio se encarga de proveer el inventario solicitado de order_service y comprar el ingrediente en caso de no tenerlo disponible, en caso de que la market no tenga el producto se genera un job el cual estará solicitando el producto hasta que se pueda comprar 

### frontend-vue:
Consume los dos microservicios, para la gestión de ordenes e informes de los movimientos del sistema.

### Credenciales por default
Correo: jav-rn@hotmail.com 
Password: password

Gracias
