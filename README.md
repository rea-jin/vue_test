# send_json
define.js copyをもとにdefine.jsを作成し設定を書く

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```
開発サーバーは8080ポートなので、送信先も同じポートじゃないとCORS（Cross-Origin Resource Sharing）ポリシーによるエラーが
発生する。
php fileに
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
* この部分はjsontestのドメインを指定する

Laravelの場合
composer require fruitcake/laravel-cors　インストール
kernel.phpに追加
protected $middleware = [
    // ...
    \Fruitcake\Cors\HandleCors::class,
];

これをインストールできればいいが、できなければ
CorsMiddleware.phpを作ってコピペ
--------------------------------------------------------------
<?php

// app/Http/Middleware/CorsMiddleware.php


namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }
    
        //許可したいドメインを追加
        $allowedOrigins = [
            'http://localhost:8080', 
            'http://jsontest'
        ];
        $origin = $request->header('Origin');
        if (in_array($origin, $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }
        return $response;
    }
}
-----------------------------------------------------------------------
その後、kernel.phpのprotected $middlewareに
いか追加
\App\Http\Middleware\CorsMiddleware::class,

### Compiles and minifies for production
```
npm run build
```
npm run serveを使わない場合、
virtual hostのdocument root , root directoryは/distにする

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).
