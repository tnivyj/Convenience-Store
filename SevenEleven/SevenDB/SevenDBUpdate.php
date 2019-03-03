<?php

/* 判斷使用者是否有輸入 engWord 的資料 */
if (filter_has_var(INPUT_POST, 'Sno') && filter_has_var(INPUT_POST, 'Slocation')){
    /* 取得使用者所輸入的資料 */
    $Sno = filter_input(INPUT_POST, "Sno");
    $Sname = filter_input(INPUT_POST, "Sname");
    $Slocation = filter_input(INPUT_POST, "Slocation");
    $Sphone = filter_input(INPUT_POST, "Sphone");

    /* 設定網頁內容顯示時的編碼，以避免中文亂碼 */
    header("Content-Type:text/html; charset=utf-8");
    $db_host = 'localhost';     //資料庫主機
    $db_user = 'root';          //資料庫使用者
    $db_password = '';          //資料庫使用者密碼
    $db_name = 'ConvenientStore';      //資料庫名稱
    /* 資料庫連接 */
    $link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    /* 以 utf8 編碼，避免中文亂碼 */
    mysqli_set_charset($link, "utf8");
    /* 檢查資料庫連接是否失敗 */
    if (!$link) {
        die("连接失败" . mysqli_connect_error()); //輸出資料庫連接錯誤
    }
    /* 定義 SQL 查詢語法 */
    $selStr = "select * from SevenEleven where Sno = '$Sno'";
    $selResult = mysqli_query($link, $selStr);
    /* 實際執行查詢語法，且檢查是否能正常執行 */
    /* 此處同時判斷是否 database 中確實存在該筆資料，才能進行後續修改動作！ */
    if (mysqli_fetch_row($selResult) > 0) {
        /* 定義 SQL 的修改（Update）語法 */
        $updateStr = "Update SevenEleven ";
        $updateStr .= "Set Sname='$Sname', Slocation='$Slocation', Sphone='$Sphone' ";
        $updateStr .= "Where Sno ='$Sno'";
        /* 實際執行修改的SQL語法 */
        $updateResult = mysqli_query($link, $updateStr);
        /* 檢查是否能正常執行 */
        if ($updateResult) {
            echo "修改成功!";
        } else {
            echo "失败!" . mysqli_error($link); //輸出SQL語法錯誤
        }
    } else {
        echo "找不到资料！";
    }
    mysqli_close($link); //關閉資料庫連接
}
?>
