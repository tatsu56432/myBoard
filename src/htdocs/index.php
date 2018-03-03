<?php
session_start();

require_once "system/function.php";


$logFile = './system/log.txt';

if(!empty($logFile)){
    $logData = getLogData($logFile);
}else{
    echo "logファイルの取得に失敗しました。";
}

var_dump($logData);

$data = array();
$data = $logData;
$view = view('index.php',$data);
echo $view;


$submit = isset($_POST['submit']) ? $_POST['submit'] : NULL;

if($submit && $_SERVER['REQUEST_METHOD'] === 'POST'){



    $name = isset($_POST['name']) ? $_POST['name'] : NULL;
    $comment = isset($_POST['comment']) ? $_POST['comment'] : NULL;

    $data = escape($_POST);
    $error = validation();

    if(count($error) > 0){
        $data = array();
        $data['error'] = $error;
        $data['name'] = $name;
        $data['comment'] = $comment;

    }else{

    }





}


