<?php 

return[
    ['GET','/',[\App\Controller\HomeController::class,'index']],
    ['GET','/posts/{id:\d+}',[\App\Controller\PostController::class,'show']],
    ['GET','/users/{name:.+}',function(string $name){
        return  new \followed\framed\Http\Response("hello $name");
    }],

];