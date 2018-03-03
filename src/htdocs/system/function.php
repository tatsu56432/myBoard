<?php


function escape($var)
{
    if (is_array($var)) {
        return array_map('escape', $var);
    } else {
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    }
}

function view($template, $data)
{
    escape($data);
    extract($data);
    ob_start();
    include dirname(__FILE__) . '/view/' . $template;
    $view = ob_get_contents();
    ob_end_clean();
    return $view;
}

function validation($input = null)
{
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
    }else if(mb_strlen($name) >= 20){
        $error['name'] = '名前は20文字以内で入力してください。';
    }

    return $error;
}


function displayTable($result){
    foreach($result as $val){
        echo <<<HTML
    <tr>
        <td>{$val['address_num']}</td>
        <td>{$val['pref_ja']}</td>
        <td>{$val['ward_ja']}</td>
        <td>{$val['address_ja']}</td>
    </tr>
HTML;
    }
}

function putLogData($log){

    $fp=fopen($log,"a");
    foreach ($log as $a){
        fputs($fp,$a."\n");
    }
    fclose($fp);

}


function getLogData ($log) {

    $getFile = fopen($log, 'r');
    if ($getFile){
        if (flock($getFile, LOCK_SH)) {
            //一行ごとに処理を行う
            while (!feof($getFile)) {
                //$str = array();
                $str[] = fgets($getFile);
            }
            flock($getFile, LOCK_UN);
        }else{
            echo 'ファイルの展開に失敗';
        }
    }
    return $str;
}



function test(){

    echo "test";

}