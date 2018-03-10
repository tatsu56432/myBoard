<?php

require_once "define.php";

function db_connect () {
    $mysqlConnect = mysqli_connect(HOST,DB_USER_NAME,DB_PASS,DB_NAME) or
    die(mysqli_connect_error());
    mysqli_set_charset($mysqlConnect,'utf-8');
    return $mysqlConnect;
}

function db_connect_pdo () {

    try {
        $pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DB_NAME . ';charset=utf8',DB_USER_NAME,DB_PASS,
            array(PDO::ATTR_EMULATE_PREPARES => false));

        return $pdo;

    } catch (PDOException $e) {
        exit('データベース接続失敗。'.$e->getMessage());
    }

}


function get_db_data ($pdo) {
    $data = array();
    $stmt = $pdo -> query("SET NAMES utf8;");
    $stmt = $pdo->query("SELECT * FROM board");
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        $data[] = array(
            'name' => $row["name"],
            'comment' => $row["comment"],
            'date' => $row["date"],
        );
    }
    return $data;
}

function insert_db ($pdo , $insertData) {
    $id = NULL;
    $name =$insertData['name'];
    $comment = $insertData['comment'];
    $date = $insertData['date'];
    //$ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    $stmt = $pdo -> query("SET NAMES utf8;");
    $stmt = $pdo -> prepare("INSERT INTO board (id , name, comment , ip_address , date) VALUES (:id , :name, :comment , :user_agent , :date)");
    $stmt->bindValue(':id', $id , PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
//    $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
    $stmt->bindParam(':user_agent', $user_agent, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);

    $stmt->execute();
}



function escape ($var) {
    if (is_array($var)) {
        return array_map('escape', $var);
    } else {
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    }
}

function view ($template, $data) {
    escape($data);
    extract($data);
    ob_start();
    include dirname(__FILE__) . '/view/' . $template;
    $view = ob_get_contents();
    ob_end_clean();
    return $view;
}

function validation ($input = null) {
    if (!$input) {
        $input = $_POST;
    }

    $name = isset($input['name']) ? $input['name'] : null;
    $comment = isset($input['comment']) ? $input['comment'] : null;

    //データを整形
    $name = trim($name);

    //エラー配列の初期化、
    $error = array();

    if(empty($name)){
        $error['name'] = '名前が入力されてません';
    }else if(mb_strlen($name) >= 20){
        $error['name'] = '名前は20文字以内で入力してください。';
    }

    if(empty($comment)) {
        $error['comment'] = 'コメントが入力されていません';
    }else if(mb_strlen($comment) >= 100){
        $error['comment'] = 'コメントは100文字以内で入力してください。';
    }

    return $error;
}


function displayItem ($data) {
    if(isset($data) && is_array($data)){
        foreach ($data as $val){
            $html = <<<HTML
            <li class="chatItem">
                <div class="chatItem__box">
                    <p class="chatItem--name">name:{$data['name']}</p>
                    <p class="chatItem--date">date:{$data['date']}</p>
                    <p class="chatItem--comment">comment:{$data['comment']}</p>
                </div>
            </li>
HTML;
            echo nl2br($html);
        }
    }elseif(empty($data)){
        echo "まだコメントはありません";
    }

}

function putLogData ($file  , $name , $comment) {
    $date =  date('Y年m月d日 H時i分s秒');
    $comment_data = $comment;
    $comment_data = nl2br($comment_data);
    $name_data = $name;
    $logData = $name_data . ',' . $date . "," .$comment_data . "\n";
    if (($fp = fopen($file, 'a')) !== FALSE) {
        if (fwrite($fp, $logData) === FALSE) {
            print 'ファイル書き込み失敗:  ' . $file;
        }
        fclose($fp);
    }
}


function getLogData ($log) {

    $getFile = fopen($log, 'r');
    if ($getFile){
        if (flock($getFile, LOCK_SH)) {
            //一行ごとに処理を行う
            while ($line = fgets($getFile)) {
                $lineArray[] = explode(",",$line);
            }
            flock($getFile, LOCK_UN);
        }else{
            echo 'ファイルの展開に失敗';
        }
    }
    return array($lineArray);
}



