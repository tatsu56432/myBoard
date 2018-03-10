<?php

require_once "define.php";

//function db_connect () {
//    $mysqlConnect = mysqli_connect(HOST,DB_USER_NAME,DB_PASS,DB_NAME) or
//    die(mysqli_connect_error());
//    mysqli_set_charset($mysqlConnect,'utf-8');
//    return $mysqlConnect;
//}

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
    $stmt = $pdo -> prepare("INSERT INTO board (id , name, comment , user_agent , date) VALUES (:id , :name, :comment , :user_agent , :date)");
    $stmt->bindValue(':id', $id , PDO::PARAM_INT);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
//  $stmt->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
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

function validation ($input = null) {
    if (!$input) {
        $input = $_POST;
    }

    $name = isset($input['name']) ? $input['name'] : null;
    $comment = isset($input['comment']) ? $input['comment'] : null;
    $name = trim($name);


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


function get_target_col ($data , $target) {
    if(isset($data) && is_array($data)){
        $arrTarget = array();
        foreach ($data as $key1 => $val1){
            foreach ($val1 as $key2 => $val2){
                if($key2 == $target){
                    $arrTarget[] = $val2;
                }
            }
        }
        return $arrTarget;
    }elseif(empty($data)){
        echo "まだコメントはありません";
    }
}

function displayItem ($data , $name_vars = NULL,$comment_vars = NULL ,$date_vars = NULL) {
    if(isset($data) && is_array($data)){
        $i = 0;
        foreach ($data as $key => $val){
            $html = <<<HTML
            <li class="chatItem">
                <div class="chatItem__box">
                    <p class="chatItem--name">name:{$name_vars[$i]}</p>
                    <p class="chatItem--date">date:{$date_vars[$i]}</p>
                    <p class="chatItem--comment">comment:{$comment_vars[$i]}</p>
                </div>
            </li>
HTML;
            $i++;
            echo nl2br($html);
        }

    }elseif(empty($data)){
        echo "まだコメントはありません";
    }

}



