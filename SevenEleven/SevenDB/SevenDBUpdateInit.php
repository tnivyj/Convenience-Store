<?php

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
/* 定義 SQL 查詢語法（選取所有的資料） */
$selStr = "select * from SevenEleven";
/* 實際執行查詢語法 */
$result = mysqli_query($link, $selStr);
/* 檢查是否能正常執行 */
if ($result) {
    /* 檢查是否有查詢到任何資料 */
    if (mysqli_num_rows($result) > 0) {
        /* 將所有的查詢結果轉換成「關聯型」陣列 */
        $queryData = mysqli_fetch_all($result, MYSQLI_ASSOC);
        /* 將「關聯型」陣列的查詢結果，輸出成 json 格式 */
        /* 接著，再藉由 echo 的輸出，傳送至前端 */
        echo json_encode($queryData);
        mysqli_free_result($result); //釋放查詢結果的記憶體
    } else {
        echo "没有资料。";
    }
} else {
    echo "查询错误: " . mysqli_error($link); //輸出SQL語法錯誤
}
mysqli_close($link); //關閉資料庫連接
?>
