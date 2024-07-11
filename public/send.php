<?php

// vueからデータを受け取って、そのままcurlで送る
$data = json_decode(file_get_contents('php://input'), true);

$method = $data['method'];
$url = $data['url'];
$path_param = $data['path_param'];
$replace_param = $data['replace_param'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($path_param));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$response = curl_exec($ch); // レスポンスを変数に入れる
curl_close($ch);

echo $response;