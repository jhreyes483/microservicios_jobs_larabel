# Microservicios laravel

## Microservicios

### order_service: 
Este servicio se encarga de recibir las ordenes y enviarlas al microservicio de warehouse_service.
Se genera tabla de configuracion llamada configs donde se pueden definir dos flujos distintos.
1=> Crear ordenes solo con ingredientes existentes (aleatoreo).
2=> Crear ordenes con todos los ingredientes sin importar si hay existencias (aleatoreo), en este caso las ordenes cambian de estado una vez se tiene todos los productos comprados (jobs)


### warehouse_ingredients_service: 
Este servicio se encarga de proveer el inventario solicitado de order_service y comprar el ingrediente en caso de no tenerlo disponible, en caso de que la market no tenga el producto se genera un job el cual estará solicitando el producto hasta que se pueda comprar 


## farmers_market_service:
Se encarga de administrar la plaza el inventario de la plaza de mercado para lograr manejar el flujo completo de la prueba planteada.

### frontend-vue:
Consume los dos microservicios, para la gestión de ordenes e informes de los movimientos del sistema.


### Credenciales por default
Correo: jav-rn@hotmail.com 
Password: password



### Hoja de vida 
https://jhreyes483.github.io/Hoja_V/

Gracias
