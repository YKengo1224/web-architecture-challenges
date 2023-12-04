<?php

// サーバが各国語で挨拶を返すサンプル


// WebSocketServerクラスライブラリのインクルード

include 'WebSocketServer.php';
include 'WebSocketClient.php';
include 'WebSocketEvent.php';
include 'IWebSocketEvent.php';
include 'WebSocketException.php';

include '../actions/DBConnect.php';
include '../actions/SuveyAction.php';
include '../actions/DeepL.php';
include '../actions/GPT3.5.php';
include '../actions/LearningFlow.php';


try {

  // WebSocketServerオブジェクトのインスタンス生成

    //  $ws = new WebSocketServer("192.168.10.7", "8081");
    $ws = new WebSocketServer("172.20.0.3","8081");

  // ログ表示をOFF

    //  $ws->setDisplayLog (false);

  // 識別名の登録

  $ws->registerResource ('flow');


  // メッセージ受信に対するイベントハンドラの登録

  $ws->registerEvent('receivedMessage', 'flow',

      function ($client, $data) use (&$ws) {

        // クライアントから受信したメッセージ表示

        echo "受信: $data\n";

        $data = json_decode($data,true);

        //GPT,Deeplを用いて学習フローを生成
        $data = criate($data);
        print_r( $data);
        $client->sendCommand(json_encode($data),1,false);

      }

  );

  // サーバ起動

  $ws->serverRun(

      function () {

        printf("Running Server!\n");

      }

  );

} catch (WebSocketException $e) {

  echo $e->getMessage() . "\n";

}

?>
