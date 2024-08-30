<?php 

return[
    ['GET','/',[\App\Controller\HomeController::class,'index']],
    ['GET','/posts/{id:\d+}',[\App\Controller\PostController::class,'show']],
    ['GET','/posts',[\App\Controller\PostController::class,'create']],
    ['POST','/posts',[\App\Controller\PostController::class,'store']],
    ['GET','/register',[\App\Controller\RegistrationController::class,'index']],
    ['POST','/register',[\App\Controller\RegistrationController::class,'register']],
    ['GET','/login',[\App\Controller\LoginController::class,'index']],
    ['POST','/login',[\App\Controller\LoginController::class,'login']],
    ['GET','/dash',[\App\Controller\DashboardController::class,'index']],
    ['GET','/users/{name:.+}',function(string $name){
        return  new \followed\framed\Http\Response("hello $name");
    }],
];