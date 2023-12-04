<?php
function criate($data){
    $email = $data['email'];
    $language = $data['lang'];
    $app = $data['app'];

    $db = SELECTSuvey($email);

    $DeepLCh = curl_init();

    $text = 'Languages used | Years of use | Level of language use';
    if($db[0]['IsExperience']=='1'){
        foreach($db as $index => $data){
            $lang = $data['language'];  //もとから英語のため，翻訳なし
            $year = JaToEn($DeepLCh,$data['years']);
            $level = JaToEn($DeepLCh,$data['level']);
            $text = "{$text} \n {$lang} | {$year} | {$level}";
        }
        $T = "このようなプログラミング経験を持つ人がいます．この人のスキルを予想し，この人が，";
        $T = JaToEn($DeepLCh,$T);
        $text = "{$text}\n {$T}";

    }

    else{
        $text ='プログラミング初心者の人がいます．この人のスキルを予想し，その人が，';
        $DeepLCh = curl_init();
        $text = JaToEn($DeepLCh,$text);
    }


    $T = "{$language}を用いて{$app}を作成する際のおすすめの学習フローを10工程に分け，各ステップを箇条書きしてください.簡潔にお願いします.ただし，この人がすでに持っていると予想できるスキルの学習は省いてください．また，スクレイピングしやすいような形式で返答してください．各行のはじめは必ず'Step'をつけてください.";
    //英語に翻訳してGPTに投げる->日本語に翻訳
    $T = JaToEn($DeepLCh,$T);
    $text = "{$text} {$T}";
    $result = GPT($text);
    //    $result = EnToJa($DeepLCh,$result);

    echo $text;
    $result = explode("Step",$result);

    for($i=1;$i<=10;$i++){
        $result[$i] = EnToJa($DeepLCh,$result[$i]);
    }

    // print_r($result);

    return $result;

}

?>
