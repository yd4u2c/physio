sio/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(163): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))
#63 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php(53): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
#64 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/ValidatePostSize.php(27): Illuminate\\Routing\\Pipeline->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))
#65 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(163): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))
#66 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php(53): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
#67 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Foundation/Http/Middleware/CheckForMaintenanceMode.php(62): Illuminate\\Routing\\Pipeline->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))
#68 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(163): Illuminate\\Foundation\\Http\\Middleware\\CheckForMaintenanceMode->handle(Object(Illuminate\\Http\\Request), Object(Closure))
#69 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php(53): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
#70 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(104): Illuminate\\Routing\\Pipeline->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))
#71 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(151): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
#72 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(116): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))
#73 /Library/WebServer/Documents/physio/public/index.php(55): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))
#74 /Library/WebServer/Documents/physio/server.php(21): require_once('/Library/WebSer...')
#75 {main}
"} 
[2019-05-25 09:14:41] local.ERROR: Array to string conversion {"userId":4,"exception":"[object] (ErrorException(code: 0): Array to string conversion at /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Support/Str.php:335)
[stacktrace]
#0 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Support/Str.php(335): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, 'Array to string...', '/Library/WebSer...', 335, Array)
#1 /Library/WebServer/Documents/physio/vendor/laravel/framewor