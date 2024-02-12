## Overview

Prueba técnica de un CRUD API REST que consta de un controlador para Leads. 

### Requerimientos

- **Php ^8.1**
- **Composer**
- **Docker**

## Instalación

- **1) Clonar proyecto en entorno local** ````git clone git@github.com:ecuation/iahorro.git````
- **2) Copiar fichero .env.example como .env**
- **3) Instalar dependencias con comando:** ```composer install```
- **4) Levantar contenedores Docker del proyecto con comando:** ```./vendor/bin/sail up```
- **5) Correr migraciones con comando:** ```./vendor/bin/sail artisan migrate```


## Tests de LeadController

Para correr los tests simplemente lo haremos a través del comando```./vendor/bin/sail artisan test```.
Este comando ejecutará los test que se encuentran en el fichero```tests/API/LeadControllerAPITest```

## Endpoints
POST       api/lead ......................................................................................................................................................................... leads.store › LeadController@store  
PATCH      api/lead/{id} .................................................................................................................................................................. leads.update › LeadController@update  
GET|HEAD   api/lead/{id} ...................................................................................................................................................................... leads.show › LeadController@show  
DELETE     api/lead/{id} ................................................................................................................................................................ leads.destroy › LeadController@destroy

## LeadController
Este es el controlador que se ha refactorizado se han añadido 2 nuevos servicios para separar responsabilidades en el mismo.

## LeadService
Este servicio consta de 2 métodos ```createLeadFromClient```  y ```updateLead```. Estos métodos se encargan a su vez llamar a otro servicio
externo el ```LeadScoringService```, simplemente he separado responsabilidades ya que dichos métodos reciben una data correspondiente a un Lead
y también requieren de un cálculo de un score que se realiza por medio del servicio LeadScoringService, de esta forma tenemos métodos más limpios en el controlador
y además separamos responsabilidades facilitando la mantenibilidad y la escalabilidad del proyecto a futuro.

## ClientService
En este servicio he creado un método ```storeOrUpdateClientIfExists``` el cual se encarga de comprobar por medio del campo email si el cliente existe
y en caso afirmativo simplemente actualizaremos el modelo con los datos enviados, en caso contrario, si el cliente no existe, lo que hará es crear un nuevo cliente
y devolver el modelo en cuestión.

## Manejo de Errores en LeadController@store (Error handling)
Primero hemos separado la validación del request en un ````StoreLeadRequest```` , el cual tiene las reglas de validación requeridas para las peticiones que se envíen a dicho endpoint, de esta 
manera también tendremos un método store mucho más limpio y con la responsabilidad de validación separada en un LaravelRequest (StoreLeadRequest).

Este método (store) no solo se encarga de crear un nuevo Lead, si no que además debemos comprobar sin un cliente existe y crear o actualizar según el caso. 
Para ello he usado un try/catch con un DB transaction el cual se encarga de ejecutar las queries SQL y en caso de que alguna de ellas falle hacemos un rollback de la transacción lanzando un HTTPException.

Para la respuesta en caso exitoso, también hemos usado un Laravel API Resource el cual ayuda a tener un código más limpio y reutilizable a la hora de enviar respuestas JSON de dicho recurso,
este resource es el ```LeadResource```.

## Manejo de HTTPResponses en los métodos show, update y destroy
Para normalizar las respuestas básicas HTTP he creado un fichero helper ```HTTPResponseHelper``` con un método ```notFoundResponse```, esta clase no solo puede tener 
un método para dichos casos, en caso de necesitar extender a otras respuetas simplemente se puede ir añadiendo los métodos correspondientes para así tenerlo todo centralizado 
en una sola clase y mantener uniformidad en las respuestas JSON HTTP.

## Tests
En el ````LeadControllerAPITest```` no solo se están comprobando los endpoints CRUD para los casos básicos,
también he añadido pruebas para casos más especificos como el test ````test_store_lead_from_existing_client````. En este test
se comprueba que efectivamente si existe un cliente con dicho email este sea actualizado, además de retornar su status correcto.









