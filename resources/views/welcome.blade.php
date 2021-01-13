<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

       
    </head>
    <body>
        <div id="app" class="content"><!--La equita id debe ser app, como hemos visto en app.js-->
                <example-component></example-component><!--Añadimos nuestro componente vuejs-->
                <router-view></router-view>
             </div>
    </body>
    <script src="{{asset('js/app.js')}}"></script> <!--Añadimos el js generado con webpack, donde se encuentra nuestro componente vuejs-->

</html>
