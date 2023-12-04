<?php

//api key = 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


require_once "actions/DBConnect.php";
require_once "actions/UserTableAction.php";
require_once "actions/SuveyAction.php";
require_once "actions/DeepL.php";
require_once "actions/GPT3.5.php";
require_once "actions/LearningFlow.php";

session_start();

$view = array();
$event='login';
if(isset($_GET['event']))$event=$_GET['event'];


switch($event){
    case 'login':
        require './views/login.phtml';
        break;
    case 'receiveLogin':
        $view = CheckLogin();
        if($view['isError']){
            require './views/login.phtml';
        }
        else{
            $_SESSION['email'] = $view['email'];
            if(isset($view['first'])){
                require './views/first_login.phtml';
            }
            else{
                require './views/home.html';
            }
        }
        break;
    case 'MemberShip':
        require './views/MemberShip/MemberShip.phtml';
        break;
    case 'ReceiveRegstration':
        $view = isMembershipAvailable();
        if($view['isError']){
            require './views/MemberShip/MemberShip.phtml';
        }
        else{
            require './views/MemberShip/MemberShip_Success.phtml';
        }
        break;

    case 'StartSuvey':
        require './views/suvey/suvey.phtml';
        break;
    case 'ReceiveSuvey':
        $view = $_POST;
        $view['email'] = $_SESSION['email'];
        $error = INSERTSuvey($view);
        if($error == 1){
            require  './views/suvey/suvey.phtml';
        }
        else{
            require './views/home.html';
        }
        break;
    case 'EditSuvey':
        $view = SELECTSuvey($_SESSION['email']);
        require './views/suvey/EditSurvey.phtml';
        break;
    case 'EditSuveyComp':
        $view = $_POST;
        $view['email'] = $_SESSION['email'];
        $error = UPDATESuvey($view);
        if($error == 1){
            $view = SELECTSuvey($_SESSION['email']);
            require './views/suvey/EditSurvey.phtml';
        }
        else{
            require './views/home.html';
        }
        break;
    case 'logout':
        $_SESSION = array();
        session_destroy();
        require './views/login.phtml';
        break;
    default:
        die("evnet error:ホームページ管理者にお問い合わせください.");
}

?>
