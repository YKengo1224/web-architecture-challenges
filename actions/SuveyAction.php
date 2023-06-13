<?php


// function SELECTuser($view){
//     $dbh = ConnectDB();
//     $sql = 'SELECT * FROM User WHERE email = :email';
//     $stmt = $dbh->prepare($sql);

//     $stmt->bindValue(':email',$view['email'],PDO::PARAM_STR);
//     $stmt->execute();

//     $result = $stmt->fetch(PDO::FETCH_ASSOC);

//     return $result;
// }



function INSERTExperience($view){
    $dbh = ConnectDB();

    $email = $view['email'];
    $langs = $view['lang'];
    $years = $view['year'];
    $levels = $view['level'];

    for ($i = 0; $i < count($langs); $i++) {
        $lang = $langs[$i];
        $year = $years[$i];
        $level = $levels[$i];
        $sql = 'INSERT INTO suvey_Experience (email,language,years,level) VALUES (:email,:lang,:year,:level)';
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array(':email' => $email,':lang'=>$lang,':year'=>$year,':level'=>$level));

    }

    if ($stmt->errorCode() !== '00000') {
        $errorInfo = $stmt->errorInfo();
        echo "エラー: " . $errorInfo[2];
        exit();
    }
}


// function UpdateNumAccess($result,$count){
//     $dbh = ConnectDB();

//     $sql = 'UPDATE User SET num_access = :num_access WHERE  email = :email';
//     $stmt = $dbh->prepare($sql);
//     $stmt->bindValue(':email',$result['email'],PDO::PARAM_STR);
//     $stmt->bindValue(':num_access',$count,PDO::PARAM_INT);
//     $stmt->execute();

// }


// function CheckLogin(){
//     $return = [];
//     $email = filter_input(INPUT_POST,'email');
//     $password = filter_input(INPUT_POST,'password');
//     $view['email'] = $email;
//     $view['password'] = $email;

//     if(empty($email)){
//         $return['isError'] = 1;
//         $return['code'] = 'NoEnterEmail';
//         return $return;
//     }
//     if(empty($password)){
//         $return['isError'] = 1;
//         $return['code'] = 'NoEnterPassword';
//         return $return;
//     }

//     $result = SELECTuser($view);
//     if(!$result){
//         $return['isError'] = 1;
//         $return['code'] = 'NotMatchEmail';
//         return $return;
//     }

//     else{
//         if(password_verify($password,$result['password'])){
//             $access = $result['num_access'] + 1;
//             if($access == 1) $return['first'] = 1;

//             UpdateNumAccess($result,$access);
//             $return['isError'] = 0;
//             $return['email'] = $result['email'];
//             return $return;
//         }
//         else{
//             $return['isError'] = 1;
//             $return['code'] = 'NotMatchPassword';
//             return $return;
//         }
//     }
// }



// function isMembershipAvailable(){
//     $return = [];
//     $email = filter_input(INPUT_POST,'email');
//     $password = filter_input(INPUT_POST,'password');
//     $view['email'] = $email;
//     $view['password'] = $email;

//     if(empty($email)){
//         $return['isError'] = 1;
//         $return['code'] = 'NoEnterEmail';
//         return $return;
//     }
//     if(empty($password)){
//         $return['isError'] = 1;
//         $return['code'] = 'NoEnterPassword';
//         return $return;
//     }

//     if(strcmp($_POST['password'],$_POST['password2']) != 0){
//         $return['isError'] = 1;
//         $return['code'] = 'DifferentPassword';
//         return $return;
//     }


//     $result = SELECTuser($view);
//     if(!$result){
//         INSERTuser($view);
//         $return['isError'] = 0;
//         return $return;
//     }
//     else{
//         $return['isError'] = 1;
//         $return['code'] = 'AlreadyRegstrationEmail';
//         return $return;
//     }
//}

?>
