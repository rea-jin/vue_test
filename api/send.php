<?php

// CORSヘッダーを設定（開発環境用、本番環境では適切に設定してください）
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// POSTデータを取得
$data = json_decode(file_get_contents("php://input"), true);

// APIのURLを構築
$apiUrl = $data['route'];  // VueコンポーネントからのrouteデータをAPIのURLとして使用
$pathParameter = $data['pathParameter'];  // VueコンポーネントからのpathParameterデータをAPIのURLに埋め込む
$replaceParam = $data['replaceParam'];  // VueコンポーネントからのreplaceParamデータをAPIのURLに埋め込む
$method = $data['method'];  // VueコンポーネントからのmethodデータをAPIのリクエストメソッドとして使用
$request = json_decode($data['request'], true);

// cURLを使用して外部APIにリクエストを送信
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// パスパラメータ置き換え
$apiUrl = str_replace($pathParameter, $replaceParam, $apiUrl);

if($method === 'GET'){
  // クエリパラメータ作成
  $query = http_build_query($request);
  // URLにクエリパラメータを追加
  $apiUrl = $apiUrl . '?' . $query;
  curl_setopt($ch, CURLOPT_URL, $apiUrl);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
} else {
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
  curl_setopt($ch, CURLOPT_URL, $apiUrl);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

}
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// APIからのレスポンスをそのままクライアントに返す
http_response_code($httpCode);
echo $response;