<?php

/* 确认是否填写Sno和Slocation */
if (filter_has_var(INPUT_POST, 'addSno') && filter_has_var(INPUT_POST, 'addSlocation')) {
    $Sno = filter_input(INPUT_POST, 'addSno');
    $Sname = filter_input(INPUT_POST, 'addSname');
    $Slocation = filter_input(INPUT_POST, 'addSlocation');
    $Sphone = filter_input(INPUT_POST, 'addSphone');
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
    $sql = "INSERT INTO SevenEleven VALUES ('$Sno', '$Sname', '$Slocation', '$Sphone');";
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