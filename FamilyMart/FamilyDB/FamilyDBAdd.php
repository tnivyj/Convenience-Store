<?php

/* 确认是否填写Sno和Slocation */
if (filter_has_var(INPUT_POST, 'addFno') && filter_has_var(INPUT_POST, 'addFlocation')) {
    $Fno = filter_input(INPUT_POST, 'addFno');
    $Fname = filter_input(INPUT_POST, 'addFname');
    $Flocation = filter_input(INPUT_POST, 'addFlocation');
    $Fphone = filter_input(INPUT_POST, 'addFphone');
    $db_host = 'localhost';          //資料庫主機
    $db_user = 'root';               //資料庫使用者
    $db_password = '';               //資料庫使用者密碼
    $db_name = 'ConvenientStore';          //資料庫名稱
    /* 建立資料庫的連結 */
    $link = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$link) {  //輸出資料庫連接錯誤
        die("连接失败" . mysqli_connect_error());
    }
    /* 新增資料的 SQL 語法 */
    $sql = "INSERT INTO FamilyMart VALUES ('$Fno', '$Fname', '$Flocation', '$Fphone');";
    //var_dump($sql);
    mysqli_set_charset($link, "utf8");      // 設定連接資料庫及執行SQL的編碼為 utf8
    $result = mysqli_query($link, $sql);    // 執行SQL語法
    if ($result) {
        echo "新增成功。";
    } else {   //輸出SQL語法錯誤
        echo "新增错误: " . mysqli_error($link);
    }
    mysqli_close($link); //關閉資料庫連接
}
?>