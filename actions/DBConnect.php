<?
function ConnectDB(){

    try{
        $dsn = 'mysql:dbname=suvey;host=docker-lamp_mysql_1';
        $username = 'root';
        $password = 'password';
        $dbh  = new PDO($dsn,$username,$password);
    }
    catch(PDOException $e){
        echo "データベース接続失敗：管理者にお問い合わせください．";
        exit();
    }
    return $dbh;

}
?>
