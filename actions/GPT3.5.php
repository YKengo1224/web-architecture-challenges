<?php

function GPT($text){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);


    $apikey = "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";
    $url = "https://api.openai.com/v1/chat/completions";

    // リクエストヘッダー
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apikey
    );

    // リクエストボディ
    $data = array(
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ["role" => "system", "content" => "日本語で回答して"],
            ['role' => 'user', 'content' => $text],
        ],
        'max_tokens' => 1000,
    );

    // cURLを使用してAPIにリクエストを送信
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);


    if(curl_errno($ch)){
        return ('Curl error: ' . curl_error($ch));
    }
    curl_close($ch);



    // 結果をデコード
    $result = json_decode($response, true);


    $result_message = $result["choices"][0]["message"]["content"];

    // 結果を出力
    return $result_message;
}
?>
