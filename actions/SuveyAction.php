<?php


function INSERTEIs($view){
    $dbh = ConnectDB();

    $email = $view['email'];
    if(strcmp($view['experience'],'Yes')==0){
        $Is = 1;
    }
    else
        $Is = 0;

    $sql = 'INSERT INTO suvey_IsExperience (email,IsExperience) VALUES (:email,:Is)';
    $stmt = $dbh->prepare($sql);

    $stmt->execute(array(':email' => $email,':Is'=>$Is));



    if ($stmt->errorCode() !== '00000') {
        $errorInfo = $stmt->errorInfo();
        echo "エラー: " . $errorInfo[2];
        exit();
    }
}

function SELECTIs($email){
    $dbh = ConnectDB();
    $sql = 'SELECT Isexperience FROM suvey_IsExperience WHERE  email = :email';

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':email' => $email));

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;

}

function UPDATEIs($view){
    $dbh = ConnectDB();

    $email = $view['email'];

    if(strcmp($view['experience'],'Yes')==0)
        $Is = 1;
    else
        $Is = 0;

    $sql = 'UPDATE suvey_IsExperience SET IsExperience = :Is WHERE email = :email';

    $stmt = $dbh->prepare($sql);

    $stmt->execute(array(':Is' => $Is,':email'=>$email));

    if ($stmt->errorCode() !== '00000') {
        $errorInfo = $stmt->errorInfo();
        echo "エラー: " . $errorInfo[2];
        exit();
    }

}


function INSERTExperience($view){

    $email = $view['email'];
    $langs = $view['lang'];
    $years = $view['year'];
    $levels = $view['level'];


    $dbh = ConnectDB();

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

function DELETEExperience($email){
    $dbh = ConnectDB();

    $sql = 'DELETE FROM suvey_Experience WHERE email = :email';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':email' => $email));


    if ($stmt->errorCode() !== '00000') {
        $errorInfo = $stmt->errorInfo();
        echo "エラー: " . $errorInfo[2];
        exit();
    }
}


function SELECTSuvey($email){
    $dbh = ConnectDB();

    $Is = SELECTIs($email);

    $sql = <<<EOM
        SELECT E.language,E.years,E.level FROM suvey_Experience E LEFT OUTER JOIN suvey_IsExperience i ON E.email = i.email  WHERE E.email=:email;
        EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':email'=>$email));
    //$stmt->execute();
    $result = $stmt->fetchall(PDO::FETCH_ASSOC);
    $result[0]['IsExperience'] = $Is['Isexperience'];

    if ($stmt->errorCode() !== '00000') {
        $perrorInfo = $stmt->errorInfo();
        echo "エラー: " . $errorInfo[2];
        exit();
    }


    // foreach($result as $i){
    //     print_r($i);
    //     echo $i['IsExperience'];
    // }
    return $result;
}


function INSERTSuvey($view){
    if(strcmp($view['experience'],"Yes")==0){
        if(empty($view['lang'][0])){
            $error = 1;
        }
        else{
            INSERTEIs($view);
            INSERTExperience($view);
            $error=0;
        }
    }
    else{
        INSERTEIs($view);
        $error=0;
    }

    return $error;
}


function UPDATESuvey($view) {
    if((strcmp($view['experience'],"Yes")==0) && (empty($view['lang'][0]))){
        $error = 1;
    }
    else{
        $pre = SELECTIs($view['email']);

        if($pre['Isexperience'] == 1)
            $Is = 'Yes';
        else
            $Is = 'No';


        if(strcmp($Is,$view['experience'])!=0){
            UPDATEIs($view);
        }

        DELETEExperience($view['email']);
        if($view['experience']=='Yes'){
            INSERTExperience($view);
        }
    }
    return $error;
}

?>
