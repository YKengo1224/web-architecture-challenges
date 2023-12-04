<?php



$api_key = '404cffca-7cec-cfc4-eabc-2477644830d2:fx'; // ここにあなたのAPIキーを入力してください

function JaToEn($ch,$text_to_translate){
    $target_lang = 'EN'; // 翻訳先の言語
    $api_key = '404cffca-7cec-cfc4-eabc-2477644830d2:fx';

    // DeepL APIのURL
    $url = 'https://api-free.deepl.com/v2/translate';

    // リクエストパラメータを設定
    $data = [
        'auth_key' => $api_key,
        'text' => $text_to_translate,
        'target_lang' => $target_lang,
    ];

    // cURLセッションを初期化
    $ch = curl_init();

    // cURLオプションを設定
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // リクエストを実行し、レスポンスを取得
    $response = curl_exec($ch);

    // エラーチェック
    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }

    // cURLセッションを閉じる
    curl_close($ch);

    // レスポンスをデコード
    $responseData = json_decode($response, true);

    // 翻訳結果を出力
    if (isset($responseData['translations'][0]['text'])) {
        return $responseData['translations'][0]['text'];
    } else {
        return ("Error: " . $responseData['message']);
    }
}

function ENToJA($ch,$text_to_translate){
    $target_lang = 'JA'; // 翻訳先の言語
    $api_key = '404cffca-7cec-cfc4-eabc-2477644830d2:fx';

    // DeepL APIのURL
    $url = 'https://api-free.deepl.com/v2/translate';

    // リクエストパラメータを設定
    $data = [
        'auth_key' => $api_key,
        'text' => $text_to_translate,
        'target_lang' => $target_lang,
    ];

    // cURLセッションを初期化
    $ch = curl_init();

    // cURLオプションを設定
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    // リクエストを実行し、レスポンスを取得
    $response = curl_exec($ch);

    // エラーチェック
    if(curl_errno($ch)){
        throw new Exception(curl_error($ch));
    }

    // cURLセッションを閉じる
    curl_close($ch);

    // レスポンスをデコード
    $responseData = json_decode($response, true);

    // 翻訳結果を出力
    if (isset($responseData['translations'][0]['text'])) {
        return $responseData['translations'][0]['text'];
    } else {
        return ("Error: " . $responseData['message']);
    }
}
?>
