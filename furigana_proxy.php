<?php
// APIキーを外部ファイルから読み込み
include 'config.php';

// Yahoo APIキーを設定してください
$apiKey = YAHOO_API_KEY;

// クライアントからのテキストデータを受け取る
$inputText = $_POST['text'];

// Yahoo APIリクエストの設定
$url = "https://jlp.yahooapis.jp/FuriganaService/V2/furigana";
$data = array(
  "id" => "1",
  "jsonrpc" => "2.0",
  "method" => "jlp.furiganaservice.furigana",
  "params" => array(
    "q" => $inputText,
    "grade" => 1
  )
);

// APIリクエストの送信
$options = array(
  'http' => array(
    'header'  => "Content-type: application/json\r\nUser-Agent: Yahoo AppID: " . $apiKey . "\r\n",
    'method'  => 'POST',
    'content' => json_encode($data),
  ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// 結果を返す
if ($result === FALSE) {
  echo json_encode(["error" => "リクエストに失敗しました"]);
} else {
  echo $result;
}
