nate\\Database\\Eloquent\\Model::__callStatic('create', Array)
#16 [internal function]: App\\Http\\Controllers\\OrtController->ortPage2(Object(Illuminate\\Http\\Request))
#17 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Controller.php(54): call_user_func_array(Array, Array)
#18 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php(45): Illuminate\\Routing\\Controller->callAction('ortPage2', Array)
#19 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Route.php(219): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\OrtController), 'ortPage2')
#20 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Route.php(176): Illuminate\\Routing\\Route->runController()
#21 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Router.php(680): Illuminate\\Routing\\Route->run()
#22 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Pipeline.php(30): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))
#23 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Routing/Middleware/SubstituteBindings.php(41): Illuminate\\Routing\\Pipeline->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))
#24 /Library/WebServer/Documents/physio/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(163): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))
#25 /Libr