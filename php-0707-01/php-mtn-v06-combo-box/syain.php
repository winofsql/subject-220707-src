<?php
require_once("setting.php");

header( "Content-Type: text/html; charset=utf-8" );

// データベースに接続する
require_once("db_connect.php");
require_once("model.php");

$query = <<<QUERY
select * from コード名称マスタ where 区分 = 2
QUERY;

    $result = $mysqli->query( $query );
    $rows = $result->fetch_all( MYSQLI_ASSOC );
$json = json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );

// データ表示処理
if ( $_POST["btn"] == "確認" ) {

    $row = check($mysqli);
    if ( $row ) {
        $_POST["sname"] = $row["氏名"];
        $_POST["fname"] = $row["フリガナ"];
        $_POST["syozoku"] = $row["所属"];
        $_POST["seibetsu"] = $row["性別"];
        $_POST["kyuyo"] = $row["給与"];
        $_POST["teate"] = $row["手当"];
        $_POST["kanri"] = $row["管理者"];
        $_POST["birth"] = $row["生年月日"];
    }
    else {
        $_POST["sname"] = "";
        $_POST["fname"] = "";
        $_POST["syozoku"] = "";
        $_POST["seibetsu"] = "";
        $_POST["kyuyo"] = "";
        $_POST["teate"] = "";
        $_POST["kanri"] = "";
        $_POST["birth"] = "";

        $_POST["message"] = "新規登録です";
    }

    // $gno が 1 でエラーが無い場合( ここではエラーチェクをしていない )
    // プロテクトコントロール
    $readonly_1 = $disabled_type_text;
    $readonly_2 = "";
    $disabled_1 = $disabled_type;
    $disabled_2 = "";

    // 所属コンボボックス
    $syozoku_option = "";
    $query = <<<QUERY
select * from コード名称マスタ where 区分 = 2
QUERY;

    $result = $mysqli->query( $query );
    $rows = $result->fetch_all( MYSQLI_ASSOC );
    // while ( $row = $result->fetch_array( MYSQLI_BOTH ) ) {
    //     if ( $_POST["syozoku"] == $row["コード"] ) {
    //         $syozoku_option .= 
    //             "<option selected value='{$row["コード"]}'>{$row["名称"]}</option>";
    //     }
    //     else {
    //         $syozoku_option .= 
    //             "<option value='{$row[0]}'>{$row["名称"]}</option>";
    //     }
    // }

    // 次の画面の会話番号( 確認がクリックされた )
    $gno = 2;

}

// データ更新処理
if ( $_POST["btn"] == "更新" ) {

    $row = check($mysqli);
    // 社員コードが存在する
    if ( $row ) {
        update( $mysqli );
    }
    // 社員コードが存在しない
    else{
        insert( $mysqli );
    }

    $_POST["scode"] = "";
    $_POST["sname"] = "";
    $_POST["fname"] = "";
    $_POST["syozoku"] = "";
    $_POST["seibetsu"] = "";
    $_POST["kyuyo"] = "";
    $_POST["teate"] = "";
    $_POST["kanri"] = "";
    $_POST["birth"] = "";

    // $gno が 2 でエラーが無い場合( ここではエラーチェクをしていない )
    // プロテクトコントロール
    $readonly_1 = "";
    $readonly_2 = $disabled_type_text;
    $disabled_1 = "";
    $disabled_2 = $disabled_type;
    
    // 次の画面の会話番号( 更新がクリックされた )
    $gno = 1;

}

require_once("syain-view.php");

// debug_print();

// print_r(json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));