## Introducción

Este documento describe el proyecto de Marlon Torino, un ávido buscador de experiencias de viaje emocionantes alrededor del mundo. La aplicación web desarrollada permite a Marlon conocer el clima del día en la ciudad a la que desea viajar y calcular el presupuesto de viaje en la moneda local del destino escogido. Además, la aplicación está diseñada para ser utilizada en computadoras personales, tablets y teléfonos inteligentes, y permite compartir la información en español y alemán.

## Pantallas de la Aplicación

### Pantalla 1

-   **Funcionalidad**: Permite seleccionar el país y la ciudad de destino.
-   **Campos Obligatorios**:
    -   Selección del País: Inglaterra, Japón, India y Dinamarca.
    -   Selección de la Ciudad: Dos ciudades por cada país.
-   **Interacción**: Lista dinámica que se actualiza según el país seleccionado.

### Pantalla 2

-   **Funcionalidad**: Permite ingresar el presupuesto de viaje en pesos colombianos.
-   **Campos Obligatorios**:
    -   Presupuesto: Ingresado en pesos colombianos.

### Pantalla 3

-   **Funcionalidad**: Muestra los valores seleccionados en las dos primeras pantallas, el clima del día en la ciudad destino, la moneda local y el símbolo, el presupuesto convertido a la moneda local y la tasa de cambio aplicada.
-   **Campos Obligatorios**:

    -   País y Ciudad seleccionados.
    -   Presupuesto en pesos colombianos.

-   **Datos Mostrados**:
    -   Clima en grados centígrados.
    -   Nombre y símbolo de la moneda local.
    -   Presupuesto convertido con el símbolo de la moneda correspondiente.
    -   Tasa de cambio aplicada.

### Navegación

-   **Botones**:
    -   Siguiente y Atrás en las primeras dos pantallas.
    -   "Volver al inicio" en la última pantalla para realizar otra búsqueda.
-   **Menú**:
    -   Cambio de idioma (Español / Alemán): Cambia los textos al idioma seleccionado.
    -   Ver historial: Muestra las últimas 5 consultas realizadas por la aplicación.

## Configuración del Entorno de Desarrollo

1. **Laravel 8**: Seguir las instrucciones de instalación de Laravel 8 según la documentación oficial.
2. **PHP 7.4**: Instalar PHP 7.4 según las instrucciones de la documentación oficial de PHP.
3. **Bootstrap 5**: Incluir Bootstrap 5 en el frontend mediante CDN o instalación local según la guía oficial de Bootstrap.
4. **Angular 17**: Configurar Angular 17 en el frontend siguiendo las instrucciones de la documentación oficial de Angular.

### Frontend

El proyecto del frontend se encuentra compilado en este proyecto. Para ver el proyecto Fronend se encuentra en: [viajes_fronend](https://github.com/14Cristhian/viajes_fronend).

## Configuración de Laravel 8

1. **Base de Datos**: Configurar la base de datos en el archivo `.env` con los detalles de conexión adecuados.
2. **Modelos**: Crear modelos Eloquent en Laravel para interactuar con la base de datos.
3. **Controladores**: Crear controladores en Laravel para manejar las solicitudes HTTP y gestionar la lógica del servidor.

    - **WeatherController**: Este controlador maneja la obtención de datos de clima a través de la API de OpenWeatherMap. Recibe una solicitud HTTP con el nombre de la ciudad y el país, y devuelve los datos climáticos en formato JSON.
    - **convertirMoneda**: Este controlador se encarga de convertir una cantidad de dinero de una moneda a otra utilizando la API de conversión de moneda. Recibe la moneda de origen, la moneda de destino y la cantidad, y devuelve el resultado de la conversión en formato JSON.
    - **ConsultaController**: Este controlador se encarga de manejar las consultas realizadas por los usuarios. Almacena la información de la consulta en la base de datos y proporciona endpoints para guardar y eliminar consultas.

4. **Rutas**: Definir rutas en Laravel para enlazar solicitudes HTTP con controladores específicos.
    - Se define una ruta para la página principal y las vistas secundarias de la aplicación frontend en Angular.
    - Se definen rutas para guardar y eliminar consultas, obtener los últimos 5 registros de consultas y realizar peticiones de clima y conversión de moneda.

## Configuración de Angular 17

1. **Componentes**: Crear componentes en Angular para construir la interfaz de usuario.
2. **Servicios**: Crear servicios en Angular para manejar la comunicación con el backend a través de solicitudes HTTP.
3. **Enrutamiento**: Configurar el enrutamiento en Angular para navegar entre diferentes vistas de la aplicación.
4. **Interacción con Bootstrap 5**: Utilizar los estilos y componentes de Bootstrap 5 en los componentes de Angular según sea necesario.

El código fuente del frontend se encuentra disponible en el repositorio [viajes_fronend](https://github.com/14Cristhian/viajes_fronend).

## Despliegue

1. **Despliegue del Backend**: Desplegar el backend de Laravel en un servidor web compatible con PHP 7.4.
2. **Despliegue del Frontend**: Compilar el frontend de Angular y desplegarlo en un servidor web estático o integrarlo con el backend de Laravel según sea necesario.

Para las peticiones HTTP, se ha configurado un middleware `VerifyCsrfToken` en Laravel para excluir las siguientes rutas de la verificación CSRF:

-   /consultas
-   /consultas/\*
-   /get-weather
-   /convert-currency

## Estructura de la Tabla de la base de datos MySql

```sql
CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pais VARCHAR(255) NOT NULL,
    ciudad VARCHAR(255) NOT NULL,
    presupuesto DECIMAL(10, 2) NOT NULL,
    clima DECIMAL(10, 2) NOT NULL,
    monedaLocal DECIMAL(10, 2) NOT NULL,
    tasaCambio DECIMAL(10, 6) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Controladores

1. **WeatherController**:
   Este método recibe una solicitud HTTP con los parámetros 'city' y 'country', y utiliza estos parámetros para construir la URL de la API de OpenWeatherMap y obtener los datos climáticos de la ciudad y país especificados.

    ```php
    public function getWeather(Request $request)
     {
         $city = $request->input('city');
         $country = $request->input('country');
         $apiKey = 'ApiKey';
         $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$country}&units=metric&appid={$apiKey}";

         $response = Http::get($apiUrl);

         if ($response->failed()) {
             return response()->json(['error' => 'No se pudo obtener el clima'], 500);
         }

         return response()->json($response->json());
     }
    ```

2. **convertirMoneda**:
   Este método recibe la moneda de origen, la moneda de destino y la cantidad a convertir, y utiliza estos parámetros para realizar la conversión de moneda utilizando una API externa..

    ```php
    public function convertirMoneda(Request $request)
    {
        $from = 'COP';
        $to = $request->get('to');
        $amount = $request->get('amount');

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => 'TUAPIKEY',
            'X-RapidAPI-Host' => 'currency-conversion-and-exchange-rates.p.rapidapi.com',
        ])->get('https://currency-conversion-and-exchange-rates.p.rapidapi.com/convert', [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ]);

        return $response->json();
    }
    ```
