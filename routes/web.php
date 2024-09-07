<?php 

return[
    ['GET','/',[\App\Controller\HomeController::class,'index']],
    ['GET','/posts/{id:\d+}',[\App\Controller\PostController::class,'show']],
    ['GET','/posts',[\App\Controller\PostController::class,'create']],
    ['POST','/posts',[\App\Controller\PostController::class,'store']],
    ['GET','/register',[\App\Controller\RegistrationController::class,'index',[\followed\framed\Http\Middleware\Guest::class]]],
    ['POST','/register',[\App\Controller\RegistrationController::class,'register']],
    ['GET','/login',[\App\Controller\LoginController::class,'index',[\followed\framed\Http\Middleware\Guest::class]]],
    ['POST','/login',[\App\Controller\LoginController::class,'login',[\followed\framed\Http\Middleware\VerifyCsrfToken::class]]],
    ['GET','/logout',[\App\Controller\LoginController::class,'logout']],
    ['GET','/dash',[\App\Controller\DashboardController::class,'index',
        [
            followed\framed\Http\Middleware\Authenticate::class,
            followed\framed\Http\Middleware\Dummy::class
        ]
        ]],
    ['GET','/users/{name:.+}',function(string $name){
        return  new \followed\framed\Http\Response("hello $name");
    }],
];