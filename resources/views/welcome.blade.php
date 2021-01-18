<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="/css/all.css">

    </head>
    <body>
        <div id="app"><!--La equita id debe ser app, como hemos visto en app.js-->
              
                <mainapp></mainapp>
             </div>
    </body>
    <script src="{{asset('js/app.js')}}"></script> <!--Añadimos el js generado con webpack, donde se encuentra nuestro componente vuejs-->

</html>
