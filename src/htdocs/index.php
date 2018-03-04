<?php
session_start();

require_once "system/function.php";

//if (!empty($_POST)) {
//    //SESSIONに保存したらページを更新
//    $_SESSION = $_POST;
//
//    $_SESSION = array();
//    session_destroy();
//    //現在のURLで更新
//    header("Location: index.php");
//    exit;
//}

$logFile = './system/log.txt';

if(!empty($logFile)){
    $logData = getLogData($logFile);
}else{
    echo "logファイルの取得に失敗しました。";
}


//echo "<pre>";
//print_r($logData) ;
//echo "</pre>";
//var_dump($logData);

$view = view('index_view.php',$logData);
echo $view;


$data = escape($_POST);
$name = isset($_POST['name']) ? $_POST['name'] : NULL;
$comment = isset($_POST['comment']) ? $_POST['comment'] : NULL;
$submit = isset($_SESSION['submit']) ? $_SESSION['submit'] : NULL;

if($submit){




}else{

//  echo "SEND!";
    $error = validation($_POST);
    if(count($error) > 0){
        $data = array();
        $data['error'] = $error;
        $view = view('index_view.php',$data);
        echo $view;
    }else{
        $data = array();
        $data['name'] = $name;
        $data['comment'] = $comment;
        putLogData($logFile,$name,$comment);
        header("Location: index.php");
        exit;
    }
}



